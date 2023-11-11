{{--details section--}}
<div class="collapse flight_details_container"
     id="flight_details{{(!isset($search_data) || isset($search_data["main_vendor"])) ? 0 : $search_data["render"]}}_{{$key}}">
    {{--depart details--}}

    <div class="details_content">

        <div class="details_header">
            <div class="row">

                <div class="col-10 col-md-6 details_title">
                    <span class="details_title_way">
                        @if ($item["DirectionInd"]==4)
                            @lang('trs.trip') 1
                        @else
                            @lang('trs.depart')
                        @endif
                    </span>
                    <span class="details_title_f_t">

                        {{($item["airports1"] ? $item["airports1"]["name"] : $item["depart_airport"]) . "-" . ($item["airports2"] ? $item["airports2"]["name"] : $item["arrival_airport"])}}
                    </span>

                </div>
                <div class="col-2 col-md-6 details_time">
                    <span>{{$total_time_hour."h"}}{{$total_time_min!=0 ? ":".$total_time_min."'" : ""}}</span>

                </div>

            </div>
        </div>

        <div class="details_body">

            <div class="details_body_head d-md-block d-none">
                <div class="row">

                    <div class="flight_item col-2">
                        <span>@lang('trs.airline')</span>
                    </div>
                    <div class="flight_item col-2">
                        <span>@lang('trs.flight_number')</span>
                    </div>
                    <div class="flight_item col-2">
                        <span>@lang('trs.flight_date')</span>
                    </div>
                    <div class="flight_item col-2">
                        <span>@lang('trs.enter_date')</span>
                    </div>
                    <div class="flight_item col-2">
                        <div class="row">
                            <div class="flight_item col">
                                <span>@lang('trs.duration')</span>
                            </div>

                            @if(!isset($search_data) || !$search_data["none_stop"])

                                <div class="flight_item col text-red">
                                    <span>@lang('trs.waiting')</span>
                                </div>
                            @endif

                        </div>
                    </div>
                    <div class="flight_item col-2">
                        <span>@lang('trs.bar')</span>
                    </div>
                    {{--<div class="flight_item col-2">--}}

                    {{--<div class="top_item f_t_time">--}}
                    {{--<span>--}}
                    {{--Bar--}}
                    {{--</span>--}}
                    {{--</div>--}}

                    {{--</div>--}}


                </div>
            </div>

            {{--flight leg--}}
            @foreach($item["legs"] as $leg)

                @if($leg["is_return"]==0)

                    @php

                        $depart1=$leg["leg_depart_time"];
                        $depart_time1=date('H:i',strtotime($depart1));
                        $depart_date1=date('d.m.Y',strtotime($depart1));
                        $depart_date1_day=\App\Services\MyHelperFunction::turn_day_of_week(date('w',strtotime($depart1)));

                        $arrival1=$leg["leg_arrival_time"];
                        $arrival_time1=date('H:i',strtotime($arrival1));
                        $arrival_date1=date('d.m.Y',strtotime($arrival1));
                        $arrival_date1_day=\App\Services\MyHelperFunction::turn_day_of_week(date('w',strtotime($arrival1)));

                        $total_time1=$leg["leg_time"];
                        $total_time_hour1=intval($total_time1/60);
                        $total_time_min1=intval($total_time1%60);

                        $total_waiting1=$leg["leg_waiting"];
                        $total_waiting_hour1=intval($total_waiting1/60);
                        $total_waiting_min1=intval($total_waiting1%60);


                    @endphp

                    <div class="depart_section">
                        <div class="row">

                            <div class="flight_item logo_container col-4 col-md-2">

                                <div class="logo_leg">
                                    <img
                                        src="images/{{ $leg["airlines"] ?  $leg["airlines"]["image"] : "AirlineLogo/default.png"}}"
                                        alt="{{$leg["airlines"] ? $leg["airlines"]["name"]  : ""}}">
                                </div>
                            </div>
                            <div class="col-4 flight_item d-md-none">
                                <div class="top_item f_t_time">
                        <span>
                            {{$leg["leg_flight_number"]}}

                        </span>
                                </div>
                                <div class="bot_item">
                        <span>
                         {{\App\Services\MyHelperFunction::turn_class($leg["cabin_class"])}}/{{$leg["cabin_class_code"]}}
                        </span>
                                </div>
                                @if ($leg["aircraft_type"])

                                    <div class="date_item">
                                    <span class="aircraft_name">
                                        {{$leg["aircraft_type"]}} <i class="fas fa-info-circle"></i>
                                        <span class="aircraft_description">
                                            {{$leg["aircraft_type_description"]}}
                                        </span>
                                    </span>

                                    </div>
                                @endif
                            </div>
                            <div class="col-4 d-md-none"></div>

                            <div class="flight_item col-md-2 d-md-block d-none">

                                <div class="top_item f_t_time">
                        <span>
                            {{$leg["leg_flight_number"]}}

                        </span>
                                </div>
                                <div class="bot_item">
                        <span>
                         {{\App\Services\MyHelperFunction::turn_class($leg["cabin_class"])}}/{{$leg["cabin_class_code"]}}
                        </span>
                                </div>
                                @if ($leg["aircraft_type"])

                                    <div class="date_item">
                                    <span class="aircraft_name">
                                        {{$leg["aircraft_type"]}} <i class="fas fa-info-circle"></i>
                                        <span class="aircraft_description">
                                            {{$leg["aircraft_type_description"]}}
                                        </span>
                                    </span>

                                    </div>
                                @endif
                            </div>

                            <div class="flight_item col col-md-2">

                                <div class="top_item f_t_time">
                        <span>
                           {{$depart_time1}}
                        </span>
                                </div>
                                <div class="bot_item">
                        <span>
                                {{$leg["airports1"] ? ($leg["airports1"][$city]!="" ? $leg["airports1"][$city] : $leg["airports1"]["city_en"]) : ""}} -
                        </span>
                                    <span>
                                {{$leg["airports1"] ? ($leg["airports1"]["name"]!="" ? $leg["airports1"]["name"] : $leg["leg_depart_airport"]) : $leg["leg_depart_airport"]}}
                            </span>
                                </div>
                                <div class="date_item">
                        <span>
                          {{$depart_date1_day}}  {{$depart_date1}}
                        </span>
                                </div>
                            </div>


                            {{--                                            sm display div--}}

                            <div class="flight_item col d-md-none sm_display_div_result_details">

                                <div class="flight_duration_md">
                        <span>
                                                     {{$total_time_hour1."h"}}{{$total_time_min1!=0 ? ":".$total_time_min1."'" : ""}}

                        </span>

                                </div>


                                <div class="flight_duration_md">
                        <span>
                            @if (!$leg["leg_bar_exist"])
                                <i> <img class="width-20px" src="images/icon/suitcase-solid.png"></i>
                            @elseif($leg["leg_bar"])
                                <i class="fas fa-suitcase bar_leg"></i>
                                {{$leg["leg_bar"]}}

                            @endif
                        </span>
                                </div>
                                <div class="flight_duration_md">
                                    @if ($leg["seats_remaining"])
                                        <div class="date_item">
                        <span class="{{intval($leg["seats_remaining"])<5 ? "text-red" :""}}">
                         <img src="images/icon/flight-seat.png"
                              class="flight_seat_image"> {{$leg["seats_remaining"]}} @lang('trs.seats_remains')
                        </span>
                                        </div>
                                    @endif
                                </div>

                                <div class="flight_duration_md">
 <span class="flight_duration_md_waiting">
                            {{$total_waiting1==0 ? "" : $total_waiting_hour1."h"}}{{$total_waiting1!=0 ? $total_waiting_min1!=0 ? ":".$total_waiting_min1."'" : "" :""}}
     {{$total_waiting1==0 ? "" : " waiting"}}
                        </span>
                                </div>

                            </div>

                            {{--                                            end sm display div--}}

                            <div class="flight_item col col-md-2">

                                <div class="top_item f_t_time">
                        <span>
                            {{$arrival_time1}}
                        </span>
                                </div>
                                <div class="bot_item">
                        <span>
                            {{$leg["airports2"] ? ($leg["airports2"][$city]!="" ? $leg["airports2"][$city] : $leg["airports2"]["city_en"]) : ""}} -
                        </span>
                                    <span>
                                {{$leg["airports2"] ? ($leg["airports2"]["name"]!="" ? $leg["airports2"]["name"] : $leg["leg_arrival_airport"]) : $leg["leg_arrival_airport"]}}
                            </span>
                                </div>
                                <div class="date_item">
                        <span>
                           {{$arrival_date1_day}} {{$arrival_date1}}
                        </span>
                                </div>
                            </div>

                            <div class="flight_item col-2 d-md-block d-none">
                                <div class="row">
                                    <div class="flight_item col">

                                        <div class="top_item time_detail">
                        <span>
                            {{$total_time_hour1."h"}}{{$total_time_min1!=0 ? ":".$total_time_min1."'" : ""}}

                        </span>
                                        </div>


                                    </div>
                                    {{--                                    @if(!$search_data["none_stop"])--}}

                                    <div class="flight_item col">

                                        <div class="top_item time_detail waiting_time">
                        <span>
                            {{$total_waiting1==0 ? "" : $total_waiting_hour1."h"}}{{$total_waiting1!=0 ? $total_waiting_min1!=0 ? ":".$total_waiting_min1."'" : "" :""}}

                        </span>
                                        </div>


                                    </div>
                                    {{--                                    @endif--}}

                                </div>
                            </div>

                            <div class="flight_item col-2 d-md-block d-none">

                                <div class="top_item">
                        <span>
                            @if (!$leg["leg_bar_exist"])
                                <i> <img class="width-20px" src="images/icon/suitcase-solid.png"></i>
                            @elseif($leg["leg_bar"])
                                <i class="fas fa-suitcase bar_leg"></i>
                                {{$leg["leg_bar"]}}

                            @endif                        </span>
                                </div>

                                @if ($leg["seats_remaining"])
                                    <div class="date_item">
                        <span class="{{intval($leg["seats_remaining"])<5 ? "text-red" :""}}">
                         <img src="images/icon/flight-seat.png"
                              class="flight_seat_image"> {{$leg["seats_remaining"]}} @lang('trs.seats_remains')
                        </span>
                                    </div>
                                @endif


                            </div>


                        </div>
                    </div>
                @endif
            @endforeach
            {{--// flight leg--}}


        </div>

    </div>

    {{--//depart details--}}


    {{--return details--}}
    @if($item["DirectionInd"]==2)
        <div class="details_content">

            <div class="details_header">
                <div class="row">

                    <div class="col-10 col-md-6 details_title">
                        <span class="details_title_way">@lang('trs.return')</span>
                        <span class="details_title_f_t">
                            {{($item["airports3"] ? $item["airports3"]["name"] : $item["return_depart_airport"]) . "-" . ($item["airports4"] ? $item["airports4"]["name"] : $item["return_arrival_airport"])}}

                        </span>

                    </div>
                    <div class="col-2 col-md-6 details_time text-right">
                        <span>{{$return_total_time_hour."h:".$return_total_time_min."'"}}</span>

                    </div>

                </div>
            </div>

            <div class="details_body">
                <div class="details_body_head d-md-block d-none">
                    <div class="row">

                        <div class="flight_item col-2">
                            <span>@lang('trs.airline')</span>
                        </div>
                        <div class="flight_item col-2">
                            <span>@lang('trs.flight_number')</span>
                        </div>
                        <div class="flight_item col-2">
                            <span>@lang('trs.flight_date')</span>
                        </div>
                        <div class="flight_item col-2">
                            <span>@lang('trs.enter_date')</span>
                        </div>
                        <div class="flight_item col-2">
                            <div class="row">
                                <div class="flight_item col">
                                    <span>@lang('trs.duration')</span>
                                </div>

                                @if(!isset($search_data) || !$search_data["none_stop"])

                                    <div class="flight_item col text-red">
                                        <span>@lang('trs.waiting')</span>
                                    </div>
                                @endif

                            </div>
                        </div>
                        <div class="flight_item col-2">
                            <span>@lang('trs.bar')</span>
                        </div>
                        {{--<div class="flight_item col-2">--}}

                        {{--<div class="top_item f_t_time">--}}
                        {{--<span>--}}
                        {{--Bar--}}
                        {{--</span>--}}
                        {{--</div>--}}

                        {{--</div>--}}


                    </div>
                </div>

                {{--flight leg--}}

                @foreach($item["legs"] as $leg)

                    @if($leg["is_return"]==1)

                        @php

                            $depart1=$leg["leg_depart_time"];
                            $depart_time1=date('H:i',strtotime($depart1));
                            $depart_date1=date('d.m.Y',strtotime($depart1));
                            $depart_date1_day=\App\Services\MyHelperFunction::turn_day_of_week(date('w',strtotime($depart1)));

                            $arrival1=$leg["leg_arrival_time"];
                            $arrival_time1=date('H:i',strtotime($arrival1));
                            $arrival_date1=date('d.m.Y',strtotime($arrival1));
                            $arrival_date1_day=\App\Services\MyHelperFunction::turn_day_of_week(date('w',strtotime($arrival1)));

                            $total_time1=$leg["leg_time"];
                            $total_time_hour1=intval($total_time1/60);
                            $total_time_min1=intval($total_time1%60);

                            $total_waiting1=$leg["leg_waiting"];
                            $total_waiting_hour1=intval($total_waiting1/60);
                            $total_waiting_min1=intval($total_waiting1%60);


                        @endphp

                        <div class="depart_section">
                            <div class="row">

                                <div class="flight_item logo_container col-4 col-md-2">

                                    <div class="logo_leg">
                                        <img
                                            src="images/{{$leg["airlines"] ? $leg["airlines"]["image"]  : "AirlineLogo/default.png"}}"
                                            alt="{{$leg["airlines"] ? $leg["airlines"]["name"]  : ""}}">
                                    </div>
                                </div>
                                <div class="col-4 flight_item d-md-none">
                                    <div class="top_item f_t_time">
                        <span>
                            {{$leg["leg_flight_number"]}}
                        </span>
                                    </div>
                                    <div class="bot_item">
                        <span>
                         {{\App\Services\MyHelperFunction::turn_class($leg["cabin_class"])}}/{{$leg["cabin_class_code"]}}
                        </span>
                                    </div>
                                    @if ($leg["aircraft_type"])
                                        <div class="date_item">
                                        <span class="aircraft_name">
                                            {{$leg["aircraft_type"]}} <i class="fas fa-info-circle"></i>
                                       <span class="aircraft_description">
                                            {{$leg["aircraft_type_description"]}}
                                        </span>
                                        </span>

                                        </div>

                                    @endif
                                </div>
                                <div class="col-4 d-md-none"></div>

                                <div class="flight_item col-2 d-md-block d-none">

                                    <div class="top_item f_t_time">
                        <span>
                            {{$leg["leg_flight_number"]}}
                        </span>
                                    </div>
                                    <div class="bot_item">
                        <span>
                         {{\App\Services\MyHelperFunction::turn_class($leg["cabin_class"])}}/{{$leg["cabin_class_code"]}}
                        </span>
                                    </div>
                                    @if ($leg["aircraft_type"])
                                        <div class="date_item">
                                        <span class="aircraft_name">
                                            {{$leg["aircraft_type"]}} <i class="fas fa-info-circle"></i>
                                       <span class="aircraft_description">
                                            {{$leg["aircraft_type_description"]}}
                                        </span>
                                        </span>

                                        </div>

                                    @endif
                                </div>

                                <div class="flight_item col col-md-2">

                                    <div class="top_item f_t_time">
                        <span>
                           {{$depart_time1}}
                        </span>
                                    </div>
                                    <div class="bot_item">
                        <span>
                                {{$leg["airports1"] ? ($leg["airports1"][$city]!="" ? $leg["airports1"][$city] : $leg["airports1"]["city_en"]) : ""}} -
                        </span>
                                        <span>
                                {{$leg["airports1"] ? ($leg["airports1"]["name"]!="" ? $leg["airports1"]["name"] : $leg["leg_depart_airport"]) : $leg["leg_depart_airport"]}}
                            </span>
                                    </div>
                                    <div class="date_item">
                        <span>
                          {{$depart_date1_day}}  {{$depart_date1}}
                        </span>
                                    </div>
                                </div>

                                {{--                                            sm display div--}}

                                <div class="flight_item col d-md-none sm_display_div_result_details">

                                    <div class="flight_duration_md">
                        <span>
                                                     {{$total_time_hour1."h"}}{{$total_time_min1!=0 ? ":".$total_time_min1."'" : ""}}

                        </span>

                                    </div>


                                    <div class="flight_duration_md">
                        <span>
                            @if (!$leg["leg_bar_exist"])
                                <i> <img class="width-20px" src="images/icon/suitcase-solid.png"></i>
                            @elseif($leg["leg_bar"])
                                <i class="fas fa-suitcase bar_leg"></i>
                                {{$leg["leg_bar"]}}

                            @endif                        </span>
                                    </div>

                                    <div class="flight_duration_md">
                                        @if ($leg["seats_remaining"])
                                            <div class="date_item">
                        <span class="{{intval($leg["seats_remaining"])<5 ? "text-red" :""}}">
                         <img src="images/icon/flight-seat.png"
                              class="flight_seat_image"> {{$leg["seats_remaining"]}} @lang('trs.seats_remains')
                        </span>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="flight_duration_md_waiting">
 <span>
                            {{$total_waiting1==0 ? "" : $total_waiting_hour1."h"}}{{$total_waiting1!=0 ? $total_waiting_min1!=0 ? ":".$total_waiting_min1."'" : "" :""}}

     {{$total_waiting1==0 ? "" : " waiting"}}
                        </span>
                                    </div>

                                </div>

                                {{--                                            end sm display div--}}

                                <div class="flight_item col col-md-2">

                                    <div class="top_item f_t_time">
                        <span>
                            {{$arrival_time1}}
                        </span>
                                    </div>
                                    <div class="bot_item">
                        <span>
                            {{$leg["airports2"] ? ($leg["airports2"][$city]!="" ? $leg["airports2"][$city] : $leg["airports2"]["city_en"]) : ""}} -
                        </span>
                                        <span>
                                {{$leg["airports2"] ? ($leg["airports2"]["name"]!="" ? $leg["airports2"]["name"] : $leg["leg_arrival_airport"] ) : $leg["leg_arrival_airport"]}}
                            </span>
                                    </div>
                                    <div class="date_item">
                        <span>
                           {{$arrival_date1_day}} {{$arrival_date1}}
                        </span>
                                    </div>
                                </div>

                                <div class="flight_item col-2 d-md-block d-none">
                                    <div class="row">
                                        <div class="flight_item col">

                                            <div class="top_item time_detail">
                        <span>
                            {{$total_time_hour1."h"}}{{$total_time_min1!=0 ? ":".$total_time_min1."'" : ""}}

                        </span>
                                            </div>


                                        </div>
                                        {{--                                        @if(!$search_data["none_stop"])--}}

                                        <div class="flight_item col">

                                            <div class="top_item time_detail waiting_time">
                        <span>
                            {{$total_waiting1==0 ? "" : $total_waiting_hour1."h"}}{{$total_waiting1!=0 ? $total_waiting_min1!=0 ? ":".$total_waiting_min1."'" : "" :""}}
                        </span>
                                            </div>


                                        </div>
                                        {{--                                        @endif--}}

                                    </div>
                                </div>

                                <div class="flight_item col-2 d-md-block d-none">

                                    <div class="top_item">
                        <span>
                            @if (!$leg["leg_bar_exist"])
                                <i> <img class="width-20px" src="images/icon/suitcase-solid.png"></i>
                            @elseif($leg["leg_bar"])
                                <i class="fas fa-suitcase bar_leg"></i>
                                {{$leg["leg_bar"]}}

                            @endif                        </span>
                                    </div>
                                    @if ($leg["seats_remaining"])
                                        <div class="date_item">
                        <span class="{{intval($leg["seats_remaining"])<5 ? "text-red" :""}}">
                         <img src="images/icon/flight-seat.png"
                              class="flight_seat_image"> {{$leg["seats_remaining"]}} @lang('trs.seats_remains')
                        </span>
                                        </div>
                                    @endif

                                </div>


                            </div>
                        </div>
                    @endif
                @endforeach


                {{--// flight leg--}}


            </div>

        </div>
    @endif
    {{--// return details--}}


    @if($item["DirectionInd"]==4)
        @foreach($item->multi_flights as $key=>$multi)
            <div class="details_content">

                <div class="details_header">
                    <div class="row">

                        <div class="col-10 col-md-6 details_title">
                            <span class="details_title_way">@lang('trs.trip') {{$key+2}}</span>
                            <span class="details_title_f_t">
                            {{($multi["airports1"] ? $multi["airports1"]["name"] : $multi["depart_airport"]) . "-" . ($multi["airports2"] ? $multi["airports2"]["name"] : $multi["arrival_airport"])}}

                        </span>

                        </div>
                        <div class="col-2 col-md-6 details_time text-right">
                            <span>{{$return_total_time_hour."h:".$return_total_time_min."'"}}</span>

                        </div>

                    </div>
                </div>

                <div class="details_body">
                    <div class="details_body_head d-md-block d-none">
                        <div class="row">

                            <div class="flight_item col-2">
                                <span>@lang('trs.airline')</span>
                            </div>
                            <div class="flight_item col-2">
                                <span>@lang('trs.flight_number')</span>
                            </div>
                            <div class="flight_item col-2">
                                <span>@lang('trs.flight_date')</span>
                            </div>
                            <div class="flight_item col-2">
                                <span>@lang('trs.enter_date')</span>
                            </div>
                            <div class="flight_item col-2">
                                <div class="row">
                                    <div class="flight_item col">
                                        <span>@lang('trs.duration')</span>
                                    </div>

                                    @if(!isset($search_data) || !$search_data["none_stop"])

                                        <div class="flight_item col text-red">
                                            <span>@lang('trs.waiting')</span>
                                        </div>
                                    @endif

                                </div>
                            </div>
                            <div class="flight_item col-2">
                                <span>@lang('trs.bar')</span>
                            </div>
                            {{--<div class="flight_item col-2">--}}

                            {{--<div class="top_item f_t_time">--}}
                            {{--<span>--}}
                            {{--Bar--}}
                            {{--</span>--}}
                            {{--</div>--}}

                            {{--</div>--}}


                        </div>
                    </div>

                    {{--flight leg--}}

                    @foreach($multi["legs"] as $leg)

                        @if($leg["is_return"]==0)

                            @php

                                $depart1=$leg["leg_depart_time"];
                                $depart_time1=date('H:i',strtotime($depart1));
                                $depart_date1=date('d.m.Y',strtotime($depart1));
                                $depart_date1_day=\App\Services\MyHelperFunction::turn_day_of_week(date('w',strtotime($depart1)));

                                $arrival1=$leg["leg_arrival_time"];
                                $arrival_time1=date('H:i',strtotime($arrival1));
                                $arrival_date1=date('d.m.Y',strtotime($arrival1));
                                $arrival_date1_day=\App\Services\MyHelperFunction::turn_day_of_week(date('w',strtotime($arrival1)));

                                $total_time1=$leg["leg_time"];
                                $total_time_hour1=intval($total_time1/60);
                                $total_time_min1=intval($total_time1%60);

                                $total_waiting1=$leg["leg_waiting"];
                                $total_waiting_hour1=intval($total_waiting1/60);
                                $total_waiting_min1=intval($total_waiting1%60);


                            @endphp

                            <div class="depart_section">
                                <div class="row">

                                    <div class="flight_item logo_container col-4 col-md-2">

                                        <div class="logo_leg">
                                            <img
                                                src="images/{{$leg["airlines"] ? $leg["airlines"]["image"]  : "AirlineLogo/default.png"}}"
                                                alt="{{$leg["airlines"] ? $leg["airlines"]["name"]  : ""}}">
                                        </div>
                                    </div>
                                    <div class="col-4 flight_item d-md-none">
                                        <div class="top_item f_t_time">
                        <span>
                            {{$leg["leg_flight_number"]}}
                        </span>
                                        </div>
                                        <div class="bot_item">
                        <span>
                         {{\App\Services\MyHelperFunction::turn_class($leg["cabin_class"])}}/{{$leg["cabin_class_code"]}}
                        </span>
                                        </div>
                                        @if ($leg["aircraft_type"])
                                            <div class="date_item">
                                        <span class="aircraft_name">
                                            {{$leg["aircraft_type"]}} <i class="fas fa-info-circle"></i>
                                       <span class="aircraft_description">
                                            {{$leg["aircraft_type_description"]}}
                                        </span>
                                        </span>

                                            </div>

                                        @endif
                                    </div>
                                    <div class="col-4 d-md-none"></div>

                                    <div class="flight_item col-2 d-md-block d-none">

                                        <div class="top_item f_t_time">
                        <span>
                            {{$leg["leg_flight_number"]}}
                        </span>
                                        </div>
                                        <div class="bot_item">
                        <span>
                         {{\App\Services\MyHelperFunction::turn_class($leg["cabin_class"])}}/{{$leg["cabin_class_code"]}}
                        </span>
                                        </div>
                                        @if ($leg["aircraft_type"])
                                            <div class="date_item">
                                        <span class="aircraft_name">
                                            {{$leg["aircraft_type"]}} <i class="fas fa-info-circle"></i>
                                       <span class="aircraft_description">
                                            {{$leg["aircraft_type_description"]}}
                                        </span>
                                        </span>

                                            </div>

                                        @endif
                                    </div>

                                    <div class="flight_item col col-md-2">

                                        <div class="top_item f_t_time">
                        <span>
                           {{$depart_time1}}
                        </span>
                                        </div>
                                        <div class="bot_item">
                        <span>
                                {{$leg["airports1"] ? ($leg["airports1"][$city]!="" ? $leg["airports1"][$city] : $leg["airports1"]["city_en"]) : ""}} -
                        </span>
                                            <span>
                                {{$leg["airports1"] ? ($leg["airports1"]["name"]!="" ? $leg["airports1"]["name"] : $leg["leg_depart_airport"]) : $leg["leg_depart_airport"]}}
                            </span>
                                        </div>
                                        <div class="date_item">
                        <span>
                          {{$depart_date1_day}}  {{$depart_date1}}
                        </span>
                                        </div>
                                    </div>

                                    {{--                                            sm display div--}}

                                    <div class="flight_item col d-md-none sm_display_div_result_details">

                                        <div class="flight_duration_md">
                        <span>
                                                     {{$total_time_hour1."h"}}{{$total_time_min1!=0 ? ":".$total_time_min1."'" : ""}}

                        </span>

                                        </div>


                                        <div class="flight_duration_md">
                        <span>
                            @if (!$leg["leg_bar_exist"])
                                <i> <img class="width-20px" src="images/icon/suitcase-solid.png"></i>
                            @elseif($leg["leg_bar"])
                                <i class="fas fa-suitcase bar_leg"></i>
                                {{$leg["leg_bar"]}}

                            @endif                        </span>
                                        </div>

                                        <div class="flight_duration_md">
                                            @if ($leg["seats_remaining"])
                                                <div class="date_item">
                        <span class="{{intval($leg["seats_remaining"])<5 ? "text-red" :""}}">
                         <img src="images/icon/flight-seat.png"
                              class="flight_seat_image"> {{$leg["seats_remaining"]}} @lang('trs.seats_remains')
                        </span>
                                                </div>
                                            @endif
                                        </div>

                                        <div class="flight_duration_md_waiting">
 <span>
                            {{$total_waiting1==0 ? "" : $total_waiting_hour1."h"}}{{$total_waiting1!=0 ? $total_waiting_min1!=0 ? ":".$total_waiting_min1."'" : "" :""}}

     {{$total_waiting1==0 ? "" : " waiting"}}
                        </span>
                                        </div>

                                    </div>

                                    {{--                                            end sm display div--}}

                                    <div class="flight_item col col-md-2">

                                        <div class="top_item f_t_time">
                        <span>
                            {{$arrival_time1}}
                        </span>
                                        </div>
                                        <div class="bot_item">
                        <span>
                            {{$leg["airports2"] ? ($leg["airports2"][$city]!="" ? $leg["airports2"][$city] : $leg["airports2"]["city_en"]) : ""}} -
                        </span>
                                            <span>
                                {{$leg["airports2"] ? ($leg["airports2"]["name"]!="" ? $leg["airports2"]["name"] : $leg["leg_arrival_airport"] ) : $leg["leg_arrival_airport"]}}
                            </span>
                                        </div>
                                        <div class="date_item">
                        <span>
                           {{$arrival_date1_day}} {{$arrival_date1}}
                        </span>
                                        </div>
                                    </div>

                                    <div class="flight_item col-2 d-md-block d-none">
                                        <div class="row">
                                            <div class="flight_item col">

                                                <div class="top_item time_detail">
                        <span>
                            {{$total_time_hour1."h"}}{{$total_time_min1!=0 ? ":".$total_time_min1."'" : ""}}

                        </span>
                                                </div>


                                            </div>
                                            {{--                                        @if(!$search_data["none_stop"])--}}

                                            <div class="flight_item col">

                                                <div class="top_item time_detail waiting_time">
                        <span>
                            {{$total_waiting1==0 ? "" : $total_waiting_hour1."h"}}{{$total_waiting1!=0 ? $total_waiting_min1!=0 ? ":".$total_waiting_min1."'" : "" :""}}
                        </span>
                                                </div>


                                            </div>
                                            {{--                                        @endif--}}

                                        </div>
                                    </div>

                                    <div class="flight_item col-2 d-md-block d-none">

                                        <div class="top_item">
                        <span>
                            @if (!$leg["leg_bar_exist"])
                                <i> <img class="width-20px" src="images/icon/suitcase-solid.png"></i>
                            @elseif($leg["leg_bar"])
                                <i class="fas fa-suitcase bar_leg"></i>
                                {{$leg["leg_bar"]}}

                            @endif                        </span>
                                        </div>
                                        @if ($leg["seats_remaining"])
                                            <div class="date_item">
                        <span class="{{intval($leg["seats_remaining"])<5 ? "text-red" :""}}">
                         <img src="images/icon/flight-seat.png"
                              class="flight_seat_image"> {{$leg["seats_remaining"]}} @lang('trs.seats_remains')
                        </span>
                                            </div>
                                        @endif

                                    </div>


                                </div>
                            </div>
                        @endif
                    @endforeach


                    {{--// flight leg--}}


                </div>

            </div>
        @endforeach
    @endif

</div>
{{-- //details section--}}
