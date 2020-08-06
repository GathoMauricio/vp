<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Purifier;
use Config;

class Mensaje extends Model
{
    protected $table = 'mensajes';
	protected $primaryKey = 'id';
	public $timestamps = true;

    protected $fillable = [
        'id',
        'service_id',
        'leido', 
        'emisor_id',
        'receptor_id',
        'mensaje',
        'icon',
        'color',
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
    public function emisor()
    {
        return $this->belongsTo
        (
            'App\User',
            'emisor_id',
            'id'
            
        )
        ->withDefault();
    }
    public function receptor()
    {
        return $this->belongsTo
        (
            'App\User',
            'receptor_id',
            'id'
            
        )
        ->withDefault();
    }
    /*
    public function setMensajeAttribute($value) {
        $this->attributes['mensaje'] = Purifier::clean( $value );
    }
    */
}
