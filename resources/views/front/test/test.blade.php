@extends('layouts.front')
@section('content')


    <div id="paypal-button-container"></div>


@endsection

@section('script')
<script
    src="https://www.paypal.com/sdk/js?client-id=AWeqpdmml9cx4sL1JUkcJebiwrciRfoam8nHRtDe5Kmmz5QNLEGmJGjGUrw4J3SjziDwAdEPDsGsh4ps"></script>


<script>
    // Render the PayPal button into #paypal-button-container
    paypal.Buttons({
        style: {
            color: 'gold',
            shape: 'pill',
            label: 'pay',
            layout: 'vertical'
        }

    }).render('#paypal-button-container');
</script>
@endsection
