<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePerfilTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('perfil', function(Blueprint $table){
			$table->increments('id');
			$table->string('descricao', 100);
			$table->integer('perfil_id')->unsigned()->nullable();
			$table->boolean('administrador')->default(false);
			
			$table->foreign('perfil_id')->references('id')->on('perfil');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('perfil');
	}

}
