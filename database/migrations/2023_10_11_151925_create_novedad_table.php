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
        Schema::create('novedad', function (Blueprint $table) {
            $table->integer('ID_Nov', true);
            $table->timestamp('Fe_Nov')->useCurrentOnUpdate()->useCurrent();
            $table->integer('T_Nov')->index('novedad_ibfk_3');
            $table->string('Dic_Nov', 70)->nullable();
            $table->string('Des_Nov');
            $table->integer('id_em')->index('novedad_ibfk_1');
            $table->integer('ID_S')->nullable()->index('novedad_ibfk_2');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('novedad');
    }
};
