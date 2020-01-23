<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use Illuminate\Support\Facades\Validator;
use App\Jobs\ProductImport;

class ProductController extends Controller
{
	public function index()
	{
		return Product::all();
	}

	public function addProducts($data){
		$product =  Product::create($data);

		echo "Finalizado";

		return [
			'status'	=>	'Enviado com sucesso!'
		];
	}

	public function store(Request $request)
	{
		$data = $request->all();

		// $validator = Validator::make($data, [
		// 	'im'				=>	['required', 'numeric', 'unique:products'],
		// 	'name'				=>	['required', 'string'],
		// 	'free_shipping'		=>	['required', 'boolean'],
		// 	'description'		=>	['required', 'string'],
		// 	'price'				=>	['required', 'numeric'],
		// ],
		// [
		// 	'im.required'				=>	"Campo 'im' é obrigatório!",
		// 	'im.numeric'				=>	"Campo 'im' tem que ser numerico!",
		// 	'im.unique'					=>	"Já existe esse 'im'!",
		// 	'name.required'				=>	"Campo 'name' é obrigatório!",
		// 	'free_shipping.required'	=>	"Campo 'free_shipping' é obrigatório!",
		// 	'free_shipping.boolean'		=>	"Campo 'free_shipping' tem que ser '0 ou 1'",
		// 	'description.required'		=>	"Campo 'description' tem que ser boolean",
		// 	'price.required'			=>	"Campo 'price' é obrigatório!",
		// 	'price.numeric'				=>	"Campo 'price' tem que ser um preço!",
		// ]);

		// if ($validator->fails()){
		// 	return $validator->errors();
		// }

		// $product =  Product::create($data);
		ProductImport::dispatch($this, $data);
		return [
			'status'	=>	'Importando...'
		];
	}

	public function show($id)
	{
		$product = Product::findOrFail($id);
		return $product;
	}

	public function update(Request $request, $id)
	{
		$data = $request->all();

		$validator = Validator::make($data, [
			'im'				=>	['required', 'numeric', 'unique:products'],
			'name'				=>	['required', 'string'],
			'free_shipping'		=>	['required', 'boolean'],
			'description'		=>	['required', 'string'],
			'price'				=>	['required', 'integer'],
		],
		[
			'im.required'				=>	"Campo 'im' é obrigatório!",
			'im.numeric'				=>	"Campo 'im' tem que ser numerico!",
			'im.unique'					=>	"Já existe esse 'im'!",
			'name.required'				=>	"Campo 'name' é obrigatório!",
			'free_shipping.required'	=>	"Campo 'free_shipping' é obrigatório!",
			'free_shipping.boolean'		=>	"Campo 'free_shipping' tem que ser boolean",
			'description.required'		=>	"Campo 'description' tem que ser boolean",
			'price.required'			=>	"Campo 'price' é obrigatório!",
			'price.integer'				=>	"Campo 'price' tem que ser um preço!",
		]);

		if ($validator->fails()){
			return $validator->errors();
		}

		$product = Product::findOrFail($id);
		$product->update($data);

		return $product;
	}

	public function destroy($id)
	{
		$product = Product::findOrFail($id);
		$product->delete();
		return $product;
	}
}
