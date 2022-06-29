@extends('layouts.front')
@section('content')



    <section class="padding-tb-100px">
        <div class="container {{$rtl_ignore ? "force_ltr" : ""}}" >
            {!! $text !!}
        </div>
    </section>



{{--    <section class="padding-tb-100px">--}}
{{--        <div class="container">--}}

{{--            @include('front.partials.general_errors')--}}

{{--            @if (session('message'))--}}
{{--                <div class="alert alert-primary margin-top-40px" role="alert">--}}

{{--                    {{session('message')}}--}}

{{--                </div>--}}

{{--            @elseif(session('error'))--}}
{{--                <div class="alert alert-primary margin-top-40px" role="alert">--}}

{{--                    {{session('error')}}--}}

{{--                </div>--}}
{{--            @endif--}}


{{--            <div class="row">--}}
{{--                --}}{{--                <div class="col-lg-6 col-md-6">--}}
{{--                --}}{{--                    <form action="{{route('contact.send_message')}}" method="post">--}}
{{--                --}}{{--                        {{csrf_field()}}--}}
{{--                --}}{{--                        <div class="form-row">--}}
{{--                --}}{{--                            <div class="form-group col-md-6">--}}
{{--                --}}{{--                                <label for="full_name">@lang('trs.full_name')</label>--}}
{{--                --}}{{--                                <input type="text" name="full_name" class="form-control" id="full_name" placeholder="@lang('trs.full_name')" value="{{old('full_name')}}">--}}
{{--                --}}{{--                            </div>--}}
{{--                --}}{{--                            <div class="form-group col-md-6">--}}
{{--                --}}{{--                                <label for="inputEmail4">@lang('trs.email')</label>--}}
{{--                --}}{{--                                <input type="email" name="email" class="form-control" id="inputEmail4" placeholder="@lang('trs.email')" value="{{old('email')}}">--}}
{{--                --}}{{--                            </div>--}}
{{--                --}}{{--                        </div>--}}
{{--                --}}{{--                        <div class="form-group">--}}
{{--                --}}{{--                            <label for="contact_phone">@lang('trs.phone')</label>--}}
{{--                --}}{{--                            <input type="text" name="contact_phone" class="form-control" id="contact_phone" placeholder="@lang('trs.phone')" value="{{old('phone')}}">--}}
{{--                --}}{{--                        </div>--}}

{{--                --}}{{--                        <div class="form-group">--}}
{{--                --}}{{--                            <label for="subject">@lang('trs.subject')</label>--}}
{{--                --}}{{--                            <input type="text" name="subject" class="form-control" id="subject" placeholder="@lang('trs.subject')" value="{{old('subject')}}">--}}
{{--                --}}{{--                        </div>--}}
{{--                --}}{{--                        <div class="form-group">--}}
{{--                --}}{{--                            <label for="contact_content">@lang('trs.message')</label>--}}
{{--                --}}{{--                            <textarea class="form-control" name="message" id="contact_content" rows="3" value="{{old('contact_content')}}"></textarea>--}}
{{--                --}}{{--                        </div>--}}
{{--                --}}{{--                        <input type="hidden" name="lang" value="{{$lang}}">--}}
{{--                --}}{{--                        <button type="submit"--}}
{{--                --}}{{--                           class="btn-sm btn-lg btn-block background-main-color text-white text-center font-weight-bold text-uppercase rounded-0 padding-15px">@lang('trs.send')</button>--}}
{{--                --}}{{--                    </form>--}}
{{--                --}}{{--                </div>--}}
{{--                <div class="col-lg-6 col-md-6">--}}
{{--                    <h6>--}}
{{--                        @lang('trs.contact_us_page_description')--}}
{{--                    </h6>--}}

{{--                    <h6 class="margin-top-20px">@lang('trs.site_title'):</h6>--}}
{{--                    <span class="d-block"><i class="fas fa-file-signature text-main-color margin-right-10px"></i>{{$setting->site_title}}</span>--}}
{{--                    <h6 class="margin-top-20px">@lang('trs.admin') :</h6>--}}
{{--                    <span class="d-block"><i class="fas fa-user-cog text-main-color margin-right-10px"></i>{{$setting->admin_name}}</span>--}}

{{--                    <h6 class="margin-top-20px">@lang('trs.phone') :</h6>--}}
{{--                    <span class="d-block"><i class="fa fa-phone text-main-color margin-right-10px"--}}
{{--                                             aria-hidden="true"></i>{{$setting->phone}}</span>--}}

{{--                    @if ($setting->fax)--}}
{{--                        <h6 class="margin-top-20px">@lang('trs.fax') :</h6>--}}
{{--                        <span class="d-block"><i class="fa fa-mobile text-main-color margin-right-10px"--}}
{{--                                                 aria-hidden="true"></i>{{$setting->fax}}</span>--}}
{{--                    @endif--}}

{{--                    @if ($setting->whatsapp)--}}
{{--                        <h6 class="margin-top-20px">@lang('trs.whatsapp') :</h6>--}}
{{--                        <span class="d-block"><i class="fa fa-mobile text-main-color margin-right-10px"--}}
{{--                                                 aria-hidden="true"></i>{{$setting->whatsapp}}</span>--}}
{{--                    @endif--}}


{{--                    --}}{{----}}{{--                    <h6 class="margin-top-20px">Address :</h6>--}}
{{--                    --}}{{----}}{{--                    <span class="d-block"><i class="fa fa-map text-main-color margin-right-10px" aria-hidden="true"></i>{{$setting->address}}</span>--}}

{{--                    <h6 class="margin-top-20px">@lang('trs.email') :</h6>--}}
{{--                    <span class="d-block"><i class="fa fa-envelope-open text-main-color margin-right-10px"--}}
{{--                                             aria-hidden="true"></i><a--}}
{{--                                href="mailto:{{$setting->email}}" class="text-black">{{$setting->email}}</a></span>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </section>--}}



@endsection
