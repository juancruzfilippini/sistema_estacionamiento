<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payments;
use App\Models\Vehicles;
use App\Models\Clients;
use App\Models\Tariffs;
use App\Models\Brands;
use App\Models\Models;


class ClientController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search'); // Obtener el valor de búsqueda
        $clients = Clients::with('vehicles')
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', "%$search%")
                    ->orWhere('last_name', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%");
            })
            ->get();

        return view('client.index', compact('clients', 'search'));
    }


    public function create()
    {
        $today = date('Y-m-d');
        $vehicles = Vehicles::all();
        $tariffs = Tariffs::all();
        $brands = Brands::all();
        $models = Models::all();

        return view('client.create', compact('today', 'vehicles', 'tariffs', 'models', 'brands'));
    }

    public function store(Request $request)
    {
        // Convierte los datos necesarios a mayúsculas excepto el email
        $data = $request->only('name', 'last_name', 'phone', 'address', 'email');
        $data['name'] = strtoupper($data['name']);
        $data['last_name'] = strtoupper($data['last_name']);
        $data['phone'] = strtoupper($data['phone']);
        $data['address'] = strtoupper($data['address']);
        $data['email'] = strtolower($data['email']);

        // Crear cliente
        $client = Clients::create($data);

        // Manejar opción de auto
        if ($request->vehicle_option === 'new') {
            $vehicleData = $request->only('brand_id', 'model_id', 'color', 'type', 'patent', 'tariff_id');
            $vehicleData['brand_id'] = strtoupper($vehicleData['brand_id']);
            $vehicleData['model_id'] = strtoupper($vehicleData['model_id']);
            $vehicleData['color'] = strtoupper($vehicleData['color']);
            $vehicleData['type'] = strtoupper($vehicleData['type']);
            $vehicleData['patent'] = strtoupper($vehicleData['patent']);

            $vehicle = Vehicles::create($vehicleData);
            $client->vehicles()->attach($vehicle->id);
        } elseif ($request->vehicle_option === 'existing') {
            $client->vehicles()->attach($request->vehicle_id);
        }

        return redirect()->route('dashboard')->with('success', 'Cliente creado correctamente.');
    }

    public function markAsPaid($paymentId)
    {
        $payment = Payments::findOrFail($paymentId);
        $payment->update([
            'status' => 'paid',
            'payment_date' => now(),
        ]);

        return back()->with('success', 'El pago ha sido registrado como pagado.');
    }

    public function pay(Request $request)
    {
        $currentMonth = now()->format('Y-m');

        // Buscar clientes y su estado de pago
        $clients = Clients::with([
            'payments' => function ($query) use ($currentMonth) {
                $query->where('billing_month', $currentMonth);
            }
        ])
            ->when($request->search, function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->search . '%');
            })
            ->get();

        return view('clients.index', compact('clients'));
    }

    public function getClientData($id)
    {
        $client = Clients::findOrFail($id);
        return response()->json($client);
    }

    public function update(Request $request, $id)
    {
        $client = Clients::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);

        $client->update([
            'name' => $request->name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        return redirect()->route('client.index')->with('success', 'Cliente actualizado correctamente');
    }


}
