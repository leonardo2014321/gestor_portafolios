import { test, expect } from '@playwright/test';
import { BASE } from '../helpers.js';

// ═══════════════════════════════════════════════════════════════════
// SPRINT 4: PRUEBAS DE HUMO (SMOKE TESTS) - ENTORNO PRODUCCIÓN
// Estas pruebas son ligeras y no invasivas. Su objetivo es asegurar
// que el servidor (http://tis.cs.umss.edu.bo/) responda tras el despliegue.
// ═══════════════════════════════════════════════════════════════════

test.describe('Sprint 4: Smoke Tests - Puesta en Marcha (Producción)', () => {

    test('TC-169: Verificación de Disponibilidad Web (Landing Page)', async ({ page }) => {
        // Navegar a la URL de producción
        const response = await page.goto(BASE, { timeout: 60000 });
        
        // 1. El servidor debe responder con código 200 OK
        expect(response.status()).toBe(200);

        // 2. El título del hero principal debe estar visible (asegura que el DOM renderizó)
        const heroTitle = page.getByRole('heading', { level: 2, name: /tu portafolio/i });
        await expect(heroTitle).toBeVisible({ timeout: 15000 });
    });

    test('TC-170: Carga de Assets Estáticos (CSS/JS)', async ({ page }) => {
        const failedAssets = [];

        // Monitorear todas las respuestas de red para capturar CSS o JS rotos (404, 500)
        page.on('response', response => {
            const type = response.request().resourceType();
            if ((type === 'stylesheet' || type === 'script') && response.status() >= 400) {
                failedAssets.push({ url: response.url(), status: response.status() });
            }
        });

        await page.goto(BASE, { waitUntil: 'networkidle' });

        // 1. Comprobar que no hubo fallos críticos en la carga de assets compilados por Vite/Apache
        expect(failedAssets.length, `Fallo al cargar assets: ${JSON.stringify(failedAssets)}`).toBe(0);
        
        // 2. Verificar estilos aplicados (Tailwind/DaisyUI)
        const navbar = page.locator('nav').first();
        await expect(navbar).toBeVisible();
    });

    test('TC-171: Verificación de Modales de Autenticación', async ({ page }) => {
        await page.goto(BASE);

        // 1. Abrir Modal Login
        await page.locator('#openLoginModal').click();
        await expect(page.locator('#loginModal')).toBeVisible();
        await expect(page.locator('form[action*="/login"]')).toBeVisible();

        // Cerrar modal
        await page.locator('#loginModal .btn-close-modal').click();
        
        // 2. Abrir Modal Registro
        await page.locator('#openRegisterModal').click();
        await expect(page.locator('#registerModal')).toBeVisible();
        await expect(page.locator('form[action*="/registro"]')).toBeVisible();
    });

});
