@extends('layouts.front')

@section('content')

    <div class="padding-tb-40px cip_page_container">
        <div class="container">

            <div class="">
                @include('front.cip.cip_header')
                @include('front.cip.cip_list')
            </div>

            @include('front.cip_passenger.cip_passenger_form')

        </div>

    </div>

@endsection

@section("script")

    <script>

        $(".DOB_date").caleran({

            locale:"{{$lang=="de" ? "de" : "en"}}",
            startEmpty: true,
            startOnMonday: true,
            maxDate: moment(),
            showFooter: false,
            autoCloseOnSelect:true,
            format:"DD.MM.YYYY",

            DOBCalendar: true,

        });



    </script>


@endsection