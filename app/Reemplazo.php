<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reemplazo extends Model
{
    protected $table = 'reemplazos';
	protected $primaryKey = 'id';
	public $timestamps = true;

    protected $fillable = [
        'id',
        'service_id',
        'reemplazo',
        'marca',
        'modelo',
        'serie',
        'otro',
        'costo',
        'entrega',
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
