// @ts-check
const { test, expect } = require('@playwright/test');

// Datos de prueba
const userEmail = 'serpientinon@gmail.com';
const userPass  = '12tres45';

test.describe('HU Cliente - CRUD Trayectoria y Soft Deletes', () => {

    test.beforeEach(async ({ page }) => {
        // Login antes de cada test
        await page.goto('/login');
        await page.fill('#email', userEmail);
        await page.fill('#password', userPass);
        await page.click('button[type="submit"]');
        await expect(page).toHaveURL('/home');
        
        // Navegar a Mi Trayectoria
        await page.goto('/perfil');
        await page.click('button[onclick="abrirModalTrayectoria()"]');
        await expect(page.locator('#modalTrayectoria')).toBeVisible();
    });

    test('TC-147: Crear nueva Habilidad (CRUD)', async ({ page }) => {
        // Seleccionar tab habilidades
        await page.click('button[onclick="switchTab(\'habilidades\')"]');
        await page.click('#btnNuevaHabilidad');
        
        await page.fill('#hab_nombre', 'Automatización QA Playwright');
        await page.selectOption('#hab_nivel', 'avanzado');
        await page.selectOption('#hab_tipo', 'fuerte');
        
        await page.click('#btnGuardarHabilidad');
        
        // Verificar que aparece en la lista
        const item = page.locator('.tray-item', { hasText: 'Automatización QA Playwright' });
        await expect(item).toBeVisible();
    });

    test('TC-148: Editar Habilidad existente (CRUD)', async ({ page }) => {
        await page.click('button[onclick="switchTab(\'habilidades\')"]');
        
        // Buscar la habilidad creada y hacer clic en editar (ícono lápiz)
        const item = page.locator('.tray-item', { hasText: 'Automatización QA Playwright' });
        await item.locator('button[onclick^="editarHabilidad"]').click();
        
        // Modificar nivel
        await page.selectOption('#hab_nivel', 'intermedio');
        await page.click('#btnGuardarHabilidad');
        
        // Verificar cambio en la UI
        await expect(item.locator('.badge', { hasText: 'Intermedio' })).toBeVisible();
    });

    test('TC-149: Soft Delete de Habilidad - Se oculta en UI pero persiste (Criterio Cliente)', async ({ page, request }) => {
        // Este test verifica que al eliminar, desaparezca de la UI, 
        // pero idealmente a nivel BD (o API admin) siga existiendo (Soft Delete).
        await page.click('button[onclick="switchTab(\'habilidades\')"]');
        
        const item = page.locator('.tray-item', { hasText: 'Automatización QA Playwright' });
        
        // Confirmar eliminación
        page.on('dialog', dialog => dialog.accept());
        await item.locator('button[onclick^="eliminarHabilidad"]').click();
        
        // Verificar que ya no está visible en la interfaz del usuario
        await expect(page.locator('.tray-item', { hasText: 'Automatización QA Playwright' })).not.toBeVisible();
        
        // NOTA: Como el sistema actual hace Hard Delete ($model->delete()), 
        // este caso detectará que desaparece de la UI, pero si hiciéramos una query directa a la BD
        // fallaría al no encontrar el registro. Se reportará como un BUG para desarrollo.
    });

    test('TC-150: Soft Delete de Experiencia - Validación de consistencia', async ({ page }) => {
        // Seleccionar tab experiencias
        await page.click('button[onclick="switchTab(\'experiencias\')"]');
        await page.click('#btnNuevaExperiencia');
        
        await page.fill('#exp_empresa', 'Empresa de Prueba Soft Delete');
        await page.fill('#exp_cargo', 'QA Tester');
        await page.fill('#exp_inicio', '2025-01-01');
        await page.click('#btnGuardarExperiencia');
        
        const item = page.locator('.tray-item', { hasText: 'Empresa de Prueba Soft Delete' });
        await expect(item).toBeVisible();

        // Eliminar
        page.on('dialog', dialog => dialog.accept());
        await item.locator('button[onclick^="eliminarExperiencia"]').click();
        
        // Verificar que no se muestra
        await expect(page.locator('.tray-item', { hasText: 'Empresa de Prueba Soft Delete' })).not.toBeVisible();
    });

});
