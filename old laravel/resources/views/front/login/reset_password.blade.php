@extends('layouts.authenticate')
@section('content')

    @if ($errors)
    @endif

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



                        <form method="post" action="{{route('do_reset'). ($lang!="de"? "?lang=".$lang : "")}}" id="reset_pass_form">
                            {{csrf_field()}}
                            <input type="hidden" name="hide_email" value="{{$email}}">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-lg-4"><label for="password"
                                                                 class="col-form-label"><strong>@lang('trs.password')
                                                *</strong></label></div>
                                    <div class="col-lg-8"><input type="password" name="password"
                                                                 class="form-control rounded-0" id="password"
                                                                 placeholder="@lang('trs.password')">
                                        @if ($errors->get('password'))
                                            <span class="error_alert">{{$errors->get('password')[0]}}</span>
                                        @endif</div>
                                </div>


                            </div>
                            <div class="form-group">

                                <div class="row">
                                    <div class="col-lg-4"><label for="confirm_password"
                                                                 class="col-form-label"><strong>@lang('trs.confirm_password')
                                                *</strong></label></div>
                                    <div class="col-lg-8"><input type="password" name="password_confirmation"
                                                                 class="form-control rounded-0"
                                                                 id="confirm_password"
                                                                 placeholder="@lang('trs.confirm_password')"></div>
                                    </div>
                                </div>




                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-block rounded-0 background-main-color">
                                    @lang('trs.change')
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


