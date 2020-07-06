<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre_nick');
            // $table->string('apellidos');
            // $table->string('nickname');
            // $table->date('nacimiento');
            $table->text('nombre_pyme');
            $table->integer('categoria_pyme_id');
            $table->string('address')->nullable();
            $table->text('avatar')->nullable();
            $table->text('avatarback')->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->integer('active')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
