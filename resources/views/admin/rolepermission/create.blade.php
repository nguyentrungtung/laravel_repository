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
            <li><a href="{{ route('home.index') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li> <a href="{{ route('user.index') }}"> User </a></li>
            <li class="active"> <a href="{{ route('user.create') }}"> User</a></li>
        </ol>
    </section>
@endsection()
@section('content')
<div class="row">
    <div class="col-md-6">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Add Role</h3>
        </div>
        <form role="form" method="post" action="{{ route('rolepermission.store') }}">
            @csrf
          <div class="box-body">
            <div class="form-group">
              <label for="roleName">Role Name</label>
              <input type="text" class="form-control" id="roleName" name="roleName" placeholder="Enter role name" required>
            </div>
          </div>
          <div class="box-footer">
            <button type="submit" class="btn btn-primary">Add Role</button>
          </div>
        </form>
      </div>
    </div>
  </div>

@endsection()

@section('script')

@endsection
