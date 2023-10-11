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
        Schema::table('novedad', function (Blueprint $table) {
            $table->foreign(['id_em'], 'novedad_ibfk_1')->references(['id_em'])->on('empleado');
            $table->foreign(['T_Nov'], 'novedad_ibfk_3')->references(['T_Nov'])->on('tp_novedad');
            $table->foreign(['ID_S'], 'novedad_ibfk_2')->references(['ID_S'])->on('sede');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('novedad', function (Blueprint $table) {
            $table->dropForeign('novedad_ibfk_1');
            $table->dropForeign('novedad_ibfk_3');
            $table->dropForeign('novedad_ibfk_2');
        });
    }
};
