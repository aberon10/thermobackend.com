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
        	['nombre_tipo' => 'Administrador'],
        	['nombre_tipo' => 'Business Intelligence'],
        	['nombre_tipo' => 'Premium'],
        	['nombre_tipo' => 'Gratis'],
        	['nombre_tipo' => 'No Registrado']
        );
    }
}
