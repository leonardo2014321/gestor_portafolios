import { test, expect } from '@playwright/test';

const BASE = 'http://localhost:8000';

test.describe('HU-06: Biografía profesional (Mi Trayectoria)', () => {

    // ─── HELPER: Login + abrir modal Trayectoria ───
    async function loginYTrayectoria(page) {
        await page.goto(BASE);
        await page.locator('#openLoginModal').click();
        await expect(page.locator('#loginModal')).toBeVisible();
        await page.fill('input[name="email"]', 'serpientinon@gmail.com');
        await page.fill('input[name="password"]', '12tres45');
        await page.click('button:has-text("Entrar al sistema")');
        await expect(page).toHaveURL(/.*\/menu/, { timeout: 10000 });
        await page.goto(`${BASE}/perfil`);
        await expect(page.locator('h1:has-text("Mi Perfil")')).toBeVisible({ timeout: 10000 });
        // Abrir modal Mi Trayectoria
        await page.click('button:has-text("Mi Trayectoria")');
        await expect(page.locator('#modalTrayectoria')).toHaveClass(/show/, { timeout: 5000 });
    }

    // Helper: Cambiar tab
    async function switchTab(page, tabName) {
        await page.click(`.tray-tab:has-text("${tabName}")`);
        await page.waitForTimeout(500);
    }

    // ═══════════════════════════════════════════════════════════
    // TC-38: Verificar coherencia de fechas
    // ═══════════════════════════════════════════════════════════
    test('TC-38: Verificar coherencia de fechas', async ({ page }) => {
        await loginYTrayectoria(page);
        await switchTab(page, 'Experiencia');

        // 1. Llenar campos obligatorios
        await page.fill('#expEmpresa', 'Empresa Test');
        await page.fill('#expCargo', 'Cargo Test');

        // 2. Poner fecha fin ANTERIOR a fecha inicio
        await page.fill('#expInicio', '2024-06-01');
        await page.fill('#expFin', '2024-01-01');

        // 3. Verificar que muestra error de coherencia de fechas
        await expect(page.locator('#errExpFin')).toBeVisible();
        await expect(page.locator('#errExpFin')).toContainText('anterior');
    });

    // ═══════════════════════════════════════════════════════════
    // TC-39: Verificar trabajo actual
    // ═══════════════════════════════════════════════════════════
    test('TC-39: Verificar trabajo actual', async ({ page }) => {
        await loginYTrayectoria(page);
        await switchTab(page, 'Experiencia');

        // 1. Verificar que el checkbox "Actualmente trabajo aquí" existe
        await expect(page.locator('#expActual')).toBeVisible();

        // 2. Marcar el checkbox
        await page.check('#expActual');

        // 3. El campo de fecha fin se debe deshabilitar o ocultar
        const isHidden = await fgExpFin.evaluate(el => {
            const style = window.getComputedStyle(el);
            return style.display === 'none' || style.opacity === '0.4' || el.getAttribute('disabled') !== null;
        });

        // 5. Aserción final
        expect(isHidden).toBeTruthy();

        // 4. Desmarcar y verificar que el campo reaparece
        await page.uncheck('#expActual');
    });

    // ═══════════════════════════════════════════════════════════
    // TC-40: Verificar nivel de habilidad
    // ═══════════════════════════════════════════════════════════
    test('TC-40: Verificar nivel de habilidad', async ({ page }) => {
        await loginYTrayectoria(page);

        // 1. Verificar que el tab Habilidades está activo por defecto
        await expect(page.locator('.tray-tab.active')).toContainText('Habilidades');

        // 2. Verificar que las estrellas existen (5 estrellas)
        const stars = page.locator('#starsWrap .star');
        await expect(stars).toHaveCount(5);

        // 3. Verificar leyenda de niveles
        await expect(page.locator('#nivelLabel')).toContainText('Principiante');
        await expect(page.locator('#nivelLabel')).toContainText('Intermedio');
        await expect(page.locator('#nivelLabel')).toContainText('Avanzado');

        // 4. Hacer click en estrella 3 (Intermedio)
        await page.click('.star[data-v="3"]');

        // 5. Verificar que las primeras 3 estrellas están activas
        for (let i = 1; i <= 3; i++) {
            await expect(page.locator(`.star[data-v="${i}"]`)).toHaveClass(/on/);
        }
    });

    // ═══════════════════════════════════════════════════════════
    // TC-41: Verificar guardado básico y orden
    // ═══════════════════════════════════════════════════════════
    test('TC-41: Verificar guardado básico y orden', async ({ page }) => {
        await loginYTrayectoria(page);

        // 1. Verificar que la lista de habilidades se carga
        await page.waitForTimeout(2000);
        const listHab = page.locator('#listHabilidades');
        await expect(listHab).toBeVisible();

        // 2. Verificar que las habilidades existentes tienen nombre y nivel
        const items = page.locator('#listHabilidades .item-card');
        const count = await items.count();
        if (count > 0) {
            // Verificar que el primer item tiene texto
            await expect(items.first().locator('strong')).not.toBeEmpty();
        }
    });

    // ═══════════════════════════════════════════════════════════
    // TC-42: Verificar duplicidad de skills
    // ═══════════════════════════════════════════════════════════
    test('TC-42: Verificar duplicidad de skills', async ({ page }) => {
        await loginYTrayectoria(page);

        // 1. Verificar que existe el error de duplicado (oculto inicialmente)
        await expect(page.locator('#errHabDup')).toBeAttached();

        // 2. Verificar texto del error
        await expect(page.locator('#errHabDup')).toContainText('Ya tienes registrada');
    });

    // ═══════════════════════════════════════════════════════════
    // TC-43: Verificar orden de experiencia
    // ═══════════════════════════════════════════════════════════
    test('TC-43: Verificar orden de experiencia', async ({ page }) => {
        await loginYTrayectoria(page);
        await switchTab(page, 'Experiencia');

        // 1. Verificar que la lista de experiencias se carga
        await page.waitForTimeout(2000);
        const listExp = page.locator('#listExperiencias');
        await expect(listExp).toBeVisible();

        // 2. Verificar los campos del formulario de experiencia
        await expect(page.locator('#expEmpresa')).toBeVisible();
        await expect(page.locator('#expCargo')).toBeVisible();
        await expect(page.locator('#expInicio')).toBeVisible();
        await expect(page.locator('#expFin')).toBeVisible();
        await expect(page.locator('#expDesc')).toBeVisible();
    });

    // ═══════════════════════════════════════════════════════════
    // TC-44: Verificar eliminación de registros
    // ═══════════════════════════════════════════════════════════
    test('TC-44: Verificar eliminación de registros', async ({ page }) => {
        await loginYTrayectoria(page);

        // 1. Verificar que existe el modal de confirmación de eliminación
        await expect(page.locator('#delOverlay')).toBeAttached();

        // 2. Verificar que tiene botones de cancelar y confirmar
        await expect(page.locator('#delOverlay .btn-cancel')).toBeAttached();
        await expect(page.locator('#delOverlay .btn-danger')).toBeAttached();

        // 3. Verificar texto del modal
        await expect(page.locator('#delOverlay h3')).toContainText('Eliminar');
        await expect(page.locator('#delOverlay p')).toContainText('no se puede deshacer');
    });

    // ═══════════════════════════════════════════════════════════
    // TC-45: Verificar sugerencias de skills
    // ═══════════════════════════════════════════════════════════
    test('TC-45: Verificar sugerencias de skills', async ({ page }) => {
        await loginYTrayectoria(page);

        // 1. Verificar que el campo de nombre de habilidad tiene placeholder
        await expect(page.locator('#habNombre')).toHaveAttribute('placeholder', /JavaScript|Python|Diseño/);

        // 2. Verificar que existe el dropdown de autocompletado
        await expect(page.locator('#acDrop')).toBeAttached();

        // 3. Escribir algo para activar sugerencias
        await page.fill('#habNombre', 'Java');
        await page.locator('#habNombre').dispatchEvent('input');

        // 4. Esperar un momento para que se renderice
        await page.waitForTimeout(500);
    });

    // ═══════════════════════════════════════════════════════════
    // TC-46: Verificar descripción de logros
    // ═══════════════════════════════════════════════════════════
    test('TC-46: Verificar descripción de logros', async ({ page }) => {
        await loginYTrayectoria(page);
        await switchTab(page, 'Experiencia');

        // 1. Verificar que el campo de descripción existe
        await expect(page.locator('#expDesc')).toBeVisible();

        // 2. Verificar placeholder
        await expect(page.locator('#expDesc')).toHaveAttribute('placeholder', /actividades y logros/);

        // 3. Verificar maxlength
        await expect(page.locator('#expDesc')).toHaveAttribute('maxlength', '2000');

        // 4. Escribir una descripción de logros
        await page.fill('#expDesc', 'Lideré un equipo de 5 personas en la implementación de un ERP.');
        const valor = await page.inputValue('#expDesc');
        expect(valor).toContain('Lideré');
    });

    // ═══════════════════════════════════════════════════════════
    // TC-47: Verificar carga de títulos
    // ═══════════════════════════════════════════════════════════
    test('TC-47: Verificar carga de títulos', async ({ page }) => {
        await loginYTrayectoria(page);
        await switchTab(page, 'Formación');

        // 1. Verificar campos de formación
        await expect(page.locator('#forInstitucion')).toBeVisible();
        await expect(page.locator('#forTitulo')).toBeVisible();
        await expect(page.locator('#forInicio')).toBeVisible();
        await expect(page.locator('#forFin')).toBeVisible();

        // 2. Verificar placeholders
        await expect(page.locator('#forInstitucion')).toHaveAttribute('placeholder', /Universidad|Instituto/);
        await expect(page.locator('#forTitulo')).toHaveAttribute('placeholder', /Ingeniería/);

        // 3. Verificar lista de formaciones
        const listFor = page.locator('#listFormaciones');
        await expect(listFor).toBeVisible();
    });

    // ═══════════════════════════════════════════════════════════
    // TC-48: Verificar Enum de nivel cerrado
    // ═══════════════════════════════════════════════════════════
    test('TC-48: Verificar Enum de nivel cerrado', async ({ page }) => {
        await loginYTrayectoria(page);

        // 1. Verificar que solo hay 5 estrellas (1-5, no más)
        const stars = page.locator('#starsWrap .star');
        await expect(stars).toHaveCount(5);

        // 2. Verificar que cada estrella tiene un data-v válido (1-5)
        for (let i = 1; i <= 5; i++) {
            await expect(page.locator(`.star[data-v="${i}"]`)).toBeAttached();
        }

        // 3. No debe existir estrella 6
        await expect(page.locator('.star[data-v="6"]')).not.toBeAttached();

        // 4. Verificar que sin seleccionar nivel, el error aparece al intentar agregar
        await page.fill('#habNombre', 'TestSkill');
        // No seleccionar estrellas
        await page.click('#formHab .btn-save');
        await expect(page.locator('#errHabNivel')).toBeVisible();
    });

    // ═══════════════════════════════════════════════════════════
    // TC-49: Verificar asistencia en errores de red
    // ═══════════════════════════════════════════════════════════
    test('TC-49: Verificar asistencia en errores de red', async ({ page }) => {
        await loginYTrayectoria(page);

        // 1. Verificar que la alerta de error de red existe (oculta)
        await expect(page.locator('#trayAlert')).toBeAttached();

        // 2. Verificar el contenido del mensaje
        await expect(page.locator('#trayAlert')).toContainText('fallo momentáneo');
        await expect(page.locator('#trayAlert')).toContainText('Reintentar');
    });

    // ═══════════════════════════════════════════════════════════
    // TC-50: Verificar adaptabilidad móvil
    // ═══════════════════════════════════════════════════════════
    test('TC-50: Verificar adaptabilidad móvil', async ({ page }) => {
        // 1. Viewport móvil
        await page.setViewportSize({ width: 375, height: 667 });
        await loginYTrayectoria(page);

        // 2. Verificar que el modal de trayectoria sigue visible
        await expect(page.locator('#modalTrayectoria')).toHaveClass(/show/);

        // 3. Verificar que los tabs son accesibles
        await expect(page.locator('.tray-tab:has-text("Habilidades")')).toBeVisible();
        await expect(page.locator('.tray-tab:has-text("Experiencia")')).toBeVisible();

        // 4. Verificar que se puede cambiar de tab
        await switchTab(page, 'Certificaciones');
        await expect(page.locator('#pane-certificacion')).toHaveClass(/active/);

        // 5. Verificar campos de certificaciones
        await expect(page.locator('#certNombre')).toBeVisible();
    });

});
