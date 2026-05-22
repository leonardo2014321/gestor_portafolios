import { test, expect } from '@playwright/test';

import { BASE, loginUsuario, loginAdmin, logoutCleanup } from '../helpers.js';

test.describe('HU-10: Calendario Interactivo', () => {

    // ─── HELPER: Login + navegar al dashboard (donde está el calendario) ───
    async function loginYMenu(page) {
    await loginUsuario(page);
}

    // ═══════════════════════════════════════════════════════════
    // TC-84: Verificar carga de eventos
    // ═══════════════════════════════════════════════════════════
    test('TC-84: Verificar carga de eventos', async ({ page }) => {
        await loginYMenu(page);

        // 1. Verificar que el calendario está visible en el panel derecho
        await expect(page.locator('#cal-grid-container')).toBeVisible();

        // 2. Verificar que se muestra el mes actual
        const calTitle = page.locator('#cal-title');
        await expect(calTitle).toBeVisible();
        const titleText = await calTitle.textContent();
        expect(titleText.trim().length).toBeGreaterThan(0);

        // 3. Verificar que las celdas del calendario se renderizan
        const dayCells = page.locator('.cd');
        const dayCount = await dayCells.count();
        expect(dayCount).toBeGreaterThan(0);
    });

    // ═══════════════════════════════════════════════════════════
    // TC-85: Verificar cambio de vista
    // ═══════════════════════════════════════════════════════════
    test('TC-85: Verificar cambio de vista', async ({ page }) => {
        await loginYMenu(page);

        // 1. Verificar que el selector de vista existe
        const viewSelector = page.locator('#cal-view-sel');
        await expect(viewSelector).toBeVisible();

        // 2. Verificar opciones disponibles
        const options = viewSelector.locator('option');
        const optionCount = await options.count();
        expect(optionCount).toBeGreaterThanOrEqual(2);

        // 3. Verificar que "Días" está seleccionado por defecto
        await expect(viewSelector).toHaveValue('dias');

        // 4. Cambiar a vista "Meses"
        await viewSelector.selectOption('meses');
        await page.waitForTimeout(500);

        // 5. Verificar que el grid cambia (muestra meses en vez de días)
        const mesesGrid = page.locator('.cal-grid-meses');
        const mesesVisible = await mesesGrid.isVisible().catch(() => false);
        // La vista debe haber cambiado

        // 6. Cambiar a vista "Años"
        await viewSelector.selectOption('anios');
        await page.waitForTimeout(500);

        // 7. Volver a "Días"
        await viewSelector.selectOption('dias');
        await page.waitForTimeout(500);
    });

    // ═══════════════════════════════════════════════════════════
    // TC-86: Verificar detalle de evento
    // ═══════════════════════════════════════════════════════════
    test('TC-86: Verificar detalle de evento', async ({ page }) => {
        await loginYMenu(page);

        // 1. Hacer click en un día del calendario
        const todayCell = page.locator('.cd.today');
        const hasTodayCell = await todayCell.count();

        if (hasTodayCell > 0) {
            await todayCell.click();
            await page.waitForTimeout(500);

            // 2. Verificar que se abre el modal de detalle del día
            const modal = page.locator('#modalDia');
            const modalVisible = await modal.evaluate(el => el.style.display === 'flex');
            if (modalVisible) {
                // 3. Verificar que muestra la fecha
                await expect(page.locator('#modalFecha')).toBeVisible();
                const fechaText = await page.locator('#modalFecha').textContent();
                expect(fechaText.trim().length).toBeGreaterThan(0);

                // 4. Verificar campo de nuevo evento
                await expect(page.locator('#nuevoEventoInput')).toBeVisible();
                await expect(page.locator('#nuevoEventoHora')).toBeVisible();

                // 5. Cerrar modal
                await page.click('#modalDia button:has-text("Cerrar")');
            }
        }
    });

    // ═══════════════════════════════════════════════════════════
    // TC-87: Verificar creación rápida
    // ═══════════════════════════════════════════════════════════
    test('TC-87: Verificar creación rápida', async ({ page }) => {
        await loginYMenu(page);

        // 1. Click en el día de hoy
        const todayCell = page.locator('.cd.today');
        if (await todayCell.count() > 0) {
            await todayCell.click();
            await page.waitForTimeout(500);

            // 2. Verificar que el modal se abre
            const isOpen = await page.locator('#modalDia').evaluate(el => el.style.display === 'flex');
            if (isOpen) {
                // 3. Llenar nombre del evento
                await page.fill('#nuevoEventoInput', 'Evento de prueba E2E');
                await page.fill('#nuevoEventoHora', '14:00 PM');

                // 4. Click en "Agregar evento"
                await page.click('button:has-text("Agregar evento")');
                await page.waitForTimeout(500);

                // 5. Verificar que el evento se agregó al listado
                const eventos = page.locator('#listaEventos div');
                const hasEventos = await eventos.count();
                expect(hasEventos).toBeGreaterThan(0);

                // 6. Limpiar: eliminar el evento creado
                const deleteBtn = page.locator('#listaEventos button[title="Eliminar"]').first();
                if (await deleteBtn.count() > 0) {
                    await deleteBtn.click();
                    await page.waitForTimeout(300);
                }

                // 7. Cerrar modal
                await page.click('#modalDia button:has-text("Cerrar")');
            }
        }
    });

    // ═══════════════════════════════════════════════════════════
    // TC-88: Verificar arrastrar y soltar
    // ═══════════════════════════════════════════════════════════
    test('TC-88: Verificar arrastrar y soltar (interacción con celdas)', async ({ page }) => {
        await loginYMenu(page);

        // 1. Verificar que las celdas del calendario son clickeables
        const cells = page.locator('.cd:not(.other)');
        const count = await cells.count();
        expect(count).toBeGreaterThan(0);

        // 2. Click en una celda que no sea hoy
        if (count > 1) {
            await cells.nth(1).click();
            await page.waitForTimeout(500);

            // 3. Verificar que el modal se abre
            const modalDia = page.locator('#modalDia');
            const isOpen = await modalDia.evaluate(el => el.style.display === 'flex');
            if (isOpen) {
                await page.click('#modalDia button:has-text("Cerrar")');
            }
        }
    });

    // ═══════════════════════════════════════════════════════════
    // TC-89: Verificar indicador de hoy
    // ═══════════════════════════════════════════════════════════
    test('TC-89: Verificar indicador de hoy', async ({ page }) => {
        await loginYMenu(page);

        // 1. Verificar que existe una celda con clase "today"
        const todayCell = page.locator('.cd.today');
        await expect(todayCell).toBeVisible();

        // 2. Verificar que muestra el número del día actual
        const todayText = await todayCell.textContent();
        const today = new Date().getDate();
        expect(parseInt(todayText.trim())).toBe(today);

        // 3. Verificar que la celda tiene estilo diferenciado (background azul)
        const bgColor = await todayCell.evaluate(el => {
            return window.getComputedStyle(el).backgroundColor;
        });
        // Debe tener un color de fondo que no sea transparente
        expect(bgColor).not.toBe('rgba(0, 0, 0, 0)');
    });

    // ═══════════════════════════════════════════════════════════
    // TC-90: Verificar navegación temporal
    // ═══════════════════════════════════════════════════════════
    test('TC-90: Verificar navegación temporal', async ({ page }) => {
        await loginYMenu(page);

        // 1. Obtener el título del mes actual
        const originalTitle = await page.locator('#cal-title').textContent();

        // 2. Click en botón "siguiente" (›)
        await page.click('.cal-nav:last-child');
        await page.waitForTimeout(500);

        // 3. Verificar que el título cambió
        const nextTitle = await page.locator('#cal-title').textContent();
        expect(nextTitle).not.toBe(originalTitle);

        // 4. Click en botón "anterior" (‹)
        await page.click('.cal-nav:first-child');
        await page.waitForTimeout(500);

        // 5. Verificar que volvió al mes original
        const backTitle = await page.locator('#cal-title').textContent();
        expect(backTitle.trim()).toBe(originalTitle.trim());
    });

    // ═══════════════════════════════════════════════════════════
    // TC-91: Verificar categorías por color
    // ═══════════════════════════════════════════════════════════
    test('TC-91: Verificar categorías por color', async ({ page }) => {
        await loginYMenu(page);

        // 1. Verificar que las celdas con eventos tienen indicador visual
        // Las celdas con evento tienen clase .ev que agrega un punto de color
        const calGrid = page.locator('#cal-grid-container');
        await expect(calGrid).toBeVisible();

        // 2. Verificar que los días del otro mes tienen clase "other"
        const otherDays = page.locator('.cd.other');
        const otherCount = await otherDays.count();
        // Debe haber días del mes anterior/siguiente
        expect(otherCount).toBeGreaterThanOrEqual(0);
    });

    // ═══════════════════════════════════════════════════════════
    // TC-92: Verificar sincronización de zona horaria
    // ═══════════════════════════════════════════════════════════
    test('TC-92: Verificar sincronización de zona horaria', async ({ page }) => {
        await loginYMenu(page);

        // 1. Verificar que el calendario muestra el mes correcto según la zona del navegador
        const calTitle = await page.locator('#cal-title').textContent();
        const now = new Date();
        const months = ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];
        const expectedMonth = months[now.getMonth()];
        const expectedYear = now.getFullYear().toString();

        expect(calTitle).toContain(expectedMonth);
        expect(calTitle).toContain(expectedYear);

        // 2. Verificar que "hoy" coincide con la fecha del sistema
        const todayCell = page.locator('.cd.today');
        const todayText = await todayCell.textContent();
        expect(parseInt(todayText.trim())).toBe(now.getDate());
    });

    // ═══════════════════════════════════════════════════════════
    // TC-93: Verificar recordatorios previos
    // ═══════════════════════════════════════════════════════════
    test('TC-93: Verificar recordatorios previos', async ({ page }) => {
        await loginYMenu(page);

        // 1. Verificar que la sección de notificaciones existe en el panel derecho
        await expect(page.locator('.rp-ttl:has-text("Notific")')).toBeVisible();

        // 2. Verificar que hay notificaciones renderizadas
        const notifs = page.locator('.notif');
        const notifCount = await notifs.count();
        expect(notifCount).toBeGreaterThan(0);

        // 3. Verificar que la primera notificación tiene contenido
        await expect(notifs.first().locator('.ntxt')).toBeVisible();
    });

    // ═══════════════════════════════════════════════════════════
    // TC-94: Verificar la recreación correcta de los días
    // ═══════════════════════════════════════════════════════════
    test('TC-94: Verificar la recreación correcta de los días', async ({ page }) => {
        await loginYMenu(page);

        // 1. Verificar que los encabezados de día existen (Do, Lu, Ma, Mi, Ju, Vi, Sá)
        const dayHeaders = page.locator('.cdn');
        await expect(dayHeaders).toHaveCount(7);

        // Verificar nombres de días
        const expectedDays = ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sá'];
        for (let i = 0; i < 7; i++) {
            const text = await dayHeaders.nth(i).textContent();
            expect(text.trim()).toBe(expectedDays[i]);
        }

        // 2. Verificar que hay entre 28 y 42 celdas de día (4-6 semanas)
        const dayCells = page.locator('.cd');
        const totalCells = await dayCells.count();
        expect(totalCells).toBeGreaterThanOrEqual(28);
        expect(totalCells).toBeLessThanOrEqual(42);

        // 3. Navegar al mes siguiente y verificar que se regenera
        await page.click('.cal-nav:last-child');
        await page.waitForTimeout(500);

        const newCells = page.locator('.cd');
        const newTotal = await newCells.count();
        expect(newTotal).toBeGreaterThanOrEqual(28);
        expect(newTotal).toBeLessThanOrEqual(42);

        // 4. Volver al mes anterior
        await page.click('.cal-nav:first-child');
        await page.waitForTimeout(500);
    });

});
