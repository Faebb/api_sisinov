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
        Schema::table('empleado', function (Blueprint $table) {
            $table->foreign(['id_doc'], 'empresa_ibfk_1')->references(['ID_Doc'])->on('tipo_doc');
            $table->foreign(['id_eps'], 'empresa_ibfk_3')->references(['ID_eps'])->on('eps');
            $table->foreign(['id_ces'], 'empresa_ibfk_5')->references(['ID_ces'])->on('cesantias');
            $table->foreign(['id_rh'], 'empresa_ibfk_2')->references(['ID_RH'])->on('rh');
            $table->foreign(['id_arl'], 'empresa_ibfk_4')->references(['ID_arl'])->on('arl');
            $table->foreign(['id_pens'], 'empresa_ibfk_6')->references(['ID_pens'])->on('pensiones');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('empleado', function (Blueprint $table) {
            $table->dropForeign('empresa_ibfk_1');
            $table->dropForeign('empresa_ibfk_3');
            $table->dropForeign('empresa_ibfk_5');
            $table->dropForeign('empresa_ibfk_2');
            $table->dropForeign('empresa_ibfk_4');
            $table->dropForeign('empresa_ibfk_6');
        });
    }
};
