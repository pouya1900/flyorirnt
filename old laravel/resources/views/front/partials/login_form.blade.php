<section class="auth_page background-light-grey padding-tb-30px">
    <div class="container">
        <div class="row justify-content-md-center">

            <div class="col-lg-7">

                <div class="text-center margin-bottom-30px">
                    <a href="{{route('home'). ($lang!="de"? "?lang=".$lang : "")}}"><img src="images/{{$setting->logo}}"
                                                                                         alt=""></a>
                </div>

                <div class="padding-30px background-white border-1 border-grey-1">

                    <div id="not_confirmed" class="alert alert-primary margin-top-40px display_none" role="alert">
                    </div>

                    @if (session('success_message'))
                        <div class="alert alert-success" role="alert">
                            {{session('success_message')}}
                        </div>

                        @elseif(session('error_message'))
                        <div class="alert alert-danger" role="alert">
                            {{session('error_message')}}
                        </div>
                    @endif


                    <form method="post" action="{{route('do_login'). ($lang!="de"? "?lang=".$lang : "")}}"
                          id="login_form">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label for="inputEmail3" class="col-form-label"><strong>
                                    @lang('trs.email')</strong></label>
                            <input type="text" name="email" value="{{old('email')}}" class="form-control rounded-0"
                                   id="inputEmail3"
                                   placeholder=" @lang('trs.email')">
                            <span class="error_alert"></span>

                        </div>
                        <div class="form-group">
                            <label for="inputPassword3"
                                   class="col-form-label"><strong>@lang('trs.password')</strong></label>
                            <input type="password" name="password" class="form-control rounded-0"
                                   id="inputPassword3" placeholder="@lang('trs.password')">
                            <span class="error_alert"></span>

                        </div>
                        <div class="form-group ">
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input name="remember" class="form-check-input"
                                           type="checkbox"> @lang('trs.remember_me')
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit"
                                    class="btn btn-primary btn-block rounded-0 background-main-color login_form_submit">
                                @lang('trs.sign_in')
                            </button>
                        </div>
                    </form>

                    <div id="login_error" class="error_alert display_none">

                    </div>
                </div>
            </div>

        </div>
        <!-- // row -->


        <div class="row justify-content-md-center">

            <div class="col-lg-7 lmf">

                <a target="_blank" href="{{route('forgot')}}">@lang('trs.forgot_password')<i
                            class="fas fa-external-link-alt"></i></a>
                <a target="_blank"
                   href="{{route('register'). ($lang!="de"? "?lang=".$lang : "")}}">@lang('trs.not_member')
                    (@lang('trs.register_now')) <i class="fas fa-external-link-alt"></i></a>

            </div>

        </div>

    </div>
    <!-- // container -->
</section>
