<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePerfilTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('perfil', function (Blueprint $table) {
            $table->increments('id');
            $table->string('descricao')->unique();
            $table->boolean('administrador')->default(false);

            // Define o campo de chave estrangeira do auto relacionamento PERFIL-PERFIL PAI
            $table->integer('perfil_id')->unsigned()->nullable();

            // Amarração da chave estrangeira
            $table->foreign('perfil_id')->references('id')->on('perfil');
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
//        Schema::dropIfExists('permissao');
//        Schema::dropIfExists('perfil');
    }
}
