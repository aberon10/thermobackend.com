<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateListaCancion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lista_cancion', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->unsignedInteger('id_cancion');
            $table->unsignedInteger('id_lista');
            $table->timestamp('fecha');
            $table->timestamps(); // create_at, update_at

            // foreign key
            $table->foreign('id_cancion')
                    ->references('id_cancion')->on('cancion')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');

            $table->foreign('id_lista')
                    ->references('id_lista')->on('lista')
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
        Schema::dropIfExists('lista_cancion');
    }
}
