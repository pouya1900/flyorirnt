@extends('layouts.admin')

@section('content')

    <section class="content">

        <div class="row">

            <div class="col-md-10">
                <!-- general form elements -->
                <div class="box box-primary box-bg with-border">
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form action="{{route('admin.update_user',$user->id)}}" method="post" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="box-body">


                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="id">id</label>
                                        <input name="id" id="id" class="form-control" rows="1"
                                               placeholder="id" readonly value="{{$user->id}}">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="gender">gender</label>
                                        <select id="gender" name="gender" class="form-control">
                                            <option value="">gender...</option>

                                            <option value="0" {{$user->gender==0 ? "selected" : ""}}>male</option>
                                            <option value="1" {{$user->gender==1 ? "selected" : ""}}>female</option>
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="f_name">first name</label>
                                        <input name="f_name" id="f_name" class="form-control" rows="1"
                                               placeholder="first name" value="{{$user->f_name}}">
                                    </div>

                                    <div class="col-md-6">
                                        <label for="l_name">last name</label>
                                        <input name="l_name" id="l_name" class="form-control" rows="1"
                                               placeholder="last name" value="{{$user->l_name}}">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="email">email</label>
                                        <input name="email" id="email" class="form-control" rows="1"
                                               placeholder="email" value="{{$user->email}}">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="birthday">birthday</label>
                                        <input name="birthday" id="birthday" class="form-control" rows="1"
                                               placeholder="birthday" value="{{$user->birthday}}">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="country">country</label>
                                        <select id="country" class="form-control"
                                                name="country">
                                            <option value="">country...</option>
                                            <option value="DE">germany</option>
                                            @foreach($country as $item)

                                                <option value="{{$item["code"]}}" {{$item["code"]==$user->country ? "selected"  : ""}}>{{$item["country_en"]}}</option>

                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="mobile">mobile</label>
                                        <input name="mobile" id="mobile" class="form-control" rows="1"
                                               placeholder="mobile" value="{{$user->mobile}}">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="role">role</label>
                                        <select name="role" id="role" class="form-control">
                                            <option value="{{\App\User::guest}}" {{$user->role==\App\User::guest ? "selected" : ""}}>
                                                guest
                                            </option>
                                            <option value="{{\App\User::user}} " {{$user->role==\App\User::user ? "selected" : ""}}>
                                                user
                                            </option>
                                            <option value="{{\App\User::staff}} " {{$user->role==\App\User::staff ? "selected" : ""}}>
                                                staff
                                            </option>
                                            <option value="{{\App\User::admin}} " {{$user->role==\App\User::admin ? "selected" : ""}}>
                                                admin
                                            </option>
                                            <option value="{{\App\User::agency}} " {{$user->role==\App\User::agency ? "selected" : ""}}>
                                                agency
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

        </div>

    </section>


@endsection
@section('script')

@endsection

