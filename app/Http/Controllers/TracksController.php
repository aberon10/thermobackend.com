<?php
namespace App\Http\Controllers;

use App\File;
use App\Interfaces\Crud;
use App\Models\Album;
use App\Models\ImagenAlbum;
use App\Models\Cancion;
use App\ValidationsMusic;
use App\Procedures\ChangeRoutesProcedure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class TracksController extends Controller
{
    public function __construct() {
    	$this->middleware(['admin', 'account_type']);
    }

	/**
	 * index
	 * @param  $id Id del album.
	 * @return Illuminate\Http\Response
	 */
    public function index($id)
    {
    	// recupero todas las pistas que pertenezcan al album
    	if (isset($id)) {
    		$tracks = \DB::table('cancion')
    				->where('cancion.id_album', '=', $id)
    				->join('album', 'album.id_album', '=', 'cancion.id_album')
					->join('artista', 'album.id_artista', '=', 'artista.id_artista')
    				->join('img_album', 'album.id_album', '=', 'img_album.id_album')
    				->orderBy('cancion.nombre_cancion', 'asc')
    				->get();

    		if (count($tracks) == 0) {
    			return redirect()->action('TracksController@showForm');
    		} else {
    			return view('sections.tracks.index', compact('tracks'));
    		}

    	} else {
    		abort(404);
    	}
    }

	/**
	 * showForm
	 * @return Illuminate\Http\Response
	 */
	public function showForm()
	{
		$albums  = \DB::table('album')
						->join('artista', 'artista.id_artista', '=', 'album.id_artista')
						->orderBy('nombre_artista', 'asc')
						->orderBy('nombre', 'asc')
						->get();

		$panel_title  = 'Agregar una Nueva Pista';
		$label_select = 'Album';

		return view('sections.tracks.add', compact('albums', 'panel_title', 'label_select'));
	}

	/**
	 * add
	 * @param Request $request
	 * @return Illuminate\Http\Response
	 */
	public function add(Request $request)
	{	
		// valido los campos nombre y select
		if (NULL == ($errors = ValidationsMusic::validateFields($request->only('nombre', 'select')))) {
			// valido el archivo
			if (NULL == ($errors = ValidationsMusic::validateFileAudio($request->only('file')))) {
				// valido la extension del archivo
				$errors = ValidationsMusic::checkExtensionAudio($request->file('file'));
			}
		}

		if ($errors != NULL) {
			return response()->json([
				'success'  => false,
				'messages' => $errors,
				'message'  => 'Por favor, Comprueba los errores.'
			], 422);
		} else {
			// compruebo si existe el album
			$album = Album::find($request->select);

			if (isset($album)) {
				// compruebo que no exista la pista
				$exist_track = Cancion::where('nombre_cancion', '=', $request->nombre)->where('id_album', '=', $album->id_album)->first();

				if ($exist_track == NULL) {

					// Recupero la ruta del album
					$path_DB = dirname(ImagenAlbum::find($album->id_album)->src_img);

					// extension file
					$file_extension = $request->file('file')->getClientOriginalExtension();
					$filename = ucfirst($request->nombre).'.'.$file_extension;

					// subo el archivo
					$path = $request->file('file')->storeAs(
					   $path_DB, $filename, 'public'
					);

					// recupero los datos del archivo de audio
					$filedata = File::analyzeFile(array(storage_path().'/app/public/'.$path));

					// guardo los datos en la DB
					$track = new Cancion;
					$track->nombre_cancion = ucfirst($request->nombre);
					$track->id_album       = $album->id_album;
					$track->anio           = $album->anio;
					$track->formato        = $filedata[0]['fileformat'];
					$track->duracion       = $filedata[0]['duration'];
					$track->contador       = 0;
					$track->src_audio      = $path_DB.'/'.$filename; // RUTA DEL AUDIO
					$track->save();

					return response()->json([
						'success' => true,
						'message' => 'Pista agregada con éxito.'
					], 200);
				} else {
					// track exist
					return response()->json([
						'success'       => false,
						'message'       => 'Por favor, Comprueba los errores.',
						'message_exist' => 'La pista, ya existe.',
						'exist'         => true
					], 422);
				}
			} else {
				// album exist
				return response()->json([
					'success'       => false,
					'message'       => 'Por favor, Comprueba los errores.',
					'message_exist' => 'El album seleccionado no existe.',
					'exist'         => false
				], 422);
			}
		}
	}

	/**
	 * edit
	 * @param  Request $request
	 * @param  integer  $id
	 * @return Illuminate\Http\Response
	 */
	public function edit(Request $request, $id)
	{
		if (isset($id) && preg_match('/^[0-9]{1,}+$/', $id)) {
			$main_data = Cancion::find($id);
			if ($main_data != NULL) {
				$name = $main_data->nombre_cancion;
				$type = ($main_data->formato === 'mp3') ? 'audio/mpeg' : 'audio/ogg';

				// get all albums
				$albums = \DB::table('album')
						->join('artista', 'artista.id_artista', '=', 'album.id_artista')
						->orderBy('nombre_artista', 'asc')
						->orderBy('nombre', 'asc')
						->get();

				$label_select = 'Albums';

				return view('sections.tracks.edit', compact('main_data', 'name', 'type', 'albums', 'label_select'));
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
	 * @param  integer  $id
	 * @return Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		if (isset($id)) {
			$track = Cancion::find($id);

			if (isset($track)) {
				// validations fields
				if ($errors = ValidationsMusic::validateFields($request->only('nombre', 'select'))) {
					return response()->json([
						'success'  => false,
						'messages' => $errors,
						'message'  => 'Por favor, Comprueba los errores.'
				    ], 422);
				}

				$new_name_track = ucfirst($request->nombre);
				$old_name_track = $track->nombre_cancion;
				$base_dir       = dirname($track->src_audio);

				// nuevo album
				$album =  Album::find($request->select);

				// compruebo que no exista la pista
				$exist_track = Cancion::where('nombre_cancion', '=', $new_name_track)
								->where('nombre_cancion', '!=', $old_name_track)
								->where('id_album', '=', $album->id_album)
								->first();

				if ($exist_track == NULL) {
					if ($album->id_album != NULL) {

						// CASO 1 - Cambia el nombre de la pista
						if ($new_name_track != $old_name_track) {
							// ruta nueva y vieja
							$directory = storage_path('app/public/').$base_dir;

							// nombre de la pista
							$old_name_audio = basename($track->src_audio);
							$extension = explode('.', $old_name_audio)[1];

							$new_audio = $directory.'/'.$new_name_track.".".$extension;
							$old_audio = $directory.'/'.$old_name_audio;

							$path_DB = explode('public/', $new_audio)[1];

							// renombro el audio
							if (rename($old_audio, $new_audio)) {
								// actualizo los datos en la DB
								$track->nombre_cancion = $new_name_track;
								$track->src_audio = $path_DB;
								$track->save();
							}
						}

						// CASO 2 - Cambia el album
						if ($track->id_album != $album->id_album) {
							$target = dirname(ImagenAlbum::find($album->id_album)->src_img).'/'.basename($track->src_audio);
							$source = $track->src_audio;

							// muevo la pista a el nuevo album
							if (NULL != ($error = File::move(storage_path('app/public/').$source, storage_path('app/public/').$target))) {
								return response()->json([
									'success' => false,
									'error'   => $error
								]);
							}
							// actualizo los datos en la DB
							$track->id_album = $album->id_album;
							$track->src_audio = $target;
							$track->anio = $album->anio;
							$track->save();
						}

						// CASO 3 - Cambia el audio
						if ($request->file('file')) {
							// valido el archivo
							if (NULL == ($errors = ValidationsMusic::validateFileAudio($request->only('file')))) {
								// valido la extension del archivo
								$errors = ValidationsMusic::checkExtensionAudio($request->file('file'));
							}

							if ($errors != NULL) {
								return response()->json([
									'success'  => false,
									'messages' => $errors,
									'message'  => 'Por favor, Comprueba los errores.'
								], 422);
							} else {
								// borro el audio viejo
								if (NULL != ($error = File::removeFiles([storage_path().'/app/public/'.$track->src_audio])))	{
									return response()->json([
										'success' => false,
										'error'   => $error
									]);
								}

								$path = dirname($track->src_audio);
								$filename = $new_name_track.'.'.$request->file('file')->getClientOriginalExtension();

								// subo el nuevo audio
								$path_DB = $request->file('file')->storeAs(
								    $path, $filename, 'public'
								);

								$track->src_audio = $path.'/'.$filename;
								$track->save();
							}
						}

						return response()->json([
							'success' => true,
							'message' => 'Actualizado con exito.',
							'src'     => $track->src_audio,
							'name'    => $new_name_track ?? '',
							'select'  => $request->select ?? ''
						]);
					} else {
						// album not exist
						return response()->json([
							'success'       => false,
							'message'       => 'Por favor, Comprueba los errores.',
							'message_exist' => 'El album seleccionado no existe.',
							'exist'         => false
						], 422);
					}
				} else {
					// track exist
					return response()->json([
						'success'       => false,
						'message'       => 'Por favor, Comprueba los errores.',
						'message_exist' => 'La pista, ya existe.',
						'exist'         => true
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
		$tracks = $request->input('items');

		$count_tracks = count($tracks);

		if ($count_tracks > 0) {
			$exist = true;
			$i = 0;

			// compruebo si existe la pista seleccionada
			while ($i < $count_tracks && $exist) {
				if (Cancion::find($tracks[$i]) == NULL) {
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
				$source_audio = [];

				for ($i = 0; $i < $count_tracks; $i++) {
					array_push($source_audio, storage_path().'/app/public/'.Cancion::find($tracks[$i])->src_audio);
				}

				// elimino el audio
				File::removeFiles($source_audio);

				// elimino la pista de la DB
				for ($i=0; $i < $count_tracks; $i++) {
					Cancion::find($tracks[$i])->delete();
				}

				return response()->json([
					"success" => true,
					"message" => ($count_tracks > 1) ? 'Pistas eliminadas con éxito.' : 'Pista eliminada con éxito.'
				]);
			}
		}
	}
}
