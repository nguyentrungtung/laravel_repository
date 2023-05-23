<!-- sidebar: style can be found in sidebar.less -->
<section class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel">
        <div class="pull-left image">
            <img src="{{ asset('adminlte/dist/img/user2-160x160.jpg') }}" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
            <p>{{ Auth::user()->name }}</p>
            <a href="#"><i class="fa fa-circle text-success"></i> </a>
        </div>
    </div>
    <!-- search form -->
    <!-- /.search form -->
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu" data-widget="tree">
        <li class="header"></li>
        <li><a href="{{ route('home.index') }}"><i class="fa fa-dashboard"></i> <span>@lang('menu.home')</span></a></li>

{{--        @if(auth()->user()->checkPermissionTo('list user'))--}}
        <li class="treeview">
            <a href="#">
                <i class="fa fa-users"></i> <span>@lang('menu.users')</span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu">
{{--                @if(auth()->user()->checkPermissionTo('list user'))--}}
                    <li><a href="{{ route('user.index') }}"><i class="fa fa-hand-o-right"></i>@lang('menu.listusers')</a></li>
{{--                @endif--}}
{{--                @if(auth()->user()->checkPermissionTo('list user'))--}}
                <li>
                    <a href="{{ route('rolepermission.index') }}"><i class="fa fa-hand-o-right"></i>@lang('menu.listrolepermission')</a>
                </li>
{{--                @endif--}}
            </ul>
        </li>
{{--        @endif--}}
        @if(auth()->user()->checkPermissionTo('list banner'))
        <li class="treeview">
            <a href="#">
                <i class="fa fa-tag"></i> <span>@lang('menu.banner')</span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu">
                @if(auth()->user()->checkPermissionTo('list banner'))
                <li><a href="{{ route('banner.index') }}"><i
                            class="fa fa-hand-o-right"></i>@lang('menu.banner')</a>
                </li>
                @endif
            </ul>
        </li>
        @endif

        <li class="treeview">
            <a href="#">
                <i class="fa fa-book"></i> <span>@lang('menu.post')</span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu">
                 @if(auth()->user()->checkPermissionTo('list bai viet'))
                <li><a href="{{ route('post.index') }}"><i class="fa fa-hand-o-right"></i>@lang('menu.post')</a>
                </li>
                @endif
                @if(auth()->user()->checkPermissionTo('list danh muc bai viet'))
                <li><a href="{{ route('postcategory.index') }}"><i class="fa fa-hand-o-right"></i>@lang('menu.postCategory')</a>
                </li>
                @endif
                @if(auth()->user()->checkPermissionTo('list binh luan bai viet'))
                <li><a href="{{ route('postcomment.index') }}"><i
                    class="fa fa-hand-o-right"></i>@lang('menu.postComment')</a>
                </li>
                @endif
            </ul>
        </li>
        @if(auth()->user()->checkPermissionTo('list lien ket link'))
        <li class="treeview">
            <a href="#">
                <i class="fa fa-heart"></i> <span>@lang('menu.redirect')</span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu">
                @if(auth()->user()->checkPermissionTo('list lien ket link'))
                <li><a href="{{ route('redirect.index') }}"><i class="fa fa-hand-o-right"></i>@lang('menu.redirect')</a></li>
                @endif
            </ul>
        </li>
        @endif
        @if(auth()->user()->checkPermissionTo('view media'))
        <li class="treeview">
            <a href="#">
                <i class="fa fa-heart"></i> <span>Mangager Media</span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu">
                @if(auth()->user()->checkPermissionTo('view media'))
                <li><a href="{{ route('media.index') }}"><i class="fa fa-hand-o-right"></i>Mangager Media</a></li>
                @endif
            </ul>
        </li>
        @endif

        <li class="treeview">
            <a href="#">
                <i class="fa fa-users"></i> <span>Demo</span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu">
                <li><a href="{{ route('demo.index') }}"><i class="fa fa-hand-o-right"></i>List</a></li>
                <li><a href="{{ route('demo.create') }}"><i class="fa fa-hand-o-right"></i>Create</a></li>
            </ul>
        </li>

        <li class="header">Config</li>
        <li><a href="{{ route('log.index') }}"><i class="fa fa-circle-o text-aqua"></i>Log</a>
        </li>
        {{-- <li><a href="#"><i class="fa fa-users"></i> <span>Documentation</span></a></li> --}}

    </ul>
</section>
<!-- /.sidebar -->
