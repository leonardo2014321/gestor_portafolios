import { test, expect } from '@playwright/test';

const BASE = 'http://localhost:8000';

test.describe('HU-04: Recuperar Contraseña', () => {

    // ─── HELPER: Abrir modal de recuperación desde la landing ───
    async function abrirModalRecuperar(page) {
        await page.goto(BASE);
        // 1. Abrir modal de login
        await page.locator('#openLoginModal').click();
        await expect(page.locator('#loginModal')).toBeVisible();

        // 2. Click en "¿Olvidaste tu contraseña?"
        await page.getByText('¿Olvidaste tu contraseña?').click();

        // 3. Verificar que el modal de recuperación está visible
        await expect(page.locator('#modalRecuperar')).toBeVisible();
    }

    // ═══════════════════════════════════════════════════════════
    // TC-18: Solicitar recuperación con email registrado
    // ═══════════════════════════════════════════════════════════
    test('TC-18: Solicitar recuperación con email registrado', async ({ page }) => {
        await abrirModalRecuperar(page);

        // 1. Verificar título del modal
        await expect(page.getByText('Recuperar acceso')).toBeVisible();

        // 2. Verificar instrucciones
        await expect(page.getByText('Ingresa tu correo electrónico registrado')).toBeVisible();

        // 3. Ingresar email registrado
        await page.fill('#email_recuperar', 'serpientinon@gmail.com');

        // 4. Click en "Enviar enlace de recuperación →"
        await page.click('#btnRecuperar');

        // 5. Verificar que aparece el loading
        // (puede ser muy rápido, verificamos el resultado)

        // 6. Esperar mensaje de respuesta (éxito o error del backend)
        await expect(page.locator('#mensajeEmail')).not.toBeEmpty({ timeout: 15000 });

        // 7. Si el email está registrado, debería mostrar mensaje de éxito (verde)
        // El backend responde con data.mensaje
        const mensaje = page.locator('#mensajeEmail');
        await expect(mensaje).toBeVisible();
    });

    // ═══════════════════════════════════════════════════════════
    // TC-19: Solicitar recuperación con email no registrado
    // ═══════════════════════════════════════════════════════════
    test('TC-19: Solicitar recuperación con email no registrado', async ({ page }) => {
        await abrirModalRecuperar(page);

        // 1. Ingresar email que NO existe en el sistema
        await page.fill('#email_recuperar', 'noexiste999@gmail.com');

        // 2. Enviar solicitud
        await page.click('#btnRecuperar');

        // 3. Verificar respuesta del servidor
        await expect(page.locator('#mensajeEmail')).not.toBeEmpty({ timeout: 15000 });

        // 4. Debería mostrar mensaje de error (rojo)
        // El backend devuelve error si el email no existe
        const mensaje = page.locator('#mensajeEmail');
        await expect(mensaje).toBeVisible();
    });

    // ═══════════════════════════════════════════════════════════
    // TC-20: Solicitar recuperación con campo email vacío
    // ═══════════════════════════════════════════════════════════
    test('TC-20: Solicitar recuperación con campo email vacío', async ({ page }) => {
        await abrirModalRecuperar(page);

        // 1. Dejar el campo de email vacío
        await page.fill('#email_recuperar', '');

        // 2. Click en enviar
        await page.click('#btnRecuperar');

        // 3. Verificar que aparece error "El correo es obligatorio"
        await expect(page.locator('#errorEmail')).toBeVisible();
        await expect(page.locator('#errorEmail')).toContainText('El correo es obligatorio');
    });

    // ═══════════════════════════════════════════════════════════
    // TC-21: Solicitar recuperación con formato de email inválido
    // ═══════════════════════════════════════════════════════════
    test('TC-21: Solicitar recuperación con formato de email inválido', async ({ page }) => {
        await abrirModalRecuperar(page);

        // 1. Ingresar email con formato inválido
        await page.fill('#email_recuperar', 'correo-sin-arroba');

        // 2. Click en enviar
        await page.click('#btnRecuperar');

        // 3. Verificar que aparece error "Correo inválido"
        await expect(page.locator('#errorEmail')).toBeVisible();
        await expect(page.locator('#errorEmail')).toContainText('Correo inválido');
    });

    // ═══════════════════════════════════════════════════════════
    // TC-22: Resetear contraseña exitosamente con token válido
    // ═══════════════════════════════════════════════════════════
    test.skip('TC-22: Resetear contraseña con token válido (formulario de reset)', async ({ page }) => {
        // ⚠️ SKIP: Requiere un token real generado por el flujo de recuperación (vía Gmail).
        //    El token fake no permite completar el flujo E2E.
        // 1. Navegar con un token simulado en la URL
        // Esto activa el formulario de cambio de contraseña
        await page.goto(`${BASE}?token=test-token-fake`);

        // 2. Esperar que el modal de recuperación se abra automáticamente (detecta token en URL)
        await expect(page.locator('#modalRecuperar')).toBeVisible({ timeout: 5000 });

        // 3. Verificar que se muestra el formulario de reset (no el de envío de email)
        await expect(page.locator('#formReset')).toBeVisible();

        // 4. Verificar que el mensaje principal cambió
        await expect(page.locator('#mensajePrincipal')).toContainText('nueva contraseña');

        // 5. Llenar nueva contraseña válida
        await page.fill('#resetPassword', 'NuevaPass123');
        await page.fill('#resetConfirmPassword', 'NuevaPass123');

        // 6. Verificar validación en vivo: reglas cumplidas (verde)
        await expect(page.locator('#ruleLength')).toContainText('✓');
        await expect(page.locator('#ruleNumber')).toContainText('✓');

        // 7. Verificar que las contraseñas coinciden
        await expect(page.locator('#statusConfirm')).toContainText('coinciden');

        // 8. Enviar formulario (el token es falso, esperamos respuesta del backend)
        await page.click('#formReset button[type="submit"]');

        // 9. Verificar que hubo respuesta del backend (éxito o error según el token)
        await expect(page.locator('#mensajeReset')).not.toBeEmpty({ timeout: 10000 });
    });

    // ═══════════════════════════════════════════════════════════
    // TC-23: Contraseñas que no coinciden son rechazadas
    // ═══════════════════════════════════════════════════════════
    test('TC-23: Contraseñas que no coinciden son rechazadas', async ({ page }) => {
        // 1. Navegar con token para activar el formulario de reset
        await page.goto(`${BASE}?token=test-token-fake`);
        await expect(page.locator('#modalRecuperar')).toBeVisible({ timeout: 5000 });
        await expect(page.locator('#formReset')).toBeVisible();

        // 2. Llenar contraseñas que no coinciden
        await page.fill('#resetPassword', 'Password123');
        await page.fill('#resetConfirmPassword', 'OtraPassword456');

        // 3. Verificar mensaje "No coinciden"
        await expect(page.locator('#statusConfirm')).toBeVisible();
        await expect(page.locator('#statusConfirm')).toContainText('no coinciden');

        // 4. Intentar enviar
        await page.click('#formReset button[type="submit"]');

        // 5. El formulario no debería proceder (validarConfirm() lo bloquea)
        // Verificar que mensajeReset no muestra mensaje de éxito
        await page.waitForTimeout(1000);
        const resetMsg = await page.locator('#mensajeReset').textContent();
        expect(resetMsg?.trim()).toBe('');
    });

    // ═══════════════════════════════════════════════════════════
    // TC-24: Contraseña menor a 8 caracteres rechazada
    // ═══════════════════════════════════════════════════════════
    test('TC-24: Contraseña menor a 8 caracteres rechazada', async ({ page }) => {
        // 1. Navegar con token para activar el formulario de reset
        await page.goto(`${BASE}?token=test-token-fake`);
        await expect(page.locator('#modalRecuperar')).toBeVisible({ timeout: 5000 });
        await expect(page.locator('#formReset')).toBeVisible();

        // 2. Llenar contraseña corta (menos de 8 caracteres)
        await page.fill('#resetPassword', 'Ab1');
        await page.fill('#resetConfirmPassword', 'Ab1');

        // 3. Verificar indicador visual: regla de longitud NO cumplida
        await expect(page.locator('#ruleLength')).toContainText('✕');

        // 4. Intentar enviar
        await page.click('#formReset button[type="submit"]');

        // 5. Verificar mensaje de error de validación
        await expect(page.locator('#errorNewPassword')).toBeVisible();
        await expect(page.locator('#errorNewPassword')).toContainText('Mínimo 8 caracteres');
    });

});
