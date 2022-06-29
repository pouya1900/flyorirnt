@php

    //$count=sizeof($flight);
        $city="city_".$lang;

if (!isset($start)) $start=0;

@endphp
<div class="passenger_list_container">

    @if ($flight["DirectionInd"]==2)
        <div class="passenger_list_header">
            <span>@lang('trs.depart')</span>
        </div>
    @endif
    <div class="flight-post">

        <table class="table table-striped text-center">
            <thead>
            <tr>
                <th scope="col">@lang('trs.airline')</th>
                <th scope="col">@lang('trs.flight_number')</th>
                <th scope="col">@lang('trs.flight_date')</th>
                <th scope="col">@lang('trs.enter_date')</th>
                <th scope="col">@lang('trs.waiting')</th>
                <th scope="col">@lang('trs.bar')</th>
            </tr>
            </thead>
            <tbody>
            @if(isset($flight) && !empty($flight))

                @php

                    $item=$flight;
                    $key=0;
                        $depart=$item["depart_time"];
                        $depart_time=date('H:i',strtotime($depart));
                        $depart_date=date('d.m.Y',strtotime($depart));

                        $arrival=$item["arrival_time"];
                        $arrival_time=date('H:i',strtotime($arrival));
                        $arrival_date=date('d.m.Y',strtotime($arrival));

                        $total_time=$item["total_time"];
                        $total_time_hour=intval($total_time/60);
                        $total_time_min=intval($total_time%60);

                        $total_waiting=$item["total_waiting"];
                        $total_waiting_hour=intval($total_waiting/60);
                        $total_waiting_min=intval($total_waiting%60);

                        if ($depart_time>0 && $depart_time<8) $depart_range=0;
                        else if ($depart_time>=8 && $depart_time<12) $depart_range=1;
                        else if ($depart_time>=12 && $depart_time<=18) $depart_range=2;
                        else if ($depart_time>18 && $depart_time<=24) $depart_range=3;


                        if ($item["DirectionInd"]==2) {
                        $return_depart=$item["return_depart_time"];
                        $return_depart_time=date('H:i',strtotime($return_depart));
                        $return_depart_date=date('d.m.Y',strtotime($return_depart));

                        $return_arrival=$item["return_arrival_time"];
                        $return_arrival_time=date('H:i',strtotime($return_arrival));
                        $return_arrival_date=date('d.m.Y',strtotime($return_arrival));

                        $return_total_time=$item["return_total_time"];
                        $return_total_time_hour=intval($return_total_time/60);
                        $return_total_time_min=intval($return_total_time%60);

                        $return_total_waiting=$item["return_total_waiting"];
                        $return_total_waiting_hour=intval($return_total_waiting/60);
                        $return_total_waiting_min=intval($return_total_waiting%60);

                        if ($return_depart_time>0 && $return_depart_time<8) $return_depart_range=0;
                        else if ($return_depart_time>=8 && $return_depart_time<12) $return_depart_range=1;
                        else if ($return_depart_time>=12 && $return_depart_time<=18) $return_depart_range=2;
                        else if ($return_depart_time>18 && $return_depart_time<=24) $return_depart_range=3;
                        }




                @endphp


                @foreach($item["legs"] as $leg)

                    @if($leg["is_return"]==0)

                        @php


                            $depart1=$leg["leg_depart_time"];
                            $depart_time1=date('H:i',strtotime($depart1));
                            $depart_date1=date('d.m.Y',strtotime($depart1));
                            $arrival1=$leg["leg_arrival_time"];
                            $arrival_time1=date('H:i',strtotime($arrival1));
                            $arrival_date1=date('d.m.Y',strtotime($arrival1));

                            $total_time1=$leg["leg_time"];
                            $total_time_hour1=intval($total_time1/60);
                            $total_time_min1=intval($total_time1%60);

                            $total_waiting1=$leg["leg_waiting"];
                            $total_waiting_hour1=intval($total_waiting1/60);
                            $total_waiting_min1=intval($total_waiting1%60);


                        @endphp

                        <tr>
                            <td>
                                <div class="flight_item">

                                    <div class="logo_leg">
                                        <img width="150px" src="images/{{$leg["airlines"]["image"]}}">
                                    </div>
                                </div>

                            </td>
                            <td>
                                <div class="flight_item">

                                    <div class="top_item f_t_time">
                        <span>
                            {{substr($leg["leg_flight_number"],0,2)!=$leg["leg_airline_code"] ? $leg["leg_airline_code"] : "" }}{{$leg["leg_flight_number"]}}
                        </span>
                                    </div>
                                    <div class="bot_item">
                        <span>
                         {{\App\Services\MyHelperFunction::turn_class($leg["cabin_class"])}}
                        </span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="flight_item">

                                    <div class="top_item f_t_time">
                        <span>
                           {{$depart_time1}}
                        </span>
                                    </div>
                                    <div class="bot_item">
                        <span>
                            {{$leg["airports1"][$city]!="" ? $leg["airports1"][$city] : $leg["airports1"]["city_en"]}}
                        </span>
                                        <span>
                                {{$leg["airports1"]["name"]!="" ? $leg["airports1"]["name"] : $leg["leg_depart_airport"]}}
                            </span>
                                    </div>
                                    <div class="bot_item">
                        <span class="date_latin_font">
                            {{$depart_date1}}
                        </span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="flight_item">

                                    <div class="top_item f_t_time">
                        <span>
                            {{$arrival_time1}}
                        </span>
                                    </div>
                                    <div class="bot_item">
                        <span>
                            {{$leg["airports2"][$city]!="" ? $leg["airports2"][$city] : $leg["airports2"]["city_en"]}}
                        </span>
                                        <span>
                                {{$leg["airports2"]["name"]!="" ? $leg["airports2"]["name"] : $leg["leg_arrival_airport"]}}
                            </span>
                                    </div>
                                    <div class="bot_item">
                        <span class="date_latin_font">
                            {{$arrival_date1}}
                        </span>
                                    </div>
                                </div>

                            </td>
                            <td>
                                <div class="flight_item">

                                    <div class="top_item time_detail waiting_time">
                        <span>
                            {{$total_waiting1==0 ? "" : $total_waiting_hour1."h"}}{{$total_waiting1!=0 ? $total_waiting_min1!=0 ? ":".$total_waiting_min1."'" : "" :""}}

                        </span>
                                    </div>

                                </div>
                            </td>
                            <td>
                                <div class="flight_item">

                                    <div class="top_item">
                        <span>
                            {{$leg["leg_bar"]}}
                        </span>
                                    </div>

                                </div>
                            </td>

                        </tr>

                    @endif
                @endforeach

            @endif

            </tbody>
        </table>


    </div>


</div>

@if ($flight["DirectionInd"]==2)
<div class="passenger_list_container">

        <div class="passenger_list_header">
            <span>@lang('trs.return')</span>
        </div>

    <div class="flight-post">

        <table class="table table-striped text-center">
            <thead>
            <tr>
                <th scope="col">@lang('trs.airline')</th>
                <th scope="col">@lang('trs.flight_number')</th>
                <th scope="col">@lang('trs.flight_date')</th>
                <th scope="col">@lang('trs.enter_date')</th>
                <th scope="col">@lang('trs.waiting')</th>
                <th scope="col">@lang('trs.bar')</th>
            </tr>
            </thead>
            <tbody>
            @if(isset($flight) && !empty($flight))

                @php

                    $item=$flight;
                    $key=0;
                        $depart=$item["depart_time"];
                        $depart_time=date('H:i',strtotime($depart));
                        $depart_date=date('d.m.Y',strtotime($depart));

                        $arrival=$item["arrival_time"];
                        $arrival_time=date('H:i',strtotime($arrival));
                        $arrival_date=date('d.m.Y',strtotime($arrival));

                        $total_time=$item["total_time"];
                        $total_time_hour=intval($total_time/60);
                        $total_time_min=intval($total_time%60);

                        $total_waiting=$item["total_waiting"];
                        $total_waiting_hour=intval($total_waiting/60);
                        $total_waiting_min=intval($total_waiting%60);

                        if ($depart_time>0 && $depart_time<8) $depart_range=0;
                        else if ($depart_time>=8 && $depart_time<12) $depart_range=1;
                        else if ($depart_time>=12 && $depart_time<=18) $depart_range=2;
                        else if ($depart_time>18 && $depart_time<=24) $depart_range=3;


                        if ($item["DirectionInd"]==2) {
                        $return_depart=$item["return_depart_time"];
                        $return_depart_time=date('H:i',strtotime($return_depart));
                        $return_depart_date=date('d.m.Y',strtotime($return_depart));

                        $return_arrival=$item["return_arrival_time"];
                        $return_arrival_time=date('H:i',strtotime($return_arrival));
                        $return_arrival_date=date('d.m.Y',strtotime($return_arrival));

                        $return_total_time=$item["return_total_time"];
                        $return_total_time_hour=intval($return_total_time/60);
                        $return_total_time_min=intval($return_total_time%60);

                        $return_total_waiting=$item["return_total_waiting"];
                        $return_total_waiting_hour=intval($return_total_waiting/60);
                        $return_total_waiting_min=intval($return_total_waiting%60);

                        if ($return_depart_time>0 && $return_depart_time<8) $return_depart_range=0;
                        else if ($return_depart_time>=8 && $return_depart_time<12) $return_depart_range=1;
                        else if ($return_depart_time>=12 && $return_depart_time<=18) $return_depart_range=2;
                        else if ($return_depart_time>18 && $return_depart_time<=24) $return_depart_range=3;
                        }




                @endphp


                @foreach($item["legs"] as $leg)

                    @if($leg["is_return"]==1)

                        @php


                            $depart1=$leg["leg_depart_time"];
                            $depart_time1=date('H:i',strtotime($depart1));
                            $depart_date1=date('d.m.Y',strtotime($depart1));
                            $arrival1=$leg["leg_arrival_time"];
                            $arrival_time1=date('H:i',strtotime($arrival1));
                            $arrival_date1=date('d.m.Y',strtotime($arrival1));

                            $total_time1=$leg["leg_time"];
                            $total_time_hour1=intval($total_time1/60);
                            $total_time_min1=intval($total_time1%60);

                            $total_waiting1=$leg["leg_waiting"];
                            $total_waiting_hour1=intval($total_waiting1/60);
                            $total_waiting_min1=intval($total_waiting1%60);


                        @endphp

                        <tr>
                            <td>
                                <div class="flight_item ">

                                    <div class="logo_leg">
                                        <img width="150px" src="images/{{$leg["airlines"]["image"]}}">
                                    </div>
                                </div>

                            </td>
                            <td>
                                <div class="flight_item">

                                    <div class="top_item f_t_time">
                        <span>
                            {{substr($leg["leg_flight_number"],0,2)!=$leg["leg_airline_code"] ? $leg["leg_airline_code"] : "" }}{{$leg["leg_flight_number"]}}
                        </span>
                                    </div>
                                    <div class="bot_item">
                        <span>
                         {{\App\Services\MyHelperFunction::turn_class($leg["cabin_class"])}}
                        </span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="flight_item">

                                    <div class="top_item f_t_time">
                        <span>
                           {{$depart_time1}}
                        </span>
                                    </div>
                                    <div class="bot_item">
                        <span>
                            {{$leg["airports1"][$city]!="" ? $leg["airports1"][$city] : $leg["airports1"]["city_en"]}}
                        </span>
                                        <span>
                                {{$leg["airports1"]["name"]!="" ? $leg["airports1"]["name"] : $leg["leg_depart_airport"]}}
                            </span>
                                    </div>
                                    <div class="bot_item">
                        <span class="date_latin_font">
                            {{$depart_date1}}
                        </span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="flight_item">

                                    <div class="top_item f_t_time">
                        <span>
                            {{$arrival_time1}}
                        </span>
                                    </div>
                                    <div class="bot_item">
                        <span>
                            {{$leg["airports2"][$city]!="" ? $leg["airports2"][$city] : $leg["airports2"]["city_en"]}}
                        </span>
                                        <span>
                                {{$leg["airports2"]["name"]!="" ? $leg["airports2"]["name"] : $leg["leg_arrival_airport"]}}
                            </span>
                                    </div>
                                    <div class="bot_item">
                        <span class="date_latin_font">
                            {{$arrival_date1}}
                        </span>
                                    </div>
                                </div>

                            </td>
                            <td>
                                <div class="flight_item">

                                    <div class="top_item time_detail waiting_time">
                        <span>
                            {{$total_waiting1==0 ? "" : $total_waiting_hour1."h"}}{{$total_waiting1!=0 ? $total_waiting_min1!=0 ? ":".$total_waiting_min1."'" : "" :""}}

                        </span>
                                    </div>

                                </div>
                            </td>
                            <td>
                                <div class="flight_item">

                                    <div class="top_item">
                        <span>
                            {{$leg["leg_bar"]}}
                        </span>
                                    </div>

                                </div>
                            </td>

                        </tr>

                    @endif
                @endforeach

            @endif

            </tbody>
        </table>


    </div>


</div>
@endif