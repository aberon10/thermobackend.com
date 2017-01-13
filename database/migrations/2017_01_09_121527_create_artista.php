<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArtista extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('artista', function (Blueprint $table) {
        	$table->engine = 'InnoDB';

            $table->increments('id_artista');
            $table->unsignedInteger('id_genero');
            $table->string('nombre_artista', 60);
            $table->timestamps(); // created_at updated_at

            // foreign key
            $table->foreign('id_genero')
            	->references('id_genero')->on('genero')
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
        Schema::dropIfExists('artista');
    }
}
