<form action="{{route('cip_process_payment',['book_token'=>$book->token]). ($lang!="de"? "?lang=".$lang : "")}}" method="post">
    {{csrf_field()}}
    <div class="payment_method_container">

        <div class="confirm_rules">

            <div class="custom-control custom-checkbox ">
                <input type="checkbox" class="custom-control-input" id="confirm" name="confirm" required>
                <label class="custom-control-label" for="confirm">@lang('trs.confirm_rules')</label>
                <p id="confirm_error" class="display_none">@lang('trs.check_checkbox')</p>

            </div>

        </div>


        <div class="payment_method_table">
            <div class="payment_method_header">

                <div class="row">
                    <div class="col-4 payment_cell">
                        <span>@lang('trs.price')</span>
                    </div>
                    <div class="col-8 payment_cell">
                        <span>@lang('trs.payment_method')</span>
                    </div>
                </div>

            </div>

            <div class="payment_method_body">

                <div class="row">

                    <div class="col-4 payment_cell payment_price">
<span>
{{$book->price_e}} EUR
</span>
                    </div>

                    <div class="col-8 payment_cell">

                        <div id="paypal-button-container"></div>


                    </div>

                </div>

            </div>
        </div>

    </div>


</form>


<script src="https://www.paypal.com/sdk/js?client-id={{$setting->payment ? env('PAYPAL_CLIENT_ID') : env('PAYPAL_TEST_CLIENT_ID')}}&currency=EUR"></script>


<script>
    // Render the PayPal button into #paypal-button-container
    paypal.Buttons({


        onInit: function(data, actions) {

            // Disable the buttons
            actions.disable();

            // Listen for changes to the checkbox
            document.querySelector('#confirm')
                .addEventListener('change', function(event) {

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
        onClick: function() {

            // Show a validation error if the checkbox is not checked
            if (!document.querySelector('#confirm').checked) {
                document.querySelector('#confirm_error').classList.remove('display_none');
                alert("please confirm rules check box");
                $('html, body').animate({
                    scrollTop: parseInt($("#confirm_error").offset().top)-200
                }, 500);
            }
        },


// Set up the transaction
        createOrder: function (data, actions) {

            return fetch('{{route('cip_process_payment',['book_token'=>$book->token]). ($lang!="de"? "?lang=".$lang : "")}}', {
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
                    }

                    else if (data.error == 2) {

                        $("#validate_error_container").html(data.view);
                        $("#validate_error_modal").modal('show');
                    }

                }
                else {
                    return data.orderID;
                }
            });
        },

// Finalize the transaction
        onApprove: function (data, actions) {
            var page = "{{route('cip_confirm_payment',["method"=>"paypal"])}}" + "?paymentId=" + data.orderID + "&payerID=" + data.payerID + "&" + "{{($lang!="de"? "lang=".$lang : "")}}";

            $('.booking_loader').show();

            window.location.replace(page);
        },
        onCancel: function (data) {
            var page = "{{route('cip_cancel_payment',["book_token"=>$book->token]). ($lang!="de"? "?lang=".$lang : "")}}";


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