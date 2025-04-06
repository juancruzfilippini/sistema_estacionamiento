<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateBrandsTable extends Migration
{
    public function up()
    {
        Schema::create('brands', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
        });

        // Insertar marcas populares en Argentina
        $brands = [
            'CHEVROLET',
            'FIAT',
            'FORD',
            'PEUGEOT',
            'RENAULT',
            'TOYOTA',
            'VOLKSWAGEN',
            'CITROËN',
            'NISSAN',
            'HONDA',
            'JEEP',
            'HYUNDAI',
            'KIA',
            'CHERY',
            'SUZUKI',
            'BMW',
            'MERCEDES-BENZ',
            'AUDI',
            'LEXUS',
            'VOLVO',
            'PORSCHE',
            'LAND ROVER'
        ];


        foreach ($brands as $brand) {
            DB::table('brands')->insert(['name' => $brand, 'created_at' => now(), 'updated_at' => now()]);
        }
    }

    public function down()
    {
        Schema::dropIfExists('brands');
    }
}
