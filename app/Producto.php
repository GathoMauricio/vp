<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table = 'productos';
	protected $primaryKey = 'id';
	public $timestamps = true;

    protected $fillable = [
        'id',
        'service_id',
        'equipo_refaccion',
        'marca',
        'modelo',
        'serie',
        'otro',
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
