@extends('layouts.admin')

@section('content')
    <section class="content">

        <div class="row">
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary box-bg with-border">
                    <div class="box-header text-center">
                        <p class="text-right">
                            <a class="btn btn-info" href="{{ url('/user/create') }}">Add User</a>
                        </p>
                    </div>
                    <div class="box-body">
                        <table id="table" class="table table-bordered dt-responsive tickets_table">
                            <thead>
                            <tr>
                                <th>Issued date</th>
                                <th>token</th>
                                <th>Status</th>
                                <th>Arranger name</th>
                                <th>Ticket number</th>
                                <th>Flight number</th>
                                <th>CIP airport</th>
                                <th>Passengers</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php $i= 1; @endphp
                            @foreach ($books as $book)

                                <tr>
                                    <td>{{ date("Y-m-d \n H:i",strtotime($book->created_at)) }}</td>
                                    <td>
                                        {{$book->token}}
                                    </td>
                                    <td>
                                        <a href="{{route('admin.cip_search_ticket_result',[ 'id'=>$book->id ])}}">{{ $book->status }}</a>
                                    </td>
                                    <td>
                                        {{ $book->arranger_first_name." ".$book->arranger_last_name }}
                                    </td>
                                    <td>
                                        {{ $book->ticket_number }}
                                    </td>
                                    <td>{{ $book->flight_number }}</td>
                                    <td>{{ $book->cip_airport }}</td>
                                    <td>
                                        @php($j=0)
                                        @foreach($book->cip_passengers as $passenger)
                                            {{$j>0 ? " , " : ""}}
                                            {{$passenger->first_name." ".$passenger->last_name}}
                                            @php($j++)
                                        @endforeach
                                    </td>
                                    <td class="text-center">

                                        @if($book->status=="booked" || $book->status=="wait_for_ticket")
                                            <a class="btn" href="{{route('home')."/tickets/cip_tickets/".$book->token.".pdf"}}"
                                               style="display:inline">Download</a>
                                        @endif
                                        {{--                                        <a class="btn btn-danger" data-id="{{ $book->id }}" style="display:inline">Delete</a>--}}
                                    </td>

                                </tr>

                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>Issued date</th>
                                <th>token</th>
                                <th>Status</th>
                                <th>Arranger name</th>
                                <th>Ticket number</th>
                                <th>Flight number</th>
                                <th>CIP airport</th>
                                <th>Passengers</th>
                                <th>Action</th>
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
    <script type="text/javascript" charset="UTF-8">
        $(document).on('click', '.btn-danger', function (e) {
            e.preventDefault();
            var id = $(this).data('id');
            var auth = "<?php echo \Illuminate\Support\Facades\Auth::user()->id; ?>";
            if (id != auth) {
                swal({
                        title: "Are you sure!",
                        text: "You want to Delete This User Account?",
                        type: "error",
                        confirmButtonClass: "btn-danger",
                        confirmButtonText: "Yes!",
                        confirmButtonColor: "#DD6B55",
                        showCancelButton: true,
                    },
                    function () {
                        $.ajaxSetup({
                            headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')}
                        });
                        $.ajax({
                            type: "Post",
                            url: "{{url('user/delete')}}",
                            data: {id: id},
                            success: function (res) {
                                console.log(res);
                                swal({
                                    type: 'success',
                                    title: 'Succesfully deleted!!',
                                    text: "You have successfully Deleted this!",
                                    showConfirmButton: false,
                                    timer: 5000
                                });
                                location.reload();
                            }
                        });
                    });
            } else {
                swal({
                    title: "Sorry Dear!",
                    text: "You can not Delete your own Account.",
                    type: "info",
                    showConfirmButton: false,
                    timer: 3500
                });
            }
        });
    </script>
@endsection
