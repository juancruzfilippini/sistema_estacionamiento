<?php

namespace App\Http\Controllers;

use App\Models\Brands;
use App\Models\Models;

use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brands::with('models')->get();
        return view('brands.index', compact('brands'));
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|unique:brands,name']);
        Brands::create(['name' => strtoupper($request->name)]);

        return redirect()->route('brands.index')->with('success', 'Marca agregada correctamente.');
    }

}
