@extends('layouts.front')
@section('content')

    <div class="airlines_list_page_container">
        <div class="container">

            <div class="airline_input_content">
                <input class="form-control" id="myInput" type="text" placeholder="Search..">
            </div>

            <div class="row">


                @foreach($airlines as $airline)

                    <div class="col-12 col-md-6 col-lg-4 airline_list_page_content">
                        <a href="{{$airline->agb}}">
                            <table>
                                <thead>
                                <tr>
                                    <th>
                                <img src="images/{{$airline->image}}">
                                    </th>
                                    <th>
                                <span>
                                    {{$airline->name}}
                                </span>
                                    </th>
                                </tr>
                                </thead>
                            </table>
                        </a>
                    </div>

                @endforeach
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $("#myInput").on("keyup", function () {
            var value = $(this).val().toLowerCase();
            $(".airline_list_page_content").filter(function () {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });

    </script>
@endsection