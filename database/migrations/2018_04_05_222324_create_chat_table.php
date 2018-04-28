<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chat', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_user_envia')->unsigned();
            $table->integer('id_user_recibe')->unsigned();
            $table->text('mensaje')->nullable();
            $table->text('archivo')->nullable();
            $table->timestamps();

            $table->foreign('id_user_envia')->references('id')->on('users');
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
        Schema::dropIfExists('chat');
    }
}
