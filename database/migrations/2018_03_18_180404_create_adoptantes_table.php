<?php

use App\Adoptante;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdoptantesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adoptantes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('direccion');
            $table->string('ocupacion');
            $table->string('estado_civil');
            $table->string('habilitado')->default(Adoptante::ADOPTANTE_HABILITADO);
            $table->integer('user_id')->nullable()->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');
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
        Schema::dropIfExists('adoptantes');
    }
}
