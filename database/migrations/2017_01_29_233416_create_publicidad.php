<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePublicidad extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('publicidad', function (Blueprint $table) {
	        $table->engine = 'InnoDB';

	        $table->increments('id_publicidad');
	        $table->unsignedInteger('id_tipo_publicidad');
	        $table->string('nombre_publicidad');
	        $table->string('src');
	        $table->string('duracion')->default('');
	        $table->timestamps(); // create_at, update_at

	        // foreign key
	        $table->foreign('id_tipo_publicidad')
	                ->references('id_tipo_publicidad')->on('tipo_publicidad')
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
    	Schema::dropIfExists('publicidad');
    }
}
