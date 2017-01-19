<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
	/**
	 * $table
	 * @var string
	 */
    protected $table = 'album';

    /**
     * $primaryKey
     * @var string
     */
    protected $primaryKey = 'id_album';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['nombre', 'id_artista', 'cant_pistas', 'anio', 'id_album'];

}
