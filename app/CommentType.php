<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CommentType extends Model
{
    protected $table = 'comment_types';
	protected $primaryKey = 'id';
	public $timestamps = true;

    protected $fillable = [
        'id',
        'comment_type',
        'created_at',
        'updated_at'
    ];
}
