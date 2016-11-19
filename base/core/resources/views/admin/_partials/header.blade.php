<header class="main-header">
    <!-- Logo -->
    <a href="/" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b>LWD</b></span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg">Lara<b>WebEd</b></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </a>
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <li class="dropdown user-menu">
                    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown"
                       data-close-others="true">
                        <img alt=""
                             class="img-circle user-image"
                             src="{{ $loggedInUser->resolved_avatar or '' }}"
                             width="25"
                             height="25">
                        <span class="hidden-xs">{{ $loggedInUser->display_name or '' }}</span>
                        <span class="fa fa-angle-down"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <img alt=""
                                 class="img-circle"
                                 src="{{ $loggedInUser->resolved_avatar or '' }}">
                            <p>{{ $loggedInUser->display_name or '' }}</p>
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="{{ route('admin::users.edit.get', ['id' => $loggedInUser->id]) }}" class="btn btn-default btn-flat">
                                    <i class="icon-user"></i> Profile
                                </a>
                            </div>
                            <div class="pull-right">
                                <a href="{{ route('admin::auth.logout.get') }}" class="btn btn-default btn-flat">
                                    <i class="icon-logout"></i> Sign out
                                </a>
                            </div>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                </li>
            </ul>
        </div>
    </nav>
</header>
