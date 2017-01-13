<?php
namespace App\Http\Controllers;

use App\File;
use App\Models\Genero;
use App\Models\ImagenGenero;
use App\Interfaces\Crud;
use App\Procedures\ChangeRoutesProcedure;
use App\ValidationsMusic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class GenresController extends Controller implements Crud
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

		if (count($genres) === 0) {
			return redirect()->action('GenresController@showFormAddGenre');
		}

		return view('sections.genres.index', compact('genres'));
	}

	/**
	 * showFormAddGenre
	 * @return Illuminate\Http\Response
	 */
	public function showFormAddGenre()
	{
		$panel_title = 'Agregar Nuevo Genero';
		return view('sections.genres.add', compact('panel_title'));
	}

	/**
	 * add
	 * @param Request $request
	 * @return Illuminate\Http\Response
	 */
	public function add(Request $request)
	{
		// check exist genre
		$exist = Genero::where('nombre_genero', $request->nombre)->first();

		if ($exist == null) {

			// validations fields
			if ($errors = ValidationsMusic::validateFields($request->only('nombre', 'descripcion', 'file'))) {
				return response()->json([
					'success'  => false,
					'messages' => $errors,
					'message'  => 'Por favor, Comprueba los errores.'
			    ], 422);
			}

			// save genre
			$genero = new Genero;
			$genero->nombre_genero = ($request->nombre);
			$genero->descripcion   = $request->descripcion;
			$genero->save();

			// last id genre
			$last_insert_id = $genero->id_genero;

			// Created a directory for Genre
			$path = "uploads/music/".ucfirst($request->nombre);
			Storage::makeDirectory($path);

			// extension file
			$file_extension = $request->file('file')->guessClientExtension();

			$filename = $request->nombre.".".$file_extension;

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
			'exist'    => true,
			'message_exist' => 'El genero, ya existe.'
		], 422);
	}

	 /**
     * edit
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
				$panel_title = 'Actualizar Genero';

				return view('sections.genres.edit', compact('data_genre', 'img_genre', 'panel_title'));
			} else {
				abort(404);
			}

		} else {
			abort(404);
		}
	}

	 /**
     * update
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

				// validations fields
				if ($errors = ValidationsMusic::validateFields($request->only('nombre', 'descripcion'))) {
					return response()->json([
						'success'  => false,
						'messages' => $errors,
						'message'  => 'Por favor, Comprueba los errores.'
				    ], 422);
				}

				$new_name_genre = ucfirst($request->nombre); // new name
				$old_name_genre = ucfirst($genre->nombre_genero); // old name

				// check exist genre
				$exist_genre = Genero::where('nombre_genero', $new_name_genre)->where('nombre_genero', '!=', $old_name_genre)->first();

				if ($exist_genre == null) {
					// CASO 1
					// Cambia el nombre del genero por lo tanto cambia el nombre de la carpeta y de la imagen
					if ($old_name_genre != $new_name_genre) {
						$new_directory = storage_path().'/app/public/uploads/music/'.$new_name_genre;
						$old_directory = storage_path().'/app/public/uploads/music/'.$old_name_genre;

						// recupero la ruta de la imagen
						$img_genre = ImagenGenero::find($genre->id_genero);

						$old_img   = basename($img_genre->src_img); // name image
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

						// validations file
						if ($errors = ValidationsMusic::validateFields($request->only('file'))) {
							return response()->json([
								'success'  => false,
								'messages' => $errors,
								'message'  => 'Por favor, Comprueba los errores.'
						    ], 422);
						}

						// recupero la ruta de la imagen
						$img_genre = ImagenGenero::find($genre->id_genero);

						// borro la imagen vieja
						Storage::delete(storage_path('app/public/').$img_genre->src_img);

						// ruta nueva y nombre del archivo
						$path = "uploads/music/".$new_name_genre;
						$filename = $new_name_genre.".".$request->file('file')->guessClientExtension();

						// subo la nueva imagen
						$path_DB = $request->file('file')->storeAs(
						    $path, $filename, 'public'
						);

						// actualizo la ruta en la DB
						$img_genre->src_img = $path.'/'.$filename;
						$img_genre->save();
					}

					// PROCEDURE CHANGE_ROUTES_1
					$procedure = ChangeRoutesProcedure::updateRouteArtist('uploads/music/'.$old_name_genre, 'uploads/music/'.$new_name_genre);

					return response()->json([
						'success'     => true,
						'message'     => 'Actualizado con exito.',
						'src'     	  => $path_DB ?? '',
						'name'        => $new_name_genre ?? '',
						'description' => $request->descripcion ?? ''
 					]);

				} else {
					return response()->json([
						'success'  => false,
						'message'  => 'Por favor, Comprueba los errores.',
						'exist'    => true,
						'message_exist' => 'El genero, ya existe.'
					], 422);
				}

			} else {
				abort(404);
			}

		} else {
			abort(404);
		}
	}

	/**
	 * delete
	 * @param  Request $request
	 * @return Illuminate\Http\Response
	 */
	public function delete(Request $request)
	{
		// recupero los datos del JSON
		$genres = $request->input('items');

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
					File::removeDir(storage_path('app/public/').dirname($source_img[$i]));
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
