@extends('layouts.admin')
@section('content')

    <section class="content">

        @if (session('success'))
            <div class="alert alert-success" role="alert">
                {{session('success')}}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger" role="alert">
                {{session('error')}}
            </div>
        @endif

        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <!-- general form elements -->
                <div class="box box-primary box-bg with-border collapsed-box">
                    <!-- /.box-header -->
                    <!-- form start -->
                    <div class="box-header with-border">
                        <h3 class="box-title">About Us</h3>

                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                        class="fa fa-plus"></i>
                            </button>
                        </div>
                    </div>

                    <div class="box-body">
                        <form action="{{route('admin.pages_store')}}" method="post">
                            {{csrf_field()}}
                            <input type="hidden" name="id" value="{{$pages["about_us"]->id}}">

                            <div class="page_text_container">
                                <label for="about_us_en">english page</label>
                                <textarea class="" rows="4" id="about_us_en"
                                          name="text_en">{{$pages["about_us"]->text_en}}</textarea>
                            </div>

                            <div class="page_text_container">
                                <label for="about_us_de">germany page</label>
                                <textarea class="" rows="4" id="about_us_de"
                                          name="text_de">{{$pages["about_us"]->text_de}}</textarea>
                            </div>

                            <div class="page_text_container">
                                <label for="about_us_fa">persian page</label>
                                <textarea class="" rows="4" id="about_us_fa"
                                          name="text_fa">{{$pages["about_us"]->text_fa}}</textarea>
                            </div>
                            <div class="page_text_container">
                                <label for="about_us_ru">russian page</label>
                                <textarea class="" rows="4" id="about_us_ru"
                                          name="text_ru">{{$pages["about_us"]->text_ru}}</textarea>
                            </div>

                            <div>
                                <label for="about_us_rtl">ignore rtl in right to left language</label>
                                <input type="checkbox" name="rtl_ignore"
                                       id="about_us_rtl" {{$pages["about_us"]->rtl_ignore ? "checked" : ""}}>
                            </div>

                            <button class="submit_page" name="about_us_action" value="1" type="submit">save</button>
                        </form>
                    </div>

                </div>
                <!-- /.box -->

            </div>

            <div class="col-md-10 col-md-offset-1">
                <!-- general form elements -->
                <div class="box box-primary box-bg with-border collapsed-box">
                    <!-- /.box-header -->
                    <!-- form start -->
                    <div class="box-header with-border">
                        <h3 class="box-title">Privacy</h3>

                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                        class="fa fa-plus"></i>
                            </button>
                        </div>
                    </div>

                    <div class="box-body">
                        <form action="{{route('admin.pages_store')}}" method="post">
                            {{csrf_field()}}
                            <input type="hidden" name="id" value="{{$pages["privacy"]->id}}">

                            <div class="page_text_container">
                                <label for="privacy_en">english page</label>
                                <textarea class="" rows="4" id="privacy_en"
                                          {{--                                          name="text_en">{{str_replace( '&', '&amp;', $pages["privacy"]->text_en)}}</textarea>--}}
                                          name="text_en">{{$pages["privacy"]->text_en}}</textarea>
                            </div>

                            <div class="page_text_container">
                                <label for="privacy_de">germany page</label>
                                <textarea class="" rows="4" id="privacy_de"
                                          name="text_de">{{$pages["privacy"]->text_de}}</textarea>
                            </div>

                            <div class="page_text_container">
                                <label for="privacy_fa">persian page</label>
                                <textarea class="" rows="4" id="privacy_fa"
                                          name="text_fa">{{$pages["privacy"]->text_fa}}</textarea>
                            </div>
                            <div class="page_text_container">
                                <label for="privacy_ru">russian page</label>
                                <textarea class="" rows="4" id="privacy_ru"
                                          name="text_ru">{{$pages["privacy"]->text_ru}}</textarea>
                            </div>
                            <div>
                                <label for="privacy_rtl">ignore rtl in right to left language</label>
                                <input type="checkbox" name="rtl_ignore"
                                       id="privacy_rtl" {{$pages["privacy"]->rtl_ignore ? "checked" : ""}}>
                            </div>
                            <button class="submit_page" name="privacy_action" value="1" type="submit">save</button>
                        </form>
                    </div>

                </div>
                <!-- /.box -->

            </div>

            <div class="col-md-10 col-md-offset-1">
                <!-- general form elements -->
                <div class="box box-primary box-bg with-border collapsed-box">
                    <!-- /.box-header -->
                    <!-- form start -->
                    <div class="box-header with-border">
                        <h3 class="box-title">AGB</h3>

                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                        class="fa fa-plus"></i>
                            </button>
                        </div>
                    </div>

                    <div class="box-body">
                        <form action="{{route('admin.pages_store')}}" method="post">
                            {{csrf_field()}}
                            <input type="hidden" name="id" value="{{$pages["AGB"]->id}}">

                            <div class="page_text_container">
                                <label for="AGB_en">english page</label>
                                <textarea class="" rows="4" id="AGB_en"
                                          name="text_en">{{$pages["AGB"]->text_en}}</textarea>
                            </div>

                            <div class="page_text_container">
                                <label for="AGB_de">germany page</label>
                                <textarea class="" rows="4" id="AGB_de"
                                          name="text_de">{{$pages["AGB"]->text_de}}</textarea>
                            </div>

                            <div class="page_text_container">
                                <label for="AGB_fa">persian page</label>
                                <textarea class="" rows="4" id="AGB_fa"
                                          name="text_fa">{{$pages["AGB"]->text_fa}}</textarea>
                            </div>
                            <div class="page_text_container">
                                <label for="AGB_ru">russian page</label>
                                <textarea class="" rows="4" id="AGB_ru"
                                          name="text_ru">{{$pages["AGB"]->text_ru}}</textarea>
                            </div>
                            <div>
                                <label for="AGB_rtl">ignore rtl in right to left language</label>
                                <input type="checkbox" name="rtl_ignore"
                                       id="AGB_rtl" {{$pages["AGB"]->rtl_ignore ? "checked" : ""}}>
                            </div>
                            <button class="submit_page" name="AGB_action" value="1" type="submit">save</button>
                        </form>
                    </div>

                </div>
                <!-- /.box -->

            </div>

            <div class="col-md-10 col-md-offset-1">
                <!-- general form elements -->
                <div class="box box-primary box-bg with-border collapsed-box">
                    <!-- /.box-header -->
                    <!-- form start -->
                    <div class="box-header with-border">
                        <h3 class="box-title">imprint</h3>

                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                        class="fa fa-plus"></i>
                            </button>
                        </div>
                    </div>

                    <div class="box-body">
                        <form action="{{route('admin.pages_store')}}" method="post">
                            {{csrf_field()}}
                            <input type="hidden" name="id" value="{{$pages["imprint"]->id}}">

                            <div class="page_text_container">
                                <label for="imprint_en">english page</label>
                                <textarea class="" rows="4" id="imprint_en"
                                          name="text_en">{{$pages["imprint"]->text_en}}</textarea>
                            </div>

                            <div class="page_text_container">
                                <label for="imprint_de">germany page</label>
                                <textarea class="" rows="4" id="imprint_de"
                                          name="text_de">{{$pages["imprint"]->text_de}}</textarea>
                            </div>

                            <div class="page_text_container">
                                <label for="imprint_fa">persian page</label>
                                <textarea class="" rows="4" id="imprint_fa"
                                          name="text_fa">{{$pages["imprint"]->text_fa}}</textarea>
                            </div>
                            <div class="page_text_container">
                                <label for="imprint_ru">russian page</label>
                                <textarea class="" rows="4" id="imprint_ru"
                                          name="text_ru">{{$pages["imprint"]->text_ru}}</textarea>
                            </div>

                            <div>
                                <label for="imprint_rtl">ignore rtl in right to left language</label>
                                <input type="checkbox" name="rtl_ignore"
                                       id="imprint_rtl" {{$pages["imprint"]->rtl_ignore ? "checked" : ""}}>
                            </div>

                            <button class="submit_page" name="imprint_action" value="1" type="submit">save</button>
                        </form>
                    </div>

                </div>
                <!-- /.box -->

            </div>


            <div class="col-md-10 col-md-offset-1">
                <!-- general form elements -->
                <div class="box box-primary box-bg with-border collapsed-box">
                    <!-- /.box-header -->
                    <!-- form start -->
                    <div class="box-header with-border">
                        <h3 class="box-title">cip</h3>

                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                        class="fa fa-plus"></i>
                            </button>
                        </div>
                    </div>

                    <div class="box-body">
                        <form action="{{route('admin.pages_store')}}" method="post">
                            {{csrf_field()}}
                            <input type="hidden" name="id" value="{{$pages["cip"]->id}}">

                            <div class="page_text_container">
                                <label for="cip_en">english page</label>
                                <textarea class="" rows="4" id="cip_en"
                                          name="text_en">{{$pages["cip"]->text_en}}</textarea>
                            </div>

                            <div class="page_text_container">
                                <label for="cip_de">germany page</label>
                                <textarea class="" rows="4" id="cip_de"
                                          name="text_de">{{$pages["cip"]->text_de}}</textarea>
                            </div>

                            <div class="page_text_container">
                                <label for="cip_fa">persian page</label>
                                <textarea class="" rows="4" id="cip_fa"
                                          name="text_fa">{{$pages["cip"]->text_fa}}</textarea>
                            </div>
                            <div class="page_text_container">
                                <label for="cip_ru">russian page</label>
                                <textarea class="" rows="4" id="cip_ru"
                                          name="text_ru">{{$pages["cip"]->text_ru}}</textarea>
                            </div>

                            <div>
                                <label for="cip_rtl">ignore rtl in right to left language</label>
                                <input type="checkbox" name="rtl_ignore"
                                       id="cip_rtl" {{$pages["cip"]->rtl_ignore ? "checked" : ""}}>
                            </div>

                            <button class="submit_page" name="cip_action" value="1" type="submit">save</button>
                        </form>
                    </div>

                </div>
                <!-- /.box -->

            </div>

            <div class="col-md-10 col-md-offset-1">
                <!-- general form elements -->
                <div class="box box-primary box-bg with-border collapsed-box">
                    <!-- /.box-header -->
                    <!-- form start -->
                    <div class="box-header with-border">
                        <h3 class="box-title">condition in ticket for parto</h3>

                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                        class="fa fa-plus"></i>
                            </button>
                        </div>
                    </div>

                    <div class="box-body">
                        <form action="{{route('admin.pages_store')}}" method="post">
                            {{csrf_field()}}
                            <input type="hidden" name="id" value="{{$pages["condition_parto"]->id}}">

                            <div class="page_text_container">
                                <label for="con_en">english</label>
                                <textarea class="" rows="4" id="con_en"
                                          name="text_en">{{$pages["condition_parto"]->text_en}}</textarea>
                            </div>

                            <div class="page_text_container">
                                <label for="con_de">germany</label>
                                <textarea class="" rows="4" id="con_de"
                                          name="text_de">{{$pages["condition_parto"]->text_de}}</textarea>
                            </div>

                            <div class="page_text_container">
                                <label for="con_fa">persian</label>
                                <textarea class="" rows="4" id="con_fa"
                                          name="text_fa">{{$pages["condition_parto"]->text_fa}}</textarea>
                            </div>
                            <div class="page_text_container">
                                <label for="con_ru">russian</label>
                                <textarea class="" rows="4" id="con_ru"
                                          name="text_ru">{{$pages["condition_parto"]->text_ru}}</textarea>
                            </div>

                            <div>
                                <label for="con_rtl">ignore rtl in right to left language</label>
                                <input type="checkbox" name="rtl_ignore"
                                       id="con_rtl" {{$pages["condition_parto"]->rtl_ignore ? "checked" : ""}}>
                            </div>

                            <button class="submit_page" name="con_action" value="1" type="submit">save</button>
                        </form>
                    </div>

                </div>
                <!-- /.box -->

            </div>

            <div class="col-md-10 col-md-offset-1">
                <!-- general form elements -->
                <div class="box box-primary box-bg with-border collapsed-box">
                    <!-- /.box-header -->
                    <!-- form start -->
                    <div class="box-header with-border">
                        <h3 class="box-title">condition in ticket for iran air</h3>

                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                        class="fa fa-plus"></i>
                            </button>
                        </div>
                    </div>

                    <div class="box-body">
                        <form action="{{route('admin.pages_store')}}" method="post">
                            {{csrf_field()}}
                            <input type="hidden" name="id" value="{{$pages["condition_ir"]->id}}">

                            <div class="page_text_container">
                                <label for="con_en">english</label>
                                <textarea class="" rows="4" id="con_en"
                                          name="text_en">{{$pages["condition_ir"]->text_en}}</textarea>
                            </div>

                            <div class="page_text_container">
                                <label for="con_de">germany</label>
                                <textarea class="" rows="4" id="con_de"
                                          name="text_de">{{$pages["condition_ir"]->text_de}}</textarea>
                            </div>

                            <div class="page_text_container">
                                <label for="con_fa">persian</label>
                                <textarea class="" rows="4" id="con_fa"
                                          name="text_fa">{{$pages["condition_ir"]->text_fa}}</textarea>
                            </div>
                            <div class="page_text_container">
                                <label for="con_ru">russian</label>
                                <textarea class="" rows="4" id="con_ru"
                                          name="text_ru">{{$pages["condition_ir"]->text_ru}}</textarea>
                            </div>

                            <div>
                                <label for="con_rtl">ignore rtl in right to left language</label>
                                <input type="checkbox" name="rtl_ignore"
                                       id="con_rtl" {{$pages["condition_ir"]->rtl_ignore ? "checked" : ""}}>
                            </div>

                            <button class="submit_page" name="con_action" value="1" type="submit">save</button>
                        </form>
                    </div>

                </div>
                <!-- /.box -->

            </div>

            <div class="col-md-10 col-md-offset-1">
                <!-- general form elements -->
                <div class="box box-primary box-bg with-border collapsed-box">
                    <!-- /.box-header -->
                    <!-- form start -->
                    <div class="box-header with-border">
                        <h3 class="box-title">contact</h3>

                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                        class="fa fa-plus"></i>
                            </button>
                        </div>
                    </div>

                    <div class="box-body">
                        <form action="{{route('admin.pages_store')}}" method="post">
                            {{csrf_field()}}

                            <input type="hidden" name="id" value="{{$pages["contact"]->id}}">

                            <div class="page_text_container">
                                <label for="contact_en">english</label>
                                <textarea class="" rows="4" id="contact_en"
                                          name="text_en">{{$pages["contact"]->text_en}}</textarea>
                            </div>

                            <div class="page_text_container">
                                <label for="contact_de">germany</label>
                                <textarea class="" rows="4" id="contact_de"
                                          name="text_de">{{$pages["contact"]->text_de}}</textarea>
                            </div>

                            <div class="page_text_container">
                                <label for="contact_fa">persian</label>
                                <textarea class="" rows="4" id="contact_fa"
                                          name="text_fa">{{$pages["contact"]->text_fa}}</textarea>
                            </div>
                            <div class="page_text_container">
                                <label for="contact_ru">russian</label>
                                <textarea class="" rows="4" id="contact_ru"
                                          name="text_ru">{{$pages["contact"]->text_ru}}</textarea>
                            </div>

                            <div>
                                <label for="contact_rtl">ignore rtl in right to left language</label>
                                <input type="checkbox" name="rtl_ignore"
                                       id="contact_rtl" {{$pages["contact"]->rtl_ignore ? "checked" : ""}}>
                            </div>

                            <button class="submit_page" name="contact_action" value="1" type="submit">save</button>
                        </form>
                    </div>

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




