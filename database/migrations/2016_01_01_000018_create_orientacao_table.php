<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrientacaoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('orientacao', function(Blueprint $table)
		{
			$table->integer("orientador_id")->unsigned();
			$table->integer("trabalho_id")->unsigned();
			$table->string("tipo_orientacao", 100);

			$table->primary(["orientador_id", "trabalho_id"]);
			
			$table->foreign("trabalho_id")->references("id")->on("trabalho")->onDelete("cascade");
			$table->foreign("orientador_id")->references("id")->on("orientador")->onDelete("cascade");

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('orientacao');
	}

}
