<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAvaliadorAreaTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('avaliador_area', function(Blueprint $table)
		{
			$table->integer('area_id')->unsigned();
			$table->integer('avaliador_id')->unsigned();

			$table->primary(["area_id", "avaliador_id"]);
			$table->foreign("area_id")->references("id")->on("area");
			$table->foreign("avaliador_id")->references("id")->on("avaliador");
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('avaliador_area');
	}

}
