import { test, expect } from '@playwright/test';
import path from 'path';

import { BASE, loginUsuario, loginAdmin, logoutCleanup } from '../helpers.js';

test.describe('HU-05: Gestión de perfil profesional', () => {

    // ─── HELPER: Login + navegar a /perfil ───
    async function loginYPerfil(page) {
        await loginUsuario(page);
        // Buscamos el botón "Mi Perfil" que aparece en el menú lateral
        const btnMiPerfil = page.getByRole('link', { name: /mi perfil/i });
        await page.locator('text=Mi Perfil').click();
        await page.waitForTimeout(10);
        // 4. Confirmar que la URL cambió a /perfil y la vista cargó
        await page.waitForURL(/.*\/perfil/);
        // Validamos el título principal de la sección
        await expect(page.locator('h1:has-text("Mi Perfil")')).toBeVisible({ timeout: 10000 });
    }

    // ═══════════════════════════════════════════════════════════
    // TC-25: Verificar campos obligatorios (nombre, apellido y profesión)
    // ═══════════════════════════════════════════════════════════
    test('TC-25: Verificar campos obligatorios (nombre, apellido y profesión)', async ({ page }) => {
        await loginYPerfil(page);

        // 1. Vaciar campos obligatorios
        await page.fill('#fNombre', '');
        await page.fill('#fApellido', '');
        await page.fill('#fProfesion', '');

        // 2. Click en "Guardar" (abre modal de confirmación si valida; si no, muestra errores)
        await page.click('#btnSave');

        // 3. Verificar que los mensajes de error aparecen
        await expect(page.locator('#errNombre')).toBeVisible();
        await expect(page.locator('#errNombre')).toContainText('obligatorio');

        await expect(page.locator('#errApellido')).toBeVisible();
        await expect(page.locator('#errApellido')).toContainText('obligatorio');

        await expect(page.locator('#errProfesion')).toBeVisible();
        await expect(page.locator('#errProfesion')).toContainText('obligatoria');

        // 4. Verificar que los campos tienen estilo de error
        await expect(page.locator('#fNombre')).toHaveClass(/error/);
        await expect(page.locator('#fApellido')).toHaveClass(/error/);
        await expect(page.locator('#fProfesion')).toHaveClass(/error/);
    });

    // ═══════════════════════════════════════════════════════════
    // TC-26: Verificar campo profesión que sea coherente
    // ═══════════════════════════════════════════════════════════
    test('TC-26: Verificar campo profesión que sea coherente', async ({ page }) => {
        await loginYPerfil(page);

        // 1. Verificar que el campo tiene placeholder descriptivo
        await expect(page.locator('#fProfesion')).toHaveAttribute('placeholder', 'Ej: Ingeniero de Software');

        // 2. Verificar longitud máxima permitida (150 caracteres)
        await expect(page.locator('#fProfesion')).toHaveAttribute('maxlength', '150');

        // 3. Ingresar profesión con caracteres prohibidos
        await page.fill('#fProfesion', 'Ingeniero<script>');
        await page.locator('#fProfesion').dispatchEvent('input');

        // 4. Verificar que muestra error de caracteres no permitidos
        await expect(page.locator('#errProfesion')).toBeVisible();
        await expect(page.locator('#errProfesion')).toContainText('Carácter no permitido');

        // 5. Ingresar profesión válida
        await page.fill('#fProfesion', 'Ingeniero de Software');
        await page.locator('#fProfesion').dispatchEvent('input');

        // 6. El error debe desaparecer
        await expect(page.locator('#fProfesion')).not.toHaveClass(/error/);
    });

    // ═══════════════════════════════════════════════════════════
    // TC-27: Verificar límite de caracteres en la biografía sin espacios vacíos
    // ═══════════════════════════════════════════════════════════
    test('TC-27: Verificar límite de caracteres en la biografía', async ({ page }) => {
        await loginYPerfil(page);

        // 1. Verificar que el contador de caracteres es visible
        await expect(page.locator('#bioCounter')).toBeVisible();

        // 2. Escribir texto dentro del límite
        const textoCorto = 'Esta es mi biografía profesional.';
        await page.fill('#fBiografia', textoCorto);
        await page.locator('#fBiografia').dispatchEvent('input');

        // 3. Verificar contador actualizado
        await expect(page.locator('#bioCounter')).toContainText(`${textoCorto.length} / 1000`);

        // 4. Escribir texto que excede 1000 caracteres
        const textoLargo = 'A'.repeat(1050);
        await page.fill('#fBiografia', textoLargo);
        await page.locator('#fBiografia').dispatchEvent('input');

        // 5. Verificar que el contador muestra exceso (rojo)
        await expect(page.locator('#bioCounter')).toHaveClass(/over/);

        // 6. Verificar que el botón Guardar se deshabilita
        await expect(page.locator('#btnSave')).toBeDisabled();

        // 7. Verificar mensaje de error
        await expect(page.locator('#errBiografia')).toBeVisible();
        await expect(page.locator('#errBiografia')).toContainText('supera el límite');
    });

    // ═══════════════════════════════════════════════════════════
    // TC-28: Verificar guardado de imagen
    // ═══════════════════════════════════════════════════════════
    test('TC-28: Verificar guardado de imagen', async ({ page }) => {
        await loginYPerfil(page);

        // 1. Verificar que el área de foto existe
        await expect(page.locator('.photo-card')).toBeVisible();
        await expect(page.locator('.photo-wrap')).toBeVisible();

        // 2. Verificar que el input de archivo está oculto pero existe
        const inputFoto = page.locator('#inputFoto');
        await expect(inputFoto).toHaveAttribute('accept', '.jpg,.jpeg,.png');

        // 3. Verificar hint de formato
        await expect(page.locator('.photo-hint')).toContainText('JPG o PNG');
        await expect(page.locator('.photo-hint')).toContainText('Máx 2 MB');
    });

    // ═══════════════════════════════════════════════════════════
    // TC-29: Verificar formato de foto de perfil
    // ═══════════════════════════════════════════════════════════
    test('TC-29: Verificar formato de foto de perfil', async ({ page }) => {
        await loginYPerfil(page);

        // 1. Verificar que solo acepta jpg, jpeg, png
        const inputFoto = page.locator('#inputFoto');
        await expect(inputFoto).toHaveAttribute('accept', '.jpg,.jpeg,.png');

        // 2. Simular subida de archivo con formato inválido (gif)
        // Creamos un archivo fake de tipo gif
        await page.evaluate(() => {
            const dt = new DataTransfer();
            const file = new File(['fake'], 'test.gif', { type: 'image/gif' });
            dt.items.add(file);
            const input = document.getElementById('inputFoto');
            input.files = dt.files;
            input.dispatchEvent(new Event('change'));
        });

        // 3. Verificar mensaje de error de formato
        await expect(page.locator('#photoError')).toBeVisible();
        await expect(page.locator('#photoError')).toContainText('Formato no soportado');
    });

    // ═══════════════════════════════════════════════════════════
    // TC-30: Verificar peso de la imagen de perfil
    // ═══════════════════════════════════════════════════════════
    test('TC-30: Verificar peso de la imagen de perfil', async ({ page }) => {
        await loginYPerfil(page);

        // 1. Simular subida de archivo que excede 2MB
        await page.evaluate(() => {
            const dt = new DataTransfer();
            // Crear un archivo de ~3MB
            const largeContent = new Uint8Array(3 * 1024 * 1024);
            const file = new File([largeContent], 'foto_grande.jpg', { type: 'image/jpeg' });
            dt.items.add(file);
            const input = document.getElementById('inputFoto');
            input.files = dt.files;
            input.dispatchEvent(new Event('change'));
        });

        // 2. Verificar mensaje de error de peso
        await expect(page.locator('#photoError')).toBeVisible();
        await expect(page.locator('#photoError')).toContainText('2MB');
    });

    // ═══════════════════════════════════════════════════════════
    // TC-31: Verificar limpieza de datos (XSS)
    // ═══════════════════════════════════════════════════════════
    test('TC-31: Verificar limpieza de datos (XSS)', async ({ page }) => {
        await loginYPerfil(page);

        const xssPayloads = [
            '<script>alert("xss")</script>',
            '"><img src=x onerror=alert(1)>',
            'Test`injection',
            'Test{payload}',
            'Test;drop',
            'Test\\path',
        ];

        // 1. Probar XSS en campo nombre
        await page.fill('#fNombre', xssPayloads[0]);
        await page.locator('#fNombre').dispatchEvent('input');
        await expect(page.locator('#errNombre')).toBeVisible();
        await expect(page.locator('#errNombre')).toContainText('Carácter no permitido');

        // 2. Probar XSS en campo apellido
        await page.fill('#fApellido', xssPayloads[1]);
        await page.locator('#fApellido').dispatchEvent('input');
        await expect(page.locator('#errApellido')).toBeVisible();

        // 3. Probar backtick en profesión
        await page.fill('#fProfesion', xssPayloads[2]);
        await page.locator('#fProfesion').dispatchEvent('input');
        await expect(page.locator('#errProfesion')).toBeVisible();

        // 4. Probar llaves en biografía
        await page.fill('#fBiografia', xssPayloads[3]);
        await page.locator('#fBiografia').dispatchEvent('input');
        await expect(page.locator('#errBiografia')).toBeVisible();

        // 5. Intentar guardar con datos maliciosos — no debe permitirlo
        await page.click('#btnSave');
        // El modal de confirmación NO debe abrirse
        await expect(page.locator('#modalGuardar')).not.toHaveClass(/show/);
    });

    // ═══════════════════════════════════════════════════════════
    // TC-32: Verificar persistencia de cambios
    // ═══════════════════════════════════════════════════════════
    test('TC-32: Verificar persistencia de cambios', async ({ page }) => {
        await loginYPerfil(page);

        // 1. Guardar los valores actuales
        const nombreActual = await page.inputValue('#fNombre');

        // 2. Modificar nombre con timestamp para unicidad
        const nuevoNombre = `TestPersist${Date.now() % 1000}`;
        await page.fill('#fNombre', nuevoNombre);

        // 3. Asegurarse que los demás campos obligatorios tengan valor
        const apellido = await page.inputValue('#fApellido');
        if (!apellido) await page.fill('#fApellido', 'TestApellido');

        const profesion = await page.inputValue('#fProfesion');
        if (!profesion) await page.fill('#fProfesion', 'Ingeniero de Pruebas');

        const biografia = await page.inputValue('#fBiografia');
        if (!biografia) await page.fill('#fBiografia', 'Biografía de prueba.');

        // 4. Click en Guardar → abre modal de confirmación
        await page.click('#btnSave');
        await expect(page.locator('#modalGuardar')).toHaveClass(/show/, { timeout: 3000 });

        // 5. Confirmar guardado
        await page.click('button:has-text("Sí, guardar")');

        // 6. Esperar redirección (la página recarga con ?updated=1)
        await page.waitForURL(/.*perfil/, { timeout: 15000 });

        // 7. Verificar que el nombre se guardó
        await expect(page.locator('#fNombre')).toHaveValue(nuevoNombre);

        // 8. Restaurar nombre original
        await page.fill('#fNombre', nombreActual || 'Test');
        await page.click('#btnSave');
        await expect(page.locator('#modalGuardar')).toHaveClass(/show/, { timeout: 3000 });
        await page.click('button:has-text("Sí, guardar")');
        await page.waitForURL(/.*perfil/, { timeout: 15000 });
    });

    // ═══════════════════════════════════════════════════════════
    // TC-33: Verificar cancelación de edición
    // ═══════════════════════════════════════════════════════════
    test('TC-33: Verificar cancelación de edición', async ({ page }) => {
        await loginYPerfil(page);

        // 1. Guardar valores originales
        const nombreOriginal = await page.inputValue('#fNombre');
        const apellidoOriginal = await page.inputValue('#fApellido');

        // 2. Modificar campos
        await page.fill('#fNombre', 'NombreCambiado');
        await page.fill('#fApellido', 'ApellidoCambiado');

        // 3. Click en "Cancelar"
        await page.click('.btn-cancel:has-text("Cancelar")');

        // 4. Verificar que los valores se restauraron a los originales
        await expect(page.locator('#fNombre')).toHaveValue(nombreOriginal);
        await expect(page.locator('#fApellido')).toHaveValue(apellidoOriginal);
    });

    // ═══════════════════════════════════════════════════════════
    // TC-34: Verificar feedback de éxito
    // ═══════════════════════════════════════════════════════════
    test('TC-34: Verificar feedback de éxito', async ({ page }) => {
        await loginYPerfil(page);

        // 1. Asegurar que los campos obligatorios tengan valores
        const nombre = await page.inputValue('#fNombre');
        if (!nombre) await page.fill('#fNombre', 'Test');
        const apellido = await page.inputValue('#fApellido');
        if (!apellido) await page.fill('#fApellido', 'Usuario');
        const profesion = await page.inputValue('#fProfesion');
        if (!profesion) await page.fill('#fProfesion', 'Tester');
        const bio = await page.inputValue('#fBiografia');
        if (!bio) await page.fill('#fBiografia', 'Bio de prueba.');

        // 2. Click en Guardar → modal confirmación
        await page.click('#btnSave');
        await expect(page.locator('#modalGuardar')).toHaveClass(/show/, { timeout: 3000 });

        // 3. Confirmar
        await page.click('button:has-text("Sí, guardar")');

        // 4. La página recarga con ?updated=1 que genera alerta de éxito
        await page.waitForURL(/.*perfil/, { timeout: 15000 });

        // 5. Verificar alerta de éxito verde
        await expect(page.locator('.alert-success')).toBeVisible({ timeout: 5000 });
        await expect(page.locator('.alert-success')).toContainText('actualizado correctamente');
    });

    // ═══════════════════════════════════════════════════════════
    // TC-35: Verificar previsualización
    // ═══════════════════════════════════════════════════════════
    test('TC-35: Verificar previsualización', async ({ page }) => {
        await loginYPerfil(page);

        // 1. Verificar que el botón "Vista Previa" existe
        await expect(page.locator('#btnPreview')).toBeVisible();

        // 2. La preview card debe estar oculta inicialmente
        await expect(page.locator('#previewCard')).not.toHaveClass(/show/);

        // 3. Click en "Vista Previa"
        await page.click('#btnPreview');

        // 4. Verificar que la preview card se muestra
        await expect(page.locator('#previewCard')).toHaveClass(/show/);

        // 5. Verificar que muestra el nombre actual
        const nombre = await page.inputValue('#fNombre');
        const apellido = await page.inputValue('#fApellido');
        await expect(page.locator('#prevName')).toContainText(nombre);

        // 6. Verificar que la profesión se refleja
        const profesion = await page.inputValue('#fProfesion');
        if (profesion) {
            await expect(page.locator('#prevProf')).toContainText(profesion);
        }

        // 7. Modificar nombre y verificar que el preview se actualiza en tiempo real
        await page.fill('#fNombre', 'NuevoNombre');
        await page.locator('#fNombre').dispatchEvent('input');
        await expect(page.locator('#prevName')).toContainText('NuevoNombre');

        // 8. Click de nuevo para ocultar
        await page.click('#btnPreview');
        await expect(page.locator('#previewCard')).not.toHaveClass(/show/);
    });

    // ═══════════════════════════════════════════════════════════
    // TC-36: Verificar redundancia de red
    // ═══════════════════════════════════════════════════════════
    test('TC-36: Verificar redundancia de red (alerta de reintento)', async ({ page }) => {
        await loginYPerfil(page);

        // 1. Verificar que la alerta de reintento existe pero está oculta
        const alertRetry = page.locator('#alertRetry');
        await expect(alertRetry).toBeHidden();

        // 2. Verificar que el texto de la alerta es correcto
        await expect(alertRetry).toContainText('Error de conexión');
        await expect(alertRetry).toContainText('Reintentar');

        // 3. Simular error de red: interceptar petición POST a /perfil
        await page.route('**/perfil', async (route) => {
            if (route.request().method() === 'POST') {
                await route.abort('failed');
            } else {
                await route.continue();
            }
        });

        // 4. Llenar campos válidos
        const nombre = await page.inputValue('#fNombre');
        if (!nombre) await page.fill('#fNombre', 'Test');
        const apellido = await page.inputValue('#fApellido');
        if (!apellido) await page.fill('#fApellido', 'Test');
        const profesion = await page.inputValue('#fProfesion');
        if (!profesion) await page.fill('#fProfesion', 'Tester');
        const bio = await page.inputValue('#fBiografia');
        if (!bio) await page.fill('#fBiografia', 'Bio de prueba.');

        // 5. Intentar guardar — simular envío directo sin modal
        await page.evaluate(() => {
            submitPerfil();
        });

        // 6. Verificar que aparece la alerta de reintento
        await expect(alertRetry).toBeVisible({ timeout: 10000 });
    });

    // ═══════════════════════════════════════════════════════════
    // TC-37: Verificar la restricción de datos vacíos
    // ═══════════════════════════════════════════════════════════
    test('TC-37: Verificar la restricción de datos vacíos', async ({ page }) => {
        await loginYPerfil(page);

        // 1. Vaciar TODOS los campos incluyendo biografía
        await page.fill('#fNombre', '');
        await page.fill('#fApellido', '');
        await page.fill('#fProfesion', '');
        await page.fill('#fBiografia', '');

        // 2. Intentar guardar
        await page.click('#btnSave');

        // 3. Verificar que NO se abre el modal de confirmación
        await expect(page.locator('#modalGuardar')).not.toHaveClass(/show/);

        // 4. Verificar que todos los campos obligatorios muestran error
        await expect(page.locator('#errNombre')).toBeVisible();
        await expect(page.locator('#errApellido')).toBeVisible();
        await expect(page.locator('#errProfesion')).toBeVisible();

        // 5. La biografía vacía también muestra error (validateForm la requiere)
        await expect(page.locator('#errBiografia')).toBeVisible();
        await expect(page.locator('#errBiografia')).toContainText('vacía');

        // 6. Verificar espacios en blanco como vacío
        await page.fill('#fNombre', '   ');
        await page.click('#btnSave');
        await expect(page.locator('#errNombre')).toBeVisible();
    });

});
