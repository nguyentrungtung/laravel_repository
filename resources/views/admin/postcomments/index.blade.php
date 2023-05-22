@extends('admin.layouts.app')
@section('titel','Home Admin')
@section('css_global')
{!! \Html::style('adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') !!}
@endsection

@section('breadcrumb')
<section class="content-header">
    @include('admin.partials.breadcrumbs')
</section>
@endsection

@section('content')

<div class="row">
<div class="col-xs-12">
    <div class="box">
    <div class="box-header">
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <table id="example1" class="table table-bordered table-striped">
        <thead>
            <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Post Id</th>
            <th>Status</th>
            <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @php $i= 1; @endphp
            @foreach ($postcomments as $postcomment)
            <tr>
                <th scope="row" style="width:20px">{{ $postcomment->id }}</th>
                <td>{{ $postcomment->author }}</td>
                <td>{{ $postcomment->email }}</td>
                <td>{{ $postcomment->post_id }}</td>
                <td>{{ $postcomment->status == 1 ? 'Hiện' : 'Ẩn' }}</td>
            <td>
                <a href="{{ route('postcomment.edit', $postcomment->id) }}"><i class="fa fa-fw fa-pencil-square-o"></i></a>
                <a href="#" data-url="{{ route('postcomment.destroy', $postcomment->id) }}" class="removeRecord"
                id="{{ $postcomment->id }}"><i class="fa fa-fw fa-trash"></i></a>
            </td>
            </tr>
            @endforeach
        </tbody>
        </table>
        <div class="col-sm-12 text-right">
        {{ $postcomments->appends(request()->all())->links('pagination::bootstrap-4') }}
        </div>
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
