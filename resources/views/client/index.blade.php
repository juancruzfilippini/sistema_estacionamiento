<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Lista de Clientes y Vehículos') }}
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
                    <!-- Formulario de búsqueda -->
                    <form method="GET" action="{{ route('client.index') }}" class="mb-6">
                        <div class="flex items-center">
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Buscar cliente por nombre o email"
                                class="border border-gray-300 rounded px-4 py-2 w-full">
                            <button type="submit"
                                class="ml-2 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                                Buscar
                            </button>
                        </div>
                    </form>

                    <!-- Tabla de clientes -->
                    <table class="table-auto w-full border-collapse border border-gray-300">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="border border-gray-300 px-4 py-2 text-left">Nombre del Cliente</th>
                                <th class="border border-gray-300 px-4 py-2 text-left">Contacto</th>
                                <th class="border border-gray-300 px-4 py-2 text-left">Domicilio</th>
                                <th class="border border-gray-300 px-4 py-2 text-left">Vehículos</th>
                                <th class="border border-gray-300 px-4 py-2 text-left">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($clients as $client)
                                <tr>
                                    <td class="border border-gray-300 px-4 py-2">{{ $client->name }}
                                        {{ $client->last_name }}</td>
                                    <td class="border border-gray-300 px-4 py-2">
                                        @if (empty($client->email) && empty($client->phone))
                                            Sin contacto registrado
                                        @else
                                            {{ $client->email ?: 'Sin email registrado' }} - Tel:
                                            {{ $client->phone ?: 'Sin teléfono registrado' }}
                                        @endif
                                    </td>
                                    <td class="border border-gray-300 px-4 py-2">
                                        @if (empty($client->address))
                                            Sin dirección registrada
                                        @else
                                            {{ $client->address }} 
                                        @endif
                                    </td>

                                    <td class="border border-gray-300 px-4 py-2">
                                        <ul>
                                            @foreach ($client->vehicles as $vehicle)
                                                <li>
                                                    {{ $vehicle->brand->name }} {{ $vehicle->model->name }} -
                                                    {{ $vehicle->patent }}
                                                </li>
                                            @endforeach
                                        </ul>
                                    </td>
                                    <td class="border border-gray-300 px-4 py-2">
                                        <div class="flex space-x-1">

                                            <!-- Botón editar (modal) -->
                                            <button
                                                class="px-2 py-1 bg-green-500 text-white text-sm rounded hover:bg-green-600 open-edit-modal inline"
                                                data-id="{{ $client->id }}">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </button>

                                            <!-- Botón pagos -->
                                            <a href="{{ route('payments.index', $client->id) }}"
                                                class="px-2 py-1 bg-blue-500 text-white text-sm rounded hover:bg-blue-600 inline">
                                                <i class="fa-solid fa-file"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="border border-gray-300 px-4 py-2 text-center">
                                        No se encontraron clientes.
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

<!-- Modal de edición de cliente -->
<div id="editClientModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-2xl p-6 relative">
        <h2 class="text-lg font-semibold mb-4">Editar Cliente</h2>
        <form id="editClientForm" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" name="client_id" id="edit_client_id">

            <div class="mb-4">
                <label for="edit_name" class="block text-sm font-medium">Nombre</label>
                <input type="text" name="name" id="edit_name" class="w-full border rounded p-2">
            </div>
            <div class="mb-4">
                <label for="edit_last_name" class="block text-sm font-medium">Apellido</label>
                <input type="text" name="last_name" id="edit_last_name" class="w-full border rounded p-2">
            </div>

            <div class="mb-4">
                <label for="edit_email" class="block text-sm font-medium">Email</label>
                <input type="email" name="email" id="edit_email" class="w-full border rounded p-2">
            </div>

            <div class="mb-4">
                <label for="edit_phone" class="block text-sm font-medium">Teléfono</label>
                <input type="text" name="phone" id="edit_phone" class="w-full border rounded p-2">
            </div>
            <div class="mb-4">
                <label for="edit_address" class="block text-sm font-medium">Domicilio</label>
                <input type="text" name="address" id="edit_address" class="w-full border rounded p-2">
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
        const modal = document.getElementById('editClientModal');
        const form = document.getElementById('editClientForm');

        document.querySelectorAll('.open-edit-modal').forEach(button => {
            button.addEventListener('click', () => {
                const clientId = button.dataset.id;

                fetch(`/sistema_estacionamiento/public/clients/${clientId}/data`)
                    .then(res => res.json())
                    .then(data => {
                        form.action = `/sistema_estacionamiento/public/clients/${clientId}`;
                        document.getElementById('edit_client_id').value = clientId;
                        document.getElementById('edit_name').value = data.name;
                        document.getElementById('edit_last_name').value = data.last_name;
                        document.getElementById('edit_email').value = data.email;
                        document.getElementById('edit_phone').value = data.phone;
                        document.getElementById('edit_address').value = data.address;

                        modal.classList.remove('hidden');
                    });
            });
        });

        document.querySelectorAll('.close-modal').forEach(btn => {
            btn.addEventListener('click', () => {
                modal.classList.add('hidden');
            });
        });
    });
</script>
