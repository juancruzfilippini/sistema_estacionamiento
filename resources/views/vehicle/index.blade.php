<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Lista de Vehículos y Dueños') }}
        </h2>
    </x-slot>

    <div class="py-12" style="margin-bottom: 1000px">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
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
                    <form method="GET" action="{{ route('vehicle.index') }}" class="mb-6">
                        <div class="flex items-center">
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Buscar vehículo por marca, modelo o placa"
                                class="border border-gray-300 rounded px-4 py-2 w-full">
                            <button type="submit"
                                class="ml-2 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                                Buscar
                            </button>
                        </div>
                    </form>


                    <!-- Tabla de vehículos -->
                    <table class="table-auto w-full border-collapse border border-gray-300">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="border border-gray-300 px-4 py-2 text-left">Vehiculo</th>
                                <th class="border border-gray-300 px-4 py-2 text-left">Color</th>
                                <th class="border border-gray-300 px-4 py-2 text-left">Patente</th>
                                <th class="border border-gray-300 px-4 py-2 text-left">Dueños</th>
                                <th class="border border-gray-300 px-4 py-2 text-left">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($vehicles as $vehicle)
                                <tr>
                                    <td class="border border-gray-300 px-4 py-2">{{ $vehicle->brand->name }}
                                        {{ $vehicle->model->name }}</td>
                                    <td class="border border-gray-300 px-4 py-2">{{ $vehicle->color }}</td>
                                    <td class="border border-gray-300 px-4 py-2">{{ $vehicle->patent }}</td>
                                    <td class="border border-gray-300 px-4 py-2">
                                        <ul>
                                            @foreach ($vehicle->clients as $client)
                                                <li>{{ $client->name }} {{ $client->last_name }}</li>
                                            @endforeach
                                        </ul>
                                    </td>
                                    <td class="border border-gray-300 px-4 py-2">
                                        <div class="flex space-x-1">
                                            <!-- Botón eliminar -->
                                            <form method="POST" class="delete-form" data-id="{{ $vehicle->id }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="px-2 py-1 bg-red-500 text-white text-sm rounded hover:bg-red-600 inline">
                                                    <i class="fa-solid fa-trash-can"></i>
                                                </button>
                                            </form>

                                            <!-- Botón editar (modal) -->
                                            <button
                                                class="px-2 py-1 bg-green-500 text-white text-sm rounded hover:bg-green-600 open-edit-modal inline"
                                                data-id="{{ $vehicle->id }}">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </button>

                                            <!-- Botón pagos -->
                                            <a href="{{ route('payments.index', $vehicle->id) }}"
                                                class="px-2 py-1 bg-blue-500 text-white text-sm rounded hover:bg-blue-600 inline">
                                                <i class="fa-solid fa-file"></i>
                                            </a>
                                        </div>
                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="border border-gray-300 px-4 py-2 text-center">
                                        No se encontraron vehículos.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>

                    </table>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<!-- En tu layout (por ejemplo en el head o antes del cierre de body) -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('.delete-form').forEach(form => {
            form.addEventListener('submit', function (e) {
                e.preventDefault();
                Swal.fire({
                    title: '¿Eliminar vehículo?',
                    text: "Esta acción no se puede deshacer",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    });
</script>


<!-- Modal de edición de vehículo -->
<div id="editVehicleModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-2xl p-6 relative">
        <h2 class="text-lg font-semibold mb-4">Editar Vehículo</h2>
        <form id="editVehicleForm" action="{{ route('vehicle.update', $vehicle->id) }}" method="POST">
            @csrf
            @method('PUT')

            <input type="hidden" name="vehicle_id" id="vehicle_id">

            <div class="flex space-x-2">
                <div class="mb-4 w-1/2">
                    <label for="brand_id" class="block text-sm font-medium">Marca</label>
                    <select id="edit_brand" name="brand_id" class="w-full border rounded p-2">
                        <option value="">Seleccione una marca</option>
                        @foreach ($brands as $brand)
                            <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4 w-1/2">
                    <label for="model_id" class="block text-sm font-medium">Modelo</label>
                    <select id="edit_model" name="model_id" class="w-full border rounded p-2"></select>
                </div>
            </div>
            <div class="flex space-x-2">
                <div class="mb-4 w-1/2">
                    <label for="patent" class="block text-sm font-medium">Patente</label>
                    <input type="text" name="patent" id="edit_patent" class="w-full border rounded p-2">
                </div>

                <div class="mb-4 w-1/2">
                    <label for="color" class="block text-sm font-medium">Color</label>
                    <input type="text" name="color" id="edit_color" class="w-full border rounded p-2">
                </div>
            </div>
            <div class="flex justify-end">
                <button type="button" class="ml-2 p-2 text-gray-500 hover:underline close-modal">Cancelar</button>
                <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                    Guardar Cambios
                </button>
            </div>
        </form>
    </div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', () => {
        const modal = document.getElementById('editVehicleModal');
        const form = document.getElementById('editVehicleForm');
        const brandSelect = document.getElementById('edit_brand');
        const modelSelect = document.getElementById('edit_model');

        document.querySelectorAll('.open-edit-modal').forEach(btn => {
            btn.addEventListener('click', () => {
                const vehicleId = btn.dataset.id;

                fetch(`/sistema_estacionamiento/public/vehicles/${vehicleId}/data`)
                    .then(res => res.json())
                    .then(data => {
                        form.action =
                            `/sistema_estacionamiento/public/vehicles/${vehicleId}`;
                        document.getElementById('vehicle_id').value = vehicleId;
                        document.getElementById('edit_patent').value = data.patent;
                        document.getElementById('edit_color').value = data.color;
                        brandSelect.value = data.brand_id;

                        fetch(`/sistema_estacionamiento/public/get-models/${data.brand_id}`)
                            .then(res => res.json())
                            .then(models => {
                                modelSelect.innerHTML =
                                    '<option value="">Seleccione un modelo</option>';
                                models.forEach(model => {
                                    const opt = document.createElement(
                                        'option');
                                    opt.value = model.id;
                                    opt.text = model.name;
                                    if (model.id == data.model_id) opt
                                        .selected = true;
                                    modelSelect.appendChild(opt);
                                });
                            });

                        modal.classList.remove('hidden');
                    });
            });
        });

        // Cargar modelos al cambiar la marca
        brandSelect.addEventListener('change', () => {
            const brandId = brandSelect.value;
            fetch(`/sistema_estacionamiento/public/get-models/${brandId}`)
                .then(res => res.json())
                .then(models => {
                    modelSelect.innerHTML = '<option value="">Seleccione un modelo</option>';
                    models.forEach(model => {
                        const opt = document.createElement('option');
                        opt.value = model.id;
                        opt.text = model.name;
                        modelSelect.appendChild(opt);
                    });
                });
        });

        // Cerrar el modal
        document.querySelectorAll('.close-modal').forEach(el => {
            el.addEventListener('click', () => {
                modal.classList.add('hidden');
            });
        });
    });
</script>
