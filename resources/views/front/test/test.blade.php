@extends('layouts.front')
@section('content')


    <div id="paypal-button-container"></div>


@endsection

@section('script')
<script
    src="https://www.paypal.com/sdk/js?client-id={{$setting->payment ? env('PAYPAL_CLIENT_ID') : env('PAYPAL_TEST_CLIENT_ID')}}&currency=EUR&intent=authorize"></script>


<script>
    // Render the PayPal button into #paypal-button-container
    paypal.Buttons({


        onInit: function (data, actions) {

            // Disable the buttons
            actions.disable();

            // Listen for changes to the checkbox
            document.querySelector('#confirm')
                .addEventListener('change', function (event) {

                    // Enable or disable the button when it is checked or unchecked
                    if (event.target.checked) {
                        actions.enable();
                        $('#confirm_error').addClass('display_none');
                    } else {
                        actions.disable();
                    }
                });
        },

        // onClick is called when the button is clicked
        onClick: function () {

            // Show a validation error if the checkbox is not checked
            if (!document.querySelector('#confirm').checked) {
                document.querySelector('#confirm_error').classList.remove('display_none');
                alert("please confirm rules check box");
                $('html, body').animate({
                    scrollTop: parseInt($("#confirm_error").offset().top) - 200
                }, 500);
            }
        },


// Set up the transaction
        createOrder: function (data, actions) {

            return fetch('{{route('process_payment',['book_token'=>$book["token"]]). ($lang!="de"? "?lang=".$lang : "")}}', {
                method: 'get',
                headers: {
                    'contentType': 'application/json'
                },

            }).then(function (res) {
                return res.json();
            }).then(function (data) {
                if (!data.orderID) {

                    if (data.error == 1) {
                        window.location.replace(data.url);
                    } else if (data.error == 2) {

                        $("#validate_error_container").html(data.view);
                        $("#validate_error_modal").modal('show');
                    }

                } else {
                    return data.orderID;
                }
            });
        },

// Finalize the transaction
        onApprove: function (data, actions) {
            var page = "{{route('confirm_payment',["method"=>"paypal"])}}" + "?paymentId=" + data.orderID + "&payerID=" + data.payerID + "&" + "{{($lang!="de"? "lang=".$lang : "")}}";

            $('.booking_loader').show();

            window.location.replace(page);
        },
        onCancel: function (data) {
            var page = "{{route('cancel_payment',["book_token"=>$book["token"]]). ($lang!="de"? "?lang=".$lang : "")}}";


            window.location.replace(page);
        },
        style: {
            color: 'gold',
            shape: 'pill',
            label: 'pay',
            layout: 'vertical'
        }

    }).render('#paypal-button-container');
</script>
