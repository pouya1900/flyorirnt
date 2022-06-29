@extends('layouts.admin')

@section('content')
    <section class="content">

        <div class="row">
            <div class="col-md-6">
                <!-- general form elements -->
                <div class="box box-primary box-bg with-border">
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form action="{{route('admin.update_setting1')}}" method="post">
                        {{csrf_field()}}
                        <div class="box-body">

                            <div class="form-group">

                                <label for="name">Site Title</label>
                                <input type="text" name="site_title" class="form-control" id="name"
                                       placeholder="Enter Site Name"
                                       value="{{ $setting->site_title}}" required=""/>
                            </div>

                            {{--                        <div class="form-group">--}}
                            {{--                            <label for="welcome">Welcome Text</label>--}}
                            {{--                            <textarea name="welcome" id="welcome" class="form-control" rows="1" placeholder="Enter Welcome Text (maximum character limit : 100)" required >{{ $settings[3]['value']}}</textarea>--}}
                            {{--                        </div>--}}
                            {{--                        <div class="form-group">--}}
                            {{--                            <label for="footer">Footer Info</label>--}}
                            {{--                            <textarea name="footer" id="footer" class="form-control" rows="1" placeholder="Enter Footer Info (maximum character limit : 100)" required >{{ $settings[4]['value']}}</textarea>--}}
                            {{--                        </div>--}}

                            {{--                        <div class="form-group">--}}
                            {{--                            <label for="meta_title">Meta Title</label>--}}
                            {{--                            <textarea name="meta_title" id="meta_title" class="form-control" rows="1" placeholder="Enter Meta Title (maximum character limit : 60)" required >{{ $settings[8]['value']}}</textarea>--}}
                            {{--                        </div>--}}
                            {{--                        <div class="form-group">--}}
                            {{--                            <label for="meta_desc">Meta Description</label>--}}
                            {{--                            <textarea name="meta_desc" id="meta_desc" class="form-control" rows="2" placeholder="Enter Meta Description (maximum character limit : 255)" required >{{ $settings[9]['value']}}</textarea>--}}
                            {{--                        </div>--}}
                        </div>
                        <!-- /.box-body -->

                        <div class="box-footer text-center">
                            <button type="submit" name="submit" id="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
                <!-- /.box -->

            </div>
            <div class="col-md-6">
                <!-- general form elements -->
                <div class="box box-primary box-bg with-border">
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form action="{{route('admin.update_setting3')}}" method="post">
                        {{csrf_field()}}
                        <div class="box-body">

                            <div class="form-group">

                                <label for="render">flight active vendor</label>
                                <select name="render" class="form-control" id="render">
                                    <option value="{{\App\Models\Setting::parto}}" {{$setting->flight_render==\App\Models\Setting::parto ? "selected" : ""}}>
                                        parto main
                                    </option>
                                    <option value="{{\App\Models\Setting::amadeus}}" {{$setting->flight_render==\App\Models\Setting::amadeus ? "selected" : ""}}>
                                        amadeus
                                    </option>
                                    <option value="{{\App\Models\Setting::parto_demo}}" {{$setting->flight_render==\App\Models\Setting::parto_demo ? "selected" : ""}}>
                                        parto demo
                                    </option>
                                    <option value="{{\App\Models\Setting::iranAir}}" {{$setting->flight_render==\App\Models\Setting::iranAir ? "selected" : ""}}>
                                        iran air
                                    </option>
                                    <option value="{{\App\Models\Setting::iranAir_demo}}" {{$setting->flight_render==\App\Models\Setting::iranAir_demo ? "selected" : ""}}>
                                        iran air demo
                                    </option>
                                </select>

                            </div>

                            <div class="form-group">

                                <label for="render">flight ajax active vendor</label>

                                <div>
                                    <input type="checkbox" name="ajax_render[]"
                                           id="ajax_render{{\App\Models\Setting::parto}}"
                                           value="{{\App\Models\Setting::parto}}" {{$setting->flight_render_ajax  && in_array(\App\Models\Setting::parto , json_decode($setting->flight_render_ajax)) ? "checked" : ""}}>
                                    <label for="ajax_render{{\App\Models\Setting::parto}}">parto main</label>
                                </div>
                                <div>
                                    <input type="checkbox" name="ajax_render[]"
                                           id="ajax_render{{\App\Models\Setting::amadeus}}"
                                           value="{{\App\Models\Setting::amadeus}}" {{$setting->flight_render_ajax && in_array(\App\Models\Setting::amadeus , json_decode($setting->flight_render_ajax)) ? "checked" : ""}}>
                                    <label for="ajax_render{{\App\Models\Setting::amadeus}}">amadeus</label>
                                </div>
                                <div>
                                    <input type="checkbox" name="ajax_render[]"
                                           id="ajax_render{{\App\Models\Setting::parto_demo}}"
                                           value="{{\App\Models\Setting::parto_demo}}" {{$setting->flight_render_ajax && in_array(\App\Models\Setting::parto_demo , json_decode($setting->flight_render_ajax)) ? "checked" : ""}}>
                                    <label for="ajax_render{{\App\Models\Setting::parto_demo}}">parto demo</label>
                                </div>
                                <div>
                                    <input type="checkbox" name="ajax_render[]"
                                           id="ajax_render{{\App\Models\Setting::iranAir}}"
                                           value="{{\App\Models\Setting::iranAir}}" {{$setting->flight_render_ajax && in_array(\App\Models\Setting::iranAir , json_decode($setting->flight_render_ajax)) ? "checked" : ""}}>
                                    <label for="ajax_render{{\App\Models\Setting::iranAir}}">iran air</label>
                                </div>
                                <div>
                                    <input type="checkbox" name="ajax_render[]"
                                           id="ajax_render{{\App\Models\Setting::iranAir_demo}}"
                                           value="{{\App\Models\Setting::iranAir_demo}}" {{$setting->flight_render_ajax && in_array(\App\Models\Setting::iranAir_demo , json_decode($setting->flight_render_ajax)) ? "checked" : ""}}>
                                    <label for="ajax_render{{\App\Models\Setting::iranAir_demo}}">iran air demo</label>
                                </div>
                            </div>

                            <div class="form-group">

                                <label for="render">other days flight</label>

                                <div>
                                    <input type="checkbox" name="other_days"
                                           id="other_days" {{$setting->other_days ? "checked" : ""}}>
                                    <label for="other_days">iran air</label>
                                </div>

                            </div>

                        </div>
                        <!-- /.box-body -->

                        <div class="box-footer text-center">
                            <button type="submit" name="submit" id="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
                <!-- /.box -->

            </div>
            <div class="col-md-6">
                <!-- general form elements -->
                <div class="box box-primary box-bg with-border">
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form action="{{route('admin.update_setting2')}}" method="post" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="box-body">


                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Site Logo</label><br>
                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                            <div class="fileinput-preview thumbnail" data-trigger="fileinput"
                                                 style="width: 200px; height: 100px;">
                                                <img src="images/{{ $setting->logo }}" alt=""/>
                                            </div>
                                            <div>
                              <span class="btn btn-primary btn-file">
                                  @if (!$setting->logo)
                                      <span class="fileinput-new"> Select image </span>
                                  @else
                                      <span class="fileinput-exists"> Change </span>
                                  @endif

                                  <input type="file" name="logo"> </span>
                                                @if ($setting->logo)
                                                    <a href="javascript:;" class="btn btn-danger fileinput-exists"
                                                       data-dismiss="fileinput"> Remove </a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Site Favicon</label><br>
                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                            <div class="fileinput-preview thumbnail" data-trigger="fileinput"
                                                 style="width: 80px; height: 80px;">
                                                <img src="images/{{ $setting->favicon }}" alt=""/>
                                            </div>
                                            <div>
                              <span class="btn btn-primary btn-file">
                                   @if (!$setting->favicon)
                                      <span class="fileinput-new"> Select image </span>
                                  @else
                                      <span class="fileinput-exists"> Change </span>
                                  @endif
                                  <input type="file" name="favicon"> </span>
                                                @if ($setting->favicon)
                                                    <a href="javascript:;" class="btn btn-danger fileinput-exists"
                                                       data-dismiss="fileinput"> Remove </a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="email">Email Address</label>
                                        <textarea name="email" id="email" class="form-control" rows="1"
                                                  placeholder="Enter email" required>{{ $setting->email}}</textarea>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="phone">Phone Number</label>
                                        <textarea name="phone" id="phone" class="form-control" rows="1"
                                                  placeholder="Enter phone">{{ $setting->phone}}</textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="fax">fax</label>
                                        <textarea name="fax" id="fax" class="form-control" rows="1"
                                                  placeholder="Enter fax">{{ $setting->fax}}</textarea>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="admin_name">admin name</label>
                                        <textarea name="admin_name" id="admin_name" class="form-control" rows="1"
                                                  placeholder="Enter phone"
                                        >{{ $setting->admin_name }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="fax">whatsapp</label>
                                <textarea name="whatsapp" id="whatsapp" class="form-control" rows="1"
                                          placeholder="Enter whatsapp number (e.g:15551234567)">{{ $setting->whatsapp}}</textarea>

                            </div>

                            <div class="form-group">
                                <label for="address">Address</label>
                                <textarea name="address" id="address" class="form-control" rows="1"
                                          placeholder="Enter address">{{ $setting->address }}</textarea>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>search loader background image</label><br>
                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                            <div class="fileinput-preview thumbnail" data-trigger="fileinput"
                                                 style="width: 200px; height: 100px;">
                                                <img src="images/{{ $setting->search_loader_img }}" alt=""/>
                                            </div>
                                            <div class="margin-top-50px">
                              <span class="btn btn-primary btn-file">
                                  @if (!$setting->search_loader_img)
                                      <span class="fileinput-new"> Select image </span>
                                  @else
                                      <span class="fileinput-exists"> Change </span>
                                  @endif

                                  <input type="file" name="search_loader_background"> </span>
                                                @if ($setting->search_loader_img)
                                                    <a href="javascript:;" class="btn btn-danger fileinput-exists"
                                                       data-dismiss="fileinput"> Remove </a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="logo_position_search_loader">position logo in search loader</label>
                                        <select name="logo_position_search_loader" id="logo_position_search_loader"
                                                class="form-control" required>

                                            <option value="left" {{$setting->logo_position_search_loader=="left" ? "selected" : ""}}>
                                                left
                                            </option>
                                            <option value="center" {{$setting->logo_position_search_loader=="center" ? "selected" : ""}}>
                                                center
                                            </option>
                                            <option value="right" {{$setting->logo_position_search_loader=="right" ? "selected" : ""}}>
                                                right
                                            </option>

                                        </select>
                                    </div>
                                </div>
                            </div>


                        </div>
                        <!-- /.box-body -->

                        <div class="box-footer text-center">
                            <button type="submit" name="submit" id="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
                <!-- /.box -->

            </div>
            <div class="col-md-6">
                <!-- general form elements -->
                <div class="box box-primary box-bg with-border">
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form action="{{route('admin.update_setting4')}}" method="post">
                        {{csrf_field()}}
                        <div class="box-body">

                            <div class="form-group">
                                <div>
                                    <p>
                                        Payment
                                    </p>
                                </div>
                                <div>
                                    <label for="payment">Use real payment : </label>
                                    <label class="switch">
                                        <input type="checkbox" id="payment"
                                               name="payment" {{$setting->payment ? "checked" : ""}}>
                                        <span class="slider round"></span>
                                    </label>
                                </div>

                                <div>
                                    <label for="pure_price">Show pure price to admin : </label>
                                    <label class="switch">
                                        <input type="checkbox" id="pure_price"
                                               name="pure_price" {{$setting->pure_price ? "checked" : ""}}>
                                        <span class="slider round"></span>
                                    </label>
                                </div>

                                <div>
                                    <label for="test_one_euro">Use one euro test payment : </label>
                                    <label class="switch">
                                        <input type="checkbox" id="test_one_euro"
                                               name="test_one_euro" {{$setting->test_one_euro ? "checked" : ""}}>
                                        <span class="slider round"></span>
                                    </label>
                                </div>

                                <div>
                                    <label for="test_one_euro_with_book">Use one euro test payment with booking
                                        : </label>
                                    <label class="switch">
                                        <input type="checkbox" id="test_one_euro"
                                               name="test_one_euro_with_book" {{$setting->test_one_euro_with_book ? "checked" : ""}}>
                                        <span class="slider round"></span>
                                    </label>
                                </div>

                            </div>

                        </div>
                        <!-- /.box-body -->

                        <div class="box-footer text-center">
                            <button type="submit" name="submit" id="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
                <!-- /.box -->

            </div>

            <div class="col-md-6">
                <!-- general form elements -->
                <div class="box box-primary box-bg with-border">
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form action="{{route('admin.update_setting5')}}" method="post">
                        {{csrf_field()}}
                        <div class="box-body">

                            <div class="form-group">
                                <div>
                                    <p>
                                        Cip setting
                                    </p>
                                </div>

                                <div>
                                    <label for="cip_on_off">Cip on\off : </label>
                                    <label class="switch">
                                        <input type="checkbox" id="cip_on_off"
                                               name="cip_on_off" {{$setting->cip_active ? "checked" : ""}}>
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                                <div>
                                    <label for="cip_max_time">Cip max reserve allowed time : </label>
                                    <input type="text" name="cip_max_time"
                                           id="cip_max_time"
                                           value="{{date('d.m.Y',strtotime($setting->cip_max_time))}}">
                                </div>

                                <div>
                                    <label for="cip_max_time_day_active">Cip max time with days : </label>
                                    <label class="switch">
                                        <input type="checkbox" id="cip_max_time_day_active"
                                               name="cip_max_time_day_active" {{$setting->cip_max_time_day ? "checked" : ""}}>
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                                <div>
                                    <label for="cip_max_time_day">Cip max reserve allowed time per day : </label>
                                    <input type="number" name="cip_max_time_day"
                                           id="cip_max_time_day"
                                           value="{{$setting->cip_max_time_day}}">
                                </div>

                            </div>

                        </div>
                        <!-- /.box-body -->

                        <div class="box-footer text-center">
                            <button type="submit" name="submit" id="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
                <!-- /.box -->

            </div>


        </div>

    </section>

@endsection

@section('script')
    <script>
        $("#cip_max_time").caleran({

            locale: "en",
            startOnMonday: true,
            showFooter: false,
            autoCloseOnSelect: true,
            format: "DD.MM.YYYY",
            singleDate: true,
            startEmpty: $("#cip_max_time").val() === "",
        });
    </script>

@endsection