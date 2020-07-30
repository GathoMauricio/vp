<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StatusService extends Model
{
    protected $table = 'status_services';
	protected $primaryKey = 'id';
	public $timestamps = true;

    protected $fillable = [
        'id',
        'status_service'
    ];
}
