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
        Schema::table('contacto_emergencia', function (Blueprint $table) {
            $table->foreign(['id_em'], 'contacto_emergencia')->references(['id_em'])->on('empleado');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contacto_emergencia', function (Blueprint $table) {
            $table->dropForeign('contacto_emergencia');
        });
    }
};
