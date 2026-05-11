import { test, expect } from '@playwright/test';

// ═══════════════════════════════════════════════════════════════════
// REGRESIÓN: Pruebas Sprint 1 y 2 no rotas por Sprint 3
// Tipo Ejecución: AUTOMATED | Sprint: 3
// ═══════════════════════════════════════════════════════════════════

const BASE = 'http://localhost:8000';

async function loginYMenu(page) {
    await page.goto(BASE);
    await page.waitForLoadState('networkidle');
    await page.getByRole('button', { name: 'Iniciar sesión' }).click();
    await expect(page.locator('#loginModal')).toBeVisible({ timeout: 10000 });
    await page.fill('input[name="email"]', 'serpientinon@gmail.com');
    await page.fill('input[name="password"]', '12tres45');
    await page.click('button:has-text("Entrar al sistema")');
    await expect(page).toHaveURL(/.*\/menu/, { timeout: 45000 });
    await page.waitForLoadState('networkidle');
}

test.describe('Regresión Sprint 1 y 2', () => {

    // ═══════════════════════════════════════════════════════════
    // TC-143: Login y registro siguen funcionales
    // Tipo Prueba: REGRESION
    // ═══════════════════════════════════════════════════════════
    test('TC-143: Login funcional tras cambios Sprint 3', async ({ page }) => {
        // 1. Ir a home
        await page.goto(BASE);
        await page.waitForLoadState('networkidle');
        await expect(page).toHaveURL(/.*\/(home)?$/);

        // 2. Abrir modal login
        await page.getByRole('button', { name: 'Iniciar sesión' }).click();
        await expect(page.locator('#loginModal')).toBeVisible();

        // 3. Llenar credenciales
        await page.fill('input[name="email"]', 'serpientinon@gmail.com');
        await page.fill('input[name="password"]', '12tres45');

        // 4. Enviar
        await page.click('button:has-text("Entrar al sistema")');

        // 5. Verificar redirección a /menu
        await expect(page).toHaveURL(/.*\/menu/, { timeout: 45000 });

        // 6. Verificar elementos del dashboard
        await expect(page.locator('.topbar')).toBeVisible();
        await expect(page.locator('aside')).toBeVisible();
    });

    // ═══════════════════════════════════════════════════════════
    // TC-144: Perfil editable y guardable
    // Tipo Prueba: REGRESION
    // ═══════════════════════════════════════════════════════════
    test('TC-144: Perfil sigue editable y guardable', async ({ page }) => {
        await loginYMenu(page);

        // 1. Navegar a perfil
        await page.goto(`${BASE}/perfil`);
        await expect(page.getByText('Mi Perfil')).toBeVisible({ timeout: 10000 });

        // 2. Verificar campos editables (IDs reales del perfil)
        const inputNombre = page.locator('#fNombre');
        await expect(inputNombre).toBeVisible();
        const valorOriginal = await inputNombre.inputValue();
        expect(valorOriginal.length).toBeGreaterThan(0);

        // 3. Verificar que el botón guardar existe
        const btnGuardar = page.locator('#btnSave');
        await expect(btnGuardar).toBeVisible();

        // 4. Verificar que la biografía es editable
        const textBio = page.locator('#fBiografia');
        await expect(textBio).toBeVisible();
    });

    // ═══════════════════════════════════════════════════════════
    // TC-146: Dashboard usuario muestra portafolios
    // Tipo Prueba: REGRESION
    // ═══════════════════════════════════════════════════════════
    test('TC-146: Dashboard usuario muestra stats y portafolios', async ({ page }) => {
        await loginYMenu(page);

        // 1. Stats visibles
        await expect(page.locator('.stats')).toBeVisible();
        await expect(page.locator('.stat.s-blue')).toBeVisible();

        // 2. Portafolios o estado vacío visible
        const cards = page.locator('.pcard-teal, .pcard-light, .pcard-dark');
        const emptyState = page.getByText('Sin portafolios aún');
        const cardCount = await cards.count();
        if (cardCount > 0) {
            await expect(cards.first()).toBeVisible();
        } else {
            await expect(emptyState).toBeVisible();
        }

        // 3. Sidebar con navegación funcional
        await expect(page.locator('#btn-menu')).toBeVisible();
        await expect(page.locator('#btn-portafolios')).toBeVisible();
        await expect(page.locator('#btn-reportes')).toBeVisible();
    });

    // ═══════════════════════════════════════════════════════════
    // TC-146B: Logout sigue funcional
    // Tipo Prueba: REGRESION
    // ═══════════════════════════════════════════════════════════
    test('TC-146B: Logout con modal de confirmación', async ({ page }) => {
        await loginYMenu(page);

        // 1. Abrir dropdown de usuario en el navbar
        await page.locator('#nav-user-wrap button').first().click();
        await expect(page.locator('#navUserMenu')).toBeVisible();

        // 2. Clic en "Cerrar sesión" dentro del dropdown
        await page.locator('#navUserMenu button:has-text("Cerrar sesión")').click();

        // 3. Modal de confirmación debe aparecer
        await expect(page.locator('#modalLogout')).toBeVisible();

        // 4. Cancelar
        await page.locator('#modalLogout button:has-text("Cancelar")').click();
        await expect(page.locator('#modalLogout')).toBeHidden();

        // 5. Repetir y confirmar logout
        await page.locator('#nav-user-wrap button').first().click();
        await page.locator('#navUserMenu button:has-text("Cerrar sesión")').click();
        await expect(page.locator('#modalLogout')).toBeVisible();
        await page.locator('#modalLogout #logoutBtnLabelGlobal').click();

        // 6. Redirige a home
        await expect(page).toHaveURL(/.*\/(home)?$/, { timeout: 10000 });
    });

    // ═══════════════════════════════════════════════════════════
    // TC-146C: Protección de rutas — /menu sin auth
    // Tipo Prueba: REGRESION + SEGURIDAD
    // ═══════════════════════════════════════════════════════════
    test('TC-146C: /menu sin autenticación redirige a login', async ({ page }) => {
        await page.goto(`${BASE}/menu`);
        await expect(page).toHaveURL(/.*\/login/, { timeout: 10000 });
    });

    // ═══════════════════════════════════════════════════════════
    // TC-146D: Protección de rutas — /perfil sin auth
    // Tipo Prueba: REGRESION + SEGURIDAD
    // ═══════════════════════════════════════════════════════════
    test('TC-146D: /perfil sin autenticación redirige a login', async ({ page }) => {
        await page.goto(`${BASE}/perfil`);
        await expect(page).toHaveURL(/.*\/login/, { timeout: 10000 });
    });
});
