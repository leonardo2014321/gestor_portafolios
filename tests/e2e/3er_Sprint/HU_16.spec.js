import { test, expect } from '@playwright/test';

// ═══════════════════════════════════════════════════════════════════
// HU-16: Soporte Multi-idioma
// Tipo Ejecución: AUTOMATED | Sprint: 3
// ═══════════════════════════════════════════════════════════════════

const BASE = 'http://localhost:8000';

async function loginYMenu(page) {
    await page.goto(BASE);
    await page.locator('#openLoginModal').click();
    await expect(page.locator('#loginModal')).toBeVisible({ timeout: 5000 });
    await page.fill('input[name="email"]', 'serpientinon@gmail.com');
    await page.fill('input[name="password"]', '12tres45');
    await page.click('button:has-text("Entrar al sistema")');
    await expect(page).toHaveURL(/.*\/menu/, { timeout: 15000 });
}

test.describe('HU-16: Soporte Multi-idioma', () => {

    // ═══════════════════════════════════════════════════════════
    // TC-133: Cambiar de Español a Inglés
    // Tipo Prueba: FUNCIONAL
    // ═══════════════════════════════════════════════════════════
    test('TC-133: Cambiar idioma de Español a Inglés', async ({ page }) => {
        await loginYMenu(page);

        // Verificar texto en español
        await expect(page.getByText('Menú principal')).toBeVisible();

        // Cambiar a inglés
        await page.goto(`${BASE}/lang/en`);
        await page.waitForTimeout(500);

        // Verificar textos en inglés
        await expect(page.getByText('Main Menu')).toBeVisible();
        await expect(page.getByText('Reports')).toBeVisible();
        await expect(page.getByText('My Profile')).toBeVisible();
    });

    // ═══════════════════════════════════════════════════════════
    // TC-134: Cambiar de Inglés a Francés
    // Tipo Prueba: FUNCIONAL
    // ═══════════════════════════════════════════════════════════
    test('TC-134: Cambiar idioma de Inglés a Francés', async ({ page }) => {
        await loginYMenu(page);

        // Poner en inglés primero
        await page.goto(`${BASE}/lang/en`);
        await page.waitForTimeout(500);
        await expect(page.getByText('Main Menu')).toBeVisible();

        // Cambiar a francés
        await page.goto(`${BASE}/lang/fr`);
        await page.waitForTimeout(500);

        // Verificar que los textos cambiaron (no están en inglés)
        const menuText = await page.locator('#btn-menu span').textContent();
        expect(menuText.trim()).not.toBe('Main Menu');
        expect(menuText.trim()).not.toBe('Menú principal');
    });

    // ═══════════════════════════════════════════════════════════
    // TC-135: Volver a Español
    // Tipo Prueba: FUNCIONAL
    // ═══════════════════════════════════════════════════════════
    test('TC-135: Volver a Español desde otro idioma', async ({ page }) => {
        await loginYMenu(page);

        // Cambiar a inglés
        await page.goto(`${BASE}/lang/en`);
        await page.waitForTimeout(500);

        // Volver a español
        await page.goto(`${BASE}/lang/es`);
        await page.waitForTimeout(500);

        // Verificar español
        await expect(page.getByText('Menú principal')).toBeVisible();
        await expect(page.getByText('Reportes')).toBeVisible();
        await expect(page.getByText('Mi Perfil')).toBeVisible();
    });

    // ═══════════════════════════════════════════════════════════
    // TC-136: Persistencia tras recarga
    // Tipo Prueba: FUNCIONAL
    // ═══════════════════════════════════════════════════════════
    test('TC-136: Idioma persiste tras recarga de página', async ({ page }) => {
        await loginYMenu(page);

        // Cambiar a inglés
        await page.goto(`${BASE}/lang/en`);
        await page.waitForTimeout(500);

        // Navegar a /menu directamente
        await page.goto(`${BASE}/menu`);
        await page.waitForTimeout(500);

        // Verificar que sigue en inglés
        await expect(page.getByText('Main Menu')).toBeVisible();

        // Recargar
        await page.reload();
        await page.waitForTimeout(500);

        // Sigue en inglés
        await expect(page.getByText('Main Menu')).toBeVisible();

        // Restaurar español para otros tests
        await page.goto(`${BASE}/lang/es`);
    });

    // ═══════════════════════════════════════════════════════════
    // TC-137: Idioma no permitido
    // Tipo Prueba: SEGURIDAD
    // ═══════════════════════════════════════════════════════════
    test('TC-137: Idioma no permitido no cambia la sesión', async ({ page }) => {
        await loginYMenu(page);

        // Asegurar español
        await page.goto(`${BASE}/lang/es`);
        await page.waitForTimeout(300);

        // Intentar idioma no permitido
        await page.goto(`${BASE}/lang/de`);
        await page.waitForTimeout(500);

        // Navegar al menú
        await page.goto(`${BASE}/menu`);
        await page.waitForTimeout(500);

        // Verificar que sigue en español (no cambió a alemán)
        await expect(page.getByText('Menú principal')).toBeVisible();
    });

    // ═══════════════════════════════════════════════════════════
    // TC-138: Path traversal en ruta de idioma
    // Tipo Prueba: SEGURIDAD
    // ═══════════════════════════════════════════════════════════
    test('TC-138: Path traversal — /lang/../../etc/passwd bloqueado', async ({ page }) => {
        const response = await page.goto(`${BASE}/lang/..%2F..%2Fetc%2Fpasswd`);

        // No debe exponer archivos del sistema
        if (response) {
            const status = response.status();
            expect([200, 302, 404]).toContain(status);
        }

        // Verificar que NO contiene contenido de /etc/passwd
        const content = await page.content();
        expect(content).not.toContain('root:');
        expect(content).not.toContain('/bin/bash');
    });

    // ═══════════════════════════════════════════════════════════
    // TC-139: Evitar loop infinito
    // Tipo Prueba: SISTEMA
    // ═══════════════════════════════════════════════════════════
    test('TC-139: /lang/en no genera redirect loop', async ({ page }) => {
        // Navegar directamente sin referrer
        const response = await page.goto(`${BASE}/lang/en`);

        // Debe redirigir a alguna página (no a sí misma infinitamente)
        const finalUrl = page.url();
        expect(finalUrl).not.toContain('/lang/');
    });

    // ═══════════════════════════════════════════════════════════
    // TC-140: No destruye sesión de autenticación
    // Tipo Prueba: REGRESION
    // ═══════════════════════════════════════════════════════════
    test('TC-140: Cambiar idioma no destruye sesión', async ({ page }) => {
        await loginYMenu(page);

        // Cambiar idioma varias veces
        await page.goto(`${BASE}/lang/en`);
        await page.waitForTimeout(300);
        await page.goto(`${BASE}/lang/fr`);
        await page.waitForTimeout(300);
        await page.goto(`${BASE}/lang/es`);
        await page.waitForTimeout(300);

        // Verificar que sigue logueado (puede acceder a /menu)
        await page.goto(`${BASE}/menu`);
        await expect(page).toHaveURL(/.*\/menu/, { timeout: 5000 });

        // No fue redirigido a login
        await expect(page).not.toHaveURL(/.*\/login/);
    });

    // ═══════════════════════════════════════════════════════════
    // TC-141: Textos del perfil cambian
    // Tipo Prueba: INTEGRACION
    // ═══════════════════════════════════════════════════════════
    test('TC-141: Textos del perfil cambian según idioma', async ({ page }) => {
        await loginYMenu(page);

        // En español
        await page.goto(`${BASE}/lang/es`);
        await page.goto(`${BASE}/perfil`);
        await page.waitForTimeout(500);
        await expect(page.getByText('Mi Perfil')).toBeVisible();
        await expect(page.getByText('Información Personal')).toBeVisible();

        // En inglés
        await page.goto(`${BASE}/lang/en`);
        await page.goto(`${BASE}/perfil`);
        await page.waitForTimeout(500);
        await expect(page.getByText('My Profile')).toBeVisible();
        await expect(page.getByText('Personal Information')).toBeVisible();

        // Restaurar
        await page.goto(`${BASE}/lang/es`);
    });

    // ═══════════════════════════════════════════════════════════
    // TC-142: Default es español
    // Tipo Prueba: SANIDAD-HUMO
    // ═══════════════════════════════════════════════════════════
    test('TC-142: Idioma default es español', async ({ page }) => {
        // Navegar a home sin sesión previa (nuevo contexto)
        await page.goto(`${BASE}/home`);
        await page.waitForTimeout(500);

        // Verificar textos en español en la home
        const content = await page.content();
        // Debe contener textos en español (hero, nav, etc.)
        expect(content).toContain('Iniciar sesión');
    });
    // ═══════════════════════════════════════════════════════════
    // TC-155: Multi-idioma — Menú desplegable existe
    // Tipo Prueba: FUNCIONAL
    // ═══════════════════════════════════════════════════════════
    test('TC-155: Idioma — Dropdown visible en el navbar', async ({ page }) => {
        await loginYMenu(page);
        const langBtn = page.locator('#btn-lang');
        await expect(langBtn).toBeVisible();
    });
});
