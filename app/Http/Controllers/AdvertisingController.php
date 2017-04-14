<?php

namespace App\Http\Controllers;

use App\File;
use App\ValidationsMusic;
use App\Models\Advertising;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AdvertisingController extends Controller
{
   	public function __construct() {
   		$this->middleware(['admin', 'advertising']);
   	}

   	/**
	 * index
	 * @return Illuminate\Http\Response
	 */
   	public function index()
   	{
   		$advertising_audio = Advertising::where('id_tipo_publicidad', '=', 1)->orderBy('nombre_publicidad')->get();
   		$advertising_image = Advertising::where('id_tipo_publicidad', '=', 2)->orderBy('nombre_publicidad')->get();

   		if (count($advertising_image) > 0 || count($advertising_audio) > 0) {
   			return view('sections.advertising.index', compact('advertising_audio', 'advertising_image'));
   		} else {
   			return redirect('/advertising/add');
   		}
   	}

   	/**
	 * showForm
	 * @return Illuminate\Http\Response
	 */
   	public function showForm()
   	{
   		return view('sections.advertising.add');
   	}

   	/**
	 * add
	 * @param  Request $request
	 * @return Illuminate\Http\Response
	 */
   	public function add(Request $request)
   	{
   		$errors = NULL;
		$extensions = array('jpeg', 'jpg', 'png', 'gif');

   		$validations = Validator::make($request->only('name', 'type', 'file'), [
   			'name' => 'required',
   			'type' => 'required',
   			'file' => 'required|max:20480',
   		], [
   			'name.required' => 'Campo requerido.',
   			'type.required' => 'Campo requerido.',
			'file.required' => 'El campo es requerido.',
			'file.max'      => 'El archivo no debe superar los 20MB.'
   		]);

   		if ($validations->fails()) {
   			return response()->json([
   				'success' => false,
   				'messages' => $validations->errors()
   			], 422);
   		}

   		// validate file
   		if ($request->file('file')) {
			$extension  = $request->file('file')->guessClientExtension();
   			if ($request->type == 'image' && !in_array($extension, $extensions)) {
   				return response()->json([
   					'success' => false,
   					'messages' => ['file' => ['Tipo de archivo no permitido']]
   				], 422);
   			} else if ($request->type == 'audio') {
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
				], 422);
			} else {
				$filename = trim($request->name).'.'.$request->file('file')->getClientOriginalExtension();

				// subo el archivo
				$path = $request->file('file')->storeAs(
				   'bi/', $filename, 'public'
				);

				// recupero los datos del archivo de audio
				$filedata = ($request->type == 'audio') ? File::analyzeFile(array(storage_path().'/app/public/'.$path)) : "";

				// Guardo la publicidad
				$advertising = new Advertising;
				$advertising->nombre_publicidad = trim($request->name);
				$advertising->id_tipo_publicidad = ($request->type == 'audio') ? 1 : 2;
				$advertising->src = 'bi/'.$filename;
				$advertising->duracion = ($filedata) ? $filedata[0]['duration'] : "";
				$advertising->save();

				return response()->json([
					'success' => true,
					'message' => 'Publicidad agregada con éxito.'
				], 200);
			}
   		}
   	}

   	/**
	 * edit
	 * @param  Request $request
	 * @param  string  $id Id de la publicidad
	 * @return Illuminate\Http\Response
	 */
   	public function edit(Request $request, $id)
   	{
   		$advertising = Advertising::find($id);
   		return view('sections.advertising.edit', compact('advertising'));
   	}

   	/**
	 * update
	 * @param  Request $request
	 * @param  string  $id Id de la publicidad
	 * @return Illuminate\Http\Response
	 */
   	public function update(Request $request, $id)
   	{
   		$errors = NULL;
		$extensions = array('jpeg', 'jpg', 'png', 'gif');

		// compruebo que la publicidad a editar exista
		$advertising = Advertising::find($request->_id);

		if (count($advertising) == 0) {
			return response()->json([
   				'success' => false,
   				'message' => 'La publicidad que desea editar, no existe.'
   			], 422);
		}

   		$validations = Validator::make($request->only('name'), [
   			'name' => 'required',
   		], [
   			'name.required' => 'Campo requerido.',
   		]);

   		if ($validations->fails()) {
   			return response()->json([
   				'success' => false,
   				'messages' => $validations->errors()
   			], 422);
   		}

   		// si se cambio el archivo, lo valido
   		if ($request->file('file')) {

			$extension  = $request->file('file')->guessClientExtension();

			if ($request->type == 'image' || $request->type == 'audio') {
	   			if ($request->type == 'image' && !in_array($extension, $extensions)) {
	   				return response()->json([
	   					'success' => false,
	   					'messages' => ['file' => ['Tipo de archivo no permitido']]
	   				], 422);
	   			} else if ($request->type == 'audio') {
	   				// valido el archivo
					if (NULL == ($errors = ValidationsMusic::validateFileAudio($request->only('file')))) {
						// valido la extension del archivo
						$errors = ValidationsMusic::checkExtensionAudio($request->file('file'));
					}
	   			}
			} else {
				return response()->json([
	   				'success' => false,
	   				'messages' => ['file' => ['Tipo de archivo no permitido']]
	   			], 422);
			}
   		}

   		// Actualizo los datos en la DB y subo el archivo si existe
   		if ($errors != NULL) {
			return response()->json([
				'success'  => false,
				'messages' => $errors,
			], 422);
		} else {

			if ($request->file('file')) {
				// elimino el archivo anterior
				if (NULL != ($error = File::removeFiles([storage_path().'/app/public/'.$advertising->src])))	{
					return response()->json([
						'success' => false,
						'message' => $error
					]);
				}

				$filename = trim($request->name).'.'.$request->file('file')->getClientOriginalExtension();

				// subo el archivo
				$path = $request->file('file')->storeAs(
				   'bi/', $filename, 'public'
				);

				// recupero los datos del archivo de audio
				$filedata = ($request->type == 'audio') ? File::analyzeFile(array(storage_path().'/app/public/'.$path)) : "";

				// Ruta del archivo y duracion
				$advertising->src = 'bi/'.$filename;
				$advertising->duracion = ($filedata) ? $filedata[0]['duration'] : "";
			} else {
				// Cambio el nombre del archivo en caso de que este no cambie
				$filename = explode('/', $advertising->src)[1];
				$filename = trim($request->name).'.'.explode('.', $filename)[1];

				if (rename(storage_path().'/app/public/'.$advertising->src, storage_path().'/app/public/bi/'.$filename)) {
					$advertising->src = 'bi/'.$filename;
				}
			}

			// Nombre y Tipo de Publicidad
			$advertising->nombre_publicidad = trim($request->name);

			if (!empty($request->type)) {
				$advertising->id_tipo_publicidad = ($request->type == 'audio') ? 1 : 2;
			}

			// Guardo la publicidad
			$advertising->save();

			return response()->json([
				'success' => true,
				'message' => 'Publicidad actualizada con éxito.'
			], 200);
		}
   	}

   	 /**
	 * delete
	 * @param  Request $request
	 * @return Illuminate\Http\Response
	 */
   	public function delete(Request $request)
   	{
   		$items = $request->input('items');

   		$count_items = count($items);

   		if ($count_items > 0) {
   			$exist = true;
			$i = 0;

			// compruebo si el/las publicidad/es existe/n
			while ($i < $count_items && $exist) {
				if (empty(Advertising::find($items[$i]))) {
					$exist = false;
				}
				$i++;
			}

			if (!$exist) {
				return response()->json([
					"success" => false,
					"message" => "La publicidad seleccionada no existe."
				]);
			} else {
				$source = [];

				// recupero las rutas del archivo
				for ($i=0; $i < $count_items; $i++) {
					array_push($source, Advertising::find($items[$i])->src);
				}

				// elimino el archivo
				$count_src = count($source);
				for ($i=0; $i < $count_src; $i++) {
					File::removeFiles([storage_path().'/app/public/'.$source[$i]]);
				}

				// elimino la/s publicidad/es de la DB
				for ($i=0; $i < $count_items; $i++) {
					Advertising::find($items[$i])->delete();
				}

				return response()->json([
					"success" => true,
					"message" => ($count_items > 1) ? 'Publicidades eliminadas con éxito.' : 'Publicidad eliminada con éxito.'
				]);
			}
   		}
   	}
}
