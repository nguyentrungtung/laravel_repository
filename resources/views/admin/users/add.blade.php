@extends('admin.layouts.app')

@section('titel','Home Admin')
@section('css_global')
    {!! \Html::style('adminlte/bower_components/select2/dist/css/select2.min.css') !!}
@endsection

@section('breadcrumb')
    <section class="content-header">
        @include('admin.partials.breadcrumbs')
    </section>
@endsection

@section('content')
    <div class="row">
        <div class="box">
            <div class="box-body warper_form">
                {!! Form::open(['route' => 'user.store', 'method' => 'POST', 'class' => 'form-horizontal', 'user' => 'form']) !!}
                    {!! $formHtml !!}
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection

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
