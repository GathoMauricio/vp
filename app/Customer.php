<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'customers';
	protected $primaryKey = 'id';
	public $timestamps = true;

    protected $fillable = [
        'customer_type_id',
        'name',
        'code',
        'rfc',
        'responsable_name',
        'responsable_last_name1',
        'responsable_last_name2',
        'phone',
        'email',
        'cp',
        'asentamiento',
        'ciudad',
        'municipio',
        'estado',
        'calle_numero',
        'piso',
        'interior',
        'image'
    ];

    public function customer_type()
    {
        return $this->belongsTo
        (
            'App\CustomerType',
            'customer_type_id',
            'id'
            
        )
        ->withDefault();
    }
}
