@extends('admin.layouts.app')

@section('titel','Home Admin')
@section('css_global')
@endsection

@section('breadcrumb')
<section class="content-header">
    @include('admin.partials.breadcrumbs')
  </section>
@endsection()

@section('content')
<div class="row">
    <div class="col-lg-3"></div>
    <div class="col-lg-6">
      <div class="box">
        <div class="box-body warper_form">

          <form id="personal-info">

            <div class="form-group row">
              <label for="input-1" class="col-sm-2 col-form-label">Full Name</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="input-1" disabled value="{{$user->name}}" >
              </div>
            </div>

            <div class="form-group row">
              <label for="input-3" class="col-sm-2 col-form-label">E-mail</label>
              <div class="col-sm-10">
                <input type="email" class="form-control" id="input-3" disabled value="{{$user->email}}" >
              </div>
            </div>
          </form>

        </div>
      </div>
    </div>
    <div class="col-lg-3"></div>
  </div><!--End Row-->

@endsection()

@section('script')

@endsection

