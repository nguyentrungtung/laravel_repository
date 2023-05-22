@extends('admin.layouts.app')

@section('titel','Home Admin')
@section('css')
@endsection

@section('breadcrumb')
  <section class="content-header">
    <h1>
{{--      Dashboard--}}
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Dashboard</li>
    </ol>
  </section>
@endsection

@section('content')

<section class="content">
  <!-- Info boxes -->
  <div class="row">
    <div class="col-md-3 col-sm-6 col-xs-12">
      <div class="info-box">
        <span class="info-box-icon bg-aqua"><i class="fa fa-users"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">Staff</span>
          <span class="info-box-number">{{ $totalUser }}</span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
    </div>
    <!-- /.col -->
    <div class="col-md-3 col-sm-6 col-xs-12">
      <div class="info-box">
        <span class="info-box-icon bg-red"><i class="ion ion-ios-people-outline"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">Customers</span>
          <span class="info-box-number"></span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
    </div>
    <!-- /.col -->

    <!-- fix for small devices only -->
    <div class="clearfix visible-sm-block"></div>

    <div class="col-md-3 col-sm-6 col-xs-12">
      <div class="info-box">
        <span class="info-box-icon bg-green"><i class="ion ion-ios-cart-outline"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">Discount Code</span>
          <span class="info-box-number"></span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
    </div>
    <!-- /.col -->
{{--    <div class="col-md-3 col-sm-6 col-xs-12">--}}
{{--      <div class="info-box">--}}
{{--        <span class="info-box-icon bg-yellow"><i class="ion ion-ios-people-outline"></i></span>--}}

{{--        <div class="info-box-content">--}}
{{--          <span class="info-box-text">New Members</span>--}}
{{--          <span class="info-box-number">2,000</span>--}}
{{--        </div>--}}
{{--        <!-- /.info-box-content -->--}}
{{--      </div>--}}
{{--      <!-- /.info-box -->--}}
{{--    </div>--}}
    <!-- /.col -->
  </div>
  <!-- /.row -->

  <div class="row">
    <div class="col-md-12">
      <div class="box">
          <!-- LINE CHART -->
          <div class="box box-info">
              <div class="box-header with-border">
                  <h3 class="box-title">Customer Line Chart</h3>
              </div>
              <div class="box-body">
                  <div class="chart">
                      <canvas id="lineChart" style="height:250px"></canvas>
                  </div>
              </div>
              <!-- /.box-body -->
          </div>
          <!-- /.box -->
      </div>
      <!-- /.box -->
    </div>
    <!-- /.col -->
  </div>
  <!-- /.row -->

</section>
@endsection
{{-- end content --}}

@section('script')

{!! \Html::script('adminlte/dist/js/demo.js') !!}
{!! \Html::script('js/chart.js') !!}

  <script>
    $(document).ready(function () {
      $(".removeRecord").click(function () {
        let url = $(this).data('url');
        console.log(url);
        swal({
          title: "Bạn có chắc chắn không?",
          text: "Sau khi xóa, bạn sẽ không thể khôi phục tệp tưởng tượng này!",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        })
          .then((willDelete) => {
            if (willDelete) {
              $.ajax({
                type: 'DELETE',
                dataType: 'json',
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                data: {
                  _method: 'DELETE',
                  "_token": "{{ csrf_token() }}"
                },
                url,
                success: function (data) {
                  window.location.reload();
                }
              });
            }
          });
      });
    });
  </script>

@endsection
