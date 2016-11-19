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
    <title>{{ $pageTitle or 'Dashboard' }} | WebEd</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta content="Admin dashboard - WebEd" name="description"/>

    <base href="{{ asset('') }}">

    {!! \Assets::renderStylesheets() !!}

    @php do_action('header_css') @endphp

    @yield('css')

    <link rel="shortcut icon" href="{{ asset(get_settings('favicon')) }}"/>

    <script type="text/javascript">
        var BASE_URL = '{{ asset('') }}',
            FILE_MANAGER_URL = '{{ route('admin::elfinder.popup.get') }}';
    </script>

    {{--BEGIN plugins--}}
    {!! \Assets::renderScripts('top') !!}
    {{--END plugins--}}

    @php do_action('header_js') @endphp
</head>

<body class="{{ $bodyClass or '' }} skin-purple sidebar-mini on-loading @php do_action('body_class') @endphp">

<!-- Loading state -->
<div class="page-spinner-bar">
    <div class="bounce1"></div>
    <div class="bounce2"></div>
    <div class="bounce3"></div>
</div>
<!-- Loading state -->

<div class="wrapper">
    {{--BEGIN Header--}}
    @include('webed-core::admin._partials.header')
    {{--END Header--}}

    {{--BEGIN Sidebar--}}
    @include('webed-core::admin._partials.sidebar')
    {{--END Sidebar--}}

    <div class="content-wrapper">
        <section class="content-header">
            {{--BEGIN Page title--}}
            @include('webed-core::admin._partials.page-title')
            {{--END Page title--}}
            {{--BEGIN Breadcrumbs--}}
            @include('webed-core::admin._partials.breadcrumbs')
            {{--END Breadcrumbs--}}
        </section>

        <section class="content">
            {{--BEGIN Flash messages--}}
            @include('webed-core::admin._partials.flash-messages')
            {{--END Flash messages--}}

            {{--BEGIN Content--}}
            @yield('content')
            {{--END Content--}}
        </section>
    </div>

    {{--BEGIN Footer--}}
    @include('webed-core::admin._partials.footer')
    {{--END Footer--}}

    {{--BEGIN control sidebar--}}
    @include('webed-core::admin._partials.control-sidebar')
    {{--END control sidebar--}}
</div>

{{--Modals--}}
@include('webed-core::admin._partials.modals')

<!--[if lt IE 9]>
<script src="{{ asset('admin/plugins/respond.min.js') }}"></script>
<script src="{{ asset('admin/plugins/excanvas.min.js') }}"></script>
<![endif]-->

{{--BEGIN plugins--}}
{!! \Assets::renderScripts('bottom') !!}
{{--END plugins--}}

@php do_action('footer_js') @endphp

@yield('js')

@yield('js-init')

</body>

</html>
