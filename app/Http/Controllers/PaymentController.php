<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Mail\PaymentReceiptMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Models\Clients;
use App\Models\Payments;
use App\Models\Vehicles;
use Carbon\Carbon;

class PaymentController extends Controller
{
    public function index($vehicleId)
    {
        $vehicle = Vehicles::with('payments.client')->findOrFail($vehicleId);
        $payments = $vehicle->payments; // Asumiendo que tienes la relación definida en el modelo Vehicle

        return view('payment.index', compact('vehicle', 'payments'));
    }


    public function create()
    {
        $clients = Clients::all();
        return view('payment.create', compact('clients'));
    }

    public function store(Request $request)
    {
        //dd($request->all());
        $currentDay = now()->format('Y-m-d');
        $client = Clients::findOrFail($request->client_id);
        $vehicle = Vehicles::findOrFail($request->vehicle_id);

        // Verificar si ya existe un pago para el vehículo en este mes
        $payment = Payments::where('vehicle_id', $request->vehicle_id)
            ->where('billing_month', $request->billing_month)
            ->first();

        if ($payment) {
            return redirect()->back()->with('error', 'Este vehículo ya tiene un pago registrado para este mes.');
        }

        // Crear el pago
        $payment = Payments::create([
            'vehicle_id' => $request->vehicle_id,
            'client_id' => $request->client_id,
            'amount' => $request->amount,
            'payment_date' => $currentDay,
            'billing_month' => $request->billing_month,
            'type' => $request->type,
        ]);

        if ($request->billing_month == now()->format('m-Y')) {
            // ✅ Actualizar el estado del vehículo a "paid"
            Vehicles::where('id', $request->vehicle_id)->update(['status' => 'paid']);
        }

        // ✅ Generar el PDF en memoria
        $pdf = PDF::loadView('pdf.receipt', compact('payment'))->output();

        if ($request->has('send_mail') && $client->email) {
            // ✅ Enviar email con el PDF adjunto
            Mail::to($client->email)->send(new PaymentReceiptMail($payment, $client, $vehicle, $pdf));
            return redirect()->route('dashboard')->with('success', 'Pago registrado correctamente. Comprobante enviado por mail');
        } else if(!$client->email) {
            return redirect()->route('dashboard')->with('success', 'Pago registrado correctamente. Mail NO registrado');
        } else{
            return redirect()->route('dashboard')->with('success', 'Pago registrado correctamente.');
        }
        

    }


    public function generateReceipt($id)
    {
        $payment = Payments::with('client', 'vehicle')->findOrFail($id);

        $pdf = PDF::loadView('pdf.receipt', compact('payment'));

        return $pdf->stream('recibo_pago.pdf'); // Muestra el PDF en el navegador
        // return $pdf->download('recibo_pago.pdf'); // Para forzar la descarga
    }

    public function getPaidMonths($vehicleId)
    {
        $paid = Payments::where('vehicle_id', $vehicleId)
            ->pluck('billing_month') // formato MM-YYYY
            ->toArray();

        return response()->json(['paidMonths' => $paid]);
    }


}
