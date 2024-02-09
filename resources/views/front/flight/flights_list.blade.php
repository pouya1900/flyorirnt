@php

    $city="city_".$lang;

if (!isset($start)) $start=0;

@endphp

<div id="flight_posts_content"
        {{--     class="{{(isset($ajax_render) && $ajax_render) ? "breaker_container_for_flight" : ""}}"--}}
>

    <!-- flight post -->
    @if(isset($flight) && !empty($flight))
        @foreach($flight as $main_key=>$item)

            @php

                $key=$main_key+$start;

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


                    }

                    $min_seats_depart=1000;
                    $min_seats_return=1000;
                    foreach ($item["legs"] as $item_legs) {
                        if (!$item_legs["is_return"]) {
                            if ($item_legs["seats_remaining"] < $min_seats_depart )
                                {
                                    $min_seats_depart=$item_legs["seats_remaining"];
                                }
                        }
                        else {
                             if ($item_legs["seats_remaining"] < $min_seats_return )
                                {
                                    $min_seats_return=$item_legs["seats_remaining"];
                                }
                        }
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

            <div class="{{$item["ValidatingAirlineCode"]=="IR" && !isset($no_recommended) ? "our_recommend_container" : ""}}">
                @if ($item["ValidatingAirlineCode"]=="IR")
                    <div class="our_recommend">
                        @lang('trs.our_recommend')
                    </div>

                @endif

                <div class="flight_container filter_class padding-0px margin-bottom-0px" id="fl{{$item["id"]}}">

                    <div class="flight-post  with-hover box-shadow-hover ">
                        @if(\Illuminate\Support\Facades\Auth::check() && \Illuminate\Support\Facades\Auth::user()->role==3)
                            {{$item["FareType"]}}
                        @endif
						
                        {{--main flight section--}}
                        <div class="flight_post_container">
                            <div class="row">

                                <div class="col-12 col-md-10">

                                    <div class="row d-md-none">
                                        <div class="flight_item logo_container col-4 ">

                                            @foreach($item["airlines"] as $logo)
                                                @if($logo["pivot"]["is_return"]==0)
                                                    <div class="logo_leg">
                                                        <img src="images/{{$logo["image"]}}"
                                                             alt="{{$logo["name"]}}">

                                                    </div>
                                                @endif
                                            @endforeach

                                            @if (!$item["airlines"])
                                                <div class="logo_leg">
                                                    <img src="images/AirlineLogo/default.png">

                                                </div>
                                            @endif
                                        </div>
                                        <div class="col-4 flight_item ">
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
                                        <div class="flight_item col-4 deal_button_md_d">
                                            <a href="{{route('passengers_info',['flight_token'=>$item["token"]]). ($lang!="de"? "?lang=".$lang : "")}}">
                                                <span>{{$item["TotalFare"]}} €</span>
                                                {{--                                            <span>{{round($item["FarePerAdult"])*$item["adult"] + round($item["FarePerChild"])*$item["child"] + round($item["FarePerInf"])*$item["infant"]}} €</span>--}}
                                                <i class="fas fa-long-arrow-alt-right"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="details_link" data-toggle="collapse"
                                         data-target="#flight_details{{isset($search_data["main_vendor"]) ? 0 : $search_data["render"]}}_{{$key}}"
                                         role="button"
                                         aria-expanded="false"
                                         aria-controls="flight_details{{isset($search_data["main_vendor"]) ? 0 : $search_data["render"]}}_{{$key}}"
                                         data-tar="{{$key}}"
                                         data-render="{{isset($search_data["main_vendor"]) ? 0 : $search_data["render"]}}">

                                        {{--depart section--}}
                                        <div class="depart_section {{$item["DirectionInd"]!=2 ? "border-bottom-0 padding-bottom-0px-imp" : ""}}">
                                            <div class="row">

                                                <div class="flight_item logo_container col d-md-block d-none">

                                                    @foreach($item["airlines"] as $logo)
                                                        @if($logo["pivot"]["is_return"]==0)
                                                            <div class="logo_leg">
                                                                <img src="images/{{$logo["image"]}}"
                                                                     alt="{{$logo["name"]}}">

                                                            </div>
                                                        @endif
                                                    @endforeach
                                                    @if (!$item["airlines"])
                                                        <div class="logo_leg">
                                                            <img src="images/AirlineLogo/default.png">

                                                        </div>
                                                    @endif
                                                </div>

                                                <div class="flight_item col d-md-block d-none">

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
                           {{$depart_date_day}} {{$depart_date}}
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
     {{$total_waiting==0 ? "" : $total_waiting_hour."h"}}{{$total_waiting!=0 ? $total_waiting_min!=0 ? ":".$total_waiting_min."'" : "" :""}}{{$total_waiting==0 ? "" : " waiting"}}
     </span>
                        </span>
                                                    </div>

                                                    <div class="flight_duration_md">
                                                        @if ($min_seats_depart)
                                                            <div class="flight_seats_price_deal">
                                        <span class="{{intval($min_seats_depart)==$search_data["adl"]+$search_data["chl"] ? "text-red" :""}}">
                                            <img src="images/icon/flight-seat.png"
                                                 class="flight_seat_image"> {{$min_seats_depart}} @lang('trs.seats_remains')
                                        </span>
                                                            </div>
                                                        @endif
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
                                                            @if ($min_seats_depart)
                                                                <div class="flight_seats_price_deal">
                                        <span class="{{intval($min_seats_depart)==$search_data["adl"]+$search_data["chl"] ? "text-red" :""}}">
                                            <img src="images/icon/flight-seat.png"
                                                 class="flight_seat_image"> {{$min_seats_depart}} @lang('trs.seats_remains')
                                        </span>
                                                                </div>
                                                            @endif

                                                        </div>

                                                        @if(!$search_data["none_stop"])
                                                            <div class="flight_item col">

                                                                <div class="top_item time_detail waiting_time">
                        <span>
                            {{$total_waiting==0 ? "" : $total_waiting_hour."h"}}{{$total_waiting!=0 ? $total_waiting_min!=0 ? ":".$total_waiting_min."'" : "" :""}}
                        </span>
                                                                </div>


                                                            </div>

                                                        @endif


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

                                            <div class="row d-md-none">
                                                <div class="flight_item logo_container col-4 ">

                                                    @foreach($item["airlines"] as $logo)
                                                        @if($logo["pivot"]["is_return"]==1)
                                                            <div class="logo_leg">
                                                                <img src="images/{{$logo["image"]}}"
                                                                     alt="{{$logo["name"]}}">

                                                            </div>
                                                        @endif
                                                    @endforeach

                                                    @if (!$item["airlines"])
                                                        <div class="logo_leg">
                                                            <img src="images/AirlineLogo/default.png">

                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="col-4 flight_item ">
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
                                                <div class="col-4"></div>
                                            </div>

                                            <div class="return_section">
                                                <div class="row">

                                                    <div class="flight_item logo_container col d-md-block d-none">

                                                        @foreach($item["airlines"] as $logo)
                                                            @if($logo["pivot"]["is_return"]==1)
                                                                <div class="logo_leg">
                                                                    <img src="images/{{$logo["image"]}}"
                                                                         alt="{{$logo["name"]}}">

                                                                </div>
                                                            @endif
                                                        @endforeach
                                                        @if (!$item["airlines"])
                                                            <div class="logo_leg">
                                                                <img src="images/AirlineLogo/default.png">

                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="flight_item col d-md-block d-none ">
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
                                                    {{--                                                    <div class="col-4 d-md-none"></div>--}}

                                                    {{--                                                    <div class="flight_item d-md-block d-none col">--}}

                                                    {{--                                                        <div class="top_item f_t_time">--}}
                                                    {{--                        <span>--}}
                                                    {{--                            {{$item["return_flight_number"]}}--}}

                                                    {{--                        </span>--}}
                                                    {{--                                                        </div>--}}
                                                    {{--                                                        <div class="bot_item">--}}
                                                    {{--                        <span>--}}
                                                    {{--                         {{\App\Services\MyHelperFunction::turn_class($item["return_class"])}}/{{$item["return_class_code"]}}--}}
                                                    {{--                        </span>--}}
                                                    {{--                                                        </div>--}}
                                                    {{--                                                        @if ($return_aircraft_type)--}}
                                                    {{--                                                            <div class="text-black">--}}
                                                    {{--                                                    <span class="aircraft_name">--}}
                                                    {{--                                                        {{$return_aircraft_type}} <i class="fas fa-info-circle"></i>--}}
                                                    {{--                                                        <span class="aircraft_description">--}}
                                                    {{--                                                           {{$return_aircraft_type_description}}--}}
                                                    {{--                                                        </span>--}}
                                                    {{--                                                    </span>--}}

                                                    {{--                                                            </div>--}}
                                                    {{--                                                        @endif--}}
                                                    {{--                                                    </div>--}}

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
                           {{$return_depart_date_day}} {{$return_depart_date}}
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
                                                        <div class="flight_duration_md">

                                                            @if ($min_seats_return)
                                                                <div class="flight_seats_price_deal">
                                        <span class="{{intval($min_seats_return)==$search_data["adl"]+$search_data["chl"] ? "text-red" :""}}">
                                            <img src="images/icon/flight-seat.png"
                                                 class="flight_seat_image"> {{$min_seats_return}} @lang('trs.seats_remains')
                                        </span>
                                                                </div>
                                                            @endif
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

                                                    <div class="flight_item d-md-block d-none col">
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
                                                                @if ($min_seats_return)
                                                                    <div class="flight_seats_price_deal">
                                        <span class="{{intval($min_seats_return)==$search_data["adl"]+$search_data["chl"] ? "text-red" :""}}">
                                            <img src="images/icon/flight-seat.png"
                                                 class="flight_seat_image"> {{$min_seats_return}} @lang('trs.seats_remains')
                                        </span>
                                                                    </div>
                                                                @endif


                                                            </div>
                                                            @if(!$search_data["none_stop"])

                                                                <div class="flight_item col">

                                                                    <div class="top_item time_detail waiting_time">
                        <span>
                            {{$return_total_waiting==0 ? "" : $return_total_waiting_hour."h"}}{{$return_total_waiting!=0 ? $return_total_waiting_min!=0 ? ":".$return_total_waiting_min."'" : "" :""}}

                        </span>
                                                                    </div>


                                                                </div>
                                                            @endif
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
                                                      data-target="#flight_details{{isset($search_data["main_vendor"]) ? 0 : $search_data["render"]}}_{{$key}}"
                                                      role="button"
                                                      aria-expanded="false" aria-controls="collapseExample"
                                                      data-tar="{{$key}}"
                                                      data-render="{{isset($search_data["main_vendor"]) ? 0 : $search_data["render"]}}"><span
                                                            class="all_details_link"><i
                                                                class="fas fa-info-circle"></i>
                                                <div class="flight_details_detail_link display-inline"
                                                     data-change="{{$key}}"
                                                     data-render="{{isset($search_data["main_vendor"]) ? 0 : $search_data["render"]}}">

                                                    <span class="d-none d-md-inline">@lang('trs.details')</span>
                                                </div>
                                           </span></span>
                                            </div>
                                            <div>
                                                <span class="price_link" data-toggle="collapse"
                                                      data-target="#price_details{{isset($search_data["main_vendor"]) ? 0 : $search_data["render"]}}_{{$key}}"
                                                      role="button"
                                                      aria-expanded="false" aria-controls="collapseExample"
                                                      data-tar="{{$key}}"
                                                      data-render="{{isset($search_data["main_vendor"]) ? 0 : $search_data["render"]}}"><span
                                                            class="all_details_link"><i
                                                                class="fas fa-money-bill"></i>
                                                <div class="price_details_detail_link display-inline"
                                                     data-change="{{$key}}"
                                                     data-render="{{isset($search_data["main_vendor"]) ? 0 : $search_data["render"]}}">

                                                    <span class="d-none d-md-inline">@lang('trs.price')</span>
                                                </div>
                                           </span></span>
                                            </div>

                                            <div>

                                    <span class="all_details_link" id="baggage_rules" data-token="{{$item["token"]}}">
                                       @if (!$item["bar_exist"])
                                            <i> <img src="images/icon/suitcase-solid.png"></i>
                                            @if ($item["return_bar_exist"] && $item["DirectionInd"]==2)
                                                / <i class="fas fa-suitcase "></i>
                                                <span class="d-none d-md-inline">{{$item["return_bar"]}}</span>
                                            @endif
                                        @else
                                            <i class="fas fa-suitcase "></i>
                                            <span class="d-md-inline">{{$item["bar"]}}
                                                @if(!$item["return_bar_exist"] && $item["DirectionInd"]==2)
                                                    / <i> <img src="images/icon/suitcase-solid.png"></i>
                                                @else
                                                    {{$item["bar"]!=$item["return_bar"] && $item["return_bar"]!="" ? "/".$item["return_bar"] : ""}}
                                                @endif
                                                    </span>
                                        @endif
                                    </span>
                                            </div>
                                            <div>
                                        <span class="all_details_link" id="ticket_rules"
                                              data-token="{{$item["token"]}}"><i
                                                    class="fas fa-ticket-alt"></i>
                                            <span class="d-none d-md-inline">@lang('trs.ticket_rules')</span>
                                        </span>
                                            </div>

                                        </div>


                                    </div>

                                </div>
                                <hr>
                                <div class="col-2 d-none d-md-block deal_container">


                                    <div class="deal_content {{$item["DirectionInd"]==2 ? "return_deal_bottom" : "single_deal_bottom"}}">
                                        <div class="deal_price_total">
                                            {{--                                        <span>{{round($item["TotalFare"])}} €</span>--}}
                                            <span>{{$item["TotalFare"]}} €</span>
                                            {{--                                        <span>{{round($item["FarePerAdult"])*$item["adult"] + round($item["FarePerChild"])*$item["child"] + round($item["FarePerInf"])*$item["infant"]}} €</span>--}}

                                        </div>
                                        @if($item["TotalFare"]!=$item["FarePerAdult"])
                                            <div class="deal_price_detail">
                                                <span>{{round($item["FarePerAdult"])}} € @lang('trs.p.a')</span>
                                                {{--                                            <span>{{$item["FarePerAdult"]}} € @lang('trs.p.a')</span>--}}
                                            </div>
                                        @endif

                                        <a href="{{route('passengers_info',['flight_token'=>$item["token"]]). ($lang!="de"? "?lang=".$lang : "")}}">
                                            <div class="deal_button">@lang('trs.deal')</div>
                                        </a>

                                        <div class="deal_section_baggage_container">
                                        <span class="deal_section_baggage" id="baggage_rules"
                                              data-token="{{$item["token"]}}">



                                            @if (!$item["bar_exist"])
                                                <i> <img src="images/icon/suitcase-solid.png"></i>
                                                @if ($item["return_bar_exist"] && $item["DirectionInd"]==2)
                                                    / <i class="fas fa-suitcase "></i>
                                                    <span class="d-none d-md-inline">{{$item["return_bar"]}}</span>
                                                @endif
                                            @else
                                                <i class="fas fa-suitcase "></i>
                                                <span class="d-none d-md-inline">{{$item["bar"]}}
                                                    @if(!$item["return_bar_exist"] && $item["DirectionInd"]==2)
                                                        / <i> <img src="images/icon/suitcase-solid.png"></i>
                                                    @else
                                                        {{$item["bar"]!=$item["return_bar"] && $item["return_bar"]!="" ? "/".$item["return_bar"] : ""}}
                                                    @endif
                                                    </span>
                                            @endif


                                            </span>
                                        </div>

                                        @if (!$item["bar_exist"] || ($item["DirectionInd"]==2 && !$item["return_bar_exist"]))
                                            <div class="deal_section_baggage_alert">
                                                <span>
                                                {{(!$item["bar_exist"] && !$item["return_bar_exist"]) ? trans('trs.no_baggage') : (!$item["bar_exist"] ? trans('trs.no_baggage_depart') : trans('trs.no_baggage_return'))}}
                                                </span>
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
            </div>

        @endforeach


    @endif
</div>
@if(isset($flight) && !empty($flight))

    <input type="hidden" name="lang" value="{{$lang}}">
    <input type="hidden" name="is_none_stop" value="{{$search_data["none_stop"]}}">

@endif
@include('front.flight.flight_pagination')