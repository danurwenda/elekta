@extends('adminlte::page')
@section('header', 'Twitter')
@section('description')
last update : <span id='tw-last-update' style='display: none'>{{ $timestamp }}</span>
@stop
@section('js')
<script src="{{{ URL::asset('vendor/moment/moment.min.js')}}}"></script>
<script>
    $('#tw-last-update').show().html(moment.unix($('#tw-last-update').html()).format('HH:mm:ss DD-MMM-YYYY'));
</script>
<script src="https://www.amcharts.com/lib/3/amcharts.js"></script>
<script src="https://www.amcharts.com/lib/3/serial.js"></script>
<script src="https://www.amcharts.com/lib/3/themes/light.js"></script>
@stop

@section('content')
<div class="row">
    <div class="col-md-6">
        <!-- AREA CHART -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Hari Ini</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>

            </div>
            <div class="box-body">
                <div>
                    @include('pages.sosmed.twitter.today')
                </div>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->

        <!-- DONUT CHART -->
        <div class="box box-danger">
            <div class="box-header with-border">
                <h3 class="box-title">Influencer</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs pull-right">
                        <li><a href="#tab_4" data-toggle="tab">Puti</a></li>
                        <li><a href="#tab_2" data-toggle="tab">Gus Ipul</a></li>
                        <li><a href="#tab_3" data-toggle="tab">Emil</a></li>
                        <li class="active"><a href="#tab_1" data-toggle="tab">Khofifah</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_1">
                            @include('pages.sosmed.twitter.userkhof')
                        </div>
                        <!-- /.tab-pane -->
                        <div class="tab-pane" id="tab_2">
                            @include('pages.sosmed.twitter.useripul')
                        </div>
                        <div class="tab-pane" id="tab_3">
                            @include('pages.sosmed.twitter.useremil')
                        </div>
                        <!-- /.tab-pane -->
                        <div class="tab-pane" id="tab_4">
                            @include('pages.sosmed.twitter.userputi')
                        </div>
                        <!-- /.tab-pane -->
                    </div>
                    <!-- /.tab-content -->
                </div>

            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->



    </div>
    <!-- /.col (LEFT) -->
    <div class="col-md-6">
        <!-- LINE CHART -->
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Seminggu Ini</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body">
                <div >
                    @include('pages.sosmed.twitter.weeks')
                </div>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->

        <!-- BAR CHART -->
        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title">Hashtag Terbanyak</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs pull-right">
                        <li><a href="#tab_4h" data-toggle="tab">Puti</a></li>
                        <li><a href="#tab_2h" data-toggle="tab">Gus Ipul</a></li>
                        <li><a href="#tab_3h" data-toggle="tab">Emil</a></li>
                        <li class="active"><a href="#tab_1h" data-toggle="tab">Khofifah</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_1h">
                            @include('pages.sosmed.twitter.hashtagkhof')
                        </div>
                        <!-- /.tab-pane -->
                        <div class="tab-pane" id="tab_2h">
                            @include('pages.sosmed.twitter.hashtagipul')
                        </div>
                        <div class="tab-pane" id="tab_3h">
                            @include('pages.sosmed.twitter.hashtagemil')
                        </div>
                        <!-- /.tab-pane -->
                        <div class="tab-pane" id="tab_4h">
                            @include('pages.sosmed.twitter.hashtagputi')
                        </div>
                        <!-- /.tab-pane -->
                    </div>
                    <!-- /.tab-content -->
                </div>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->


    </div>
    <!-- /.col (RIGHT) -->
</div>
<!-- /.row -->

@include('pages.sosmed.twitter.graph')
@endsection
