<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;

class Service extends Model
{
    protected $table = 'services';
	protected $primaryKey = 'id';
	public $timestamps = true;

    protected $fillable = [
        'id',
        'status_service_id',
        'service_type_id',
        'service_report',
        'final_user_id',
        'manager_id',
        'technical_id',
        'customer_id',
        'description',
        'priority',
        'observations',
        'schedule',
        'solution',
        'init_service',
        'end_service',
        'firm',
        'created_at',
        'updated_at'
    ];
    //Valores implícitos de quien crea el servicio
    protected static function boot()
	{
		parent::boot();
        static::creating(function ($query) {
			$query->manager_id = Auth::user()->id;
		});
    }
    public function status()
    {
        return $this->belongsTo
        (
            'App\StatusService',
            'status_service_id',
            'id'
        )
        ->withDefault();
    }
    public function service_type()
    {
        return $this->belongsTo
        (
            'App\ServiceType',
            'service_type_id',
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
    public function technical()
    {
        return $this->belongsTo
        (
            'App\User',
            'technical_id',
            'id'
        )
        ->withDefault();
    }
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
    public function usuario_Final()
    {
        return $this->belongsTo
        (
            'App\FinalUser',
            'final_user_id',
            'id'
        )
        ->withDefault();
    }
}
