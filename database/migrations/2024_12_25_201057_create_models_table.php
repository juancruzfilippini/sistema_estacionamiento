<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateModelsTable extends Migration
{
    public function up()
    {
        Schema::create('models', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('brand_id');
            $table->foreign('brand_id')->references('id')->on('brands')->onDelete('cascade');
            $table->timestamps();
        });

        // Insertar modelos por marca
        $modelsByBrand = [
            'TOYOTA' => ['COROLLA', 'HILUX', 'YARIS', 'ETIOS', 'SW4'],
            'VOLKSWAGEN' => ['GOL', 'POLO', 'VENTO', 'AMAROK', 'T-CROSS'],
            'FORD' => ['FIESTA', 'FOCUS', 'RANGER', 'ECOSPORT', 'KUGA'],
            'CHEVROLET' => ['ONIX', 'S10', 'TRACKER', 'CRUZE', 'SPIN'],
            'RENAULT' => ['KANGOO', 'SANDERO', 'DUSTER', 'LOGAN', 'STEPWAY'],
            'PEUGEOT' => ['208', '308', '2008', 'PARTNER', '3008'],
            'FIAT' => ['CRONOS', 'PALIO', 'TORO', 'ARGO', 'MOBI'],
            'NISSAN' => ['VERSA', 'KICKS', 'FRONTIER', 'SENTRA', 'MARCH'],
            'HONDA' => ['CIVIC', 'HR-V', 'CR-V', 'FIT', 'CITY'],
            'MERCEDES-BENZ' => ['CLASE A', 'CLASE C', 'CLASE E', 'GLA', 'GLC'],
            'BMW' => ['SERIE 1', 'SERIE 3', 'SERIE 5', 'X1', 'X3'],
            'AUDI' => ['A3', 'A4', 'Q2', 'Q3', 'Q5'],
            'HYUNDAI' => ['I10', 'I20', 'TUCSON', 'SANTA FE', 'KONA'],
            'KIA' => ['PICANTO', 'RIO', 'SPORTAGE', 'SELTOS', 'SORENTO'],
            'CITROËN' => ['C3', 'C4 LOUNGE', 'C5 AIRCROSS', 'BERLINGO', 'JUMPY']
        ];


        foreach ($modelsByBrand as $brand => $models) {
            $brandId = DB::table('brands')->where('name', $brand)->value('id');
            if ($brandId) {
                foreach ($models as $model) {
                    DB::table('models')->insert([
                        'name' => $model,
                        'brand_id' => $brandId,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                }
            }
        }
    }

    public function down()
    {
        Schema::dropIfExists('models');
    }
}
