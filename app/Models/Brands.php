<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brands extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function models()
    {
        return $this->hasMany(Models::class, 'brand_id');
    }

}