<div class="modal fade" id="rules_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalScrollableTitle">@lang('trs.ticket_rules')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">


                @if(isset($rules["Success"]) )

                    @if ($rules["Success"] && $rules["FareRules"])
                        @foreach($rules["FareRules"] as $kew=>$rule)

                            <div class="card">
                                <div class="rules_direction" data-toggle="collapse" data-target="#collapse{{$kew}}"
                                     aria-expanded="true" aria-controls="collapse{{$kew}}">
                                    <span>
                                        {{$rule["CityPair"] ? $rule["CityPair"] : trans("trs.ticket")}}
                                    </span>
                                </div>
                                <div id="collapse{{$kew}}" class="collapse ca_body" aria-labelledby="collapse{{$kew}}">
                                    <div class="accordion" id="accordionExample2">
                                        @foreach($rule["RuleDetails"] as $kew2=>$rule_detail)
                                            <div class="card">
                                                <div class="rules_title" data-toggle="collapse"
                                                     data-target="#collapse_{{$kew}}_{{$kew2}}"
                                                     aria-expanded="true" aria-controls="collapse_{{$kew}}_{{$kew2}}">
                                                    <span>
                                                        {{$rule_detail["Category"]}}
                                                    </span>
                                                </div>

                                                <div id="collapse_{{$kew}}_{{$kew2}}" class="collapse ca_body"
                                                     aria-labelledby="collapse_{{$kew}}_{{$kew2}}">
                                                    <div class="rules_body">
                                                        <p>
                                                            {!! $rule_detail["Rules"] !!}
                                                        </p>
                                                    </div>

                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                            </div>

                        @endforeach

                    @elseif(isset($rules["FareRuleText"]))

                        <div class="rules_direction">
                            <span>
                                {{$rules["FareRuleText"]["depart"][0]}} - {{$rules["FareRuleText"]["depart"][1]}}
                            </span>
                        </div>
                        {!! $rules["FareRuleText"]["Description"][0] !!}

                        @if ($rules["FareRuleText"]["Description"][1])
                            <div class="rules_direction">
                            <span>
                                {{$rules["FareRuleText"]["return"][0]}} - {{$rules["FareRuleText"]["return"][1]}}
                            </span>
                            </div>
                            {!! $rules["FareRuleText"]["Description"][1] !!}
                        @endif

                    @endif
                    
                @endif

                <div class="custom_rule_div">
                    <span>@lang('trs.service_fee_not_refunded_in_rule')</span>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('trs.close')</button>
            </div>
        </div>
    </div>


</div>





