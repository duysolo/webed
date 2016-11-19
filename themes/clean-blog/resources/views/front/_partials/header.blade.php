<!-- Navigation -->
<nav class="navbar navbar-default navbar-custom navbar-fixed-top">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header page-scroll">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                Menu <i class="fa fa-bars"></i>
            </button>
            <a class="navbar-brand" href="{{ url('') }}">WebEd starter page</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        {!! $cmsMenuHtml or '' !!}
    </div>
    <!-- /.container -->
</nav>

<!-- Set your background image for this header on the line below. -->
<div class="intro-header" style="background-image: url('{{ asset('themes/clean-blog/img/home-bg.jpg') }}')">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                <div class="site-heading">
                    <h1>{{ $object->title or '' }}</h1>
                    <hr class="small">
                    <span class="subheading">Bootstrap your site with WebEd CMS today!</span>
                </div>
            </div>
        </div>
    </div>
</div>
