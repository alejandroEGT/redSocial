<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComentarioUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comentario-user', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_comentario')->nullable()->unsigned();
            $table->integer('id_user_recibe')->nullable()->unsigned();
            $table->timestamps();

            $table->foreign('id_comentario')->references('id')->on('comentario_multiple');
            $table->foreign('id_user_recibe')->references('id')->on('users');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comentario-user');
    }
}
