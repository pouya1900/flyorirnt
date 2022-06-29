<?php


$i = 1;
?>

<div class="passenger_list_container">

    <div class="passenger_list_header">

        <span>@lang('trs.your_booking_details')</span>
    </div>

    <div class="passenger_list_body passenger_table_container">

        <table class="table table-striped">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">@lang('trs.name')</th>
                <th scope="col">@lang('trs.gender')</th>
                <th scope="col">@lang('trs.passenger_type')</th>
                <th scope="col">@lang('trs.date_of_birth')</th>
                <th scope="col">@lang('trs.nationality')</th>
                @if($book["passengers"][0]["passport_number"] || $book["passengers"][0]["national_id"])
                    <th scope="col">@lang('trs.id/passport_number')</th>
                @endif
                @if($flight["IsPassportMandatory"])
                    <th scope="col">@lang('trs.expiry_date')</th>

                @endif

            </tr>
            </thead>
            <tbody>
            @foreach($book["passengers"] as $passenger)

                <tr>
                    <th scope="row">{{$i}}</th>
                    <td>{{\App\Services\MyHelperFunction::turn_title($passenger["gender"],$passenger["type"])}} {{$passenger["first_name"]}} {{$passenger["middle_name"]}} {{$passenger["last_name"]}}</td>
                    <td>{{\App\Services\MyHelperFunction::turn_gender($passenger["gender"])}}</td>
                    <td>{{\App\Services\MyHelperFunction::turn_type($passenger["type"])}}</td>
                    <td class="date_latin_font">{{date('d-m-Y',strtotime($passenger["birthday"]))}}</td>
                    <td>{{$passenger["countries"]["country_en"]}}</td>
                    @if ($passenger["passport_number"])
                        <td>{{$passenger["passport_number"]}}</td>
                    @elseif($passenger["national_id"])
                        <td>{{$passenger["national_id"]}}</td>
                    @endif
                    @if($flight["IsPassportMandatory"])

                        <td class="date_latin_font">{{date('d-m-Y',strtotime($passenger["expiry_date"]))}}</td>
                    @endif
                </tr>
                @php($i++)
            @endforeach
            </tbody>
        </table>


    </div>

    @if(url()->current()!=route('confirm_payment',["method"=>"paypal"]))

        <div class="passenger_list_header">

            <span>@lang('trs.contact_detail')</span>
        </div>

        <div class="passenger_list_body">
            <div class="passenger_list_item">


                <div class="  passenger_list_item_title">
                    <span>@lang('trs.email') : {{$book["users"]["email"]}}</span>
                </div>

                <div class="  passenger_list_item_content">
                    <span>@lang('trs.phone') : {{$book["dial_code"].$book["phone"]}}</span>
                </div>


            </div>
        </div>

    @endif

</div>