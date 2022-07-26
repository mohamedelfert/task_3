<aside class="main-sidebar">
    <section class="sidebar">
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{ !empty(auth()->user()->image_path) ? auth()->user()->image_path : asset('dashboard_files/img/default.png') }}" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>{{ !empty(auth()->user()->first_name) ? auth()->user()->first_name : 'Admin' }} {{ !empty(auth()->user()->last_name) ? auth()->user()->last_name : 'Name' }}</p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
{{--        <br>--}}
        <ul class="sidebar-menu" data-widget="tree">
            <li><a href="{{ route( 'dashboard.index')}}"><i class="fa fa-dashboard"></i><span>@lang('site.dashboard')</span></a></li>

            @if (auth()->user()->hasPermission('users_read'))
                <li><a href="{{ route('dashboard.users.index') }}"><i class="fa fa-users"></i><span>@lang('site.users')</span></a></li>
            @endif

            @if (auth()->user()->hasPermission('users_read'))
                <li><a href="{{ route('dashboard.categories.index') }}"><i class="fa fa-bookmark"></i><span>@lang('site.categories')</span></a></li>
            @endif

            @if (auth()->user()->hasPermission('users_read'))
                <li><a href="{{ route('dashboard.products.index') }}"><i class="fa fa-th-list"></i><span>@lang('site.products')</span></a></li>
            @endif
        </ul>
    </section>
</aside>

