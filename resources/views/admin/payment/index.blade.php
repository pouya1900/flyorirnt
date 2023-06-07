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
                                <th>date</th>
                                <th>book id</th>
                                <th>book arranger name</th>
                                <th>Status</th>
                                <th>book Status</th>
                                <th>payment id</th>
                                <th>payer id</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php $i= 1; @endphp
                            @foreach ($payments as $payment)

                                <tr>
                                    <td>{{ date("Y-m-d \n H:i",strtotime($payment->updated_at)) }}</td>

                                    <td>
                                        <a href="{{route('admin.search_ticket_result',['id'=>$payment->books->id])}}"> {{$payment->books->id}}</a>
                                    </td>

                                    <td>{{$payment->books->arranger_first_name." ".$payment->books->arranger_last_name}}</td>

                                    <td>{{$payment->status}}</td>
                                    <td>{{$payment->books->status}}</td>
                                    <td>{{$payment->payment_id}}</td>
                                    <td>{{$payment->payer_id}}</td>

                                </tr>

                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>date</th>
                                <th>book id</th>
                                <th>book arranger name</th>
                                <th>Status</th>
                                <th>payment id</th>
                                <th>payer id</th>
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
