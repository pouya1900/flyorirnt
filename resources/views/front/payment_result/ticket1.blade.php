@php
    $city="city_".$lang;
    $text="text_".$lang;
    $country="country_".$lang;
@endphp

<div class="{{!isset($pdf_download) || !$pdf_download ? "padding-0px ticket_pdf_font" : "ticket_container"}}">


    <div class="{{!isset($pdf_download) || !$pdf_download ? "padding-0px " : "ticket_body"}} page_break_after">

        <div class="company_container">
            <table>
                <tbody>
                <tr>
                    <td class="company_name">
                        @if ($book->users->role==\App\User::agency)
                            {{$book->users->f_name." ".$book->users->l_name}}
                        @else
                            @lang('trs.company_name')
                        @endif
                    </td>
                    <td class="company_logo_in_ticket">
                        @if ($book->users->role==\App\User::agency)
                            <img class="company_logo_image_ticket" src="images/{{$book->users->logo}}">
                        @else
                            <img class="company_logo_image_ticket" src="images/{{$setting->logo}}">
                        @endif
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="ticket_section_container">

            <div class="ticket_section_title">@lang('trs.electronic_ticket')</div>

            <div class="into_line">
                <table>
                    {{--                        <tr>--}}
                    {{--                            <td>@lang('trs.passenger'):</td>--}}
                    {{--                            <td class="ticket_bold_section">{{$passenger->first_name." ".$passenger->middle_name."".$passenger->last_name}}</td>--}}
                    {{--                        </tr>--}}
                    <tr>
                        <td>@lang('trs.airline_PNR'):</td>
                        <td class="ticket_bold_section">{{$book->airline_pnr ?: $book->UniqueId}}</td>
                    </tr>
                    <tr>
                        <td>@lang('trs.date'):</td>
                        <td class="ticket_bold_section">{{date('d.m.Y',strtotime($book->updated_at))}}</td>
                    </tr>
                    <tr>
                        <td>@lang('trs.tracking_number'):</td>
                        <td class="ticket_bold_section">{{$book->token}}</td>
                    </tr>
                </table>
            </div>
        </div>


        <div class="ticket_section_container">

            <div class="ticket_section_title">@lang('trs.passengers')</div>
            <div class="into_line">
                <div class="ticket_flight_content">

                    <table
                        class="table table-bordered {{!isset($pdf_download) || !$pdf_download ? "full-width_important" : ""}}">

                        <tr>
                            <td class="ticket_bold_section">@lang('trs.passenger_name')</td>
                            <td class="ticket_bold_section">@lang('trs.nationality')</td>
                            <td class="ticket_bold_section">@lang('trs.date_of_birth')</td>
                            <td class="ticket_bold_section">@lang('trs.E-ticket_number')</td>
                            <td class="ticket_bold_section">@lang('trs.id/passport_number')</td>
                        </tr>
                        @foreach($book->passengers as $passenger)

                            <tr>
                                <td>{{\App\Services\MyHelperFunction::turn_title($passenger->gender,$passenger->type)." ".$passenger->first_name." ".$passenger->middle_name."".$passenger->last_name}}</td>
                                <td>{{$passenger->countries->$country}}</td>
                                <td class="date_latin_font">{{$passenger["birthday"] ? date('d-m-Y',strtotime($passenger["birthday"])) : ""}}</td>
                                <td>{{$passenger->ticket_number ? : $book->ticket_number}}</td>
                                <td>{{$passenger->passport_number ? : $passenger->national_id}}</td>
                            </tr>



                        @endforeach
                    </table>
                </div>
            </div>
        </div>


        <div class="ticket_section_container">

            <div class="ticket_section_title">@lang('trs.flight_details')</div>

            <div class="into_line">

                <div class="ticket_flight_content">

                    <table class="{{!isset($pdf_download) || !$pdf_download ? "full-width_important" : ""}}">
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


                        @if ($book->flights->multi_flights)
                            @foreach($book->flights->multi_flights as $multi)
                                @foreach($multi->legs as $flight)

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
                            @endforeach
                        @endif

                    </table>

                </div>

            </div>
        </div>

        @if ($book->users->role!=\App\User::agency)
            <div class="ticket_section_container">
                <div class="ticket_section_title">@lang('trs.price_detail')</div>
                <div class="into_line">

                    <table>
                        <tr>
                            <td>@lang('trs.adult_base_price_per_each'):</td>
                            <td class="ticket_bold_section">{{round($book->flights->costs->FarePerAdult)}} €</td>
                        </tr>

                        @if ($book->flights->costs->child)
                            <tr>
                                <td>@lang('trs.child_base_price_per_each'):</td>
                                <td class="ticket_bold_section">{{round($book->flights->costs->FarePerChild)}} €</td>
                            </tr>
                        @endif

                        @if ($book->flights->costs->infant)
                            <tr>
                                <td>@lang('trs.infant_base_price_per_each'):</td>
                                <td class="ticket_bold_section">{{round($book->flights->costs->FarePerInf)}} €</td>
                            </tr>
                        @endif

                    </table>
                </div>

            </div>
        @endif

        <div class="ticket_section_container">
            <div class="ticket_section_title">@lang('trs.condition')</div>

            <div class="into_line">
                {!! $condition->$text ?  : $condition->text_en !!}
            </div>

        </div>


    </div>


    <div class="download_ticket">
        @if (isset($pdf_download) && $pdf_download==1)
            <a class="download_ticket_button" target="_blank"
               href="tickets/{{$file_name}}">@lang('trs.download_ticket_pdf')</a>
            <a class="back_to_home" href="{{route('home'). ($lang!="de"? "?lang=".$lang : "")}}">@lang('trs.home')</a>
        @endif


    </div>


</div>
