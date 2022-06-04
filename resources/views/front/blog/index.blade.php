@extends('layouts.front')
@section('content')

    @php
        $post_title="post_title_".$lang;
        $post_content="post_content_".$lang;
    @endphp
    <div class="padding-tb-40px background-light-grey">
        <div class="container">
            <div class="row justify-content-center">

                <!--  content -->
                <div class="col-lg-8 col-md-8 sticky-content">

                @foreach($posts as $post)
                    <!-- post -->
                        <div class="blog-entry background-white border-1 border-grey-1 margin-bottom-35px">
                            <div class="row no-gutters">
                                <div class="img-in col-lg-5"><a
                                            href="{{route('post',['id'=>$post->id]). ($lang!="de"? "?lang=".$lang : "")}}"><img
                                                src="images/{{$post->post_image}}" alt="{{$post->post_name}}"></a>
                                </div>
                                <div class="col-lg-7">
                                    <div class="padding-25px">
                                        <a class="d-block  text-capitalize text-up-small text-dark font-weight-700 margin-bottom-8px"
                                           href="{{route('post',['id'=>$post->id]) . ($lang!="de"? "?lang=".$lang : "")}}">{!! $post->$post_title !!}</a>
                                        <div class="d-block text-up-small text-grey-2 margin-bottom-10px">{!! substr(strip_tags($post->$post_content),0,150) !!}
                                        </div>
                                        <div class="meta">
                                            {{--                                        <span class="margin-right-20px text-extra-small">By : <a href="#"--}}
                                            {{--                                                                                                 class="text-main-color">Rabie Elkheir</a></span>--}}
                                            {{--                                            <span class="margin-right-20px text-extra-small">Date :  <a--}}
                                            {{--                                                        class="text-main-color date_latin_font">{{date('d-m-Y',strtotime($post->created_at))}}</a></span>--}}
                                            {{--                                            <span class="text-extra-small">Categorie :  <a href="#"--}}
                                            {{--                                                                                           class="text-main-color">Arts</a></span>--}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <!-- // post -->
                @endforeach

                <!-- pagination -->

                {{ $posts->links() }}
                <!-- // pagination -->
                </div>
                <!-- //  content -->


            </div>
        </div>
    </div>



@endsection

@section('script')
    <script>

        $('ul.pagination li:first a , ul.pagination li:first span').html('<<');
        $('ul.pagination li:last a , ul.pagination li:last span').html('>>');

    </script>
@endsection
