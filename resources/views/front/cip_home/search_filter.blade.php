@php
    $count=0;
        foreach($cip_airports as $cip_item) {

        if ($cip_item["status"]) {

            $count++;
            $one_item=$cip_item;
        }

    }

@endphp


<div class="cip_bar_container">
    <div class="container">
        <div class="row justify-content-center">
            <div class="cip_bar_content col-10">

                <form method="post" action="{{route('cip_search'). ($lang!="de"? "?lang=".$lang : "")}}"
                      class="cip_search_form">
                    @if ($setting->cip_active)
                        {{ csrf_field()  }}
                    @endif
                    <div class="row justify-content-center">


                        <div class="col-12 col-lg-2 cip_search_item">
                            <div class="custom-control custom-radio">
                                <input type="radio" id="cip_dir_from" name="cip_dir" value="2" checked
                                       class="custom-control-input cip_dir_input">
                                <label class="custom-control-label" for="cip_dir_from">@lang('trs.flight_from')</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input type="radio" id="cip_dir_to" name="cip_dir" value="1"
                                       class="custom-control-input cip_dir_input">
                                <label class="custom-control-label" for="cip_dir_to">@lang('trs.flight_to')</label>
                            </div>
                        </div>

                        <div class="col-12 col-lg-3 cip_search_item cip_airport cip_airport_origin">
                            <input name="cip_airport" type="text"
                                   class="input-text full-width airport_search cip_search"
                                   data-validation="{{$count==1 ? 1 : 0}}" data-sec="1"
                                   autocomplete="off"
                                   placeholder="@lang('trs.flying_from')"
                                   @if($count==1)
                                   data-country="{{$one_item["country"]["name_en"]}}" data-code="{{$one_item["code"]}}"
                                   value="{{$one_item["name"]["name_en"]."-(".$one_item["code"].")"}}"
                                    @endif>

                            <div class="search_result_cip display_none">

                                <div class="search_box">

                                    @foreach($cip_airports as $cip_item)
                                        @if ($cip_item["status"])
                                            <div class="airport_item"
                                                 onclick="select_airport_cip(this,'{{$cip_item["country"]["name_en"]}}')">

                                                <div class="row margin-right-0px margin-left-0px">
                                                    <div class="col-1 padding-top-10px padding-right-0px padding-left-0px">
                                                        <i class="fas fa-plane"></i>

                                                    </div>
                                                    <div class="col-10 airport_name_container padding-right-0px">
                                                                    <span data-code="{{$cip_item["code"]}}"
                                                                          class="airport_option airport_name">{{$cip_item["name"]["name_en"]}}</span>
                                                        <span class="airport_city_name">{{$cip_item["name"]["name_en"]}}-{{$cip_item["country"]["name_en"]}}</span>

                                                    </div>
                                                    <div class="col-1 airport_code_container padding-right-0px padding-left-0px">
                                                        <span class="airport_code">{{$cip_item["code"]}}</span>

                                                    </div>
                                                </div>

                                            </div>
                                        @endif
                                    @endforeach

                                </div>
                            </div>


                        </div>
                        <div class="col-12 col-lg-3 cip_search_item cip_date date_latin_font">
                            <input class="passenger_form_element airline_search" type="text" name="airline"
                                   data-validation="0" data-sec="1" autocomplete="off"
                                   placeholder="@lang('trs.airline')">
                            <div class="search_result1 search_result"></div>

                        </div>
                        <div class="col-12 col-lg-2 cip_search_item cip_date date_latin_font">
                            <input type="text" autocomplete="off" placeholder="@lang("trs.date")" id="date1"
                                   name="cip_date">
                        </div>
                        <div class="col-12 col-lg-2 cip_search_item search-filter counter_container ">
                            <input type="text" id="cip_count_button" value="1 {{trans('trs.passenger')}}" readonly>

                            <div class="flight_type ">
                                <div class="cip_count_container">
                                    <div class="row margin-0px ">

                                        <div class="col-4 padding-right-5px padding-left-5px">

                                            <div class="count_h">

                                                <div class="font-weight-600 margin-bottom-5px">@lang('trs.adults')</div>
                                                <div class="counter_h">

                                                    <div class="count_h_up count_btn">+</div>
                                                    <input type="text" class="count_number" readonly value="1"
                                                           data-min="1" data-max="9" id="adl" name="adl">
                                                    <div class="count_h_down count_btn">-</div>

                                                </div>
                                                <div class="age_range">(+12 @lang('trs.years'))</div>

                                            </div>

                                        </div>
                                        <div class="col-4 padding-right-5px padding-left-5px">

                                            <div class="count_h">

                                                <div class="font-weight-600 margin-bottom-5px">@lang('trs.children')</div>
                                                <div class="counter_h">

                                                    <div class="count_h_up count_btn">+</div>
                                                    <input type="text" class="count_number" readonly value="0"
                                                           data-min="0" data-max="8" id="chl" name="chl">
                                                    <div class="count_h_down count_btn">-</div>

                                                </div>
                                                <div class="age_range">(2-12 @lang('trs.years'))</div>

                                            </div>

                                        </div>
                                        <div class="col-4 padding-right-5px padding-left-5px">

                                            <div class="count_h">

                                                <div class="font-weight-600 margin-bottom-5px">@lang('trs.infants')</div>
                                                <div class="counter_h">

                                                    <div class="count_h_up count_btn">+</div>
                                                    <input type="text" class="count_number" readonly value="0"
                                                           data-min="0" data-max="8" id="inf" name="inf">
                                                    <div class="count_h_down count_btn">-</div>

                                                </div>
                                                <div class="age_range">(-2 @lang('trs.years'))</div>

                                            </div>

                                        </div>


                                    </div>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" id="cip_type_int" name="cip_type" value="1" checked
                               class="custom-control-input">
                        <div class="col-lg-1"></div>
                        <div class="col-12 col-lg-10">
                              <span class="error_alert">
                               @include('front.partials.errors')
                            </span>
                        </div>
                        <div class="col-lg-1"></div>

                        <div class="col-lg-1"></div>

                        @if ($setting->cip_active)
                            <div class="col-12 col-lg-10 cip_date_alarm">
                                <span>@lang('trs.cip_max_date_message') {{date('d.m.Y',strtotime($cip_max_time))}}</span>
                            </div>
                        @else
                            <div class="col-12 col-lg-10 cip_date_alarm">
                                <span>@lang('trs.cip_not_active_at_this_time')</span>
                            </div>
                        @endif

                        <div class="col-lg-1"></div>

                        @if ($setting->cip_active)
                            <div class="col-12 col-lg-6 cip_search_item justify-content-center">
                                <button type="submit"
                                        class="cip_search_button btn-sm btn-lg btn-block background-main-color text-white text-center text-uppercase font-weight-600  ">
                                    <i
                                            class="fa fa-search"></i> @lang('trs.search')</button>
                            </div>
                        @endif

                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

