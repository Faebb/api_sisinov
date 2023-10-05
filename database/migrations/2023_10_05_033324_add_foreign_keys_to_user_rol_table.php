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
        Schema::table('user_rol', function (Blueprint $table) {
            $table->foreign(['ID_rol'], 'user_rol_ibfk_2')->references(['ID_rol'])->on('rol');
            $table->foreign(['ID_log'], 'user_rol_ibfk_1')->references(['ID_log'])->on('login');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_rol', function (Blueprint $table) {
            $table->dropForeign('user_rol_ibfk_2');
            $table->dropForeign('user_rol_ibfk_1');
        });
    }
};
