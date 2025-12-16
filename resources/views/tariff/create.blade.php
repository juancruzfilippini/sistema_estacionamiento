<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Crear Nueva Tarifa') }}
        </h2>
    </x-slot>

    
    <div class="py-8">
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

                    <form action="{{ route('tariff.store') }}" method="POST" class="space-y-8">
                        @csrf

                        <!-- Valor de la tarifa -->
                        <div class="space-y-6">
                            <div class="flex space-x-4">
                                <div class="w-1/3">
                                    <label for="description" class="block text-sm font-medium text-gray-700">Descripcion
                                        de la tarifa</label>
                                    <div class="relative mt-1">
                                        <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                            <i class="fas fa-comment text-gray-400"></i>
                                        </span>
                                        <input type="text" id="description" name="description" step="0.01"
                                            min="0" required
                                            class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                            value="{{ old('description') }}">
                                    </div>
                                </div>
                                <div class="w-1/3">

                                    <label for="value" class="block text-sm font-medium text-gray-700">Valor</label>
                                    <div class="relative mt-1">
                                        <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                            <i class="fas fa-dollar-sign text-gray-400"></i>
                                        </span>
                                        <input type="number" id="value" name="value" step="0.01"
                                            min="0" required
                                            class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                            value="{{ old('value') }}">
                                    </div>
                                </div>
                                <div class="w-1/3">
                                    <label for="type" class="block text-sm font-medium text-gray-700">Tipo de
                                        Vehículo</label>
                                    <div class="relative mt-1">
                                        <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                            <i class="fas fa-car text-gray-400"></i>
                                        </span>
                                        <select id="type" name="type" required
                                            class=" h-10 pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                            <option value="auto" {{ old('type') == 'auto' ? 'selected' : '' }}>
                                                Auto
                                            </option>
                                            <option value="camioneta"
                                                {{ old('type') == 'camioneta' ? 'selected' : '' }}>Camioneta
                                            </option>
                                            <option value="moto" {{ old('type') == 'moto' ? 'selected' : '' }}>
                                                Moto
                                            </option>
                                            <option value="otro" {{ old('type') == 'otro' ? 'selected' : '' }}>
                                                Otro
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Tipo de vehículo -->

                        </div>

                        <!-- Botón para enviar el formulario -->
                        <div class="flex justify-end">
                            <button type="submit" class="btn bg-green-500 hover:bg-green-700 text-white px-4 py-2 rounded-md">
                                <i class="fa-solid fa-save mr-2"></i> Crear Tarifa
                            </button>
                        </div>
                    </form>

                    <!-- Listado de tarifas existentes -->
                    <div class="mt-8">
                        <h3 class="text-lg font-semibold mb-4">Tarifas Existentes</h3>
                        <table class="table-auto w-full text-left border-none border border-gray-300">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2">Descripción</th>
                                    <th class="px-4 py-2">Valor</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tariffs as $tariff)
                                    <tr id="tariff-row-{{ $tariff->id }}">
                                        <td class=" px-4 py-2">
                                            <input type="text" value="{{ $tariff->description }}"
                                                class="tariff-input w-full" data-id="{{ $tariff->id }}"
                                                data-field="description">
                                        </td>
                                        <td class=" px-4 py-2">
                                            <input type="number" value="{{ $tariff->value }}" class="tariff-input"
                                                data-id="{{ $tariff->id }}" data-field="value" step="0.01"
                                                min="0">
                                        </td>
                                        <td class="border-none py-2 flex space-x-2">
                                            <button onclick="updateTariff({{ $tariff->id }})"
                                                class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                                <i class="fa-solid fa-save"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmDelete(tariffId) {
        Swal.fire({
            title: '¿Estás seguro?',
            text: "Esta acción no se puede deshacer.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                // Enviar el formulario para eliminar
                document.getElementById(`delete-form-${tariffId}`).submit();
            }
        });
    }

    function updateTariff(tariffId) {
        let inputs = document.querySelectorAll(`.tariff-input[data-id='${tariffId}']`);
        let data = {};

        inputs.forEach(input => {
            data[input.dataset.field] = input.value;
        });

        fetch(`/sistema_estacionamiento/public/tariff/update/${tariffId}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire('Éxito', 'Tarifa actualizada correctamente', 'success');
                } else {
                    Swal.fire('Error', 'No se pudo actualizar la tarifa', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire('Error', 'Hubo un problema al actualizar la tarifa', 'error');
            });
    }
</script>
