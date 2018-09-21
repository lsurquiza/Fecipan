<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAvaliadorCategoriaTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('avaliador_categoria', function(Blueprint $table)
		{
			$table->integer("area_id")->unsigned();
			$table->integer("categoria_id")->unsigned();
			
			$table->primary(["area_id", "categoria_id"]);
			$table->foreign("area_id")->references("id")->on("area");
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
		Schema::dropIfExists('avaliador_categoria');
	}

}
