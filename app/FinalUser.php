<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FinalUser extends Model
{
    protected $table = 'final_users';
	protected $primaryKey = 'id';
	public $timestamps = true;

    protected $fillable = [
        'id',
        'customer_id',
        'name',
        'last_name1',
        'last_name2',
        'email',
        'phone',
        'extension',
        'area_descripcion',
        'cp',
        'asentamiento',
        'ciudad',
        'municipio',
        'estado',
        'calle_numero',
        'piso',
        'interior',
        'image',
        'password'
    ];
    public function customer()
    {
        return $this->belongsTo
        (
            'App\Customer',
            'customer_id',
            'id'
            
        )
        ->withDefault();
    }
    public function setNameAttribute($value)
    {
        $fragmentos = explode(' ',$value);
        $resultado ="";
        for($i=0;$i<count($fragmentos);$i++)
        {
            $resultado .= \Str::studly(strtolower($fragmentos[$i]))." ";
        }
        $this->attributes['name'] = $resultado;
    }
    public function setLastName1Attribute($value)
    {
        $fragmentos = explode(' ',$value);
        $resultado ="";
        for($i=0;$i<count($fragmentos);$i++)
        {
            $resultado .= \Str::studly(strtolower($fragmentos[$i]))." ";
        }
        $this->attributes['last_name1'] = $resultado;
    }
    public function setLastName2Attribute($value)
    {
        $fragmentos = explode(' ',$value);
        $resultado ="";
        for($i=0;$i<count($fragmentos);$i++)
        {
            $resultado .= \Str::studly(strtolower($fragmentos[$i]))." ";
        }
        $this->attributes['last_name2'] = $resultado;
    }
    
}
