<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConteudoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conteudo', function (Blueprint $table) {
            $table->increments('id');
            $table->string('link')->unique();
            $table->string('rotulo');
            $table->boolean('publica')->default(false);
            $table->boolean('menu')->default(true);

            //$table->primary('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
//        Schema::dropIfExists('conteudo');
    }
}
