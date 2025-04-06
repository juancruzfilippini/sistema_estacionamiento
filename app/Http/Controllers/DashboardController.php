<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehicles;

class DashboardController extends Controller
{
    public function index()
    {
        $overdue = Vehicles::where('status', 'overdue')->get();
        $pending = Vehicles::where('status', 'pending')->get();
        $paid = Vehicles::where('status', 'paid')->get();

        return view('dashboard', compact('overdue', 'pending', 'paid'));
    }

}
