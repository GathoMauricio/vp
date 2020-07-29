<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sepomex extends Model
{
    protected $table = 'sepomex';
	protected $primaryKey = 'id';
	public $timestamps = true;

    protected $fillable = [
        'id',
        'idEstado',
        'idMunicipio',
        'municipio',
        'ciudad',
        'zona',
        'cp',
        'asentamiento',
        'tipo'
    ];
}
