import { test, expect } from '@playwright/test';

const BASE = 'http://localhost:8000';

test.describe('HU-03: Autentificar Usuario', () => {

    // ─── HELPER: Abrir modal de login desde la landing ───
    async function abrirModalLogin(page) {
        await page.goto(BASE);
        await page.locator('#openLoginModal').click();
        await expect(page.locator('#loginModal')).toBeVisible();
    }

    // ═══════════════════════════════════════════════════════════
    // TC-8: Login exitoso con credenciales válidas
    // ═══════════════════════════════════════════════════════════
    test('TC-8: Login exitoso con credenciales válidas', async ({ page }) => {
        await abrirModalLogin(page);

        // 1. Llenar email y contraseña válidos
        await page.fill('input[name="email"]', 'serpientinon@gmail.com');
        await page.fill('input[name="password"]', '12tres45');

        // 2. Click en "Entrar al sistema"
        await page.click('button:has-text("Entrar al sistema")');

        // 3. Verificar redirección al menú principal (/menu)
        await expect(page).toHaveURL(/.*\/menu/, { timeout: 10000 });

        // 4. Verificar que se muestra el panel del sistema
        await expect(page.locator('.topbar')).toBeVisible();
        await expect(page.getByText('Sistema de Portafolios')).toBeVisible();
    });

    // ═══════════════════════════════════════════════════════════
    // TC-9: Login con email no registrado
    // ═══════════════════════════════════════════════════════════
    test('TC-9: Login con email no registrado', async ({ page }) => {
        await abrirModalLogin(page);

        // 1. Usar email que no existe
        await page.fill('input[name="email"]', 'noexiste99999@gmail.com');
        await page.fill('input[name="password"]', 'CualquierPass1');

        // 2. Enviar formulario
        await page.click('button:has-text("Entrar al sistema")');

        // 3. Verificar mensaje de error "Correo incorrecto."
        await expect(page.locator('.text-rose-500')).toBeVisible({ timeout: 10000 });
        await expect(page.locator('.text-rose-500').first()).toContainText('Correo incorrecto');
    });

    // ═══════════════════════════════════════════════════════════
    // TC-10: Login con contraseña incorrecta
    // ═══════════════════════════════════════════════════════════
    test('TC-10: Login con contraseña incorrecta', async ({ page }) => {
        await abrirModalLogin(page);

        // 1. Email correcto pero contraseña incorrecta
        await page.fill('input[name="email"]', 'serpientinon@gmail.com');
        await page.fill('input[name="password"]', 'ContraseñaMala99');

        // 2. Enviar formulario
        await page.click('button:has-text("Entrar al sistema")');

        // 3. Verificar mensaje de error "Contraseña incorrecta."
        await expect(page.locator('.text-rose-500')).toBeVisible({ timeout: 10000 });
        await expect(page.locator('.text-rose-500').first()).toContainText(/Contraseña incorrecta/);
    });

    // ═══════════════════════════════════════════════════════════
    // TC-11: Login con campos vacíos
    // ═══════════════════════════════════════════════════════════
    test('TC-11: Login con campos vacíos', async ({ page }) => {
        await abrirModalLogin(page);

        // 1. Dejar campos vacíos y hacer clic en enviar
        // Los inputs tienen 'required', así que el navegador bloquea el submit
        await page.click('button:has-text("Entrar al sistema")');

        // 2. Verificar que seguimos en la misma página (no hubo navegación)
        await expect(page).toHaveURL(BASE);

        // 3. Verificar que el modal de login sigue visible
        await expect(page.locator('#loginModal')).toBeVisible();

        // 4. Verificar que los inputs tienen el atributo required
        await expect(page.locator('#loginModal input[name="email"]')).toHaveAttribute('required', '');
        await expect(page.locator('#loginModal input[name="password"]')).toHaveAttribute('required', '');
    });

    // ═══════════════════════════════════════════════════════════
    // TC-12: Logout exitoso desde sidebar y topbar
    // ═══════════════════════════════════════════════════════════
    test('TC-12: Logout exitoso desde sidebar', async ({ page }) => {
        // 1. Primero hacer login
        await abrirModalLogin(page);
        await page.fill('input[name="email"]', 'serpientinon@gmail.com');
        await page.fill('input[name="password"]', '12tres45');
        await page.click('button:has-text("Entrar al sistema")');
        await expect(page).toHaveURL(/.*\/menu/, { timeout: 10000 });

        // 2. Click en "Cerrar Sesión" del sidebar
        await page.click('.btn-logout');

        // 3. Verificar redirección a /home
        await expect(page).toHaveURL(/.*\/home/, { timeout: 10000 });
    });

    // ═══════════════════════════════════════════════════════════
    // TC-13: Acceso a ruta protegida sin autenticación
    // ═══════════════════════════════════════════════════════════
    test('TC-13: Acceso a ruta protegida sin autenticación', async ({ page }) => {
        // 1. Intentar acceder directamente a /menu sin estar logueado
        await page.goto(`${BASE}/menu`);

        // 2. Verificar que redirige a /login (middleware 'auth')
        await expect(page).toHaveURL(/.*\/login/, { timeout: 10000 });
    });

    // ═══════════════════════════════════════════════════════════
    // TC-14: Logout redirige a /home (no a /login)
    // ═══════════════════════════════════════════════════════════
    test('TC-14: Logout redirige a /home (no a /login)', async ({ page }) => {
        // 1. Login
        await abrirModalLogin(page);
        await page.fill('input[name="email"]', 'serpientinon@gmail.com');
        await page.fill('input[name="password"]', '12tres45');
        await page.click('button:has-text("Entrar al sistema")');
        await expect(page).toHaveURL(/.*\/menu/, { timeout: 10000 });

        // 2. Logout
        await page.click('.btn-logout');

        // 3. Verificar que redirige específicamente a /home y NO a /login
        await expect(page).toHaveURL(/.*\/home/, { timeout: 10000 });
        await expect(page).not.toHaveURL(/.*\/login/);
    });

    // ═══════════════════════════════════════════════════════════
    // TC-15: Elementos visuales del formulario de Login
    // ═══════════════════════════════════════════════════════════
    test('TC-15: Elementos visuales del formulario de Login', async ({ page }) => {
        await abrirModalLogin(page);

        // 1. Verificar título "Bienvenido de nuevo"
        await expect(page.getByText('Bienvenido de nuevo')).toBeVisible();

        // 2. Verificar subtítulo
        await expect(page.getByText('Inicia sesión para gestionar tu portafolio')).toBeVisible();

        // 3. Verificar labels
        await expect(page.getByText('CORREO ELECTRÓNICO').first()).toBeVisible();
        await expect(page.getByText('CONTRASEÑA').first()).toBeVisible();

        // 4. Verificar placeholders
        await expect(page.getByPlaceholder('ejemplo@gmail.com')).toBeVisible();
        await expect(page.getByPlaceholder('••••••••••••')).toBeVisible();

        // 5. Verificar checkbox "Recordar sesión"
        await expect(page.getByText('Recordar sesión')).toBeVisible();

        // 6. Verificar enlace "¿Olvidaste tu contraseña?"
        await expect(page.getByText('¿Olvidaste tu contraseña?')).toBeVisible();

        // 7. Verificar botón "Entrar al sistema"
        await expect(page.getByRole('button', { name: /entrar al sistema/i })).toBeVisible();

        // 8. Verificar botón "Continuar con Google"
        await expect(page.getByText('Continuar con Google')).toBeVisible();

        // 9. Verificar enlace "Regístrate"
        await expect(page.getByText('¿No tienes cuenta?')).toBeVisible();
        await expect(page.getByRole('button', { name: 'Regístrate' })).toBeVisible();
    });

    // ═══════════════════════════════════════════════════════════
    // TC-16: Diseño responsive del Login (móvil)
    // ═══════════════════════════════════════════════════════════
    test('TC-16: Diseño responsive del Login (móvil)', async ({ page }) => {
        // 1. Emular viewport móvil
        await page.setViewportSize({ width: 375, height: 812 });

        await page.goto(BASE);

        // 2. En móvil, el menú de escritorio está oculto y se muestra el hamburguesa
        await expect(page.locator('.sm\\:hidden').first()).toBeVisible();

        // 3. Abrir menú móvil (hamburguesa)
        await page.locator('button[aria-label="Abrir menú"]').click();

        // 4. Click en "Iniciar Sesión" del menú móvil
        await page.locator('#openLoginModalMobile').click();

        // 5. Verificar que el modal de login se muestra correctamente
        await expect(page.locator('#loginModal')).toBeVisible();

        // 6. Verificar que el formulario se adapta al viewport
        await expect(page.getByPlaceholder('ejemplo@gmail.com')).toBeVisible();
        await expect(page.getByRole('button', { name: /entrar al sistema/i })).toBeVisible();
    });

    // ═══════════════════════════════════════════════════════════
    // TC-17: Visualización de mensaje de error tras login fallido
    // ═══════════════════════════════════════════════════════════
    test('TC-17: Visualización de mensaje de error tras login fallido', async ({ page }) => {
        await abrirModalLogin(page);

        // 1. Enviar credenciales incorrectas
        await page.fill('input[name="email"]', 'noexiste@gmail.com');
        await page.fill('input[name="password"]', 'WrongPass123');
        await page.click('button:has-text("Entrar al sistema")');

        // 2. La página se recarga mostrando el login con errores
        // El login modal se abre automáticamente cuando hay errores (@if ($errors->any()))
        await page.waitForLoadState('networkidle');

        // 3. Verificar que el mensaje de error está visible con estilo rojo (rose-500)
        await expect(page.locator('.text-rose-500').first()).toBeVisible({ timeout: 10000 });

        // 4. Verificar que el input de email tiene borde rojo (border-rose-500)
        // El email incorrecto produce un error visual en el campo
        const emailContainer = page.locator('#loginModal .border-rose-500').first();
        await expect(emailContainer).toBeVisible();
    });

});
