<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class AvatarAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('img_usuario')->insert([
			'id_usuario' => 1,
			'src_img' => 'avatars/admin.jpg'
        ]);
    }
}
