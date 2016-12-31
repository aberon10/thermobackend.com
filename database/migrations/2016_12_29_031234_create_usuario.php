<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsuario extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuario', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            
            $table->increments('id_usuario');
            $table->unsignedInteger('id_tipo_usuario');
            $table->string('usuario', 30)->unique();
            $table->string('nombre', 60)->nullable();
            $table->string('apellido', 60)->nullable();
            $table->string('correo')->nullable();
            $table->string('pass', 300)->nullable();
            $table->date('fecha_nac')->nullable();
            $table->char('sexo', 1)->nullable();
            $table->string('cuenta_valida', 10)->nullable();
            $table->string('account_code', 10)->nullable();
            $table->integer('id_google')->nullable();
            $table->integer('id_facebook')->nullable();
            $table->rememberToken()->nullable();
            $table->timestamps(); // create_at, update_at

            // foreign key
            $table->foreign('id_tipo_usuario')
                ->references('id_tipo_usr')->on('tipo_usuario')
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
        Schema::dropIfExists('usuario');
    }
}
