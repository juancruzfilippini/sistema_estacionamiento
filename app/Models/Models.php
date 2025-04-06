<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Models extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'brand_id'];

    public function brand()
    {
        return $this->belongsTo(Brands::class);
    }
}