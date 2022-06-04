@extends('layouts.admin')

@section('content')
    <section class="content">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">

                <!-- general form elements -->
                <div class="box box-primary box-bg with-border">
                    <div class="box-header text-center">
                        <p class="text-right">
                            <a class="btn btn-info" href="{{ route('admin.posts') }}">Post List</a>
                        </p>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form method="post" action="{{route('admin.store_post')}}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="box-body">
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Name</label>
                                            <input type="text" class="form-control" name="name"
                                            >
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="image">Image</label>
                                            <input type="file" name="image" id="image" class="form-control thumbnail_input"/>
                                            <img class="thumbnail_image_show" width="100" src="#">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Title EN</label>
                                            <input type="text" class="form-control" name="title_en">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Title DE</label>
                                            <input type="text" class="form-control" name="title_de"
                                            >
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Title FA</label>
                                            <input type="text" class="form-control" name="title_fa"
                                            >
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Title RU</label>
                                            <input type="text" class="form-control" name="title_ru"
                                            >
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>status (show in blog ?)</label>
                                            <input type="checkbox" class="" name="status" checked
                                                    >
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>home active (show in home page as post ?)</label>
                                            <input type="checkbox" class="" name="home_page"
                                                    >
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="product_details">Post Content EN</label>
                                            <textarea name="content_en" class="form-control"
                                                      rows="4"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="product_details">Post Content DE</label>
                                            <textarea name="content_de" class="form-control"
                                                      rows="4"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="product_details">Post Content FA</label>
                                            <textarea name="content_fa" class="form-control"
                                                      rows="4"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="product_details">Post Content RU</label>
                                            <textarea name="content_ru" class="form-control"
                                                      rows="4"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer text-center">
                            <button type="submit" name="submit" id="submit" class="btn btn-primary">Create Post
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