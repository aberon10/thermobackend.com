<?php
namespace App;

class DateFormat
{
	public static function format(string $date)
	{
		$temp_date = explode(' ', $date);
		$new_format_date = explode('-', $temp_date[0]); // date
		return $new_format_date[2].'-'.$new_format_date[1].'-'.$new_format_date[0].' '.$temp_date[1];
	}
}
