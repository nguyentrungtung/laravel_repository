@extends('admin.layouts.app')
@section('titel', 'Home Admin')
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
            <li class="active"> <a href="{{ route('user.index') }}"> Log </a></li>
        </ol>
    </section>
@endsection

@section('content')

    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title"></h3>
                    <button type="button" onclick="window.location='{{ route('log.create') }}'"
                        class="btn btn-info">@lang('common.add')</button>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Ip</th>
                                <th style="width:15%">Browser</th>
                                <th>Method</th>
                                <th>Action</th>
                                <th>Module</th>
                                <th>Created At</th>
                                <th>Setting</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $i= 1; @endphp
                            @foreach ($logs as $log)
                                <tr>
                                    <th scope="row" style="width:20px">{{ $log->id }}</th>
                                    <td>{{ $log->name }}</td>
                                    <td>{{ $log->email }}</td>
                                    <td>{{ $log->ip }}</td>
                                    <td>{{ $log->browser }}</td>
                                    <td>{{ $log->method }}</td>
                                    <td>{{ $log->action }}</td>
                                    <td>{{ $log->module }}</td>
                                    <td>{{ $log->created_at->format('d/m/Y') }}</td>
                                    <td>
                                        <a href="#" data-url="{{ route('log.destroy', $log->id) }}"
                                            class="removeRecord" id="{{ $log->id }}"><i
                                                class="fa fa-fw fa-trash"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="col-sm-12 text-right">
                        {{ $logs->appends(request()->all())->links() }}
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
        $(function() {
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
