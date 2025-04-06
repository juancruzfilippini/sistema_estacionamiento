<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Clients extends Model
{
    protected $fillable = ['name', 'last_name', 'phone', 'address', 'email'];

    public function vehicles()
    {
        return $this->belongsToMany(Vehicles::class, 'client_vehicle');
    }
}
