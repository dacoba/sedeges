<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateValoracionTrabajoSocialTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('valoracion_trabajo_socials', function (Blueprint $table) {
            $table->increments('id');
            $table->date('fecha_valoracion');
            $table->boolean('condiciones_vivienda')->nullable();
            $table->boolean('estructura_familiar')->nullable();
            $table->boolean('situacion_actual')->nullable();
            $table->text('observacion_trabajador_social')->nullable();
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
        Schema::dropIfExists('valoracion_trabajo_socials');
    }
}
