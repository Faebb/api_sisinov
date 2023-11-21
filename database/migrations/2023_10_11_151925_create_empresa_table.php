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
        Schema::create('empresa', function (Blueprint $table) {
            $table->integer('id_e', true);
            $table->string('Nit_E', 15);
            $table->string('Nom_E', 70)->unique('Nom_E');
            $table->string('Eml_E', 50)->unique('Eml_E');
            $table->string('Nom_Rl', 40)->nullable();
            $table->tinyInteger('ID_Doc')->index('fk_ID_Doc')->nullable();
            $table->string('CC_Rl', 15);
            $table->string('telefonoGeneral', 15)->unique('telefonoGeneral')->nullable();
            $table->integer('Val_E')->nullable();
            $table->string('Est_E', 3);
            $table->date('Fh_Afi');
            $table->date('fechaFinalizacion');
            $table->string('COD_SE', 15);
            $table->string('COD_AE', 15);

            $table->unique(['ID_Doc', 'CC_Rl'], 'ID_Doc');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('empresa');
    }
};
