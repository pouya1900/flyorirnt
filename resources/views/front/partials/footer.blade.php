<!-- ======= footer  ======= -->
<footer id="footer" class="background-dark text-center text-lg-left text-white">
    <div class="container">
        <div class="row padding-tb-100px">
            <div class="col-lg-6">
                <div class="about">
                    <div class="logo margin-bottom-20px"><a
                                href="{{route('home'). ($lang!="de"? "?lang=".$lang : "")}}"><img
                                    src="images/logo-light.png"></a></div>
                    <p class="text-grey-2">
                        @lang('trs.footer_text')
                    </p>
                </div>
            </div>
            <div class="col-lg-3 text-left sm-mb-40px">
                <ul class="footer-menu row margin-0px padding-0px list-unstyled">
                    <li class="col-6 padding-tb-5px footer_menu_item"><a
                                href="{{route('privacy'). ($lang!="de"? "?lang=".$lang : "")}}"
                                class="text-main-color">@lang('trs.privacy')</a></li>
                    <li class="col-6 padding-tb-5px footer_menu_item"><a
                                href="{{route('imprint'). ($lang!="de"? "?lang=".$lang : "")}}"
                                class="text-main-color">@lang('trs.imprint')</a></li>
                    <li class="col-6 padding-tb-5px footer_menu_item"><a
                                href="{{route('AGB'). ($lang!="de"? "?lang=".$lang : "")}}"
                                class="text-main-color">@lang('trs.AGB')</a></li>
                    <li class="col-6 padding-tb-5px footer_menu_item"><a
                                href="{{route('faqs'). ($lang!="de"? "?lang=".$lang : "")}}"
                                class="text-main-color">@lang('trs.FAQ')</a></li>
                    <li class="col-6 padding-tb-5px footer_menu_item"><a
                                href="{{route('airlines.index'). ($lang!="de"? "?lang=".$lang : "")}}"
                                class="text-main-color">@lang('trs.agb_of_airlines')</a></li>

                </ul>
            </div>
            <div class="col-lg-3">
                <ul class="images-feed row no-gutters margin-0px padding-0px list-unstyled">
                    <li class="col-4  padding-tb-5px"><a href="#" class="padding-lr-5px d-block"><img
                                    src="pics/400x400_1.jpg" alt=""></a></li>
                    <li class="col-4 padding-tb-5px"><a href="#" class="padding-lr-5px d-block"><img
                                    src="pics/400x400_2.jpg" alt=""></a></li>
                    <li class="col-4 adding-tb-5px"><a href="#" class="padding-lr-5px d-block"><img
                                    src="pics/400x400_3.jpg" alt=""></a></li>
                    <li class="col-4 padding-tb-5px"><a href="#" class="padding-lr-5px d-block"><img
                                    src="pics/400x400_4.jpg" alt=""></a></li>
                    <li class="col-4 padding-tb-5px"><a href="#" class="padding-lr-5px d-block"><img
                                    src="pics/400x400_5.jpg" alt=""></a></li>
                    <li class="col-4 padding-tb-5px"><a href="#" class="padding-lr-5px d-block"><img
                                    src="pics/400x400_6.jpg" alt=""></a></li>
                </ul>
            </div>
        </div>

        <div class="row padding-tb-30px border-top-1 border-grey-3">
            <div class="col-lg-4">
                <p class="text-sm-center text-lg-left"><span class="text-grey-1">{{$setting->site_title}}</span> |
                    @ {{ date('Y',strtotime('now')) }} @lang('trs.copy_right_text')</p>
            </div>
            <div class="col-lg-4 sm-mb-20px">
                <div class="text-center"><img src="images/cards.png" alt=""></div>
            </div>
            <div class="col-lg-4">
                <ul class="social_link list-inline text-sm-center text-lg-right">
                    <li class="list-inline-item"><a class="facebook" href="#"><i class="fa fa-facebook"
                                                                                 aria-hidden="true"></i></a></li>
                    <li class="list-inline-item"><a class="youtube" href="#"><i class="fa fa-youtube-play"
                                                                                aria-hidden="true"></i></a></li>
                    <li class="list-inline-item"><a class="linkedin" href="#"><i class="fa fa-linkedin"
                                                                                 aria-hidden="true"></i></a></li>
                    <li class="list-inline-item"><a class="google" href="#"><i class="fa fa-google-plus"
                                                                               aria-hidden="true"></i></a></li>
                    <li class="list-inline-item"><a class="twitter" href="#"><i class="fa fa-twitter"
                                                                                aria-hidden="true"></i></a></li>
                    <li class="list-inline-item"><a class="rss" href="#"><i class="fa fa-rss"
                                                                            aria-hidden="true"></i></a></li>
                </ul>
                <!-- // Social -->
            </div>
        </div>

    </div>

</footer>
<!-- ======= end footer  ======= -->