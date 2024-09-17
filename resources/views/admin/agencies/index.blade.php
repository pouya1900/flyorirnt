@extends('layouts.admin')


@section('content')
    <section class="content">

        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <!-- general form elements -->
                <div class="box box-primary box-bg with-border">
                    <div class="box-header text-center">
                        <p class="text-right">
                            <a class="btn btn-info" href="{{ url('/user/create') }}">Add User</a>
                        </p>
                    </div>
                    <div class="box-body">
                        <table id="table" class="table table-bordered dt-responsive">
                            <thead>
                            <tr>
                                <th>Sl</th>
                                <th>Name</th>
                                <th>balance</th>
                                <th>Date Created</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php $i= 1; @endphp
                            @foreach ($users as $user)

                                <tr>
                                    <td>{{ $i++ }}</td>
                                    <td>
                                        <a href="{{route('admin.search_user_result',['id'=>$user->id])}}">{{ $user->f_name }}</a>
                                    </td>
                                    <td>{{ number_format($user->balance->amount,2,',','.') }}</td>
                                    <td>{{ $user->created_at }}</td>
                                    <td class="text-center">
                                        <a class="btn btn-primary" href="{{route('admin.agency.show',$user->id)}}"
                                           style="display:inline">Edit</a>
                                    </td>

                                </tr>

                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>Sl</th>
                                <th>Name</th>
                                <th>email</th>
                                <th>Role</th>
                                <th>Date Created</th>
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

@endsection
