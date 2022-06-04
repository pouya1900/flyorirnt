<!DOCTYPE html>
<html lang="en-US">

<head>
    <title>@lang('trs.tab_title')</title>
    <base href="{{route('home')}}">
    <meta name="author" content="Nile-Theme">
    <meta name="robots" content="index follow">
    <meta name="googlebot" content="index follow">
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <meta name="keywords" content="Travel, HTML5, CSS3, Hotel , Multipurpose, Template, Create a Travel website fast">
    <meta name="description" content="HTML5 Multipurpose Template, Create a website fast">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token()  }}">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,800|Poppins:300i,400,300,700,400i,500|Ubuntu:300i,400,300,700,400i,500|Raleway:400,500,600,700"
          rel="stylesheet">


    {{--    fav icon--}}
    <link rel="icon" href="images/{{$setting->favicon}}" type="image/gif" sizes="16x16">


    <!-- CSS Files -->


    <link rel="stylesheet" type="text/css" href="plugins/revslider/css/settings.css">

    <!-- Owl Carousel Assets -->
    <link href="css/owl.carousel.css" rel="stylesheet">
    <link href="css/owl.theme.css" rel="stylesheet">

    <link rel="stylesheet" href="fonts/font-awesome/css/all.min.css">
    <link rel="stylesheet" href="css/jquery-ui.css">

    <link rel="stylesheet" href="css/responsive.css">

    {{--    @if ($lang=='fa')--}}
{{--        <link rel="stylesheet" href="css/bootstrap-rtl.min.css">--}}
{{--        <link rel="stylesheet" href="css/rtl_style.css?ver=30">--}}

{{--    @else--}}
        <link rel="stylesheet" href="css/bootstrapa.css">
        <link rel="stylesheet" href="css/style.css?ver=30">
        <link rel="stylesheet" href="css/test_style.css?ver=2">

{{--    @endif    --}}

    <link rel="stylesheet" href="css/swiper.min.css">
    <link rel="stylesheet" href="css/media_style.css">


    <script type="text/javascript" src="js/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="js/loading.js"></script>

    <!-- REVOLUTION JS FILES -->
    <script type="text/javascript" src="plugins/revslider/js/jquery.themepunch.tools.min.js"></script>
    <script type="text/javascript" src="plugins/revslider/js/jquery.themepunch.revolution.min.js"></script>

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
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>

    <!--DATA PICKER FILE-->
    <script src="js/moment.min.js"></script>
    <script src="js/caleran.min.js"></script>
    <link href="css/caleran.min.css" rel="stylesheet" />



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

    @include('layouts.partials.analytic')

</head>

<body>

@yield('content')


@include('front.partials.ajax_translate')

<script type="text/javascript" src="js/sticky-sidebar.js"></script>
<script type="text/javascript" src="js/custom.js"></script>
<script src="js/owl.carousel.min.js"></script>
<script type="text/javascript" src="js/jquery-ui.js"></script>
<script type="text/javascript" src="js/popper.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/swiper.min.js"></script>

@yield('script')

</body>

</html>
