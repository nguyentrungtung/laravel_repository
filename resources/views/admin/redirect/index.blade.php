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

    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <table id="example2" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                {!! Form::open([
                                    'route' => ` {{ route('redirect.store') }}`,
                                    'method' => 'POST',
                                    'class' => 'form-horizontal',
                                    'redirect' => 'form',
                                ]) !!}
                                <th>
                                    <input type="text" class="form-control" placeholder="Link cũ" name="old_link">
                                    @error('old_link')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </th>
                                <th>
                                    <input type="text" class="form-control" placeholder="Link mới" name="new_link">
                                    @error('new_link')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </th>
                                <th>
                                    <select name="redirect_status" id="redirect" class="form-control">
                                        <option checked value="300"> Redirect</option>
                                        <option value="300">300</option>
                                        <option value="301">301</option>
                                        <option value="302">302</option>
                                        <option value="303">303</option>
                                        <option value="304">304</option>
                                        <option value="305">305</option>
                                        <option value="306">306</option>
                                        <option value="307">307</option>
                                    </select>
                                </th>
                                <th>
                                    <select name="status" id="status" class="form-control">
                                        <option value="1">active</option>
                                        <option value="0">no active</option>
                                    </select>
                                </th>
                                <th>
                                    <button class="btn btn-info">+ ADD</button>
                                </th>
                                {!! Form::close() !!}
                                <th>
                                    <div class="box-tools">
                                        <form action="{{ route('redirect.index') }}" method="get">
                                            <div class="input-group input-group-sm hidden-xs" style="width: 200px;">
                                                <input type="text" name="query" class="form-control pull-right"
                                                    placeholder="Search...">
                                                <div class="input-group-btn">
                                                    <button type="submit" class="btn btn-default"><i
                                                            class="fa fa-search"></i></button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </th>
                            </tr>
                        </thead>
                    </table>
                </div>
                <div class="box-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th><input type="checkbox" name="remove_mutiple" id="checkAll"> <span  class="btn-danger btn-sm rm">Xóa nhiều</span></th>
                                <th>Link cũ</th>
                                <th>Link mới</th>
                                <th>Điều hướng</th>
                                <th>Trạng thái</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $i= 1; @endphp
                            @foreach ($redirects as $redirect)
                            {!! Form::open([
                                'route' => ` {{ route('redirect.edit') }}`,
                                'method' => 'PUT',
                                'class' => 'form-horizontal',
                                'redirect' => 'form',
                            ]) !!}
                            <tr>
                                <th scope="row" style="width:20px">{{ $redirect->id }}</th>
                                <td>
                                    <input type="checkbox" name="remove" value="{{ $redirect->id }}">
                                </td>
                                <td>
                                    <input type="text"  value="{{ isset($redirect) ? $redirect->old_link : old('old_link') }}" name="old_link" class="form-control old_{{ $redirect->id }}">
                                </td>
                                <td>
                                    <input type="text" value="{{ isset($redirect) ? $redirect->new_link : old('new_link') }}" name="new_link" class="form-control new_{{ $redirect->id }}">
                                </td>
                                <td>

                                    <select name="redirect_status" id="redirect" class="form-control change_{{ $redirect->id }}">
                                        @if (isset($redirect))
                                            <option value="300" {{ $redirect->redirect_status == 300 ? 'selected' : '' }}>300</option>
                                            <option value="301" {{ $redirect->redirect_status == 301 ? 'selected' : '' }}>301</option>
                                            <option value="302" {{ $redirect->redirect_status == 302 ? 'selected' : '' }}>302</option>
                                            <option value="303" {{ $redirect->redirect_status == 303 ? 'selected' : '' }}>303</option>
                                            <option value="304" {{ $redirect->redirect_status == 304 ? 'selected' : '' }}>304</option>
                                            <option value="305" {{ $redirect->redirect_status == 305 ? 'selected' : '' }}>305</option>
                                            <option value="306" {{ $redirect->redirect_status == 306 ? 'selected' : '' }}>306</option>
                                            <option value="307" {{ $redirect->redirect_status == 307 ? 'selected' : '' }}>307</option>
                                        @else
                                            <option value="300">300</option>
                                            <option value="301">301</option>
                                            <option value="302">302</option>
                                            <option value="303">303</option>
                                            <option value="304">304</option>
                                            <option value="305">305</option>
                                            <option value="306">306</option>
                                            <option value="307">307</option>
                                        @endif
                                    </select>
                                </td>
                                <td>
                                    <select name="status" id="status" class="form-control changestatus_{{ $redirect->id }}">
                                        @if (isset($redirect))
                                        <option value="1" {{ $redirect->status == 1 ? 'selected' : '' }}>active</option>
                                        <option value="0" {{ $redirect->status == 0 ? 'selected' : '' }}>no active</option>
                                        @else
                                        <option value="1">active</option>
                                        <option value="0">no active</option>
                                        @endif
                                    </select>
                                </td>
                                <td>
                                    <a class="update" data-id={{ $redirect->id }}  ><i class="fa fa-fw fa-pencil-square-o"></i></a>
                                    <a href="#" data-url="{{ route('redirect.destroy', $redirect->id) }}" class="removeRecord" id=""><i
                                        class="fa fa-fw fa-trash"></i></a>
                                    </td>
                                </tr>
                                {!! Form::close() !!}
                            @endforeach
                        </tbody>
                    </table>
                    <div class="col-sm-12 text-right">
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
                        url: `{{ route('redirect.removeAll') }}`,
                        data:{
                            _token:$('meta[name="csrf-token"]').attr('content'),
                            array_id:array_id
                        },
                        success: function(data) {
                            window.location.reload();
                        }
                    })
                })
                $('.update').on('click', function(e){
                    e.preventDefault();
                    const id = $(this).data('id');
                    const old_link = $('.old_' + id).val()
                    const new_link = $('.new_' + id).val()
                    const redirect_status = $('.change_' + id).val()
                    const status = $('.changestatus_' + id).val()
                    $.ajax({
                        method: 'POST',
                        url: `{{ route('upgrate') }}`,
                        data: {
                            _token:$('meta[name="csrf-token"]').attr('content'),
                            id: id,
                            old_link:old_link,
                            new_link:new_link,
                            redirect_status:redirect_status,
                            status:status
                        },
                        success: function(data) {
                            window.location.reload();
                        }
                    })
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
