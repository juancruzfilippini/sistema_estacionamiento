<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Vehicles;
use App\Models\Payments;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class UpdateVehicleStatus extends Command
{
    protected $signature = 'vehicles:update-status';
    protected $description = 'Actualiza el estado de los vehículos según los pagos';

    public function handle()
    {
        Log::info('🚗 Comando vehicles:update-status ejecutado a las ' . now());

        $currentMonth = now()->format('m-Y'); // Ejemplo: "03-2025"
        $today = now()->format('d');
        //$today = 1;

        // 1️⃣ Día 1: Marcar como "pending" solo los que NO tienen pago registrado del mes actual
        if ($today == 1) {
            $vehiclesWithoutPayment = Vehicles::whereNull('deleted_at')
                ->whereDoesntHave('payments', function ($query) use ($currentMonth) {
                    $query->where('billing_month', $currentMonth)
                        ->where('status', 'paid');
                })->get();

            foreach ($vehiclesWithoutPayment as $vehicle) {
                $vehicle->update(['status' => 'pending']);
            }

            $this->info("Se han marcado " . count($vehiclesWithoutPayment) . " vehículos como 'pending'.");
        }

        // 2️⃣ Día 10: Marcar como "overdue" los que SIGUEN sin pagar el mes actual
        if ($today == 10) {
            $vehiclesWithoutPayment = Vehicles::whereNull('deleted_at')
                ->whereDoesntHave('payments', function ($query) use ($currentMonth) {
                    $query->where('billing_month', $currentMonth)
                        ->where('status', 'paid');
                })->get();

            foreach ($vehiclesWithoutPayment as $vehicle) {
                $vehicle->update(['status' => 'overdue']);
            }

            $this->info("Se han marcado " . count($vehiclesWithoutPayment) . " vehículos como 'overdue'.");
        }
    }
}
