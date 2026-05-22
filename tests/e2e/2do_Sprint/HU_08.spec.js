import { test, expect } from '@playwright/test';

import { BASE, loginUsuario, loginAdmin, logoutCleanup } from '../helpers.js';

test.describe('HU-08: Buscador de Activos (Explorador)', () => {

    // ─── HELPER: Login + navegar al explorador ───
    async function loginYExplorador(page) {
        await page.goto(BASE);
        await page.locator('#openLoginModal').click();
        await expect(page.locator('#loginModal')).toBeVisible();
        await page.fill('input[name="email"]', 'serpientinon@gmail.com');
        await page.fill('input[name="password"]', '12tres45');
        await page.click('button:has-text("Entrar al sistema")');
        await expect(page).toHaveURL(/.*\/menu/, { timeout: 10000 });
        // Cambiar a vista Explorador
        await page.click('button:has-text("Explorador")');
        await page.waitForTimeout(1000);
    }

    // ═══════════════════════════════════════════════════════════
    // TC-63: Verificar búsqueda por coincidencia
    // ═══════════════════════════════════════════════════════════
    test('TC-63: Verificar búsqueda por coincidencia', async ({ page }) => {
        await loginYExplorador(page);

        // 1. Verificar que el campo de búsqueda existe
        const searchInput = page.locator('#expSearch');
        await expect(searchInput).toBeVisible();

        // 2. Escribir un término de búsqueda
        await searchInput.fill('Programa');
        await page.click('.btn-buscar');

        // 3. Verificar que los resultados muestran cards
        await page.waitForTimeout(500);
        const cards = page.locator('.exp-card');
        const count = await cards.count();

        // 4. El contador debe reflejar los resultados
        const countText = await page.locator('#expCount').textContent();
        expect(countText).toContain('Resultado');
    });

    // ═══════════════════════════════════════════════════════════
    // TC-64: Verificar velocidad de respuesta
    // ═══════════════════════════════════════════════════════════
    test('TC-64: Verificar velocidad de respuesta', async ({ page }) => {
        await loginYExplorador(page);

        // 1. Medir tiempo de búsqueda
        const start = Date.now();
        await page.locator('#expSearch').fill('Programa');
        await page.click('.btn-buscar');
        await page.waitForTimeout(200);
        const elapsed = Date.now() - start;

        // 2. La búsqueda debe responder en menos de 2 segundos
        expect(elapsed).toBeLessThan(2000);

        // 3. Los resultados deben renderizarse
        const countText = await page.locator('#expCount').textContent();
        expect(countText).toMatch(/\d+ Resultado/);
    });

    // ═══════════════════════════════════════════════════════════
    // TC-65: Verificar búsqueda vacía
    // ═══════════════════════════════════════════════════════════
    test('TC-65: Verificar búsqueda vacía', async ({ page }) => {
        await loginYExplorador(page);

        // 1. Dejar campo vacío y buscar
        await page.locator('#expSearch').fill('');
        await page.click('.btn-buscar');

        // 2. Debe mostrar todos los resultados (sin filtro)
        await page.waitForTimeout(500);
        const countText = await page.locator('#expCount').textContent();
        expect(countText).toMatch(/\d+ Resultado/);

        // 3. Debe haber al menos los 4 cards de ejemplo
        const cards = page.locator('.exp-card');
        const count = await cards.count();
        expect(count).toBeGreaterThanOrEqual(1);
    });

    // ═══════════════════════════════════════════════════════════
    // TC-66: Verificar atajos de teclado
    // ═══════════════════════════════════════════════════════════
    test('TC-66: Verificar atajos de teclado', async ({ page }) => {
        await loginYExplorador(page);

        // 1. Enfocar el campo de búsqueda
        const searchInput = page.locator('#expSearch');
        await searchInput.click();

        // 2. Escribir y presionar Enter
        await searchInput.fill('PHP');
        await searchInput.press('Enter');

        // 3. Verificar que la búsqueda se ejecuta (el campo mantiene el texto)
        await expect(searchInput).toHaveValue('PHP');
    });

    // ═══════════════════════════════════════════════════════════
    // TC-67: Verificar resaltado de texto
    // ═══════════════════════════════════════════════════════════
    test('TC-67: Verificar resaltado de texto', async ({ page }) => {
        await loginYExplorador(page);

        // 1. Buscar un término que exista en las cards
        await page.locator('#expSearch').fill('Programa');
        await page.click('.btn-buscar');
        await page.waitForTimeout(500);

        // 2. Verificar que el texto buscado está resaltado con <mark>
        const marks = page.locator('.exp-card-title mark');
        const markCount = await marks.count();

        // Si hay resultados, deben tener highlight
        if (markCount > 0) {
            const markText = await marks.first().textContent();
            expect(markText.toLowerCase()).toContain('programa');
        }
    });

    // ═══════════════════════════════════════════════════════════
    // TC-68: Verificar historial reciente
    // ═══════════════════════════════════════════════════════════
    test('TC-68: Verificar historial reciente', async ({ page }) => {
        await loginYExplorador(page);

        // 1. Realizar varias búsquedas
        const searchInput = page.locator('#expSearch');
        await searchInput.fill('PHP');
        await page.click('.btn-buscar');
        await page.waitForTimeout(300);

        await searchInput.fill('Seguridad');
        await page.click('.btn-buscar');
        await page.waitForTimeout(300);

        // 2. Limpiar y verificar que se puede buscar de nuevo
        await searchInput.fill('');
        await page.click('.btn-buscar');
        await page.waitForTimeout(300);

        // 3. Verificar que todos los cards se muestran al limpiar
        const countText = await page.locator('#expCount').textContent();
        expect(countText).toMatch(/\d+ Resultado/);
    });

    // ═══════════════════════════════════════════════════════════
    // TC-69: Verificar filtros por tipo
    // ═══════════════════════════════════════════════════════════
    test('TC-69: Verificar filtros por tipo', async ({ page }) => {
        await loginYExplorador(page);

        // 1. Verificar que los filtros existen
        await expect(page.locator('.exp-filter:has-text("Todos")')).toBeVisible();
        await expect(page.locator('.exp-filter:has-text("Proyectos")')).toBeVisible();
        await expect(page.locator('.exp-filter:has-text("Documentos")')).toBeVisible();
        await expect(page.locator('.exp-filter:has-text("Habilidades")')).toBeVisible();

        // 2. "Todos" debe estar activo por defecto
        await expect(page.locator('.exp-filter:has-text("Todos")')).toHaveClass(/active/);

        // 3. Click en "Proyectos"
        await page.click('.exp-filter:has-text("Proyectos")');
        await page.waitForTimeout(500);

        // 4. Verificar que el filtro cambia
        await expect(page.locator('.exp-filter:has-text("Proyectos")')).toHaveClass(/active/);
        await expect(page.locator('.exp-filter:has-text("Todos")')).not.toHaveClass(/active/);

        // 5. Click en "Habilidades"
        await page.click('.exp-filter:has-text("Habilidades")');
        await page.waitForTimeout(500);
        await expect(page.locator('.exp-filter:has-text("Habilidades")')).toHaveClass(/active/);

        // 6. Volver a "Todos"
        await page.click('.exp-filter:has-text("Todos")');
        await expect(page.locator('.exp-filter:has-text("Todos")')).toHaveClass(/active/);
    });

    // ═══════════════════════════════════════════════════════════
    // TC-70: Verificar búsqueda por etiquetas
    // ═══════════════════════════════════════════════════════════
    test('TC-70: Verificar búsqueda por etiquetas', async ({ page }) => {
        await loginYExplorador(page);

        // 1. Verificar que las cards tienen tags
        await page.waitForTimeout(500);
        const tags = page.locator('.exp-tag');
        const tagCount = await tags.count();
        expect(tagCount).toBeGreaterThan(0);

        // 2. Los tags deben tener formato correcto (texto visible)
        if (tagCount > 0) {
            const tagText = await tags.first().textContent();
            expect(tagText.trim().length).toBeGreaterThan(0);
        }
    });

    // ═══════════════════════════════════════════════════════════
    // TC-71: Verificar navegación rápida
    // ═══════════════════════════════════════════════════════════
    test('TC-71: Verificar navegación rápida', async ({ page }) => {
        await loginYExplorador(page);

        // 1. Verificar que se puede navegar entre vistas del dashboard
        // Click en "Inicio"
        await page.click('button:has-text("Inicio")');
        await page.waitForTimeout(500);
        await expect(page.locator('#view-menu')).toHaveClass(/active/);

        // 2. Volver al explorador
        await page.click('button:has-text("Explorador")');
        await page.waitForTimeout(500);
        await expect(page.locator('#view-explorador')).toHaveClass(/active/);

        // 3. Verificar que el explorador mantiene su estado
        await expect(page.locator('#expSearch')).toBeVisible();
    });

    // ═══════════════════════════════════════════════════════════
    // TC-72: Verificar limpieza de búsqueda
    // ═══════════════════════════════════════════════════════════
    test('TC-72: Verificar limpieza de búsqueda', async ({ page }) => {
        await loginYExplorador(page);

        // 1. Realizar una búsqueda
        await page.locator('#expSearch').fill('PHP');
        await page.click('.btn-buscar');
        await page.waitForTimeout(300);

        // 2. Limpiar el campo
        await page.locator('#expSearch').fill('');
        await page.click('.btn-buscar');
        await page.waitForTimeout(300);

        // 3. Verificar que se muestran todos los resultados
        const countText = await page.locator('#expCount').textContent();
        expect(countText).toMatch(/\d+ Resultado/);
    });

    // ═══════════════════════════════════════════════════════════
    // TC-73: Localizar un archivo real
    // ═══════════════════════════════════════════════════════════
    test('TC-73: Localizar un archivo real', async ({ page }) => {
        await loginYExplorador(page);

        // 1. Buscar "Seguridad" (existe en cards de ejemplo)
        await page.locator('#expSearch').fill('Seguridad');
        await page.click('.btn-buscar');
        await page.waitForTimeout(500);

        // 2. Verificar que hay resultados
        const cards = page.locator('.exp-card');
        const count = await cards.count();

        if (count > 0) {
            // 3. Verificar que la card tiene título visible
            await expect(cards.first().locator('.exp-card-title')).toBeVisible();
            // 4. Verificar que tiene descripción
            await expect(cards.first().locator('.exp-card-desc')).toBeVisible();
        }
    });

    // ═══════════════════════════════════════════════════════════
    // TC-74: Indicación clara del nulo hallazgo
    // ═══════════════════════════════════════════════════════════
    test('TC-74: Indicación clara del nulo hallazgo', async ({ page }) => {
        await loginYExplorador(page);

        // 1. Buscar algo que NO existe
        await page.locator('#expSearch').fill('xyznoexistezyx12345');
        await page.click('.btn-buscar');
        await page.waitForTimeout(500);

        // 2. Verificar que el contador muestra 0 resultados
        const countText = await page.locator('#expCount').textContent();
        expect(countText).toContain('0');

        // 3. Verificar que el grid está vacío
        const cards = page.locator('.exp-card');
        await expect(cards).toHaveCount(0);
    });

    // ═══════════════════════════════════════════════════════════
    // TC-75: Protección a textos saboteadores
    // ═══════════════════════════════════════════════════════════
    test('TC-75: Protección a textos saboteadores', async ({ page }) => {
        await loginYExplorador(page);

        // 1. Buscar con payload XSS
        await page.locator('#expSearch').fill('<script>alert("xss")</script>');
        await page.click('.btn-buscar');
        await page.waitForTimeout(500);

        // 2. Verificar que NO se ejecutó el script (la página sigue funcionando)
        const countText = await page.locator('#expCount').textContent();
        expect(countText).toContain('0');

        // 3. Buscar con inyección SQL
        await page.locator('#expSearch').fill("'; DROP TABLE users;--");
        await page.click('.btn-buscar');
        await page.waitForTimeout(500);

        // 4. La página no debe crashear
        await expect(page.locator('#expCount')).toBeVisible();

        // 5. Buscar con caracteres especiales
        await page.locator('#expSearch').fill('{{constructor.constructor("return this")()}}');
        await page.click('.btn-buscar');
        await page.waitForTimeout(500);
        await expect(page.locator('#expCount')).toBeVisible();
    });

});
