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
$route = empty($postcomment) ? 'postcomment.store' : ['postcomment.update', $postcomment->id];
$method = empty($postcomment) ? 'POST' : 'PUT';
@endphp
{!! Form::open(['route' => $route, 'method' => $method, 'class' => 'form-horizontal', 'postcomment' => 'form'])
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
                        <label for="author">Author</label>
                        <input type="text" name="author" value="{{ isset($postcomment) ? $postcomment->author : '' }}"
                            class="form-control" id="author" placeholder="author">
                        @error('author')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="email">email</label>
                        <input type="text" name="email" value="{{ isset($postcomment) ? $postcomment->email : '' }}"
                            class="form-control" id="email" placeholder="email">
                        @error('email')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="comment">comment</label>
                        <input type="text" name="comment" value="{{ isset($postcomment) ? $postcomment->comment : '' }}"
                            class="form-control" id="comment" placeholder="comment">
                        @error('comment')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="status">Status</label>
                        <select class="select2 form-control" style="width: 100%;" name="status">
                            @foreach ($statusData as $data)
                            @if (isset($postcomment))
                            <option class="text-black font-medium" value="{{ $data['value'] }}" {{$postcomment->status ==
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
                <!-- /.box-body -->
                <div class="box-body">
                    <div class="form-group">
                        <label for="rep">Reply postcomment</label>

                        <input type="text" name="rep" value="{{ isset($postcomment) ?  isset(json_decode($postcomment->rep)[0]) ? json_decode($postcomment->rep)[0]->comment : '' : '' }}"
                            class="form-control" id="rep" placeholder="rep">
                        @error('postcomment')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </div><!--End Row-->
        <div class="col-md-3">
        </div>
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
</script>

<script>
    var editor = CKEDITOR.replace("ckeditor");
    CKFinder.setupCKEditor(editor);
    $(document).ready(function () {
        $('.select2').select2();
    });
    $(document).on('click', '.ckfinderUploadImage', function () {
        $currentElement = $(this);
        CKFinder.modal({
            language: "vi",
            chooseFiles: true,
            width: 800,
            height: 600,
            onInit: function (finder) {
                finder.on("files:choose", function (evt) {
                    var file = evt.data.files.first();
                    var thumbnail = file.getUrl();
                    $currentElement.prev().attr("src", `{{ asset( '${thumbnail}' ) }}`);
                    $currentElement.next().val(thumbnail);
                });
            },
        });
    })
</script>
@endsection
