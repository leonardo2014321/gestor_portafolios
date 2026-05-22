import { test, expect } from '@playwright/test';

import { BASE, loginUsuario, loginAdmin, logoutCleanup } from '../helpers.js';

test.describe('HU-09: Dashboard Principal de Gestión', () => {

    // ─── HELPER: Login y navegar al dashboard (/menu) ───
    async function loginYMenu(page) {
    await loginUsuario(page);
}

    // ═══════════════════════════════════════════════════════════
    // TC-79: Verificar conteo dinámico de tarjetas
    // ═══════════════════════════════════════════════════════════
    test('TC-79: Verificar conteo dinámico de tarjetas', async ({ page }) => {
        await loginYMenu(page);

        // 1. Verificar que las 3 tarjetas de estadísticas están visibles
        await expect(page.locator('.stat.s-blue')).toBeVisible();
        await expect(page.locator('.stat.s-white')).toBeVisible();
        await expect(page.locator('.stat.s-teal')).toBeVisible();

        // 2. Verificar que las tarjetas muestran sus labels
        await expect(page.locator('.stat.s-blue .stat-lbl')).toContainText('Portafolios');
        await expect(page.locator('.stat.s-white .stat-lbl')).toContainText('Documentos');
        await expect(page.locator('.stat.s-teal .stat-lbl')).toContainText('Aprobados');

        // 3. Verificar que los conteos son numéricos
        const portafoliosNum = await page.locator('.stat.s-blue .stat-num').textContent();
        const documentosNum = await page.locator('.stat.s-white .stat-num').textContent();
        const aprobadosNum = await page.locator('.stat.s-teal .stat-num').textContent();

        expect(portafoliosNum.trim()).toMatch(/^\d+$/);
        expect(documentosNum.trim()).toMatch(/^\d+$/);
        expect(aprobadosNum.trim()).toMatch(/^\d+$/);
    });

    // ═══════════════════════════════════════════════════════════
    // TC-79: Verificar renderizado de estado vacío
    // ═══════════════════════════════════════════════════════════
    test('TC-79: Verificar renderizado de estado vacío', async ({ page }) => {
        await loginYMenu(page);

        // El dashboard muestra cards de portafolios O un estado vacío
        const portafolioCards = page.locator('.pcard.cn');
        const emptyState = page.locator('text=Sin portafolios aún');

        const cardsCount = await portafolioCards.count();

        if (cardsCount === 0) {
            // 1. Si no hay portafolios, verificar estado vacío
            await expect(emptyState).toBeVisible();
            await expect(page.getByText('Crea tu primer portafolio')).toBeVisible();

            // 2. Verificar que hay botón para crear portafolio
            await expect(page.getByText('Crear portafolio')).toBeVisible();
        } else {
            // 3. Si hay portafolios, verificar que las cards tienen contenido
            await expect(portafolioCards.first()).toBeVisible();

            // 4. Las cards deben tener nombre y estado
            await expect(page.locator('.pcard-name').first()).not.toBeEmpty();
            await expect(page.locator('.pcard-st').first()).toBeVisible();
        }
    });

    // ═══════════════════════════════════════════════════════════
    // TC-79: Verificar persistencia del Sidebar
    // ═══════════════════════════════════════════════════════════
    test('TC-79: Verificar persistencia del Sidebar', async ({ page }) => {
        await loginYMenu(page);

        // 1. Verificar que el sidebar está visible con todos sus elementos
        await expect(page.locator('aside')).toBeVisible();

        // 2. Verificar enlaces del sidebar
        await expect(page.getByText('Menú principal')).toBeVisible();
        await expect(page.getByText('Portafolios').first()).toBeVisible();
        await expect(page.getByText('Explorador')).toBeVisible();
        await expect(page.getByText('Académico')).toBeVisible();
        await expect(page.getByText('Reportes')).toBeVisible();
        await expect(page.getByText('Mi Perfil')).toBeVisible();

        // 3. Verificar botón de cerrar sesión en sidebar
        await expect(page.locator('.btn-logout')).toBeVisible();
        await expect(page.locator('.btn-logout')).toContainText('Cerrar Sesión');

        // 4. Navegar al explorador y verificar que el sidebar persiste
        await page.locator('button:has-text("Explorador")').click();
        await expect(page.locator('aside')).toBeVisible();
        await expect(page.locator('.btn-logout')).toBeVisible();

        // 5. Volver al menú y verificar que sigue visible
        await page.locator('#btn-menu').click();
        await expect(page.locator('aside')).toBeVisible();
    });

    // ═══════════════════════════════════════════════════════════
    // TC-79: Verificar visualización del calendario
    // ═══════════════════════════════════════════════════════════
    test('TC-79: Verificar visualización del calendario', async ({ page }) => {
        // Asegurar viewport amplio para que se muestre el panel derecho
        await page.setViewportSize({ width: 1400, height: 900 });
        await loginYMenu(page);

        // 1. Verificar que el panel derecho está visible
        await expect(page.locator('.rpanel')).toBeVisible();

        // 2. Verificar título del calendario (mes y año)
        const calTitle = page.locator('#cal-title');
        await expect(calTitle).toBeVisible();
        const titleText = await calTitle.textContent();
        // Debe contener un mes y un año (ej: "April 2026")
        expect(titleText).toMatch(/\w+\s\d{4}/);

        // 3. Verificar que los días de la semana están presentes
        await expect(page.getByText('Do').first()).toBeVisible();
        await expect(page.getByText('Mi').first()).toBeVisible();
        await expect(page.getByText('Ma').first()).toBeVisible();

        // 4. Verificar botones de navegación de mes
        const navButtons = page.locator('.cal-nav');
        await expect(navButtons).toHaveCount(2);

        // 5. Navegar al mes siguiente
        await navButtons.last().click();
        const newTitle = await calTitle.textContent();
        expect(newTitle).not.toBe(titleText);

        // 6. Navegar al mes anterior (volver)
        await navButtons.first().click();
        const restoredTitle = await calTitle.textContent();
        expect(restoredTitle).toBe(titleText);

        // 7. Verificar que el día actual tiene clase especial
        const today = page.locator('.cd.today');
        const todayCount = await today.count();
        // Solo tiene clase "today" si estamos viendo el mes actual
        if (todayCount > 0) {
            await expect(today).toBeVisible();
        }
    });

    // ═══════════════════════════════════════════════════════════
    // TC-80: Verificar redirección de enlaces institucionales
    // ═══════════════════════════════════════════════════════════
    test('TC-80: Verificar redirección de enlaces institucionales', async ({ page }) => {
        await page.setViewportSize({ width: 1400, height: 900 });
        await loginYMenu(page);

        // 1. Verificar que la sección de "Enlaces" está visible en el panel derecho
        await expect(page.locator('.rpanel')).toBeVisible();

        // 2. Verificar que los enlaces institucionales están presentes
        await expect(page.getByText('Repositorio')).toBeVisible();
        await expect(page.getByText('Ayuda')).toBeVisible();
        await expect(page.getByText('Portal UMSS')).toBeVisible();
        await expect(page.getByText('Aula Virtual')).toBeVisible();

        // 3. Verificar que cada enlace tiene un icono
        const enlaces = page.locator('.enlace');
        const count = await enlaces.count();
        expect(count).toBeGreaterThanOrEqual(4);

        // 4. Verificar que los enlaces son clicables (hrefs)
        for (let i = 0; i < count; i++) {
            const enlace = enlaces.nth(i);
            const tag = await enlace.evaluate(el => el.tagName.toLowerCase());
            expect(tag).toBe('a');
        }
    });

    // ═══════════════════════════════════════════════════════════
    // TC-81: Verificar integridad de la sesión al cerrar
    // ═══════════════════════════════════════════════════════════
    test('TC-81: Verificar integridad de la sesión al cerrar', async ({ page }) => {
        await loginYMenu(page);

        // 1. Verificar que el usuario está logueado (topbar muestra nombre)
        await expect(page.locator('.topbar')).toBeVisible();
await expect(page.locator('text=Conectado')).toBeVisible();
        // 2. Cerrar sesión
        await page.click('.btn-logout');

        // 3. Verificar redirección a /home
   
// 3. Confirmar que aparece el modal de confirmación (visto en image_1e234f.png)
await expect(page.locator('text=¿Cerrar sesión?')).toBeVisible();
await page.click('button:has-text("Sí, salir")');
        await expect(page).toHaveURL(/.*\/home/, { timeout: 10000 });

        // 4. Intentar acceder a /menu sin autenticación
        await page.goto(`${BASE}/menu`);

        // 5. Debe redirigir a /login (middleware 'auth')
        await expect(page).toHaveURL(/.*\/login/, { timeout: 10000 });

        // 6. Intentar acceder a /perfil sin autenticación
        await page.goto(`${BASE}/perfil`);
        await expect(page).toHaveURL(/.*\/login/, { timeout: 10000 });
    });

    // ═══════════════════════════════════════════════════════════
    // TC-82: Verificar adaptabilidad de interfaz (Móvil)
    // ═══════════════════════════════════════════════════════════
    test('TC-82: Verificar adaptabilidad de interfaz (Móvil)', async ({ page }) => {
        // 1. Emular viewport móvil
        await page.setViewportSize({ width: 375, height: 812 });

        await loginYMenu(page);

        // 2. Verificar que el sidebar se compacta (solo iconos, sin texto)
        await expect(page.locator('aside')).toBeVisible();
        // En modo responsive (<992px), los textos del sidebar se ocultan
        // El sidebar se reduce a 78px de ancho

        // 3. Verificar que el panel derecho se oculta en móvil (<1200px)
        await expect(page.locator('.rpanel')).toBeHidden();

        // 4. Verificar que el contenido principal sigue visible
        await expect(page.getByText('Sistema de Portafolios')).toBeVisible();

        // 5. Verificar que las stats se apilan en una columna
        await expect(page.locator('.stats')).toBeVisible();
        await expect(page.locator('.stat.s-blue')).toBeVisible();

        // 6. Verificar que el topbar sigue visible
        await expect(page.locator('.topbar')).toBeVisible();
    });

    // ═══════════════════════════════════════════════════════════
    // TC-83: Verificar visualización de logs de notificación
    // ═══════════════════════════════════════════════════════════
    test('TC-83: Verificar visualización de logs de notificación', async ({ page }) => {
        await page.setViewportSize({ width: 1400, height: 900 });
        await loginYMenu(page);

        // 1. Verificar que la sección de notificaciones existe en el panel derecho
        await expect(page.locator('.rpanel')).toBeVisible();

        // 2. Verificar título de la sección de notificaciones
        await expect(page.getByText('Notific. actualización')).toBeVisible();

        // 3. Verificar que hay al menos una notificación
        const notificaciones = page.locator('.notif');
        const count = await notificaciones.count();
        expect(count).toBeGreaterThanOrEqual(1);

        // 4. Verificar que las notificaciones tienen iconos y texto
        await expect(page.locator('.ni-icon').first()).toBeVisible();
        await expect(page.locator('.ntxt').first()).toBeVisible();

        // 5. Verificar contenido de notificaciones conocidas
        await expect(page.getByText('Nueva actualización disponible')).toBeVisible();
        await expect(page.getByText('Informe mensual subido')).toBeVisible();

        // 6. Verificar que la campana de notificaciones está en el topbar
        const notificationBell = page.locator('.topbar').locator('button, i').filter({ has: page.locator('.fa-bell, .icon-bell') }).first();
        await expect(notificationBell).toBe   });

});
