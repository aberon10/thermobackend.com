<?php
declare(strict_types=1);
namespace App;

use Illuminate\Support\Facades\Validator;

class ValidationsMusic
{
	/**
	 * $validation_name
	 * Reglas de validación para el nombre de la entidad: Género, Artista, Album y Pista.
	 * @var array
	 */
	private static $validation_name =  array('required', 'min:2', 'max:60', 'regex:/^[A-Za-z-ÁÉÍÓÚÑáéíóúñ0-9\_\&\-\.\'\"\s]+$/');

	/**
	 * validateFields
	 * @param  array  $fields campos a validar.
	 * @return array  $main_errors mensajes de error.
	 */
    public static function validateFields(array $fields) :array
    {
    	$main_errors = []; // guarda los mensajes de error

		// Valido el nombre
		if (array_key_exists('nombre', $fields)) {
			$validation = Validator::make($fields,
				['nombre' => self::$validation_name],
				[
					'nombre.required' => 'El campo es requerido.',
					'nombre.min'      => 'Utiliza como minimo 2 caracteres.',
					'nombre.max'      => 'Utiliza como maximo 60 caracteres.',
					'nombre.regex'    => 'El nombre ingresado no es valido.',
				]
			);

			if ($validation->fails()) {
				$main_errors['nombre'] = $validation->errors()->first('nombre');
			}
		}

		// Valido el archivo
		if (array_key_exists('file', $fields)) {
			$validation = Validator::make($fields,
				['file' => 'required|mimes:jpg,jpeg,png,gif|max:5120'],
				[
					'file.required' => 'El campo es requerido.',
					'file.mimes'    => 'Tipo de archivo no permitido.',
					'file.max'      => 'El archivo no debe superar los 5120kb.'
				]
			);

			if ($validation->fails()) {
				$main_errors['file'] = $validation->errors()->first('file');
			}
		}

		// Valido la descripcion
		if (array_key_exists('descripcion', $fields)) {
			$validation = Validator::make($fields,
				['descripcion'     => 'max:250'],
				['descripcion.max' => 'Utiliza como maximo 250 caracteres.']
			);

			if ($validation->fails()) {
				$main_errors['descripcion'] = $validation->errors()->first('descripcion');
			}
		}

		// Valido el campo select
		if (array_key_exists('select', $fields)) {
			$validation = Validator::make($fields,
				['select' => 'required'],
				['select.required' => 'El campo es requerido.']
			);

			if ($validation->fails()) {
				$main_errors['select'] = $validation->errors()->first('select');
			}
		}

		return $main_errors;
    }

    /**
     * validateFileAudio
     * @param  array $files
     * @return array|NULL $error
     */
    public static function validateFileAudio($files)
    {
    	$error = NULL;

    	$validation = Validator::make($files,
			['file' => 'required|max:20480'],
			[
				'file.required' => 'El campo es requerido.',
				'file.max'      => 'El archivo no debe superar los 20MB.'
			]
		);

		if ($validation->fails()) {
			$error = [];
			$error['file'] = $validation->errors()->first('file');
		}

		return $error;
    }

    /**
     * checkExtensionAudio
     * @param  resource $file
     * @return NULL|array
     */
    public static function checkExtensionAudio($file)
    {
		if ($file->getClientOriginalExtension() != 'mp3' && $request->file('file')->getClientOriginalExtension() != 'ogg') {
			return $error = ['file' => 'Tipo de archivo no permitido.'];
		}

		return NULL;
    }
}
