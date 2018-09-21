<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermissaoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permissao', function (Blueprint $table) {
            $table->integer('perfil_id')->unsigned();
            $table->integer('conteudo_id')->unsigned();
            $table->boolean('inserir')->default(false);
            $table->boolean('editar')->default(false);
            $table->boolean('excluir')->default(false);

            $table->primary(['perfil_id', 'conteudo_id']);
            $table->foreign('perfil_id')->references('id')->on('perfil')->onDelete('cascade');
            $table->foreign('conteudo_id')->references('id')->on('conteudo')->onDelete('cascade');
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
    }
}
