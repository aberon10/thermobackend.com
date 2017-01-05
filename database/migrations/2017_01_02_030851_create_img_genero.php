<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImgGenero extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('img_genero', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id_img_genero');
            $table->unsignedInteger('id_genero');
            $table->string('src_img');
        	$table->timestamps(); // create_at update_at

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
        Schema::dropIfExists('img_genero');
    }
}
