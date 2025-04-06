<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <a href="{{ route('dashboard') }}" class="flex items-center">
                    <img src="https://raw.githubusercontent.com/juancruzfilippini/logo-presupuestos/289dc3004683ac2d5af59c3b3ef13e435823400e/logo%20horizontal%20recortado.png"
                        alt="Logo Presupuestos" class="h-10 w-auto">
                </a>


                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex items-center">
                    <x-nav-link :href="route('client.create')" :active="request()->routeIs('client.create')">
                        {{ __('Registrar cliente') }}
                    </x-nav-link>


                    <!-- Dropdown Navigation -->
                    <div class="relative flex items-center">
                        <button id="dropdownButton"
                            class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 hover:text-gray-900 focus:outline-none">
                            {{ __('Buscar') }}
                            <svg class="ml-1 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <!-- Dropdown Menu -->
                        <div id="dropdownMenu"
                            class="absolute left-0 top-full mt-2 hidden w-48 bg-white border border-gray-200 rounded-md shadow-lg z-10">
                            <a href="{{ route('client.index') }}"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900">
                                {{ __('Ver Clientes') }}
                            </a>
                            <a href="{{ route('vehicle.index') }}"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900">
                                {{ __('Ver Vehículos') }}
                            </a>
                        </div>
                    </div>

                    <x-nav-link :href="route('payments.create')" :active="request()->routeIs('payments.create')">
                        {{ __('Generar pago') }}
                    </x-nav-link>

                    <x-nav-link :href="route('tariff.create')" :active="request()->routeIs('tariff.create')">
                        {{ __('Gestionar tarifas') }}
                    </x-nav-link>

                    <!-- JavaScript -->
                    <script>
                        document.addEventListener('DOMContentLoaded', () => {
                            const dropdownButton = document.getElementById('dropdownButton');
                            const dropdownMenu = document.getElementById('dropdownMenu');

                            dropdownButton.addEventListener('click', () => {
                                dropdownMenu.classList.toggle('hidden'); // Show/hide menu on click
                            });

                            // Close dropdown if clicked outside
                            document.addEventListener('click', (event) => {
                                if (!dropdownButton.contains(event.target) && !dropdownMenu.contains(event.target)) {
                                    dropdownMenu.classList.add('hidden'); // Hide menu
                                }
                            });
                        });
                    </script>

                </div>



            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>


                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
