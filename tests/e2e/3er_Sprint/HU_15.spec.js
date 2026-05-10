import { test, expect } from '@playwright/test';

// ═══════════════════════════════════════════════════════════════════
// HU-15: Alertas de Notificaciones
// Tipo Ejecución: AUTOMATED | Sprint: 3
// ═══════════════════════════════════════════════════════════════════

const BASE = 'http://localhost:8000';

async function loginAdmin(page) {
    await page.goto(BASE);
    await page.locator('#openLoginModal').click();
    await expect(page.locator('#loginModal')).toBeVisible({ timeout: 5000 });
    await page.fill('input[name="email"]', 'admin@umss.edu.bo');
    await page.fill('input[name="password"]', 'admin123');
    await page.click('button:has-text("Entrar al sistema")');
    await expect(page).toHaveURL(/.*\/admin/, { timeout: 15000 });
}

async function loginUsuario(page) {
    await page.goto(BASE);
    await page.locator('#openLoginModal').click();
    await expect(page.locator('#loginModal')).toBeVisible({ timeout: 5000 });
    await page.fill('input[name="email"]', 'serpientinon@gmail.com');
    await page.fill('input[name="password"]', '12tres45');
    await page.click('button:has-text("Entrar al sistema")');
    await expect(page).toHaveURL(/.*\/menu/, { timeout: 15000 });
}

test.describe('HU-15: Alertas de Notificaciones', () => {

    // ═══════════════════════════════════════════════════════════
    // TC-121: Enviar notificación a todos
    // Tipo Prueba: FUNCIONAL
    // ═══════════════════════════════════════════════════════════
    test('TC-121: Admin — Enviar notificación a todos los usuarios', async ({ page }) => {
        await loginAdmin(page);
        const csrfToken = await page.locator('meta[name="csrf-token"]').getAttribute('content');

        // Ir a vista Notificaciones
        await page.locator('#btn-notificaciones').click();
        await expect(page.locator('#view-notificaciones')).toBeVisible();

        // Llenar formulario
        await page.fill('#notif-titulo', 'Test E2E Masiva ' + Date.now());
        await page.fill('#notif-mensaje', 'Esta es una notificación de prueba enviada a todos los usuarios.');
        await page.selectOption('#notif-tipo', 'todos');

        // Enviar
        await page.click('#btn-enviar-notif');
        await page.waitForTimeout(1000);

        // Verificar mensaje de éxito
        await expect(page.getByText('Notificación enviada correctamente')).toBeVisible({ timeout: 5000 });
    });

    // ═══════════════════════════════════════════════════════════
    // TC-122: Enviar notificación a usuario específico
    // Tipo Prueba: FUNCIONAL
    // ═══════════════════════════════════════════════════════════
    test('TC-122: Admin — Enviar a usuario específico', async ({ page }) => {
        await loginAdmin(page);

        await page.locator('#btn-notificaciones').click();
        await expect(page.locator('#view-notificaciones')).toBeVisible();

        // Seleccionar tipo individual
        await page.selectOption('#notif-tipo', 'individual');
        await page.waitForTimeout(300);

        // Verificar que aparece el selector de usuario
        const userSelect = page.locator('#notif-destinatario');
        await expect(userSelect).toBeVisible();

        // Seleccionar primer usuario disponible
        const options = userSelect.locator('option');
        const count = await options.count();
        if (count > 1) { // skip placeholder
            await userSelect.selectOption({ index: 1 });
        }

        // Llenar y enviar
        await page.fill('#notif-titulo', 'Test Individual ' + Date.now());
        await page.fill('#notif-mensaje', 'Notificación individual de prueba');
        await page.click('#btn-enviar-notif');
        await page.waitForTimeout(1000);

        await expect(page.getByText('Notificación enviada correctamente')).toBeVisible({ timeout: 5000 });
    });

    // ═══════════════════════════════════════════════════════════
    // TC-123: Enviar sin título rechazado
    // Tipo Prueba: FUNCIONAL
    // ═══════════════════════════════════════════════════════════
    test('TC-123: Validación — Enviar sin título rechazado', async ({ page }) => {
        await loginAdmin(page);
        const csrfToken = await page.locator('meta[name="csrf-token"]').getAttribute('content');

        const response = await page.evaluate(async (token) => {
            const res = await fetch('/admin/notificaciones', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    titulo: '',
                    mensaje: 'Mensaje sin título',
                    tipo_envio: 'todos'
                })
            });
            return { status: res.status };
        }, csrfToken);

        expect(response.status).toBe(422);
    });

    // ═══════════════════════════════════════════════════════════
    // TC-125: Título excede 150 caracteres
    // Tipo Prueba: EXPLORATORIA
    // ═══════════════════════════════════════════════════════════
    test('TC-125: Validación — Título > 150 chars rechazado', async ({ page }) => {
        await loginAdmin(page);
        const csrfToken = await page.locator('meta[name="csrf-token"]').getAttribute('content');

        const response = await page.evaluate(async ({ token, titulo }) => {
            const res = await fetch('/admin/notificaciones', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    titulo: titulo,
                    mensaje: 'Mensaje de prueba',
                    tipo_envio: 'todos'
                })
            });
            return { status: res.status };
        }, { token: csrfToken, titulo: 'X'.repeat(151) });

        expect(response.status).toBe(422);
    });

    // ═══════════════════════════════════════════════════════════
    // TC-127: Recepción por usuario destino
    // Tipo Prueba: INTEGRACION
    // ═══════════════════════════════════════════════════════════
    test('TC-127: Usuario recibe notificaciones tipo "todos"', async ({ page }) => {
        await loginUsuario(page);

        // Consultar endpoint de notificaciones
        const response = await page.evaluate(async () => {
            const res = await fetch('/mis-notificaciones');
            return { status: res.status, data: await res.json() };
        });

        expect(response.status).toBe(200);
        expect(response.data).toHaveProperty('notificaciones');
        // Verificar que es un array
        expect(Array.isArray(response.data.notificaciones)).toBe(true);
    });

    // ═══════════════════════════════════════════════════════════
    // TC-128: Marcar como leída
    // Tipo Prueba: FUNCIONAL
    // ═══════════════════════════════════════════════════════════
    test('TC-128: Usuario marca notificación como leída', async ({ page }) => {
        await loginUsuario(page);
        const csrfToken = await page.locator('meta[name="csrf-token"]').getAttribute('content');

        // Obtener notificaciones
        const notifs = await page.evaluate(async () => {
            const res = await fetch('/mis-notificaciones');
            return await res.json();
        });

        if (notifs.notificaciones.length === 0) {
            test.skip();
            return;
        }

        const notifId = notifs.notificaciones[0].id;

        // Marcar como leída
        const response = await page.evaluate(async ({ token, id }) => {
            const res = await fetch(`/mis-notificaciones/${id}/leida`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json'
                }
            });
            return { status: res.status };
        }, { token: csrfToken, id: notifId });

        expect(response.status).toBe(200);
    });

    // ═══════════════════════════════════════════════════════════
    // TC-129: Usuario normal no puede enviar notificación
    // Tipo Prueba: SEGURIDAD
    // ═══════════════════════════════════════════════════════════
    test('TC-129: Seguridad — Usuario normal no envía notificaciones', async ({ page }) => {
        await loginUsuario(page);
        const csrfToken = await page.locator('meta[name="csrf-token"]').getAttribute('content');

        const response = await page.evaluate(async (token) => {
            const res = await fetch('/admin/notificaciones', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    titulo: 'Intento no autorizado',
                    mensaje: 'No debería funcionar',
                    tipo_envio: 'todos'
                })
            });
            return { status: res.status };
        }, csrfToken);

        // Debe recibir 403 (middleware es_admin)
        expect([403, 302]).toContain(response.status);
    });

    // ═══════════════════════════════════════════════════════════
    // TC-132: Tipo envío inválido via API
    // Tipo Prueba: SEGURIDAD
    // ═══════════════════════════════════════════════════════════
    test('TC-132: Tipo envío inválido rechazado', async ({ page }) => {
        await loginAdmin(page);
        const csrfToken = await page.locator('meta[name="csrf-token"]').getAttribute('content');

        const response = await page.evaluate(async (token) => {
            const res = await fetch('/admin/notificaciones', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    titulo: 'Test inválido',
                    mensaje: 'Mensaje',
                    tipo_envio: 'tipo_inventado'
                })
            });
            return { status: res.status };
        }, csrfToken);

        expect(response.status).toBe(422);
    });

    // ═══════════════════════════════════════════════════════════
    // TC-124A: Individual sin seleccionar usuario
    // Tipo Prueba: FUNCIONAL
    // ═══════════════════════════════════════════════════════════
    test('TC-124A: Individual sin destinatario rechazado (API)', async ({ page }) => {
        await loginAdmin(page);
        const csrfToken = await page.locator('meta[name="csrf-token"]').getAttribute('content');

        const response = await page.evaluate(async (token) => {
            const res = await fetch('/admin/notificaciones', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    titulo: 'Test sin destino',
                    mensaje: 'No tiene destinatario',
                    tipo_envio: 'individual'
                    // destinatario_id falta intencionalmente
                })
            });
            return { status: res.status };
        }, csrfToken);

        expect(response.status).toBe(422);
    });

    // ═══════════════════════════════════════════════════════════
    // TC-131A: Admin — Historial y eliminar notificación
    // Tipo Prueba: FUNCIONAL
    // ═══════════════════════════════════════════════════════════
    test('TC-131A: Admin — Listar y eliminar notificación', async ({ page }) => {
        await loginAdmin(page);
        const csrfToken = await page.locator('meta[name="csrf-token"]').getAttribute('content');

        // Listar notificaciones
        const listResponse = await page.evaluate(async () => {
            const res = await fetch('/admin/notificaciones');
            return { status: res.status, data: await res.json() };
        });

        expect(listResponse.status).toBe(200);
        expect(Array.isArray(listResponse.data)).toBe(true);

        if (listResponse.data.length === 0) {
            test.skip();
            return;
        }

        // Eliminar la primera
        const notifId = listResponse.data[0].id;
        const delResponse = await page.evaluate(async ({ token, id }) => {
            const res = await fetch(`/admin/notificaciones/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json'
                }
            });
            return { status: res.status };
        }, { token: csrfToken, id: notifId });

        expect(delResponse.status).toBe(200);
    });
});
