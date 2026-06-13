import { test, expect } from '@playwright/test';
import { BASE } from '../helpers.js';

// ═══════════════════════════════════════════════════════════════════
// SPRINT 4: PRUEBAS DE COMPATIBILIDAD - ENTORNO PRODUCCIÓN
// Verifica cabeceras, rutas estáticas y configuraciones del 
// servidor Apache/PHP/Node.
// ═══════════════════════════════════════════════════════════════════

test.describe('Sprint 4: Compatibilidad y Entorno (Producción)', () => {

    test('TC-174: Verificación de Reglas de Enrutamiento (Apache/Laravel)', async ({ page }) => {
        // 1. Tratar de acceder a una ruta inexistente debe ser capturada por Laravel (404 personalizado o default de Laravel), no por Apache
        const response = await page.goto(`${BASE}/ruta-que-no-existe-12345`);
        
        // El status HTTP debe ser 404
        expect(response.status()).toBe(404);

        // La vista no debe ser el 404 por defecto de Apache
        const bodyText = await page.textContent('body');
        expect(bodyText.toLowerCase()).not.toContain('apache');
    });

    test('TC-175: Configuración de Entorno (Storage y Public)', async ({ page }) => {
        // 1. Verificar acceso a carpeta build generada por Vite (Node.js compatibility)
        const response = await page.goto(`${BASE}/build/manifest.json`);
        
        // El manifiesto puede estar accesible o denegado, pero no debe devolver un error 500 de PHP
        const status = response.status();
        expect([200, 403, 404]).toContain(status);
    });

    test('TC-176: Verificación de Sesiones Seguras', async ({ page }) => {
        const response = await page.goto(BASE);
        
        // 1. Verificar cookies de Laravel (XSRF-TOKEN y laravel_session)
        const cookies = await page.context().cookies();
        
        const xsrfToken = cookies.find(c => c.name === 'XSRF-TOKEN');
        const laravelSession = cookies.find(c => c.name.includes('session'));

        expect(xsrfToken).toBeDefined();
        expect(laravelSession).toBeDefined();

        // Si la URL usa HTTPS, la cookie debería ser Secure (si el servidor lo soporta)
        if (BASE.startsWith('https')) {
            expect(laravelSession.secure).toBeTruthy();
        }
    });

});
