<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cancion extends Model
{
	/**
	 * $table
	 * @var string
	 */
    protected $table = 'cancion';

    /**
     * $primaryKey
     * @var string
     */
    protected $primaryKey = 'id_cancion';

    protected $fillable = ['nombre_cancion', 'id_album', 'formato', 'duracion', 'src_audio', 'anio', 'idioma', 'contador'];
}
