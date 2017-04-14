<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTarea extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    	Schema::create('tarea', function (Blueprint $table) {
       	   	$table->engine = 'InnoDB';

	        $table->increments('id_tarea');
	        $table->unsignedInteger('id_usuario');
	        $table->string('titulo');
	        $table->string('estado', 10); // estado de la tarea PENDIENTE
	        $table->timestamps(); // create_at, update_at

	        // foreign key
	        $table->foreign('id_usuario')
	                ->references('id_usuario')->on('usuario')
	                ->onDelete('cascade')
	                ->onUpdate('cascade');
    	});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tarea');
    }
}
