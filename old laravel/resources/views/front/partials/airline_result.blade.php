

@php
    $n=sizeof($airlines);
@endphp

@if($n>0)

    <div class="search_box" >

        @foreach($airlines as $item)
            @php
                $item=(array) $item;
            @endphp
            <div class="airport_item" onclick="select_airline({{$sec}},this)">

                <div class="row margin-right-0px margin-left-0px">
                    <div class="col-1 padding-top-10px padding-right-0px padding-left-0px">
                        <i class="fas fa-plane"></i>

                    </div>
                    <div class="col-10 airport_name_container padding-right-0px">
                        <span data-code="{{$item["code"]}}" class="airport_option airport_name" >{{$item["name"]}}</span>

                    </div>
                    <div class="col-1 airport_code_container padding-right-0px padding-left-0px">
                        <span class="airport_code">{{$item["code"]}}</span>

                    </div>
                </div>

            </div>
        @endforeach
    </div>
@endif


