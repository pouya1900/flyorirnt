@extends('layouts.admin')

@section('content')
    <section class="content">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
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
                            <a class="btn btn-info" href="{{ route('admin.posts') }}">Post List</a>
                        </p>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form method="post" action="{{route('admin.update_post')}}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="box-body">
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>id</label>
                                            <input type="text" class="form-control" name="id" readonly
                                                   value="{{ $post->id }}">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Name</label>
                                            <input type="text" class="form-control" name="name"
                                                   value="{{ $post->post_name }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="image">Image</label>
                                            <input type="file" name="image" id="image"  class="form-control thumbnail_input"/>
                                            <img class="thumbnail_image_show" width="100" src="images/{{$post->post_image}}">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Title EN</label>
                                            <input type="text" class="form-control" name="title_en"
                                                   value="{{ $post->post_title_en }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Title DE</label>
                                            <input type="text" class="form-control" name="title_de"
                                                   value="{{ $post->post_title_de }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Title FA</label>
                                            <input type="text" class="form-control" name="title_fa"
                                                   value="{{ $post->post_title_fa }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Title RU</label>
                                            <input type="text" class="form-control" name="title_ru"
                                                   value="{{ $post->post_title_ru }}">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>status (show in blog ?)</label>
                                            <input type="checkbox" class="" name="status"
                                                    {{ $post->status==1 ? "checked" : ""}}>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>home active (show in home page as post ?)</label>
                                            <input type="checkbox" class="" name="home_page"
                                                    {{ $post->home_page==1 ? "checked" : ""}}>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="product_details">Post Content EN</label>
                                            <textarea name="content_en" class="form-control"
                                                      rows="4">{{ $post->post_content_en }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="product_details">Post Content DE</label>
                                            <textarea name="content_de" class="form-control"
                                                      rows="4">{{ $post->post_content_de }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="product_details">Post Content FA</label>
                                            <textarea name="content_fa" class="form-control"
                                                      rows="4">{{ $post->post_content_fa }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="product_details">Post Content RU</label>
                                            <textarea name="content_ru" class="form-control"
                                                      rows="4">{{ $post->post_content_ru }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer text-center">
                            <button type="submit" name="submit" id="submit" class="btn btn-primary">Update Post
                            </button>
                        </div>
                    </form>
                </div>
                <!-- /.box -->
            </div>
        </div>
    </section>
@endsection


@section('script')
    <script src="https://cloud.tinymce.com/dev/tinymce.min.js?apiKey=m4x14c2uixh5g3lrm05vkez3vsxk00hpwr8soldild193nf5"></script>
    <script>
        tinymce.init({
            selector: 'textarea',
            height: 100,
            menubar: false,
            plugins: [
                'advlist autolink lists link image charmap print preview anchor textcolor',
                'searchreplace visualblocks code fullscreen',
                'insertdatetime media table contextmenu paste code help'
            ],
            toolbar1: ' styleselect | fontselect | fontsizeselect | searchreplace insertdatetime charmap | bold italic underline strikethrough subscript superscript | alignleft aligncenter alignright alignjustify |  bullist numlist | forecolor backcolor | blockquote link unlink table | image media  | code preview ',
            image_advtab: true,
            templates: [
                {title: 'Test template 1', content: 'Test 1'},
                {title: 'Test template 2', content: 'Test 2'}
            ],

            relative_urls: false,
            remove_script_host: false,
            convert_urls: true,

            content_css: [
                '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
                '//www.tinymce.com/css/codepen.min.css']
        });
    </script>
@endsection