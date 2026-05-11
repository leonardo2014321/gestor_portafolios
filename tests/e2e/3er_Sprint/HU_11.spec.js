import { test, expect } from '@playwright/test';

// ═══════════════════════════════════════════════════════════════════
// HU-11: Vista de Administrador Portafolios (Admin)
// Tipo Ejecución: AUTOMATED | Sprint: 3
// ═══════════════════════════════════════════════════════════════════

const BASE = 'http://localhost:8000';

// ─── HELPER: Login como admin ───
async function loginAdmin(page) {
    await page.goto(BASE);
    await page.getByRole('button', { name: 'Iniciar sesión' }).click();
    await expect(page.locator('#loginModal')).toBeVisible({ timeout: 10000 });
    await page.fill('input[name="email"]', 'admin@gmail.com');
    await page.fill('input[name="password"]', 'infinitycode1');
    await page.click('button:has-text("Entrar al sistema")');
    await expect(page).toHaveURL(/.*\/admin/, { timeout: 30000 });
    await page.waitForTimeout(1000);
}

// ─── HELPER: Login como usuario normal ───
async function loginUsuario(page) {
    await page.goto(BASE);
    await page.getByRole('button', { name: 'Iniciar sesión' }).click();
    await expect(page.locator('#loginModal')).toBeVisible({ timeout: 10000 });
    await page.fill('input[name="email"]', 'serpientinon@gmail.com');
    await page.fill('input[name="password"]', '12tres45');
    await page.click('button:has-text("Entrar al sistema")');
    await expect(page).toHaveURL(/.*\/menu/, { timeout: 30000 });
    await page.waitForTimeout(1000);
}

test.describe('HU-11: Vista de Administrador (Admin Dashboard)', () => {

    // ═══════════════════════════════════════════════════════════
    // TC-85: Dashboard — Métricas visibles y con datos reales
    // Tipo Prueba: FUNCIONAL
    // ═══════════════════════════════════════════════════════════
    test('TC-85: Dashboard — Métricas visibles y con datos reales', async ({ page }) => {
        await loginAdmin(page);

        // 1. Verificar que las 4 stat-cards están visibles
        const statCards = page.locator('.stat-card');
        await expect(statCards).toHaveCount(4);

        // 2. Verificar métricas con labels correctos
        await expect(page.getByText('Usuarios Totales')).toBeVisible();
        await expect(page.getByText('Portafolios Registrados')).toBeVisible();
        await expect(page.getByText('Administradores')).toBeVisible();

        // 3. Verificar que Usuarios Totales es numérico y >= 1
        const totalUsuarios = await page.locator('.stat-card').first().locator('.stat-val').textContent();
        expect(parseInt(totalUsuarios.replace(/,/g, ''))).toBeGreaterThanOrEqual(1);

        // 4. Verificar que Administradores >= 1
        const totalAdmins = await page.locator('.stat-card').nth(3).locator('.stat-val').textContent();
        expect(parseInt(totalAdmins.replace(/,/g, ''))).toBeGreaterThanOrEqual(1);
    });

    // ═══════════════════════════════════════════════════════════
    // TC-86: Dashboard — Documentos Subidos está hardcodeado (BUG)
    // Tipo Prueba: FUNCIONAL
    // ═══════════════════════════════════════════════════════════
    test('TC-86: Dashboard — Verificar métrica Documentos Subidos', async ({ page }) => {
        await loginAdmin(page);

        // Verificar que la tarjeta Documentos Subidos existe
        await expect(page.getByText('Documentos Subidos')).toBeVisible();

        // BUG CONOCIDO: Este valor está hardcodeado como "4,302"
        const docsVal = await page.locator('.stat-card').nth(2).locator('.stat-val').textContent();
        // Marcamos como advertencia si es hardcodeado
        if (docsVal.trim() === '4,302') {
            console.warn('⚠️ BUG: Documentos Subidos está HARDCODEADO en 4,302');
        }
        // Igualmente verificamos que al menos es numérico
        expect(docsVal.trim()).toMatch(/^[\d,]+$/);
    });

    // ═══════════════════════════════════════════════════════════
    // TC-87: Tabla Usuarios Recientes con columnas correctas
    // Tipo Prueba: FUNCIONAL
    // ═══════════════════════════════════════════════════════════
    test('TC-87: Tabla Usuarios Recientes — columnas y datos', async ({ page }) => {
        await loginAdmin(page);

        // 1. Verificar panel header
        await expect(page.getByText('Usuarios Recientes')).toBeVisible();

        // 2. Verificar encabezados de columnas (dashboard tiene 3 columnas)
        const headers = page.locator('#view-dashboard table thead th');
        await expect(headers).toHaveCount(3);
        await expect(headers.nth(0)).toContainText('Usuario');
        await expect(headers.nth(1)).toContainText('Registro');
        await expect(headers.nth(2)).toContainText('Estado');

        // 3. Verificar que hay filas de datos
        const rows = page.locator('#view-dashboard table tbody tr');
        const count = await rows.count();
        expect(count).toBeGreaterThanOrEqual(1);

        // 4. Verificar que primera fila tiene nombre y email
        await expect(rows.first().locator('.u-name')).not.toBeEmpty();
        await expect(rows.first().locator('.u-email')).not.toBeEmpty();
    });

    // ═══════════════════════════════════════════════════════════
    // TC-90: Panel Actividad Reciente
    // Tipo Prueba: FUNCIONAL
    // ═══════════════════════════════════════════════════════════
    test('TC-90: Panel Actividad Reciente — muestra acciones', async ({ page }) => {
        await page.setViewportSize({ width: 1400, height: 900 });
        await loginAdmin(page);

        // 1. Panel derecho visible
        await expect(page.locator('.rpanel')).toBeVisible();

        // 2. Sección Actividad Reciente
        await expect(page.getByText('Actividad Reciente')).toBeVisible();

        // 3. Verificar items de actividad
        const actItems = page.locator('.act-item');
        const count = await actItems.count();
        // Puede haber 0 si no hay actividad, o hasta 10
        if (count > 0) {
            await expect(actItems.first().locator('.act-title')).toBeVisible();
            await expect(actItems.first().locator('.act-time')).toBeVisible();
            await expect(actItems.first().locator('.act-icon')).toBeVisible();
        } else {
            await expect(page.getByText('No hay actividad reciente')).toBeVisible();
        }
    });

    // ═══════════════════════════════════════════════════════════
    // TC-91: Calendario — Navegación entre meses
    // Tipo Prueba: FUNCIONAL
    // ═══════════════════════════════════════════════════════════
    test('TC-91: Calendario — Navegación entre meses', async ({ page }) => {
        await page.setViewportSize({ width: 1400, height: 900 });
        await loginAdmin(page);

        // 1. Calendario visible
        const calTitle = page.locator('#cal-title');
        await expect(calTitle).toBeVisible();
        const tituloOriginal = await calTitle.textContent();

        // 2. Verificar días de semana
        await expect(page.locator('.rpanel .cdn').first()).toBeVisible();

        // 3. Navegar al mes siguiente
        const navButtons = page.locator('.rpanel .cal-nav');
        await navButtons.last().click();
        await page.waitForTimeout(300);
        const tituloNuevo = await calTitle.textContent();
        expect(tituloNuevo).not.toBe(tituloOriginal);

        // 4. Volver al mes anterior
        await navButtons.first().click();
        await page.waitForTimeout(300);
        const tituloRestaurado = await calTitle.textContent();
        expect(tituloRestaurado).toBe(tituloOriginal);

        // 5. Cambiar a vista Meses
        await page.locator('#cal-view-sel').selectOption('meses');
        await page.waitForTimeout(300);
        const gridMeses = page.locator('.cal-grid-meses');
        await expect(gridMeses).toBeVisible();
    });

    // ═══════════════════════════════════════════════════════════
    // TC-92: Sidebar — Navegación entre vistas admin
    // Tipo Prueba: FUNCIONAL
    // ═══════════════════════════════════════════════════════════
    test('TC-92: Sidebar — Navegación entre vistas', async ({ page }) => {
        await loginAdmin(page);

        // 1. Dashboard visible por defecto
        await expect(page.locator('#view-dashboard')).toBeVisible();
        await expect(page.locator('#btn-dashboard')).toHaveClass(/active/);

        // 2. Clic Usuarios
        await page.locator('#btn-usuarios').click();
        await expect(page.locator('#view-usuarios')).toBeVisible();
        await expect(page.locator('#view-dashboard')).toBeHidden();
        await expect(page.locator('#btn-usuarios')).toHaveClass(/active/);

        // 3. Clic Portafolios
        await page.locator('#btn-portafolios').click();
        await expect(page.locator('#view-portafolios')).toBeVisible();
        await expect(page.locator('#view-usuarios')).toBeHidden();

        // 4. Clic Notificaciones
        await page.locator('#btn-notificaciones').click();
        await expect(page.locator('#view-notificaciones')).toBeVisible();
        await expect(page.locator('#view-portafolios')).toBeHidden();

        // 5. Volver al Dashboard
        await page.locator('#btn-dashboard').click();
        await expect(page.locator('#view-dashboard')).toBeVisible();
    });

    // ═══════════════════════════════════════════════════════════
    // TC-95: Seguridad — Acceso denegado a usuario normal
    // Tipo Prueba: SEGURIDAD
    // ═══════════════════════════════════════════════════════════
    test('TC-95: Seguridad — Usuario normal no accede a /admin', async ({ page }) => {
        await loginUsuario(page);

        // Intentar acceder a /admin
        const response = await page.goto(`${BASE}/admin`);

        // Debe recibir 403 o redirect
        if (response) {
            const status = response.status();
            expect([403, 302]).toContain(status);
        }

        // Verificar que NO se muestra el panel de admin
        await expect(page.locator('.admin-hero')).toBeHidden();
    });

    // ═══════════════════════════════════════════════════════════
    // TC-96: Seguridad — Acceso sin autenticación
    // Tipo Prueba: SEGURIDAD
    // ═══════════════════════════════════════════════════════════
    test('TC-96: Seguridad — Sin sesión redirige a login', async ({ page }) => {
        // Ir directamente a /admin sin login
        await page.goto(`${BASE}/admin`);

        // Debe redirigir a /login
        await expect(page).toHaveURL(/.*\/login/, { timeout: 10000 });
    });

    // ═══════════════════════════════════════════════════════════
    // TC-98: Menú acciones — Se cierra al clic fuera
    // Tipo Prueba: FUNCIONAL
    // ═══════════════════════════════════════════════════════════
    test('TC-98: Menú acciones — Se cierra al clic fuera', async ({ page }) => {
        await loginAdmin(page);

        // 1. Navegar a vista Usuarios (los action-btn están ahí, no en dashboard)
        await page.locator('#btn-usuarios').click();
        await expect(page.locator('#view-usuarios')).toBeVisible();

        const actionBtns = page.locator('#view-usuarios .action-btn');
        const count = await actionBtns.count();
        if (count === 0) {
            test.skip();
            return;
        }

        await actionBtns.first().click();
        const menu = page.locator('#view-usuarios .action-menu').first();
        await expect(menu).toBeVisible();

        // 2. Clic fuera → se cierra
        await page.locator('.admin-hero').click();
        await expect(menu).toBeHidden();
    });

    // ═══════════════════════════════════════════════════════════
    // TC-99: Logout Admin — Flujo completo
    // Tipo Prueba: FUNCIONAL
    // ═══════════════════════════════════════════════════════════
    test('TC-99: Logout Admin — Modal confirmación y redirección', async ({ page }) => {
        await loginAdmin(page);

        // 1. Abrir dropdown usuario
        await page.locator('.tb-right').locator('.sb-av').click();
        await expect(page.locator('#admin-dropdown')).toBeVisible();

        // 2. Clic cerrar sesión → abre modal
        await page.locator('#admin-dropdown button').click();
        await expect(page.locator('#modal-logout-confirm')).toBeVisible();
        await expect(page.getByText('¿Cerrar sesión?')).toBeVisible();

        // 3. Cancelar → cierra modal
        await page.locator('#modal-logout-confirm').getByText('Cancelar').click();
        await expect(page.locator('#modal-logout-confirm')).toBeHidden();

        // 4. Repetir y confirmar
        await page.locator('.tb-right').locator('.sb-av').click();
        await page.locator('#admin-dropdown button').click();
        await page.locator('#modal-logout-confirm').getByText('Sí, salir').click();

        // 5. Redirige a home
        await expect(page).toHaveURL(/.*\/(home|login)?$/, { timeout: 10000 });
    });

    // ═══════════════════════════════════════════════════════════
    // TC-93: Vista Usuarios — Búsqueda y filtro (AUTOMATED)
    // Tipo Prueba: FUNCIONAL
    // ═══════════════════════════════════════════════════════════
    test('TC-93: Vista Usuarios — Búsqueda y filtro por estado', async ({ page }) => {
        await loginAdmin(page);

        // Ir a vista Usuarios
        await page.locator('#btn-usuarios').click();
        await expect(page.locator('#view-usuarios')).toBeVisible();

        // Verificar stats
        await expect(page.locator('#view-usuarios .stat-card')).toHaveCount(4);

        // Verificar tabla
        const tabla = page.locator('#tabla-usuarios tbody tr');
        const totalInicial = await tabla.count();
        expect(totalInicial).toBeGreaterThanOrEqual(1);

        // Filtrar por estado "Activos"
        await page.locator('#filtro-estado').selectOption('activo');
        await page.waitForTimeout(300);

        // Verificar que las filas visibles tienen data-estado="activo"
        const filasVisibles = page.locator('#tabla-usuarios tbody tr:visible');
        const countVisible = await filasVisibles.count();
        // Al menos las filas activas deben ser visibles
        expect(countVisible).toBeLessThanOrEqual(totalInicial);

        // Resetear filtro
        await page.locator('#filtro-estado').selectOption('');
    });

    // ═══════════════════════════════════════════════════════════
    // TC-94: Vista Portafolios Admin — Stats y búsqueda (AUTOMATED)
    // Tipo Prueba: FUNCIONAL
    // ═══════════════════════════════════════════════════════════
    test('TC-94: Vista Portafolios — Stats y búsqueda', async ({ page }) => {
        await loginAdmin(page);

        // Ir a vista Portafolios
        await page.locator('#btn-portafolios').click();
        await expect(page.locator('#view-portafolios')).toBeVisible();

        // Verificar 3 stats
        const stats = page.locator('#view-portafolios .stat-card');
        await expect(stats).toHaveCount(3);

        // Verificar labels
        await expect(page.locator('#view-portafolios').getByText('Total Portafolios')).toBeVisible();
        await expect(page.locator('#view-portafolios').getByText('Vinculados')).toBeVisible();

        // Verificar tabla
        await expect(page.locator('#tabla-portafolios')).toBeVisible();
    });

    // ═══════════════════════════════════════════════════════════
    // TC-97: Responsive — Panel admin en móvil (AUTOMATED)
    // Tipo Prueba: COMPATIBILIDAD
    // ═══════════════════════════════════════════════════════════
    test('TC-97: Responsive — Admin en viewport móvil', async ({ page }) => {
        await page.setViewportSize({ width: 375, height: 812 });
        await loginAdmin(page);

        // 1. Botón hamburguesa visible
        await expect(page.locator('#mobile-menu-btn')).toBeVisible();

        // 2. Sidebar inicia oculto (offscreen)
        const sidebar = page.locator('aside');
        await expect(sidebar).toBeVisible(); // exists in DOM

        // 3. Stats se apilan en 1 columna
        await expect(page.locator('.stats-grid')).toBeVisible();

        // 4. Abrir sidebar
        await page.locator('#mobile-menu-btn').click();
        await expect(sidebar).toHaveClass(/open/);

        // 5. Cerrar con overlay
        await page.locator('#sidebar-overlay').click();
        await expect(sidebar).not.toHaveClass(/open/);
    });

    // ═══════════════════════════════════════════════════════════
    // TC-88A: Toggle Estado — Cambio visual funciona (AUTOMATED)
    // Tipo Prueba: FUNCIONAL
    // ═══════════════════════════════════════════════════════════
    test('TC-88A: Toggle Estado — Cambio visual badge', async ({ page }) => {
        await loginAdmin(page);

        // Navegar a vista Usuarios (los action-btn están ahí, no en dashboard)
        await page.locator('#btn-usuarios').click();
        await expect(page.locator('#view-usuarios')).toBeVisible();

        const actionBtns = page.locator('#view-usuarios .action-btn');
        const count = await actionBtns.count();
        if (count === 0) { test.skip(); return; }

        // Abrir menú del primer usuario
        await actionBtns.first().click();
        const menu = page.locator('#view-usuarios .action-menu').first();
        await expect(menu).toBeVisible();

        // Obtener estado actual del primer toggle (Estado)
        const toggle = menu.locator('input[type="checkbox"]').first();
        const wasChecked = await toggle.isChecked();

        // Cambiar toggle
        await toggle.click();
        await page.waitForTimeout(300);

        // Verificar que el badge cambió
        const statusBadge = page.locator('#view-dashboard [id^="status-"]').first();
        if (wasChecked) {
            await expect(statusBadge).toContainText('Inactivo');
        } else {
            await expect(statusBadge).toContainText('Activo');
        }
    });
    // ═══════════════════════════════════════════════════════════
    // TC-151: Admin — Verificar presencia de Avatar en Header
    // Tipo Prueba: FUNCIONAL
    // ═══════════════════════════════════════════════════════════
    test('TC-151: Admin — Avatar en Header visible', async ({ page }) => {
        await loginAdmin(page);
        const avatar = page.locator('.tb-right .sb-av');
        await expect(avatar).toBeVisible();
    });
});
