<?php

namespace App\Http\Controllers\Admin;

use App\Models\Faq;
use App\Models\Page;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\AdminImageTrait;

class ImageController extends Controller
{
	use AdminImageTrait;

	protected $storageDisk;

	public function __construct() {
		$this->storageDisk = "uploadImage";
	}

	public function index() {


		return view('admin.upload.index');

	}


	public function store(Request $request) {


			$imageData = $this->storeImage( $request, $this->storageDisk, 'file' );

			return $imageData;

	}




}
