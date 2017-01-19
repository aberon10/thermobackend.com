<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCancion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cancion', function (Blueprint $table) {
        	$table->engine = 'InnoDB';

            $table->increments('id_cancion');
            $table->unsignedInteger('id_album');
            $table->string('nombre_cancion');
            $table->string('formato', 5);
            $table->string('duracion', 11);
            $table->string('src_audio');
            $table->string('anio', 11)->nullable();
            $table->string('idioma')->default('Español');
            $table->integer('contador')->default(0);
            $table->timestamps(); // created_at updated_at

            $table->foreign('id_album')
           		->references('id_album')->on('album')
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
        Schema::dropIfExists('cancion');
    }
}
