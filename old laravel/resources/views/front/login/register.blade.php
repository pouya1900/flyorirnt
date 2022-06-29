@extends('layouts.authenticate')
@section('content')

    @php
        $country_lang="country_".$lang;
    @endphp

    <section class="background-light-grey padding-tb-40px text-center text-lg-left">
        <div class="container">
            <div class="row justify-content-md-center">

                <div class="col-lg-7">
                    <div class="text-center margin-bottom-30px">
                        <a href="{{route('home'). ($lang!="de"? "?lang=".$lang : "")}}"><img
                                    src="images/{{$setting->logo}}" alt=""></a>
                    </div>
                    <div class="padding-30px background-white border-1 border-grey-1">
                        <form action="{{route('do_register'). ($lang!="de"? "?lang=".$lang : "")}}" method="post">
                            {{csrf_field()}}
                            @if (session('user_error') && session('user_error')=="exist")
                                <div class="form-group">
                                    <div class="alert alert-danger" role="alert">
                                        @lang('trs.already_registered')
                                    </div>
                                </div>
                            @endif

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-lg-3"><label for="inputEmail3"
                                                                 class="col-form-label"><strong>@lang('trs.email') *
                                            </strong></label></div>
                                    <div class="col-lg-9">
                                        <input type="text" name="email" value="{{old('email')}}"
                                               class="form-control rounded-0" id="inputEmail3"
                                               placeholder="@lang('trs.email')">
                                        @if ($errors->get('email'))
                                            <span class="error_alert">{{$errors->get('email')[0]}}</span>

                                        @endif
                                    </div>
                                </div>


                            </div>
                            <div class="form-group">

                                <div class="row">
                                    <div class="col-lg-3"><label for="f_name"
                                                                 class="col-form-label"><strong>@lang('trs.first_name')
                                                *
                                            </strong></label></div>
                                    <div class="col-lg-9"><input type="text" name="user_f_name"
                                                                 value="{{old('user_f_name')}}"
                                                                 class="form-control rounded-0" id="f_name"
                                                                 placeholder="@lang('trs.first_name')">
                                        @if ($errors->get('user_f_name'))
                                            <span class="error_alert">{{$errors->get('user_f_name')[0]}}</span>

                                        @endif</div>
                                </div>


                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-lg-3"><label for="l_name"
                                                                 class="col-form-label"><strong>@lang('trs.last_name') *
                                            </strong></label></div>
                                    <div class="col-lg-9"><input type="text" name="user_l_name"
                                                                 value="{{old('user_l_name')}}"
                                                                 class="form-control rounded-0" id="l_name"
                                                                 placeholder="@lang('trs.last_name')">
                                        @if ($errors->get('user_l_name'))
                                            <span class="error_alert">{{$errors->get('user_l_name')[0]}}</span>

                                        @endif</div>
                                </div>


                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-lg-3"><label for="gender"
                                                                 class="col-form-label"><strong>@lang('trs.gender') *
                                            </strong></label></div>
                                    <div class="col-lg-9">

                                        <select id="gender" name="user_gender" class="form-control rounded-0">
                                            <option value="0" {{old('user_gender')==0 ? "selected" : ""}} >@lang('trs.male')</option>
                                            <option value="1" {{old('user_gender')==1 ? "selected" : ""}} >@lang('trs.female')</option>
                                        </select>

                                        @if ($errors->get('user_gender'))
                                            <span class="error_alert">{{$errors->get('user_gender')[0]}}</span>

                                        @endif</div>
                                </div>


                            </div>
                            <div class="form-group">

                                <div class="row">
                                    <div class="col-lg-3"><label for="mobile"
                                                                 class="col-form-label"><strong>@lang('trs.mobile')</strong></label>
                                    </div>
                                    <div class="col-9">
                                        <div class="row ltr_persian">
                                            <div class="col-6 input-group mb-3 dial_code_container ">

                                                <select class="custom-select" name="country_dial_code"
                                                        id="country_dial_code">
                                                    <option>country</option>
                                                    @foreach($country as $item)
                                                        <option value="{{$item->dial_code}}" {{$item->code=="DE" ? "selected" : ""}}>{{$item->$country_lang!="" ? $item->$country_lang : $item->country_en}}</option>
                                                    @endforeach

                                                </select>
                                                <div class="input-group-prepend">
                                                    <label class="input-group-text" id="dial_code_label"
                                                           for="country_dial_code">+49</label>
                                                </div>
                                            </div>
                                            <div class="col-6 dial_country_container ">
                                                <input type="text" name="mobile"
                                                       value="{{old('user_mobile')}}"
                                                       class="form-control rounded-0" id="mobile"
                                                       placeholder="@lang('trs.mobile')">
                                                @if ($errors->get('user_mobile'))
                                                    <span class="error_alert">{{$errors->get('user_mobile')[0]}}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-lg-3"><label for="password"
                                                                 class="col-form-label"><strong>@lang('trs.password')
                                                *</strong></label></div>
                                    <div class="col-lg-9"><input type="password" name="password"
                                                                 class="form-control rounded-0" id="password"
                                                                 placeholder="@lang('trs.password')">
                                        @if ($errors->get('password'))
                                            <span class="error_alert">{{$errors->get('password')[0]}}</span>
                                        @endif</div>
                                </div>


                            </div>
                            <div class="form-group">

                                <div class="row">
                                    <div class="col-lg-3"><label for="confirm_password"
                                                                 class="col-form-label"><strong>@lang('trs.confirm_password')
                                                *</strong></label></div>
                                    <div class="col-lg-9"><input type="password" name="password_confirmation"
                                                                 class="form-control rounded-0"
                                                                 id="confirm_password"
                                                                 placeholder="@lang('trs.confirm_password')"></div>
                                </div>


                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-block rounded-0 background-main-color">
                                    @lang('trs.sign_up')
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="margin-bottom-20px margin-top-100px">
                        <i class="fa fa-key margin-right-10px" aria-hidden="true"></i> <strong
                                class="text-uppercase"> @lang('trs.sign_up_now')</strong>
                        <span class="d-block text-grey-2">{!! __('trs.sign_up_terms_accept',["url"=>route('privacy')]) !!}</span>
                    </div>


                    <p class="text-grey-2"></p>
                </div>

            </div>
            <!-- // row -->
        </div>
        <!-- // container -->
    </section>
@endsection