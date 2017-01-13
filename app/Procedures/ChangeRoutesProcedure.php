<?php
namespace App\Procedures;

use DB;

class ChangeRoutesProcedure
{
	public static function updateRouteArtist($old_route, $new_route)
	{
		return DB::select('CALL CHANGE_ROUTES_1(?,?)', array($old_route, $new_route));
	}

	public static function updateRouteAlbum($old_route, $new_route)
	{
		return DB::select('CALL CHANGE_ROUTES_2(?,?)', array($old_route, $new_route));
	}
}
