# 📋 QA Sprint 3 — Resumen Ejecutivo de Cambios y Diagnóstico

**Proyecto:** SansiFolios — Gestor de Portafolios  
**Sprint:** 3 (Final)  
**Fecha:** 2026-05-10  
**Equipo:** QA  
**Autor:** QA Lead

---

## 1. Modificaciones Realizadas

### 1.1 Corrección de Conflictos

#### ✅ Merge Conflict — `resources/views/menu.blade.php`
- **Ubicación:** Líneas 521–525
- **Problema:** Marcadores de merge (`<<<<<<<`, `=======`, `>>>>>>>`) se renderizaban como texto visible en la interfaz del sidebar.
- **Causa:** Conflicto no resuelto entre la rama `HEAD` (texto hardcodeado `Portafolios`) y el commit `3d7d173` (versión internacionalizada `{{ __('app.menu.portafolios') }}`).
- **Resolución:** Se mantuvo la versión internacionalizada `{{ __('app.menu.portafolios') }}` para compatibilidad con HU-16 (Multi-idioma).

```diff
  <button id="btn-portafolios" class="sb-item" onclick="showView('portafolios')">
      <svg>...</svg>
-<<<<<<< HEAD
-                    <span>Portafolios</span>
-=======
-                    <span>{{ __('app.menu.portafolios') }}</span>
->>>>>>> 3d7d17730f5d487b225a3e5836a0bcfb9a318195
+                    <span>{{ __('app.menu.portafolios') }}</span>
  </button>
```

#### ✅ Error de Sintaxis — `tests/e2e/2do_Sprint/HU_09.spec.js`
- **Ubicación:** Línea 265
- **Problema:** Assertion rota `await expect(notificationBell).toBe   });` — sintaxis incompleta que impide compilación de toda la suite HU-09.
- **Resolución:** Se corrigió a `.toBeVisible()` con el selector `.tb-bell` que existe en el DOM actual.

```diff
- const notificationBell = page.locator('.topbar').locator('button, i').filter({ has: page.locator('.fa-bell, .icon-bell') }).first();
- await expect(notificationBell).toBe   });
+ const notificationBell = page.locator('.tb-bell');
+ await expect(notificationBell).toBeVisible();
+     });
```

---

### 1.2 Archivos de Tests Automatizados Creados

Se crearon **6 archivos** de pruebas E2E con Playwright en `tests/e2e/3er_Sprint/`:

| Archivo | HU | Tests | Cobertura |
|---|---|---|---|
| `HU_11.spec.js` | HU-11 | 13 | Admin Dashboard: métricas, tabla usuarios, actividad reciente, calendario, sidebar, toggles, seguridad, responsive |
| `HU_12.spec.js` | HU-12 | 8 | Reportes: selector plantillas, mapeo de datos, exportar PDF, seguridad, aislamiento, responsive |
| `HU_13.spec.js` | HU-13 | 10 | Portafolios CRUD: crear, validación campos, URL, actualizar, eliminar, seguridad aislamiento, límites |
| `HU_15.spec.js` | HU-15 | 10 | Notificaciones: envío masivo, individual, validación, recepción, marcar leída, seguridad, CRUD admin |
| `HU_16.spec.js` | HU-16 | 10 | Multi-idioma: ES/EN/FR, persistencia, idioma no permitido, path traversal, loop, sesión, default |
| `REGRESION.spec.js` | S1+S2 | 6 | Regresión: login, perfil, dashboard, logout, protección de rutas |

### 1.3 Estadísticas de Cobertura

| Métrica | Valor |
|---|---|
| **Total Test Cases diseñados** | 62 |
| **Tests Automatizados (Playwright)** | 57 |
| **Tests Solo Manuales** | 5 |
| **Porcentaje Automatizado** | **91.9%** ✅ (criterio mínimo: 70%) |

#### Tests que permanecen solo MANUAL (5):

| TC | Descripción | Razón |
|---|---|---|
| TC-88 | Toggle estado (persistencia BD) | BUG: no hay endpoint backend, se necesita verificar manualmente |
| TC-89 | Toggle rol admin | BUG: solo cambia DOM, no persiste |
| TC-105 | CSS print emulation | Requiere DevTools → Rendering → Emulate CSS media |
| TC-113/114/115 | Upload archivos reales | Archivos físicos (PDF, .exe, >10MB) complejos en E2E |
| TC-145 | Trayectoria CRUD | Habilidades y experiencia — verificación visual manual |

---

## 2. Diagnóstico de Base de Datos

### 2.1 Información General

| Parámetro | Valor |
|---|---|
| **Driver** | PostgreSQL (`pgsql`) |
| **Database** | `postgres` |
| **Migraciones** | 17/17 ejecutadas ✅ |
| **Estado** | Todas las migraciones ran exitosamente |

### 2.2 Tablas Existentes (16)

| Tabla | Registros | FK hacia |
|---|---|---|
| `usuarios` | 11 | — (tabla raíz) |
| `portafolios` | 6 | `usuarios.id` |
| `portafolio_archivos` | 1 | `portafolios.id` |
| `notificaciones` | 1 | `usuarios.id` (×2: creado_por, destinatario_id) |
| `actividades_log` | 377 | `usuarios.id` |
| `habilidades` | — | `usuarios.id` |
| `experiencias` | — | `usuarios.id` |
| `formaciones` | — | `usuarios.id` |
| `certificaciones` | — | `usuarios.id` |
| `redes_perfil` | — | `usuarios.id` |
| `sesiones_usuario` | — | `usuarios.id` |
| `tokens_recuperacion` | — | `usuarios.id` |
| `roles` | — | — |
| `usuario_roles` | — | `usuarios.id`, `roles.id` |
| `busquedas` | — | — |
| `migrations` | 17 | — (sistema Laravel) |

### 2.3 Estructura de Tabla `usuarios`

| Columna | Tipo | Nullable | Default |
|---|---|---|---|
| `id` | integer | NO | autoincrement |
| `nombre` | varchar | NO | — |
| `email` | varchar | NO | — (unique) |
| `contrasena` | varchar | NO | — |
| `email_verificado` | boolean | YES | false |
| `created_at` | timestamp | YES | CURRENT_TIMESTAMP |
| `updated_at` | timestamp | YES | CURRENT_TIMESTAMP |
| `google_id` | varchar | YES | — |
| `apellido` | varchar | YES | — |
| `profesion` | varchar(150) | YES | — |
| `biografia` | text | YES | — |
| `foto_perfil` | varchar | YES | — |
| `activo` | boolean | NO | true |
| `es_admin` | boolean | NO | false |
| `motivo_desactivacion` | varchar | YES | — |

### 2.4 Estructura de Tabla `portafolios`

| Columna | Tipo | Nullable |
|---|---|---|
| `id` | bigint | NO |
| `nombre` | varchar | NO |
| `descripcion` | text | YES |
| `usuario_id` | integer | NO |
| `created_at` | timestamp | YES |
| `updated_at` | timestamp | YES |
| `estado` | varchar | NO |
| `repositorio_url` | varchar | YES |

### 2.5 Estructura de Tabla `notificaciones`

| Columna | Tipo | Nullable |
|---|---|---|
| `id` | bigint | NO |
| `titulo` | varchar | NO |
| `mensaje` | text | NO |
| `tipo_envio` | varchar | NO |
| `destinatario_id` | bigint | YES |
| `creado_por` | bigint | NO |
| `leida` | boolean | NO |
| `created_at` | timestamp | YES |
| `updated_at` | timestamp | YES |

### 2.6 Estructura de Tabla `actividades_log`

| Columna | Tipo | Nullable |
|---|---|---|
| `id` | integer | NO |
| `usuario_id` | integer | YES |
| `accion` | varchar | NO |
| `detalles` | jsonb | YES |
| `ip_address` | inet | YES |
| `user_agent` | text | YES |
| `created_at` | timestamp | YES |

---

## 3. Problemas de Base de Datos Detectados

### ⚠️ Problema 1: `portafolios.descripcion` — Inconsistencia nullable vs required

| Aspecto | Detalle |
|---|---|
| **Severidad** | 🟡 Media |
| **Ubicación** | Migración original + `PortafolioController.php` |
| **Descripción** | La columna `descripcion` es `nullable=YES` en la BD, pero el controller valida con `'descripcion' => 'required|string'`. Si existen registros antiguos con `NULL`, podrían causar errores al renderizar. |
| **Recomendación** | Crear migración para cambiar a `NOT NULL` con default vacío, o ajustar la validación. |

### ⚠️ Problema 2: `actividades_log` — Falta columna `updated_at`

| Aspecto | Detalle |
|---|---|
| **Severidad** | 🟡 Media |
| **Ubicación** | Tabla `actividades_log` |
| **Descripción** | La BD solo tiene `created_at` pero no `updated_at`. La migración usa `$table->timestamps()` (que crea ambas), pero la tabla pre-existente solo tenía `created_at`. Si un modelo Eloquent intenta escribir `updated_at`, lanzará error `column "updated_at" does not exist`. |
| **Recomendación** | En el modelo, agregar `public $timestamps = false;` o `const UPDATED_AT = null;`, o crear migración para añadir la columna faltante. |

### ⚠️ Problema 3: `notificaciones.tipo_envio` — Sin constraint ENUM en BD

| Aspecto | Detalle |
|---|---|
| **Severidad** | 🟡 Media |
| **Ubicación** | Tabla `notificaciones`, columna `tipo_envio` |
| **Descripción** | La migración declara `$table->enum('tipo_envio', ['individual', 'todos', 'rol'])`, pero PostgreSQL almacena los enums de Laravel como `varchar` simple. No hay CHECK constraint en la BD. Un INSERT directo (sin pasar por Laravel) podría meter valores inválidos. |
| **Recomendación** | La validación backend (`Rule::in`) es suficiente mientras no haya acceso directo a la BD. Opcional: agregar CHECK constraint. |

### 🟢 Problema 4: Inconsistencia de tipos `integer` vs `bigint`

| Aspecto | Detalle |
|---|---|
| **Severidad** | 🟢 Baja |
| **Ubicación** | `portafolios.usuario_id` (integer) vs `portafolio_archivos.id` (bigint) |
| **Descripción** | Las tablas del Sprint 1 (`usuarios`, `portafolios`) usan `integer` para IDs, pero las del Sprint 3 (`notificaciones`, `portafolio_archivos`) usan `bigint`. PostgreSQL maneja el cast automáticamente, pero es una inconsistencia de diseño. |
| **Recomendación** | No es bloqueante. Estandarizar a `bigint` en futuras migraciones. |

### 🟢 Problema 5: `redes_perfil.usuario_id` — FK en BD pero no en migración

| Aspecto | Detalle |
|---|---|
| **Severidad** | 🟢 Informativa |
| **Ubicación** | Tabla `redes_perfil` |
| **Descripción** | La migración solo declara `$table->unsignedBigInteger('usuario_id')` sin `->constrained()`, pero la BD sí tiene FK hacia `usuarios.id`. Fue probablemente añadida manualmente o por otra migración no rastreada. |
| **Recomendación** | No es un problema, solo documentar. |

---

## 4. Bugs Conocidos para el Equipo de Desarrollo

| # | Bug | Severidad | Archivo | Línea |
|---|---|---|---|---|
| BUG-01 | Métrica "Documentos Subidos" hardcodeada en "4,302" | 🟡 Media | `admin.blade.php` | ~380 |
| BUG-02 | Toggle Estado/Rol solo cambia DOM, no persiste en BD | 🔴 Alta | `admin.blade.php` | JS inline |
| BUG-03 | 2 vistas de reportes inconsistentes (1 vs 6 plantillas) | 🟡 Media | `reportes.blade.php` vs `menu.blade.php` | — |
| BUG-04 | Vista admin sin soporte multi-idioma (textos hardcodeados en español) | 🟢 Baja | `admin.blade.php` | Global |

---

## 5. Credenciales de Test

> **⚠️ Importante:** Los tests automatizados usan las siguientes credenciales. Si son diferentes, actualizar los helpers `loginAdmin()` y `loginUsuario()` en los archivos `.spec.js`.

| Rol | Email | Contraseña |
|---|---|---|
| **Admin** | `admin@umss.edu.bo` | `admin123` |
| **Usuario** | `serpientinon@gmail.com` | `12tres45` |

---

## 6. Comandos para Ejecutar Tests

```bash
# Ejecutar todos los tests del Sprint 3
npx playwright test tests/e2e/3er_Sprint/ --headed

# Ejecutar solo una HU
npx playwright test tests/e2e/3er_Sprint/HU_11.spec.js --headed

# Ejecutar en modo UI (interactivo)
npx playwright test tests/e2e/3er_Sprint/ --ui

# Generar reporte HTML
npx playwright test tests/e2e/3er_Sprint/ --reporter=html
```

---

*Documento generado automáticamente — Sprint 3 QA, SansiFolios 2026*
