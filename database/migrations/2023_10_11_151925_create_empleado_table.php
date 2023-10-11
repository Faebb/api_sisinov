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
        Schema::create('empleado', function (Blueprint $table) {
            $table->integer('id_em', true);
            $table->tinyInteger('id_doc')->index('empresa_ibfk_1');
            $table->string('documento', 15);
            $table->string('n_em', 20);
            $table->string('a_em', 20);
            $table->string('eml_em', 64)->nullable();
            $table->string('f_em');
            $table->string('barloc_em', 100);
            $table->string('dir_em', 70)->nullable();
            $table->string('lic_emp', 8);
            $table->string('lib_em', 20);
            $table->string('tel_em', 15);
            $table->string('contrato');
            $table->tinyInteger('id_pens')->index('empresa_ibfk_7');
            $table->tinyInteger('id_eps')->index('empresa_ibfk_4');
            $table->tinyInteger('id_arl')->index('empresa_ibfk_5');
            $table->tinyInteger('id_ces')->index('empresa_ibfk_6');
            $table->tinyInteger('id_rh')->index('empresa_ibfk_2');
            $table->string('estado', 2);

            $table->unique(['id_doc', 'documento'], 'id_doc');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('empleado');
    }
};
