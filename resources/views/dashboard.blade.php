<x-app-layout>
    <div class="max-w-7xl mx-auto py-12" style="margin-bottom: 530px">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Estado de Vehículos</h2>
        <div class="bg-white rounded-md">
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
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- 🚨 Deudores (rojo) -->
            <div class="bg-red-100 border-l-4 border-red-500 p-4 relative">
                <h3 class="text-xl font-semibold text-red-700">🚨 Deudores</h3>
                <input type="text" class="search-input w-full p-2 border-red-500 bg-red-100 rounded mt-2"
                    placeholder="Buscar..." data-list="overdue-list">
                <ul id="overdue-list" class="mt-2">
                    @foreach ($overdue as $vehicle)
                        <li class="text-red-600 relative group vehicle-item"
                            data-search="{{ $vehicle->brand->name ?? '' }} {{ $vehicle->model->name ?? '' }} {{ $vehicle->patent }} 
                    @foreach ($vehicle->clients as $client) {{ $client->name }} {{ $client->last_name }} @endforeach">
                            <span class="cursor-pointer hover:underline">
                                {{ $vehicle->brand->name ?? 'Sin marca' }} - {{ $vehicle->model->name ?? 'Sin modelo' }}
                                ({{ $vehicle->patent }})
                            </span>
                            <div
                                class="absolute left-0 top-6 z-50 w-56 bg-white text-gray-900 text-sm rounded-lg shadow-lg p-2 border border-gray-300 hidden group-hover:block">
                                <strong>Dueños:</strong>
                                <ul>
                                    @forelse ($vehicle->clients as $client)
                                        <li>{{ $client->name }} {{ $client->last_name }}</li>
                                    @empty
                                        <li>No tiene dueños registrados.</li>
                                    @endforelse
                                </ul>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- ⚠️ Pendientes (amarillo) -->
            <div class="bg-yellow-100 border-l-4 border-yellow-500 p-4 relative">
                <h3 class="text-xl font-semibold text-yellow-700">⚠️ Pendientes</h3>
                <input type="text" class="search-input w-full p-2 border-yellow-500 bg-yellow-100 rounded mt-2"
                    placeholder="Buscar..." data-list="pending-list">
                <ul id="pending-list" class="mt-2">
                    @foreach ($pending as $vehicle)
                        <li class="text-yellow-600 relative group vehicle-item"
                            data-search="{{ $vehicle->brand->name ?? '' }} {{ $vehicle->model->name ?? '' }} {{ $vehicle->patent }} 
                    @foreach ($vehicle->clients as $client) {{ $client->name }} {{ $client->last_name }} @endforeach">
                            <span class="cursor-pointer hover:underline">
                                {{ $vehicle->brand->name ?? 'Sin marca' }} -
                                {{ $vehicle->model->name ?? 'Sin modelo' }} ({{ $vehicle->patent }})
                            </span>
                            <div
                                class="absolute left-0 top-6 z-50 w-56 bg-white text-gray-900 text-sm rounded-lg shadow-lg p-2 border border-gray-300 hidden group-hover:block">
                                <strong>Dueños:</strong>
                                <ul>
                                    @forelse ($vehicle->clients as $client)
                                        <li>{{ $client->name }} {{ $client->last_name }}</li>
                                    @empty
                                        <li>No tiene dueños registrados.</li>
                                    @endforelse
                                </ul>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- ✅ Pagados (verde) -->
            <div class="bg-green-100 border-l-4 border-green-500 p-4 relative">
                <h3 class="text-xl font-semibold text-green-700">✅ Abonados</h3>
                <input type="text" class="search-input w-full p-2 border-green-500 bg-green-100 rounded mt-2"
                    placeholder="Buscar..." data-list="paid-list">
                <ul id="paid-list" class="mt-2">
                    @foreach ($paid as $vehicle)
                        <li class="text-green-600 relative group vehicle-item"
                            data-search="{{ $vehicle->brand->name ?? '' }} {{ $vehicle->model->name ?? '' }} {{ $vehicle->patent }} 
            @foreach ($vehicle->clients as $client) {{ $client->name }} {{ $client->last_name }} @endforeach">
                            <span class="cursor-pointer hover:underline">
                                {{ $vehicle->brand->name ?? 'Sin marca' }} -
                                {{ $vehicle->model->name ?? 'Sin modelo' }} ({{ $vehicle->patent }})
                            </span>
                            <div
                                class="absolute left-0 top-6 z-50 w-56 bg-white text-gray-900 text-sm rounded-lg shadow-lg p-2 border border-gray-300 hidden group-hover:block">
                                <strong>Dueños:</strong>
                                <ul>
                                    @forelse ($vehicle->clients as $client)
                                        <li>{{ $client->name }} {{ $client->last_name }}</li>
                                    @empty
                                        <li>No tiene dueños registrados.</li>
                                    @endforelse
                                </ul>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>

        </div>
    </div>

    <!-- Script de búsqueda sin afectar el tooltip -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.search-input').forEach(input => {
                input.addEventListener('keyup', function() {
                    let filter = this.value.toLowerCase();
                    let listId = this.getAttribute('data-list');
                    let list = document.getElementById(listId);
                    let items = list.querySelectorAll('.vehicle-item');

                    items.forEach(item => {
                        let searchText = item.getAttribute('data-search').toLowerCase();
                        if (searchText.includes(filter)) {
                            item.style.display = '';
                        } else {
                            item.style.display = 'none';
                        }
                    });
                });
            });
        });
    </script>
</x-app-layout>
z
