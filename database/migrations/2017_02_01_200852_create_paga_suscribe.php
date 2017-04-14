<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagaSuscribe extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('paga_suscribe', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id_factura');
            $table->unsignedInteger('id_usuario');
            $table->timestamp('fecha');
            $table->unsignedInteger('monto');
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
        Schema::dropIfExists('paga_suscribe');
    }
}
