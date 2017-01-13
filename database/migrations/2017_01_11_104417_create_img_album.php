<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImgAlbum extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('img_album', function (Blueprint $table) {
        	$table->engine = 'InnoDB';

            $table->increments('id_img_album');
            $table->unsignedInteger('id_album');
            $table->string('src_img');
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
        Schema::dropIfExists('img_album');
    }
}
