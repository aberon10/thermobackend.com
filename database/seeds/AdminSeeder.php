<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('usuario')->insert([
			'id_tipo_usuario' => 1,
			'usuario'         => 'admin',
			'nombre'		  => 'Juan',
			'apellido'        => 'Perez',
			'fecha_nac'       => '22-09-1985',
			'pass'            => bcrypt('admin'),
			'sexo'            => 'M',
			'correo'          => 'thermoteam2016@gmail.com'
        ]);
    }
}
