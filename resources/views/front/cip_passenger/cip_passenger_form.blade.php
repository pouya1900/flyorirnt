@php

    $passengers=$cip_data["adl"]+$cip_data["chl"]+$cip_data["inf"];
    $adult=$cip_data["adl"];
    $child=$cip_data["chl"];
    $infant=$cip_data["inf"];

    $dir=$services["service"][0]["dir"];
    
$country_lang="country_".$lang;

@endphp

@include('front.partials.errors')
<div class="passenger_form_main_container">
    <form id="cip_passenger_form" action="" method="post">
        {{ csrf_field()  }}
        <input type="hidden" name="count" value="{{$passengers}}">
        <input type="hidden" name="lang" value="{{$lang}}">
        <input type="hidden" name="last_date_bd" value="{{$cip_data["date"]}}">
        <input type="hidden" name="cip_airport" value="{{$airport}}">
        <input type="hidden" name="cip_airport_num" value="{{$cip_data["num"]}}">
        <input type="hidden" name="cip_dir" value="{{$services["service"][0]["dir"]}}">


        <div class="passenger_form_container">

            <div class="passenger_header">
                <span>@lang('trs.flight_details')</span>
            </div>

            <div class="passengers_body">

                <div class="passenger_content">

                    <div class="row">

                        <div class="col-12 col-md-6 col-lg-3">

                            <div class="item_container">
                                <label>@lang('trs.airline') :</label>
                                <input class="passenger_form_element airline_search" type="text" name="airline"
                                       data-validation="1" data-sec="1" autocomplete="off" readonly
                                       value="{{$airline->name.'-('.$airline->code.')'}}">
                                <span class="error_alert"></span>
                                <div class="search_result1 search_result"></div>
                            </div>
                        </div>

                        <div class="col-12 col-md-6 col-lg-3">
                            <div class="item_container">
                                <label>@lang('trs.flight_number') :</label>
                                <input class="passenger_form_element" type="text" name="flight_number"
                                       placeholder="flight number">
                                <span class="error_alert"></span>

                            </div>
                        </div>

                        <div class="col-12 col-md-6 col-lg-3">
                            <div class="item_container">
                                <label>
                                    {{$dir==1 ? trans('trs.origin') : trans('trs.destination')}}
                                </label>
                                <input class="passenger_form_element airport_search airport_search2" type="text"
                                       name="cip_front_airport"
                                       data-validation="0" data-sec="2"
                                       autocomplete="off"
                                       placeholder="{{$dir==1 ? trans('trs.origin') : trans('trs.destination')}}">
                                <div class="search_result2 search_result"></div>
                                <span class="error_alert"></span>

                            </div>
                        </div>


                        <div class="col-12 col-md-6 col-lg-3">
                            <div class="item_container">
                                <label>{{$dir==1 ? trans('trs.enter_date') : trans('trs.departure_date')}} :</label>
                                <input class="passenger_form_element date_latin_font" type="text"
                                       value="{{$cip_data["date"]}}"
                                       name="cip_date" readonly
                                       placeholder="{{$dir==1 ? trans('trs.enter_date') : trans('trs.departure_date')}}">
                                <span class="error_alert"></span>

                            </div>
                        </div>

                        <div class="col-12 col-md-6 col-lg-3">
                            <div class="item_container">
                                <label>{{$dir==1 ? trans('trs.enter_time') : trans('trs.departure_time')}} :</label>

                                <div class="row">

                                    <div class="col">
                                        <select name="cip_time_hour" class="passenger_form_element">
                                            <option>@lang('trs.hour')...</option>
                                            @for($k=0;$k<=23;$k++)
                                                <option value="{{$k}}">{{$k<10 ? "0".$k : $k}}</option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="col">
                                        <select name="cip_time_minute" class="passenger_form_element">
                                            <option>@lang('trs.minute')...</option>
                                            @for($k=0;$k<=59;$k++)
                                                <option value="{{$k}}">{{$k<10 ? "0".$k : $k}}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                                <span class="error_alert"></span>

                            </div>
                        </div>


                    </div>

                </div>
            </div>

        </div>


        @for($i=1;$i<=$passengers;$i++)

            @php

                if ($adult>0) {

                $type=trans('trs.adult');
                $type_code=1;
                $adult--;
                }

                elseif ($child>0) {
                $type=trans('trs.child');
                $type_code=2;
                $child--;
                }

                elseif ($infant>0) {
                $type=trans('trs.infant');
                $type_code=3;
                $infant--;
                }

            if (\Illuminate\Support\Facades\Auth::check()) {
            $user_check=true;
            $user=\Illuminate\Support\Facades\Auth::user();
            }
            else $user_check=false;

            @endphp


            <div class="passenger_form_container" id="pass{{$i}}">

                <div class="passenger_header">
                    <span>@lang('trs.cip_passenger') #{{$i}} {{$type}} </span>
                    <input type="hidden" name="type{{$i}}" value="{{$type_code}}">

                    @if ($user_check && $i==1)

                        <div class="use_user_info_container">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="use_user_info"
                                       name="use_user_info">
                                <label class="custom-control-label" for="use_user_info">
                                    @lang('trs.use_my_acc_info')

                                </label>
                            </div>
                        </div>
                    @endif

                </div>

                <div class="passengers_body">

                    <div class="passenger_content">


                        <div class="row">

                            <div class="col-12 col-md-6 col-lg-3">

                                <div class="item_container">
                                    <label for="gender{{$i}}">@lang('trs.gender') :</label>
                                    <select class="passenger_form_element" id="gender{{$i}}" name="gender{{$i}}"
                                            data-user="{{$user_check && $i==1 ? $user->gender : ""}}">
                                        <option value="">@lang('trs.gender')...</option>

                                        <option value="0">@lang('trs.male')</option>
                                        <option value="1">@lang('trs.female')</option>


                                    </select>
                                    <span class="error_alert"></span>
                                </div>
                            </div>

                            <div class="col-12 col-md-6 col-lg-3">
                                <div class="item_container">
                                    <label>@lang('trs.first_name') :</label>
                                    <input class="passenger_form_element" type="text" name="f_name{{$i}}"
                                           placeholder="@lang('trs.first_name')"
                                           data-user="{{$user_check && $i==1 ? $user->f_name : ""}}">
                                    <span class="error_alert"></span>

                                </div>
                            </div>

                            <div class="col-12 col-md-6 col-lg-3">
                                <div class="item_container">
                                    <label>@lang('trs.last_name') :</label>
                                    <input class="passenger_form_element" type="text" name="l_name{{$i}}"
                                           placeholder="@lang('trs.last_name')"
                                           data-user="{{$user_check && $i==1 ? $user->l_name : ""}}">
                                    <span class="error_alert"></span>

                                </div>
                            </div>

                            <div class="col-12 col-md-6 col-lg-3">
                                <div class="item_container">
                                    <label>@lang('trs.nationality') :</label>

                                    <select id="select_country" data-target="{{$i}}" class="passenger_form_element"
                                            name="country{{$i}}"
                                            data-user="{{$user_check && $i==1 ? $user->country : ""}}">
                                        <option value="">@lang('trs.nationality')...</option>

                                        <option value="DE">@lang('trs.germany')</option>
                                        @foreach($country as $item)
                                            <option value="{{$item["code"]}}">{{$item[$country_lang]!="" ? $item[$country_lang] : $item["country_en"]}}</option>
                                        @endforeach
                                    </select>
                                    <span class="error_alert"></span>

                                </div>
                            </div>

                            <div class="col-12 col-md-6 col-lg-3">
                                <div class="item_container">
                                    <label>@lang('trs.birthday') :</label>
                                    <input class="DOB_date passenger_form_element date_latin_font" type="text"
                                           name="bd{{$i}}"
                                           placeholder="@lang('trs.birthday')"
                                           data-user="{{$user_check && $i==1 && $user->birthday ? date('d.m.Y',strtotime($user->birthday)) : ""}}">
                                    <span class="error_alert"></span>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </div>

        @endfor


        {{--        host service--}}
        @if($services["service"][0]["welcome"])
            <div class="passenger_form_container">

                <div class="passenger_header_dropdown" data-toggle="collapse" href="#hosts" role="button"
                     aria-expanded="false" aria-controls="hosts">

                    <span>@lang('trs.do_you_have_host')</span>
                    <div class="cip_dropdown_sign">
                        <span class="up">▲</span>
                        <span class="down display_none">▼</span>
                    </div>

                </div>

                <div class=" collapse" id="hosts">
                    <div class="passengers_body passengers_body_dropdown">
                        <div class="passenger_content">

                            <div class="cip_service_title">
                                <p>@lang('trs.hosts_person_details') <span>({{$services["service"][0]["welcome"][0]["costs"]["price_euro"]}} € @lang('trs.per_person') )</span>
                                </p>
                            </div>

                            <div class="cip_service_body">

                                <div class="cip_host_container">
                                    @for($i=0;$i<9;$i++)
                                        <div class="row host_person_container display_none">
                                            <div class="col-12 col-md-6 col-lg-3">

                                                <div class="item_container">
                                                    <label for="host_gender{{$i}}">@lang('trs.gender') :</label>
                                                    <select class="passenger_form_element" id="host_gender{{$i}}"
                                                            name="host_gender][{{$i}}]" data-array="1" data-id="{{$i}}"
                                                            disabled>
                                                        <option value="">@lang('trs.gender')...</option>

                                                        <option value="0">@lang('trs.male')</option>
                                                        <option value="1">@lang('trs.female')</option>


                                                    </select>
                                                    <span class="error_alert"></span>
                                                </div>
                                            </div>

                                            <div class="col-12 col-md-6 col-lg-3">
                                                <div class="item_container">
                                                    <label>@lang('trs.full_name') :</label>
                                                    <input class="passenger_form_element" type="text"
                                                           name="host_full_name][{{$i}}]" data-array="1"
                                                           data-id="{{$i}}"
                                                           placeholder="@lang('trs.full_name')" disabled>
                                                    <span class="error_alert"></span>

                                                </div>
                                            </div>

                                        </div>
                                    @endfor
                                </div>

                                <div class="add_cip_person">
                                    <span><span class="add_person_sign">+</span>@lang('trs.add_person')</span>
                                </div>
                                <div class="remove_cip_person">
                                    <span><span class="remove_person_sign">-</span>@lang('trs.remove_person')</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        @endif

        @if($services["service"][0]["transfer"])
            {{--        transfr service--}}
            <div class="passenger_form_container">

                <div class="passenger_header_dropdown" data-toggle="collapse" href="#transfer" role="button"
                     aria-expanded="false" aria-controls="transfer">

                    <span>@lang('trs.do_you_need_transfer')</span>
                    <div class="cip_dropdown_sign">
                        <span class="up">▲</span>
                        <span class="down display_none">▼</span>
                    </div>

                </div>

                <div class=" collapse" id="transfer">
                    <div class="passengers_body passengers_body_dropdown">
                        <div class="passenger_content">

                            <div class="cip_service_title">
                                <span>@lang('trs.airport_transfer_service')</span>
                            </div>
                            @php
                                $i=0;
                            @endphp
                            @foreach($services["service"][0]["transfer"] as $key=>$transfer)

                                <div class="cip_service_body ">

                                    <div class="row">
                                        <div class="col-md-4 col-6">
                                            <div class="custom-control custom-checkbox fit-content">
                                                <input type="checkbox" id="cip_transfer_item{{$i}}"
                                                       name="transfer][{{$i}}]"
                                                       data-target="cip_transfer_detail{{$i}}"
                                                       class="custom-control-input cip_detail_link">
                                                <label class="custom-control-label"
                                                       for="cip_transfer_item{{$i}}">{{$transfer["car"]["name_en"]}}
                                                    <div>
                                                        <span class="transfer_price_per">+{{$transfer["costs"]["price_euro"]}} € @lang('trs.for_each_ordered_car')</span>
                                                    </div>
                                                </label>

                                            </div>
                                        </div>
                                        <div class="col-md-8 col-6">
                                            <div class="transfer_image">
                                                <img src="{{$transfer["car"]["img"]}}">
                                            </div>
                                        </div>
                                    </div>

                                    <input type="hidden" name="transfer_car_num][{{$i}}]"
                                           value="{{$key}}">
                                    <div class="transfer_form_data_container{{$i}} cip_service_detail cip_transfer_detail{{$i}} transfer_detail_body display_none">

                                        @include('front.cip_passenger.service_data',["number"=>1])
                                    </div>
                                </div>
                                @php
                                    $i++;
                                @endphp
                            @endforeach
                        </div>
                    </div>
                </div>

            </div>
        @endif

        @if($services["service"][0]["extra"])
            {{--        extra service--}}
            <div class="passenger_form_container">

                <div class="passenger_header_dropdown" data-toggle="collapse" href="#extra" role="button"
                     aria-expanded="false" aria-controls="extra">

                    <span>@lang('trs.do_you_need_extra_service')</span>
                    <div class="cip_dropdown_sign">
                        <span class="up">▲</span>
                        <span class="down display_none">▼</span>
                    </div>

                </div>

                <div class=" collapse" id="extra">
                    <div class="passengers_body passengers_body_dropdown">
                        <div class="passenger_content">

                            <div class="cip_service_title">
                                <span>@lang('trs.extra_service')</span>
                            </div>

                            @php
                                $i=0;
                            @endphp
                            @foreach($services["service"][0]["extra"] as $key=>$extra)
                                <div class="cip_service_body ">

                                    <div class="custom-control custom-checkbox fit-content">
                                        <input type="checkbox" id="cip_extra_item{{$i}}" name="extra][{{$i}}]"
                                               class="custom-control-input cip_detail_link"
                                               data-target="cip_extra_detail{{$i}}">
                                        <label class="custom-control-label"
                                               for="cip_extra_item{{$i}}">{{$extra["name"]["name_en"]}}
                                            <div>
                                                <span class="transfer_price_per">+{{$extra["costs"]["price_euro"]}} € @lang('trs.for_each_service')</span>
                                            </div>

                                        </label>
                                    </div>
                                    <div class="cip_service_detail cip_extra_detail{{$i}} display_none">
                                        <input type="hidden" name="extra_num][{{$i}}]"
                                               value="{{$key}}">
                                        <div class="row">

                                            <div class="col-12 col-md-6 col-lg-3">

                                                <div class="item_container">
                                                    <label for="">number :</label>
                                                    <select class="passenger_form_element" id="" disabled
                                                            name="number_extra][{{$i}}]">
                                                        <option value="1">1</option>
                                                        <option value="2">2</option>
                                                        <option value="3">3</option>
                                                        <option value="4">4</option>
                                                        <option value="5">5</option>

                                                    </select>
                                                    <span class="error_alert"></span>
                                                </div>
                                            </div>

                                        </div>

                                    </div>

                                </div>

                                @php
                                    $i++;
                                @endphp
                            @endforeach
                        </div>
                    </div>
                </div>

            </div>
        @endif

        {{--contact info--}}
        <div class="passenger_form_container">

            <div class="passenger_header">
                <span>@lang('trs.contact_info')</span>
            </div>

            <div class="passengers_body">

                <div class="passenger_content">


                    <div class="row">

                        <div class="col-12 col-md-6 col-lg-4">

                            <div class="item_container">
                                <label>@lang('trs.contact_person') :</label>
                                <select class="passenger_form_element" name="contact" id="contact_person">

                                    @for($j=1;$j<=$cip_data["adl"];$j++)
                                        <option value="{{$j}}">@lang('trs.adult') #{{$j}}</option>
                                    @endfor
                                    <option value="0">@lang('trs.arranger')</option>
                                </select>
                                <span class="error_alert"></span>

                            </div>
                        </div>
                    </div>

                    <div id="arranger_name">
                        <div class="row">

                            <div class="col-12 col-md-6 col-lg-4">
                                <div class="item_container">
                                    <label>@lang('trs.first_name') :</label>
                                    <input class="passenger_form_element" type="text" name="arranger_first_name"
                                           placeholder="@lang('trs.first_name')">
                                    <span class="error_alert"></span>

                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-4">
                                <div class="item_container">
                                    <label>@lang('trs.last_name') :</label>
                                    <input class="passenger_form_element" type="text" name="arranger_last_name"
                                           placeholder="@lang('trs.last_name')">
                                    <span class="error_alert"></span>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">


                        <div class="col-12 col-md-8 col-lg-6">
                            <div class="item_container">
                                <label>@lang('trs.Phone_number') :</label>
                                <div class="row ltr_persian">
                                    <div class="col-6 input-group mb-3 dial_code_container ">

                                        <select class="custom-select arranger_dial_code" name="country_dial_code"
                                                id="country_dial_code">
                                            <option>country</option>
                                            @foreach($country as $item)
                                                <option value="{{$item["dial_code"]}}" {{$item["code"]=="DE" ? "selected" : ""}}>{{$item[$country_lang]!="" ? $item[$country_lang] : $item["country_en"]}}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="input-group-prepend">
                                            <label class="input-group-text" id="dial_code_label"
                                                   for="country_dial_code">+49</label>
                                        </div>
                                    </div>
                                    <div class="col-6 dial_country_container ">

                                        <input class="passenger_form_element" type="text" name="phone"
                                               placeholder="@lang('trs.Phone_number')">

                                    </div>
                                </div>
                                <span class="error_alert"></span>
                                <p>@lang('trs.enter_contact')</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">

                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="item_container">
                                <label>@lang('trs.email') :</label>
                                <input class="passenger_form_element" type="email" name="email"
                                       placeholder="@lang('trs.email')"
                                       value="{{$user_check ? $user->email : ""}}" {{$user_check ? "readonly" : ""}}>
                                <span class="error_alert"></span>
                                <p>@lang('trs.login_and_see_history')</p>


                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
        {{-- //contact info--}}

        <div class="submit_passenger_form">

            <button id="cip_passengers_submit" type="submit">@lang('trs.continue')</button>

        </div>

    </form>
</div>
