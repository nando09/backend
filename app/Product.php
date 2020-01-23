<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
	protected $fillable = [
		'im',
		'name',
		'free_shipping',
		'description',
		'price'
	];

	public $timestamps = false;
}
