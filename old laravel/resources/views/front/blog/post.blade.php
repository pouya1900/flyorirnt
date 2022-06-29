@extends('layouts.front')
@section('content')

    @php

        if (\Illuminate\Support\Facades\Auth::check()){
        $user=\Illuminate\Support\Facades\Auth::user();
        $user_name=$user->f_name." ".$user->l_name;
        $user_email=$user->email;

        }

        $post_title="post_title_".$lang;
        $post_content="post_content_".$lang;
    @endphp
    <div class="padding-tb-40px background-light-grey">
        <div class="container">
            <div class="row justify-content-center">

                <!--  content -->
                <div class="col-lg-8 col-md-8 sticky-content">

                    <!-- post -->
                    <div class="blog-entry background-white border-1 border-grey-1 margin-bottom-35px">
                        {{--                    <div class="img-in"><img src="http://placehold.it/1600x800" alt=""></div>--}}
                        <div class="padding-30px">
                            <div class="meta">
                                {{--                            <span class="margin-right-20px text-extra-small">By : <a href="#" class="text-main-color">Rabie Elkheir</a></span>--}}
                               
                                {{--                            <span class="text-extra-small">Categorie :  <a href="#" class="text-main-color">Arts</a></span>--}}
                            </div>
                            <h1 class="d-block  text-capitalize text-large text-dark font-weight-700 margin-bottom-10px"
                                href="#">
                                {!! $post->$post_title !!}
                            </h1>
                            <div class="post-entry">
                                <div class="d-block text-up-small text-grey-4 margin-bottom-15px">
                                    {!! $post->$post_content !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- // post -->


                    <!-- Related Posts -->
                {{--                <div class="background-white border-1 border-grey-1 margin-bottom-35px padding-30px">--}}
                {{--                    <h4 class="table-title margin-bottom-30px"><span>Related Posts</span></h4>--}}

                {{--                    <div class="row">--}}
                {{--                        <div class="col-lg-6">--}}
                {{--                            <div class="background-white">--}}
                {{--                                <div class="post-img">--}}
                {{--                                    <a href="#"><img src="http://placehold.it/450x300" alt=""></a>--}}
                {{--                                </div>--}}
                {{--                                <div class="margin-top-30px">--}}
                {{--                                    <a href="#" class="d-block text-dark text-uppercase text-medium margin-bottom-10px font-weight-700">13 Non-Travel Books That Changed My Life</a>--}}
                {{--                                    <span class="margin-right-20px text-extra-small">By : <a href="#" class="text-main-color">Rabie Elkheir</a></span>--}}
                {{--                                    <span class="text-extra-small">Date :  <a href="#" class="text-main-color">July 15, 2016</a></span>--}}
                {{--                                    <p class="text-grey-2 margin-top-8px">up a land of wild nature, mystical and unexplored. With only 350,000 visitors per year, Madagascar is one of the most well-known but least visited </p>--}}
                {{--                                </div>--}}
                {{--                            </div>--}}
                {{--                        </div>--}}
                {{--                        <div class="col-lg-6">--}}
                {{--                            <div class="background-white">--}}
                {{--                                <div class="post-img">--}}
                {{--                                    <a href="#"><img src="http://placehold.it/450x300" alt=""></a>--}}
                {{--                                </div>--}}
                {{--                                <div class="margin-top-30px">--}}
                {{--                                    <a href="#" class="d-block text-dark text-uppercase text-medium margin-bottom-10px font-weight-700">13 Non-Travel Books That Changed My Life</a>--}}
                {{--                                    <span class="margin-right-20px text-extra-small">By : <a href="#" class="text-main-color">Rabie Elkheir</a></span>--}}
                {{--                                    <span class="text-extra-small">Date :  <a href="#" class="text-main-color">July 15, 2016</a></span>--}}
                {{--                                    <p class="text-grey-2 margin-top-8px">up a land of wild nature, mystical and unexplored. With only 350,000 visitors per year, Madagascar is one of the most well-known but least visited </p>--}}
                {{--                                </div>--}}
                {{--                            </div>--}}
                {{--                        </div>--}}


                {{--                    </div>--}}
                {{--                    <!-- // row -->--}}
                {{--                </div>--}}
                <!-- // Related Posts -->

                    {{--                    <!--  Comment -->--}}
                    {{--                    <div class="background-white border-1 border-grey-1 margin-bottom-35px padding-30px">--}}
                    {{--                        <h4 class="table-title margin-bottom-30px"><span>Comment</span></h4>--}}
                    {{--                        <ul class="commentlist padding-0px margin-0px list-unstyled text-grey-3">--}}

                    {{--                            @foreach($post->comments as $comment)--}}
                    {{--                                <li class="border-bottom-1 border-grey-1 margin-bottom-20px">--}}
                    {{--                                    <img src="http://placehold.it/60x60"--}}
                    {{--                                         class="float-left margin-right-20px margin-bottom-20px" alt="">--}}
                    {{--                                    <div class="margin-left-85px">--}}
                    {{--                                        <a class="d-block text-dark text-uppercase text-medium font-weight-700">--}}
                    {{--                                            {{$comment->comment_author}}</a>--}}
                    {{--                                        <span class="text-extra-small">Date :  <a  class="text-main-color date_latin_font">{{$comment->created_at}}</a></span>--}}
                    {{--                                        <p class="margin-top-15px">{{$comment->comment_content}}</p>--}}
                    {{--                                    </div>--}}
                    {{--                                </li>--}}

                    {{--                            @endforeach--}}

                    {{--                        </ul>--}}
                    {{--                    </div>--}}
                    {{--                    <!-- // Comment -->--}}


                    {{--                    <!--  Add Comment -->--}}
                    {{--                    <div class="background-white border-1 border-grey-1 margin-bottom-35px padding-30px">--}}
                    {{--                        <h4 class="table-title margin-bottom-30px"><span>Add Comment</span></h4>--}}
                    {{--                        <form>--}}
                    {{--                            <div class="form-row">--}}
                    {{--                                <div class="form-group col-md-6">--}}
                    {{--                                    <label for="full_name">Full Name</label>--}}
                    {{--                                    <input type="text" name="full_name" class="form-control" id="full_name" placeholder="Name" value="{{\Illuminate\Support\Facades\Auth::check() ? $user_name : ""}}">--}}
                    {{--                                </div>--}}
                    {{--                                <div class="form-group col-md-6">--}}
                    {{--                                    <label for="email">Email</label>--}}
                    {{--                                    <input type="email" name="email" class="form-control" id="email" placeholder="Email" value="{{\Illuminate\Support\Facades\Auth::check() ? $user_email : ""}}">--}}
                    {{--                                </div>--}}
                    {{--                            </div>--}}
                    {{--                            <div class="form-group">--}}
                    {{--                                <label for="inputAddress">Website :</label>--}}
                    {{--                                <input type="text" class="form-control" id="inputAddress" placeholder="Website">--}}
                    {{--                            </div>--}}
                    {{--                            <div class="form-group">--}}
                    {{--                                <label for="exampleFormControlTextarea1">Comment :</label>--}}
                    {{--                                <textarea name="comment_content" class="form-control" id="exampleFormControlTextarea1" rows="3"--}}
                    {{--                                          placeholder="Comment"></textarea>--}}
                    {{--                            </div>--}}
                    {{--                            <a href="#"--}}
                    {{--                               class="btn-sm btn-lg btn-block background-main-color text-white text-center font-weight-bold text-uppercase rounded-0 padding-10px">Send</a>--}}
                    {{--                        </form>--}}
                    {{--                    </div>--}}
                    {{--                    <!-- // Add Comment -->--}}


                </div>
                <!-- //  content -->

            </div>
        </div>
    </div>
@endsection
