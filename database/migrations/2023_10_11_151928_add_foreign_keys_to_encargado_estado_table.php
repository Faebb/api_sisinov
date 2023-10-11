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
        Schema::table('encargado_estado', function (Blueprint $table) {
            $table->foreign(['ID_En'], 'encargado_estado_ibfk_1')->references(['ID_En'])->on('encargado');
            $table->foreign(['ID_S'], 'encargado_estado_ibfk_2')->references(['ID_S'])->on('sede');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('encargado_estado', function (Blueprint $table) {
            $table->dropForeign('encargado_estado_ibfk_1');
            $table->dropForeign('encargado_estado_ibfk_2');
        });
    }
};
