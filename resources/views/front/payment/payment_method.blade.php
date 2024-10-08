<form action="{{route('process_payment',['book_token'=>$book["token"]]). ($lang!="de"? "?lang=".$lang : "")}}"
      method="post">
    {{csrf_field()}}
    <div class="payment_method_container">

        <div class="confirm_rules">

            <div class="custom-control custom-checkbox ">
                <input type="checkbox" class="custom-control-input" id="confirm" name="confirm" required>
                <label class="custom-control-label" for="confirm">@lang('trs.confirm_rules')</label>
                <a href="{{route('airlines.index'). ($lang!="de"? "?lang=".$lang : "")}}" target="_blank"
                   class="payment_agb_link">@lang('trs.agb_of_airlines') <i class="fas fa-external-link-alt"></i></a>
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
                            {{$flight["TotalFare"]}} {{$flight["Currency"]}}
                        </span>
                    </div>

                    <div class="col-8 payment_cell">

                        @if ($agency)
                            <div class="agency-button-container">
                                <div>
                                    @if(intval($agency["balance"]) >= intval($flight["TotalFare"]))

                                        <a href="{{$agency["link"]}}">@lang('trs.pay_with_balance')</a>

                                    @else
                                        <span class="opacity-5">@lang('trs.pay_with_balance')</span>
                                    @endif
                                </div>

                            </div>
                        @endif


                        <div id="paypal-button-container"></div>


                    </div>

                </div>

            </div>
        </div>

    </div>


</form>


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
