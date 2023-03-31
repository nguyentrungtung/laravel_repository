@extends('admin.layouts.app')

@section('titel','Home Admin')
@section('css_global')
    {!! \Html::style('adminlte/bower_components/select2/dist/css/select2.min.css') !!}
@endsection

@section('breadcrumb')
    <section class="content-header">
        <h1>
            {{ $title ? $title : '' }}
            <small>{{ $subTitle ? $subTitle : '' }}</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{route('home.index')}}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li> <a href="{{ route('user.index') }}"> User </a></li>
            <li class="active"> <a href="{{ route('user.create') }}"> User</a></li>
        </ol>
    </section>
@endsection()

@section('content')
    <div class="row">
        <div class="col-lg-3"></div>
        <div class="col-lg-6">
            <div class="box">
                <div class="box-body warper_form">
                    @php
                        $route = empty($user) ? 'user.store' : ['user.update', $user->id];
                        $method = empty($user) ? 'POST' : 'PUT';
                        $userRole = $user->role ?? "";
                    @endphp
                    {!! Form::open(['route' => $route, 'method' => $method, 'class' => 'form-horizontal', 'user' => 'form']) !!}

                    <h4 class="form-header text-uppercase">

                    </h4>
                    <div class="form-group row">
                        <label for="input-1" class="col-sm-2 col-form-label">Full Name</label>
                        <div class="col-sm-10">
                            {{ Form::text('name', $user->name  ?? '', ['class' => 'form-control'])}}
                            @if ($errors->has('name'))
                                <i class="error_validate">{{ $errors->first('name') }}</i>
                            @endif
                        </div>
                    </div>
                    {{-- end name --}}

                    <div class="form-group row">
                        <label for="input-3" class="col-sm-2 col-form-label">E-mail</label>
                        <div class="col-sm-10">
                            {{ Form::text('email', $user->email ?? '', ['class' => 'form-control', isset($user->id) ? 'readonly' : ''])}}
                            @if ($errors->has('email'))
                                <i class="error_validate">{{ $errors->first('email') }}</i>
                            @endif
                        </div>
                    </div>
                    {{-- end email --}}

                    <div class="form-group row">
                        <label for="password" class="col-sm-2 control-label"> {{ empty($user->id) ? 'Password' : 'Change Password' }} </label>
                        <div class="col-sm-10">
                            {{ Form::password('password', ['id' => 'password','class' => 'form-control', 'placeholder' => 'password', empty($user->id) ? 'required' : ''])}}
                            @if ($errors->has('password'))
                                <i class="error_validate">{{ $errors->first('password') }}</i>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="confirm_password" class="col-sm-2 control-label">Confirm password </label>
                        <div class="col-sm-10">
                            {{ Form::password('password_confirmation', ['id' => 'validatedForm','class' => 'form-control', 'placeholder' => 'Confirm password', empty($user->id) ? 'required' : ''])}}
                            @if ($errors->has('password_confirmation'))
                                <i class="error_validate">{{ $errors->first('password_confirmation') }}</i>
                            @endif
                            {{--{{ Form::password('confirm_password',null, ['class' => 'form-control','id' => 'validatedForm'])}}--}}
                        </div>
                    </div>
                    {{-- end password --}}

                    <div class="box-footer">
                        <div class="form-group row">
                            <label for="input01" class="col-sm-2 control-label"></label>
                            <div class="col-sm-8">
                                <button type="submit" class="btn btn-primary"> Save</button>
                                <button type="reset" class="btn btn-default btn-reset-form"> Reset</button>
                            </div>
                        </div>
                    </div>

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
        <div class="col-lg-3"></div>
    </div><!--End Row-->
@endsection()

@section('script')
    {!! \Html::script('adminlte/bower_components/select2/dist/js/select2.full.min.js') !!}
    <script type="text/javascript">
        $('.btn-reset-form').on('click', '', function () {
            //$('.form-horizontal').trigger("reset");
            $('.form-horizontal').on('form-horizontal', function () {
                $(this).find('form')[0].reset();
            });
        });
    </script>

    <script>
        $(document).ready(function (){
            $('.select2').select2();
        });
    </script>
@endsection
