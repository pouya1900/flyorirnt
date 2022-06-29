<?php

namespace App\Http\Controllers\Admin;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PostController extends Controller {
	public function index() {

		$posts = Post::all();

		return view( 'admin.posts.index', compact( 'posts' ) );

	}


	public function add() {

		return view( 'admin.posts.add_post' );

	}

	public function store( Request $request ) {

		$status    = 0;
		$home_page = 0;

		if ( $request->has( 'status' ) ) {
			$status = 1;
		}
		if ( $request->has( 'home_page' ) ) {
			$home_page = 1;
		}


		$insert = [
			"post_name"       => $request->input( 'name' ),
//			"post_image"=>'post/'.$request->input('image'),
			"post_title_en"   => $request->input( 'title_en' ),
			"post_title_de"   => $request->input( 'title_de' ),
			"post_title_fa"   => $request->input( 'title_fa' ),
			"post_title_ru"   => $request->input( 'title_ru' ),
			"post_content_en" => $request->input( 'content_en' ),
			"post_content_de" => $request->input( 'content_de' ),
			"post_content_fa" => $request->input( 'content_fa' ),
			"post_content_ru" => $request->input( 'content_ru' ),
			"status"          => $status,
			"home_page"       => $home_page,
		];

		if ( $request->file( 'image' ) ) {


			$path = $request->file( 'image' )->store( 'images/post', 'upload' );
			$path = str_replace( "images/", "", $path );

			$insert["post_image"] = $path;

		}


		Post::create( $insert );

		return redirect()->route( 'admin.posts' )->with( 'message', 'new post created successfully' );

	}


	public function edit( $id ) {

		$post = Post::find( $id );

		return view( 'admin.posts.edit_post', compact( 'post' ) );


	}


	public function update( Request $request ) {

		$id = $request->input( 'id' );

		$post = Post::find( $id );

		$status    = 0;
		$home_page = 0;

		if ( $request->has( 'status' ) ) {
			$status = 1;
		}
		if ( $request->has( 'home_page' ) ) {
			$home_page = 1;
		}

		if ( $post ) {
			$insert = [
				"post_name"       => $request->input( 'name' ),
				"post_title_en"   => $request->input( 'title_en' ),
				"post_title_de"   => $request->input( 'title_de' ),
				"post_title_fa"   => $request->input( 'title_fa' ),
				"post_title_ru"   => $request->input( 'title_ru' ),
				"post_content_en" => $request->input( 'content_en' ),
				"post_content_de" => $request->input( 'content_de' ),
				"post_content_fa" => $request->input( 'content_fa' ),
				"post_content_ru" => $request->input( 'content_ru' ),
				"status"          => $status,
				"home_page"       => $home_page,
			];


			if ( $request->file( 'image' ) ) {


				$path = $request->file( 'image' )->store( 'images/post', 'upload' );
				$path = str_replace( "images/", "", $path );

				$insert["post_image"] = $path;

			}


			$post->update( $insert );
		}

		return redirect()->route( 'admin.edit_post', [ 'id' => $id ] )->with( 'message', 'post updated successfully' );

	}

	public function delete( Request $request ) {


		$id = $request->input( 'id' );

		$post = Post::find( $id );

		if ( $post instanceof Post) {
			$post->delete();
		}
	}


}
