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
        Schema::table('asigna_vehiculo', function (Blueprint $table) {
            $table->foreign(['id_em'], 'asigna_vehiculo_ibfk_1')->references(['id_em'])->on('empleado');
            $table->foreign(['id_ve'], 'asigna_vehiculo_ibfk_2')->references(['id_ve'])->on('vehiculo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('asigna_vehiculo', function (Blueprint $table) {
            $table->dropForeign('asigna_vehiculo_ibfk_1');
            $table->dropForeign('asigna_vehiculo_ibfk_2');
        });
    }
};
