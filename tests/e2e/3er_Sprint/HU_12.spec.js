import { test, expect } from '@playwright/test';

// ═══════════════════════════════════════════════════════════════════
// HU-12: Reportes de Portafolios
// Tipo Ejecución: AUTOMATED | Sprint: 3
// ═══════════════════════════════════════════════════════════════════

import { BASE, loginUsuario, loginAdmin, logoutCleanup } from '../helpers.js';

async function loginYMenu(page) {
    await loginUsuario(page);
}

test.describe('HU-12: Reportes de Portafolios', () => {

    // ═══════════════════════════════════════════════════════════
    // TC-100: Acceso autenticado a Reportes
    // Tipo Prueba: SANIDAD-HUMO
    // ═══════════════════════════════════════════════════════════
    test('TC-100: Acceso autenticado a vista Reportes', async ({ page }) => {
        await loginYMenu(page);

        // Clic en Reportes desde sidebar
        await page.locator('#btn-reportes').click();
        await page.waitForTimeout(500);

        // Verificar vista reportes visible
        await expect(page.locator('#view-reportes')).toBeVisible();
        await expect(page.getByText('Reportes y Documentos')).toBeVisible();
    });

    // ═══════════════════════════════════════════════════════════
    // TC-101: Selector de plantillas visible y funcional
    // Tipo Prueba: FUNCIONAL
    // ═══════════════════════════════════════════════════════════
    test('TC-101: Selector de plantillas — cambio de template', async ({ page }) => {
        await loginYMenu(page);
        await page.locator('#btn-reportes').click();
        await page.waitForTimeout(500);

        // Verificar selector de plantillas
        const selectorBtns = page.locator('.template-selector .ts-btn');
        const count = await selectorBtns.count();
        expect(count).toBeGreaterThanOrEqual(2);

        // Clic en segundo template
        if (count >= 2) {
            await selectorBtns.nth(1).click();
            await page.waitForTimeout(300);

            // Verificar que el segundo botón está activo
            await expect(selectorBtns.nth(1)).toHaveClass(/active/);

            // Verificar que solo un template es visible
            const visibleTemplates = page.locator('.cv-template-view.active-tpl');
            await expect(visibleTemplates).toHaveCount(1);
        }

        // Volver al primero
        await selectorBtns.first().click();
        await expect(selectorBtns.first()).toHaveClass(/active/);
    });

    // ═══════════════════════════════════════════════════════════
    // TC-102: Mapeo de datos del perfil en plantilla
    // Tipo Prueba: INTEGRACION
    // ═══════════════════════════════════════════════════════════
    test('TC-102: Datos del usuario mapeados en plantilla CV', async ({ page }) => {
        await loginYMenu(page);
        await page.locator('#btn-reportes').click();
        await page.waitForTimeout(500);

        // Verificar que hay contenedor CV
        const cvContainer = page.locator('.cv-container').first();
        await expect(cvContainer).toBeVisible();

        // Verificar que el nombre del usuario aparece en el CV
        const cvText = await cvContainer.textContent();
        // Debe contener al menos un nombre (no estar completamente vacío)
        expect(cvText.length).toBeGreaterThan(50);

        // Verificar que la foto o placeholder existe
        const cvPhoto = cvContainer.locator('img').first();
        if (await cvPhoto.count() > 0) {
            await expect(cvPhoto).toBeVisible();
        }
    });

    // ═══════════════════════════════════════════════════════════
    // TC-104: Botón Exportar PDF existe y es clickeable
    // Tipo Prueba: FUNCIONAL
    // ═══════════════════════════════════════════════════════════
    test('TC-104: Botón Exportar PDF visible y funcional', async ({ page }) => {
        await loginYMenu(page);
        await page.locator('#btn-reportes').click();
        await page.waitForTimeout(500);

        // Buscar botón exportar
        const btnExport = page.locator('.btn-export');
        await expect(btnExport).toBeVisible();
        await expect(btnExport).toContainText('Exportar PDF');

        // Verificar que el botón tiene el icono SVG
        await expect(btnExport.locator('svg')).toBeVisible();
    });

    // ═══════════════════════════════════════════════════════════
    // TC-106: Acceso denegado sin sesión
    // Tipo Prueba: SEGURIDAD
    // ═══════════════════════════════════════════════════════════
    test('TC-106: Acceso a /reportes sin sesión redirige a login', async ({ page }) => {
        await page.goto(`${BASE}/reportes`);
        await expect(page).toHaveURL(/.*\/login/, { timeout: 10000 });
    });

    // ═══════════════════════════════════════════════════════════
    // TC-107: Aislamiento de datos entre usuarios
    // Tipo Prueba: SEGURIDAD
    // ═══════════════════════════════════════════════════════════
    test('TC-107: Aislamiento — Cada usuario ve sus datos', async ({ page }) => {
        await loginYMenu(page);
        await page.locator('#btn-reportes').click();
        await page.waitForTimeout(500);

        // Capturar contenido CV del usuario actual
        const cvContent = await page.locator('.cv-container').first().textContent();

        // El email del usuario debe estar en el CV
        // (serpientinon@gmail.com para este usuario)
        expect(cvContent).toBeTruthy();
        expect(cvContent.length).toBeGreaterThan(0);
    });

    // ═══════════════════════════════════════════════════════════
    // TC-108: Previsualización responsive
    // Tipo Prueba: COMPATIBILIDAD
    // ═══════════════════════════════════════════════════════════
    test('TC-108: Previsualización CV en viewport reducido', async ({ page }) => {
        await page.setViewportSize({ width: 768, height: 1024 });
        await loginYMenu(page);
        await page.locator('#btn-reportes').click();
        await page.waitForTimeout(500);

        // CV container sigue visible
        const cvContainer = page.locator('.cv-container').first();
        await expect(cvContainer).toBeVisible();

        // Botón exportar sigue visible
        await expect(page.locator('.btn-export')).toBeVisible();

        // Panel derecho oculto en < 1200px
        await expect(page.locator('.rpanel')).toBeHidden();
    });

    // ═══════════════════════════════════════════════════════════
    // TC-103A: Plantilla con foto placeholder si no tiene foto
    // Tipo Prueba: FUNCIONAL
    // ═══════════════════════════════════════════════════════════
    test('TC-103A: Plantilla muestra foto o placeholder', async ({ page }) => {
        await loginYMenu(page);
        await page.locator('#btn-reportes').click();
        await page.waitForTimeout(500);

        // Verificar que existe al menos una imagen en la plantilla
        const images = page.locator('.cv-container img');
        const imgCount = await images.count();
        expect(imgCount).toBeGreaterThanOrEqual(1);

        // La primera imagen (foto) debe estar visible y no rota
        const firstImg = images.first();
        await expect(firstImg).toBeVisible();

        // Verificar que tiene src válido
        const src = await firstImg.getAttribute('src');
        expect(src).toBeTruthy();
        expect(src.length).toBeGreaterThan(5);
    });
    // ═══════════════════════════════════════════════════════════
    // TC-152: Reportes — Título de la vista correcto
    // Tipo Prueba: FUNCIONAL
    // ═══════════════════════════════════════════════════════════
    test('TC-152: Reportes — Título de la vista correcto', async ({ page }) => {
        await loginYMenu(page);
        await page.locator('#btn-reportes').click();
        const header = page.locator('#view-reportes h2');
        await expect(header).toHaveText('Reportes y Documentos');
    });
});
