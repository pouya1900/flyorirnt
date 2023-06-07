@extends('layouts.front')
@section('content')

    <div class="padding-tb-40px flight_page_container ">

        <div class="container">
            <div class="flight_post_body_wide">
                <div class="flights_container">
                    @include('front.partials.flight')
                </div>
            </div>            @include('front.payment.passengers_list')
            @if ($flight['airports1']['country']=="IR" || $flight['airports2']['country']=="IR")
                @include('front.payment.payment_method')
            @else
                <div >
                    <p>@lang('trs.online_ticket_not_active')</p>
                </div>
            @endif
        </div>




    </div>

    {{--rules modal container--}}
    <div id="rules_modal_container"></div>
    <div id="validate_error_container"></div>


    @if(session('payment_error'))

        @include('front.partials.create_payment_error')

    @endif


@endsection

@section('script')
    @include('front.passenger.script')
@endsection