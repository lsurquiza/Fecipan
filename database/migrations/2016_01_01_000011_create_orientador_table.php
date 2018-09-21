<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrientadorTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('orientador', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer("pessoa_id")->unsigned();
			$table->integer("instituicao_id")->unsigned();
			
			$table->foreign("pessoa_id")->references("id")->on("pessoa");
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
		Schema::dropIfExists('orientador');
	}

}
