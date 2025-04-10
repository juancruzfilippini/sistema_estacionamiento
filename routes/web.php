<?php

use App\Http\Controllers\ProfileController;
use Carbon\Carbon;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\TariffController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\ModelController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Models\Payments;
use App\Models\Models;
use App\Models\Brands;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [AuthenticatedSessionController::class, 'create'])
    ->name('login');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

Route::get('/clients', [ClientController::class, 'index'])->name('client.index');

Route::get('/payment/create', [PaymentController::class, 'create'])->name('payments.create');

Route::post('/payment/store', [PaymentController::class, 'store'])->name('payments.store');

Route::get('/client/create', [ClientController::class, 'create'])->name('client.create');

Route::post('/client/store', [ClientController::class, 'store'])->name('client.store');

Route::get('/tariffs/create', [TariffController::class, 'create'])->name('tariff.create');

Route::post('/tariffs', [TariffController::class, 'store'])->name('tariff.store');

Route::delete('/tariffs/{id}', [TariffController::class, 'destroy'])->name('tariff.destroy');

Route::get('/vehicles', [VehicleController::class, 'index'])->name('vehicle.index');

Route::get('/vehicles-by-client/{clientId}', [VehicleController::class, 'getVehiclesByClient']);

Route::get('/vehicle-tariff/{vehicleId}', [VehicleController::class, 'getVehicleTariff']);

Route::delete('/vehicles/{id}', [VehicleController::class, 'destroy'])->name('vehicle.destroy');

Route::put('/tariff/update/{id}', [TariffController::class, 'update']);

Route::get('/vehicle/{id}/edit', [VehicleController::class, 'edit'])->name('vehicle.edit');

Route::put('/vehicles/{id}', [VehicleController::class, 'update'])->name('vehicle.update');

Route::get('/payments/{vehicle}', [PaymentController::class, 'index'])->name('payments.index');

Route::get('/receipt/{id}', [PaymentController::class, 'generateReceipt'])->name('receipt.pdf');

Route::get('/vehicle-months/{vehicle_id}', function ($vehicle_id) {
    $paidMonths = Payments::where('vehicle_id', $vehicle_id)
        ->pluck('billing_month') // Obtiene solo los meses pagados
        ->toArray();

    $allMonths = [];
    for ($i = 1; $i <= 12; $i++) {
        $monthYear = Carbon::createFromDate(now()->year, $i, 1)->format('m-Y');
        $allMonths[] = [
            'month' => $monthYear,
            'paid' => in_array($monthYear, $paidMonths) // True si está pagado, false si no
        ];
    }

    return response()->json(['months' => $allMonths]);
});

Route::get('/get-models/{brand}', function ($brand) {
    return response()->json(Models::where('brand_id', $brand)->get());
})->name('get-models');

Route::get('/vehicle-paid-months/{vehicleId}', [PaymentController::class, 'getPaidMonths']);

Route::get('/vehicles/{id}/data', [VehicleController::class, 'getVehicleData']);

Route::get('/clients/{id}/data', [ClientController::class, 'getClientData']);

Route::put('/clients/{id}', [ClientController::class, 'update'])->name('client.update');

Route::get('/brands', [BrandController::class, 'index'])->name('brands.index');

Route::post('/brands', [BrandController::class, 'store'])->name('brands.store');

Route::post('/brands/{brand}/models', [ModelController::class, 'store'])->name('models.store');

Route::get('/brands/search', [BrandController::class, 'search'])->name('brands.search');


