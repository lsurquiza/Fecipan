<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePessoaTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('pessoa', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string("nome");
			$table->string("sexo", 1)->nullable();
			$table->string("cpf", 20)->nullable();
			$table->date("data_nascimento")->nullable();
			$table->string("email")->nullable()->unique();
			$table->string("telefone_1", 15)->nullable();
			$table->string("telefone_2", 15)->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('pessoa');
	}

}
