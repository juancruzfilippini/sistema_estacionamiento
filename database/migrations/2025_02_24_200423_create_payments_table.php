<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('clients')->onDelete('cascade');
            $table->foreignId('vehicle_id')->constrained('vehicles')->onDelete('cascade');
            $table->decimal('amount', 10, 2);
            $table->dateTime('payment_date')->nullable();
            $table->string('billing_month');
            $table->enum('status', ['pending', 'paid', 'overdue'])->default('pending');
            $table->enum('type', ['efectivo', 'qr', 'transferencia', 'mercadopago', 'tarjeta']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('payments');
    }
};
