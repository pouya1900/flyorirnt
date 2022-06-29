@extends('layouts.admin')

@section('style')
    <link href="plugins/dz/dropzone.css" type="text/css" rel="stylesheet">
    <link href="plugins/dz/basic.css" type="text/css" rel="stylesheet">
@endsection

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
                    <div class="box-header with-border">
                        <h3 class="box-title">upload media</h3>

                    </div>
                    <div class="box-body">

                        <div class="form-group">

                            <label for="model">model</label>
                            <select name="model" class="form-control" id="model">
                                <option>select image model</option>
                                <option value="post">post</option>
                                <option value="page">page</option>
                                <option value="setting">setting</option>
                                <option value="avatar">avatar</option>
                                <option value="cars">cars</option>
                            </select>

                        </div>
                        <div class="form-group">

                            <div id="content_image" class="dropzone">
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.box -->

            </div>
        </div>

    </section>

    @include('admin.upload.upload_result')
@endsection

@section('script')
    <script type="text/javascript" charset="UTF-8">
    </script>
    <script type="text/javascript" src="plugins/dz/dropzone.js"></script>

    <script>

        Dropzone.autoDiscover = false;
        // or disable for specific dropzone:
        // Dropzone.options.myDropzone = false;


        $(function () {
            // Now that the DOM is fully loaded, create the dropzone, and setup the
            // event listeners
            var myDropzone = new Dropzone("div#content_image", {url: "{{route('admin.upload_store')}}"});

            myDropzone.on("sending", function (file, xhr, formData) {
                formData.append("_token", "{{ csrf_token() }}");

                model = $('#model').val();

                formData.append("model", model);
                formData.append("type", "image");

            });

            myDropzone.on("success", function (file, response) {
                var text="";
                $.each( response, function( key, value ) {
                    text+="<p>"+key+" : "+"<a href='"+value+"'>"+value+"</a>"+"</p>";
                });

                $("#result_container").html(text);
                $('#result_modal').modal('show');

            });
        });


    </script>
@endsection
