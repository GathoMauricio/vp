<?php

namespace App;
use Auth;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $table = 'files';
	protected $primaryKey = 'id';
	public $timestamps = true;

    protected $fillable = [
        'id',
        'service_id',
        'user_id',
        'route',
        "description",
        'created_at',
        'updated_at'
    ];
    protected static function boot()
	{
		parent::boot();
        static::creating(function ($query) {
			$query->user_id = Auth::user()->id;
		});
    }
    public function user()
    {
        return $this->belongsTo
        (
            'App\User',
            'user_id',
            'id'
            
        )
        ->withDefault();
    }
}
