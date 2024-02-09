@extends('layouts.pure')
@section('content')
    @php
        $city="city_".$lang;
        $text="text_".$lang;
        $country="country_".$lang;
    @endphp
    <div class="padding-0px ticket_pdf_font">

        <div class="padding-0px page_break_after">
            <div class="ticket_section_container">
                <table class="full-width_important invoice_table">
                    <tbody>
                    <tr>
                        <td><img src="images/{{$setting->logo}}"></td>
                        <td class="text-grey-3">
                            <p>{{$setting->site_title}}</p>
                            <p>Dr. Rezai Afshar, Saeed</p>
                            <p>Business Center Seestern</p>
                            <p>Fritz-Vomfelde-Str. 34</p>
                            <p>40547-Düssedlorf</p>
                            <p>Deutschland</p>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td class="text-grey-3">
                            <p>Tel. +49-(0) 211-174 202 89</p>
                            <p>E-mail: info@flyorient.de</p>
                            <p>Ust-IdNr. DE246790812</p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p>An:</p>
                            <p>{{$book->users->f_name}}</p>
                            <p>{{$book->users->address}}</p>
                        </td>
                        <td class="text-grey-3">
                            <p>Bankverbindung:</p>
                            <p>Konto Inhaber: Dr. Rezai Afshar, Saeed</p>
                            <p>Postbank Dortmund</p>
                            <p>IBAN: DE55 4401 0046 0732 6504 64</p>
                            <p>BIC: PBNKDEFF</p>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="ticket_section_container">

                <div class="ticket_section_title">@lang('trs.electronic_invoice')</div>

                <div class="into_line">
                    <table>
                        {{--                        <tr>--}}
                        {{--                            <td>@lang('trs.passenger'):</td>--}}
                        {{--                            <td class="ticket_bold_section">{{$passenger->first_name." ".$passenger->middle_name."".$passenger->last_name}}</td>--}}
                        {{--                        </tr>--}}

                        <tr>
                            <td>@lang('trs.issued_date'):</td>
                            <td class="ticket_bold_section">{{date('d.m.Y',strtotime($book->payments->created_at))}}</td>
                        </tr>
                        <tr>
                            <td>@lang('trs.invoice_number'):</td>
                            <td class="ticket_bold_section">{{$invoice_number}}</td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="ticket_section_container">

                <div class="ticket_section_title">@lang('trs.flight_details')</div>

                <div class="into_line">

                    <div class="ticket_flight_content">

                        <table class="full-width_important">
                            @foreach($book->flights->legs as $flight)

                                {{--                    <div class="ticket_flight_container">--}}
                                <tbody>
                                <tr>
                                    <td>
                                        <div class="ticket_flight_direction"><span>{{$flight->leg_depart_airport}} To {{$flight->leg_arrival_airport}}  | @lang('trs.flight_number'):{{$flight->leg_flight_number}}</span>
                                        </div>
                                    </td>
                                </tr>


                                <tr>
                                    <td>@lang('trs.airline')</td>
                                    <td>@lang('trs.flight_number') / @lang('trs.aircraft_type')</td>
                                    <td>@lang('trs.cabin')</td>
                                    <td>@lang('trs.bar')</td>
                                </tr>
                                <tr>
                                    <td class="ticket_bold_section"><img class="ticket_flight_logo"
                                                                         src="images/{{$flight->airlines->image}}">{{$flight->airlines->name}}
                                    </td>
                                    <td class="ticket_bold_section">{{$flight->leg_flight_number}}
                                        / {{$flight->aircraft_type}}</td>
                                    <td class="ticket_bold_section">{{\App\Services\MyHelperFunction::turn_class($flight->cabin_class)}} </td>
                                    <td class="ticket_bold_section">{{$flight->leg_bar}}</td>
                                </tr>

                                <tr>
                                    <td>@lang('trs.departure'): <span
                                                class="ticket_bold_section">{{$flight->airports1->name}}</span>
                                        ({{$flight->airports1->code}}
                                        ,{{$flight->airports1->$city ? : $flight->airports1->city_en}}
                                        ,{{$flight->airports1->$country ? : $flight->airports1->country_en}})
                                    </td>
                                    <td>@lang('trs.date'): <span
                                                class="ticket_bold_section">{{date('d.m.Y',strtotime($flight->leg_depart_time))}}</span>
                                    </td>
                                    <td>@lang('trs.time'): <span
                                                class="ticket_bold_section">{{date('H:i',strtotime($flight->leg_depart_time))}}</span>
                                    </td>
                                    {{--                                    <td>Departure Terminal: I</td>--}}
                                </tr>

                                <tr>
                                    <td>@lang('trs.arrival'): <span
                                                class="ticket_bold_section">{{$flight->airports2->name}}</span>
                                        ({{$flight->airports2->code}}
                                        ,{{$flight->airports2->$city ? : $flight->airports2->city_en}}
                                        ,{{$flight->airports2->$country ? : $flight->airports2->country_en}})
                                    </td>
                                    <td>@lang('trs.date'): <span
                                                class="ticket_bold_section">{{date('d.m.Y',strtotime($flight->leg_arrival_time))}}</span>
                                    </td>
                                    <td>@lang('trs.time'): <span
                                                class="ticket_bold_section">{{date('H:i',strtotime($flight->leg_arrival_time))}}</span>
                                    </td>
                                    {{--                                    <td>Departure Terminal: I</td>--}}
                                </tr>
                                </tbody>
                                {{--                    </div>--}}

                            @endforeach
                        </table>

                    </div>

                </div>
            </div>
            <div class="ticket_section_container">

                <div class="ticket_section_title">@lang('trs.passengers')</div>
                <div class="into_line">
                    <div class="ticket_flight_content">

                        <table class="table table-bordered full-width_important">

                            <tr>
                                <td class="ticket_bold_section">@lang('trs.passenger_name')</td>
                                <td class="ticket_bold_section">@lang('trs.date_of_birth')</td>
                                <td class="ticket_bold_section">@lang('trs.E-ticket_number')</td>
                                <td class="ticket_bold_section">@lang('trs.price')</td>
                            </tr>
                            @foreach($book->passengers as $passenger)

                                <tr>
                                    <td>{{\App\Services\MyHelperFunction::turn_title($passenger->gender,$passenger->type)." ".$passenger->first_name." ".$passenger->middle_name."".$passenger->last_name}}</td>
                                    <td class="date_latin_font">{{$passenger["birthday"] ? date('d-m-Y',strtotime($passenger["birthday"])) : ""}}</td>
                                    <td>{{$passenger->ticket_number ? : $book->ticket_number}}</td>
                                    @if($passenger->type==1)
                                        <td>{{round($book->flights->costs->FarePerAdult - $book->flights->costs->AgencyCommissionAdult)}}
                                            €
                                        </td>
                                    @elseif($passenger->type==2)
                                        <td>{{round($book->flights->costs->FarePerChild - $book->flights->costs->AgencyCommissionChild)}}
                                            €
                                        </td>
                                    @else
                                        <td>{{round($book->flights->costs->FarePerInf - $book->flights->costs->AgencyCommissionInfant)}}
                                            €
                                        </td>
                                    @endif

                                </tr>



                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
            <div class="ticket_section_container">
                <div class="ticket_section_title">@lang('trs.price_detail')</div>
                <div class="into_line">

                    <table>
                        <tr>
                            <td>@lang('trs.total_price')</td>
                            <td class="ticket_bold_section">{{round($book->flights->costs->TotalFare - $book->flights->costs->TotalAgencyCommission)}}
                                €
                            </td>
                        </tr>

                    </table>
                </div>

            </div>

            <div class="ticket_section_container">
                <div class="invoice_payment">
                    <p>{{trans('trs.invoice_payment_text',['amount'=>round($book->flights->costs->TotalFare - $book->flights->costs->TotalAgencyCommission)])}}</p>
                    <p>Postbank Dortmund</p>
                    <p>@lang('trs.account_holder'): Dr. Rezai Afshar, Saeed</p>
                    <p>IBAN: DE55 4401 0046 0732 6504 64</p>
                    <p>@lang('trs.purpose'): {{$invoice_number}}</p>
                </div>
            </div>

        </div>

    </div>

@endsection