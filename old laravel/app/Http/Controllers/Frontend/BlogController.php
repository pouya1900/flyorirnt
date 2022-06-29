<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;

class BlogController extends Controller
{
	public function index() {


		$lang = App::getLocale();

		$posts=Post::paginate(15);


		return view('front.blog.index',compact('posts','lang'));

    }


	public function post($id) {

		$lang = App::getLocale();

		$post=Post::with(['comments'=>function ( $query ) {
			$query->where('comment_approved','1');
		}])->find($id);


		return view('front.blog.post',compact('post','lang'));

    }
}
