{{-- 
    🧩 COMPONENTE: NAVBAR PRO

    Características:
    - Responsive con menú móvil desplegable
    - Alpine interno para toggle del menú
--}}

<nav 
    x-data="{ abierto: false }"
    class="bg-[#050B36] text-white px-6 py-4 w-full"
>

    <div class="max-w-full mx-auto flex items-center justify-between w-full">

        {{-- Logo con imagen a la izquierda --}}
        <div class="flex items-center space-x-4">
            <img src="/images/umss-logo.png" alt="Logo" class="h-10">
            <h1 class="text-xl font-bold">
                Sansi<span class="text-red-500">Folios</span>
            </h1>
        </div>

        {{-- Menú de escritorio --}}
        <div class="hidden sm:flex space-x-6 items-center text-sm sm:text-base">
            <a href="#" class="text-[#35FFE6] hover:underline">Inicio</a>
            <a href="#" class="hover:underline">Portafolios</a>
            <button id="openLoginModal" class="hover:underline">Iniciar Sesión</button>
            {{-- Botón registrarse --}}
            <button id="openRegisterModal" class="bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-500">Registrarse</button>
        </div>

        {{-- Botón menú móvil --}}
        <button 
            @click="abierto = !abierto"
            class="sm:hidden text-2xl"
            aria-label="Abrir menú"
        >
            ☰
        </button>

    </div>

    {{-- Menú móvil --}}
    <div 
        x-show="abierto"
        x-transition
        class="sm:hidden mt-4 space-y-3 text-center"
    >
        <a href="#" class="block hover:underline">Inicio</a>
        <a href="#" class="block hover:underline">Portafolios</a>
        <button id="openLoginModalMobile" class="block hover:underline">Iniciar Sesión</button>
        <button id="openRegisterModalMobile" class="block py-2 px-4 bg-blue-600 text-white rounded-md hover:bg-blue-500">Registrarse</button>
    </div>

</nav>
