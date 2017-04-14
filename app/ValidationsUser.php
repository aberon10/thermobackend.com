<?php
declare(strict_types=1);
namespace App;

use Illuminate\Support\Facades\Validator;

class ValidationsUser
{
	private static $reg_exp = array(
		'name'     => "/^[A-Za-z-ÁÉÍÓÚÑáéíóúñ\s]{2,60}$/",
		'username' => "/^[a-z0-9\_]+$/",
		'email'    => "/^([\w_\.\-]{4,60})@(([\w\-]{2,25})+\.)+([\w]{2,20})$/",
		'date'     => "/^(\d{1,2})+\/+(\d{1,2})+\/+(\d{4})$/"
	);

	public static function validateFields(array $fields) :array
	{
		$main_errors = [];

		// Usuario
		if (array_key_exists('usuario', $fields)) {
			$validation = Validator::make($fields,
				['usuario' => 'required|regex:'.self::$reg_exp['username']],
				[
					'usuario.required' => 'El campo es requerido.',
					'usuario.regex'    => 'El usuario ingresado no es valido.',
				]
			);

			if ($validation->fails()) {
				$main_errors['username'] = $validation->errors()->first('usuario');
			}
		}

		// Cuenta
		if (array_key_exists('cuenta', $fields)) {
			$validation = Validator::make($fields,
				['cuenta' => 'required|in:1,2'],
				[
					'cuenta.required' => 'El campo es requerido.',
					'cuenta.in'       => 'La cuenta ingresada no es valida.',
				]
			);

			if ($validation->fails()) {
				$main_errors['cuenta'] = $validation->errors()->first('cuenta');
			}
		}

		// Nombre
		if (array_key_exists('nombre', $fields)) {
			$validation = Validator::make($fields,
				['nombre' => 'required|regex:'.self::$reg_exp['name']],
				[
					'nombre.required' => 'El campo es requerido.',
					'nombre.regex'    => 'El nombre ingresado no es valido.',
				]
			);

			if ($validation->fails()) {
				$main_errors['nombre'] = $validation->errors()->first('nombre');
			}
		}

		// Apellido
		if (array_key_exists('apellido', $fields)) {
			$validation = Validator::make($fields,
				['apellido' => 'required|regex:'.self::$reg_exp['name']],
				[
					'apellido.required' => 'El campo es requerido.',
					'apellido.regex'    => 'El apellido ingresado no es valido.',
				]
			);

			if ($validation->fails()) {
				$main_errors['apellido'] = $validation->errors()->first('apellido');
			}
		}

		// Correo
		if (array_key_exists('correo', $fields)) {
			$validation = Validator::make($fields,
				['correo' => 'required|regex:'.self::$reg_exp['email']],
				[
					'correo.required' => 'El campo es requerido.',
					'correo.regex'    => 'El correo ingresado no es valido.',
				]
			);

			if ($validation->fails()) {
				$main_errors['correo'] = $validation->errors()->first('correo');
			}
		}

		// Sexo
		if (array_key_exists('sexo', $fields)) {
			$validation = Validator::make($fields,
				['sexo' => 'required|in:F,M'],
				[
					'sexo.required' => 'El campo es requerido.',
					'sexo.in'    	=> 'El sexo ingresado no es valido.',
				]
			);

			if ($validation->fails()) {
				$main_errors['sexo'] = $validation->errors()->first('sexo');
			}
		}

		// Fecha de nacimiento
		if (array_key_exists('day', $fields) && array_key_exists('month', $fields) && array_key_exists('year', $fields)) {
			$date = $fields['day'].'/'.$fields['month'].'/'.$fields['year'];

			if (!self::validateFormatDate($date) || !self::validationsDate($date)) {
				$main_errors['fecha_nacimiento'] = 'La fecha no es valida.';
			} else if (!self::validateHigherOfOld($date)) {
				$main_errors['fecha_nacimiento'] = 'Debe ser mayor de edad.';
			}
		}

		// // Contraseña
		if (array_key_exists('pass', $fields)) {
			$validation = Validator::make($fields,
				['pass' => 'required|min:8|max:30'],
				[
					'pass.required' => 'El campo es requerido.',
					'pass.min'    	=> 'Utiliza al menos una combinación entre 8 y 30 números, letras, guiones y signos de puntuación (como ! y &).',
					'pass.max'    	=> 'Utiliza al menos una combinación entre 8 y 30 números, letras, guiones y signos de puntuación (como ! y &).',
				]
			);

			if ($validation->fails()) {
				$main_errors['pass'] = $validation->errors()->first('pass');
			}
		}

		// Confirmacion de la contraseña
		if (array_key_exists('confirm_password', $fields)) {
			$validation = Validator::make($fields,
				['confirm_password' => 'required'],
				['confirm_password.required' => 'El campo es requerido.']
			);

			if ($validation->fails()) {
				$main_errors['confirm_password'] = $validation->errors()->first('confirm_password');
			} else if ($fields['confirm_password'] != $fields['pass']) {
				$main_errors['confirm_password'] = 'La contraseña, no coincide';
			}
		}

		return $main_errors;
	}

	/**
     * validateFormatDate
     * Comprueba que el formato de la fecha sea valido
     *
     * @param  string $date
     * @return bool
     */
    public static function validateFormatDate(string $date) :bool
    {
        return (preg_match(self::$reg_exp['date'], $date)) ? true : false;
    }

    /**
     * validationsDate
     * Comprueba la validez de una fecha utilizando el calendario gregoriano.
     *
     * @param  string $date
     * @return bool
     */
    public static function validationsDate(string $date) :bool
    {
        list($d, $m, $y) = explode('/', $date);

        // checkdate valida una fecha gregoriana
        return (checkdate((int)$m, (int)$d, (int)$y)) ? true : false;
    }

    /**
     * validateHigherOfOld
     * Comprueba si una fecha dada corresponde como una fecha
     * valida de una persona mayor de edad.
     *
     * @param  string $date
     * @return bool
     */
    public static function validateHigherOfOld(string $date) :bool
    {
        // strtotime   => convierte una fecha a formato UNIX
        // str_replace => remplaza un string por otro
        // date        => le da formato a la fecha
        // date_create => devuelve un nuevo objeto DateTime
        // date_diff   => diferencia entre dos fechas ->y anio ->m mes ->d dias

        $date  = strtotime(str_replace('/', '-', $date)); // Fecha a formato UNIX
        $date  = date_create(date('Y-m-d', $date));       // Devuelve un nuevo objeto DateTime
        $today = date_create('today');                    // Objeto DateTime con la fecha actual
        $age   = date_diff($date, $today)->y;             // Diferencia entre las fechas en años

        return ( $age >= 18 ) ? true : false;
    }

}
