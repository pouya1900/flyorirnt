<!-- ======= Header  ======= -->
@php

    if ($lang=='en') $flag="gb";
    else if ($lang=='fa') $flag="ir";
    else if ($lang=='de') $flag="de";
    else if ($lang=='ru') $flag="ru";
    $uri_parts = explode('?', $_SERVER['REQUEST_URI'], 2);

            $lang_link = "http://{$_SERVER['HTTP_HOST']}{$uri_parts[0]}";


@endphp

<header class="background-white box-shadow">
    <div class="background-main-color padding-tb-5px">
        <div class="container">
            <div class="row">
                <div class="col-sm d-none d-sm-block text-white">@lang('trs.top_bar_left_text')</div>
                {{--                <div class="col-sm">--}}
                {{--                    <ul class="list-inline text-center margin-0px text-white">--}}
                {{--                        <li class="list-inline-item"><a class="facebook" href="#"><i class="fab fa-facebook-f"></i></a></li>--}}
                {{--                        <li class="list-inline-item"><a class="youtube" href="#"><i class="fab fa-youtube"></i></a></li>--}}
                {{--                        <li class="list-inline-item"><a class="linkedin" href="#"><i class="fab fa-linkedin-in"></i></a></li>--}}
                {{--                        <li class="list-inline-item"><a class="google" href="#">--}}
                {{--                                <i class="fab fa-google-plus-square"></i>--}}
                {{--                            </a></li>--}}
                {{--                        <li class="list-inline-item"><a class="twitter" href="#"><i class="fab fa-twitter"></i></a></li>--}}
                {{--                        <li class="list-inline-item"><a class="rss" href="#"><i class="fa fa-rss"--}}
                {{--                                                                                aria-hidden="true"></i></a></li>--}}
                {{--                    </ul>--}}
                {{--                    <!-- // Social -->--}}
                {{--                </div>--}}
                <div class="col-sm ">
                    <ul class="user-area list-inline  margin-0px text-white user_section">
                        @if (!\Illuminate\Support\Facades\Auth::check())
                            <li class="list-inline-item user_area_li ">
                                <button type="button" class="login_link" data-toggle="modal" data-target="#main_login">
                                    <i class="fa fa-lock "></i>@lang('trs.login')
                                </button>
                            </li>
                            <li class="list-inline-item user_area_li"><a
                                        href="{{route('register').($lang!="de"? "?lang=".$lang : "")}}"><i
                                            class="fa fa-user-plus "></i>@lang('trs.register')</a></li>

                        @else

                            <li class="list-inline-item user_area_li "><a
                                        href="{{route('profile'). ($lang!="de"? "?lang=".$lang : "")}}"><i
                                            class="fas fa-user"></i> {{\Illuminate\Support\Facades\Auth::user()->f_name}} {{\Illuminate\Support\Facades\Auth::user()->l_name}}
                                </a></li>
                            <li class="list-inline-item user_area_li ">
                                @if(\Illuminate\Support\Facades\Auth::user()->role==\App\User::agency)
                                    @lang('trs.credit')
                                    : {{\Illuminate\Support\Facades\Auth::user()->balance ? \Illuminate\Support\Facades\Auth::user()->balance->amount : 0}}
                                    €
                                @endif
                            </li>
                            <li class="list-inline-item user_area_li"><a
                                        href="{{route('logout'). ($lang!="de"? "?lang=".$lang : "")}}"><i
                                            class="fas fa-sign-out-alt"></i> @lang('trs.log_out')</a></li>

                        @endif

                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="header-output">
        <div class="container header-in">
            <div class="row">
                <div class="col-lg-3 ">
                    <a id="logo" href="{{route('home'). ($lang!="de"? "?lang=".$lang : "")}}"
                       class="d-inline-block margin-tb-10px"><img src="images/{{$setting->logo}}"
                                                                  alt=""></a>
                    <a class="mobile-toggle"><i class="fas fa-bars"></i></a>
                </div>
                <div class="col-lg-9 position-inherit">
                    <ul id="menu-main" class="nav-menu float-right link-padding-tb-20px dropdown-dark">
                        <li class=" {{url()->current()==route('home') ? "active" : ""}}"><a
                                    href="{{route('home'). ($lang!="de"? "?lang=".$lang : "")}}">@lang('trs.home')</a>

                        </li>

                        @if(env('MENU_CIP'))
                            <li class="  {{url()->current()==route('cip_iran') ? "active" : ""}}"><a
                                        href="{{route('cip_iran'). ($lang!="de"? "?lang=".$lang : "")}}">@lang('trs.cip_iran')</a>

                            </li>
                        @endif

                        @if(env('MENU_BLOG'))

                            <li class="  {{url()->current()==route('blog') ? "active" : ""}} "><a
                                        href="{{route('blog'). ($lang!="de"? "?lang=".$lang : "")}}">@lang('trs.blog')</a>

                            </li>
                        @endif

                        @if(env('MENU_ABOUT_US'))

                            <li class="  {{url()->current()==route('about_us') ? "active" : ""}}"><a
                                        href="{{route('about_us'). ($lang!="de"? "?lang=".$lang : "")}}">@lang('trs.about_us')</a>

                            </li>
                        @endif

                        @if(env('MENU_CONTACT'))

                            <li class="  {{url()->current()==route('contact') ? "active" : ""}}"><a
                                        href="{{route('contact'). ($lang!="de"? "?lang=".$lang : "")}}">@lang('trs.contact')</a>

                            </li>
                        @endif

                        {{--                        <li class=" lang_menu ">--}}

                        {{--                            <a class="active_lang">--}}
                        {{--                                    <img src="flags/1x1/{{$flag}}.svg">--}}

                        {{--                            </a>--}}
                        {{--                            <div class="lang_bar">--}}
                        {{--                                <div class="lang_item"><a href="{{$lang_link."?lang=en"}}"><img src="flags/1x1/gb.svg" title="en" alt="en"></a></div>--}}
                        {{--                                <div class="lang_item"><a href="{{$lang_link."?lang=de"}}"><img src="flags/1x1/de.svg" title="de" alt="de"></a></div>--}}
                        {{--                                <div class="lang_item"><a href="{{$lang_link."?lang=fa"}}"><img src="flags/1x1/ir.svg" title="fa" alt="fa"></a></div>--}}
                        {{--                                <div class="lang_item"><a href="{{$lang_link."?lang=ru"}}"><img src="flags/1x1/ru.svg" title="ru" alt="ru"></a></div>--}}
                        {{--                            </div>--}}

                        {{--                        </li>--}}

                        <li class="has-dropdown"><a class="active_lang">
                                <img src="flags/1x1/{{$flag}}.svg">

                            </a>
                            <ul class="sub-menu lang_bar">
                                <li class="lang_item"><a href="{{$lang_link."?lang=en"}}"><img src="flags/1x1/gb.svg"
                                                                                               title="@lang('trs.english')"
                                                                                               alt="en"></a>
                                </li>
                                <li class="lang_item"><a href="{{$lang_link."?lang=de"}}"><img src="flags/1x1/de.svg"
                                                                                               title="@lang('trs.germany')"
                                                                                               alt="de"></a>
                                </li>
                                <li class="lang_item"><a href="{{$lang_link."?lang=fa"}}"><img src="flags/1x1/ir.svg"
                                                                                               title="@lang('trs.persian')"
                                                                                               alt="fa"></a>
                                </li>
                                {{--                                <li class="lang_item"><a href="{{$lang_link."?lang=ru"}}"><img src="flags/1x1/ru.svg"--}}
                                {{--                                                                                               title="@lang('trs.russia')"--}}
                                {{--                                                                                               alt="ru"></a>--}}
                                {{--                                </li>--}}


                            </ul>
                        </li>


                    </ul>


                </div>
            </div>
        </div>
    </div>
</header>
<!-- ======= end Header  ======= -->