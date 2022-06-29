@php

    $lang_name="name_".$lang;
        $i=0;
@endphp
@foreach($services["service"] as $key=>$service)
    @if ($service["status"] && $service["dir"]==$dir && $service["tripe_type"]==$type)

        @php
            $i++;
        $cip_data["num"]=$key;
        @endphp

        <div class="cip_ticket_details">
            <span>@lang('trs.cip_service_details')</span>
        </div>

        <div class="cip_container padding-0px margin-bottom-0px margin-top-20px">
            <div class="cip-post  with-hover box-shadow-hover ">


                <table class="table table-bordered text-center">
                    <thead>
                    <tr>
                        <th scope="col">@lang('trs.service_type')</th>
                        <th scope="col">@lang('trs.tripe_type')</th>
                        <th scope="col">@lang('trs.flight_type')</th>
                    </tr>
                    </thead>

                    <tbody>

                    <tr>
                        <td>{{$services["name"][$lang_name] ? $services["name"][$lang_name] : $services["name"]["name_en"]}} {{$service["type"]}}</td>
                        <td>@if($service["tripe_type"]==1)
                                <i class="fas fa-globe"></i>
                            @else
                                <i class="fas fa-flag-alt"></i>
                            @endif
                            {{\App\Services\MyHelperFunction::turn_cip_tripe_type($service["tripe_type"])}}</td>
                        <td>@if($service["dir"]==1)
                                <i class="fas fa-plane-arrival"></i>
                            @else
                                <i class="fas fa-plane-departure"></i>
                            @endif

                            {{\App\Services\MyHelperFunction::turn_cip_type($service["dir"])}}</td>
                    </tr>

                    </tbody>
                </table>


            </div>
        </div>



    @endif
@endforeach