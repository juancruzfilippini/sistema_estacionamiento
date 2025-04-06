<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Nuevo Cliente') }}
        </h2>
    </x-slot>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <form action="{{ route('client.store') }}" method="POST" class="space-y-8">
                        @csrf

                        <!-- Datos del Cliente -->
                        <div class="space-y-6">
                            <div class="flex space-x-4">
                                <div class="w-1/2">
                                    <label for="name" class="block text-sm font-medium text-gray-700">Nombre</label>
                                    <div class="relative mt-1">
                                        <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                            <i class="fas fa-user text-gray-400"></i>
                                        </span>
                                        <input type="text" id="name" name="name" required
                                            class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                            value="{{ old('name') }}">
                                    </div>
                                </div>
                                <div class="w-1/2">
                                    <label for="last_name"
                                        class="block text-sm font-medium text-gray-700">Apellido</label>
                                    <div class="relative mt-1">
                                        <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                            <i class="fas fa-user-tag text-gray-400"></i>
                                        </span>
                                        <input type="text" id="last_name" name="last_name" required
                                            class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                            value="{{ old('last_name') }}">
                                    </div>
                                </div>
                            </div>

                            <div class="flex space-x-4">
                                <div class="w-1/3">
                                    <label for="phone"
                                        class="block text-sm font-medium text-gray-700">Teléfono</label>
                                    <div class="relative mt-1">
                                        <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                            <i class="fas fa-phone text-gray-400"></i>
                                        </span>
                                        <input type="text" id="phone" name="phone" 
                                            class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                            value="{{ old('phone') }}">
                                    </div>
                                </div>
                                <div class="w-1/3">
                                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                    <div class="relative mt-1">
                                        <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                            <i class="fas fa-envelope text-gray-400"></i>
                                        </span>
                                        <input type="text" id="email" name="email" 
                                            class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                            value="{{ old('email') }}">
                                    </div>
                                </div>
                                <div class="w-1/3">
                                    <label for="address"
                                        class="block text-sm font-medium text-gray-700">Domicilio</label>
                                    <div class="relative mt-1">
                                        <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                            <i class="fas fa-home text-gray-400"></i>
                                        </span>
                                        <input type="text" id="address" name="address" 
                                            class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                            value="{{ old('address') }}">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Switch para autos -->
                        <div class="space-y-4">
                            <p class="text-sm font-medium text-gray-700">¿Qué desea hacer con el auto?</p>
                            <div class="flex items-center space-x-6">
                                <label class="flex items-center">
                                    <input type="radio" name="vehicle_option" value="new" class="form-radio"
                                        onclick="toggleVehicleOption('new')" checked>
                                    <span class="ml-2">Crear un auto nuevo</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="vehicle_option" value="existing" class="form-radio"
                                        onclick="toggleVehicleOption('existing')">
                                    <span class="ml-2">Asignar un auto existente</span>
                                </label>
                            </div>
                        </div>

                        <!-- Formulario para crear un nuevo auto -->
                        <div id="new-vehicle-form" class="space-y-6">
                            <h3 class="text-sm font-medium text-gray-700">Datos del Auto</h3>
                            <div class="flex space-x-4">
                                <div class="w-1/4 mt-1">
                                    <label for="brand" class="block text-sm font-medium text-gray-700">Marca</label>
                                    <select id="brand_id" name="brand_id"
                                        class="p-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 h-10">
                                        <option value=""></option>
                                        @foreach ($brands as $brand)
                                            <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="w-1/4 mt-1">
                                    <label for="model"
                                        class="block text-sm font-medium text-gray-700">Modelo</label>
                                    <select id="model_id" name="model_id"
                                        class="p-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 h-10"
                                        disabled>
                                        <option value=""></option>
                                    </select>
                                </div>
                                <div class="w-1/4">
                                    <label for="color"
                                        class="block text-sm font-medium text-gray-700">Color</label>
                                    <div class="relative mt-1">
                                        <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                            <i class="fas fa-palette text-gray-400"></i>
                                        </span>
                                        <input type="text" id="color" name="color"
                                            class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    </div>
                                </div>
                                <div class="w-1/4">
                                    <label for="type" class="block text-sm font-medium text-gray-700">Tipo</label>
                                    <div class="relative mt-1">
                                        <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                            <i class="fas fa-list text-gray-400"></i>
                                        </span>
                                        <select id="type" name="type"
                                            class="h-10 pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                            <option value="auto">Auto</option>
                                            <option value="camioneta">Camioneta</option>
                                            <option value="moto">Moto</option>
                                            <option value="otro">Otro</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="flex space-x-4">
                                <div class="w-1/2">
                                    <label for="patent"
                                        class="block text-sm font-medium text-gray-700">Patente</label>
                                    <div class="relative mt-1">
                                        <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                            <i class="fas fa-id-card text-gray-400"></i>
                                        </span>
                                        <input type="text" id="patent" name="patent"
                                            class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    </div>
                                </div>
                                <div class="w-1/2">
                                    <label for="tariff_id"
                                        class="block text-sm font-medium text-gray-700">Tarifa</label>
                                    <div class="relative mt-1">
                                        <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                            <i class="fas fa-dollar-sign text-gray-400"></i>
                                        </span>
                                        <select id="tariff_id" name="tariff_id"
                                            class="h-10 pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                            <option value="">Seleccione una tarifa</option>
                                            @foreach ($tariffs as $tariff)
                                                <option value="{{ $tariff->id }}">
                                                    {{ $tariff->description }} - ${{ $tariff->value }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>





                        <!-- Formulario para asignar un auto existente -->
                        <div id="existing-vehicle-form" class="hidden space-y-6">
                            <h3 class="text-sm font-medium text-gray-700">Seleccionar Auto</h3>
                            <div class="relative mt-1">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                    <i class="fas fa-car-side text-gray-400"></i>
                                </span>
                                <select name="vehicle_id" id="vehicle_id"
                                    class="pl-10 h-10 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    <option value="">Seleccione un auto</option>
                                    @foreach ($vehicles as $vehicle)
                                        <option value="{{ $vehicle->id }}">
                                            {{ $vehicle->brand }} - {{ $vehicle->model }} ({{ $vehicle->patent }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>


                        <div class="flex justify-end">
                            <button type="submit" class="btn bg-indigo-600 text-white px-4 py-2 rounded-md">
                                <i class="fa-solid fa-floppy-disk mr-2"></i> Registrar Cliente
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('brand_id').addEventListener('change', function() {
            let brandId = this.value;
            let modelSelect = document.getElementById('model_id');
            modelSelect.innerHTML = '<option value=""></option>';
            modelSelect.disabled = true;

            if (brandId) {
                fetch(`{{ url('get-models') }}/${brandId}`)

                    .then(response => response.json())
                    .then(data => {
                        data.forEach(model => {
                            let option = document.createElement('option');
                            option.value = model.id;
                            option.textContent = model.name;
                            modelSelect.appendChild(option);
                        });
                        modelSelect.disabled = false;
                    })
                    .catch(error => console.error('Error:', error));
            }
        });

        function toggleVehicleOption(option) {
            const newVehicleForm = document.getElementById('new-vehicle-form');
            const existingVehicleForm = document.getElementById('existing-vehicle-form');
            const tariffSelect = document.getElementById('tariff_id');

            if (option === 'new') {
                newVehicleForm.classList.remove('hidden');
                existingVehicleForm.classList.add('hidden');
                // Hacer obligatorio el campo de tarifa
                tariffSelect.setAttribute('required', 'required');
            } else {
                newVehicleForm.classList.add('hidden');
                existingVehicleForm.classList.remove('hidden');
                // Eliminar el atributo obligatorio del campo de tarifa
                tariffSelect.removeAttribute('required');
            }
        }
    </script>
</x-app-layout>
