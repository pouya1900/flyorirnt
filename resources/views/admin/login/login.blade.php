@extends('layouts.authenticate')
@section('content')
    <section class="background-light-grey padding-tb-130px">
        <div class="container">
            <div class="row justify-content-md-center">

                <div class="col-lg-4">

                    <div class="text-center margin-bottom-30px">
                        <a href="{{route('home')}}"><img src="images/{{$setting->logo}}" alt=""></a>
                    </div>

                    <div class="padding-30px background-white border-1 border-grey-1">
                        <form method="post" action="{{route('admin.do_login')}}">
                            {{csrf_field()}}
                            <div class="form-group">
                                <label for="inputEmail3" class="col-form-label"><strong>
                                        Email</strong></label>
                                <input type="text" name="email" value="{{old('email')}}" class="form-control rounded-0" id="inputEmail3"
                                       placeholder="Email">
                                @if($errors->has('email'))
                                    @foreach($errors->get('email') as $error)
                                    <span>{{$error}}</span>
                                    @endforeach
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="inputPassword3" class="col-form-label"><strong>Password</strong></label>
                                <input type="password" name="password" class="form-control rounded-0"
                                       id="inputPassword3" placeholder="Password">
                                @if($errors->has('password'))
                                    @foreach($errors->get('password') as $error)
                                        <span>{{$error}}</span>
                                    @endforeach
                                @endif
                            </div>
                            <div class="form-group ">
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input name="remember" class="form-check-input" type="checkbox"> Remember me
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-block rounded-0 background-main-color">
                                    Sign in
                                </button>
                            </div>
                        </form>

                        @if(session('loginError'))
                        <div class="text-red">
                            {{session('loginError')}}

                        </div>
                            @endif
                    </div>
                </div>


            </div>
            <!-- // row -->
        </div>
        <!-- // container -->
    </section>
@endsection