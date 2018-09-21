<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('login')->unique();
			$table->string('password', 60);
			$table->boolean('ativo')->default(true);
			$table->integer('pessoa_id')->unsigned();
			$table->integer('perfil_id')->unsigned();
			
			$table->rememberToken();
			$table->timestamps();
			
			$table->foreign('perfil_id')->references('id')->on('perfil');
			$table->foreign('pessoa_id')->references('id')->on('pessoa');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('users');
	}

}