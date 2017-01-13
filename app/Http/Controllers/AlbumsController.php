<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ValidationsMusic;

class AlbumsController extends Controller
{
    public function __construct()
	{
		$this->middleware('admin');
	}

	public function index()
	{

		$nombre = "Este es el nombre 100";

		$descripcion = "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Itaque tenetur mollitia deleniti libero quas. Id ipsa voluptas error voluptate, adipisci dolorum odio animi a, saepe delectus rerum neque alias libero!Lorem ipsum dolor sit amet, consectetur adipisicing elit. Itaque tenetur mollitia deleniti libero quas. Id ipsa voluptas error voluptate, adipisci dolorum odio animi a, saepe delectus rerum neque alias libero!Lorem ipsum dolor sit amet, consectetur adipisicing elit. Itaque tenetur mollitia deleniti libero quas. Id ipsa voluptas error voluptate, adipisci dolorum odio animi a, saepe delectus rerum neque alias libero!";

		if ($errors = ValidationsMusic::validateFields(['nombre' => $nombre,])) {
			var_dump($errors);
		} else {
			echo "Exito";
		}


	}
}
