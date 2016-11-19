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

    @php do_action('front_header_css') @endphp
    <link href="{{ asset('themes/clean-blog/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('themes/clean-blog/css/clean-blog.min.css') }}" rel="stylesheet">
    @yield('css')

    <link rel="shortcut icon" href="{{ asset(get_settings('favicon')) }}"/>

    <link href="{{ asset('themes/clean-blog/vendor/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>

    @php do_action('front_header_js') @endphp
</head>

<body class="{{ $bodyClass or '' }} @php do_action('front_body_class') @endphp">

<div class="site-wrapper" id="site_wrapper">
    <header class="site-header" id="header">
        @include('webed-theme-clean-blog::front._partials.header')
    </header>

    <main class="site-main" id="main">
        @yield('content')
    </main>

    <footer class="site-footer" id="footer">
        @include('webed-theme-clean-blog::front._partials.footer')
    </footer>
</div>

<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->

<script src="{{ asset('themes/clean-blog/vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('themes/clean-blog/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('themes/clean-blog/js/jqBootstrapValidation.js') }}"></script>
<script src="{{ asset('themes/clean-blog/js/contact_me.js') }}"></script>
<script src="{{ asset('themes/clean-blog/js/clean-blog.min.js') }}"></script>

@php do_action('front_footer_js') @endphp
@yield('js')
@yield('js-init')

</body>

</html>
