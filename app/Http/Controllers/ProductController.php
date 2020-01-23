<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use Illuminate\Support\Facades\Validator;
use App\Jobs\ProductImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ProductImport as ImportExcel;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
	public function index()
	{
		return Product::all();
	}

	public function addProducts(){
		$path = public_path('/upload/excel.xlsx');
		// return $path;

		$products = Excel::toCollection(new ImportExcel, $path);
		$data = array();

		foreach($products[0] as $key) {
			$product = [
				'im'				=>	strval($key[0]),
				'name'				=>	strval($key[1]),
				'free_shipping'		=>	strval($key[2]),
				'description'		=>	strval($key[3]),
				'price'				=>	strval($key[4])
			];

			if ($key[0] === null || $key[1] === null || $key[2] === null || $key[3] === null || $key[4] === null || $key[0] == 'lm') {
				continue;
			}
			array_push($data, $product);

		}

		DB::table('products')->insert($data);
		// return;
		echo 'Enviado com sucesso!';
	}

	public function store(Request $request)
	{
		$data = $request->all();

		$validator = Validator::make($data, [
			// 'file'	=>	['required', 'mimes:application/vnd.ms-excel'],
			// 'file'	=>	['required', 'mimes:xlsx,xls'],
			'file'	=>	['required'],
		],
		[
			'file.required'				=>	"Não existe arquivo file!",
			// 'file.mimes'				=>	"O arquivo tem que ser 'xlsx'!",
		]);

		if ($validator->fails()){
			return $validator->errors();
		}

		/*
			mimes XLSX não estava funcionando, com outra extensão como PDF estava funcionando perfeitamente.
			Então preferi verificar assim o arquivo.
		*/

		if ($data['file']->getClientOriginalExtension() != 'xlsx') {
			return [
				"file" => [
							"O arquivo tem que ser 'xlsx'!"
				]
			];
		}

		/*
			As proximas linhas comentadas fazem uma movimentação de imagem, porem prefiro não movimenta-la e usar-la no tmp mesmo.
		*/

		$file		=	$data['file'];
		$fileName	=	"excel." . $file->getClientOriginalExtension();
		$savePath	=	public_path('/upload/');

		if (file_exists(public_path('/upload/excel.xlsx'))) {
			unlink(public_path("/upload/excel.xlsx"));
		}

		$file->move($savePath, $fileName);
		// $this->addProducts();

		ProductImport::dispatch($this);

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
