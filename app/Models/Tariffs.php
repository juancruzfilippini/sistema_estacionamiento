<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tariffs extends Model
{
    use HasFactory;
    protected $fillable = ['description', 'value', 'time_unit','time_quantity', 'type'];

}
