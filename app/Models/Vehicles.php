<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Vehicles extends Model
{
    use SoftDeletes;

    protected $fillable = ['brand_id', 'model_id', 'color', 'patent', 'type', 'tariff_id', 'status'];

    public function clients()
    {
        return $this->belongsToMany(Clients::class, 'client_vehicle');
    }

    public function tariff()
    {
        return $this->belongsTo(Tariffs::class);
    }
    public function payments()
    {
        return $this->hasMany(Payments::class, 'vehicle_id');
    }

    public function brand()
    {
        return $this->belongsTo(Brands::class);
    }

    public function model()
    {
        return $this->belongsTo(Models::class); // Evitamos conflicto con PHP 'Model'
    }

}
