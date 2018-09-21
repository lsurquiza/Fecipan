<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrabalhoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('trabalho', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string("titulo", 100);
			$table->string("cod", 100);
			$table->boolean("maquete")->default(false);
			$table->integer("area_id")->unsigned();
			$table->integer("tipo_trabalho_id")->unsigned();
			$table->integer("evento_id")->unsigned();
			$table->integer("categoria_id")->unsigned();
			
			$table->foreign("area_id")->references("id")->on("area");
			$table->foreign("tipo_trabalho_id")->references("id")->on("tipo_trabalho");
			$table->foreign("evento_id")->references("id")->on("evento");
			$table->foreign("categoria_id")->references("id")->on("categoria");

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('trabalho');
	}

}
