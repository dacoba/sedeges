<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateValoracionPsicologoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('valoracion_psicologos', function (Blueprint $table) {
            $table->increments('id');
            $table->date('fecha_valoracion');
            $table->boolean('evaluacion_psicologica')->nullable();
            $table->boolean('dinamica_familiar')->nullable();
            $table->boolean('motivacion_adopcion')->nullable();
            $table->text('observacion_psicologo')->nullable();
            $table->integer('estado');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('valoracion_psicologos');
    }
}
