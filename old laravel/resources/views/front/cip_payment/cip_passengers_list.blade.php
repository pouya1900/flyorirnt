<?php


$i = 1;
?>

<div class="passenger_list_container">


    <div class="passenger_list_header">

        <span>@lang('trs.your_flight_details')</span>
    </div>

    <div class="passenger_list_body passenger_table_container">

        <table class="table table-bordered text-center">
            <thead>
            <tr>
                <th scope="col">@lang('trs.airline')</th>
                <th scope="col">@lang('trs.flight_number')</th>
                <th scope="col">{{$dir==1 ? trans('trs.origin') : trans('trs.destination')}}</th>
                <th scope="col">{{$dir==1 ? trans('trs.enter_date') : trans('trs.departure_date')}}</th>
                <th scope="col">{{$dir==1 ? trans('trs.enter_time') : trans('trs.departure_time')}}</th>
            </tr>
            </thead>
            <tbody>

            <tr>
                <td>{{$book->airlines->name}}</td>
                <td>{{$book->flight_number}}</td>
                <td>{{$book->airports->name}}</td>
                <td class="date_latin_font">{{date('d-m-Y',strtotime($book->date_time))}}</td>
                <td>{{date('H:i',strtotime($book->date_time))}}</td>
            </tr>


            </tbody>
        </table>


    </div>


    <div class="passenger_list_header">

        <span>@lang('trs.your_booking_details')</span>
    </div>

    <div class="passenger_list_body passenger_table_container">

        <table class="table table-bordered text-center">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">@lang('trs.name')</th>
                <th scope="col">@lang('trs.gender')</th>
                <th scope="col">@lang('trs.passenger_type')</th>
                <th scope="col">@lang('trs.date_of_birth')</th>
                <th scope="col">@lang('trs.nationality')</th>
                <th scope="col">@lang('trs.price')</th>
            </tr>
            </thead>
            <tbody>
            @foreach($book->cip_passengers as $passenger)

                <tr>
                    <th scope="row">{{$i}}</th>
                    <td>{{\App\Services\MyHelperFunction::turn_title($passenger->gender,$passenger->type)}} {{$passenger->first_name}} {{$passenger->last_name}}</td>
                    <td>{{\App\Services\MyHelperFunction::turn_gender($passenger->gender)}}</td>
                    <td>{{\App\Services\MyHelperFunction::turn_type($passenger->type)}}</td>
                    <td class="date_latin_font">{{date('d-m-Y',strtotime($passenger->birthday))}}</td>
                    <td>{{$passenger->countries->country_en}}</td>
                    <td>{{$passenger->price_e}}</td>
                </tr>
                @php($i++)
            @endforeach
            </tbody>
        </table>


    </div>

    {{--    host section--}}
    @php($i = 1)
    @if($host)
        <div class="passenger_list_header">

            <span>@lang('trs.hosts_details')</span>
        </div>

        <div class="passenger_list_body">
            <div class="passenger_list_item">

                <table class="table table-bordered text-center">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">@lang('trs.name')</th>
                        <th scope="col">@lang('trs.price')</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($host as $service)

                        <tr>
                            <th scope="row">{{$i}}</th>
                            <td>{{$service->full_name}}</td>
                            <td>{{$service->price_e}}</td>
                        </tr>
                        @php($i++)

                    @endforeach
                    </tbody>
                </table>

            </div>
        </div>

    @endif
    {{--end host--}}

    {{--    transfer section--}}
    @php($i = 1)
    @if($transfer)
        <div class="passenger_list_header">

            <span>@lang('trs.transfer_details')</span>
        </div>

        <div class="passenger_list_body">
            <div class="passenger_list_item">

                <table class="table table-bordered text-center">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">@lang('trs.car_name')</th>
                        <th scope="col">@lang('trs.address')</th>
                        <th scope="col">@lang('trs.time')</th>
                        <th scope="col">@lang('trs.phone')</th>
                        <th scope="col">@lang('trs.price')</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($transfer as $service)

                        <tr>
                            <th scope="row">{{$i}}</th>
                            <td>{{$service->transfer}}</td>
                            <td>{{$service->address}}</td>
                            <td>{{$service->time}}</td>
                            <td>{{$service->phone}}</td>
                            <td>{{$service->price_e}}</td>
                        </tr>
                        @php($i++)

                    @endforeach
                    </tbody>
                </table>

            </div>
        </div>

    @endif
    {{--end transfer--}}

    {{--    extra section--}}
    @php($i = 1)
    @if($extra)
        <div class="passenger_list_header">

            <span>@lang('trs.extra_details')</span>
        </div>

        <div class="passenger_list_body">
            <div class="passenger_list_item">

                <table class="table table-bordered text-center">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">@lang('trs.name')</th>
                        <th scope="col">@lang('trs.number')</th>
                        <th scope="col">@lang('trs.price')</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($extra as $service)

                        <tr>
                            <th scope="row">{{$i}}</th>
                            <td>{{$service->extra}}</td>
                            <td>{{$service->number}}</td>
                            <td>{{$service->price_e}}</td>
                        </tr>
                        @php($i++)

                    @endforeach
                    </tbody>
                </table>

            </div>
        </div>

    @endif
    {{--    end extra--}}

    @if(url()->current()!=route('cip_confirm_payment',["method"=>"paypal"]))

        <div class="passenger_list_header">

            <span>@lang('trs.contact_detail')</span>
        </div>

        <div class="passenger_list_body">
            <div class="passenger_list_item">


                <div class="  passenger_list_item_title">
                    <span>@lang('trs.email') : {{$book->users->email}}</span>
                </div>

                <div class="  passenger_list_item_content">
                    <span>@lang('trs.phone') : {{$book->dial_code.$book->phone}}</span>
                </div>


            </div>
        </div>

    @endif
</div>