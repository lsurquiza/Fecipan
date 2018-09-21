<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsuarioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuario', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('estado_civil_id')->unsigned()->nullable();
            $table->integer('pais_id')->unsigned()->nullable();
            $table->integer('perfil_id')->unsigned();
            $table->string('nome');
            $table->string('sexo', 1)->nullable();
            $table->date('data_de_nascimento')->nullable();
            $table->string('cpf', 11)->unique();
            $table->string('email', 80)->unique();
            $table->string('telefone_fixo', 40)->nullable();
            $table->string('telefone_celular', 40)->nullable();
            $table->string('login')->unique();
            $table->string('password')->unique();
            $table->boolean('habilitado')->default(true);
            $table->rememberToken();
            $table->timestamps();
            
            $table->foreign('estado_civil_id')->references('id')->on('estado_civil');
            $table->foreign('pais_id')->references('id')->on('pais');
            $table->foreign('perfil_id')->references('id')->on('perfil');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
//        Schema::dropIfExists('perfil_usuario');
//        Schema::dropIfExists('usuario');
    }
}
