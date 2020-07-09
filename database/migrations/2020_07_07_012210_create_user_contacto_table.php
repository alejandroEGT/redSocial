<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserContactoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_contacto', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('user_id');
            $table->string('contacto')->nullable();
            $table->text('url_web')->nullable();
            $table->text('url_facebook')->nullable();
            $table->text('url_instagram')->nullable();
            $table->text('direccion')->nullable();
            $table->text('descripcion_pyme')->nullable();
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
        Schema::dropIfExists('user_contacto');
    }
}
