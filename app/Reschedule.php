<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reschedule extends Model
{
    protected $table = 'reschedules';
	protected $primaryKey = 'id';
	public $timestamps = true;

    protected $fillable = [
        'id',
        'service_id',
        'manager_id',
        'last_date',
        'new_date',
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
    public function manager()
    {
        return $this->belongsTo
        (
            'App\User',
            'manager_id',
            'id'
            
        )
        ->withDefault();
    }
}
