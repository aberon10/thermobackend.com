<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImgArtista extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('img_artista', function (Blueprint $table) {
        	$table->engine = 'InnoDB';

            $table->increments('id_img_artista');
            $table->unsignedInteger('id_artista');
            $table->string('src_img');
            $table->timestamps(); // created_at updated_at

            // foreign key
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
        Schema::dropIfExists('img_artista');
    }
}
