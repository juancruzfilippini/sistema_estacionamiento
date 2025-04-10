<?php

namespace App\Http\Controllers;

use App\Models\Brands;
use App\Models\Models;

use Illuminate\Http\Request;

class ModelController extends Controller
{
    public function store(Request $request, $brandId)
    {
        $request->validate(['name' => 'required|string']);
        $brand = Brands::findOrFail($brandId);
        $brand->models()->create(['name' => strtoupper($request->name)]);

        return redirect()->route('brands.index')->with('success', 'Modelo agregado correctamente.');
    }

}
