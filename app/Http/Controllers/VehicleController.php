<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tariffs;
use App\Models\Vehicles;
use App\Models\Clients;
use App\Models\Brands;
use App\Models\Models;
use Carbon\Carbon;


class VehicleController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $brands = Brands::all();
        $models = Models::all();
        $tariffs = Tariffs::all();

        $vehicles = Vehicles::with('clients')
            ->whereNull('deleted_at') // Excluir los vehículos eliminados lógicamente
            ->when($search, function ($query, $search) {
                return $query->where(function ($query) use ($search) {
                    $query->where('brand', 'like', "%$search%")
                        ->orWhere('model', 'like', "%$search%")
                        ->orWhere('patent', 'like', "%$search%");
                });
            })
            ->get();

        return view('vehicle.index', compact('vehicles', 'search', 'brands', 'models', 'tariffs'));
    }

    public function edit($id)
    {
        $vehicle = Vehicles::findOrFail($id);
        $brands = Brands::all();
        $models = Models::all();
        return view('vehicle.edit', compact('vehicle', 'brands', 'models'));
    }

    public function update(Request $request, $id)
    {
        $vehicle = Vehicles::findOrFail($id);

        // Convertir patente y color a mayúsculas
        $data = $request->all();
        $data['patent'] = strtoupper($data['patent']);
        $data['color'] = strtoupper($data['color']);

        $vehicle->update($data);

        return redirect()->route('vehicle.index')->with('success', 'Vehículo actualizado correctamente');
    }


    public function destroy($id)
    {
        $vehicle = Vehicles::findOrFail($id);
        $vehicle->delete(); // Esto usa soft deletes

        return redirect()->route('vehicle.index')->with('success', 'Vehículo eliminado correctamente.');
    }

    // Obtener vehículos por cliente
    public function getVehiclesByClient($clientId)
    {
        $client = Clients::with(['vehicles.brand', 'vehicles.model'])->find($clientId);

        if (!$client) {
            return response()->json(['error' => 'Cliente no encontrado'], 404);
        }

        return response()->json(['vehicles' => $client->vehicles]);
    }


    // Obtener la tarifa del vehículo
    public function getVehicleTariff($vehicleId)
    {
        $vehicle = Vehicles::with('tariff')->find($vehicleId);

        if (!$vehicle || !$vehicle->tariff) {
            return response()->json(['error' => 'Vehículo o tarifa no encontrada'], 404);
        }
        return response()->json(['tariff' => $vehicle->tariff->value]);

    }

    public function getVehicleData($id)
    {
        $vehicle = Vehicles::with(['brand', 'model'])->findOrFail($id);

        return response()->json([
            'id' => $vehicle->id,
            'brand_id' => $vehicle->brand_id,
            'model_id' => $vehicle->model_id,
            'patent' => $vehicle->patent,
            'color' => $vehicle->color,
            'tariff_id' => $vehicle->tariff_id,
        ]);
    }





}
