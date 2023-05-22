@extends('admin.layouts.app')
@section('titel', 'Home Admin')
@section('css_global')
    {!! \Html::style('adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') !!}
@endsection

@section('breadcrumb')
    <section class="content-header">
        @include('admin.partials.breadcrumbs')
    </section>
@endsection

@section('content')
    <div class="list">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <label for="">
                            Tìm kiếm
                        </label>
                        <div class="text-right" style="padding-right: 10px">
                            <div class="box-tools">
                                <form action="{{ route('post.index') }}" method="get" style="display:flex; align-items:center;">
                                    <div class="input-group input-group-sm hidden-xs" style="display:flex;">
                                        <input type="text" name="query" class="form-control pull-right" placeholder="Search keyword..." value="{{ isset($query) ? $query : old('query') }}">
                                        <select name="category" id="category" class="form-control">
                                            @if (isset($postCategories))
                                                @foreach ($postCategories as $item)
                                                    <option value="{{ $item->title }}" {{ $item->title == $category ? 'selected' : '' }}>{{ $item->title }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        <select name="status" id="status" class="form-control">
                                            @if (isset($status))
                                            <option value="">Status</option>
                                            <option value="0" {{ $status == 0 ? 'selected' : '' }}>Ẩn</option>
                                            <option value="1" {{ $status == 1  ? 'selected' : '' }}>Hiện</option>
                                            @else
                                                <option value="">Status</option>
                                                <option value="0">Ẩn</option>
                                                <option value="1">Hiện</option>
                                            @endif
                                        </select>
                                    </div>
                                    <div class="input-group-btn">
                                        <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="box-header">
                        <h3 class="box-title"></h3>
                        <button type="button" onclick="window.location='{{ route('post.create') }}'"
                            class="btn btn-info">@lang('common.add')</button>

                    </div>
                    <!-- /.box-header -->

                    <div class="box-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>
                                        <label for="#checkAll" style="" >
                                            <span style="padding-right:10px;display:inline-block;"> Chọn tất cả</span>
                                            <input type="checkbox" name="checkAll" id="checkAll">
                                        </label>
                                        <button class="btn rm">Xóa nhiều</button>
                                    </th>
                                    <th>Thumbnail</th>
                                    <th>Title</th>
                                    <th>Summary</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $i= 1; @endphp
                                @foreach ($posts as $post)
                                    <tr>
                                        <th scope="row" style="width:20px">{{ $post->id }}</th>
                                        <th>
                                            <input type="checkbox" name="remove" id="remove" value={{ $post->id }}>
                                        </th>
                                        <th style="width:10%">
                                            <img class="img-fluid" style="width:100%" src="{{ asset($post->thumbnail) }}"
                                                alt="">
                                        </th>
                                        <th>{{ $post->title }}</th>
                                        <th>{{ $post->summary }}</th>
                                        <th>{{ $post->status == 0 ? 'Ẩn' : 'Hiện' }}</th>
                                        <th>
                                            <a href="{{ route('post.edit', $post->id) }}"><i
                                                    class="fa fa-fw fa-pencil-square-o"></i></a>
                                            <a href="#" data-url="{{ route('post.destroy', $post->id) }}"
                                                class="removeRecord" id="{{ $post->id }}"><i
                                                    class="fa fa-fw fa-trash"></i></a>
                                        </th>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="col-sm-12 text-right">
                            {{ $posts->appends(request()->all())->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>
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
            $(document).ready(function() {
                $('#checkAll').change(function() {
                    var isChecked = $(this).is(':checked');
                    $('input[name="remove"]').prop('checked', isChecked);
                })
                $('.rm').on('click', function(e) {
                    e.preventDefault();
                    const array_id = [];
                    $('input[name="remove"]:checked').each(function() {
                        array_id.push($(this).val());
                    });
                    $.ajax({
                        method: 'POST',
                        url: `{{ route('post.removeAll') }}`,
                        data:{
                            _token:$('meta[name="csrf-token"]').attr('content'),
                            array_id:array_id
                        },
                        success: function(data) {
                            window.location.reload();
                        }
                    })
                })
            })
        });
    </script>

@endsection
