<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmprendimientoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('emprendimiento', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('user_id');
            $table->integer('categoria_pymes_id')->nullable();
            $table->text('nombre');
            $table->text('descripcion');
            $table->text('direccion')->nullable();
            $table->string('contacto')->nullable();
            $table->text('url_facebook')->nullable();
            $table->text('url_instagram')->nullable();
            $table->text('url_web')->nullable();
            $table->char('activo',3);
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
        Schema::dropIfExists('emprendimiento');
    }
}
