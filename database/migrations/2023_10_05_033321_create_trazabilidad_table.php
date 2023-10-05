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
        Schema::create('trazabilidad', function (Blueprint $table) {
            $table->integer('ID_Tra', true);
            $table->timestamp('Fh_Tra')->useCurrentOnUpdate()->useCurrent();
            $table->integer('id_em')->index('trasabilidad_ibfk_1');
            $table->string('descripcion')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trazabilidad');
    }
};
