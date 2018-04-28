<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSolicitudTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('solicitud', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_solicita')->unsigned();
            $table->integer('user_acepta')->unsigned();
            $table->integer('id_estado')->unsigned();
            $table->timestamps();

            $table->foreign('user_solicita')->references('id')->on('users');
            $table->foreign('user_acepta')->references('id')->on('users');
            $table->foreign('id_estado')->references('id')->on('estado_solicitud');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('solicitud');
    }
}
