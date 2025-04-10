<script src="//unpkg.com/alpinejs" defer></script>

<x-app-layout>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <x-slot name="header">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Gestión de Marcas y Modelos</h2>
            </x-slot>

            <div class="py-6 max-w-5xl mx-auto space-y-4">
                <!-- Formulario agregar marca -->
                <form action="{{ route('brands.store') }}" method="POST" class="flex space-x-2 items-end">
                    @csrf
                    <div>
                        <input type="text" name="name" class="rounded border w-64" required placeholder="Agregar marca">
                    </div>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 h-10">
                        <i class="fa-solid fa-plus"></i>
                    </button>
                </form>

                <!-- Listado de marcas -->
                @foreach ($brands as $brand)
                    <div x-data="{ open: false }" class="border p-4 rounded shadow">
                        <button @click="open = !open"
                            class="font-semibold text-lg text-left w-full flex justify-between items-center">
                            {{ $brand->name }}
                            <svg x-show="!open" class="w-5 h-5" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path d="M19 9l-7 7-7-7" />
                            </svg>
                            <svg x-show="open" class="w-5 h-5" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path d="M5 15l7-7 7 7" />
                            </svg>
                        </button>

                        <div x-show="open" class="mt-2">
                            <ul class="list-disc list-inside mb-2">
                                @foreach ($brand->models as $model)
                                    <li>{{ $model->name }}</li>
                                @endforeach
                            </ul>

                            <!-- Formulario para agregar modelo -->
                            <form action="{{ route('models.store', $brand->id) }}" method="POST"
                                class="flex space-x-2 mt-2">
                                @csrf
                                <input type="text" name="name" placeholder="Nuevo modelo"
                                    class="border rounded p-2 w-64" required>
                                <button type="submit"
                                    class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600"><i class="fa-solid fa-plus"></i></button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
