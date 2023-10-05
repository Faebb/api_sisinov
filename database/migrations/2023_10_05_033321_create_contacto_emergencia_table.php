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
        Schema::create('contacto_emergencia', function (Blueprint $table) {
            $table->integer('ID_CEm', true);
            $table->string('N_CoE', 40);
            $table->string('Csag', 40)->nullable();
            $table->integer('id_em')->index('fk_contacto_emergencia');
            $table->string('T_CEm', 20)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contacto_emergencia');
    }
};
