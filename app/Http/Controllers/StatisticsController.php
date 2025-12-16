<?php

namespace App\Http\Controllers;

use App\Models\Payments;
use Carbon\Carbon;

class StatisticsController extends Controller
{
    public function index()
    {
        $currentYear = now()->year;

        Carbon::setLocale('es');

        $payments = Payments::select('amount', 'billing_month', 'payment_date', 'vehicle_id', 'client_id')->get();

        $monthlyStats = collect();

        for ($month = 1; $month <= 12; $month++) {
            $monthDate = Carbon::createFromDate($currentYear, $month, 1);
            $billingKey = $monthDate->format('m-Y');

            $itemsForMonth = $payments->filter(function ($payment) use ($billingKey, $currentYear) {
                if (!$payment->billing_month) {
                    return false;
                }

                try {
                    $billingDate = Carbon::createFromFormat('m-Y', $payment->billing_month);
                } catch (\Exception $e) {
                    return false;
                }

                return $billingDate->year === $currentYear && $payment->billing_month === $billingKey;
            });

            $monthlyStats->push([
                'billing_month' => $billingKey,
                'label' => $monthDate->translatedFormat('F Y'),
                'total_amount' => $itemsForMonth->sum('amount'),
                'payments_count' => $itemsForMonth->count(),
                'vehicles_count' => $itemsForMonth->unique('vehicle_id')->count(),
                'clients_count' => $itemsForMonth->unique('client_id')->count(),
                'average_amount' => round($itemsForMonth->avg('amount'), 2) ?: 0,
            ]);
        }

        $bestMonth = $monthlyStats->sortByDesc('total_amount')->first();

        if ($bestMonth && $bestMonth['total_amount'] <= 0) {
            $bestMonth = null;
        }

        $yearTotals = [
            'total_amount' => $monthlyStats->sum('total_amount'),
            'payments_count' => $monthlyStats->sum('payments_count'),
            'vehicles_count' => $monthlyStats->sum('vehicles_count'),
            'clients_count' => $monthlyStats->sum('clients_count'),
            'best_month' => $bestMonth,
        ];

        return view('dashboard.metrics', [
            'monthlyStats' => $monthlyStats,
            'yearTotals' => $yearTotals,
            'currentYear' => $currentYear,
        ]);
    }
}
