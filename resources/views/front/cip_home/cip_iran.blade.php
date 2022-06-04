@extends('layouts.front')
@section('content')

    @include('front.cip_home.search_filter')
    @php($slider='front.slider_cip.slider_cip_'.$lang)
    @include($slider)
    @include('front.cip_home.cip_description')

@endsection


@section('script')

    <script type="text/javascript">

        var date1 = new Date();
        var date2 = new Date();

        @if($cip_max_time_day)
        date2.setDate(date1.getDate() + {{$cip_max_time_day}});
        @else
            date2 = new Date(Date.parse("{{$cip_max_time}}"));
        @endif

        var userLanguage1 = "{{$lang=="de" ? "de" : "en"}}";

        $("#date1").caleran({

            locale: userLanguage1,
            format: "DD.MM.YYYY",
            singleDate: true,
            minDate: date1,
            maxDate: date2,
            startEmpty: $("#date1").val() === "",
            autoCloseOnSelect: true
        });
    </script>

@endsection