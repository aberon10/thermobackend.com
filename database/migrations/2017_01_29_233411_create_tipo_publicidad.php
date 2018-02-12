<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTipoPublicidad extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    	Schema::create('tipo_publicidad', function (Blueprint $table) {
	        $table->engine = 'InnoDB';

	        $table->increments('id_tipo_publicidad');
	        $table->string('nombre_tipo_publicidad');
	        $table->timestamps(); // create_at, update_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    	Schema::dropIfExists('tipo_publicidad');
    }
}
