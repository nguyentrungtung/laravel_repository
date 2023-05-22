@extends('admin.layouts.app')

@section('titel','Home Admin')
@section('css_global')
    {!! \Html::style('adminlte/bower_components/select2/dist/css/select2.min.css') !!}
@endsection

@section('breadcrumb')
    <section class="content-header">
        <h1>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('home.index') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li> <a href="{{ route('user.index') }}"> User </a></li>
            <li class="active"> <a href="{{ route('user.create') }}"> User</a></li>
        </ol>
    </section>
@endsection()

@section('content')
    <div class="">

        <div class="col-lg-12">
            <div class="box">
                <div class="box-body">
                    @php
                        $route = empty($role) ? 'rolepermission.store' : ['rolepermission.update', $role->id];
                        $method = empty($role) ? 'POST' : 'PUT';
                    @endphp
                    {!! Form::open(['route' => $route, 'method' => $method, 'class' => 'form-horizontal', 'rolepermission' => 'form']) !!}


                    <div class="form-group">
                        <label for="input-1" class="col-sm-2 col-form-label">Role</label>
                        <div class="col-sm-10">
                            {{ Form::text('name', $role->name  ?? '', ['class' => 'form-control']) }}
                            @if ($errors->has('name'))
                              <i class="error_validate">{{ $errors->first('name') }}</i>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <input type="hidden" value="{{ $role->id }}" name="roleId">
                    </div>


                    <div class="box box-primary">
                        <div class="box-body">
                            <div class="row">
                                @foreach($permissions as $permission)
                                    <div class="col-sm-4">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="permission[]"  value="{{ !empty($permission->name) ? $permission->name : '' }}" {{ isset($rolePermissionArr[$permission->id]['id']) == $permission->id ? 'checked' : '' }} > {{ $permission->name }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                        <div class="box-footer">
                            <div class="form-group row">
                                <label for="input01" class="col-sm-2 control-label"></label>
                                <div class="col-sm-8">
                                    <button type="submit" class="btn btn-primary"> Save</button>
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

    @endsection
