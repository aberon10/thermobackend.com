<?php
namespace App\Http\Controllers;

use App\File;
use App\Interfaces\Crud;
use App\Models\Album;
use App\Models\ImagenAlbum;
use App\Models\Artista;
use App\Models\ImagenArtista;
use App\ValidationsMusic;
use App\Procedures\ChangeRoutesProcedure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AlbumsController extends Controller implements Crud
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
		$albums = Album::orderBy('nombre')->get();

		if (count($albums) == 0) {
			return redirect()->action('AlbumsController@showForm');
		} else {
			$artists = [];

			// recupero los artistas
			foreach ($albums as $key => $album) {
				array_push($artists, Artista::find($album->id_artista));
			}

			return view('sections.albums.index', compact('albums', 'artists'));
		}
	}

	/**
	 * showForm
	 * @return Illuminate\Http\Response
	 */
	public function showForm()
	{
		$artists      = Artista::all();
		$panel_title  = 'Agregar un Nuevo Album';
		$label_select = 'Artista';

		return view('sections.albums.add', compact('artists', 'panel_title', 'label_select'));
	}

	/**
	 * add
	 * @param Request $request
	 * @return Illuminate\Http\Response
	 */
	public function add(Request $request)
	{
		// validations fields
		if ($errors = ValidationsMusic::validateFields($request->only('nombre', 'select', 'cant_pistas', 'anio', 'file'))) {
			return response()->json([
				'success'  => false,
				'messages' => $errors,
				'message'  => 'Por favor, Comprueba los errores.'
		    ], 422);
		}

		// check exist artist
		$artist = Artista::where('id_artista', $request->select)->first();

		if (isset($artist)) {

			// check exist album
			$exist_album = Album::where('nombre', $request->nombre)->first();

			if ($exist_album == null) {

				$album = new Album;
				$album->nombre      = ucfirst($request->nombre);
				$album->anio        = $request->anio;
				$album->cant_pistas = $request->cant_pistas;
				$album->id_artista  = $request->select;

				$album->save();

				// dirname uploads/music/Genero/Artista
				$dirname = dirname(ImagenArtista::find($request->select)->src_img);

				// Created a directory for Album
				$path = $dirname.'/'.ucfirst($request->nombre);
				Storage::makeDirectory($path);

				// extension file
				$file_extension = $request->file('file')->guessClientExtension();

				$filename = ucfirst($request->nombre).".".$file_extension;

				// Move Upload File
				$path_DB = $request->file('file')->storeAs(
				    $path, $filename, 'public'
				);

				// save img
				$img_album = new ImagenAlbum;
				$img_album->id_album = $album->id_album;
				$img_album->src_img = $path.'/'.$filename;
				$img_album->save();

				return response()->json([
					'success' => true,
					'message' => 'Album agregado con éxito.'
				], 200);

			} else {
				// album exist
				return response()->json([
					'success'       => false,
					'message'       => 'Por favor, Comprueba los errores.',
					'message_exist' => 'El album, ya existe.',
					'exist'         => true
				], 422);
			}
		} else {
			// genre exist
			return response()->json([
				'success'       => false,
				'message'       => 'Por favor, Comprueba los errores.',
				'message_exist' => 'El artista seleccionado no existe.',
				'exist'         => false
			], 422);
		}
	}

	/**
	 * edit
	 * @param  Request $request
	 * @param  integer  $id     ID del album
	 * @return Illuminate\Http\Response
	 */
	public function edit(Request $request, $id)
	{
		if (isset($id)) {
			$album = Album::find($id);

			if (!empty($album)) {
				// get image
				$img_album = ImagenAlbum::find($id);
				$panel_title = 'Actualizar Album';

				// get genre
				$artist = Artista::find($album->id_artista);

				// get all genres
				$artists = Artista::all();

				$label_select = 'Artista';

				return view('sections.albums.edit', compact('album', 'artist', 'artists', 'img_album', 'panel_title', 'label_select'));
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
	 * @param  integer  $id     ID del album
	 * @return Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		if (isset($id)) {

			$album = Album::find($id);

			if (!empty($album)) {
				// validations fields
				if ($errors = ValidationsMusic::validateFields($request->only('nombre', 'select', 'cant_pistas', 'anio'))) {
					return response()->json([
						'success'  => false,
						'messages' => $errors,
						'message'  => 'Por favor, Comprueba los errores.'
				    ], 422);
				}

				$new_name_album = ucfirst($request->nombre); // new name
				$old_name_album = $album->nombre; // old name

				$exist_album = Album::where('nombre', $new_name_album)->where('nombre', '!=', $old_name_album)->first();

				// recupero la ruta de la imagen
				$img = ImagenAlbum::find($album->id_album);
				$base_dir = dirname(dirname($img->src_img)); // uploads/music/Cumbia/Marama

				if ($exist_album == null) {

					// nuevo artista
					$artist = Artista::find($request->select);

					// CASO 1
					// Cambia el nombre del album por lo tanto cambia el nombre de la carpeta y de la imagen
					if ($old_name_album != $new_name_album) {
						// ruta nueva y vieja
						$new_directory = storage_path('app/public/').$base_dir.'/'.$new_name_album;
						$old_directory = storage_path('app/public/').$base_dir.'/'.$old_name_album;

						// nombre de la imagen
						$old_name_img = basename($img->src_img);
						$extension = explode('.', $old_name_img)[1];

						$new_img = $new_directory.'/'.$new_name_album.".".$extension;
						$path_DB = explode('public/', $new_img)[1];

						$old_img = $new_directory.'/'.$old_name_img;

						// renombro el directorio y la imagen
						if (rename($old_directory, $new_directory)) {
							if (rename($old_img, $new_img)) {
								// actualizo los datos en la DB
								$album->nombre = $new_name_album;
								$img->src_img = $path_DB;
								$album->save();
								$img->save();

								// PROCEDURE CHANGE_ROUTES_2
								$old_route = $base_dir.'/'.$old_name_album.'/';
								$new_route = $base_dir.'/'.$new_name_album.'/';
								$procedure = ChangeRoutesProcedure::updateRouteAlbum($old_route, $new_route);
							}
						}
					}

					// CASO 2 Cambia el artista
					if ($artist->id_artista != $album->id_artista) {
						// ruta base del artista uploads/music/Genero/Artista
						$base_dir_artist = dirname(ImagenArtista::find($artist->id_artista)->src_img);

						$old_src = dirname($base_dir).'/'.basename($base_dir).'/'.$album->nombre;
						$new_src = $base_dir_artist.'/'.$new_name_album;

						// copia a el nuevo directorio y elimina el viejo
						File::fullCopy(storage_path().'/app/public/'.$old_src, storage_path().'/app/public/'.$new_src);

						if (File::removeDir(storage_path().'/app/public/'.$old_src)) {
							$album->id_artista = $artist->id_artista;
							$album->save();

							// PROCEDURE CHANGE_ROUTES_1
							$procedure = ChangeRoutesProcedure::updateRouteAlbum($old_src.'/', $new_src.'/');
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
						$img_album = ImagenAlbum::find($album->id_album);

						// borro la imagen vieja
						if (NULL != ($error = File::removeFiles([storage_path().'/app/public/'.$img_album->src_img])))	{
							return response()->json([
								'success' => false,
								'error'   => $error
							]);
						}

						// ruta nueva y nombre del archivo
						$path = dirname($img_album->src_img);
						$filename = $new_name_album.".".$request->file('file')->guessClientExtension();

						// subo la nueva imagen
						$path_DB = $request->file('file')->storeAs(
						    $path, $filename, 'public'
						);

						$img_album->src_img = $path.'/'.$filename;
						$img_album->save();
					}

					// CASO 4 cambia el año
					if ($album->anio != $request->anio) {
						$album->anio = $request->anio;
						$album->save();
					}

					// CASO 5 cambia la cantidad de pistas
					if ($album->cant_pistas != $request->cant_pistas) {
						$album->cant_pistas = $request->cant_pistas;
						$album->save();
					}

					return response()->json([
						'success' => true,
						'message' => 'Actualizado con exito.',
						'src'     => ImagenAlbum::find($album->id_album)->src_img,
						'name'    => $new_name_album ?? '',
						'select'  => $request->select ?? ''
					]);
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
		$albums = $request->input('items');

		$count_albums = count($albums);

		if ($count_albums > 0) {
			$exist = true;
			$i = 0;

			// compruebo si el/los album/s existe/n
			while ($i < $count_albums && $exist) {
				if (empty(Album::find($albums[$i]))) {
					$exist = false;
				}
				$i++;
			}

			if (!$exist) {
				return response()->json([
					"success" => false,
					"message" => "El album seleccionado no existe."
				]);
			} else {
				$source_img = [];

				// recupero las rutas de la imagen
				for ($i=0; $i < $count_albums; $i++) {
					array_push($source_img, ImagenAlbum::find($albums[$i])->src_img);
				}

				// elimino el directorio
				$count_src_img = count($source_img);
				for ($i=0; $i < $count_src_img; $i++) {
					File::removeDir(storage_path().'/app/public/'.dirname($source_img[$i]));
				}

				// elimino el/los album/s de la DB
				for ($i=0; $i < $count_albums; $i++) {
					Album::find($albums[$i])->delete();
				}

				return response()->json([
					"success" => true,
					"message" => (count($count_albums) > 1) ? 'Albums eliminados con éxito.' : 'Album eliminado con éxito.'
				]);
			}
		}
	}

}
