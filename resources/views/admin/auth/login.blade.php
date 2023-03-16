<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Admin | Log in</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
	{{-- <link rel="stylesheet" href="../../bower_components/bootstrap/dist/css/bootstrap.min.css"> --}}
	{!! \Html::style('adminlte/bower_components/bootstrap/dist/css/bootstrap.min.css') !!}
  <!-- Font Awesome -->
	{{-- <link rel="stylesheet" href="../../bower_components/font-awesome/css/font-awesome.min.css"> --}}
	{!! \Html::style('adminlte/bower_components/font-awesome/css/font-awesome.min.css') !!}
  <!-- Ionicons -->
	{{-- <link rel="stylesheet" href="../../bower_components/Ionicons/css/ionicons.min.css"> --}}
	{!! \Html::style('adminlte/bower_components/Ionicons/css/ionicons.min.css') !!}
  <!-- Theme style -->
	{{-- <link rel="stylesheet" href="../../dist/css/AdminLTE.min.css"> --}}
	{!! \Html::style('adminlte/dist/css/AdminLTE.min.css') !!}
  <!-- iCheck -->
	{{-- <link rel="stylesheet" href="../../plugins/iCheck/square/blue.css"> --}}
	{!! \Html::style('adminlte/plugins/iCheck/square/blue.css') !!}

    {!! \Html::style('plugin_admin/toastr/toastr.min.css') !!}

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="">{{ __('Login') }}</a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Sign in to start your session</p>

    <form action="{{ route('login.post') }}" method="post">
      @csrf
      <div class="form-group has-feedback">
        <input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Email">

        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          @if ($errors->has('email'))
            <span class="" >
                <strong>{{ $errors->first('email') }}</strong>
            </span>
          @endif
      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" name="password" placeholder="Password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        @if ($errors->has('password'))
            <span class="" >
                <strong>{{ $errors->first('password') }}</strong>
            </span>
        @endif
      </div>
      <div class="row">
        <div class="col-xs-8">
          <div class="checkbox icheck">
            <label>
{{--              <input type="checkbox"> {{ __('Remember Me') }}--}}
            </label>
          </div>
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat">{{ __('Login') }}</button>
        </div>
        <!-- /.col -->
      </div>
    </form>

    {{--<div class="social-auth-links text-center">--}}
    {{--  <p>- OR -</p>--}}
    {{--  <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign in using--}}
    {{--    Facebook</a>--}}
    {{--  <a href="#" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google-plus"></i> Sign in using--}}
    {{--    Google+</a>--}}
    {{--</div>--}}
    <!-- /.social-auth-links -->
    {{-- @if (Route::has('password.request'))
        <a class="btn btn-link" href="{{ route('password.request') }}">
          {{ __('Forgot Your Password?') }}
        </a>
	 	@endif --}}


{{--<a href="#">I forgot my password</a><br>--}}
{{--<a href="register.html" class="text-center">Register a new membership</a>--}}

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 3 -->
{{-- <script src="../../bower_components/jquery/dist/jquery.min.js"></script> --}}
{!! \Html::script('adminlte/bower_components/jquery/dist/jquery.min.js') !!}
<!-- Bootstrap 3.3.7 -->
{{-- <script src="../../bower_components/bootstrap/dist/js/bootstrap.min.js"></script> --}}
{!! \Html::script('adminlte/bower_components/bootstrap/dist/js/bootstrap.min.js') !!}
<!-- iCheck -->
{{-- <script src="../../plugins/iCheck/icheck.min.js"></script> --}}
{!! \Html::script('adminlte/plugins/iCheck/icheck.min.js') !!}

{!! \Html::script('plugin_admin/toastr/toastr.min.js') !!}
@include('admin.partials.notification')

<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' /* optional */
    });
  });
</script>
</body>
</html>
