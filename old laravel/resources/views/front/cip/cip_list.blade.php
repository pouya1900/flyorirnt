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

        <div class="cip_container padding-0px margin-bottom-0px">
            <div class="cip-post  with-hover box-shadow-hover ">

                <div class="cip_post_container">
                    <div class="row">

                        <div class="col-12 col-md-9">

                            <div class="row d-md-none">
                                <div class="col-9"></div>
                                <div class="cip_item col-3 deal_button_cip_md_d">
                                    @if(\Illuminate\Support\Facades\Route::currentRouteName()=="CIPs")

                                        <a href="{{route('cip_passengers',$cip_data). ($lang!="de"? "?lang=".$lang : "")}}">
                                            <span>{{round($service["passenger"]["adl_passenger_euro"])}} € </span>
                                            <i class="fas fa-long-arrow-alt-right"></i>
                                        </a>
                                    @endif
                                </div>
                            </div>


                            <div class="row">
                                <div class="cip_item col-6">
                                    <span>{{$services["name"][$lang_name] ? $services["name"][$lang_name] : $services["name"]["name_en"]}} {{$service["type"]}}</span>
                                </div>
                                <div class="cip_item col-3">
                                    <span>
                                          @if($service["tripe_type"]==1)
                                            <i class="fas fa-globe"></i>
                                        @else
                                            <i class="fas fa-flag-alt"></i>
                                        @endif
                                        {{\App\Services\MyHelperFunction::turn_cip_tripe_type($service["tripe_type"])}}</span>
                                </div>
                                <div class=" cip_item col-3">
                                    <span>
                                        @if($service["dir"]==1)
                                            <i class="fas fa-plane-arrival"></i>
                                        @else
                                            <i class="fas fa-plane-departure"></i>
                                        @endif

                                        {{\App\Services\MyHelperFunction::turn_cip_type($service["dir"])}}</span>
                                </div>
                            </div>

                            <div class="cip_details">

                                <div class="rules">


                                    <div>
                                    <span class="all_details_link" data-toggle="modal"
                                          data-target="#price_detail{{$i}}">
                                            <i class="fas fa-suitcase"></i>
                                        <span class="d-none d-md-inline">@lang('trs.cip_price_detail')</span>
                                    </span>
                                    </div>
                                    <div>
                                        <span class="all_details_link" data-toggle="modal"
                                              data-target="#service_detail{{$i}}"><i
                                                    class="fas fa-ticket-alt"></i>
                                            <span class="d-none d-md-inline">@lang('trs.cip_service_details')</span>
                                        </span>
                                    </div>

                                </div>


                            </div>

                        </div>

                        <div class="d-none d-md-block col-md-3 deal_container">


                            <div class="deal_content">
                                <div class="deal_price_total">
                                    <span>{{round($service["passenger"]["adl_passenger_euro"])*$cip_data["adl"] + round($service["passenger"]["chl_passenger_euro"])*$cip_data["chl"] + round($service["passenger"]["inf_passenger_euro"])*$cip_data["inf"]}} €</span>
                                </div>
                                @if ($cip_data["adl"]>1 || $cip_data["chl"]>0 || $cip_data["inf"]>0)
                                    <div class="deal_price_detail">
                                        <span>{{round($service["passenger"]["adl_passenger_euro"])}} € @lang('trs.p.a')</span>
                                    </div>
                                @endif


                                @if(\Illuminate\Support\Facades\Route::currentRouteName()=="CIPs")
                                    <a href="{{route('cip_passengers',$cip_data). ($lang!="de"? "?lang=".$lang : "")}}">
                                        <div class="deal_button">@lang('trs.deal')</div>
                                    </a>
                                @endif

                            </div>


                        </div>


                    </div>


                </div>
            </div>
        </div>

        @include("front.cip.cip_details")


    @endif
@endforeach