@php
    $passengers=$flight["adult"]+$flight["child"]+$flight["infant"];
    $adult=$flight["adult"];
    $child=$flight["child"];
    $infant=$flight["infant"];

$country_lang="country_".$lang;

@endphp

@include('front.partials.errors')
<div class="passenger_form_main_container">
    <form id="passenger_form" action="" method="post">
        {{ csrf_field()  }}
        <input type="hidden" name="token" value="{{$flight["token"]}}">
        <input type="hidden" name="count" value="{{$passengers}}">
        <input type="hidden" name="lang" value="{{$lang}}">
        <input type="hidden" name="domestic" value="{{$domestic}}">
        <input type="hidden" name="last_date_bd"
               value="{{$flight["DirectionInd"]==2 ? $flight["return_depart_time"] : $flight["depart_time"]}}">
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
                    <span>@lang('trs.passenger') #{{$i}} {{$type}} </span>
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
                                    <label>@lang('trs.birthday') :</label>
                                    <input class="DOB_date passenger_form_element date_latin_font" type="text"
                                           name="bd{{$i}}"
                                           placeholder="@lang('trs.birthday')"
                                           data-user="{{$user_check && $i==1 && $user->birthday ? date('d.m.Y',strtotime($user->birthday)) : ""}}">
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


                            @if($flight["IsPassportMandatory"])
                                <div class="col-12 col-md-6 col-lg-3" id="passport_exp_div{{$i}}">
                                    <div class="item_container">
                                        <label>@lang('trs.expiry_date_of_passport') :</label>
                                        <input class="EXP_date passenger_form_element date_latin_font" type="text"
                                               name="exp{{$i}}"
                                               placeholder="@lang('trs.expiry_date_of_passport')">
                                        @if(! $flight["IsPassportMandatory"])
                                            <span>mandatory 0</span>
                                        @endif
                                        <span class="error_alert"></span>
                                    </div>
                                </div>
                            @endif

                            @if($flight["IsPassportIssueDateMandatory"])
                                <div class="col-12 col-md-6 col-lg-3" id="passport_issue_div{{$i}}">
                                    <div class="item_container">
                                        <label>@lang('trs.issue_date_of_passport') :</label>
                                        <input class="DOB_date passenger_form_element date_latin_font" type="text"
                                               name="iss{{$i}}"
                                               placeholder="@lang('trs.issue_date_of_passport')">
                                        <span class="error_alert"></span>
                                    </div>
                                </div>
                            @endif

                            @if($flight["IsPassportNumberMandatory"])
                                <div class="col-12 col-md-6 col-lg-3" id="passport_number_div{{$i}}">
                                    <div class="item_container">
                                        <label>@lang('trs.pass_number') :</label>
                                        <input class="passenger_form_element" type="text" name="pass_number{{$i}}"
                                               placeholder="@lang('trs.pass_number')"
                                               data-user="{{$user_check && $i==1 ? $user->pass_number : ""}}">
                                        <span class="error_alert"></span>

                                    </div>
                                </div>
                            @endif

                            <div class="col-12 col-md-6 col-lg-3 display_none" id="national_id_div{{$i}}">
                                <div class="item_container">
                                    <label>@lang('trs.national_id_number') :</label>
                                    <input class="passenger_form_element" type="text" name="nid{{$i}}"
                                           placeholder="@lang('trs.national_id_number')">
                                    <span class="error_alert"></span>

                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        @endfor

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

                                    @for($j=1;$j<=$flight["adult"];$j++)
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
                                    <input class="passenger_form_element" type="text"
                                           name="arranger_first_name"
                                           placeholder="@lang('trs.first_name')">
                                    <span class="error_alert"></span>

                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-4">
                                <div class="item_container">
                                    <label>@lang('trs.last_name') :</label>
                                    <input class="passenger_form_element" type="text"
                                           name="arranger_last_name"
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

                                        <select class="custom-select arranger_dial_code"
                                                name="country_dial_code"
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
                                        <span class="error_alert"></span>

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

            <button id="passengers_submit" type="submit">@lang('trs.continue')</button>

        </div>

    </form>
</div>