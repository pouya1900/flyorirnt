@extends('layouts.pure')
@section('content')

    <div class="confirm_register_page">
        <div class="row justify-content-md-center">

            <div class="col-lg-5">

                <div class="text-center margin-bottom-30px">
                    <a href="{{route('home'). ($lang!="de"? "?lang=".$lang : "")}}"><img src="images/{{$setting->logo}}" alt=""></a>
                </div>

                <div class="register_confirm">

                    @if ($log)
                        <div class="register_confirm_header">
                            <span>@lang('trs.success')</span>
                        </div>

                    @else

                        <div class="register_confirm_header">
                            <span>@lang('trs.Woops')</span>
                        </div>
                    @endif


                    <div class="register_confirm_body">
                        <p>{{$message}}
                        </p>
                    </div>


                    <div class="register_confirm_footer">


                        <a href="{{route('login')}}"  class="login_link_register_page">
                            @lang('trs.login')
                        </a>
                    </div>



                </div>

            </div>

        </div>
    </div>
@endsection