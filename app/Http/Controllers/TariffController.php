<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehicles;
use App\Models\Clients;
use App\Models\Tariffs;

class TariffController extends Controller
{
    public function create()
    {
        $tariffs = Tariffs::all();

        return view('tariff.create', compact('tariffs'));
    }

    public function store(Request $request)
    {
        //dd($request);

        $data = $request->only('description', 'value', 'time_unit', 'time_quantity', 'type');
        $data['description'] = strtoupper($data['description']);

        // Crear cliente
        $tariff = Tariffs::create($data);

        return redirect()->route('tariff.create')->with('success', 'Tarifa creada exitosamente.');
    }

    public function update(Request $request, $id)
    {
        $tariff = Tariffs::findOrFail($id);
        $tariff->update($request->all());

        return response()->json(['success' => true]);
    }


    public function destroy($id)
    {
        $tariff = Tariffs::findOrFail($id);
        $tariff->delete();

        return redirect()->back()->with('success', 'La tarifa fue eliminada correctamente.');
    }

}
