/**
 * ═══════════════════════════════════════════════════════════════════
 * Helpers compartidos para tests E2E — SansiFolios
 * ═══════════════════════════════════════════════════════════════════
 *
 * BASE_URL configurable via variable de entorno:
 *   - php artisan serve:  BASE_URL=http://localhost:8000  (default)
 *   - XAMPP Apache:       BASE_URL=http://localhost/gestor_portafolios/public
 *   - Producción:         BASE_URL=https://sansifolios.com
 *
 * Uso:  BASE_URL=http://localhost/gestor_portafolios/public npx playwright test
 */

import { expect } from '@playwright/test';

// ─── URL Base configurable ───
export const BASE = process.env.BASE_URL || 'http://localhost:8000';

// ─── Credenciales de prueba ───
const USER_EMAIL = 'serpientinon@gmail.com';
const USER_PASS  = '12tres45';
const ADMIN_EMAIL = 'admin@gmail.com';
const ADMIN_PASS  = 'infinitycode1';

/**
 * Login como usuario normal.
 * Usa el patrón de Sprint 3 (getByRole 'Iniciar sesión').
 * Espera inteligente: networkidle en vez de timeouts fijos.
 */
export async function loginUsuario(page) {
    await page.goto(BASE);
    await page.waitForLoadState('networkidle');
    await page.getByRole('button', { name: 'Iniciar sesión' }).click();
    await expect(page.locator('#loginModal')).toBeVisible({ timeout: 15000 });
    await page.fill('input[name="email"]', USER_EMAIL);
    await page.fill('input[name="password"]', USER_PASS);
    await page.click('button:has-text("Entrar al sistema")');
    await expect(page).toHaveURL(/.*\/menu/, { timeout: 60000 });
    await page.waitForLoadState('networkidle');
}

/**
 * Login como administrador.
 * Espera inteligente: networkidle en vez de timeouts fijos.
 */
export async function loginAdmin(page) {
    await page.goto(BASE);
    await page.waitForLoadState('networkidle');
    await page.getByRole('button', { name: 'Iniciar sesión' }).click();
    await expect(page.locator('#loginModal')).toBeVisible({ timeout: 15000 });
    await page.fill('input[name="email"]', ADMIN_EMAIL);
    await page.fill('input[name="password"]', ADMIN_PASS);
    await page.click('button:has-text("Entrar al sistema")');
    await expect(page).toHaveURL(/.*\/admin/, { timeout: 60000 });
    await page.waitForLoadState('networkidle');
}

/**
 * Logout limpio para afterEach.
 * Usa esperas inteligentes en vez de waitForTimeout fijos.
 */
export async function logoutCleanup(page) {
    try {
        if (await page.locator('#nav-user-wrap button').first().isVisible({ timeout: 1000 })) {
            await page.locator('#nav-user-wrap button').first().click();
            await page.locator('#navUserMenu button:has-text("Cerrar sesión")').click();
            await page.locator('#modalLogout #logoutBtnLabelGlobal').click();
            await page.waitForURL(/.*\/(home|login)?$/, { timeout: 15000 });
        }
    } catch (e) {
        // Silenciar errores de logout — no deben romper el siguiente test
    }
    // Pequeño respiro al servidor (reducido de 1500ms a networkidle)
    await page.waitForLoadState('domcontentloaded').catch(() => {});
}
