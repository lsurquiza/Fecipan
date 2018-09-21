<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConteudoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::create('conteudo', function(Blueprint $table){
			$table->increments('id');
			$table->string('rota', 32);
			$table->string('rotulo', 32);
			$table->boolean('publica')->default(false);
			$table->boolean('menu')->default(true);
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
		Schema::dropIfExists('conteudo');
    }
}
