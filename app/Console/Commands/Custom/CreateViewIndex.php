<?php

namespace App\Console\Commands\Custom;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class CreateViewIndex extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:view-index {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $name = $this->argument('name');
        $lowerName = strtolower($name);
        $routeFilePath = 'resources/views/admin/' . $lowerName . '/' . 'index.blade.php';
        $content = <<<EOT
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
                <h3 class="box-title"></h3>
                <button type="button" onclick="window.location='{{ route('{$lowerName}.create') }}'"
                class="btn btn-info">@lang('common.add')</button>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                    <th>ID</th>
                    <th>Thumbnail</th>
                    <th>Title</th>
                    <th>Summary</th>
                    <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php \$i= 1; @endphp
                    @foreach (\${$lowerName}s as \${$lowerName})
                    <tr>
                    <th scope="row" style="width:20px">{{\${$lowerName}->id}}</th>
                    <td style="width:10%">
                        <img class="img-fluid" style="width:100%" src="{{asset(\${$lowerName}->thumbnail)}}" alt="">
                    </td>
                    <td>{{\${$lowerName}->title}}</td>
                    <td>{{\${$lowerName}->summary}}</td>
                    <td>
                        <a href="{{ route('{$lowerName}.show', \${$lowerName}->id) }}"><i class="fa fa-fw fa-user"></i></a>
                        <a href="{{ route('{$lowerName}.edit', \${$lowerName}->id) }}"><i class="fa fa-fw fa-pencil-square-o"></i></a>
                        <a href="#" data-url="{{ route('{$lowerName}.destroy', \${$lowerName}->id) }}" class="removeRecord"
                        id="{{ \${$lowerName}->id }}"><i class="fa fa-fw fa-trash"></i></a>
                    </td>
                    </tr>
                    @endforeach
                </tbody>
                </table>
                <div class="col-sm-12 text-right">
                {{ \${$lowerName}s->appends(request()->all())->links() }}
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

        EOT;

        // Write the new contents back to the file
        File::put($routeFilePath, $content);

        $this->info('create model successfully!');
    }
}
