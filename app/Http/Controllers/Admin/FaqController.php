<?php

namespace App\Http\Controllers\Admin;

use App\Models\Faq;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FaqController extends Controller {
	public function index() {

		$faqs = Faq::all();

		return view( 'admin.faqs.index', compact( 'faqs' ) );

	}


	public function add() {

		return view( 'admin.faqs.add_faq' );

	}

	public function store( Request $request ) {

		$status = 0;

		if ( $request->has( 'status' ) ) {
			$status = 1;
		}


		$insert = [
			"title_en"   => $request->input( 'title_en' ),
			"title_de"   => $request->input( 'title_de' ),
			"title_fa"   => $request->input( 'title_fa' ),
			"title_ru"   => $request->input( 'title_ru' ),
			"content_en" => $request->input( 'content_en' ),
			"content_de" => $request->input( 'content_de' ),
			"content_fa" => $request->input( 'content_fa' ),
			"content_ru" => $request->input( 'content_ru' ),
			"status"     => $status,
		];


		Faq::create( $insert );

		return redirect()->route( 'admin.faqs' )->with( 'message', 'new faq created successfully' );

	}


	public function edit( $id ) {

		$faq = Faq::find( $id );

		return view( 'admin.faqs.edit_faq', compact( 'faq' ) );


	}


	public function update( Request $request ) {

		$id = $request->input( 'id' );

		$faq = Faq::find( $id );

		$status = 0;

		if ( $request->has( 'status' ) ) {
			$status = 1;
		}


		if ( $faq ) {
			$insert = [
				"title_en"   => $request->input( 'title_en' ),
				"title_de"   => $request->input( 'title_de' ),
				"title_fa"   => $request->input( 'title_fa' ),
				"title_ru"   => $request->input( 'title_ru' ),
				"content_en" => $request->input( 'content_en' ),
				"content_de" => $request->input( 'content_de' ),
				"content_fa" => $request->input( 'content_fa' ),
				"content_ru" => $request->input( 'content_ru' ),
				"status"     => $status,
			];


			$faq->update( $insert );
		}

		return redirect()->route( 'admin.edit_faq', [ 'id' => $id ] )->with( 'message', 'faq updated successfully' );

	}

	public function delete( Request $request ) {


		$id = $request->input( 'id' );


		$faq = Faq::find( $id );
		if ( $faq instanceof Faq) {
			$faq->delete();
		}
	}

}
