<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class TipoDeUsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tipo_usuario')->insert(
        	['nombre_tipo' => 'Administrador']
        );

        DB::table('tipo_usuario')->insert(
        	['nombre_tipo' => 'Business Intelligence']
        );

        DB::table('tipo_usuario')->insert(
        	['nombre_tipo' => 'Premium']
        );

        DB::table('tipo_usuario')->insert(
        	['nombre_tipo' => 'Gratis']
        );

        DB::table('tipo_usuario')->insert(
        	['nombre_tipo' => 'No Registrado']
        );
    }
}




