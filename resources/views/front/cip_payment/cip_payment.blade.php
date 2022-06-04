@extends('layouts.front')
@section('content')

    <div class="padding-tb-40px flight_page_container ">

        <div class="container">

            <div class="">
                @include('front.cip.cip_header')
                @include('front.cip.cip_list')
            </div>

            @include('front.cip_payment.cip_passengers_list')

            <div class="payment_page_total_price">
                <div class="payment_page_total_price_float">
                    <span class="payment_page_total_price_title">@lang('trs.total'): </span>
                    <span class="payment_page_total_price_p">{{$book->price_e}} €</span>
                </div>
                <br style="clear: both">
            </div>

            @include('front.cip_payment.payment_method')
        </div>


    </div>



    @if(session('payment_error'))

        @include('front.partials.create_payment_error')

    @endif


@endsection

