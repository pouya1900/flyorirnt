@extends('layouts.pure')
@section('content')

    @if (!isset($booked) || !$booked)
        <div class="container">

            <div class="alert alert-primary margin-top-40px" role="alert">

@lang('trs.booking_confirmation')            </div>
        </div>


    @endif

    @include('front.payment_result.ticket1')
@endsection