<?php

namespace App\Imports;

use App\Product;
use Maatwebsite\Excel\Concerns\ToModel;

class ProductImport implements ToModel
{
	/**
	* @param array $row
	*
	* @return \Illuminate\Database\Eloquent\Model|null
	*/
	public function model(array $row)
	{
		return new Product([
			'im'				=>	$row[0],
			'name'				=>	$row[1],
			'free_shipping'		=>	$row[2],
			'description'		=>	$row[3],
			'price'				=>	$row[4]
		]);
	}
}
