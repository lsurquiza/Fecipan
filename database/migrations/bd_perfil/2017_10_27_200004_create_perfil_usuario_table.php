<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePerfilUsuarioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /**
        Schema::create('perfil_usuario', function (Blueprint $table) {
            $table->integer('usuario_id')->unsigned();
            $table->integer('perfil_id')->unsigned();
            $table->boolean('usual')->default(false);
            $table->boolean('habilitado')->default(true);

            $table->primary(['usuario_id', 'perfil_id']);
            $table->foreign('usuario_id')->references('id')->on('usuario')->onDelete('cascade');
            $table->foreign('perfil_id')->references('id')->on('perfil')->onDelete('cascade');
        });
        */
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
//        Schema::dropIfExists('perfil_usuario');
    }
}
