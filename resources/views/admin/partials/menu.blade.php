<!-- sidebar: style can be found in sidebar.less -->
<section class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel">
        <div class="pull-left image">
            <img src="{{ asset("adminlte/dist/img/user2-160x160.jpg") }}" class="img-circle" alt="User Image">
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

        <li class="treeview">
            <a href="#">
                <i class="fa fa-users"></i> <span>@lang('menu.users')</span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu">
                <li><a href="{{ route('user.index') }}"><i class="fa fa-hand-o-right"></i>@lang('menu.listusers')</a></li>
            </ul>
        </li>





        {{--<li><a href="#"><i class="fa fa-users"></i> <span>Documentation</span></a></li>--}}

    </ul>
</section>
<!-- /.sidebar -->
