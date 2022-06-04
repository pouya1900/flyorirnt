@extends('layouts.admin')


@section('content')
    <section class="content">

        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="box box-primary box-bg with-border">
                    <div class="box-body">
                        <div>
                            <p>
                                Grouped By
                            </p>
                        </div>
                        <div>
                            <form action="{{route('admin.analyze')}}" method="get">
                                <div>
                                    <input type="checkbox" id="origin"
                                           name="origin" {{$origin_g ? "checked" : ""}}>
                                    <label for="origin">origin</label>
                                </div>
                                <div>
                                    <input type="checkbox" id="destination"
                                           name="destination" {{$destination_g ? "checked" : ""}}>
                                    <label for="destination">destination</label>
                                </div>
                                <div>
                                    <button type="submit">filter</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 ">
                <!-- general form elements -->
                <div class="box box-primary box-bg with-border">

                    <div class="box-body">
                        <table id="table" class="table table-bordered dt-responsive">
                            <thead>
                            <tr>
                                <th>origin</th>
                                <th>destination</th>
                                @if (!$origin_g && !$destination_g)
                                    <th>depart</th>
                                    <th>return</th>
                                    {{--                                    <th>class</th>--}}
                                    <th>ns</th>
                                    <th>ad</th>
                                    <th>ch</th>
                                    <th>in</th>
                                    <th>Date</th>
                                @endif
                                @if ($origin_g || $destination_g)
                                    <th>count</th>
                                @endif
                            </tr>
                            </thead>
                            <tbody>
                            @php $i= 1; @endphp
                            @foreach ($searches as $search)
                                @if(! $search->user || $search->user->role<3)

                                    <tr>
                                        <td>
                                            <a href="{{route('admin.analyze',["origin_search"=>$search->origin_code])}}"> {{$destination_g && !$origin_g ? "-" : $search->origin_code}}
                                            </a>
                                        </td>
                                        <td>
                                            <a href="{{route('admin.analyze',["destination_search"=>$search->destination_code])}}">{{$origin_g && !$destination_g ? "-" : $search->destination_code}}
                                            </a>
                                        </td>
                                        @if (!$origin_g && !$destination_g)
                                            <td>{{$search->depart_date }}</td>
                                            <td>{{$search->return_date ?? "-"}}</td>
                                            {{--                                        <td>{{$search->class}}</td>--}}
                                            <td>{{$search->is_none_stop}}</td>
                                            <td>{{$search->adult}}</td>
                                            <td>{{$search->child}}</td>
                                            <td>{{$search->infant}}</td>
                                            <td>
                                                <p>{{date('Y-m-d',strtotime($search->created_at))}}</p>
                                                <p>{{date('H:i',strtotime($search->created_at))}}</p>
                                            </td>
                                        @endif
                                        @if ($origin_g || $destination_g)
                                            <th>
                                                @if ($origin_g && $destination_g)
                                                    <a href="{{route('admin.analyze',["destination_search"=>$search->destination_code,"origin_search"=>$search->origin_code])}}">
                                                        {{$search->total}}
                                                    </a>
                                                @else
                                                    {{$search->total}}

                                                @endif
                                            </th>
                                        @endif
                                    </tr>
                                @endif
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>origin</th>
                                <th>destination</th>
                                <th>depart</th>
                                <th>return</th>
                                {{--                                <th>class</th>--}}
                                <th>ns</th>
                                <th>ad</th>
                                <th>ch</th>
                                <th>in</th>
                                <th>Date</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <!-- /.box -->

            </div>
        </div>

    </section>
@endsection



@section('script')

@endsection
