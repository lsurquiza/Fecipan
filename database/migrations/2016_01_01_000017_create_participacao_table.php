<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParticipacaoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('participacao', function(Blueprint $table)
		{
			$table->integer("estudante_id")->unsigned();
			$table->integer("trabalho_id")->unsigned();
			
			$table->primary(["estudante_id", "trabalho_id"]);
			
			$table->foreign("estudante_id")->references("id")->on("estudante")->onDelete("cascade");
			$table->foreign("trabalho_id")->references("id")->on("trabalho")->onDelete("cascade");

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('participacao');
	}

}
