<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title> @yield('title') </title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    {!! \Html::style('adminlte/bower_components/bootstrap/dist/css/bootstrap.min.css') !!}
    <!-- Font Awesome -->
    {!! \Html::style('adminlte/bower_components/font-awesome/css/font-awesome.min.css') !!}
    <!-- Ionicons -->
    {!! \Html::style('adminlte/bower_components/Ionicons/css/ionicons.min.css') !!}
    <!-- jvectormap -->
    {!! \Html::style('adminlte/bower_components/jvectormap/jquery-jvectormap.css') !!}
    <!-- Theme style -->
    {!! \Html::style('adminlte/dist/css/AdminLTE.min.css') !!}
    {!! \Html::style('plugin_admin/toastr/toastr.min.css') !!}

    <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
    {!! \Html::style('adminlte/dist/css/skins/_all-skins.min.css') !!}
    {!! \Html::style('css/common.css') !!}
    @yield('css_global')
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

</head>

<body class="hold-transition skin-blue sidebar-mini">
    <div class="preloading">
        <div id="preload" class="preload-container text-center">
        </div>
    </div>


    <div class="wrapper">

        <div class="top-header">
            @include('admin.partials.heade_top')
        </div>
        <!-- Left side column. contains the logo and sidebar -->
        <aside class="main-sidebar">
            @include('admin.partials.menu')
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            @yield('breadcrumb')

            <!-- Main content -->
            <section class="content">
                @yield('content')
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <footer class="main-footer">
            <div class="pull-right hidden-xs">
                <b>Version</b> 2.4.0
            </div>
            <strong>Copyright &copy; 2019-2022 <a href="#">Admin System</a>.</strong> All rights
            reserved.
        </footer>
        <div class="right_header_admin">
            @include('admin.partials.right_heade')
        </div>
        <!-- Add the sidebar's background. This div must be placed
        immediately after the control sidebar -->
        <div class="control-sidebar-bg"></div>

    </div>
    <!-- ./wrapper -->

    <!-- jQuery 3 -->
    {!! \Html::script('adminlte/bower_components/jquery/dist/jquery.min.js') !!}
    <!-- Bootstrap 3.3.7 -->
    {!! \Html::script('adminlte/bower_components/bootstrap/dist/js/bootstrap.min.js') !!}
    <!-- FastClick -->
    {!! \Html::script('adminlte/bower_components/fastclick/lib/fastclick.js') !!}
    <!-- AdminLTE App -->
    {!! \Html::script('adminlte/dist/js/adminlte.min.js') !!}
    <!-- Sparkline -->
    {!! \Html::script('adminlte/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js') !!}
    <!-- jvectormap  -->
    {!! \Html::script('adminlte/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js') !!}
    {!! \Html::script('adminlte/plugins/jvectormap/jquery-jvectormap-world-mill-en.js') !!}
    <!-- SlimScroll -->
    {!! \Html::script('adminlte/bower_components/jquery-slimscroll/jquery.slimscroll.min.js') !!}
    <!-- ChartJS -->
    {{-- {!! \Html::script('adminlte/bower_components/chart.js/Chart.js') !!} --}}
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    {{-- {!! \Html::script('adminlte/dist/js/pages/dashboard2.js') !!} --}}
    {!! \Html::script('js/common.js') !!}
    <!-- AdminLTE for demo purposes -->
    {!! \Html::script('adminlte/dist/js/demo.js') !!}
    {!! \Html::script('sweetalert/sweetalert.min.js') !!}
    {!! \Html::script('plugin_admin/toastr/toastr.min.js') !!}
    @yield('script')
    @include('admin.partials.notification')

    <script>
        $(document).ready(function () {
            $(".removeRecord").click(function () {
                let url = $(this).data('url');
                console.log(url);
                swal({
                    title: "Bạn có chắc chắn không?",
                    text: "Sau khi xóa, bạn sẽ không thể khôi phục tệp tưởng tượng này!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                    .then((willDelete) => {
                        if (willDelete) {
                            $.ajax({
                                type: 'DELETE',
                                dataType: 'json',
                                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                                data: {
                                    _method: 'DELETE',
                                    "_token": "{{ csrf_token() }}"
                                },
                                url,
                                success: function (data) {
                                    window.location.reload();
                                }
                            });
                        }
                    });
            });
        });
        $(window).one("load", function() {
            $("body").removeClass('preloading');
            $(".preload-container").delay(1000).hide();
        });
    </script>

</body>

</html>
