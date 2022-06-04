<div class="modal fade" id="service_detail{{$i}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header cip_modal_header">
                <h5 class="modal-title" id="exampleModalLabel">@lang('trs.service_detail')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body cip_modal_body">

                @foreach($service["description"] as $description)

                    <p>{{$description[$lang]}}</p>

                @endforeach

            </div>

        </div>
    </div>
</div>


<div class="modal fade" id="price_detail{{$i}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header cip_modal_header">
                <h5 class="modal-title" id="exampleModalLabel">@lang('trs.cip_price_detail')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body cip_modal_body">
                @if($service["passenger"])

                    <div class="cip_price_detail_item">
                        <div class="cip_price_detail_title"><span>@lang('trs.passenger')</span></div>

                        <div class="cip_price_detail_body">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th scope="col">@lang('trs.name')</th>
                                    <th scope="col">@lang('trs.price')</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>@lang('trs.adult_passenger')</td>
                                    <td>{{$service["passenger"]["adl_passenger_euro"]}}</td>

                                </tr>

                                <tr>
                                    <td>@lang('trs.child_passenger')</td>
                                    <td>{{$service["passenger"]["chl_passenger_euro"]}}</td>

                                </tr>

                                <tr>
                                    <td>@lang('trs.infant_passenger')</td>
                                    <td>{{$service["passenger"]["inf_passenger_euro"]}}</td>

                                </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>

                @endif

                @if($service["transfer"])

                    <div class="cip_price_detail_item">
                        <div class="cip_price_detail_title"><span>@lang('trs.transfer')</span></div>

                        <div class="cip_price_detail_body">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th scope="col">@lang('trs.name')</th>
                                    <th scope="col">@lang('trs.price')</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($service["transfer"] as $transfer)
                                    <tr>
                                        <td>{{$transfer["car"][$lang_name] ? $transfer["car"][$lang_name] : $transfer["car"]["name_en"]}}</td>
                                        <td>{{$transfer["costs"]["price_euro"]}}</td>

                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif
                @if($service["extra"])

                    <div class="cip_price_detail_item">
                        <div class="cip_price_detail_title"><span>@lang('trs.extra_service')</span></div>

                        <div class="cip_price_detail_body">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th scope="col">@lang('trs.name')</th>
                                    <th scope="col">@lang('trs.price')</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($service["extra"] as $extra)
                                    <tr>
                                        <td>{{$extra["name"][$lang_name] ? $extra["name"][$lang_name] : $extra["name"]["name_en"]}}</td>
                                        <td>{{$transfer["costs"]["price_euro"]}}</td>

                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif

            </div>

        </div>
    </div>
</div>