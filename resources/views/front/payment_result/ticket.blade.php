<div class="{{!isset($pdf_download) || !$pdf_download ? "padding-0-imp" : "ticket_container"}}">


    <div class="{{!isset($pdf_download) || !$pdf_download ? "padding--20-imp" : "ticket_body"}}">

        <div class="ticket_details">


            <div class="left_detail">
                @if ($book["ticket_number"])
                    <span>@lang('trs.E-ticket_number') : {{$book["ticket_number"]}}</span>

                @else

                    <span>@lang('trs.airline_PNR') : {{$book["airline_pnr"]}}</span>

                @endif

            </div>

            <div class=" center_detail">
                <span>flyorient.de</span>
            </div>

            {{--            booked by commented :............................................. --}}
                            <div class="right_detail">
                                <span>@lang('trs.tracking_number') : {{$book["token"]}}</span>
                            </div>
            {{--            booked by commented :............................................. --}}


        </div>
        <br style="clear: both">
        <div class="flight_post_body_wide">
            <div class="flights_container">
                {{--                @include('front.payment_result.flight')--}}
                @include('front.payment_result.flight')
            </div>
        </div>

        @include('front.payment.passengers_list')


    </div>

    @if (isset($pdf_download) && $pdf_download==1)
        <div class="download_ticket">

            <a href="tickets/{{$file_name}}">@lang('trs.download_ticket_pdf')</a>

        </div>
    @endif

</div>
