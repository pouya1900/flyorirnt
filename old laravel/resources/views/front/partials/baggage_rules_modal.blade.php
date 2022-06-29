<div class="modal fade" id="rules_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalScrollableTitle">@lang('trs.baggage_rules')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                @if(isset($rules["Success"]) && ($rules["Success"] || isset($rules["FareRuleText"]) ))

                    @if (isset($rules["BaggageInfoes"]))

                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th scope="col">@lang('trs.depart')</th>
                                <th scope="col">@lang('trs.arrival')</th>
                                <th scope="col">@lang('trs.flight_number')</th>
                                <th scope="col">@lang('trs.bar')</th>

                            </tr>
                            </thead>
                            <tbody>


                            @foreach($rules["BaggageInfoes"] as $rule)

                                <tr>
                                    <td>{{$rule["Departure"]}}</td>
                                    <td>{{$rule["Arrival"]}} </td>
                                    <td>{{$rule["FlightNo"]}} </td>
                                    <td>{{$rule["Baggage"]}} </td>
                                </tr>

                            @endforeach


                            </tbody>
                        </table>


                    @endif

                    @if (isset($rules["Services"]))
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th scope="col">@lang('trs.service')</th>
                                <th scope="col">@lang('trs.price')</th>

                            </tr>
                            </thead>
                            <tbody>


                            @foreach($rules["Services"] as $rule)

                                <tr>
                                    <td>{{$rule["Description"]}}</td>
                                    <td>{{$rule["ServiceCost"]["Amount"]}} {{$rule["ServiceCost"]["Currency"]}}</td>
                                </tr>

                            @endforeach


                            </tbody>
                        </table>

                    @endif

                    @if(isset($rules["iran_air"]))

                        <div class="rules_direction">
                            <span>
                                {{$rules["FareRuleText"]["depart"][0]}} - {{$rules["FareRuleText"]["depart"][1]}}
                            </span>
                        </div>
                        <table class="table table-striped">

                            <tbody>
                            <tr>
                                <td>
                                    {{$rules["iran_air"][0]}}
                                </td>
                            </tr>
                            </tbody>

                        </table>

                        @if ($rules["iran_air"][1])
                            <div class="rules_direction">
                            <span>
                                {{$rules["FareRuleText"]["return"][0]}} - {{$rules["FareRuleText"]["return"][1]}}
                            </span>
                            </div>
                            <table class="table table-striped">

                                <tbody>
                                <tr>
                                    <td>
                                        {{$rules["iran_air"][0]}}
                                    </td>
                                </tr>
                           
                                </tbody>

                            </table>
                        @endif

                    @endif


                @else
                    <div>
                        <p>@lang('trs.no_rules')</p>
                    </div>
                @endif

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('trs.close')</button>
            </div>
        </div>
    </div>
</div>