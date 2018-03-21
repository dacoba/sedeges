<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInfantesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('infantes', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('ci')->unique();
            $table->string('ci_extencion');
            $table->string('nombre');
            $table->string('genero');
            $table->date('fecha_nacimiento');
            $table->date('fecha_ingreso');
            $table->text('descripcion');
            $table->boolean('habilitado');
            $table->boolean('adoptado');
            $table->integer('centro_id')->unsigned();
            $table->foreign('centro_id')->references('id')->on('centros')->onDelete('restrict')->onUpdate('cascade');
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
        Schema::dropIfExists('infantes');
    }
}
