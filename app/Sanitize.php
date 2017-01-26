<?php
namespace App;

class Sanitize
{
	/**
	 * punctuationMarks
	 * Se encarga de eliminar cualquier caracter extraño
	 * @param  string $str
	 * @return string
	 */
	public static function punctuationMarks(string $str)
	{
	    return str_replace(
	        array("\\", "¨", "º", "-", "~",
	             "#", "@", "|", "!", "\"",
	             "·", "$", "%", "&", "\/",
	             "(", ")", "?", "'", "¡",
	             "¿", "[", "^", "<code>", "]",
	             "+", "}", "{", "¨", "´",
	             ">", "< ", ";", ",", ":",
	             ".", " ", "*"),
	        '',
	        $str
	    );
	}
}
