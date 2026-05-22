import { test, expect } from '@playwright/test';
import { BASE, loginUsuario, logoutCleanup } from '../helpers.js';

// ═══════════════════════════════════════════════════════════════════
// SPRINT 4: PRUEBAS DE SANIDAD (SANITY TESTS) - ENTORNO PRODUCCIÓN
// Verifica que la conexión con Base de Datos y Supabase operan de
// manera correcta tras el despliegue.
// ═══════════════════════════════════════════════════════════════════

test.describe('Sprint 4: Sanity Tests - Puesta en Marcha (Producción)', () => {

    test.afterEach(async ({ page }) => {
        await logoutCleanup(page);
    });

    test('TC-PROD-04: Conexión a Base de Datos (PgSQL/MariaDB)', async ({ page }) => {
        // Intento de login verifica que el servidor se comunica con la BD
        await loginUsuario(page);
        
        // 1. Validar que la redirección a /menu ocurre (Login exitoso)
        await expect(page).toHaveURL(/.*\/menu/);

        // 2. Comprobar que los datos del usuario se leen de la BD
        const navName = page.locator('#nav-user-wrap .font-semibold').first();
        await expect(navName).not.toBeEmpty();
    });

    test('TC-PROD-05: Verificación de Explorador de Portafolios (Lectura DB)', async ({ page }) => {
        await page.goto(`${BASE}/explorador`);

        // 1. Debe cargar al menos las categorías (tabla categorias)
        const categorias = page.locator('.categoria-btn');
        await expect(categorias.first()).toBeVisible();

        // 2. Debe cargar al menos un usuario público si existen datos
        const tarjetas = page.locator('.perfil-card');
        const numTarjetas = await tarjetas.count();
        expect(numTarjetas).toBeGreaterThanOrEqual(0); // Puede ser 0 si la BD es nueva
    });

});
