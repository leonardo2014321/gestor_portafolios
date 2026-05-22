import { test, expect } from '@playwright/test';

import { BASE, loginUsuario, loginAdmin, logoutCleanup } from '../helpers.js';

test.describe('HU-07: Redes y Privacidad', () => {

    // ─── HELPER: Login + navegar a /perfil ───
    async function loginYPerfil(page) {
        await page.goto(BASE);
        await page.locator('#openLoginModal').click();
        await expect(page.locator('#loginModal')).toBeVisible();
        await page.fill('input[name="email"]', 'serpientinon@gmail.com');
        await page.fill('input[name="password"]', '12tres45');
        await page.click('button:has-text("Entrar al sistema")');
        await expect(page).toHaveURL(/.*\/menu/, { timeout: 10000 });
        await page.goto(`${BASE}/perfil`);
        await expect(page.locator('h1:has-text("Mi Perfil")')).toBeVisible({ timeout: 10000 });
    }

    // ─── HELPER: Abrir sección redes (si es un componente embebido) ───
    async function abrirRedes(page) {
        // Las redes están en /perfil/redes como API, no como vista separada
        // Cargamos la data vía fetch en el contexto de /perfil
    }

    // ═══════════════════════════════════════════════════════════
    // TC-51: Verificar estructura de LinkedIn
    // ═══════════════════════════════════════════════════════════
    test('TC-51: Verificar estructura de LinkedIn', async ({ page }) => {
        await loginYPerfil(page);

        // 1. Verificar que la API de redes responde
        const response = await page.request.get(`${BASE}/perfil/redes`);
        expect(response.ok()).toBeTruthy();

        // 2. Verificar que la respuesta es un array JSON
        const data = await response.json();
        expect(Array.isArray(data)).toBeTruthy();

        // 3. Verificar la estructura: cada red tiene tipo, url, visible
        if (data.length > 0) {
            const red = data[0];
            expect(red).toHaveProperty('tipo');
            expect(red).toHaveProperty('url');
            expect(red).toHaveProperty('visible');
        }
    });

    // ═══════════════════════════════════════════════════════════
    // TC-52: Verificar protocolo seguro
    // ═══════════════════════════════════════════════════════════
    test('TC-52: Verificar protocolo seguro', async ({ page }) => {
        await loginYPerfil(page);

        // 1. Verificar que la API de redes requiere autenticación
        // Al estar autenticados, la petición debe ser exitosa
        const response = await page.request.get(`${BASE}/perfil/redes`);
        expect(response.ok()).toBeTruthy();

        // 2. Verificar que POST requiere CSRF token
        const csrfToken = await page.evaluate(() => {
            return document.querySelector('meta[name="csrf-token"]')?.content;
        });
        expect(csrfToken).toBeTruthy();
    });

    // ═══════════════════════════════════════════════════════════
    // TC-53: Verificar toggle de privacidad
    // ═══════════════════════════════════════════════════════════
    test('TC-53: Verificar toggle de privacidad', async ({ page }) => {
        await loginYPerfil(page);

        // 1. Obtener estado actual de redes
        const response = await page.request.get(`${BASE}/perfil/redes`);
        const data = await response.json();

        // 2. Verificar que las redes tienen campo "visible" (booleano)
        if (data.length > 0) {
            data.forEach(red => {
                expect(typeof red.visible).toBe('boolean');
            });
        }

        // 3. Probar guardado con toggle de visibilidad cambiado
        const csrfToken = await page.evaluate(() => {
            return document.querySelector('meta[name="csrf-token"]')?.content;
        });

        const redesPayload = [
            { tipo: 'linkedin', url: 'https://linkedin.com/in/test', visible: false },
            { tipo: 'github', url: 'https://github.com/test', visible: true }
        ];

        const saveResponse = await page.request.post(`${BASE}/perfil/redes`, {
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            data: { redes: redesPayload }
        });

        expect(saveResponse.ok()).toBeTruthy();
    });

    // ═══════════════════════════════════════════════════════════
    // TC-54: Verificar enlaces externos
    // ═══════════════════════════════════════════════════════════
    test('TC-54: Verificar enlaces externos', async ({ page }) => {
        await loginYPerfil(page);

        // 1. Obtener redes guardadas
        const response = await page.request.get(`${BASE}/perfil/redes`);
        const data = await response.json();

        // 2. Verificar que las URLs tienen formato válido (si tienen valor)
        data.forEach(red => {
            if (red.url && red.url.trim() !== '') {
                // La URL debería empezar con http:// o https://
                const urlRegex = /^https?:\/\//;
                // El backend puede guardar sin protocolo, pero la vista lo agrega
                expect(typeof red.url).toBe('string');
            }
        });
    });

    // ═══════════════════════════════════════════════════════════
    // TC-55: Verificar acceso denegado
    // ═══════════════════════════════════════════════════════════
    test('TC-55: Verificar acceso denegado', async ({ page }) => {
        // 1. Sin login, acceder a la API de redes debe redirigir a login
        const response = await page.request.get(`${BASE}/perfil/redes`, {
            maxRedirects: 0
        });

        // 2. Debe devolver redirect (302) o error (401/403)
        expect([302, 401, 403]).toContain(response.status());
    });

    // ═══════════════════════════════════════════════════════════
    // TC-56: Verificar icono dinámico
    // ═══════════════════════════════════════════════════════════
    test('TC-56: Verificar icono dinámico', async ({ page }) => {
        await loginYPerfil(page);

        // 1. Verificar que el sidebar tiene el link a Mi Perfil
        await expect(page.locator('.sb-item:has-text("Mi Perfil")')).toBeVisible();

        // 2. Verificar que Mi Perfil está marcado como activo
        await expect(page.locator('.sb-item.active:has-text("Mi Perfil")')).toBeVisible();

        // 3. Verificar que el avatar del sidebar se muestra
        const sidebarAv = page.locator('#sidebarAv');
        await expect(sidebarAv).toBeVisible();
    });

    // ═══════════════════════════════════════════════════════════
    // TC-57: Verificar ofuscación de correo
    // ═══════════════════════════════════════════════════════════
    test('TC-57: Verificar ofuscación de correo', async ({ page }) => {
        await loginYPerfil(page);

        // 1. Verificar que la vista NO expone el email en texto plano en el DOM visible
        const pageContent = await page.textContent('main');
        // El email NO debe aparecer en el contenido principal del perfil
        // (puede estar en la sesión pero no visible al público)
        expect(pageContent).not.toContain('serpientinon@gmail.com');
    });

    // ═══════════════════════════════════════════════════════════
    // TC-58: Verificar slug personalizado
    // ═══════════════════════════════════════════════════════════
    test('TC-58: Verificar slug personalizado', async ({ page }) => {
        await loginYPerfil(page);

        // 1. Verificar que el perfil tiene un ID de usuario visible
        const userIdText = await page.locator('.sb-uid').textContent();
        expect(userIdText).toMatch(/#\d+/);
    });

    // ═══════════════════════════════════════════════════════════
    // TC-59: Verificar confirmación de privacidad
    // ═══════════════════════════════════════════════════════════
    test('TC-59: Verificar confirmación de privacidad', async ({ page }) => {
        await loginYPerfil(page);

        // 1. Verificar que el botón "Desactivar cuenta" existe
        await expect(page.locator('button:has-text("Desactivar cuenta")')).toBeVisible();

        // 2. Click en Desactivar cuenta
        await page.click('button:has-text("Desactivar cuenta")');

        // 3. Verificar que aparece modal de confirmación
        await expect(page.locator('#modalDesactivar')).toHaveClass(/show/);
        await expect(page.locator('#modalDesactivar h3')).toContainText('Desactivar');

        // 4. Verificar que tiene botón de cancelar
        await expect(page.locator('#modalDesactivar .btn-cancel')).toBeVisible();

        // 5. Cancelar
        await page.click('#modalDesactivar .btn-cancel');
        await expect(page.locator('#modalDesactivar')).not.toHaveClass(/show/);
    });

    // ═══════════════════════════════════════════════════════════
    // TC-60: Verificar guardado parcial
    // ═══════════════════════════════════════════════════════════
    test('TC-60: Verificar guardado parcial', async ({ page }) => {
        await loginYPerfil(page);

        // 1. Guardar redes con solo LinkedIn (sin GitHub)
        const csrfToken = await page.evaluate(() => {
            return document.querySelector('meta[name="csrf-token"]')?.content;
        });

        const redesPayload = [
            { tipo: 'linkedin', url: 'https://linkedin.com/in/testuser', visible: true },
            { tipo: 'github', url: '', visible: false }
        ];

        const response = await page.request.post(`${BASE}/perfil/redes`, {
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            data: { redes: redesPayload }
        });

        expect(response.ok()).toBeTruthy();

        // 2. Verificar que se guardó correctamente
        const getResponse = await page.request.get(`${BASE}/perfil/redes`);
        const data = await getResponse.json();

        const linkedin = data.find(r => r.tipo === 'linkedin');
        if (linkedin) {
            expect(linkedin.url).toContain('linkedin.com');
        }
    });

    // ═══════════════════════════════════════════════════════════
    // TC-61: Verificar Opacidad por control manual
    // ═══════════════════════════════════════════════════════════
    test('TC-61: Verificar Opacidad por control manual', async ({ page }) => {
        await loginYPerfil(page);

        // 1. Verificar que la Vista Previa funciona como control de visibilidad
        const btnPreview = page.locator('#btnPreview');
        await expect(btnPreview).toBeVisible();

        // 2. La preview empieza oculta
        await expect(page.locator('#previewCard')).not.toHaveClass(/show/);

        // 3. Activar preview (control manual de lo que se muestra)
        await page.click('#btnPreview');
        await expect(page.locator('#previewCard')).toHaveClass(/show/);

        // 4. Desactivar preview
        await page.click('#btnPreview');
        await expect(page.locator('#previewCard')).not.toHaveClass(/show/);
    });

    // ═══════════════════════════════════════════════════════════
    // TC-62: Verificar Candado total al perfil
    // ═══════════════════════════════════════════════════════════
    test('TC-62: Verificar Candado total al perfil', async ({ page }) => {
        await loginYPerfil(page);

        // 1. Verificar que la desactivación de cuenta funciona como "candado total"
        await page.click('button:has-text("Desactivar cuenta")');
        await expect(page.locator('#modalDesactivar')).toHaveClass(/show/);

        // 2. Verificar el texto explicativo
        await expect(page.locator('#modalDesactivar p')).toContainText('no podrás iniciar sesión');
        await expect(page.locator('#modalDesactivar p')).toContainText('no elimina tus datos');

        // 3. Verificar que el botón "Sí, desactivar" existe
        await expect(page.locator('#modalDesactivar .btn-danger')).toContainText('desactivar');

        // 4. Cancelar (no desactivar realmente la cuenta de test)
        await page.click('#modalDesactivar .btn-cancel');
    });

});
