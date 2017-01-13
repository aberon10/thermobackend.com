<?php
namespace App;

class File
{
	/**
	 * fullCopy
	 * Copia el contenido de un directorios a otro.
	 *
	 * @param {String}  $source
	 * @param {String}  $target
	 */
	public static function fullCopy($source, $target)
	{
		if (is_dir($source)) {
			// si no existe lo crea
			if (!is_dir($target)) {
				@mkdir($target);
			}
			// Creo una instancia de la clase Directory
			$directory = dir($source);

			// leeo el directorio
			while (FALSE !== ($entry = $directory->read())) {

				if ($entry == '.' || $entry == '..') {
					continue;
				}

				$Entry = $source.'/'.$entry;

				// si es un directorio vuelvo a llamar a la funcion
				// de lo contrario, si es un archivo lo copio al destino
				(is_dir($Entry)) ? self::fullCopy($Entry, $target.'/'.$entry) : copy($Entry, $target.'/'.$entry);
			}
			$directory->close();
		} else {
			copy($source, $target);
		}
	}

	/**
	 * removeDir
	 * Elimina el contenido de un directorio y despues este ultimo,
	 * en caso de que el argumento $delete_root sea true.
	 *
	 * @param  string  $dir directorio
	 * @return boolean
	 */
	public static function removeDir($dir, $delete_root = true) {
		$files = array_diff(scandir($dir), array('.','..'));

		foreach ($files as $file) {
			(is_dir("$dir/$file")) ? self::removeDir("$dir/$file") : unlink("$dir/$file");
		}

		return ($delete_root) ? rmdir($dir) : true;
	}

}
