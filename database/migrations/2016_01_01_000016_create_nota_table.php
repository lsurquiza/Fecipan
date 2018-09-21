<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotaTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('nota', function(Blueprint $table)
		{
			$table->increments('id');
			$table->float("valor")->nullable();
			$table->integer("avaliacao_id")->unsigned();
			$table->integer("quesito_id")->unsigned();

			$table->foreign("avaliacao_id")->references("id")->on("avaliacao")->onDelete('cascade');
			$table->foreign("quesito_id")->references("id")->on("quesito");
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('nota');
	}

}
