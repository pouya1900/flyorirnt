<!-- ======= Our Service  ======= -->

@php
    $post_title="post_title_".$lang;
    $post_content="post_content_".$lang;
@endphp
<section id="our-service" class="hot-hotels padding-tb-100px background-light-grey">
    <!--
        <section id="top-cities" class="map-ba top-cities padding-top-100px padding-bottom-70px background-grey-1">
    -->
    <div class="container">
        <div class="section-title section-title-center">
            <h1 class="title"><span>@lang('trs.our_services')</span></h1>
{{--            <span class="section-title-des">Lorem Ipsum Dolor Sit Amet, Consectetur Adipisicing Elitdunt</span>--}}
        </div>
        <div class="row">
            @foreach($posts as $post)
                <div class="col-md col-sm-12 ">
                    <h3><i class="fa icon-round-ba background-pink"></i>
                        <span class="text-medium text-uppercase align-middle">{!! $post[$post_title] !!}</span></h3>
                    <div class="thumbnail">
                        <img src="images/{{$post["post_image"]}}">
                    </div>
                    <i class="d-block text-up-small text-grey-2 margin-bottom-15px">{!! substr(strip_tags($post[$post_content]),0,65) !!}</i>
                    <a href="{{route('post',['id'=>$post["id"] ]) . ($lang!="de"? "?lang=".$lang : "")}}" class="btn background-cyan-0 text-dark padding-lr-10px text-small text-uppercase">
                        @lang('trs.read_more')
                    </a>
                </div>
            @endforeach


        </div>
    </div>
    <!-- // container -->
</section>

<!-- ======= Our Service  ======= -->