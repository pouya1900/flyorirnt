@php($counter=0)
<div class="{{\Illuminate\Support\Facades\Route::currentRouteName()!='payment' ? "collapse" : ""}}"
     id="price_details{{(!isset($search_data) || isset($search_data["main_vendor"])) ? 0 : $search_data["render"]}}_{{$key}}">

    <div class="price_container">

        <div class="row">

            <div class="col-12 price_table_container">


                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th scope="col">@lang('trs.passengers')</th>
                        <th scope="col">@lang('trs.per_person')</th>
                        <th scope="col">@lang('trs.base_price')</th>
                        <th scope="col">@lang('trs.taxes_and_fees')</th>
                        {{--                        <th scope="col">@lang('trs.service_fee')</th>--}}
                        <th scope="col">@lang('trs.count')</th>
                        <th scope="col">@lang('trs.price')</th>

                    </tr>
                    </thead>
                    <tbody>
                    @if($item["adult"])
                        <tr>

                            <td>@lang('trs.adult')</td>
                            {{--                            <td>{{round($item["FarePerAdult"])}}</td>--}}
                            <td>{{$item["FarePerAdult"]}}</td>
                            <td>{{$item["FarePerAdult"] - $item["taxAdult"] - $item["serviceAdult"]}}</td>
                            <td>{{$item["taxAdult"]+$item["serviceAdult"]}}</td>
                            {{--                            <td>{{$item["serviceAdult"]}}</td>--}}
                            <td>{{$item["adult"]}}</td>
                            <td>{{$item["FarePerAdult"]*$item["adult"]}}</td>

                        </tr>

                    @endif

                    @if($item["child"])
                        <tr>
                            <td>@lang('trs.child')</td>
                            <td>{{$item["FarePerChild"]}}</td>
                            <td>{{$item["FarePerChild"] - $item["taxChild"] - $item["serviceChild"]}}</td>
                            <td>{{$item["taxChild"]+$item["serviceChild"]}}</td>
                            {{--                            <td>{{$item["serviceChild"]}}</td>--}}
                            <td>{{$item["child"]}}</td>
                            <td>{{$item["FarePerChild"]*$item["child"]}}</td>

                        </tr>

                    @endif

                    @if($item["infant"])
                        <tr>
                            <td>@lang('trs.infant')</td>
                            <td>{{$item["FarePerInf"]}}</td>
                            <td>{{$item["FarePerInf"] - $item["taxInfant"] - $item["serviceInfant"]}}</td>
                            <td>{{$item["taxInfant"]+$item["serviceInfant"]}}</td>
                            {{--                            <td>{{$item["serviceInfant"]}}</td>--}}
                            <td>{{$item["infant"]}}</td>
                            <td>{{$item["FarePerInf"]*$item["infant"]}}</td>
                        </tr>

                    @endif

                    <tr class="total_price_tax">

                        <td>@lang('trs.total_price')</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>{{$item["FarePerAdult"]*$item["adult"] + $item["FarePerChild"]*$item["child"] + $item["FarePerInf"]*$item["infant"]}}</td>

                    </tr>
                    </tbody>
                </table>


            </div>


        </div>

    </div>

</div>
