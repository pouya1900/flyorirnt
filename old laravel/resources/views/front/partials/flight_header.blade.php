{{--flight header --}}
<div class="flight_header">

    <div class="flight_header_container">
        <div class="row">

            <div class="col-10">

                <div class="row">

                    <div class="flight_item col">
                        <span>@lang('trs.airline')</span>
                    </div>
                    <div class="flight_item col">
                        <span>@lang('trs.flight_number')</span>
                    </div>
                    <div class="flight_item col">
                        <span>@lang('trs.flight_date')</span>
                    </div>
                    <div class="flight_item col">
                        <span>@lang('trs.enter_date')</span>
                    </div>
                    <div class="flight_item col">
                        <div class="row margin-left-0px margin-right-0px">
                            <div class="flight_item col">
                                <span>@lang('trs.duration')</span>
                            </div>

                            @if(!isset($search_data) || !$search_data["none_stop"])

                                <div class="flight_item col text-red">
                                    <span>@lang('trs.waiting')</span>
                                </div>
                            @endif

                        </div>
                    </div>
                    {{--<div class="flight_item col-2">--}}

                    {{--<div class="top_item f_t_time">--}}
                    {{--<span>--}}
                    {{--Bar--}}
                    {{--</span>--}}
                    {{--</div>--}}

                    {{--</div>--}}


                </div>

            </div>

            <div class="flight_item col-2">
                <span>@lang('trs.price')</span>
            </div>

        </div>
    </div>
</div>
{{--// flight header--}}