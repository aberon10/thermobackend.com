<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlbum extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('album', function (Blueprint $table) {
        	$table->engine = 'InnoDB';

            $table->increments('id_album');
            $table->unsignedInteger('id_artista');
            $table->string('nombre');
            $table->integer('anio');
            $table->integer('cant_pistas');
            $table->timestamps(); // created_at updated_at

        	$table->foreign('id_artista')
        		->references('id_artista')->on('artista')
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
        Schema::dropIfExists('album');
    }
}
