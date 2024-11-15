@extends('layouts.pure')
@section('content')

    <div class="confirm_register_page">
        <div class="row justify-content-md-center">

            <div class="col-lg-5">

                <div class="text-center margin-bottom-30px">
                    <a href="{{route('home'). ($lang!="de"? "?lang=".$lang : "")}}"><img src="images/{{$setting->logo}}"
                                                                                         alt=""></a>
                </div>

                <div class="register_confirm">


                    <div class="register_confirm_header">
                        <span>@lang('trs.canceled')</span>
                    </div>


                    <div class="register_confirm_body">
                        <p>@lang('trs.cancel_payment_message')
                        </p>
                    </div>

                    @if ($research_data)
                        <div class="register_confirm_footer">
                            <a href="{{$research_data["link"]!="" ? $research_data["link"] : route('home'). ($lang!="de"? "?lang=".$lang : "")}}"
                               id="refresh_search" class="refresh_btn" data-origin="{{$research_data["origin"]}}"
                               data-destination="{{$research_data["destination"]}}"
                               data-depart_date="{{$research_data["depart_date"]}}"
                               data-return_date="{{$research_data["return_date"]}}">@lang('trs.refresh_search')</a>
                        </div>
                    @endif


                </div>

            </div>

        </div>
    </div>
@endsection
