<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('evento', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string("titulo", 100);
			$table->integer("ano");
			$table->integer("semestre");
			$table->string("tema")->nullable();
			$table->string("cidade")->nullable();
			$table->date("data_inicio")->nullable();
			$table->date("data_fim")->nullable();
			$table->boolean("ativo")->default(true);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('evento');
	}

}
