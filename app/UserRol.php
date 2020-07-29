<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserRol extends Model
{
    protected $table = 'users_roles';
	protected $primaryKey = 'id';
	public $timestamps = true;

    protected $fillable = [
        'id',
        'user_id',
        'rol_id',
    ];
    public function rol_name()
    {
        return $this->belongsTo
        (
            'App\Rol',
            'rol_id',
            'id'
            
        )
        ->withDefault();
    }
}
