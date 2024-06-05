<!DOCTYPE html>
<html lang="{{$lang=="en" ? "en-US" : $lang}}">

<head>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-TEJW3VCC57"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }

        gtag('js', new Date());

        gtag('config', 'G-TEJW3VCC57');
    </script>


    <title>@lang('trs.tab_title')</title>
    <base href="{{route('home')}}">
    <meta name="author" content="Nile-Theme">
    <meta name="robots" content="index follow">
    <meta name="googlebot" content="index follow">
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta name="keywords"
          content="booking , flugticket , travel , flight , hotel , flug , پرواز , بلیط , هواپیما , رزرو">
    <meta name="description"
          content="Flüge nach Teheran,Flüge nach Teheran mit Iran Air,Flights to Tehran,Flights to Tehran with Iran Air,پرواز به ایران,پرواز به ایران با ایران ایر">
    <meta name="viewport" content="width=device-width, initial-scale=1.0 user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token()  }}">
    <!-- Google Fonts -->
    <link href="css/font-loader.css"
          rel="stylesheet">
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])


    {{--    fav icon--}}
    <link rel="icon" href="images/{{$setting->favicon}}" type="image/gif" sizes="16x16">

    <!-- CSS Files -->

    <link rel="stylesheet" type="text/css" href="plugins/revslider/css/settings.css">

    <!-- Owl Carousel Assets -->
    <link href="css/owl.carousel.css" rel="stylesheet">
    <link href="css/owl.theme.css" rel="stylesheet">

    <link rel="stylesheet" href="fonts/font-awesome/css/all.min.css">
    <link rel="stylesheet" href="css/jquery-ui.min.css">
    <link rel="stylesheet" href="css/responsive.min.css">

    @if($lang=='ru')
        <link rel="stylesheet" href="css/ru_font.css">
    @endif

    @if ($lang=='fa')
        <link rel="stylesheet" href="css/bootstrap-rtl.min.css">
        <link rel="stylesheet" href="css/rtl_style.css">

    @else
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/style1.min.css">

    @endif
    <link rel="stylesheet" href="css/test_style.css">

    <link rel="stylesheet" href="css/swiper.min.css">
    <link rel="stylesheet" href="css/media_style.min.css?ver=1">


    <script type="text/javascript" src="js/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="js/loading.js"></script>

    <input type="hidden" name="privacy_link" value="{{route('privacy'). ($lang!="de"? "?lang=".$lang : "")}}">
    <script type="text/javascript" src="assets/js/ct-ultimate-gdpr.min.js"></script>

    @if($lang=='de')
        <script type="text/javascript" src="assets/js/init_DE.js"></script>
    @elseif($lang=='ru')
        <script type="text/javascript" src="assets/js/init_RU.js"></script>
    @else
        <script type="text/javascript" src="assets/js/init.js"></script>
    @endif

<!-- REVOLUTION JS FILES -->
    <script type="text/javascript" src="plugins/revslider/js/jquery.themepunch.tools.min.js"></script>
    <script type="text/javascript" src="plugins/revslider/js/jquery.themepunch.revolution.min.js"></script>
    <script type="text/javascript" src="js/jquery.ui.touch-punch.min.js"></script>

    <!-- SLIDER REVOLUTION 5.0 EXTENSIONS  (Load Extensions only on Local File Systems !  The following part can be removed on Server for On Demand Loading) -->
    <script type="text/javascript" src="plugins/revslider/js/extensions/revolution.extension.actions.min.js"></script>
    <script type="text/javascript" src="plugins/revslider/js/extensions/revolution.extension.carousel.min.js"></script>
    <script type="text/javascript" src="plugins/revslider/js/extensions/revolution.extension.kenburn.min.js"></script>
    <script type="text/javascript"
            src="plugins/revslider/js/extensions/revolution.extension.layeranimation.min.js"></script>
    <script type="text/javascript" src="plugins/revslider/js/extensions/revolution.extension.migration.min.js"></script>
    <script type="text/javascript"
            src="plugins/revslider/js/extensions/revolution.extension.navigation.min.js"></script>
    <script type="text/javascript" src="plugins/revslider/js/extensions/revolution.extension.parallax.min.js"></script>
    <script type="text/javascript"
            src="plugins/revslider/js/extensions/revolution.extension.slideanims.min.js"></script>
    <script type="text/javascript" src="plugins/revslider/js/extensions/revolution.extension.video.min.js"></script>
    {{--    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>--}}

<!--DATA PICKER FILE-->
    <script src="js/moment.min.js"></script>
    <script src="js/caleran.min.js?ver=2"></script>
    <link href="css/caleran.min.css" rel="stylesheet"/>


    <style type="text/css">
        #rev_slider_3_1_wrapper .tp-loader.spinner4 {
            background-color: #ffffff !important;
        }

        .hephaistos .tp-bullet {
            width: 12px;
            height: 12px;
            position: absolute;
            background: rgba(153, 153, 153, 0);
            border: 3px solid rgba(29, 184, 193, 0.9);
            border-radius: 50%;
            cursor: pointer;
            box-sizing: content-box;
            box-shadow: 0px 0px 2px 1px rgba(130, 130, 130, 0.3)
        }

        .hephaistos .tp-bullet:hover,
        .hephaistos .tp-bullet.selected {
            background: rgba(255, 255, 255, 0);
            border-color: rgba(220, 36, 38, 1)
        }

    </style>

    @yield('style')

    @include('layouts.partials.analytic')
</head>

<body>
@include('front.partials.ajax_loader')
@include('front.partials.load_screen')
@include('front.payment.booking_loader')
@include('front.partials.login_modal')
@include('front.partials.nav')
@yield('content')

@include('front.partials.footer')
@include('front.partials.ajax_translate')


<script type="text/javascript" src="js/sticky-sidebar.min.js"></script>
<script type="text/javascript" src="js/custom12411.min.js?"></script>
<script src="js/owl.carousel.min.js"></script>
<script type="text/javascript" src="js/jquery-ui.min.js"></script>
<script type="text/javascript" src="js/popper.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/swiper.min.js"></script>

@yield('script')

</body>

</html>
