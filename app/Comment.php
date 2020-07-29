<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;

class Comment extends Model
{
    protected $table = 'comments';
	protected $primaryKey = 'id';
	public $timestamps = true;

    protected $fillable = [
        'id',
        'service_id',
        'user_id',
        'comment_type_id',
        'comment',
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
    public function type()
    {
        return $this->belongsTo
        (
            'App\CommentType',
            'comment_type_id',
            'id'
            
        )
        ->withDefault();
    }
}
