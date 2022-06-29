@extends('layouts.authenticate')
@section('content')


    <section class="auth_page background-light-grey padding-tb-30px">
        <div class="container">
            <div class="row justify-content-md-center">

                <div class="col-lg-7">

                    <div class="text-center margin-bottom-30px">
                        <a href="{{route('home'). ($lang!="de"? "?lang=".$lang : "")}}"><img src="images/{{$setting->logo}}" alt=""></a>
                    </div>

                    <div class="padding-30px background-white border-1 border-grey-1">

                        <div id="not_confirmed" class="alert alert-primary margin-top-40px display_none" role="alert">
                        </div>



                        <form method="post" action="{{route('send_reset_link'). ($lang!="de"? "?lang=".$lang : "")}}" id="reset_pass_form">
                            {{csrf_field()}}
                            <div class="form-group">
                                <label for="inputEmail3" class="col-form-label"><strong>
                                        @lang('trs.email')</strong></label>
                                <input type="text" name="email" value="{{old('email')}}" class="form-control rounded-0" id="inputEmail3"
                                       placeholder=" @lang('trs.email')">
                                <p>we will send a password reset link to your email</p>
                                @if (session('action_error'))
                                    <span class="error_alert">{{session('action_error')}}</span>

                                @endif

                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-block rounded-0 background-main-color">
                                    @lang('trs.send')
                                </button>
                            </div>
                        </form>

                        <div id="login_error" class="error_alert display_none" >

                        </div>
                    </div>
                </div>

            </div>
            <!-- // row -->

            <div class="row justify-content-md-center">

                <div class="col-lg-7 lmf">

                    <a target="_blank" href="{{route('register'). ($lang!="de"? "?lang=".$lang : "")}}">@lang('trs.not_member') (@lang('trs.register_now'))  <i class="fas fa-external-link-alt"></i></a>

                </div>

            </div>

        </div>
        <!-- // container -->
    </section>


@endsection


