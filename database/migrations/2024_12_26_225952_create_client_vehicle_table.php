<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientVehicleTable extends Migration
{
    public function up()
    {
        Schema::create('client_vehicle', function (Blueprint $table) {
            $table->id();
            $table->foreignId('clients_id')->constrained('clients')->onDelete('cascade');
            $table->foreignId('vehicles_id')->constrained('vehicles')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('client_vehicle');
    }
}

