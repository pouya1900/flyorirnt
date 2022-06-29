@extends('layouts.front')
@section('content')



    <div class="padding-tb-40px flight_page_container ">

        <div class="container">
            <div class="flight_post_body_wide">
                <div class="flights_container">
                    @include('front.partials.flight')
                </div>
            </div>
            @include('front.passenger.passenger_form')
        </div>


    </div>

    {{--rules modal container--}}
    <div id="rules_modal_container"></div>
    @if(!$validate)
        @include('front.partials.validate_error')
        @include('front.partials.search_loader')
    @endif

@endsection

@section('script')
    @include('front.passenger.script')
    @if (!\Illuminate\Support\Facades\Auth::check() && $validate)

        <input type="hidden" name="route" value="passengers">
        <script>

            $("#main_login").modal("show");

        </script>
    @endif
@endsection