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
