@include('front.partials.flight_header')


@php

    $count=sizeof($flight);
        $city="city_".$lang;

@endphp

<!-- flight post -->
@if(isset($flight) && !empty($flight))

    @php

        $item=$flight;
        if (!isset($key)) $key=0;
            $depart=$item["depart_time"];
            $depart_time=date('H:i',strtotime($depart));
            $depart_date=date('d.m.Y',strtotime($depart));
            $depart_date_day=\App\Services\MyHelperFunction::turn_day_of_week(date('w',strtotime($depart)));

            $arrival=$item["arrival_time"];
            $arrival_time=date('H:i',strtotime($arrival));
            $arrival_date=date('d.m.Y',strtotime($arrival));
            $arrival_date_day=\App\Services\MyHelperFunction::turn_day_of_week(date('w',strtotime($arrival)));

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
            $return_depart_date_day=\App\Services\MyHelperFunction::turn_day_of_week(date('w',strtotime($return_depart)));

            $return_arrival=$item["return_arrival_time"];
            $return_arrival_time=date('H:i',strtotime($return_arrival));
            $return_arrival_date=date('d.m.Y',strtotime($return_arrival));
            $return_arrival_date_day=\App\Services\MyHelperFunction::turn_day_of_week(date('w',strtotime($return_arrival)));

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

            $depart_aircraft_type="";
            $return_aircraft_type="";
            if (!$item["stops"]) {
                $depart_aircraft_type=$item["legs"][0]["aircraft_type"];
                $depart_aircraft_type_description=$item["legs"][0]["aircraft_type_description"];
            }
            if (!$item["return_stops"]){
                $return_aircraft_type=$item["legs"][count($item["legs"])-1]["aircraft_type"];
                $return_aircraft_type_description=$item["legs"][count($item["legs"])-1]["aircraft_type_description"];
            }

    @endphp

    <div class="flight_container filter_class padding-0px margin-bottom-0px">

        <div class="flight-post flight-post_last  with-hover box-shadow-hover ">

            {{--main flight section--}}
            <div class="flight_post_container">
                <div class="row">

                    <div class="col-12 col-md-10">

                        <div class="details_link" data-toggle="collapse" data-target="#flight_details0_{{$key}}" role="button"
                           aria-expanded="false" aria-controls="collapseExample" data-tar="{{$key}}" data-render="0">

                            {{--depart section--}}
                            <div class="depart_section {{$item["DirectionInd"]!=2 ? "border-bottom-0 padding-bottom-0px-imp" : ""}}">
                                <div class="row">

                                    <div class="flight_item logo_container col-4 col-md">

                                        @foreach($item["airlines"] as $logo)
                                            @if($logo["pivot"]["is_return"]==0)
                                                <div class="logo_leg">
                                                    <img src="images/{{$logo["image"]}}">

                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                    <div class="col-4 flight_item d-md-none">
                                        <div class="top_item f_t_time">
                        <span>
        {{$item["flight_number"]}}
                        </span>
                                        </div>
                                        <div class="bot_item">
                        <span>
                         {{\App\Services\MyHelperFunction::turn_class($item["class"])}}/{{$item["class_code"]}}
                        </span>
                                        </div>
                                        @if ($depart_aircraft_type)
                                            <div class="text-black">
                                                    <span class="aircraft_name">
                                                        {{$depart_aircraft_type}} <i class="fas fa-info-circle"></i>
                                                <span class="aircraft_description">
                                                           {{$depart_aircraft_type_description}}
                                                        </span>
                                                    </span>

                                            </div>
                                        @endif
                                    </div>
                                    <div class="flight_item col-4 deal_button_md_d d-md-none"><span>{{round($item["TotalFare"])}} €</span>
                                    </div>

                                    <div class="flight_item col d-md-block d-none">

                                        <div class="top_item f_t_time">
                        <span>
        {{$item["flight_number"]}}
                        </span>
                                        </div>
                                        <div class="bot_item">
                        <span>
                         {{\App\Services\MyHelperFunction::turn_class($item["class"])}}//{{$item["class_code"]}}
                        </span>
                                        </div>
                                        @if ($depart_aircraft_type)
                                            <div class="text-black">
                                                    <span class="aircraft_name">
                                                        {{$depart_aircraft_type}} <i class="fas fa-info-circle"></i>
                                                <span class="aircraft_description">
                                                           {{$depart_aircraft_type_description}}
                                                        </span>
                                                    </span>

                                            </div>
                                        @endif
                                    </div>

                                    <div class="flight_item col">

                                        <div class="top_item f_t_time">
                        <span>
                           {{$depart_time}}
                        </span>
                                        </div>
                                        <div class="bot_item">
                        <span>
                            @if ($item["airports1"])
                                {{$item["airports1"][$city]!="" ? $item["airports1"][$city] : $item["airports1"]["city_en"]}}
                                -{{$item["airports1"]["code"]!="" ? $item["airports1"]["code"] : $item["depart_airport"]}}
                            @else
                                {{$item["depart_airport"]}}
                            @endif
                        </span>

                                        </div>
                                        <div class="date_item">
                        <span>
                          {{$depart_date_day}}  {{$depart_date}}
                        </span>
                                        </div>
                                    </div>

                                    {{--                                            sm display div--}}

                                    <div class="flight_item col d-md-none sm_display_div_result">

                                        <div class="flight_duration_md">
                        <span>
                           {{$total_time_hour."h"}}{{$total_time_min!=0 ? ":".$total_time_min."'" : ""}}
                        </span>

                                        </div>
                                        <div class="flight_duration_md">
 <span>
                            {{$item["stops"]==0 ? trans('trs.none_stop') : ($item["stops"]==1 ? $item["stops"]." ".trans('trs.stop') : $item["stops"]." ".trans('trs.stops_in_Counting'))}}
                    <span class="flight_duration_md_waiting">
                                 {{$total_waiting==0 ? "" : $total_waiting_hour."h"}}{{$total_waiting!=0 ? $total_waiting_min!=0 ? ":".$total_waiting_min."'" : "" :""}}
                        {{$total_waiting==0 ? "" : " waiting"}}
     </span>
                        </span>
                                        </div>

                                    </div>

                                    {{--                                            end sm display div--}}


                                    <div class="flight_item col">

                                        <div class="top_item f_t_time">
                        <span>
                            {{$arrival_time}}
                        </span>
                                        </div>
                                        <div class="bot_item">
                        <span>
                             @if ($item["airports2"])
                                {{$item["airports2"][$city]!="" ? $item["airports2"][$city] : $item["airports2"]["city_en"]}}
                                -{{$item["airports2"]["code"]!="" ? $item["airports2"]["code"] : $item["arrival_airport"]}}
                            @else
                                {{$item["arrival_airport"]}}
                            @endif

                        </span>

                                        </div>
                                        <div class="date_item">
                        <span>
                           {{$arrival_date_day}} {{$arrival_date}}
                        </span>
                                        </div>
                                    </div>
                                    <div class="flight_item col d-md-block d-none">
                                        <div class="row margin-left-0px margin-right-0px">
                                            <div class="flight_item col">

                                                <div class="top_item time_detail">
                        <span>
                           {{$total_time_hour."h"}}{{$total_time_min!=0 ? ":".$total_time_min."'" : ""}}
                        </span>
                                                </div>
                                                <div class="bot_item">
                        <span>
                            {{$item["stops"]==0 ? trans('trs.none_stop') : ($item["stops"]==1 ? $item["stops"]." ".trans('trs.stop') : $item["stops"]." ".trans('trs.stops_in_Counting'))}}

                        </span>
                                                </div>

                                            </div>

                                            {{--                                            @if(!$search_data["none_stop"])--}}

                                            <div class="flight_item col">

                                                <div class="top_item time_detail waiting_time">
                        <span>
                            {{$total_waiting==0 ? "" : $total_waiting_hour."h"}}{{$total_waiting!=0 ? $total_waiting_min!=0 ? ":".$total_waiting_min."'" : "" :""}}
                        </span>
                                                </div>


                                            </div>
                                            {{--                                            @endif--}}

                                        </div>
                                    </div>


                                    {{--<div class="flight_item col-2">--}}

                                    {{--<div class="top_item">--}}
                                    {{--<span>--}}
                                    {{--20kg--}}
                                    {{--</span>--}}
                                    {{--</div>--}}

                                    {{--</div>--}}
                                    {{----}}

                                </div>
                            </div>
                            {{--return section--}}
                            @if($item["DirectionInd"]==2)
                                <div class="return_section">
                                    <div class="row">

                                        <div class="flight_item logo_container col-4 col-md">

                                            @foreach($item["airlines"] as $logo)
                                                @if($logo["pivot"]["is_return"]==1)
                                                    <div class="logo_leg">
                                                        <img src="images/{{$logo["image"]}}">

                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                        <div class="col-4 flight_item d-md-none">
                                            <div class="top_item f_t_time">
                        <span>
                            {{$item["return_flight_number"]}}

                        </span>
                                            </div>
                                            <div class="bot_item">
                        <span>
                         {{\App\Services\MyHelperFunction::turn_class($item["return_class"])}}/{{$item["return_class_code"]}}
                        </span>
                                            </div>
                                            @if ($return_aircraft_type)
                                                <div class="text-black">
                                                    <span class="aircraft_name">
                                                        {{$return_aircraft_type}} <i class="fas fa-info-circle"></i>
                                                        <span class="aircraft_description">
                                                           {{$return_aircraft_type_description}}
                                                        </span>
                                                    </span>

                                                </div>
                                            @endif
                                        </div>
                                        <div class="col-4 d-md-none"></div>

                                        <div class="flight_item col d-md-block d-none">

                                            <div class="top_item f_t_time">
                        <span>
                            {{$item["return_flight_number"]}}

                        </span>
                                            </div>
                                            <div class="bot_item">
                        <span>
                         {{\App\Services\MyHelperFunction::turn_class($item["return_class"])}}/{{$item["return_class_code"]}}
                        </span>
                                            </div>
                                            @if ($return_aircraft_type)
                                                <div class="text-black">
                                                    <span class="aircraft_name">
                                                        {{$return_aircraft_type}} <i class="fas fa-info-circle"></i>
                                                        <span class="aircraft_description">
                                                           {{$return_aircraft_type_description}}
                                                        </span>
                                                    </span>

                                                </div>
                                            @endif
                                        </div>

                                        <div class="flight_item col">

                                            <div class="top_item f_t_time">
                        <span>
                            {{$return_depart_time}}
                        </span>
                                            </div>
                                            <div class="bot_item">
                        <span>
                            @if ($item["airports3"])
                                {{$item["airports3"][$city]!="" ? $item["airports3"][$city] : $item["airports3"]["city_en"]}}
                                -{{$item["airports3"]["code"]!="" ? $item["airports3"]["code"] : $item["return_depart_airport"]}}
                            @else
                                {{$item["return_depart_airport"]}}
                            @endif

                        </span>
                                            </div>
                                            <div class="date_item">
                        <span>
                          {{$return_depart_date_day}}  {{$return_depart_date}}
                        </span>
                                            </div>
                                        </div>

                                        {{--                                            sm display div--}}

                                        <div class="flight_item col d-md-none sm_display_div_result">

                                            <div class="flight_duration_md">
                        <span>
                            {{$return_total_time_hour."h"}}{{$return_total_time_min!=0 ? ":".$return_total_time_min."'" : ""}}

                        </span>

                                            </div>
                                            <div class="flight_duration_md">
                         <span>
                            {{$item["return_stops"]==0 ? trans('trs.none_stop') : ($item["return_stops"]==1 ? $item["return_stops"]." ".trans('trs.stop') : $item["return_stops"]." ".trans('trs.stops_in_Counting'))}}
<span class="flight_duration_md_waiting">
                            {{$return_total_waiting==0 ? "" : $return_total_waiting_hour."h"}}{{$return_total_waiting!=0 ? $return_total_waiting_min!=0 ? ":".$return_total_waiting_min."'" : "" :""}}
    {{$return_total_waiting==0 ? "" : " waiting"}}
     </span>
                        </span>
                                            </div>

                                        </div>

                                        {{--                                            end sm display div--}}


                                        <div class="flight_item col">

                                            <div class="top_item f_t_time">
                        <span>
                            {{$return_arrival_time}}
                        </span>
                                            </div>
                                            <div class="bot_item">
                       <span>
                           @if ($item["airports4"])
                               {{$item["airports4"][$city]!="" ? $item["airports4"][$city] : $item["airports4"]["city_en"]}}
                               -{{$item["airports4"]["code"]!="" ? $item["airports4"]["code"] : $item["return_arrival_airport"]}}
                           @else
                               {{$item["return_arrival_airport"]}}
                           @endif

                        </span>
                                            </div>
                                            <div class="date_item">
                        <span>
                           {{$return_arrival_date_day}} {{$return_arrival_date}}
                        </span>
                                            </div>
                                        </div>

                                        <div class="flight_item col d-md-block d-none">
                                            <div class="row margin-left-0px margin-right-0px">
                                                <div class="flight_item col">

                                                    <div class="top_item time_detail">
                        <span>
                            {{$return_total_time_hour."h"}}{{$return_total_time_min!=0 ? ":".$return_total_time_min."'" : ""}}

                        </span>
                                                    </div>
                                                    <div class="bot_item">
                        <span>
                            {{$item["return_stops"]==0 ? trans('trs.none_stop') : ($item["return_stops"]==1 ? $item["return_stops"]." ".trans('trs.stop') : $item["return_stops"]." ".trans('trs.stops_in_Counting'))}}

                        </span>
                                                    </div>

                                                </div>
                                                {{--                                                @if(!$search_data["none_stop"])--}}
                                                <div class="flight_item col">

                                                    <div class="top_item time_detail waiting_time">
                        <span>
                            {{$return_total_waiting==0 ? "" : $return_total_waiting_hour."h"}}{{$return_total_waiting!=0 ? $return_total_waiting_min!=0 ? ":".$return_total_waiting_min."'" : "" :""}}

                        </span>
                                                    </div>


                                                </div>
                                                {{--                                                @endif--}}

                                            </div>
                                        </div>

                                        {{--<div class="flight_item col-2">--}}

                                        {{--<div class="top_item">--}}
                                        {{--<span>--}}
                                        {{--20kg--}}
                                        {{--</span>--}}
                                        {{--</div>--}}

                                        {{--</div>--}}


                                    </div>

                                </div>
                            @endif
                        </div>
                        <div class="flight_details">


                            <div class="rules">

                                <div>
                                    <span class="details_link" data-toggle="collapse"
                                       data-target="#flight_details0_{{$key}}" role="button"
                                       aria-expanded="false" aria-controls="collapseExample"
                                       data-tar="{{$key}}" data-render="0"><span class="all_details_link"><i
                                                    class="fas fa-info-circle"></i>
                                                <div class="flight_details_detail_link display-inline"
                                                     data-change="{{$key}}" data-render="0">

                                                    <span class="d-none d-md-inline">@lang('trs.details')</span>
                                                </div>
                                           </span></span>
                                </div>
                                <div>
                                    <span class="price_link" data-toggle="collapse"
                                       data-target="#price_details0_{{$key}}" role="button"
                                       aria-expanded="false" aria-controls="collapseExample"
                                       data-tar="{{$key}}" data-render="0"><span class="all_details_link"><i
                                                    class="fas fa-money-bill"></i>
                                                <div class="price_details_detail_link display-inline"
                                                     data-change="{{$key}}" data-render="0">

                                                    <span class="d-none d-md-inline">@lang('trs.price')</span>
                                                </div>
                                           </span></span>
                                </div>

                                <div>
                                    <span class="all_details_link" id="baggage_rules" data-token="{{$item["token"]}}">
                                        @if (!$item["bar_exist"] && !$item["return_bar_exist"] )
                                            <i> <img src="images/icon/suitcase-solid.png"></i>
                                        @else
                                            <i class="fas fa-suitcase"></i>
                                            <span class="">
                                            {{$item["bar"]}}{{$item["bar"]!=$item["return_bar"] && $item["return_bar"]!="" ? "/".$item["return_bar"] : ""}}
                                            </span>
                                        @endif
                                             </span>
                                </div>
                                <div>
                                    <span class="all_details_link" id="ticket_rules" data-token="{{$item["token"]}}"><i
                                                class="fas fa-ticket-alt"></i>
                                        <span class="d-none d-md-inline">@lang('trs.ticket_rules')</span>
                                    </span>
                                </div>

                            </div>


                        </div>

                    </div>
                    <hr>
                    <div class="col-2 d-none d-md-block deal_container ">


                        <div class="deal_content deal_content_passenger">
                            <div class="deal_price_total">
                                {{--                                <span>{{round($item["TotalFare"])}} €</span>--}}
                                <span>{{round($item["FarePerAdult"])*$item["adult"] + round($item["FarePerChild"])*$item["child"] + round($item["FarePerInf"])*$item["infant"]}} €</span>
                            </div>
                            @if($item["TotalFare"]!=$item["FarePerAdult"])
                                <div class="deal_price_detail">
                                    <span>{{round($item["FarePerAdult"])}} € @lang('trs.p.a')</span>
                                </div>
                            @endif

                        </div>


                    </div>

                </div>
            </div>
            {{--//main flight section--}}

            @include('front.partials.flight_detail')
            @include('front.partials.price_detail')

        </div>


    </div>



    <input type="hidden" name="lang" value="{{$lang}}">
    <input type="hidden" name="sch_id" value="{{$flight["search_id"]}}">
@endif
<!-- //  Content -->

