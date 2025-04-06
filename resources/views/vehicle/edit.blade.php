<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Editar Vehículo
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('vehicle.update', $vehicle->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="flex space-x-4">
                            <div class="mb-4 w-1/2">
                                <label for="brand" class="block text-sm font-medium text-gray-700">Marca</label>
                                <select id="brand" name="brand_id"
                                    class="h-10 p-2 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    required>
                                    <option value="">Seleccione una marca</option>
                                    @foreach ($brands as $brand)
                                        <option value="{{ $brand->id }}"
                                            {{ $vehicle->brand_id == $brand->id ? 'selected' : '' }}>
                                            {{ $brand->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-4 w-1/2">
                                <label for="model" class="block text-sm font-medium text-gray-700">Modelo</label>
                                <select id="model" name="model_id"
                                    class="h-10 p-2 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    required>
                                </select>
                            </div>
                        </div>


                        <div class="flex space-x-4">
                            <div class="mb-4 w-1/2">
                                <label for="license_plate" class="block text-sm font-medium text-gray-700">Placa</label>
                                <input type="text" id="license_plate" name="license_plate"
                                    value="{{ $vehicle->patent }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    required>
                            </div>

                            <div class="mb-4 w-1/2">
                                <label for="color" class="block text-sm font-medium text-gray-700">Color</label>
                                <input type="text" id="color" name="color" value="{{ $vehicle->color }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    required>
                            </div>
                        </div>
                        <div class="flex justify-end">
                            <button type="submit"
                                class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                                <i class="fa-solid fa-save"></i> Guardar Cambios
                            </button>
                        </div>
                    </form>

                    <div class="mt-4">
                        <a href="{{ route('vehicle.index') }}" class="text-blue-500 hover:underline">Volver a la lista
                            de vehículos</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const brandSelect = document.getElementById('brand');
        const modelSelect = document.getElementById('model');
        const selectedModelId = {{ $vehicle->model_id }};

        function loadModels(brandId, selectedModelId = null) {
            fetch(`/sistema_estacionamiento/public/get-models/${brandId}`)
                .then(response => response.json())
                .then(data => {
                    modelSelect.innerHTML = '<option value="">Seleccione un modelo</option>';
                    data.forEach(model => {
                        const option = document.createElement('option');
                        option.value = model.id;
                        option.text = model.name;
                        if (model.id == selectedModelId) option.selected = true;
                        modelSelect.appendChild(option);
                    });
                });
        }

        // Cargar modelos al inicio con la marca actual
        if (brandSelect.value) {
            loadModels(brandSelect.value, selectedModelId);
        }

        // Cargar modelos cuando cambie la marca
        brandSelect.addEventListener('change', function() {
            loadModels(this.value);
        });
    });
</script>
