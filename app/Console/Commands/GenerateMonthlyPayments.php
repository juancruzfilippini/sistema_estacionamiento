<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Clients;
use App\Models\Payments;
use Carbon\Carbon;

class GenerateMonthlyPayments extends Command
{
    protected $signature = 'payments:generate';
    protected $description = 'Genera pagos pendientes para todos los clientes al inicio del mes';

    public function handle()
    {
        $currentMonth = Carbon::now()->format('Y-m'); // Año-Mes actual

        $clients = Clients::all();

        foreach ($clients as $client) {
            // Verificar si ya existe un pago para este mes
            $existingPayment = Payments::where('client_id', $client->id)
                ->where('billing_month', $currentMonth)
                ->first();

            if (!$existingPayment) {
                Payments::create([
                    'client_id' => $client->id,
                    'amount' => 10000, // Ajusta según el valor real de la cochera
                    'billing_month' => $currentMonth,
                    'status' => 'pending',
                ]);
            }
        }

        $this->info('Pagos generados exitosamente.');
    }
}
