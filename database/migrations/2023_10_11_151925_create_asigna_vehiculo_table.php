<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asigna_vehiculo', function (Blueprint $table) {
            $table->integer('ID_AV', true);
            $table->date('Fh_Asi');
            $table->integer('id_ve')->index('asigna_vehiculo_ibfk_2');
            $table->integer('id_em')->index('asigna_vehiculo_ibfk_1');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('asigna_vehiculo');
    }
};
