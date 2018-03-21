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
            $table->integer('infante_id')->nullable()->unsigned();
            $table->foreign('infante_id')->references('id')->on('infantes')->onDelete('restrict')->onUpdate('cascade');
            $table->integer('adoptante_id')->unsigned();
            $table->foreign('adoptante_id')->references('id')->on('adoptantes')->onDelete('restrict')->onUpdate('cascade');
            $table->integer('estado');
            $table->boolean('carta_solicitud');
            $table->boolean('certificado_antecedentes');
            $table->boolean('informe_antecedentes');
            $table->boolean('verificacion_domiciliaria');
            $table->boolean('certificado_estadocivil');
            $table->text('observacion_registro')->nullable();
            $table->boolean('verificacion_registro')->nullable();
            $table->text('observacion_requisitos')->nullable();
            $table->boolean('verificacion_requisitos')->nullable();
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
