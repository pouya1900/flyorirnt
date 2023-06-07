@extends('layouts.pure')

@section('content')

    @if ($data)

        <div class="ads_flight_title">
            <p>
                @lang('trs.ads_flight_iframe_header')
            </p>
        </div>

        <table class="table table-striped table-bordered ads_search_table">
            <thead>
            <tr>
                <th scope="col"><img width="150px" src="images/AirlineLogo/IR.png"></th>
                @foreach($month as $row)
                    <th class="text-center" scope="col">{{$row}}</th>
                @endforeach
            </tr>
            </thead>
            <tbody>
            @foreach($data as $key=>$value)
                <tr>

                    @php($m=$first_month)

                    <th scope="row">Ab {{$key}}</th>
                    @foreach($value as $row2)
                        @php($m>12 ? $m-=12 : "")
                        @while($row2->month != $m++)
                            <td class="text-center iframe_flight">
                                -
                            </td>
                            @php($m>12 ? $m-=12 : "")
                        @endwhile
                        <td class="text-center iframe_flight">
                            <a target="_blank" href={{$row2->search_link}}>
                                <div>{{$row2->price}} €</div>
                                <div style="font-size: 13px">{{date('d.m',strtotime($row2->depart))}}
                                    - {{date('d.m',strtotime($row2->return))}}</div>
                            </a>
                            {{--                        <div class="iframe_flight_details"><p>{{$row2->depart}}</p>--}}
                            {{--                            <p>{{$row2->return}}</p></div>--}}
                        </td>

                    @endforeach
                </tr>
            @endforeach

            </tbody>
        </table>
    @endif

@endsection