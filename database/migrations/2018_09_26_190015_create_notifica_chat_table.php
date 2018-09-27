<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificaChatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifica_chat', function (Blueprint $table) {
            $table->increments('id');
            //$table->integer('codigo_chat');
            $table->integer('id_chat')->unsigned();
            $table->integer('user_envia');
            $table->integer('user_recibe');
            $table->timestamps();

            $table->foreign('id_chat')->references('id')->on('chat');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notifica_chat');
    }
}
