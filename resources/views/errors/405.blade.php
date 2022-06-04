@extends('layouts.pure')
@section('content')

    <div class="confirm_register_page">
        <div class="row justify-content-md-center">

            <div class="col-lg-5">

                <div class="text-center margin-bottom-30px">
                    <a href="{{route('home'). ($lang!="de"? "?lang=".$lang : "")}}"><img src="images/{{$setting->logo}}" alt=""></a>
                </div>

                <div class="register_confirm">

                    <div class="register_confirm_header">
                        <span>@lang('trs.405_error')</span>
                    </div>



                    <div class="register_confirm_body">
                        <p>@lang('trs.bad_method')
                        </p>
                    </div>


                    <div class="register_confirm_footer">


                        <a href="{{route('home'). ($lang!="de"? "?lang=".$lang : "")}}"  class="login_link_register_page">
                            @lang('trs.home')
                        </a>
                    </div>



                </div>

            </div>

        </div>
    </div>
@endsection