@extends('layouts.pure')
@section('content')

    <div class="">

        <div class="{{!isset($pdf_download) || !$pdf_download ? "padding-0px ticket_pdf_font" : "ticket_container"}}">


            <div class="{{!isset($pdf_download) || !$pdf_download ? "padding-0px " : "ticket_body"}} page_break_after">

                <div class="company_container">
                    <table>
                        <tbody>
                        <tr>
                            <td class="company_name">
                                @lang('trs.company_name')
                            </td>
                            <td class="company_logo_in_ticket">
                                <img class="company_logo_image_ticket" src="images/{{$setting->logo}}">
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="ticket_section_container">

                    <div class="ticket_section_title">@lang('trs.electronic_ticket')</div>

                    <div class="into_line">
                        <table>
                            <tr>
                                <td>@lang('trs.E-ticket_number'):</td>
                                <td class="ticket_bold_section">{{$book->ticket_number}}</td>
                            </tr>
                            <tr>
                                <td>@lang('trs.tracking_number'):</td>
                                <td class="ticket_bold_section">{{$book->token}}</td>
                            </tr>
                            <tr>
                                <td>@lang('trs.date'):</td>
                                <td class="ticket_bold_section">{{date('d.m.Y',strtotime($book->updated_at))}}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="cip_list_container">
                    @include('front.cip_payment_result.cip_list')
                </div>

                @include('front.cip_payment.cip_passengers_list')
            </div>
            <div class="download_ticket">

                @if (isset($pdf_download) && $pdf_download==1)
                    <a class="download_ticket_button" target="_blank"
                       href="tickets/cip_tickets/{{$file_name}}">@lang('trs.download_ticket_pdf')</a>
                    <a class="back_to_home"
                       href="{{route('home'). ($lang!="de"? "?lang=".$lang : "")}}">@lang('trs.home')</a>
                @endif
            </div>
        </div>


    </div>

@endsection

