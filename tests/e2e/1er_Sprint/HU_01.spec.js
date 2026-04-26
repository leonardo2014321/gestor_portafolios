import { test, expect } from '@playwright/test';

const BASE = 'http://localhost:8000';

test.describe('HU-01: Gestión de perfil profesional (Landing Page)', () => {

    test.beforeEach(async ({ page }) => {
        await page.goto(BASE);
    });

    // ═══════════════════════════════════════════════════════════
    // TC-1: Validación de Identidad Visual y Estructura (UI/UX)
    // ═══════════════════════════════════════════════════════════
    test('TC-1: Validación de Identidad Visual y Estructura (UI/UX)', async ({ page }) => {
        // 1. Verificar que el título principal del hero está visible
        await expect(page.locator('h2')).toContainText('Tu Portafolio');

        // 2. Verificar que el botón "Empezar Ahora" existe y es funcional
        const btnEmpezar = page.getByRole('button', { name: /empezar ahora/i });
        await expect(btnEmpezar).toBeVisible();

        // 3. Click abre el modal de login
        await btnEmpezar.click();
        await expect(page.getByText('Bienvenido de nuevo')).toBeVisible();

        // 4. Verificar que los campos del formulario de login estén presentes
        await expect(page.getByPlaceholder('ejemplo@gmail.com')).toBeVisible();
        await expect(page.getByPlaceholder('••••••••••••')).toBeVisible();

        // 5. Verificar que el botón de submit del modal esté visible
        await expect(page.getByRole('button', { name: /entrar al sistema/i })).toBeVisible();
    });

    // ═══════════════════════════════════════════════════════════
    // TC-2: Validación de Navegación, Header Sticky y Rendimiento
    // ═══════════════════════════════════════════════════════════
    test('TC-2: Validación de Navegación, Header Sticky y Rendimiento', async ({ page }) => {
        // 1. Verificar el enlace "Ver portafolios →"
        const linkPortafolios = page.getByRole('link', { name: /ver portafolios/i });
        await expect(linkPortafolios).toBeVisible();

        // 2. Hacer clic y verificar navegación
        await linkPortafolios.click();
        await expect(page).toHaveURL(/.*portafolios/);

        // 3. Volver a la landing
        await page.goto(BASE);

        // 4. Verificar que la sección de características existe
        await expect(page.getByText('Todo tu perfil profesional en un solo lugar')).toBeVisible();

        // 5. Verificar que las tarjetas de características existen
        await expect(page.getByText('Creación de Portafolio')).toBeVisible();
        await expect(page.getByText('Gestión de Proyectos')).toBeVisible();
        await expect(page.getByText('Perfil Profesional')).toBeVisible();
        await expect(page.getByText('Acceso Seguro')).toBeVisible();
    });

    // ═══════════════════════════════════════════════════════════
    // TC-3: Verificación de Diseño Responsivo (Adaptabilidad Móvil)
    // ═══════════════════════════════════════════════════════════
    test('TC-3: Verificación de Diseño Responsivo (Adaptabilidad Móvil)', async ({ page }) => {
        // 1. Cambiar viewport a móvil (iPhone SE)
        await page.setViewportSize({ width: 375, height: 667 });
        await page.goto(BASE);

        // 2. Verificar que el hero sigue visible
        await expect(page.locator('h2')).toContainText('Tu Portafolio');

        // 3. Verificar que el botón "Empezar Ahora" sigue accesible
        const btnEmpezar = page.getByRole('button', { name: /empezar ahora/i });
        await expect(btnEmpezar).toBeVisible();

        // 4. Verificar que "Ver portafolios" sigue visible
        await expect(page.getByRole('link', { name: /ver portafolios/i })).toBeVisible();

        // 5. Verificar la sección de características en móvil
        await expect(page.getByText('Todo tu perfil profesional en un solo lugar')).toBeVisible();

        // 6. Verificar que las tarjetas de características se ven en móvil
        await expect(page.getByText('Creación de Portafolio')).toBeVisible();

        // 7. Probar en tamaño tablet (iPad)
        await page.setViewportSize({ width: 768, height: 1024 });
        await expect(page.locator('h2')).toContainText('Tu Portafolio');
        await expect(btnEmpezar).toBeVisible();
    });

});