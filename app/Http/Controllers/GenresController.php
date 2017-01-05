<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GenresController extends Controller
{
	public function __construct()
	{
		$this->middleware('admin');
	}

	/**
	 * index
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		return view('genres');
	}

	/**
	 * [showFormAddGenre description]
	 * @return \Illuminate\Http\Response
	 */
	public function showFormAddGenre()
	{
		return view('addgenre');
	}

	/**
	 * add Add new genre in Database
	 * @param Request $request
	 * @return
	 */
	public function add(Request $request)
	{
		/**********************************************************************************
		 * 							VALIDAR LOS DATOS ENVIADOS.
		*********************************************************************************/
		// regex:/^[A-Za-z-ÁÉÍÓÚÑáéíóúñ0-9\_\&\-\.\s]{2,60}$/
		// $this->validate($request, [
		// 	'nombre_genero' => "required",
		// 	'file'			=> 'required'
		// ], [
		// 	'nombre_genero.required' => 'El campo es requerido.',
		// 	'file.required'			 => 'El campo es requerido.'
		// ]);

		var_dump($request->all());

		// $name_genre = $request->nombre_genero;
		// $description = $request->descripcion;

		// $data_file =  $request->file('file');

		// $file_extension = $data_file->guessClientExtension();
		// $file_size = $data_file->getClientSize();
		// $file_mimetype = $data_file->getClientMimeType();
		// //$filename = $data_file->getClientOriginalName();
		// $max_filesize = $data_file->getMaxFilesize();

		// // Create a directory Genre
		// $path = "uploads/musica/".ucfirst($name_genre);
		// Storage::makeDirectory($path);

		// $filename = $name_genre.".".$file_extension;

		// // Move Upload File
		// $path_DB = $request->file('file')->storeAs(
		//     $path, $filename, 'public'
		// );

		// echo "PATH DB: " . $path_DB;
	}
}
