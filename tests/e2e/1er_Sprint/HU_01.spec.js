import { test, expect } from '@playwright/test';

test.describe('Pruebas de botones de la Landing Page', () => {

    test.beforeEach(async ({ page }) => {
        // Ajusta la URL según tu entorno local de Laravel
        await page.goto('http://localhost:8000');
    });

    test('debe abrir el modal de login al hacer clic en Empezar Ahora', async ({ page }) => {
        // 1. Localizar el botón por su texto (incluye flecha →)
        const btnEmpezar = page.getByRole('button', { name: /empezar ahora/i });

        // 2. Verificar que el botón sea visible
        await expect(btnEmpezar).toBeVisible();

        // 3. Hacer clic para abrir el modal de login
        await btnEmpezar.click();

        // 4. Validar que el modal de login se abrió
        // El modal tiene el título "Bienvenido de nuevo"
        await expect(page.getByText('Bienvenido de nuevo')).toBeVisible();

        // 5. Verificar que los campos del formulario de login estén presentes
        await expect(page.getByPlaceholder('ejemplo@gmail.com')).toBeVisible();
        await expect(page.getByPlaceholder('••••••••••••')).toBeVisible();

        // 6. Verificar que el botón de submit del modal esté visible
        await expect(page.getByRole('button', { name: /entrar al sistema/i })).toBeVisible();
    });

    test('debe navegar a la sección de portafolios', async ({ page }) => {
        // 1. Localizar el enlace "Ver portafolios →"
        const linkPortafolios = page.getByRole('link', { name: /ver portafolios/i });

        // 2. Verificar que el enlace sea visible
        await expect(linkPortafolios).toBeVisible();

        // 3. Hacer clic y esperar navegación
        await linkPortafolios.click();

        // 4. Verificar que la URL sea la correcta (portafolios)
        await expect(page).toHaveURL(/.*portafolios/);
    });

});