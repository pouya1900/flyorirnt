@extends('layouts.admin')
@section('content')

    @if ($payment_schedulers)
        <div class="row">
            @foreach($payment_schedulers as $payment_scheduler)
                <div class="col-md-6">
                    <div class="alert alert-danger" role="alert">
                        <h4 class="alert-heading">Payment alert!</h4>

                        <ul>
                            <li>
                                Payment_id : {{$payment_scheduler->payment->payment_id}}
                            </li>
                            <li>
                                Payer_id : {{$payment_scheduler->payment->payer_id}}
                            </li>
                            <li>
                                text response : <p>{{$payment_scheduler->failed_response}}</p>
                            </li>
                        </ul>

                    </div>
                </div>
            @endforeach
        </div>
    @endif
@endsection