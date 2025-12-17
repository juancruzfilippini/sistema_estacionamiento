<x-app-layout>
    <div class="max-w-7xl mx-auto py-10 space-y-8">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <div>
                <p class="text-sm text-gray-500">Panel de métricas</p>
                <h1 class="text-3xl font-bold text-gray-800">Desempeño {{ $currentYear }}</h1>
            </div>
            <div class="bg-blue-50 border border-blue-200 text-blue-700 px-4 py-2 rounded-lg font-semibold">
                Datos calculados en base a los pagos registrados por mes.
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white shadow rounded-lg p-4 border-l-4 border-emerald-500">
                <p class="text-sm text-gray-500">Total recaudado</p>
                <p class="text-2xl font-bold text-gray-900">${{ number_format($yearTotals['total_amount'], 2, ',', '.') }}</p>
            </div>
            <div class="bg-white shadow rounded-lg p-4 border-l-4 border-indigo-500">
                <p class="text-sm text-gray-500">Pagos registrados</p>
                <p class="text-2xl font-bold text-gray-900">{{ $yearTotals['payments_count'] }}</p>
            </div>
            <div class="bg-white shadow rounded-lg p-4 border-l-4 border-amber-500">
                <p class="text-sm text-gray-500">Vehículos abonando</p>
                <p class="text-2xl font-bold text-gray-900">{{ $yearTotals['vehicles_count'] }}</p>
            </div>
            <div class="bg-white shadow rounded-lg p-4 border-l-4 border-rose-500">
                <p class="text-sm text-gray-500">Clientes alcanzados</p>
                <p class="text-2xl font-bold text-gray-900">{{ $yearTotals['clients_count'] }}</p>
            </div>
        </div>

        @if ($yearTotals['best_month'])
            <div class="bg-gradient-to-r from-indigo-600 to-blue-500 text-white rounded-xl shadow p-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <p class="text-sm uppercase tracking-wide">Mes con mayor recaudación</p>
                    <h2 class="text-2xl font-bold">{{ $yearTotals['best_month']['label'] }}</h2>
                </div>
                <div class="text-right">
                    <p class="text-sm">Ingresos</p>
                    <p class="text-3xl font-extrabold">${{ number_format($yearTotals['best_month']['total_amount'], 2, ',', '.') }}</p>
                </div>
            </div>
        @endif

        <div class="bg-white shadow rounded-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">Detalle mensual</h3>
                    <p class="text-sm text-gray-500">Comparativo de pagos, montos y vehículos únicos por mes.</p>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mes</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total recaudado</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pagos</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Vehículos</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Clientes</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ticket promedio</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($monthlyStats as $month)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $month['label'] }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">${{ number_format($month['total_amount'], 2, ',', '.') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $month['payments_count'] }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $month['vehicles_count'] }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $month['clients_count'] }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">${{ number_format($month['average_amount'], 2, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
