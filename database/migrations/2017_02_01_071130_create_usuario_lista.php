<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsuarioLista extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuario_lista', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->unsignedInteger('id_usuario');
            $table->unsignedInteger('id_lista');
            $table->timestamp('fecha');
            $table->timestamps(); // create_at, update_at

            // foreign key
            $table->foreign('id_usuario')
                    ->references('id_usuario')->on('usuario')
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
        Schema::dropIfExists('usuario_lista');
    }
}
