<!DOCTYPE html>
<!--[if IE 8]>
<html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]>
<html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<head>
    <meta charset="utf-8"/>
    <title>{{ $pageTitle or '' }} - {{ get_settings('site_title', 'WebEd') ?: 'WebEd' }}</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta content="{{ $pageTitle or '' }} - {{ get_settings('site_title', 'WebEd') ?: 'WebEd' }}" name="description"/>
    <meta content="" name="author"/>

    <base href="{{ asset('') }}">

    <link href="{{ asset('themes/startr/css/style.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('themes/startr/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('themes/startr/css/owl.carousel.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('themes/startr/css/responsive.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('themes/startr/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('themes/startr/css/animate.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('themes/startr/css/popup.css') }}" rel="stylesheet" type="text/css">

    @php do_action('front_header_css') @endphp
    @yield('css')

    <link rel="shortcut icon" href="{{ asset(get_settings('favicon')) }}"/>

    @php do_action('front_header_js') @endphp
</head>

<body class="{{ $bodyClass or '' }} @php do_action('front_body_class') @endphp">

<div class="site-wrapper" id="site_wrapper">
    <header class="site-header header-top" id="headere-top" role="header">
        @include('webed-theme-startr::front._partials.header')
    </header>

    <main class="site-main" id="main">
        @yield('content')
    </main>

    <footer class="site-footer" id="footer">
        @include('webed-theme-startr::front._partials.footer')
    </footer>

    @yield('other-content')
</div>

<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->

<script src="{{ asset('themes/startr/js/jquery.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('themes/startr/js/parallax.min.js') }}" type="text/javascript"></script>
<script type="text/javascript">
    $('.parallax-window').parallax({});
</script>

<script src="{{ asset('themes/startr/js/main.js') }}" type="text/javascript"></script>
<script src="{{ asset('themes/startr/js/owl.carousel.js') }}" type="text/javascript"></script>
<script src="{{ asset('https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false') }}" type="text/javascript"></script>
<script src="{{ asset('themes/startr/js/maps.js') }}" type="text/javascript"></script>
<script src="{{ asset('themes/startr/js/jquery.mb.YTPlayer.js') }}" type="text/javascript"></script>
<script src="{{ asset('themes/startr/js/video.js') }}" type="text/javascript"></script>
<script src="{{ asset('themes/startr/js/custom.js') }}" type="text/javascript"></script>
<script src="{{ asset('themes/startr/js/jquery.magnific-popup.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('themes/startr/js/jquery.contact.js') }}" type="text/javascript"></script>
<script src="{{ asset('themes/startr/js/bootstrap.min.js') }}" type="text/javascript"></script>
<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
@php do_action('front_footer_js') @endphp
@yield('js')
@yield('js-init')

</body>

</html>
