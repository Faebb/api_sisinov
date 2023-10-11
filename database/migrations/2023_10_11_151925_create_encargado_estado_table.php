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
        Schema::create('encargado_estado', function (Blueprint $table) {
            $table->integer('idEncargadoEstado', true);
            $table->integer('ID_En')->index('encargado_estado_ibfk_1');
            $table->integer('ID_S')->index('encargado_estado_ibfk_2');
            $table->string('Est_en', 15);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('encargado_estado');
    }
};
