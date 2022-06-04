

<div class="margin-top-50px" id="price_details{{$key}}">

    <div class="price_container">

        <div class="row">

            <div class="col-12">


                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th scope="col">@lang('trs.passengers')</th>
                        <th scope="col">@lang('trs.price') @lang('trs.per') @lang('trs.each')(€)</th>
                        <th scope="col">@lang('trs.count')</th>
                        <th scope="col">@lang('trs.price')(€)</th>

                    </tr>
                    </thead>
                    <tbody>
                    @if($item["adult"])
                        <tr>

                            <td>@lang('trs.adult')</td>
                            <td>{{round($item["FarePerAdult"])}}</td>
                            <td>{{$item["adult"]}}</td>
                            <td>{{round($item["FarePerAdult"]*$item["adult"])}}</td>

                        </tr>

                    @endif

                    @if($item["child"])
                        <tr>

                            <td>@lang('trs.child')</td>
                            <td>{{round($item["FarePerChild"])}}</td>
                            <td>{{$item["child"]}}</td>
                            <td>{{round($item["FarePerChild"]*$item["child"])}}</td>

                        </tr>

                    @endif

                    @if($item["infant"])
                        <tr>

                            <td>@lang('trs.infant')</td>
                            <td>{{round($item["FarePerInf"])}}</td>
                            <td>{{$item["infant"]}}</td>
                            <td>{{round($item["FarePerInf"]*$item["infant"])}}</td>

                        </tr>

                    @endif

                    <tr class="total_price_tax">

                        <td>@lang('trs.total_price')</td>
                        <td>-</td>
                        <td>-</td>
                        <td>{{round($item["TotalFare"])}}</td>

                    </tr>
                    </tbody>
                </table>


            </div>


        </div>

    </div>

</div>
