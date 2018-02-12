<?php

use Illuminate\Database\Seeder;

class TipoPublicidadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tipo_publicidad')->insert(
        	['nombre_tipo_publicidad' => 'Audio']
        );

        DB::table('tipo_publicidad')->insert(
        	['nombre_tipo_publicidad' => 'Imagen']
        );
    }
}
