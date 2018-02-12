<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGenero extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('genero', function(Blueprint $table){
            $table->engine = 'InnoDB';

        	$table->increments('id_genero');
        	$table->string('nombre_genero', 40);
        	$table->string('descripcion', 250);
        	$table->timestamps(); // create_at update_at

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('genero');
    }
}
