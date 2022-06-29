@php
    $i=0;
@endphp

<div class="airline_list_container d-none d-lg-block">

    <div class="row">

        <div class="col-12">

            <table class="table table-bordered">
                <thead>
                <tr class="thead_airline_logo">
                    <th class="first_row" rowspan="2" scope="col">@lang("trs.airlines")</th>

                    @foreach($airlines_list as $item)

                        <th scope="col">
                            <div><img src="images/{{$item[0]["image"]}}"></div>
                        </th>
                    @endforeach
                </tr>
                <tr class="thead_airline_name">
                    @foreach($airlines_list as $item)

                        <th scope="col">
                            <div>{{$item[0]["name"]}}</div>
                        </th>
                    @endforeach
                </tr>
                </thead>
                <tbody>
                @if (isset($flight_grouped[$i]) && $flight_grouped[$i]["stops"]==0)
                    <tr>
                        <th class="first_row" scope="row">@lang("trs.none_stop")</th>

                        @foreach($airlines_list as $key=>$value)

                            @if ($value[0]["stops"]==0)
                                <td class="airline_list_filter"
                                    data-id="{{$value[0]["flight_id"]}}">{{round($value[0]["FarePerAdult"])*$value[0]["adult"] + round($value[0]["FarePerChild"])*$value[0]["child"] + round($value[0]["FarePerInf"])*$value[0]["infant"]}}</td>
                            @else
                                <td>-</td>
                            @endif
                        @endforeach
                    </tr>
                    @php($i++)
                @endif
                @if (isset($flight_grouped[$i]) && $flight_grouped[$i]["stops"]==1)

                    <tr>
                        <th class="first_row" scope="row">1 @lang('trs.stop')</th>

                        @foreach($airlines_list as $key=>$value)

                            @if ($value[0]["stops"]==1)
                                <td class="airline_list_filter"
                                    data-id="{{$value[0]["flight_id"]}}">{{round($value[0]["FarePerAdult"])*$value[0]["adult"] + round($value[0]["FarePerChild"])*$value[0]["child"] + round($value[0]["FarePerInf"])*$value[0]["infant"]}}</td>

                            @elseif(isset($value[1]) && $value[1]["stops"]==1)
                                <td class="airline_list_filter"
                                    data-id="{{$value[1]["flight_id"]}}">{{round($value[1]["FarePerAdult"])*$value[1]["adult"] + round($value[1]["FarePerChild"])*$value[1]["child"] + round($value[1]["FarePerInf"])*$value[1]["infant"]}}</td>
                            @else
                                <td>-</td>
                            @endif


                        @endforeach

                    </tr>
                    @php($i++)
                @endif
                @if (isset($flight_grouped[$i]) && $flight_grouped[$i]["stops"]==2)

                    <tr>
                        <th class="first_row" scope="row">+2 @lang('trs.stops_in_Counting')</th>

                        @foreach($airlines_list as $key=>$value)

                            @if ($value[0]["stops"]==2)
                                <td class="airline_list_filter"
                                    data-id="{{$value[0]["flight_id"]}}">{{round($value[0]["FarePerAdult"])*$value[0]["adult"] + round($value[0]["FarePerChild"])*$value[0]["child"] + round($value[0]["FarePerInf"])*$value[0]["infant"]}}</td>

                            @elseif(isset($value[1]) && $value[1]["stops"]==2)
                                <td class="airline_list_filter"
                                    data-id="{{$value[1]["flight_id"]}}">{{round($value[1]["FarePerAdult"])*$value[1]["adult"] + round($value[1]["FarePerChild"])*$value[1]["child"] + round($value[1]["FarePerInf"])*$value[1]["infant"]}}</td>
                            @elseif(isset($value[2]))
                                <td class="airline_list_filter"
                                    data-id="{{$value[2]["flight_id"]}}">{{round($value[2]["FarePerAdult"])*$value[2]["adult"] + round($value[2]["FarePerChild"])*$value[2]["child"] + round($value[2]["FarePerInf"])*$value[2]["infant"]}}</td>
                            @else
                                <td>-</td>
                            @endif

                        @endforeach
                    </tr>
                @endif
                </tbody>
            </table>
        </div>
    </div>
</div>