<?php
namespace App;

/**
 * @author  Alejandro Berón <alejandroberon10@gmail.com>
 * @date    2017-01-23
 * @version 1.0
 */

class Password
{
    /**
     * CHARACTERS carcateres utilizados para generar contraseñas.
     * @var string
     */
    const CHARACTERS = "1234567890abcdefghijklmnopqrstuvwxyz%_-*+-&/#%";

	/**
	  * passwordGenerate
	  * Genera un password aleatorio utilizando letras y números.
	  *
	  * @param   int    $length
	  * @return  string $password
	  */
	public static function passwordGenerate(int $length = 8) {
	    return substr(str_shuffle(self::CHARACTERS), 0, $length);
	}
}
