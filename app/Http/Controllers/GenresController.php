<?php

namespace App\Http\Controllers;

use App\Models\Genero;
use App\Models\ImagenGenero;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Cache\Factory;

class GenresController extends Controller
{
	public function __construct()
	{
		$this->middleware('admin');
	}

	/**
	 * index
	 * @return Illuminate\Http\Response
	 */
	public function index()
	{
		$genres = Genero::orderBy('nombre_genero')->get();
		return view('genres', compact('genres'));
	}

	/**
	 * showFormAddGenre
	 * @return Illuminate\Http\Response
	 */
	public function showFormAddGenre()
	{
		return view('addgenre');
	}

	/**
	 * add Add new genre in Database
	 * @param Request $request
	 * @return JSON
	 */
	public function add(Request $request)
	{
		// Create a new Validator instance.
		$validation = Validator::make($request->only('nombre_genero', 'descripcion', 'file'),
		[
			'nombre_genero' => 'required',
			'descripcion'   => 'max:250',
			'file'          => 'required|mimes:jpg,jpeg,png,gif|max:5120'
		], [
			'nombre_genero.required' => 'El campo es requerido.',
			'descripcion.max'        => 'Utiliza como máximo 250 caracteres.',
			'file.required'          => 'El campo es requerido.',
			'file.mimes'             => 'Tipo de archivo no permitido.',
			'file.max'               => 'El archivo no debe superar los 5120kb.'
		]);

		// Determine if the data fails the validation rules.
		if ($validation->fails()) {
			$errors = json_decode($validation->errors());

		    return response()->json([
				'success'  => false,
				'messages' => $errors,
				'message'  => 'Por favor, Comprueba los errores.'
		    ], 422);
		}

		// check si exist genre
		$exist = Genero::where('nombre_genero', $request->nombre_genero)->first();

		if ($exist == null) {

			// save genero
			$genero = new Genero;
			$genero->nombre_genero = ($request->nombre_genero);
			$genero->descripcion   = $request->descripcion;
			$genero->save();

			// last id genre
			$last_insert_id = $genero->id_genero;

			// Create a directory Genre
			$path = "uploads/music/".ucfirst($request->nombre_genero);
			Storage::makeDirectory($path);

			// extension file
			$file_extension = $request->file('file')->guessClientExtension();

			$filename = $request->nombre_genero.".".$file_extension;

			// Move Upload File
			$path_DB = $request->file('file')->storeAs(
			    $path, $filename, 'public'
			);

			// save img
			$img_genero = new ImagenGenero;
			$img_genero->id_genero = $last_insert_id;
			$img_genero->src_img = $path_DB;
			$img_genero->save();

			return response()->json([
				'success'  => true,
				'message'  => 'Género agregado con éxito.',
				'exist'    => false
			], 200);
		}

		return response()->json([
			'success'  => false,
			'message'  => 'Por favor, Comprueba los errores.',
			'exist'    => true
		], 422);
	}

	 /**
     * edit the specified genre.
     *
     * @param  Request  $request
     * @param  string   $id
     * @return Illuminate\Http\Response
     */
	public function edit(Request $request, $id)
	{
		if (isset($id)) {
			// get data genre
			$data_genre = Genero::where('id_genero', $id)->get();

			if (!empty($data_genre[0])) {

				// get image genre
				$img_genre = ImagenGenero::where('id_genero', $id)->get();

				return view('genreedit', compact('data_genre', 'img_genre'));

			} else {
				abort(404);
			}

		} else {
			abort(404);
		}
	}

	 /**
     * update the specified genre.
     *
     * @param  Request  $request
     * @param  string   $id
     * @return Illuminate\Http\Response
     */
	public function update(Request $request, $id)
	{
		if (isset($id)) {

			// get data genre
			$genre = Genero::find($id);

			if (!empty($genre)) {

				$validation = Validator::make($request->only('descripcion', 'nombre_genero'),
					['nombre_genero' => 'required',
					'descripcion'    => 'max:250'],
					['nombre_genero.required' => 'El campo es requerido.',
					'descripcion.max'         => 'Utiliza como máximo 250 caracteres.']
				);

				if ($validation->fails()) {
					$errors = json_decode($validation->errors());

				    return response()->json([
						'success'  => false,
						'messages' => $errors,
						'message'  => 'Por favor, Comprueba los errores.'
				    ], 422);
				}

				$new_name_genre = ucfirst($request->nombre_genero); // nombre nuevo
				$old_name_genre = ucfirst($genre->nombre_genero); // nombre viejo

				// CASO 1
				// Cambia el nombre del genero por lo tanto cambia el nombre de la carpeta y de la imagen
				if ($old_name_genre != $new_name_genre) {
					$new_directory = storage_path().'/app/public/uploads/music/'.$new_name_genre;
					$old_directory = storage_path().'/app/public/uploads/music/'.$old_name_genre;

					// recupero el la ruta de la imagen
					$img_genre = ImagenGenero::find($genre->id_genero);

					$old_img   = explode('/', $img_genre->src_img)[3]; // name image
					$extension = explode('.', $old_img)[1]; // extension

					$new_img = $new_directory.'/'.$new_name_genre.'.'.$extension; // nueva imagen
					$path_DB = explode('public/', $new_img)[1];

					$old_img = $new_directory.'/'.$old_img; // imagen vieja

					// renombro el directorio y la imagen
					if (rename($old_directory, $new_directory)) {
						if (rename($old_img, $new_img)) {
							// actualizo el nombre y la ruta
							$genre->nombre_genero = $new_name_genre;
							$img_genre->src_img = $path_DB;
							$genre->save();
							$img_genre->save();
						}
					}
				}

				// CASO 2 - Se Sube imagen
				if ($request->file('file')) {

					// Valido el archivo
					$validation = Validator::make($request->only('file'),
						['file' => 'mimes:jpg,jpeg,png,gif|max:5120'],
						[
							'file.mimes' => 'Tipo de archivo no permitido.',
							'file.max'   => 'El archivo no debe superar los 5120kb.'
						]
					);

					if ($validation->fails()) {
						$errors = json_decode($validation->errors());

					    return response()->json([
							'success'  => false,
							'messages' => $errors,
							'message'  => 'Por favor, Comprueba los errores.'
						], 422);
					}

					// recupero el la ruta de la imagen
					$img_genre = ImagenGenero::find($genre->id_genero);

					// borro la imagen vieja
					Storage::delete(storage_path().'/app/public/'.$img_genre->src_img);

					// ruta nueva
					$path = "uploads/music/".ucfirst($request->nombre_genero);

					// nombre archivo
					$filename = ucfirst($request->nombre_genero).".".$request->file('file')->guessClientExtension();

					// subo la nueva imagen
					$path_DB = $request->file('file')->storeAs(
					    $path, $filename, 'public'
					);

					$img_genre->src_img = $path_DB;
				}

				return response()->json([
					'success'       => true,
					'message'       => 'Actualizado con exito.',
					'src_img'       => $path_DB ?? '',
					'nombre_genero' => $new_name_genre ?? '',
					'descripcion'   => $request->descripcion ?? ''
				]);

			} else {
				abort(404);
			}

		} else {
			abort(404);
		}
	}

	public function delete(Request $request)
	{
		// recupero los datos del JSON
		$genres = $request->input('genres');

		$count_genres = count($genres);

		if ($count_genres > 0) {
			$exist = true;
			$i = 0;

			// compruebo si el/los genero/s existe/n
			while ($i < $count_genres && $exist) {
				if (empty(Genero::find($genres[$i]))) {
					$exist = false;
				}
				$i++;
			}

			if (!$exist) {
				return response()->json([
					"success" => false,
					"message" => "El género seleccionado no existe."
				]);
			} else {
				$source_img = [];

				// recupero las rutas de la imagen
				for ($i=0; $i < $count_genres; $i++) {
					array_push($source_img, ImagenGenero::find($genres[$i])->src_img);
				}

				// elimino el directorio
				$count_src_img = count($source_img);
				for ($i=0; $i < $count_src_img; $i++) {
					Storage::deleteDirectory(dirname($source_img[$i]));
				}

				// elimino el/los genero/s de la DB
				for ($i=0; $i < $count_genres; $i++) {
					Genero::find($genres[$i])->delete();
				}

				return response()->json([
					"success" => true,
					"message" => "Género eliminado con éxito."
				]);
			}
		}
	}
}
