<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Payments;
use Carbon\Carbon;

class UpdatePaymentStatus extends Command
{
    protected $signature = 'payments:update-status';
    protected $description = 'Actualiza los pagos vencidos a "overdue" si no han sido pagados después del día 10';

    public function handle()
    {
        $today = Carbon::now();
        $currentMonth = $today->format('Y-m');

        if ($today->day > 10) {
            Payments::where('billing_month', $currentMonth)
                ->where('status', 'pending')
                ->update(['status' => 'overdue']);
            
            $this->info('Pagos vencidos actualizados.');
        } else {
            $this->info('Aún no es el día 10 del mes.');
        }
    }
}
