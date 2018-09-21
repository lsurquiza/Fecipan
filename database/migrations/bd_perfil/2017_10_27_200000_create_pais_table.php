<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pais', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome');
            $table->string('gentilico', 80)->nullable();
            $table->string('sigla', 3);
            $table->string('sigla_web', 2);

            //$table->primary('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('permissao');
        Schema::dropIfExists('perfil_usuario');
        Schema::dropIfExists('conteudo');
        Schema::dropIfExists('usuario');
        Schema::dropIfExists('pais');
        Schema::dropIfExists('estado_civil');
        Schema::dropIfExists('perfil');
    }
}
