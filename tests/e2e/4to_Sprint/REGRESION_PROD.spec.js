import { test, expect } from '@playwright/test';
import { BASE, loginUsuario, loginAdmin, logoutCleanup } from '../helpers.js';

// ═══════════════════════════════════════════════════════════════════
// SPRINT 4: PRUEBAS DE REGRESIÓN BÁSICA - ENTORNO PRODUCCIÓN
// Verifica que los flujos críticos de las vistas continúan operativos
// sin romper funcionalidades base.
// ═══════════════════════════════════════════════════════════════════

test.describe('Sprint 4: Regresión Básica (Producción)', () => {

    test.afterEach(async ({ page }) => {
        await logoutCleanup(page);
    });

    test('TC-177: Regresión - Flujo Básico de Usuario', async ({ page }) => {
        // 1. Login de usuario
        await loginUsuario(page);
        await expect(page).toHaveURL(/.*\/menu/);

        // 2. Navegación al Perfil
        await page.locator('text=Mi Perfil').click();
        await expect(page).toHaveURL(/.*\/perfil/);
        await expect(page.locator('h1:has-text("Mi Perfil")')).toBeVisible();

        // 3. Navegación a Trayectoria
        await page.locator('text=Trayectoria Profesional').click();
        await expect(page).toHaveURL(/.*\/trayectoria/);
        await expect(page.locator('h1:has-text("Trayectoria Profesional")')).toBeVisible();

        // 4. Logout funciona
        await page.locator('#nav-user-wrap button').first().click();
        await page.locator('#navUserMenu button:has-text("Cerrar sesión")').click();
        await page.locator('#modalLogout #logoutBtnLabelGlobal').click();
        await expect(page).toHaveURL(/.*\/(home|login)?$/, { timeout: 15000 });
    });

    test('TC-178: Regresión - Flujo Básico de Administrador', async ({ page }) => {
        // 1. Login de admin
        await loginAdmin(page);
        await expect(page).toHaveURL(/.*\/admin/);

        // 2. Verificación de renderizado de tabla de usuarios
        await page.locator('#btn-usuarios').click();
        await expect(page.locator('#view-usuarios')).toBeVisible();
        await expect(page.locator('#tabla-usuarios tbody tr').first()).toBeVisible();

        // 3. Verificación de renderizado de portafolios
        await page.locator('#btn-portafolios').click();
        await expect(page.locator('#view-portafolios')).toBeVisible();
    });

});
