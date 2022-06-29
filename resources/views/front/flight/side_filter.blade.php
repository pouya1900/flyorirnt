<!-- Sidebar -->

@php
    $i=0;
@endphp

<input type="hidden" name="max_waiting" value="{{$max}}">
<!-- stop search -->
<div class="widget">
    {{--    <h4 class="widget-title filter_drop_down_link">--}}
    {{--        <span class=""> @lang('trs.stops') </span>--}}
    {{--        <span class="filter_drop_down"> ▲ </span>--}}
    {{--    </h4>--}}
    {{--depart--}}
    <div class="widget_content">

        <div class="widget-sub-title">
            <span>@lang('trs.stops')</span>

        </div>

        <div class="widget_item">

            <div class="custom-control custom-checkbox font-weight-600 ">

                <input type="checkbox" class="custom-control-input choose_all " id="depart_stops_all"
                       name="stops" {{!empty($flight) && $flight[0]["DirectionInd"]==2 ? "data-return='1'" : ""}}
                       value="ALL" checked>

                <label class="custom-control-label"
                       for="depart_stops_all">@lang('trs.choose_all') </label>
            </div>

        </div>

        <div class="widget_item">

            <div class="custom-control custom-checkbox ">
                <input type="checkbox" class="custom-control-input filter_input" id="depart_stop0"
                       name="stops" {{!empty($flight) && $flight[0]["DirectionInd"]==2 ? "data-return='1'" : ""}}
                       value="0" {{$search_data["none_stop"] ? "disabled" : ""}}
                        @php
                            $dis=0;
                                if (!isset($flight_grouped[$i]) || $flight_grouped[$i]["stops"]!=0) {
                                     echo "disabled";
                                     $dis=1;
                                }
                                 else {$i++;
                                 echo "checked";}
                        @endphp
                >
                <label class="custom-control-label" for="depart_stop0"> @lang('trs.none_stop')
                    @if($dis==0)
                        <span
                                class="only_filter" data-target="stops">@lang('trs.only')</span>
                    @endif
                </label>

            </div>

        </div>
        @if(!$search_data["none_stop"])
            <div class="widget_item">

                <div class="custom-control custom-checkbox ">
                    <input type="checkbox" class="custom-control-input filter_input" id="depart_stop1"
                           name="stops" {{!empty($flight) && $flight[0]["DirectionInd"]==2 ? "data-return='1'" : ""}}
                           value="1"
                            @php
                                $dis=0;
                                    if (!isset($flight_grouped[$i]) || $flight_grouped[$i]["stops"]!=1) {
                                         echo "disabled";
                                         $dis=1;
                                    }
                                     else {$i++;
                                     echo "checked";}
                            @endphp
                    >
                    <label class="custom-control-label" for="depart_stop1"> 1 @lang('trs.stop')
                        @if($dis==0)
                            <span
                                    class="only_filter" data-target="stops">@lang('trs.only')</span>
                        @endif
                    </label>

                </div>

            </div>
            <div class="widget_item">

                <div class="custom-control custom-checkbox ">
                    <input type="checkbox" class="custom-control-input filter_input" id="depart_stop2"
                           name="stops" {{!empty($flight) && $flight[0]["DirectionInd"]==2 ? "data-return='1'" : ""}}
                           value="2"
                            @php
                                $dis=0;
                                    if (!isset($flight_grouped[$i]) || $flight_grouped[$i]["stops"]<2) {
                                         echo "disabled";
                                         $dis=1;
     }
                                     else {$i++;
                                     echo "checked";}
                            @endphp
                    >

                    <label class="custom-control-label" for="depart_stop2">
                        2+ @lang('trs.stops_in_Counting')
                        @if($dis==0)
                            <span
                                    class="only_filter" data-target="stops">@lang('trs.only')</span>
                        @endif
                    </label>
                </div>

            </div>
        @endif


        {{--return--}}
        {{--                        @if(!empty($flight) && $flight[0]["DirectionInd"]==2)--}}
        {{--                            <div class="margin-top-15px">--}}
        {{--                                <div class="widget-sub-title">--}}
        {{--                                    <span>@lang('trs.return')</span>--}}
        {{--                                </div>--}}

        {{--                                <div class="widget_item">--}}

        {{--                                    <div class="custom-control custom-checkbox font-weight-600 ">--}}
        {{--                                        <input type="checkbox" class="custom-control-input choose_all "--}}
        {{--                                               id="return_stops_all"--}}
        {{--                                               name="return_stops"--}}
        {{--                                               value="ALL" checked>--}}
        {{--                                        <label class="custom-control-label"--}}
        {{--                                               for="return_stops_all">@lang('trs.choose_all') </label>--}}
        {{--                                    </div>--}}

        {{--                                </div>--}}

        {{--                                <div class="widget_item">--}}

        {{--                                    <div class="custom-control custom-checkbox ">--}}
        {{--                                        <input type="checkbox" class="custom-control-input filter_input"--}}
        {{--                                               id="return_stop0"--}}
        {{--                                               name="return_stops" value="0"--}}
        {{--                                                @php--}}
        {{--                                                    $dis=0;--}}
        {{--                                                        $i=0;--}}
        {{--                                                            if (!isset($return_flight_grouped[$i]) || $return_flight_grouped[$i]["return_stops"]!=0) {--}}
        {{--                                                                 echo "disabled";--}}
        {{--                                                                 $dis=1;--}}
        {{--                             }--}}
        {{--                                                             else {$i++;--}}
        {{--                                                             echo "checked";}--}}
        {{--                                                @endphp--}}
        {{--                                                {{$search_data["none_stop"] ? "disabled" : ""}}>--}}
        {{--                                        <label class="custom-control-label" for="return_stop0"> @lang('trs.none_stop')--}}

        {{--                                            @if($dis==0)--}}
        {{--                                                <span--}}
        {{--                                                        class="only_filter"--}}
        {{--                                                        data-target="return_stops">@lang('trs.only')</span>--}}
        {{--                                            @endif--}}
        {{--                                        </label>--}}
        {{--                                    </div>--}}

        {{--                                </div>--}}
        {{--                                @if(!$search_data["none_stop"])--}}
        {{--                                    <div class="widget_item">--}}

        {{--                                        <div class="custom-control custom-checkbox ">--}}
        {{--                                            <input type="checkbox" class="custom-control-input filter_input"--}}
        {{--                                                   id="return_stop1"--}}
        {{--                                                   name="return_stops" value="1"--}}
        {{--                                                    @php--}}
        {{--                                                        $dis=0;--}}
        {{--                                                            if (!isset($return_flight_grouped[$i]) || $return_flight_grouped[$i]["return_stops"]!=1) {--}}
        {{--                                                                 echo "disabled";--}}
        {{--                                                                 $dis=1;--}}
        {{--                             }--}}
        {{--                                                             else {$i++;--}}
        {{--                                                             echo "checked";}--}}
        {{--                                                    @endphp--}}
        {{--                                            >--}}
        {{--                                            <label class="custom-control-label" for="return_stop1"> 1 @lang('trs.stop')--}}
        {{--                                                @if($dis==0)--}}
        {{--                                                    <span--}}
        {{--                                                            class="only_filter"--}}
        {{--                                                            data-target="return_stops">@lang('trs.only')</span>--}}
        {{--                                                @endif--}}
        {{--                                            </label>--}}
        {{--                                        </div>--}}

        {{--                                    </div>--}}
        {{--                                    <div class="widget_item">--}}

        {{--                                        <div class="custom-control custom-checkbox ">--}}
        {{--                                            <input type="checkbox" class="custom-control-input filter_input"--}}
        {{--                                                   id="return_stop2"--}}
        {{--                                                   name="return_stops" value="2"--}}
        {{--                                                    @php--}}
        {{--                                                        $dis=0;--}}
        {{--                                                            if (!isset($return_flight_grouped[$i]) || $return_flight_grouped[$i]["return_stops"]<2) {--}}
        {{--                                                                 echo "disabled";--}}
        {{--                                                                 $dis=1;--}}
        {{--                             }--}}
        {{--                                                             else {$i++;--}}
        {{--                                                             echo "checked";}--}}
        {{--                                                    @endphp--}}
        {{--                                            >--}}
        {{--                                            <label class="custom-control-label" for="return_stop2">--}}
        {{--                                                2+ @lang('trs.stops_in_Counting')--}}
        {{--                                                @if($dis==0)--}}
        {{--                                                    <span--}}
        {{--                                                            class="only_filter"--}}
        {{--                                                            data-target="return_stops">@lang('trs.only')</span>--}}
        {{--                                                @endif--}}
        {{--                                            </label>--}}
        {{--                                        </div>--}}

        {{--                                    </div>--}}
        {{--                                @endif--}}
        {{--                            </div>--}}
        {{--                        @endif--}}
    </div>
</div>
<!--// stop Search -->


<!-- bar search -->
<div class="widget">
    {{--    <h4 class="widget-title filter_drop_down_link">--}}
    {{--        <span class=""> @lang('trs.bar') </span>--}}
    {{--        <span class="filter_drop_down"> ▲ </span>--}}
    {{--    </h4>--}}
    {{--depart--}}
    <div class="widget_content">

        {{--            <div class="widget-sub-title">--}}
        {{--                <span>@lang('trs.depart')</span>--}}

        {{--            </div>--}}


        <div class="widget_item">

            <div class="custom-control custom-checkbox ">
                <input type="checkbox" class="custom-control-input filter_input" id="depart_bar0"
                       name="bar_exist" {{!empty($flight) && $flight[0]["DirectionInd"]==2 ? "data-return='1'" : ""}}
                       value="0" checked
                >
                <label class="custom-control-label" for="depart_bar0"> @lang('trs.without_bar')
                    <i class="bar_filter_icon"><img src="images/icon/suitcase-solid.png"></i>
                    <span
                            class="only_filter" data-target="bar_exist">@lang('trs.only')</span>

                </label>

            </div>

        </div>
        <div class="widget_item">

            <div class="custom-control custom-checkbox ">
                <input type="checkbox" class="custom-control-input filter_input" id="depart_bar1"
                       name="bar_exist" {{!empty($flight) && $flight[0]["DirectionInd"]==2 ? "data-return='1'" : ""}}
                       value="1" checked
                >
                <label class="custom-control-label" for="depart_bar1"> @lang('trs.with_bar')
                    <i class="bar_filter_icon fas fa-suitcase"></i>
                    <span
                            class="only_filter" data-target="bar_exist">@lang('trs.only')</span>

                </label>

            </div>

        </div>


        {{--            --}}{{--return--}}
        {{--            @if(!empty($flight) && $flight[0]["DirectionInd"]==2)--}}
        {{--                <div class="margin-top-15px">--}}
        {{--                    <div class="widget-sub-title">--}}
        {{--                        <span>@lang('trs.return')</span>--}}
        {{--                    </div>--}}

        {{--                    <div class="widget_item">--}}

        {{--                        <div class="custom-control custom-checkbox ">--}}
        {{--                            <input type="checkbox" class="custom-control-input filter_input" id="return_bar0" name="return_bar_exist"--}}
        {{--                                   value="0" checked--}}
        {{--                            >--}}
        {{--                            <label class="custom-control-label" for="return_bar0"> @lang('trs.without_bar')--}}
        {{--                                <span--}}
        {{--                                        class="only_filter" data-target="return_bar_exist">@lang('trs.only')</span>--}}

        {{--                            </label>--}}

        {{--                        </div>--}}

        {{--                    </div>--}}
        {{--                    <div class="widget_item">--}}

        {{--                        <div class="custom-control custom-checkbox ">--}}
        {{--                            <input type="checkbox" class="custom-control-input filter_input" id="return_bar1" name="return_bar_exist"--}}
        {{--                                   value="1" checked--}}
        {{--                            >--}}
        {{--                            <label class="custom-control-label" for="return_bar1"> @lang('trs.with_bar')--}}
        {{--                                <span--}}
        {{--                                        class="only_filter" data-target="return_bar_exist">@lang('trs.only')</span>--}}

        {{--                            </label>--}}

        {{--                        </div>--}}

        {{--                    </div>--}}
        {{--                </div>--}}
        {{--            @endif--}}
    </div>
</div>
<!--// bar Search -->

<!-- time search -->
<div class="widget">
    {{--    <h4 class="widget-title filter_drop_down_link">--}}
    {{--        <span class=""> Time </span>--}}
    {{--        <span class="filter_drop_down"> ▲ </span>--}}
    {{--    </h4>--}}
    {{--depart--}}
    <div class="widget_content">
        <div class="widget-sub-title">
            <span>@lang('trs.depart')</span>
        </div>
        <div class="widget_item">

            <div class="custom-control custom-checkbox font-weight-600 ">
                <input type="checkbox" class="custom-control-input choose_all " id="depart_time_all"
                       name="depart_time_range"
                       value="ALL" checked>
                <label class="custom-control-label"
                       for="depart_time_all">@lang('trs.choose_all') </label>
            </div>

        </div>
        <div class="widget_item">

            <div class="custom-control custom-checkbox ">
                <input type="checkbox" class="custom-control-input filter_input" id="depart_time0"
                       name="depart_time_range" value="0" checked>
                <label class="custom-control-label" for="depart_time0">@lang('trs.midnight')
                    <span
                            class="only_filter" data-target="depart_time_range">@lang('trs.only')</span>
                </label>
            </div>

        </div>
        <div class="widget_item">

            <div class="custom-control custom-checkbox ">
                <input type="checkbox" class="custom-control-input filter_input" id="depart_time1"
                       name="depart_time_range" value="1" checked>
                <label class="custom-control-label" for="depart_time1">@lang('trs.morning')
                    <span
                            class="only_filter" data-target="depart_time_range">@lang('trs.only')</span>
                </label>
            </div>

        </div>
        <div class="widget_item">

            <div class="custom-control custom-checkbox ">
                <input type="checkbox" class="custom-control-input filter_input" id="depart_time2"
                       name="depart_time_range" value="2" checked>
                <label class="custom-control-label" for="depart_time2">@lang('trs.afternoon')
                    <span
                            class="only_filter" data-target="depart_time_range">@lang('trs.only')</span>
                </label>
            </div>

        </div>
        <div class="widget_item">

            <div class="custom-control custom-checkbox ">
                <input type="checkbox" class="custom-control-input filter_input" id="depart_time3"
                       name="depart_time_range" value="3" checked>
                <label class="custom-control-label" for="depart_time3">@lang('trs.night')
                    <span
                            class="only_filter" data-target="depart_time_range">@lang('trs.only')</span>
                </label>
            </div>

        </div>


        @if(!empty($flight) && $flight[0]["DirectionInd"]==2)
            {{--return--}}
            <div class="margin-top-15px">
                <div class="widget-sub-title">
                    <span>@lang('trs.return')</span>
                </div>
                <div class="widget_item">

                    <div class="custom-control custom-checkbox font-weight-600 ">
                        <input type="checkbox" class="custom-control-input choose_all"
                               id="return_time_all"
                               name="return_depart_time_range"
                               value="ALL" checked>
                        <label class="custom-control-label"
                               for="return_time_all">@lang('trs.choose_all')</label>
                    </div>

                </div>
                <div class="widget_item">

                    <div class="custom-control custom-checkbox ">
                        <input type="checkbox" class="custom-control-input filter_input"
                               id="return_time0"
                               name="return_depart_time_range" value="0" checked>
                        <label class="custom-control-label" for="return_time0">@lang('trs.midnight')
                            <span
                                    class="only_filter"
                                    data-target="return_depart_time_range">@lang('trs.only')</span>
                        </label>
                    </div>

                </div>
                <div class="widget_item">

                    <div class="custom-control custom-checkbox ">
                        <input type="checkbox" class="custom-control-input filter_input"
                               id="return_time1"
                               name="return_depart_time_range" value="1" checked>
                        <label class="custom-control-label" for="return_time1">@lang('trs.morning')
                            <span
                                    class="only_filter"
                                    data-target="return_depart_time_range">@lang('trs.only')</span>
                        </label>
                    </div>

                </div>
                <div class="widget_item">

                    <div class="custom-control custom-checkbox ">
                        <input type="checkbox" class="custom-control-input filter_input"
                               id="return_time2"
                               name="return_depart_time_range" value="2" checked>
                        <label class="custom-control-label" for="return_time2">@lang('trs.afternoon')
                            <span
                                    class="only_filter"
                                    data-target="return_depart_time_range">@lang('trs.only')</span>
                        </label>
                    </div>

                </div>
                <div class="widget_item">

                    <div class="custom-control custom-checkbox ">
                        <input type="checkbox" class="custom-control-input filter_input"
                               id="return_time3"
                               name="return_depart_time_range" value="3" checked>
                        <label class="custom-control-label" for="return_time3">@lang('trs.night')
                            <span
                                    class="only_filter"
                                    data-target="return_depart_time_range">@lang('trs.only')</span>
                        </label>
                    </div>

                </div>
            </div>
        @endif
    </div>
</div>
<!--// time Search -->


<!-- waiting time search -->
@if(!$search_data["none_stop"])
    <div class="widget">
        {{--        <h4 class="widget-title filter_drop_down_link">--}}
        {{--            <span class=""> @lang('trs.waiting_time') </span>--}}
        {{--            <span class="filter_drop_down"> ▲ </span>--}}
        {{--        </h4>--}}
        {{--depart--}}
        <div class="widget_content">
            <div class="widget-sub-title">
                <span>@lang('trs.waiting_time')</span>
            </div>
            <div class="widget_item">

                <div class="">
                    <input type="text" class="slide_input" id="total_waiting" name="depart_wait"
                           value=""
                           readonly>
                </div>
                <div id="slide_filter1" class="slide_filter slider-styled" data-start="0" data-end="{{$max}}" {{!empty($flight) && $flight[0]["DirectionInd"]==2 ? "data-return='1'" : ""}}
                     data-target="total_waiting"></div>

            </div>


            {{--                            @if(!empty($flight) && $flight[0]["DirectionInd"]==2)--}}
            {{--                                --}}{{--return--}}
            {{--                                <div class="margin-top-15px">--}}
            {{--                                    <div class="widget-sub-title">--}}
            {{--                                        <span>@lang('trs.return_waiting_time')</span>--}}
            {{--                                    </div>--}}
            {{--                                    <div class="widget_item">--}}

            {{--                                        <div class="">--}}
            {{--                                            <input type="text" class="slide_input" id="return_total_waiting"--}}
            {{--                                                   name="return_wait"--}}
            {{--                                                   value=""--}}
            {{--                                                   readonly>--}}
            {{--                                        </div>--}}
            {{--                                        <div id="slide_filter2" class="slide_filter slider-styled" data-start="0" data-end="{{$max}}"--}}
            {{--                                             data-target="return_total_waiting"></div>--}}

            {{--                                    </div>--}}

            {{--                                </div>--}}
            {{--                            @endif--}}
        </div>
    </div>
@endif
<!--// waiting time Search -->


<!-- airline search -->
<div class="widget">
    {{--    <h4 class="widget-title filter_drop_down_link">--}}
    {{--        <span class=""> @lang('trs.airlines') </span>--}}
    {{--        <span class="filter_drop_down"> ▲ </span>--}}
    {{--    </h4>--}}
    {{--depart--}}
    <div class="widget_content">
        <div class="airlines_widget">

            <div class="widget_item">

                <div class="custom-control custom-checkbox font-weight-600 ">
                    <input type="checkbox" class="custom-control-input choose_all" id="airline0"
                           name="ValidatingAirlineCode"
                           value="ALL" checked>
                    <label class="custom-control-label" for="airline0">@lang('trs.choose_all')</label>
                </div>

            </div>

            @foreach($airlines as $airline)
                <div class="widget_item">

                    <div class="custom-control custom-checkbox ">
                        <input type="checkbox" class="custom-control-input filter_input"
                               id="airline{{$airline["id"]}}"
                               name="ValidatingAirlineCode" value="{{$airline["code"]}}" checked>
                        <label class="custom-control-label" for="airline{{$airline["id"]}}">

                            {{$airline["name"]}}
                            <img class="airline_filter_logo"
                                 src="images/AirlineLogo_k/{{$airline["image"]}}">


                            {{--dont change this code style , parent and sibiling used in js--}}

                            <span
                                    class="filter_min_fare">@lang('trs.from') {{round($airline["TotalFare"])}}€

                            </span>
                            <span
                                    class="only_filter"
                                    data-target="ValidatingAirlineCode">@lang('trs.only')</span>
                        </label>
                    </div>

                </div>

            @endforeach


        </div>
    </div>

</div>
<!--// airline Search -->


<!-- //  Sidebar -->
