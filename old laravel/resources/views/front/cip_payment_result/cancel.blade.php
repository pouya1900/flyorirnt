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
                            <span>@lang('trs.canceled')</span>
                        </div>



                    <div class="register_confirm_body">
                        <p>cip canceled
                        </p>
                    </div>

                    <div class="register_confirm_footer">

                        <a  href="{{route('cip_iran')}}">@lang('trs.search_page')</a>




                    </div>



                </div>

            </div>

        </div>
    </div>
@endsection