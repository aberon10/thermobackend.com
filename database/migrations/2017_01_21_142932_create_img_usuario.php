<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImgUsuario extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    	Schema::create('img_usuario', function (Blueprint $table) {
	        $table->engine = 'InnoDB';

	        $table->increments('id_img_usuario');
	        $table->unsignedInteger('id_usuario');
	        $table->string('src_img');
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
        Schema::dropIfExists('img_usuario	');
    }
}
