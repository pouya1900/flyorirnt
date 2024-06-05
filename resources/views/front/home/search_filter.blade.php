<!-- ======= Search Filter  ======= -->
<input type="hidden" name="page" value="home">
<div class="container">
    <div class="row">
        <div id="search_form_main_container" class="col-lg-6">
            <form method="post" action="{{route('search'). ($lang!="de"? "?lang=".$lang : "")}}" class="search_form"
                  data-toggle="1">
                {{ csrf_field()  }}
                <input type="hidden" name="search_type" value="r">
                <div id="search-filter-in"
                     class="full-width  flight_search_bar_container z-index-5">
                    <div class="search-filter row no-gutters box-shadow md-tb-40px">
                        <div class="filter-tabs  col-lg-4 background-second-color">
                            <ul class="nav nav-tabs flex-column" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#home" role="tab">
                                        <i class="fas fa-plane"></i>@lang('trs.flight')</a>
                                </li>
                            </ul>
                            <div class="clearfix">
                                <div class="home_page_filter">
                                    <div class="row m-0">
                                        <div class="col-4 col-lg-12 padding-right-5px padding-left-5px">
                                            <div class="home_page_filter--item">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" name="stops0" class="custom-control-input"
                                                           id="depart_stop0" {{$setting->search_nonstop ? "checked" : ""}}>
                                                    <label class="custom-control-label"
                                                           for="depart_stop0">@lang('trs.none_stop')</label>
                                                </div>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" name="stops1" class="custom-control-input"
                                                           id="depart_stop1" {{$setting->search_one_stop ? "checked" : ""}}>
                                                    <label class="custom-control-label"
                                                           for="depart_stop1">1 @lang('trs.stop')</label>
                                                </div>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" name="stops2" class="custom-control-input"
                                                           id="depart_stop2" {{$setting->search_two_stops ? "checked" : ""}}>
                                                    <label class="custom-control-label"
                                                           for="depart_stop2">2+ @lang('trs.stops_in_Counting')</label>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-4 col-lg-12 padding-right-5px padding-left-5px">
                                            <div class="home_page_filter--item">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" name="bar0" class="custom-control-input"
                                                           id="bar0" {{$setting->search_without_bar ? "checked" : ""}}>
                                                    <label class="custom-control-label"
                                                           for="bar0">@lang('trs.without_bar')</label>
                                                </div>
                                                <div class="custom-control custom-checkbox"><input type="checkbox"
                                                                                                   name="bar1"
                                                                                                   class="custom-control-input"
                                                                                                   id="bar1" {{$setting->search_with_bar ? "checked" : ""}}>
                                                    <label class="custom-control-label"
                                                           for="bar1">@lang('trs.with_bar')</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-4 col-lg-12 padding-right-5px padding-left-5px">
                                            <div class="home_page_filter--item">
                                                <span>@lang('trs.waiting_time_search')</span>
                                                <div id="slide_filter_home" class="slide_filter slider-styled"
                                                     data-start="0"
                                                     data-end="600"
                                                     data-target="total_waiting"></div>
                                                <div class="home_page_filter--item--slide">
                                                    <input type="text" class="slide_input" id="total_waiting"
                                                           value=""
                                                           readonly>
                                                </div>

                                                <input type="hidden" name="wait0"
                                                       value="{{$setting->search_min_waiting_time*60 ?? 0}}">
                                                <input type="hidden" name="wait1"
                                                       value="{{$setting->search_max_waiting_time*60 ?? 300}}">

                                                <input type="hidden" name="max_waiting" value="1440">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="filter-output booking-form-box col-lg-8">
                            <div class="tab-content  padding-15px background-white">

                                <div class="tab-pane active" id="home" role="tabpanel">


                                    <div class="air_trip_type">
                                        <div class="row margin-right-0px margin-left-0px">
                                            <div class="col-4 way active_tab" data-toggle="R"
                                                 data-id="1">@lang('trs.round_trip')</div>
                                            <div class="col-4 way" data-toggle="O"
                                                 data-id="1">@lang('trs.one_way')</div>
                                            <div class="col-4 way" data-toggle="M"
                                                 data-id="1">@lang('trs.multi_city')</div>
                                        </div>


                                    </div>


                                    <div id="round_trip" class="custom_nav active_nav">

                                        <div class="form-group margin-bottom-5px">
                                            <label>@lang('trs.flying_from'):</label>
                                            <div class="origin"><input name="origin" type="text"
                                                                       class="input-text full-width airport_search airport_search1"
                                                                       data-validation="0" data-sec="1"
                                                                       autocomplete="off"
                                                                       placeholder="@lang('trs.flying_from')">
                                                <div class="search_result1 search_result"></div>
                                            </div>
                                        </div>
                                        <div class="form-group margin-bottom-5px">
                                            <label>@lang('trs.flying_to'):</label>
                                            <div class="destination">


                                                <input name="destination" type="text"
                                                       class="input-text full-width airport_search airport_search2"
                                                       data-validation="0" data-sec="2"
                                                       placeholder="@lang('trs.flying_to')"
                                                       autocomplete="off">

                                                <div class="search_result2 search_result"></div>

                                            </div>
                                        </div>
                                        <div class="row" style='display: flex;'>
                                            <div class="form-group col-6 round_trip1">
                                                <label>@lang('trs.depart_date') :</label>
                                                <div class="date-input full-width">
                                                    <input id="daterange1" type="text" name="daterange_d"
                                                           data-validation="1" autocomplete="off"
                                                           class="input-text full-width daterange1"
                                                           value="">
                                                </div>

                                            </div>
                                            <div class="form-group col-6 round_trip1">
                                                <label>@lang('trs.return_date') :</label>
                                                <div class="date-input full-width">
                                                    <input id="daterange2" type="text" name="daterange_r"
                                                           data-validation="1" autocomplete="off"
                                                           class="input-text full-width daterange1"
                                                           value="">
                                                </div>
                                            </div>


                                            <div class="form-group col-12 display_none one_way1">
                                                <label>@lang('trs.depart_date') :</label>
                                                <div class="date-input"><input id="date1" type="text" name="date"
                                                                               data-validation="0" autocomplete="off"
                                                                               disabled="disabled"
                                                                               class="input-text full-width date1"
                                                                               value="">
                                                </div>
                                            </div>

                                        </div>
                                        <div class="form-group margin-bottom-10px">

                                            <div class="flight_type">
                                                <select class="select_type" name="flight_class">

                                                    <option value="economy">@lang('trs.economy')</option>
                                                    <option value="premium">@lang('trs.premium')</option>
                                                    <option value="business">@lang('trs.business')</option>
                                                    <option value="first">@lang('trs.first')</option>

                                                </select>
                                            </div>

                                        </div>
                                        <div class="form-group margin-bottom-10px">

                                            <div class="flight_type">

                                                <div class="row margin-0px">

                                                    <div class="col-4 padding-right-5px padding-left-5px">

                                                        <div class="count_h">

                                                            <div
                                                                class="font-weight-600 margin-bottom-5px">@lang('trs.adults')</div>
                                                            <div class="counter_h">

                                                                <div class="count_h_up count_btn">+</div>
                                                                <input type="text" class="count_number" readonly
                                                                       value="1"
                                                                       data-min="1" data-max="9" id="adl" name="adl">
                                                                <div class="count_h_down count_btn">-</div>

                                                            </div>
                                                            <div class="age_range">(+12 @lang('trs.years'))</div>

                                                        </div>

                                                    </div>
                                                    <div class="col-4 padding-right-5px padding-left-5px">

                                                        <div class="count_h">

                                                            <div
                                                                class="font-weight-600 margin-bottom-5px">@lang('trs.children')</div>
                                                            <div class="counter_h">

                                                                <div class="count_h_up count_btn">+</div>
                                                                <input type="text" class="count_number" readonly
                                                                       value="0"
                                                                       data-min="0" data-max="8" id="chl" name="chl">
                                                                <div class="count_h_down count_btn">-</div>

                                                            </div>
                                                            <div class="age_range">(2-12 @lang('trs.years'))</div>

                                                        </div>

                                                    </div>
                                                    <div class="col-4 padding-right-5px padding-left-5px">

                                                        <div class="count_h">

                                                            <div
                                                                class="font-weight-600 margin-bottom-5px">@lang('trs.infants')</div>
                                                            <div class="counter_h">

                                                                <div class="count_h_up count_btn">+</div>
                                                                <input type="text" class="count_number" readonly
                                                                       value="0"
                                                                       data-min="0" data-max="8" id="inf" name="inf">
                                                                <div class="count_h_down count_btn">-</div>

                                                            </div>
                                                            <div class="age_range">(-2 @lang('trs.years'))</div>

                                                        </div>

                                                    </div>


                                                </div>


                                            </div>

                                        </div>
                                        <div class="form-group margin-bottom-15px user_select_none">


                                            <div class="custom-control custom-checkbox display-inline">
                                                <input type="checkbox" class="custom-control-input check_stop"
                                                       id="stop_q" name="stop_q">
                                                <label class="custom-control-label display-cell"
                                                       for="stop_q">@lang('trs.none_stop')</label>

                                            </div>

                                        </div>

                                        <button type="submit"
                                                class="btn-sm btn-lg btn-block background-main-color text-white text-center text-uppercase font-weight-600  ">
                                            <i
                                                class="fa fa-search"></i> @lang('trs.flight_search')</button>
                                    </div>

                                    <div id="multi" class="custom_nav">

                                        <div class="row">
                                            <div class="col-4">
                                                <div class="form-group margin-bottom-5px">
                                                    <label>@lang('trs.flying_from'):</label>
                                                    <div class="origin"><input name="origin1" type="text"
                                                                               class="input-text full-width airport_search airport_search3"
                                                                               data-validation="0" data-sec="3"
                                                                               autocomplete="off"
                                                                               placeholder="@lang('trs.flying_from')">
                                                        <div class="search_result3 search_result"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="form-group margin-bottom-5px">
                                                    <label>@lang('trs.flying_to'):</label>
                                                    <div class="destination">
                                                        <input name="destination1" type="text"
                                                               class="input-text full-width airport_search airport_search4"
                                                               data-validation="0" data-sec="4"
                                                               placeholder="@lang('trs.flying_to')"
                                                               autocomplete="off">

                                                        <div class="search_result4 search_result"></div>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="form-group margin-bottom-5px">
                                                    <label>@lang('trs.depart_date') :</label>
                                                    <div class="date-input"><input id="date_multi1" type="text"
                                                                                   name="date1"
                                                                                   data-validation="0"
                                                                                   autocomplete="off"
                                                                                   disabled="disabled"
                                                                                   class="input-text full-width date1 multi_date"
                                                                                   value="">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-4">
                                                <div class="form-group margin-bottom-5px">
                                                    <label>@lang('trs.flying_from'):</label>
                                                    <div class="origin"><input name="origin2" type="text"
                                                                               class="input-text full-width airport_search airport_search5"
                                                                               data-validation="0" data-sec="5"
                                                                               autocomplete="off"
                                                                               placeholder="@lang('trs.flying_from')">
                                                        <div class="search_result5 search_result"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="form-group margin-bottom-5px">
                                                    <label>@lang('trs.flying_to'):</label>
                                                    <div class="destination">


                                                        <input name="destination2" type="text"
                                                               class="input-text full-width airport_search airport_search6"
                                                               data-validation="0" data-sec="6"
                                                               placeholder="@lang('trs.flying_to')"
                                                               autocomplete="off">

                                                        <div class="search_result6 search_result"></div>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="form-group margin-bottom-5px">
                                                    <label>@lang('trs.depart_date') :</label>
                                                    <div class="date-input"><input id="date_multi2" type="text"
                                                                                   name="date2"
                                                                                   data-validation="0"
                                                                                   autocomplete="off"
                                                                                   disabled="disabled"
                                                                                   class="input-text full-width date1 multi_date"
                                                                                   value="">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="addition_multi addition_multi3">
                                            <div class="row">
                                                <div class="col-4">
                                                    <div class="form-group margin-bottom-5px">
                                                        <label>@lang('trs.flying_from'):</label>
                                                        <div class="origin"><input name="origin3" type="text"
                                                                                   class="input-text full-width airport_search airport_search7"
                                                                                   data-validation="0" data-sec="7"
                                                                                   autocomplete="off"
                                                                                   placeholder="@lang('trs.flying_from')">
                                                            <div class="search_result7 search_result"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="form-group margin-bottom-5px">
                                                        <label>@lang('trs.flying_to'):</label>
                                                        <div class="destination">


                                                            <input name="destination3" type="text"
                                                                   class="input-text full-width airport_search airport_search8"
                                                                   data-validation="0" data-sec="8"
                                                                   placeholder="@lang('trs.flying_to')"
                                                                   autocomplete="off">

                                                            <div class="search_result8 search_result"></div>

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-3">
                                                    <div class="form-group margin-bottom-5px">
                                                        <label>@lang('trs.depart_date') :</label>
                                                        <div class="date-input"><input id="date_multi3" type="text"
                                                                                       name="date3"
                                                                                       data-validation="0"
                                                                                       autocomplete="off"
                                                                                       disabled="disabled"
                                                                                       class="input-text full-width date1 multi_date"
                                                                                       value="">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-1"><p class="remove_multi" data-mul="3">x</p></div>
                                            </div>
                                        </div>
                                        <div class="addition_multi addition_multi4">
                                            <div class="row">
                                                <div class="col-4">
                                                    <div class="form-group margin-bottom-5px">
                                                        <label>@lang('trs.flying_from'):</label>
                                                        <div class="origin"><input name="origin4" type="text"
                                                                                   class="input-text full-width airport_search airport_search9"
                                                                                   data-validation="0" data-sec="9"
                                                                                   autocomplete="off"
                                                                                   placeholder="@lang('trs.flying_from')">
                                                            <div class="search_result9 search_result"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="form-group margin-bottom-5px">
                                                        <label>@lang('trs.flying_to'):</label>
                                                        <div class="destination">


                                                            <input name="destination4" type="text"
                                                                   class="input-text full-width airport_search airport_search10"
                                                                   data-validation="0" data-sec="10"
                                                                   placeholder="@lang('trs.flying_to')"
                                                                   autocomplete="off">

                                                            <div class="search_result10 search_result"></div>

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-3">
                                                    <div class="form-group margin-bottom-5px">
                                                        <label>@lang('trs.depart_date') :</label>
                                                        <div class="date-input"><input id="date_multi4" type="text"
                                                                                       name="date4"
                                                                                       data-validation="0"
                                                                                       autocomplete="off"
                                                                                       disabled="disabled"
                                                                                       class="input-text full-width date1 multi_date"
                                                                                       value="">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-1"><p class="remove_multi" data-mul="4">x</p></div>
                                            </div>
                                        </div>

                                        <div class="add_multi" data-count="2"><span>+ Add trip</span></div>


                                        <div class="form-group margin-bottom-10px">

                                            <div class="flight_type">
                                                <select class="select_type" name="flight_class">

                                                    <option value="economy">@lang('trs.economy')</option>
                                                    <option value="premium">@lang('trs.premium')</option>
                                                    <option value="business">@lang('trs.business')</option>
                                                    <option value="first">@lang('trs.first')</option>

                                                </select>
                                            </div>

                                        </div>
                                        <div class="form-group margin-bottom-10px">

                                            <div class="flight_type">

                                                <div class="row margin-0px">

                                                    <div class="col-4 padding-right-5px padding-left-5px">

                                                        <div class="count_h">

                                                            <div
                                                                class="font-weight-600 margin-bottom-5px">@lang('trs.adults')</div>
                                                            <div class="counter_h">

                                                                <div class="count_h_up count_btn">+</div>
                                                                <input type="text" class="count_number" readonly
                                                                       value="1"
                                                                       data-min="1" data-max="9" id="adl_m" name="adl_m">
                                                                <div class="count_h_down count_btn">-</div>

                                                            </div>
                                                            <div class="age_range">(+12 @lang('trs.years'))</div>

                                                        </div>

                                                    </div>
                                                    <div class="col-4 padding-right-5px padding-left-5px">

                                                        <div class="count_h">

                                                            <div
                                                                class="font-weight-600 margin-bottom-5px">@lang('trs.children')</div>
                                                            <div class="counter_h">

                                                                <div class="count_h_up count_btn">+</div>
                                                                <input type="text" class="count_number" readonly
                                                                       value="0"
                                                                       data-min="0" data-max="8" id="chl_m" name="chl_m">
                                                                <div class="count_h_down count_btn">-</div>

                                                            </div>
                                                            <div class="age_range">(2-12 @lang('trs.years'))</div>

                                                        </div>

                                                    </div>
                                                    <div class="col-4 padding-right-5px padding-left-5px">

                                                        <div class="count_h">

                                                            <div
                                                                class="font-weight-600 margin-bottom-5px">@lang('trs.infants')</div>
                                                            <div class="counter_h">

                                                                <div class="count_h_up count_btn">+</div>
                                                                <input type="text" class="count_number" readonly
                                                                       value="0"
                                                                       data-min="0" data-max="8" id="inf_m" name="inf_m">
                                                                <div class="count_h_down count_btn">-</div>

                                                            </div>
                                                            <div class="age_range">(-2 @lang('trs.years'))</div>

                                                        </div>

                                                    </div>


                                                </div>


                                            </div>

                                        </div>
                                        <div class="form-group margin-bottom-15px user_select_none">


                                            <div class="custom-control custom-checkbox display-inline">
                                                <input type="checkbox" class="custom-control-input check_stop"
                                                       id="stop_q" name="stop_q">
                                                <label class="custom-control-label display-cell"
                                                       for="stop_q">@lang('trs.none_stop')</label>

                                            </div>

                                        </div>

                                        <button type="submit"
                                                class="btn-sm btn-lg btn-block background-main-color text-white text-center text-uppercase font-weight-600  ">
                                            <i
                                                class="fa fa-search"></i> @lang('trs.flight_search')</button>
                                    </div>

                                </div>

                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>

{{--<div id="app">--}}
{{--    <search :trs="{{json_encode(trans('trs'))}}"--}}
{{--            :submit_url="{{json_encode(route('search'). ($lang!="de"? "?lang=".$lang : ""))}}"--}}
{{--            :csrf="{{json_encode(csrf_token())}}"></search>--}}
{{--</div>--}}

{{--lang for js--}}

<input type="hidden" name="lang" value="{{$lang}}">
