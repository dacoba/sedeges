<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSolicitudAdopcionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('solicitud_adopcions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('infante_genero');
            $table->integer('infante_edad_desde');
            $table->integer('infante_edad_hasta');
            $table->integer('estado');
            $table->text('observacion_registro')->nullable();
            $table->text('observacion_requisitos')->nullable();
            $table->text('observacion_demanda')->nullable();
            $table->text('observacion_documentos')->nullable();
            $table->text('observacion_representacion')->nullable();

            $table->integer('adoptante_id')->unsigned();
            $table->integer('trabajador_social_id')->nullable()->unsigned();
            $table->integer('psicologo_id')->nullable()->unsigned();
            $table->integer('doctor_id')->nullable()->unsigned();
            $table->integer('valoracion_trabajador_social_id')->nullable()->unsigned();
            $table->integer('valoracion_psicologo_id')->nullable()->unsigned();
            $table->integer('valoracion_doctor_id')->nullable()->unsigned();

            $table->boolean('demanda_adopcion')->default(false);
            $table->integer('infante_id')->nullable()->unsigned();

            $table->foreign('adoptante_id')->references('id')->on('adoptantes')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('trabajador_social_id')->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('psicologo_id')->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('doctor_id')->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('valoracion_trabajador_social_id')->references('id')->on('valoracion_trabajo_socials')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('valoracion_psicologo_id')->references('id')->on('valoracion_psicologos')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('valoracion_doctor_id')->references('id')->on('valoracion_doctors')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('infante_id')->references('id')->on('infantes')->onDelete('restrict')->onUpdate('cascade');
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
        Schema::dropIfExists('solicitud_adopcions');
    }
}
