@extends('admin.layouts.app')
@section('titel','Home Admin')
@section('css_global')
{!! \Html::style('adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') !!}
@endsection

@section('breadcrumb')
  <section class="content-header">
    <h1>
      {{ $title ? $title : '' }}
      <small>{{ $subTile ? $subTile : '' }}</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{route('home.index')}}"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active"> <a href="{{ route('user.index') }}"> User </a></li>
    </ol>
  </section>
@endsection

@section('content')

<div class="row">
  <div class="col-xs-12">

    <div class="box">
      <div class="box-header">
        <h3 class="box-title"></h3>
          <button type="button" onclick="window.location='{{ route('user.create') }}'" class="btn btn-info">@lang('common.add')</button>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <table id="example1" class="table table-bordered table-striped">
          <thead>
          <tr>
            <th>STT</th>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Action</th>
          </tr>
          </thead>
          <tbody>
            @php $i= 1; @endphp
            @foreach ($users as $user)
              <tr>
                <th>{{ $i++ }}</th>
                <th scope="row">{{$user->id}}</th>
                <td>{{$user->name}}</td>
                <td>{{$user->email}}</td>
                <td>
                    <a href="{{ route('user.show', $user->id) }}"><i class="fa fa-fw fa-user"></i></a>
                    <a href="{{ route('user.edit', $user->id) }}"><i class="fa fa-fw fa-pencil-square-o"></i></a>
                    <a href="#" data-url="{{ route('user.destroy', $user->id) }}" class="removeRecord"
                      id="{{ $user->id }}"><i class="fa fa-fw fa-trash"></i></a>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
          <div class="col-sm-12 text-right">
            {{ $users->appends(request()->all())->links() }}
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
