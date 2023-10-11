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
        Schema::create('vehiculo', function (Blueprint $table) {
            $table->integer('id_ve', true);
            $table->string('Matricula', 7)->unique('Matricula');
            $table->string('Cilindraje', 10);
            $table->year('Modelo')->nullable();
            $table->date('Fecha_Soat')->nullable();
            $table->date('Fecha_tecnicomecanica')->nullable();
            $table->string('estado', 11);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vehiculo');
    }
};
