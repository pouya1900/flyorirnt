<div class="">
    <div class="row">
        <div class="col-12 col-md-6 col-lg-3">

            <div class="item_container">
                <label for="">@lang('trs.number') :</label>
                <select class="passenger_form_element transfer_number_select" id="" disabled
                        name="number_transfer][{{$i}}]" data-target="{{$i}}">
                    <option value="1" {{$number==1 ? "selected" : ""}}>1</option>
                    <option value="2" {{$number==2 ? "selected" : ""}}>2</option>
                    <option value="3" {{$number==3 ? "selected" : ""}}>3</option>
                    <option value="4" {{$number==4 ? "selected" : ""}}>4</option>
                    <option value="5" {{$number==5 ? "selected" : ""}}>5</option>

                </select>
                <span class="error_alert"></span>
            </div>
        </div>
    </div>
    @for($j=0;$j<$number;$j++)
        <div class="row">

            <div class="col-12 col-md-6 col-lg-6">
                <div class="item_container">
                    <label>@lang('trs.address_can_persian'):</label>
                    <input class="passenger_form_element" type="text" disabled
                           name="address][{{$i}}][{{$j}}]"
                           placeholder="address">
                    <span class="error_alert"></span>
                </div>
            </div>

            <div class="col-12 col-md-6 col-lg-3">
                <div class="item_container">
                    <label>@lang('trs.pick_up_time'):</label>

                    <div class="row">

                        <div class="col">
                            <select name="transfer_time_hour][{{$i}}][{{$j}}]" class="passenger_form_element">
                                <option>@lang('trs.hour')...</option>
                                @for($k=0;$k<=23;$k++)
                                    <option value="{{$k}}">{{$k<10 ? "0".$k : $k}}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="col">
                            <select name="transfer_time_minute][{{$i}}][{{$j}}]" class="passenger_form_element">
                                <option>@lang('trs.minute')...</option>
                                @for($k=0;$k<=59;$k++)
                                    <option value="{{$k}}">{{$k<10 ? "0".$k : $k}}</option>
                                @endfor
                            </select>
                        </div>
                    </div>


                    <span class="error_alert"></span>
                </div>
            </div>

            <div class="col-12 col-md-6 col-lg-3">
                <div class="item_container">
                    <label>@lang('trs.ir_phone') {{$dir==1 ? "(".trans('trs.optional').")" : ""}}
                        :</label>
                    <input class="passenger_form_element" type="text" disabled
                           name="transfer_phone][{{$i}}][{{$j}}]"
                           placeholder="phone">
                    <span class="error_alert"></span>
                </div>
            </div>


        </div>

    @endfor

</div>