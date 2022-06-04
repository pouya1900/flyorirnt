<!DOCTYPE html>
<html lang="en-US">

<head>
    <title>@lang('trs.tab_title')</title>
    <base href="{{route('admin.home')}}">
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


    <link rel="stylesheet" href="css/jquery-ui.css">


    <script type="text/javascript" src="js/jquery-3.2.1.min.js"></script>

    <script src="https://cdn.ckeditor.com/ckeditor5/16.0.0/classic/ckeditor.js"></script>


    @include('layouts.partials.links')

    @yield('style')

</head>

<body class="skin-red sidebar-mini fixed sidebar-mini-expand-feature">


<div class="wrapper">

    @include('layouts.partials.header')

    @include('layouts.partials.sidebar')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1> @yield('content-header') </h1>
            <ol class="breadcrumb">
                <li><a href="{{ url('/') }}"><i class="fa fa-connectdevelop "></i> Home</a></li>
                @yield('breadcrumb')
            </ol>
        </section>

        @yield('content')

    </div>

    @include('layouts.partials.footer')

</div>

@include('layouts.partials.scripts')


<script type="text/javascript" src="js/custom.js"></script>
<script type="text/javascript" src="js/panel/custom.js"></script>
<script type="text/javascript" src="js/jquery-ui.js"></script>

@yield('script')

</body>

</html>
