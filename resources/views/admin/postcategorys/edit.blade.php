@extends('admin.layouts.app')

@section('titel','Home Admin')
@section('css_global')
{!! \Html::style('adminlte/bower_components/select2/dist/css/select2.min.css') !!}
<style>
    .form-group {
        margin-left: 0px !important;
        margin-right: 0px !important;
    }
</style>
@endsection

@section('breadcrumb')
<section class="content-header">
    @include('admin.partials.breadcrumbs')
</section>
@endsection()

@section('content')
@php
$route = empty($postcategory) ? 'postcategory.store' : ['postcategory.update', $postcategory->id];
$method = empty($postcategory) ? 'POST' : 'PUT';
@endphp
{!! Form::open(['route' => $route, 'method' => $method, 'class' => 'form-horizontal', 'postcategory' => 'form'])
!!}
<section class="content">
    <div class="row">
        <div class="col-md-9">

            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Main</h3>
                </div>
                <div class="box-body">
                    <div class="form-group">
                        <label for="title">Title (<span class="text-danger" > required *</span>)</label>
                        <input type="text" name="title" value="{{ isset($postcategory) ? $postcategory->title : old('title') }}"
                            class="form-control" id="title" placeholder="Title">
                        @error('title')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    @isset($postcategory)
                        <div class="form-group">
                            <label for="slug">Url (<i class="text-danger">Url có định dạng $-$-$ và không chứa dấu</i>)</label>
                            <input type="text" name="slug" value="{{ isset($postcategory) ? $postcategory->slug : old('slug') }}"
                                class="form-control" id="slug" placeholder="slug">
                            @error('slug')
                            <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    @endisset
                    <div class="form-group">
                        <label class="status">Status</label>
                        <select class="select2 form-control" style="width: 100%;" name="status">
                            @foreach ($statusData as $data)
                            @if (isset($postcategory))
                            <option class="text-black font-medium" value="{{ $data['value'] }}" {{$postcategory->status ==
                                $data['value'] ? 'selected' : ''}}>
                                {{ $data['name'] }}
                            </option>
                            @else
                            <option class="text-black font-medium" value="{{ $data['value'] }}">
                                {{ $data['name'] }}
                            </option>
                            @endif
                            @endforeach
                        </select>
                        @error('status')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Seo</h3>
                </div>
                <div class="box-body row">

                    <div class="form-group col-md-6">

                        <label for="seo_title">seo_title</label>
                        <input type="text" name="seo_title" value="{{ isset($postcategory) ? $postcategory->seo_title : old('seo_title') }}"
                            class="form-control" id="seo_title" placeholder="seo_title">
                        @error('seo_title')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror

                    </div>
                    <div class="form-group col-md-6">

                        <label for="seo_description">seo_description</label>
                        <input type="text" name="seo_description" value="{{ isset($postcategory) ? $postcategory->seo_description : old('seo_description') }}"
                            class="form-control" id="seo_description" placeholder="seo_description">
                        @error('seo_description')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror

                    </div>
                    <div class="form-group col-md-6">

                        <label for="seo_keyword">seo_keyword</label>
                        <input type="text" name="seo_keyword" value="{{ isset($postcategory) ? $postcategory->seo_keyword : old('seo_keyword') }}"
                            class="form-control" id="seo_keyword" placeholder="seo_keyword">
                        @error('seo_keyword')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror

                    </div>
                    <div class="form-group col-md-6">

                        <label for="seo_canonical">seo_canonical</label>
                        <input type="text" name="seo_canonical" value="{{ isset($postcategory) ? $postcategory->seo_canonical : old('seo_canonical') }}"
                            class="form-control" id="seo_canonical" placeholder="seo_canonical">
                        @error('seo_canonical')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror

                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </div><!--End Row-->
        {!! Form::close() !!}
</section>
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
    $(document).on('input', 'input[name=slug]', function() {
        var slug = $(this).val();
        slug = slug.toLowerCase().replace(/[^a-z0-9]+/g, '-').trim();
        $(this).val(slug);
    });
</script>
@endsection
