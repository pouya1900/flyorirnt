<div class="container mobile_search_bar_container">
    <div class="search_bar_data" data-toggle="collapse" data-target="#search_bar_collapse" role="button"
         aria-expanded="false"
         aria-controls="collapseExample">
        <div class="row margin-right-0px margin-left-0px">
            <div class="col-12 col-lg-7 search_bar_info_div">
                @if (!isset($search_data["multi"]))


                    <span>{{$search_data["origin_city"]."-".$search_data["origin_code_3chr"]}} @lang('trs.to') {{$search_data["destination_city"]."-".$search_data["destination_code_3chr"]}}</span>
                    <span>@lang('trs.depart'): <i
                            class="font-weight-600">{{date('d.m.Y',strtotime($search_data["depart"]))}}</i> {!! $search_data["return"] != "-" ? trans('trs.return').": <i class='font-weight-600'>".date('d.m.Y',strtotime($search_data["return"]))."</i>" : "" !!} </span>
                    <span>({{$search_data["adl"]}} @lang('trs.adult')  {{$search_data["chl"] ? ", ".$search_data["chl"]." ".trans('trs.child') : ""}} {{$search_data["inf"] ? ", ".$search_data["inf"]." ".trans('trs.infant') : ""}})</span>
                @endif
            </div>
            <div class="col-12 col-lg-5 search_bar_button_div">
                <span><a href="{{$search_data["prev"]}}" class="other_days">@lang('trs.prev_day')</a></span>
                <span class="d-none d-md-inline"><a class="edit">@lang('trs.edit_search')</a></span>
                <span><a href="{{$search_data["next"]}}" class="other_days">@lang('trs.next_day')</a></span>
            </div>
            <div class="col-12 d-md-none search_bar_button_div">
                <span><a class="edit">@lang('trs.edit_search')</a></span>
            </div>
        </div>
    </div>

</div>
<div class="search_bar collapse" id="search_bar_collapse">

    <div class="container">
        <div class="search_nav">

            @if (isset($search_data["multi"]))

            @else
                <div class="way {{$search_data["return"]!="-" ? "active_tab" : ""}}" data-toggle="R"
                     data-id="1">@lang('trs.round_trip')
                </div>
                <div class="way {{$search_data["return"]=="-" ? "active_tab" : ""}}" data-toggle="O"
                     data-id="1">@lang('trs.one_way')
                </div>
            @endif
            <br class="clearfix">
        </div>

        <div class="search_content">
            <form method="post" action="{{route('search'). ($lang!="de"? "?lang=".$lang : "")}}" class="search_form"
                  data-toggle="1">
                {{ csrf_field()  }}
                <div class="row">

                    <input type="hidden" name="stops0" value="{{!$filter['stops0']}}">
                    <input type="hidden" name="stops1" value="{{!$filter['stops1']}}">
                    <input type="hidden" name="stops2" value="{{!$filter['stops2']}}">
                    <input type="hidden" name="bar0" value="{{!$filter['bar0']}}">
                    <input type="hidden" name="bar1" value="{{!$filter['bar1']}}">
                    <input type="hidden" name="wait0" value="{{$filter['wait0']}}">
                    <input type="hidden" name="wait1" value="{{$filter['wait1']}}">

                    @if (isset($search_data["multi"]))

                    @else
                        <div class="col-md-3">
                            <div class="form-group margin-bottom-5px">
                                <label>@lang('trs.flying_from'):</label>
                                <div class="origin"><input name="origin" type="text"
                                                           class="input-text full-width airport_search airport_search1"
                                                           data-validation="1" data-sec="1" autocomplete="off"
                                                           value="{{$search_data["origin_code"]}}"
                                                           data-country="{{$search_data["origin_country"]}}"
                                                           data-code="{{$search_data["origin_code_3chr"]}}"
                                                           placeholder="@lang('trs.flying_from')">
                                    <div class="search_result1 search_result"></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group margin-bottom-5px">
                                <label>@lang('trs.flying_to'):</label>
                                <div class="destination"><input name="destination" type="text"
                                                                class="input-text full-width airport_search airport_search2"
                                                                data-validation="1" data-sec="2"
                                                                value="{{$search_data["destination_code"]}}"
                                                                data-country="{{$search_data["destination_country"]}}"
                                                                data-code="{{$search_data["destination_code_3chr"]}}"
                                                                placeholder="@lang('trs.flying_to')" autocomplete="off">
                                    <div class="search_result2 search_result"></div>

                                </div>
                            </div>
                        </div>

                        <div
                            class="form-group round_trip1 col-md-2 {{$search_data["return"]=="-" ? "display_none" : ""}}">
                            <label>@lang('trs.depart') :</label>
                            <div class="date-input full-width">
                                <input id="daterange1" type="text" name="daterange_d"
                                       data-validation="{{$search_data["return"]!="-" ? 1 : 0}}" autocomplete="off"
                                       {{$search_data["return"]=="-" ? "disabled" : ""}}
                                       class="input-text full-width daterange1"
                                       data-start="{{$search_data["return"]!="-" ? date('m d Y',strtotime($search_data["depart"])) : ""}}"
                                       value="{{$search_data["return"]!="-" ? $search_data["depart"] : ""}}">
                            </div>

                        </div>

                        <div
                            class="form-group round_trip1 col-md-2 {{$search_data["return"]=="-" ? "display_none" : ""}}">
                            <label>@lang('trs.return') :</label>
                            <div class="date-input full-width">
                                <input id="daterange2" type="text" name="daterange_r"
                                       data-validation="{{$search_data["return"]!="-" ? 1 : 0}}" autocomplete="off"
                                       {{$search_data["return"]=="-" ? "disabled" : ""}}
                                       class="input-text full-width daterange1"
                                       data-end="{{$search_data["return"]!="-" ? date('m d Y',strtotime($search_data["return"])) : ""}}"
                                       value="{{$search_data["return"]!="-" ? $search_data["return"] : ""}}">
                            </div>
                        </div>

                        <div class="form-group col-md-4 one_way1 {{$search_data["return"]!="-" ? "display_none" : ""}}">
                            <label>@lang('trs.depart') :</label>
                            <div class="date-input"><input id="date1" type="text" name="date"
                                                           data-validation="{{$search_data["return"]!="-" ? 0 : 1}}"
                                                           autocomplete="off"
                                                           {{$search_data["return"]!="-" ? "disabled" : ""}}
                                                           class="input-text full-width date1"
                                                           data-start="{{$search_data["return"]=="-" ? date('m d Y',strtotime($search_data["depart"])) : ""}}"
                                                           value="{{$search_data["return"]=="-" ? $search_data["depart"] : ""}}">
                            </div>
                        </div>
                    @endif

                </div>

                <div class="row">

                    <div class="col-md-3">
                        <div class="row margin-0px">

                            <div class="col-4 padding-right-5px padding-left-5px">

                                <div class="count_h">

                                    <div class="font-weight-600">@lang('trs.adults')</div>
                                    <div class="counter_h">

                                        <div class="count_h_up count_btn">+</div>
                                        <input type="text" class="count_number" readonly value="{{$search_data["adl"]}}"
                                               data-min="1" data-max="9" id="adl" name="adl">
                                        <div class="count_h_down count_btn">-</div>

                                    </div>
                                    <div class="age_range">(+12 @lang('trs.years'))</div>

                                </div>

                            </div>
                            <div class="col-4 padding-right-5px padding-left-5px">

                                <div class="count_h">

                                    <div class="font-weight-600">@lang('trs.children')</div>
                                    <div class="counter_h">

                                        <div class="count_h_up count_btn">+</div>
                                        <input type="text" class="count_number" readonly value="{{$search_data["chl"]}}"
                                               data-min="0" data-max="8" id="chl" name="chl">
                                        <div class="count_h_down count_btn">-</div>

                                    </div>
                                    <div class="age_range">(2-12 @lang('trs.years'))</div>

                                </div>

                            </div>
                            <div class="col-4 padding-right-5px padding-left-5px">

                                <div class="count_h">

                                    <div class="font-weight-600">@lang('trs.infants')</div>
                                    <div class="counter_h">

                                        <div class="count_h_up count_btn">+</div>
                                        <input type="text" class="count_number" readonly value="{{$search_data["inf"]}}"
                                               data-min="0" data-max="8" id="inf" name="inf">
                                        <div class="count_h_down count_btn">-</div>

                                    </div>
                                    <div class="age_range">(-2 @lang('trs.years'))</div>

                                </div>

                            </div>


                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group margin-top-15px">

                            <div class="flight_type">
                                <select class="select_type" name="flight_class">

                                    <option {{$search_data["class"]=="Economy" ? "selected" : ""}}>@lang('trs.economy')</option>
                                    <option {{$search_data["class"]=="Premium" ? "selected" : ""}}>@lang('trs.premium')</option>
                                    <option {{$search_data["class"]=="Business" ? "selected" : ""}}>@lang('trs.business')</option>
                                    <option {{$search_data["class"]=="First" ? "selected" : ""}}>@lang('trs.first')</option>

                                </select>
                            </div>

                        </div>
                    </div>

                    <div class="col-md-2">

                        <div class="form-group margin-top-15px user_select_none">

                            <div class="custom-control custom-checkbox display-inline">
                                <input type="checkbox" class="custom-control-input check_stop" id="stop_q"
                                       {{$search_data["none_stop"] ? "checked" : ""}}
                                       name="stop_q">
                                <label class="custom-control-label display-cell"
                                       for="stop_q">@lang('trs.none_stop')</label>
                            </div>

                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group margin-top-5px">

                            <button type="submit"
                                    class="btn-sm btn-lg btn-block background-main-color text-white text-center text-uppercase font-weight-600  ">
                                <i
                                    class="fa fa-search"></i> @lang('trs.flight_search')
                            </button>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>

<input type="hidden" name="lang" value="{{$lang}}">
