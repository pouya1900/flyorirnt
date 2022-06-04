@extends('layouts.admin')

@section('content')
    <section class="content">

        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                @if (session('message'))
                    <div class="form-group">
                        <div class="alert alert-success" role="alert">
                            {{session('message')}}
                        </div>
                    </div>
            @endif
                <!-- general form elements -->
                <div class="box box-primary box-bg with-border">
                    <div class="box-header text-center">
                        <p class="text-right">
                            <a class="btn btn-info" href="{{route('admin.add_post')}}">Add post</a>
                        </p>
                    </div>
                    <div class="box-body">
                        <table id="table" class="table table-default table-bordered dt-responsive">
                            <thead>
                            <tr>
                                <th class="all">id</th>
                                <th class="all">Name</th>
                                <th class="all">Title</th>
                                <th class="all">Image</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($posts as $post)
                                <tr class="text-center">
                                    <td class="all">{{ $post->id }}</td>
                                    <td class="all">{{ $post->post_name }}</td>
                                    <td class="all">{{ $post->post_title_en }}</td>
                                    <td class="all"><img src="images/{{ $post->post_image }}" alt="{{ $post->post_name }}" style="height: 40px; width: 40px">
                                    </td>
                                    <td class="text-center">
                                        <a class="btn btn-info" href="{{route('admin.edit_post',['id'=>$post->id])}}" style="display:inline">Edit</a>
                                        <a class="btn btn-danger"  data-id="{{$post->id}}" data-target="posts" style="display:inline">Delete</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <th class="all">id</th>
                                <th class="all">Name</th>
                                <th class="all">Title</th>
                                <th class="all">Image</th>
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
    </script>
@endsection
