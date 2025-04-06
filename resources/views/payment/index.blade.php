<x-app-layout>
    <div class="container mx-auto p-6">
        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-2xl font-bold mb-4">Pagos del Vehículo</h2>

            <p class="text-gray-700 mb-4"><strong>Vehículo:</strong> {{ $vehicle->brand->name }} - {{ $vehicle->model->name }} - {{ $vehicle->patent }}</p>

            @if ($payments->isEmpty())
                <p class="text-gray-500">No hay pagos registrados para este vehículo.</p>
            @else
                <table class="w-full border-collapse border border-gray-300">
                    <thead>
                        <tr class="bg-gray-200">
                            <th class="border border-gray-300 px-4 py-2">Fecha</th>
                            <th class="border border-gray-300 px-4 py-2">Mes de pago</th>
                            <th class="border border-gray-300 px-4 py-2">Cliente</th>
                            <th class="border border-gray-300 px-4 py-2">Monto</th>
                            <th class="border border-gray-300 px-4 py-2">Método</th>
                            <th class="border border-gray-300 px-4 py-2">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($payments as $payment)
                            <tr class="border border-gray-300">
                                <td class="px-4 py-2">{{ $payment->created_at->format('d/m/Y') }}</td>
                                <td class="px-4 py-2">{{ $payment->billing_month}}</td>
                                <td class="px-4 py-2">{{ $payment->client->name }} {{ $payment->client->last_name }}</td>
                                <td class="px-4 py-2 text-green-600 font-bold">${{ number_format($payment->amount, 2, ',', '.') }}</td>
                                <td class="px-4 py-2">{{ ucfirst($payment->type) }}</td>
                                <td class="px-4 py-2">
                                    <a href="{{ route('receipt.pdf', $payment->id) }}" target="_blank" 
                                       class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600">
                                        <i class="fa-solid fa-file-pdf"></i> Recibo
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</x-app-layout>
