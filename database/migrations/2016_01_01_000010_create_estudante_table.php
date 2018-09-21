<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEstudanteTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('estudante', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string("ra", 10)->nullable();
			$table->integer('pessoa_id')->unsigned();
			$table->integer("categoria_id")->unsigned();
			$table->integer("instituicao_id")->unsigned();
			
			$table->foreign("pessoa_id")->references("id")->on("pessoa");
			$table->foreign("categoria_id")->references("id")->on("categoria");
			$table->foreign("instituicao_id")->references("id")->on("instituicao");
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('estudante');
	}

}
