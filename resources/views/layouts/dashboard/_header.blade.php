<header class="main-header">
    {{--<!-- Logo -->--}}
    <a href="{{ route('dashboard.index') }}" class="logo">
        {{--<!-- mini logo for sidebar mini 50x50 pixels -->--}}
        <span class="logo-mini"><b>Da</b>Sh</span>
        <span class="logo-lg"><b>Dash</b>Board</span>
    </a>
    <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </a>
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                {{--<!-- Tasks: style can be found in dropdown.less -->--}}
                <li class="dropdown tasks-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-flag-o"></i></a>
                    <ul class="dropdown-menu">
                        <li>
                            {{--<!-- inner menu: contains the actual data -->--}}
                            <ul class="menu">
                                @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                    <li>
                                        <a rel="alternate" hreflang="{{ $localeCode }}" href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                                            {{ $properties['native'] }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                    </ul>
                </li>

                {{--<!-- User Account: style can be found in dropdown.less -->--}}
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="{{ !empty(auth()->user()->image_path) ? auth()->user()->image_path : asset('dashboard_files/img/default.png') }}" class="user-image" alt="User Image">
                        <span class="hidden-xs">{{ !empty(auth()->user()->first_name) ? auth()->user()->first_name : 'Admin' }} {{ !empty(auth()->user()->last_name) ? auth()->user()->last_name : 'Name' }}</span>
                    </a>
                    <ul class="dropdown-menu">
                        {{--<!-- User image -->--}}
                        <li class="user-header">
                            <img src="{{ !empty(auth()->user()->image_path) ? auth()->user()->image_path : asset('dashboard_files/img/default.png') }}" class="img-circle" alt="User Image">
                            <p>
                                <span class="hidden-xs">{{ !empty(auth()->user()->first_name) ? auth()->user()->first_name : 'Admin' }} {{ !empty(auth()->user()->last_name) ? auth()->user()->last_name : 'Name' }}</span>
                                <small>Member since 2 days</small>
                            </p>
                        </li>
                        {{--<!-- Menu Footer-->--}}
                        <li class="user-footer">
                            <a href="{{ route('dashboard.users.show',auth()->user()->id) }}" class="btn btn-default btn-flat" style="margin-bottom:5px">@lang('site.profile')</a>
                            <a href="{{ route('logout') }}" class="btn btn-default btn-flat" onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">@lang('site.logout')</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>
