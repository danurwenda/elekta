@extends('adminlte::page')
@section('header','Facebook')
@section('description')
last update : <span id='fb-last-update' style='display: none'>{{ $timestamp }}</span>
@stop

@section('content')

<div class="row">
    <div class="col-md-6">
        <!-- Today -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <i class="fa fa-bar-chart-o"></i>

                <h3 class="box-title">Total Post</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body">
                <div id="total-chart" style="height: 300px;"></div>
            </div>
            <!-- /.box-body-->
        </div>
        <!-- /.box -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <i class="fa fa-bar-chart-o"></i>

                <h3 class="box-title">Total</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body  nav-tabs-custom">
                <ul class="nav nav-tabs pull-right">
                    <li><a href="#total_ipul" data-toggle="tab">Gus Ipul</a></li>
                    <li class="active"><a href="#total_khof" data-toggle="tab">Khofifah</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="total_khof"  style="height: 300px;">
                    </div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane" id="total_ipul"  style="height: 300px;">
                    </div>
                    <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
            </div>
        </div>
        <!-- /.box -->

    </div>
    <!-- /.col -->

    <div class="col-md-6">
        <!-- Last week -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <i class="fa fa-bar-chart-o"></i>

                <h3 class="box-title">Seminggu Ini</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body">
                <div id="week-chart" style="height: 338px;" class="full-width-chart"></div>
            </div>
            <!-- /.box-body-->
        </div>
        <!-- /.box -->


        <!-- Interaction per 1K -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <i class="fa fa-bar-chart-o"></i>

                <h3 class="box-title">Interaksi per 1K</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body">
                <div id="interaction-chart" style="height: 300px;"></div>
            </div>
            <!-- /.box-body-->
        </div><!-- /.box -->
    </div>
    <!-- /.col -->
</div>

@stop

@section('js')
<script>
var khof_7 =
[{{ implode(',', $weekkhof) }}],
        ipul_7 = [{{ implode(',', $weekipul) }}],
        khof_follower = {{ $followerkhof }},
        ipul_follower = {{ $followeripul }},
        khof_total = {{ $totalkhof }},
        ipul_total = {{ $totalipul }},
        khof_summary = [{{ implode(',', $summarykhof) }}],
        ipul_summary = [{{ implode(',', $summaryipul) }}];
    </script>


<script src="{{{ URL::asset('vendor/flot/flot.bundle.js')}}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.0/moment.min.js"></script>
<script src="{{{ URL::asset('js/facebook.js')}}}"></script>
@endsection