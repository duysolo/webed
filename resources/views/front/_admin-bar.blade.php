<nav id="admin_bar">
    <div class="admin-bar-container">
        <div class="admin-bar-logo">
            <a class="navbar-brand" href="{{ route('admin::dashboard.index.get') }}" title="Go to dashboard">
                WebEd CMS
            </a>
        </div>
        <ul class="admin-navbar-nav">
            @foreach(\AdminBar::getGroups() as $slug => $group)
                @if(array_get($group, 'items'))
                    <li class="admin-bar-dropdown">
                        <a href="{{ array_get($group, 'link') }}" class="dropdown-toggle">
                            {{ array_get($group, 'title') }}
                        </a>
                        <ul class="admin-bar-dropdown-menu">
                            @foreach(array_get($group, 'items', []) as $title => $link)
                                <li>
                                    <a href="{{ $link or '' }}">
                                        {{ $title or '' }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                @endif
            @endforeach
            @foreach(\AdminBar::getLinksNoGroup() as $item)
                <li>
                    <a href="{{ array_get($item, 'link') }}">{{ array_get($item, 'title') }}</a>
                </li>
            @endforeach
        </ul>
        <ul class="admin-navbar-nav admin-navbar-nav-right">
            <li class="admin-bar-dropdown">
                <a href="" class="dropdown-toggle">
                    {{ $loggedInUser->username }}
                </a>
                <ul class="admin-bar-dropdown-menu">
                    <li>
                        <a href="{{ route('admin::users.edit.get', ['id' => $loggedInUser->id, '_tab' => 'user_profiles']) }}">Profiles</a>
                    </li>
                    <li>
                        <a href="{{ route('admin::users.edit.get', ['id' => $loggedInUser->id, '_tab' => 'change_avatar']) }}">Change
                            avatar</a>
                    </li>
                    <li>
                        <a href="{{ route('admin::users.edit.get', ['id' => $loggedInUser->id, '_tab' => 'change_password']) }}">Change
                            password</a>
                    </li>
                    <li>
                        <a href="{{ route('admin::auth.logout.get') }}">Logout</a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</nav>
<script type="text/javascript">
    var the_body = document.getElementsByTagName('body')[0];
    the_body.classList.add('show-admin-bar');
</script>
