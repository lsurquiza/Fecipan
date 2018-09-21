<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAvaliacaoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('avaliacao', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer("trabalho_id")->unsigned();
			$table->integer("avaliador_id")->unsigned();
			$table->boolean("notas_lancadas")->default(false);
			
			$table->foreign("trabalho_id")->references("id")->on("trabalho")->onDelete("cascade");
			$table->foreign("avaliador_id")->references("id")->on("avaliador")->onDelete("cascade");

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('avaliacao');
	}

}
