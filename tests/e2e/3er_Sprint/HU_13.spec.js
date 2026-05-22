import { test, expect } from '@playwright/test';

// ═══════════════════════════════════════════════════════════════════
// HU-13: Creación de Portafolios (Evidencias) — CRUD
// Tipo Ejecución: AUTOMATED | Sprint: 3
// ═══════════════════════════════════════════════════════════════════

import { BASE, loginUsuario, loginAdmin, logoutCleanup } from '../helpers.js';

async function loginYMenu(page) {
    await loginUsuario(page);
}

test.describe('HU-13: Creación de Portafolios (Evidencias)', () => {

    // ═══════════════════════════════════════════════════════════
    // TC-109: Crear portafolio con datos válidos
    // Tipo Prueba: FUNCIONAL
    // ═══════════════════════════════════════════════════════════
    test('TC-109: Crear portafolio — datos válidos (API)', async ({ request, page }) => {
        await loginYMenu(page);

        // Obtener cookies de sesión
        const cookies = await page.context().cookies();
        const csrfToken = await page.locator('meta[name="csrf-token"]').getAttribute('content');

        // POST a /mis-portafolios
        const response = await page.evaluate(async (token) => {
            const formData = new FormData();
            formData.append('nombre', 'Test Automatizado ' + Date.now());
            formData.append('descripcion', 'Portafolio creado por prueba E2E automatizada');
            formData.append('estado', 'borrador');

            const res = await fetch('/mis-portafolios', {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': token },
                body: formData
            });
            return { status: res.status, data: await res.json() };
        }, csrfToken);

        expect(response.status).toBe(200);
        expect(response.data.ok).toBe(true);
        expect(response.data.portafolio).toBeTruthy();
        expect(response.data.portafolio.nombre).toContain('Test Automatizado');
    });

    // ═══════════════════════════════════════════════════════════
    // TC-110: Crear portafolio sin nombre (validación)
    // Tipo Prueba: FUNCIONAL
    // ═══════════════════════════════════════════════════════════
    test('TC-110: Crear portafolio — nombre vacío rechazado', async ({ page }) => {
        await loginYMenu(page);
        const csrfToken = await page.locator('meta[name="csrf-token"]').getAttribute('content');

        const response = await page.evaluate(async (token) => {
            const formData = new FormData();
            formData.append('nombre', '');
            formData.append('descripcion', 'Descripción de prueba');
            formData.append('estado', 'borrador');

            const res = await fetch('/mis-portafolios', {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': token },
                body: formData
            });
            return { status: res.status };
        }, csrfToken);

        expect(response.status).toBe(422);
    });

    // ═══════════════════════════════════════════════════════════
    // TC-111: Crear con descripción vacía
    // Tipo Prueba: FUNCIONAL
    // ═══════════════════════════════════════════════════════════
    test('TC-111: Crear portafolio — descripción vacía rechazada', async ({ page }) => {
        await loginYMenu(page);
        const csrfToken = await page.locator('meta[name="csrf-token"]').getAttribute('content');

        const response = await page.evaluate(async (token) => {
            const formData = new FormData();
            formData.append('nombre', 'Test Sin Descripción');
            formData.append('descripcion', '');
            formData.append('estado', 'borrador');

            const res = await fetch('/mis-portafolios', {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': token },
                body: formData
            });
            return { status: res.status };
        }, csrfToken);

        expect(response.status).toBe(422);
    });

    // ═══════════════════════════════════════════════════════════
    // TC-112: URL repositorio inválida
    // Tipo Prueba: FUNCIONAL
    // ═══════════════════════════════════════════════════════════
    test('TC-112: Crear portafolio — URL inválida rechazada', async ({ page }) => {
        await loginYMenu(page);
        const csrfToken = await page.locator('meta[name="csrf-token"]').getAttribute('content');

        const response = await page.evaluate(async (token) => {
            const formData = new FormData();
            formData.append('nombre', 'Test URL Inválida');
            formData.append('descripcion', 'Prueba de URL');
            formData.append('repositorio_url', 'no-es-una-url');
            formData.append('estado', 'borrador');

            const res = await fetch('/mis-portafolios', {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': token },
                body: formData
            });
            return { status: res.status };
        }, csrfToken);

        expect(response.status).toBe(422);
    });

    // ═══════════════════════════════════════════════════════════
    // TC-116: Actualizar portafolio existente
    // Tipo Prueba: FUNCIONAL
    // ═══════════════════════════════════════════════════════════
    test('TC-116: Actualizar portafolio existente', async ({ page }) => {
        await loginYMenu(page);
        const csrfToken = await page.locator('meta[name="csrf-token"]').getAttribute('content');

        // 1. Obtener portafolios del usuario
        const portafolios = await page.evaluate(async () => {
            const res = await fetch('/mis-portafolios');
            return await res.json();
        });

        if (portafolios.length === 0) {
            test.skip();
            return;
        }

        const id = portafolios[0].id;

        // 2. Actualizar
        const response = await page.evaluate(async ({ token, portId }) => {
            const formData = new FormData();
            formData.append('nombre', 'Portafolio Actualizado E2E');
            formData.append('descripcion', 'Descripción actualizada');
            formData.append('estado', 'publicado');

            const res = await fetch(`/mis-portafolios/${portId}`, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': token },
                body: formData
            });
            return { status: res.status, data: await res.json() };
        }, { token: csrfToken, portId: id });

        expect(response.status).toBe(200);
        expect(response.data.ok).toBe(true);
    });

    // ═══════════════════════════════════════════════════════════
    // TC-118: Aislamiento — No editar portafolio ajeno
    // Tipo Prueba: SEGURIDAD
    // ═══════════════════════════════════════════════════════════
    test('TC-118: Seguridad — No editar portafolio ajeno', async ({ page }) => {
        await loginYMenu(page);
        const csrfToken = await page.locator('meta[name="csrf-token"]').getAttribute('content');

        // Intentar actualizar un portafolio con ID inexistente/ajeno
        const response = await page.evaluate(async (token) => {
            const formData = new FormData();
            formData.append('nombre', 'Hack intento');
            formData.append('descripcion', 'Intento de editar portafolio ajeno');
            formData.append('estado', 'borrador');

            const res = await fetch('/mis-portafolios/99999', {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': token },
                body: formData
            });
            return { status: res.status };
        }, csrfToken);

        // Debe ser 404 (firstOrFail con filtro usuario_id)
        expect([404, 500]).toContain(response.status);
    });

    // ═══════════════════════════════════════════════════════════
    // TC-119: Eliminar portafolio ajeno
    // Tipo Prueba: SEGURIDAD
    // ═══════════════════════════════════════════════════════════
    test('TC-119: Seguridad — No eliminar portafolio ajeno', async ({ page }) => {
        await loginYMenu(page);
        const csrfToken = await page.locator('meta[name="csrf-token"]').getAttribute('content');

        const response = await page.evaluate(async (token) => {
            const res = await fetch('/mis-portafolios/99999', {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json'
                }
            });
            return { status: res.status };
        }, csrfToken);

        expect([404, 500]).toContain(response.status);
    });

    // ═══════════════════════════════════════════════════════════
    // TC-120: Nombre con 256 caracteres (max 255)
    // Tipo Prueba: EXPLORATORIA
    // ═══════════════════════════════════════════════════════════
    test('TC-120: Nombre con 256 caracteres rechazado', async ({ page }) => {
        await loginYMenu(page);
        const csrfToken = await page.locator('meta[name="csrf-token"]').getAttribute('content');

        const nombreLargo = 'A'.repeat(256);

        const response = await page.evaluate(async ({ token, nombre }) => {
            const formData = new FormData();
            formData.append('nombre', nombre);
            formData.append('descripcion', 'Test de límite');
            formData.append('estado', 'borrador');

            const res = await fetch('/mis-portafolios', {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': token },
                body: formData
            });
            return { status: res.status };
        }, { token: csrfToken, nombre: nombreLargo });

        expect(response.status).toBe(422);
    });

    // ═══════════════════════════════════════════════════════════
    // TC-109B: Listar portafolios del usuario (READ)
    // Tipo Prueba: FUNCIONAL
    // ═══════════════════════════════════════════════════════════
    test('TC-109B: Listar portafolios del usuario', async ({ page }) => {
        await loginYMenu(page);

        const portafolios = await page.evaluate(async () => {
            const res = await fetch('/mis-portafolios');
            return await res.json();
        });

        expect(Array.isArray(portafolios)).toBe(true);
        // Cada portafolio debe tener campos requeridos
        if (portafolios.length > 0) {
            expect(portafolios[0]).toHaveProperty('nombre');
            expect(portafolios[0]).toHaveProperty('descripcion');
            expect(portafolios[0]).toHaveProperty('estado');
            expect(portafolios[0]).toHaveProperty('archivos');
        }
    });

    // ═══════════════════════════════════════════════════════════
    // TC-109C: Dashboard muestra portafolios en UI
    // Tipo Prueba: FUNCIONAL
    // ═══════════════════════════════════════════════════════════
    test('TC-109C: Dashboard — Portafolios visibles en UI', async ({ page }) => {
        await loginYMenu(page);

        // Verificar stats
        await expect(page.locator('.stat.s-blue .stat-num')).toBeVisible();
        await expect(page.locator('.stat.s-white .stat-num')).toBeVisible();
        await expect(page.locator('.stat.s-teal .stat-num')).toBeVisible();

        // Verificar que hay cards de portafolio O estado vacío
        const cards = page.locator('.pcard-teal, .pcard-light, .pcard-dark');
        const emptyState = page.getByText('Sin portafolios aún');

        const cardCount = await cards.count();
        if (cardCount > 0) {
            await expect(cards.first()).toBeVisible();
            await expect(cards.first().locator('.pcard-name')).not.toBeEmpty();
        } else {
            await expect(emptyState).toBeVisible();
        }
    });
    // ═══════════════════════════════════════════════════════════
    // TC-153: Portafolios — Filtro o estado existe en UI
    // Tipo Prueba: FUNCIONAL
    // ═══════════════════════════════════════════════════════════
    test('TC-153: Portafolios — Verificar existencia de tabs de filtro', async ({ page }) => {
        await loginYMenu(page);
        const navMenu = page.locator('.pf-nav');
        await expect(navMenu).toBeVisible();
    });
});
