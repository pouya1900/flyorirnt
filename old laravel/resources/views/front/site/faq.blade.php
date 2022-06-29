@extends('layouts.front')
@section('content')

    @php
        $title_lang="title_".$lang;
        $content_lang="content_".$lang;
        $i=1;
    @endphp

    <div class="padding-tb-40px background-light-grey">
        <div class="container">
            <div class="row justify-content-md-center">

                <!--  content -->
                <div class="col-lg-8 col-md-8">
                    <div id="" role="tablist" aria-multiselectable="true">
                        <!-- faqs  -->

                        @foreach($faqs as $faq)
                            <div class="card">
                                <div class="card-header" role="tab" id="headingOne">
                                    <h5 class="mb-0">
                                        <a data-toggle="collapse"  href="#collapse-{{$i}}"
                                           aria-expanded="true" aria-controls="collapseOne"
                                           class="d-block text-dark text-up-small font-weight-700"><i
                                                    class="fa fa-info faq_sign"></i>
                                            {{$faq->$title_lang}}
                                        </a>
                                    </h5>
                                </div>

                                <div id="collapse-{{$i}}" class="collapse hide" role="tabpanel" aria-labelledby="headingOne">
                                    <div class="card-block padding-30px">
                                        {!! $faq->$content_lang !!}
                                    </div>
                                </div>
                            </div>
                            @php($i++)
                    @endforeach
                    <!-- //  faqs  -->


                    </div>
                </div>
                <!-- //  content col-8 -->


            </div>
        </div>
    </div>

@endsection