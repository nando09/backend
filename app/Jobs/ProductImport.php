<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Http\Controllers\ProductController;

class ProductImport implements ShouldQueue
{
	use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
	protected $productController, $path;

	/**
	 * Create a new job instance.
	 *
	 * @return void
	 */
	public function __construct(ProductController $productController)
	{
		$this->productController = $productController;
		// $this->path = $path;
	}

	/**
	 * Execute the job.
	 *
	 * @return void
	 */
	public function handle()
	{
		$this->productController->addProducts();
	}
}
