<?php
namespace App\Http\Controllers;

use App\File;
use App\Interfaces\Crud;
use App\Models\Artista;
use App\Models\ImagenArtista;
use App\Models\Genero;
use App\ValidationsMusic;
use App\Sanitize;
use App\Procedures\ChangeRoutesProcedure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ArtistsController extends Controller implements Crud
{
    public function __construct()
	{
		$this->middleware(['admin', 'account_type']);
	}

	/**
	 * index
	 * @return Illuminate\Http\Response
	 */
	public function index()
	{
		$total_artists = count(Artista::all());

		$filter = $_GET['filter'] ?? '';
		$limit  = $_GET['limit'] ?? config('config_app.MAX_ARTISTS_PAGE');

		if (!in_array($limit, config('config_app.LIMITS'))) {
			abort(404);
		}

		if ($filter) {
			$filter = str_replace('%', '\\%', trim($filter));
			$filter = $filter."%";
		} else if(!$filter) {
			$filter = '%';
		}

		$artists = \DB::table('artista')
					->where('nombre_artista', 'LIKE', $filter)
					->join('genero', 'artista.id_genero', '=', 'genero.id_genero')
					->orderBy('genero.nombre_genero', 'asc')
					->orderBy('artista.nombre_artista', 'asc')
					->paginate($limit);

		$index = ($artists->currentPage() == 1) ? 1 : (($artists->currentPage() - 1) * $limit) + 1;

		if (count($artists) == 0 && $total_artists == 0) {
			return redirect('artists/add');
		} else if (count($artists) == 0 && $total_artists > 0) {
			abort(404);
		} else {
			return view('sections.artists.index', compact('artists', 'total_artists', 'index', 'limit'));
		}
	}

	/**
	 * search
	 * @param  Request $request
	 * @return JSON
	 */
	public function search(Request $request)
	{
		$total_data = count(Artista::all());

		$limit = ($request->limit && in_array($request->limit, config('config_app.LIMITS'))) ? $request->limit : config('config_app.MAX_ARTISTS_PAGE');

		$filter = str_replace('%', '\\%', trim($request->filter));
		$filter = $filter."%";

		$data = \DB::table('artista')
					->where('nombre_artista', 'LIKE', $filter)
					->join('genero', 'artista.id_genero', '=', 'genero.id_genero')
					->orderBy('genero.nombre_genero', 'asc')
					->orderBy('artista.nombre_artista', 'asc')
					->paginate($limit);

		$index = ($data->currentPage() == 1) ? 1 : (($data->currentPage() - 1) * $limit) + 1;

		return response()->json([
			'entitie'       => 'artist',
			'filter'        => $request->filter,
			'limit'			=> $limit,
			'data'          => $data,
			'total_data'    => $total_data,
			'pagination'    => (string) $data->links(),
			'message_panel' => 'Visualizando '.$data->currentPage().' de '.$data->lastPage().' paginas de '.$total_data.' artistas.'
		]);
	}

	/**
	 * showForm
	 * @return Illuminate\Http\Response
	 */
	public function showForm()
	{
		$genres = Genero::all();
		$panel_title = 'Agregar un Nuevo Artista';
		$label_select = 'Genero';

		return view('sections.artists.add', compact('genres', 'panel_title', 'label_select'));
	}

	/**
	 * add
	 * @param  Request $request
	 * @return Illuminate\Http\Response
	 */
	public function add(Request $request)
	{
		// validations fields
		if ($errors = ValidationsMusic::validateFields($request->only('nombre', 'file', 'select'))) {
			return response()->json([
				'success'  => false,
				'messages' => $errors,
				'message'  => 'Por favor, Comprueba los errores.'
		    ], 422);
		}

		// check exist genre
		$genre = Genero::where('id_genero', $request->select)->first();

		if (isset($genre)) {
			// check exist artist
			$exist_artist = Artista::where('nombre_artista', $request->nombre)->first();

			if ($exist_artist == null) {

				// save artist
				$artist = new Artista;
				$artist->nombre_artista = $request->nombre;
				$artist->id_genero = $request->select;
				$artist->save();

				// Created a directory for Artist
				$path = "uploads/music/".$genre->nombre_genero.'/'.ucfirst($request->nombre);
				Storage::makeDirectory($path);

				// extension file
				$file_extension = $request->file('file')->guessClientExtension();

				$filename = ucfirst($request->nombre).".".$file_extension;

				// Move Upload File
				$path_DB = $request->file('file')->storeAs(
				    $path, $filename, 'public'
				);

				// save img
				$img_artist = new ImagenArtista;
				$img_artist->id_artista = $artist->id_artista;
				$img_artist->src_img = $path.'/'.$filename;
				$img_artist->save();

				return response()->json([
					'success' => true,
					'message' => 'Artista agregado con éxito.'
				], 200);

			} else {
				return response()->json([
					'success'       => false,
					'message'       => 'Por favor, Comprueba los errores.',
					'message_exist' => 'El artista, ya existe.',
					'exist'         => true
				], 422);
			}

		} else {
			return response()->json([
				'success'       => false,
				'message'       => 'Por favor, Comprueba los errores.',
				'message_exist' => 'El genero seleccionado no existe.',
				'exist'         => false
			], 422);
		}
	}

	/**
	 * edit
	 * @param  Request  $request
	 * @param  integer  $id ID del artista.
	 * @return Illuminate\Http\Response
	 */
	public function edit(Request $request, $id)
	{
		if (isset($id) && preg_match('/^[0-9]{1,}$/', $id)) {
			$main_data = Artista::find($id);

			if (!empty($main_data)) {
				$name = $main_data->nombre_artista;

				// get image
				$img = ImagenArtista::find($id);

				// get genre
				$genre = Genero::find($main_data->id_genero);

				// get all genres
				$genres = Genero::all();

				$label_select = 'Genero';

				return view('sections.artists.edit', compact('main_data', 'name', 'genre', 'genres', 'img', 'label_select'));
			} else {
				abort(404);
			}
		} else {
			abort(404);
		}
	}

	/**
	 * update
	 * @param  Request $request
	 * @param  integer $id ID del artista.
	 * @return Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		if (isset($id)) {

			$artist = Artista::find($id);

			if (!empty($artist)) {

				// validations fields
				if ($errors = ValidationsMusic::validateFields($request->only('nombre', 'select'))) {
					return response()->json([
						'success'  => false,
						'messages' => $errors,
						'message'  => 'Por favor, Comprueba los errores.'
				    ], 422);
				}

				$new_name_artist = ucfirst($request->nombre); // new name
				$old_name_artist = ucfirst($artist->nombre_artista); // old name

				$exist_artist = Artista::where('nombre_artista', $new_name_artist)->where('nombre_artista', '!=', $old_name_artist)->first();

				// check exist artist
				if ($exist_artist == null) {

					// recupero la ruta de la imagen
					$img = ImagenArtista::find($artist->id_artista);
					$base_dir = '/app/public/'.dirname(dirname($img->src_img)); // /app/public/uploads/music/nombre_genero

					// nuevo genero
					$genre = Genero::find($request->select);

					// CASO 1
					// Cambia el nombre del artista por lo tanto cambia el nombre de la carpeta y de la imagen
					if ($old_name_artist != $new_name_artist) {
						// ruta nueva y vieja
						$new_directory = storage_path().$base_dir.'/'.$new_name_artist;
						$old_directory = storage_path().$base_dir.'/'.$old_name_artist;

						// nombre de la imagen
						$old_name_img = basename($img->src_img);
						$extension = explode('.', $old_name_img)[1];

						$new_img = $new_directory.'/'.$new_name_artist.".".$extension;
						$path_DB = explode('public/', $new_img)[1];

						$old_img = $new_directory.'/'.$old_name_img;

						// renombro el directorio y la imagen
						if (rename($old_directory, $new_directory)) {
							if (rename($old_img, $new_img)) {
								// actualizo los datos en la DB
								$artist->nombre_artista = $new_name_artist;
								$img->src_img = $path_DB;
								$artist->save();
								$img->save();

								// PROCEDURE CHANGE_ROUTES_1
								$old_route = 'uploads/music/'.basename($base_dir).'/'.$old_name_artist.'/';  // uploads/music/old_genre/old_artist
								$new_route = 'uploads/music/'.ucfirst($genre->nombre_genero).'/'.$new_name_artist.'/'; // uploads/music/new_genre/new_artist
								$procedure = ChangeRoutesProcedure::updateRouteArtist($old_route, $new_route);
							}
						}
					}

					// CASO 2 Cambia el genero
					if ($genre->id_genero != $artist->id_genero) {
						$old_src = 'uploads/music/'.basename($base_dir).'/'.$new_name_artist;
						$new_src = 'uploads/music/'.ucfirst($genre->nombre_genero).'/'.$new_name_artist;

						// copia a el nuevo directorio y elimina el viejo
						File::fullCopy(storage_path().'/app/public/'.$old_src, storage_path().'/app/public/'.$new_src);

						if (File::removeDir(storage_path().'/app/public/'.$old_src)) {
							$artist->id_genero = $genre->id_genero;
							$artist->save();

							// PROCEDURE CHANGE_ROUTES_1
							$procedure = ChangeRoutesProcedure::updateRouteArtist($old_src.'/', $new_src.'/');
						}
					}

					// CASO 3 Cambia la imagen
					if ($request->file('file')) {

						// Valido el archivo
						if ($errors = ValidationsMusic::validateFields($request->only('file'))) {
							return response()->json([
								'success'  => false,
								'messages' => $errors,
								'message'  => 'Por favor, Comprueba los errores.'
						    ], 422);
						}

						// recupero la ruta de la imagen
						$img_artist = ImagenArtista::find($artist->id_artista);

						// borro la imagen vieja
						if (NULL != ($error = File::removeFiles([storage_path().'/app/public/'.$img_artist->src_img])))	{
							return response()->json([
								'success' => false,
								'error'   => $error
							]);
						}

						// ruta nueva y nombre del archivo
						$path = dirname($img_artist->src_img);
						$filename = $new_name_artist.".".$request->file('file')->guessClientExtension();

						// subo la nueva imagen
						$path_DB = $request->file('file')->storeAs(
						    $path, $filename, 'public'
						);

						$img_artist->src_img = $path.'/'.$filename;
						$img_artist->save();
					}

					return response()->json([
						'success' => true,
						'message' => 'Actualizado con exito.',
						'src'     => ImagenArtista::find($artist->id_artista)->src_img,
						'name'    => $new_name_artist ?? '',
						'select'  => $request->select ?? ''
					]);
				}

			} else {
				abort(404);
			}
		} else {
			abor(404);
		}
	}

	/**
	 * delete
	 * @param  Request $request
	 * @return Illuminate\Http\Response
	 */
	public function delete(Request $request)
	{
		$artists = $request->input('items');

		$count_artists = count($artists);

		if ($count_artists > 0) {
			$exist = true;
			$i = 0;

			// compruebo si el/los artista/s existe/n
			while ($i < $count_artists && $exist) {
				if (empty(Artista::find($artists[$i]))) {
					$exist = false;
				}
				$i++;
			}

			if (!$exist) {
				return response()->json([
					"success" => false,
					"message" => "El artista seleccionado no existe."
				]);
			} else {
				$source_img = [];

				// recupero las rutas de la imagen
				for ($i=0; $i < $count_artists; $i++) {
					array_push($source_img, ImagenArtista::find($artists[$i])->src_img);
				}

				// elimino el directorio
				$count_src_img = count($source_img);
				for ($i=0; $i < $count_src_img; $i++) {
					File::removeDir(storage_path().'/app/public/'.dirname($source_img[$i]));
				}

				// elimino el/los artista/s de la DB
				for ($i=0; $i < $count_artists; $i++) {
					Artista::find($artists[$i])->delete();
				}

				return response()->json([
					"success" => true,
					"message" => (count($count_artists) > 1) ? 'Artistas eliminados con éxito.' : 'Artista eliminado con éxito.'
				]);
			}
		}
	}
}
