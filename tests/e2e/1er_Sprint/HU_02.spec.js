import { test, expect } from '@playwright/test';

const BASE = 'http://localhost:8000';

test.describe('HU-02: Registrar Usuario', () => {

    // ─── HELPER: Abrir modal de registro desde la landing ───
    async function abrirModalRegistro(page) {
        await page.goto(BASE);
        // Click en "Registrarse" del navbar
        await page.locator('#openRegisterModal').click();
        // Esperar que el modal de registro sea visible
        await expect(page.locator('#registerModal')).toBeVisible();
    }

    // ═══════════════════════════════════════════════════════════
    // TC-4: Validación de Registro Exitoso y Persistencia
    // ═══════════════════════════════════════════════════════════
    test.skip('TC-4: Validación de Registro Exitoso y Persistencia', async ({ page }) => {
        // ⚠️ SKIP: Este TC requiere verificación por email (click en link de Gmail).
        //    No se puede automatizar sin acceso programático al correo.
        await abrirModalRegistro(page);

        // Generar email único para evitar duplicados
        const timestamp = Date.now();
        const emailTest = `testuser${timestamp}@gmail.com`;

        // 1. Llenar formulario con datos válidos
        await page.fill('#nombre', 'Juan');
        await page.fill('#apellido', 'Perez');
        await page.fill('#email', emailTest);
        await page.fill('#password', 'Test12345');
        await page.fill('#password_confirmation', 'Test12345');

        // 2. Aceptar términos de servicio
        await page.check('#terminos');

        // 3. Verificar validación en vivo: contraseña válida (verde)
        await expect(page.locator('#errorPassword')).toContainText('Contraseña válida');

        // 4. Verificar que las contraseñas coinciden
        await expect(page.locator('#errorConfirm')).toContainText('Coinciden');

        // 5. Enviar formulario
        await page.click('#btnSubmit');

        // 6. Verificar mensaje de éxito (envío de verificación por correo)
        await expect(page.locator('#mensajeGeneral')).toBeVisible({ timeout: 15000 });
        await expect(page.locator('#mensajeGeneral')).toContainText(/verificación|enlace|correo/i);
    });

    // ═══════════════════════════════════════════════════════════
    // TC-5: Validación de Seguridad y Caracteres Prohibidos
    // ═══════════════════════════════════════════════════════════
    test('TC-5: Validación de Seguridad y Caracteres Prohibidos', async ({ page }) => {
        await abrirModalRegistro(page);

        // 1. Intentar escribir caracteres especiales en Nombre (se filtran automáticamente)
        await page.fill('#nombre', 'Juan123!@#');
        const nombreValue = await page.inputValue('#nombre');
        expect(nombreValue).toMatch(/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]*$/);

        // 2. Intentar escribir caracteres especiales en Apellido
        await page.fill('#apellido', 'Perez<script>');
        const apellidoValue = await page.inputValue('#apellido');
        expect(apellidoValue).toMatch(/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]*$/);

        // 3. Contraseña débil (menos de 8 caracteres)
        await page.fill('#password', 'abc');
        await expect(page.locator('#errorPassword')).toContainText('Mínimo 8 caracteres');

        // 4. Contraseña sin número
        await page.fill('#password', 'abcdefgh');
        await expect(page.locator('#errorPassword')).toContainText('Mínimo 8 caracteres y un número');

        // 5. Contraseñas que no coinciden
        await page.fill('#password', 'Test12345');
        await page.fill('#password_confirmation', 'OtraCosa99');
        await expect(page.locator('#errorConfirm')).toContainText('No coinciden');

        // 6. Email con formato inválido
        await page.fill('#email', 'correo-malo');
        await page.locator('#email').dispatchEvent('input');
        await expect(page.locator('#errorEmail')).toContainText('no es válido');
    });

    // ═══════════════════════════════════════════════════════════
    // TC-6: Verificación de Funciones de Interfaz
    // ═══════════════════════════════════════════════════════════
    test('TC-6: Verificación de Funciones de Interfaz', async ({ page }) => {
        await abrirModalRegistro(page);

        // 1. Verificar que el título del modal sea "Crear cuenta"
        await expect(page.getByRole('heading', { name: 'Crear cuenta' })).toBeVisible();

        // 2. Verificar que todos los campos del formulario están presentes
        await expect(page.locator('#nombre')).toBeVisible();
        await expect(page.locator('#apellido')).toBeVisible();
        await expect(page.locator('#email')).toBeVisible();
        await expect(page.locator('#password')).toBeVisible();
        await expect(page.locator('#password_confirmation')).toBeVisible();
        await expect(page.locator('#terminos')).toBeVisible();

        // 3. Verificar botón de envío
        await expect(page.locator('#btnSubmit')).toBeVisible();
        await expect(page.locator('#btnSubmit')).toContainText('Registrarse');

        // 4. Verificar toggle de visibilidad de contraseña
        const passwordInput = page.locator('#password');
        await expect(passwordInput).toHaveAttribute('type', 'password');

        // Click en el ojo para mostrar contraseña
        await page.locator('#eye-icon').click();
        await expect(passwordInput).toHaveAttribute('type', 'text');

        // Click de nuevo para ocultar
        await page.locator('#eye-icon').click();
        await expect(passwordInput).toHaveAttribute('type', 'password');

        // 5. Verificar enlace "Inicia sesión" que cambia al modal de login
        await expect(page.getByText('¿Ya tienes cuenta?')).toBeVisible();

        // 6. Enviar formulario vacío y verificar mensajes de error
        await page.click('#btnSubmit');
        await expect(page.locator('#mensajeGeneral')).toBeVisible();
    });

    // ═══════════════════════════════════════════════════════════
    // TC-7: Control de Usuarios Duplicados
    // ═══════════════════════════════════════════════════════════
    test('TC-7: Control de Usuarios Duplicados', async ({ page }) => {
        await abrirModalRegistro(page);

        // 1. Intentar registrar con un email que ya existe en el sistema
        // Usamos un email que probablemente ya exista (o uno genérico de prueba)
        await page.fill('#nombre', 'Test');
        await page.fill('#apellido', 'Duplicado');
        await page.fill('#email', 'serpientinon@gmail.com');
        await page.fill('#password', 'Test12345');
        await page.fill('#password_confirmation', 'Test12345');
        await page.check('#terminos');

        // 2. Enviar formulario
        await page.click('#btnSubmit');

        // 3. Esperar respuesta del servidor (puede ser 422 con error de email duplicado)
        // El sistema muestra error en mensajeGeneral o en errorEmail
        await page.waitForTimeout(5000);

        // 4. Verificar que aparece un mensaje de error relacionado al email duplicado
        // El backend devuelve error 422 con mensaje sobre email ya registrado
        const mensajeVisible = await page.locator('#mensajeGeneral').isVisible();
        const errorEmailVisible = await page.locator('#errorEmail').isVisible();

        // Al menos uno de los mensajes de error debe ser visible
        expect(mensajeVisible || errorEmailVisible).toBeTruthy();
    });

});
