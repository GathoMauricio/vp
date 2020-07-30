<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerType extends Model
{
    protected $table = 'customers_types';
	protected $primaryKey = 'id';
	public $timestamps = true;

    protected $fillable = [
        'id',
        'customer_type'
    ];
}
