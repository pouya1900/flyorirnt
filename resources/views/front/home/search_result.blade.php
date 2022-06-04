

    @php
        $n=sizeof($airports);
        $city="city_".$lang;
        $country="country_".$lang;
    @endphp

    @if($n>0)

    <div class="search_box" >
    @for ($i=0;$i<$n;$i++)

        @php
        $airport=(array) $airports[$i];
        @endphp

        @if($airport["is_city"])

            @php
            $name=$airport["name"];
            if ($airport["code"]=="IST") $name="Istanbul-All Airports";
            elseif ($airport["code"]=="DXB") $name="dubai-All Airports";
            @endphp

            <div class="airport_item" onclick="select_airport({{$sec}},this,'{{$airport["country"]}}')">
                <div class="row margin-right-0px margin-left-0px">
                    <div class="col-1 padding-top-10px padding-right-0px padding-left-0px">
                        <i class="fas fa-city"></i>

                    </div>
                    <div class="col-10 airport_name_container padding-right-0px">
                        <span data-code="{{$airport["code"]}}" class="airport_option airport_name" >{{$name}}</span>
                        <span class="airport_city_name">{{$airport[$city]!="" ? $airport[$city] : $airport["city_en"]}}-{{$airport[$country]!="" ? $airport[$country] : $airport["country_en"]}}</span>

                    </div>
                    <div class="col-1 airport_code_container padding-right-0px padding-left-0px">
                        <span class="airport_code">{{$airport["code"]}}</span>

                    </div>
                </div>
                    </div>
            @php
                $id=$airport["id"];
                \array_splice($airports, $i, 1);
                $n--;
                $i--;
            @endphp

            @for($j=0;$j<$n;$j++)
                    @php
                        $airport2=(array) $airports[$j];
                    @endphp


                @if($airport2["city_id"]==$id)
                        <div class="airport_item "  onclick="select_airport({{$sec}},this,'{{$airport2["country"]}}')">

                            <div class="row margin-right-0px margin-left-0px">
                                <div class="col-1 padding-top-10px padding-right-0px padding-left-0px sub_set">
                                    <i class="fas fa-plane"></i>

                                </div>
                                <div class="col-10 airport_name_container padding-right-0px sub_set">
                                    <span data-code="{{$airport2["code"]}}" class="airport_option airport_name" >{{$airport2["name"]}}</span>
                                    <span class="airport_city_name">{{$airport2[$city]!="" ? $airport2[$city] : $airport2["city_en"]}}-{{$airport2[$country]!="" ? $airport2[$country] : $airport2["country_en"]}}</span>

                                </div>
                                <div class="col-1 airport_code_container padding-right-0px padding-left-0px">
                                    <span class="airport_code">{{$airport2["code"]}}</span>

                                </div>
                            </div>


                        </div>
                    @php
                        \array_splice($airports, $j, 1);
                        $n--;
                        $j--;
                    @endphp

                @endif
            @endfor

        @endif

    @endfor

    @foreach($airports as $item)
            @php
                $item=(array) $item;
            @endphp
            <div class="airport_item" onclick="select_airport({{$sec}},this,'{{$item["country"]}}')">

                <div class="row margin-right-0px margin-left-0px">
                    <div class="col-1 padding-top-10px padding-right-0px padding-left-0px">
                        <i class="fas fa-plane"></i>

                    </div>
                    <div class="col-10 airport_name_container padding-right-0px">
                        <span data-code="{{$item["code"]}}" class="airport_option airport_name" >{{$item["name"]}}</span>
                        <span class="airport_city_name">{{$item[$city]!="" ? $item[$city] : $item["city_en"]}}-{{$item[$country]!="" ? $item[$country] : $item["country_en"]}}</span>

                    </div>
                    <div class="col-1 airport_code_container padding-right-0px padding-left-0px">
                        <span class="airport_code">{{$item["code"]}}</span>

                    </div>
                </div>

            </div>
    @endforeach
    </div>
        @endif

    @php

@endphp

