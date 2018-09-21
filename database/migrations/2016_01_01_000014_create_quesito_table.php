<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuesitoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('quesito', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string("enunciado", 100);
			$table->integer("peso");
			$table->integer("evento_id")->unsigned();
			
			$table->foreign("evento_id")->references("id")->on("evento");
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('quesito');
	}

}
