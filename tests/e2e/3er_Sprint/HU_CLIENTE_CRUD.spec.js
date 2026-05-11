import { test, expect } from '@playwright/test';

// ═══════════════════════════════════════════════════════════════════
// HU Cliente - CRUD Trayectoria y Soft Deletes
// Tipo Ejecución: AUTOMATED | Sprint: 3
// ═══════════════════════════════════════════════════════════════════

const BASE = 'http://localhost:8000';

// Datos de prueba
const userEmail = 'serpientinon@gmail.com';
const userPass  = '12tres45';

// ─── HELPER: Login como usuario ───
async function loginUsuario(page) {
    await page.goto(BASE);
    await page.getByRole('button', { name: 'Iniciar sesión' }).click();
    await expect(page.locator('#loginModal')).toBeVisible({ timeout: 10000 });
    await page.fill('input[name="email"]', userEmail);
    await page.fill('input[name="password"]', userPass);
    await page.click('button:has-text("Entrar al sistema")');
    await expect(page).toHaveURL(/.*\/menu/, { timeout: 30000 });
    await page.waitForTimeout(1000);
}

test.describe('HU Cliente - CRUD Trayectoria y Soft Deletes', () => {

    test.beforeEach(async ({ page }) => {
        // Login antes de cada test
        await loginUsuario(page);

        // Navegar a Perfil y abrir modal Trayectoria
        await page.goto(`${BASE}/perfil`);
        await page.waitForTimeout(500);

        // Abrir modal de trayectoria (la función real es abrirTrayectoria)
        await page.locator('button:has-text("Mi Trayectoria")').click();
        await expect(page.locator('#modalTrayectoria')).toBeVisible({ timeout: 5000 });
    });

    test('TC-147: Crear nueva Habilidad (CRUD)', async ({ page }) => {
        // Ya estamos en el tab habilidades (es el activo por defecto)
        await expect(page.locator('#pane-habilidades')).toBeVisible();

        // Llenar formulario de habilidad
        await page.fill('#habNombre', 'Automatización QA Playwright');

        // Seleccionar nivel (clic en estrellas — 4 estrellas = avanzado)
        await page.locator('#starsWrap .star[data-v="4"]').click();

        // Seleccionar tipo "fuerte" (ya está activo por defecto, pero click explícito)
        await page.locator('#btnTipoFuerte').click();

        // Clic en botón Agregar (btn-save dentro del form de habilidades)
        await page.locator('#formHab .btn-save').click();
        await page.waitForTimeout(500);

        // Confirmar en el mini-modal de confirmación
        const confirmOverlay = page.locator('#confirmOverlay');
        if (await confirmOverlay.isVisible()) {
            await confirmOverlay.locator('.btn-save').click();
            await page.waitForTimeout(1000);
        }

        // Verificar que aparece en la lista
        const item = page.locator('.item-card', { hasText: 'Automatización QA Playwright' });
        await expect(item).toBeVisible({ timeout: 5000 });
    });

    test('TC-148: Editar Habilidad existente (CRUD)', async ({ page }) => {
        await expect(page.locator('#pane-habilidades')).toBeVisible();

        // Buscar la habilidad creada y hacer clic en editar (ícono lápiz)
        const item = page.locator('.item-card', { hasText: 'Automatización QA Playwright' });

        // Si no existe la habilidad, skip
        if (await item.count() === 0) {
            test.skip();
            return;
        }

        await item.locator('.btn-edit-item').click();
        await page.waitForTimeout(300);

        // El formulario debe estar en modo edición
        await expect(page.locator('#formHab')).toHaveClass(/editing/);

        // Modificar nivel (clic en 3 estrellas = intermedio)
        await page.locator('#starsWrap .star[data-v="3"]').click();

        // Clic en guardar cambios
        await page.locator('#formHab .btn-save').click();
        await page.waitForTimeout(500);

        // Confirmar en el mini-modal
        const confirmOverlay = page.locator('#confirmOverlay');
        if (await confirmOverlay.isVisible()) {
            await confirmOverlay.locator('.btn-save').click();
            await page.waitForTimeout(1000);
        }

        // Verificar que el item sigue visible
        await expect(item).toBeVisible({ timeout: 5000 });
    });

    test('TC-149: Soft Delete de Habilidad - Se oculta en UI pero persiste (Criterio Cliente)', async ({ page }) => {
        // Este test verifica que al eliminar, desaparezca de la UI, 
        // pero idealmente a nivel BD (o API admin) siga existiendo (Soft Delete).
        await expect(page.locator('#pane-habilidades')).toBeVisible();

        const item = page.locator('.item-card', { hasText: 'Automatización QA Playwright' });

        if (await item.count() === 0) {
            test.skip();
            return;
        }

        // Clic en botón eliminar (ícono basura)
        await item.locator('.btn-del-item').click();
        await page.waitForTimeout(300);

        // Confirmar eliminación en el mini-modal rojo
        const delOverlay = page.locator('#delOverlay');
        await expect(delOverlay).toBeVisible();
        await delOverlay.locator('#btnConfirmDel').click();
        await page.waitForTimeout(1000);

        // Verificar que ya no está visible en la interfaz del usuario
        await expect(page.locator('.item-card', { hasText: 'Automatización QA Playwright' })).not.toBeVisible();

        // NOTA: Como el sistema actual hace Hard Delete ($model->delete()), 
        // este caso detectará que desaparece de la UI, pero si hiciéramos una query directa a la BD
        // fallaría al no encontrar el registro. Se reportará como un BUG para desarrollo.
    });

    test('TC-150: Soft Delete de Experiencia - Validación de consistencia', async ({ page }) => {
        // Seleccionar tab experiencias
        await page.locator('button:has-text("Experiencia")').click();
        await page.waitForTimeout(300);
        await expect(page.locator('#pane-experiencia')).toBeVisible();

        // Llenar formulario de experiencia
        await page.fill('#expEmpresa', 'Empresa de Prueba Soft Delete');
        await page.fill('#expCargo', 'QA Tester');
        await page.fill('#expInicio', '2025-01-01');

        // Clic en Agregar
        await page.locator('#formExp .btn-save').click();
        await page.waitForTimeout(500);

        // Confirmar en el mini-modal
        const confirmOverlay = page.locator('#confirmOverlay');
        if (await confirmOverlay.isVisible()) {
            await confirmOverlay.locator('.btn-save').click();
            await page.waitForTimeout(1000);
        }

        const item = page.locator('.item-card', { hasText: 'Empresa de Prueba Soft Delete' });
        await expect(item).toBeVisible({ timeout: 5000 });

        // Eliminar
        await item.locator('.btn-del-item').click();
        await page.waitForTimeout(300);

        // Confirmar eliminación
        const delOverlay = page.locator('#delOverlay');
        await expect(delOverlay).toBeVisible();
        await delOverlay.locator('#btnConfirmDel').click();
        await page.waitForTimeout(1000);

        // Verificar que no se muestra
        await expect(page.locator('.item-card', { hasText: 'Empresa de Prueba Soft Delete' })).not.toBeVisible();
    });

});
