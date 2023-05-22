@extends('admin.layouts.app')
@section('titel','Home Admin')
@section('css_global')
{!! \Html::style('adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') !!}
@endsection

@section('breadcrumb')
<section class="content-header">
<h1>
    {{ isset($title) ? $title : '' }}
    <small>{{ isset($subTile) ? $subTile : '' }}</small>
</h1>
<ol class="breadcrumb">
    <li><a href="{{ route('home.index') }}"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active"> <a href="{{ route('media.index') }}"> Media </a></li>
</ol>
</section>
@endsection

@section('content')

<div class="row">
<div class="col-xs-12">
    <div class="box">
    <!-- /.box-header -->
    <div class="box-body">
    </div>
    <!-- /.box-body -->
    </div>
    <!-- /.box -->
</div>
<!-- /.col -->
</div>
<!-- /.row -->

@endsection()

@section('script')
{!! \Html::script('adminlte/bower_components/datatables.net/js/jquery.dataTables.min.js') !!}
{!! \Html::script('adminlte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') !!}
<script>
    $(document).ready(function () {
        var bodyWidth = $('.content-wrapper').width();
        $currentElement = $(this);
        CKFinder.modal({
            language: "vi",
            chooseFiles: true,
            width: bodyWidth,
            height: 4000,
        });
        $('#ckf-modal').css({
            'left': 'unset',
            'right': 0,
        })
    })
$(function () {
    $('#example1').DataTable({
    "bPaginate": false
    })
    // $('#example2').DataTable({
    //   'paging'      : true,
    //   'lengthChange': false,
    //   'searching'   : false,
    //   'ordering'    : true,
    //   'info'        : true,
    //   'autoWidth'   : false
    // })
});
</script>

@endsection
