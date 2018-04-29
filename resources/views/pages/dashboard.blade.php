@extends('adminlte::page')
@section('header', 'Dashboard')
@section('description', 'last update')

@section('js')
<script src="https://www.amcharts.com/lib/3/amcharts.js"></script>
<script src="https://www.amcharts.com/lib/3/serial.js"></script>
<script src="https://www.amcharts.com/lib/3/themes/light.js"></script>
<script type="text/javascript">
    var
            youtubekhof = [{{ implode(',', $youtubekhof) }}],
            twitterkhof = [{{ implode(',', $twitterkhof) }}],
            facebookkhof = [{{ implode(',', $facebookkhof) }}],
            mediakhof = [{{ implode(',', $mediakhof) }}],
            gpluskhof = [{{ implode(',', $gpluskhof) }}],
            youtubeipul = [{{ implode(',', $youtubeipul) }}],
            twitteripul = [{{ implode(',', $twitteripul) }}],
            facebookipul = [{{ implode(',', $facebookipul) }}],
            mediaipul = [{{ implode(',', $mediaipul) }}],
            gplusipul = [{{ implode(',', $gplusipul) }}];
            </script>
<script src="{{{ URL::asset('js/dashboard.js')}}}"></script>
@endsection

@section('content')
<!-- Info boxes -->
<div class="row">
    <div class="col-md-3 col-sm-6 col-xs-12">
        <span style="top:0;left:10;position:absolute;"><i class="fa fa-female"></i> Khofifah</span>
        <div class="info-box">

            <span class="info-box-icon bg-aqua"><i class="fa fa-magnet"></i></span>

            <div class="info-box-content"  id='khof-total'>
                <span class="info-box-text">Total</span>
                <span class="info-box-number"></span>
                <span class="pull-right">
                    <i class='fa'></i>
                    <span class='diff'></span>
                </span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->
    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
            <span class="info-box-icon bg-red"><i class="fa fa-thumbs-o-up"></i></span>

            <div class="info-box-content" id='khof-yt'>
                <span class="info-box-text">Youtube</span>
                <span class="info-box-number"></span>
                <span class="pull-right">
                    <i class='fa'></i>
                    <span class='diff'></span>
                </span>
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
            <span class="info-box-icon bg-green"><i class="fa fa-twitter"></i></span>

            <div class="info-box-content" id='khof-tw'>
                <span class="info-box-text">Tweet</span>
                <span class="info-box-number"></span>
                <span class="pull-right">
                    <i class='fa'></i>
                    <span class='diff'></span>
                </span></div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->
    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
            <span class="info-box-icon bg-yellow"><i class="fa fa-newspaper-o"></i></span>

            <div class="info-box-content" id='khof-media'>
                <span class="info-box-text">News</span>
                <span class="info-box-number"></span>
                <span class="pull-right">
                    <i class='fa'></i>
                    <span class='diff'></span>
                </span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->
</div>
<!-- /.row -->

<div class="row">
    <div class="col-md-8">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Rekap Satu Minggu</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>

                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                @include('pages.dashboard.weeks')
                <!-- /.box-footer -->
            </div>
            <!-- /.box -->
        </div>
    </div>

    <div class="col-md-4">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Hari Ini</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>

                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                @include('pages.dashboard.today')
                <!-- ./box-body -->

                <!-- /.box-footer -->
            </div>
            <!-- /.box -->
        </div>
    </div>
    <!-- /.col -->
</div>
<!-- /.row -->

<div class="row">
    <div class="col-md-3 col-sm-6 col-xs-12">
        <span style="top:0;left:10;position:absolute;"><i class="fa fa-male"></i> Gus Ipul</span>
        <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="fa fa-magnet"></i></span>

            <div class="info-box-content" id='ipul-total'>
                <span class="info-box-text">Total</span>
                <span class="info-box-number"></span>
                <span class="pull-right">
                    <i class='fa'></i>
                    <span class='diff'></span>
                </span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->
    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
            <span class="info-box-icon bg-red"><i class="fa fa-thumbs-o-up"></i></span>

            <div class="info-box-content" id='ipul-yt'>
                <span class="info-box-text">Youtube</span>
                <span class="info-box-number"></span>
                <span class="pull-right">
                    <i class='fa'></i>
                    <span class='diff'></span>
                </span>
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
            <span class="info-box-icon bg-green"><i class="fa fa-twitter"></i></span>

            <div class="info-box-content" id='ipul-tw'>
                <span class="info-box-text">Tweet</span>
                <span class="info-box-number"></span>
                <span class="pull-right">
                    <i class='fa'></i>
                    <span class='diff'></span>
                </span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->
    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
            <span class="info-box-icon bg-yellow"><i class="fa fa-newspaper-o"></i></span>

            <div class="info-box-content" id='ipul-media'>
                <span class="info-box-text">News</span>
                <span class="info-box-number"></span>
                <span class="pull-right">
                    <i class='fa'></i>
                    <span class='diff'></span>
                </span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->
</div>
<!-- /.row -->

<div class="row">
    <div class="col-md-6">	
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">#iNewsDebatJatim</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>

                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                @include('pages.dashboard.graph')
                <!-- ./box-body -->

                <!-- /.box-footer -->
            </div>
            <!-- /.box -->
        </div>
    </div>	
    <div class="col-md-6"  >	
        <div class="box box-danger">
            <div class="box-header with-border">
                <h3 class="box-title">Influencer</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body" style="height:523px;">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs pull-right">
                        <li><a href="#tab_4" data-toggle="tab">Puti</a></li>
                        <li><a href="#tab_2" data-toggle="tab">Gus Ipul</a></li>
                        <li><a href="#tab_3" data-toggle="tab">Emil</a></li>
                        <li class="active"><a href="#tab_1" data-toggle="tab">Khofifah</a></li>
                        <li><a href="#tab_0" data-toggle="tab">Hashtag Terpolpuler</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane" id="tab_0">
                            @include('pages.sosmed.twitter.hashtagkhof')
                        </div>
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
    </div>	
</div>
@endsection
@section('appjs')
<script src="{{{ URL::asset('theadmin/bower_components/jquery-ui/jquery-ui.min.js')}}}"></script>
<script src="{{{ URL::asset('theadmin/bower_components/fastclick/lib/fastclick.js')}}}"></script>
<!-- Sparkline -->
<script src="{{{ URL::asset('theadmin/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js')}}}"></script>
<!-- jvectormap  -->
<script src="{{{ URL::asset('theadmin/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js')}}}"></script>
<script src="{{{ URL::asset('theadmin/plugins/jvectormap/jquery-jvectormap-world-mill-en.js')}}}"></script>
<!-- SlimScroll -->
<script src="{{{ URL::asset('theadmin/bower_components/jquery-slimscroll/jquery.slimscroll.min.js')}}}"></script>
<!-- ChartJS -->
<script src="{{{ URL::asset('theadmin/bower_components/Chart.js/Chart.js')}}}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{{ URL::asset('theadmin/dist/js/pages/dashboard2.js')}}}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{{ URL::asset('theadmin/dist/js/demo.js')}}}"></script>
@endsection