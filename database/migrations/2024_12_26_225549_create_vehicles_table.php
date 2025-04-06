<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehiclesTable extends Migration
{
    public function up()
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();

            // 🔁 Convertimos brand y model en claves foráneas
            $table->unsignedBigInteger('brand_id');
            $table->unsignedBigInteger('model_id');

            $table->string('color');
            $table->string('type');
            $table->string('patent')->unique();
            $table->unsignedBigInteger('tariff_id');
            $table->enum('status', ['pending', 'paid', 'overdue'])->default('pending');
            $table->softDeletes();
            $table->timestamps();

            // 🔑 Claves foráneas
            $table->foreign('brand_id')->references('id')->on('brands')->onDelete('cascade');
            $table->foreign('model_id')->references('id')->on('models')->onDelete('cascade');
            $table->foreign('tariff_id')->references('id')->on('tariffs')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('vehicles');
    }
}
