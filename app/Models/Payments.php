<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payments extends Model
{
    protected $fillable = ['client_id', 'vehicle_id', 'amount', 'payment_date', 'billing_month', 'type'];

    public function client()
    {
        return $this->belongsTo(Clients::class, 'client_id');
    }

    // Relación con el vehículo
    public function vehicle()
    {
        return $this->belongsTo(Vehicles::class, 'vehicle_id');
    }
}
