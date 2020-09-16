<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RetiroEquipo extends Model
{
    protected $table = 'retiro_equipo';
	protected $primaryKey = 'id';
	public $timestamps = true;

    protected $fillable = [
        'id',
        'service_id',
        'equipo',
        'marca',
        'modelo',
        'serie',
        'observaciones',
        'firma',
        'created_at',
        'updated_at'
    ];

    public function service()
    {
        return $this->belongsTo
        (
            'App\Service',
            'service_id',
            'id'
            
        )
        ->withDefault();
    }
}
