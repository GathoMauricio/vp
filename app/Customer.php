<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'customers';
	protected $primaryKey = 'id';
	public $timestamps = true;

    protected $fillable = [
        'id',
        'customer_type_id',
        'responsable_id',
        'name',
        'code',
        'rfc',
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
    public function responsable()
    {
        return $this->belongsTo
        (
            'App\FinalUser',
            'responsable_id',
            'id'
            
        )
        ->withDefault();
    }
    public function setResponsableNameAttribute($value)
    {
        $fragmentos = explode(' ',$value);
        $resultado ="";
        for($i=0;$i<count($fragmentos);$i++)
        {
            $resultado .= \Str::studly(strtolower($fragmentos[$i]))." ";
        }
        $this->attributes['responsable_name'] = $resultado;
    }
    public function setResponsableLastName1Attribute($value)
    {
        $fragmentos = explode(' ',$value);
        $resultado ="";
        for($i=0;$i<count($fragmentos);$i++)
        {
            $resultado .= \Str::studly(strtolower($fragmentos[$i]))." ";
        }
        $this->attributes['responsable_last_name1'] = $resultado;
    }
    public function setResponsableLastName2Attribute($value)
    {
        $fragmentos = explode(' ',$value);
        $resultado ="";
        for($i=0;$i<count($fragmentos);$i++)
        {
            $resultado .= \Str::studly(strtolower($fragmentos[$i]))." ";
        }
        $this->attributes['responsable_last_name2'] = $resultado;
    }
    public function setEmailAttribute($value)
	{
		$this->attributes['email'] = strtolower($value);
    }
    public function setRfcAttribute($value)
	{
		$this->attributes['rfc'] = strtoupper($value);
    }
}
