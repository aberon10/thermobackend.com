<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLista extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('lista', function (Blueprint $table) {
			$table->engine = 'InnoDB';

			$table->increments('id_lista');
			$table->string('nombre_lista');
			$table->timestamps(); // create_at, update_at
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('lista');
	}
}
