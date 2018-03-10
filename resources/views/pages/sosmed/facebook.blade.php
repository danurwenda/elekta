@extends('adminlte::page')
@section('content_header')
<h1>Facebook<small>last update</small></h1>
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
                <div id="today-chart" style="height: 300px;"></div>
            </div>
            <!-- /.box-body-->
        </div>
        <!-- /.box -->

        <!-- Total -->
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
            <div class="box-body">
                <div id="total-chart" style="height: 300px;"></div>
            </div>
            <!-- /.box-body-->
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
<script src="{{{ URL::asset('vendor/flot/flot.bundle.js')}}}"></script>

<script>
$(function () {
    var khof_color = '#f6ab02';
    var ipul_color = '#05693c';

    /*
     * LINE CHART
     * ----------
     */
    function gd(year, month, day) {
        return new Date(year, month, day).getTime();
    }

    var khof_7 = [{{ implode(',', $weekkhof) }}], ipul_7 = [{{ implode(',', $weekipul) }}];

    var khof_week = [], ipul_week = [];
    var today = new Date(2018,2,7,7,0,0,0).getTime();
    for (var i = -5; i <= 1; i++) {
        khof_week.push([today + (1000 * 3600 * 24 * i), khof_7[i + 5]])
        ipul_week.push([today + (1000 * 3600 * 24 * i), ipul_7[i + 5]])
    }
    var line_data1 = {
        label: "Khofifah",
        data: khof_week,
        color: khof_color
    }
    var line_data2 = {
        label: "Gus Ipul",
        data: ipul_week,
        color: ipul_color
    }
    $.plot('#week-chart', [line_data1, line_data2], {
        grid: {
            hoverable: true,
            borderColor: '#f3f3f3',
            borderWidth: 1,
            tickColor: '#f3f3f3'
        },
        series: {
            shadowSize: 0,
            lines: {
                show: true
            },
            points: {
                show: true
            }
        },
        lines: {
            fill: false,
            color: ['#3c8dbc', '#f56954']
        },
        yaxis: {
            show: true
        },
        xaxis: {
            mode: "time",
            tickSize: [1, "day"],
            tickLength: 0
        }
    })
    //Initialize tooltip on hover
    $('<div class="tooltip-inner" id="line-chart-tooltip"></div>').css({
        position: 'absolute',
        display: 'none',
        opacity: 0.8
    }).appendTo('body')
    $('#week-chart').bind('plothover', function (event, pos, item) {

        if (item) {
            var x = item.datapoint[0].toFixed(2),
                    y = item.datapoint[1].toFixed(2)

            $('#line-chart-tooltip').html(item.series.label + ' of ' + x + ' = ' + y)
                    .css({top: item.pageY + 5, left: item.pageX + 5})
                    .fadeIn(200)
        } else {
            $('#line-chart-tooltip').hide()
        }

    })
    /* END LINE CHART */

    

    /*
     * INTER CHART
     * ---------
     */

    var inter_khof = {
        data: [['Khofifah', {{ $followerkhof }}]],
        color: khof_color
    }
    var inter_gi = {
        data: [['Gus Ipul', {{ $followeripul }}]],
        color: ipul_color
    }
    $.plot('#interaction-chart', [inter_khof, inter_gi], {
        grid: {
            borderWidth: 1,
            borderColor: '#f3f3f3',
            tickColor: '#f3f3f3'
        },
        series: {
            bars: {
                show: true,
                barWidth: 0.5,
                align: 'center'
            }
        },
        xaxis: {
            mode: 'categories',
            tickLength: 0
        }
    })
    /* END INTER CHART */

    /*
     * TODAY CHART
     * ---------
     */

    var today_khof = {
        data: [['Khofifah', {{ $todaykhof }}]],
        color: khof_color
    }
    var today_gi = {
        data: [['Gus Ipul', {{ $todayipul }}]],
        color: ipul_color
    }
    $.plot('#today-chart', [today_khof, today_gi], {
        grid: {
            borderWidth: 1,
            borderColor: '#f3f3f3',
            tickColor: '#f3f3f3'
        },
        series: {
            bars: {
                show: true,
                barWidth: 0.5,
                align: 'center'
            }
        },
        xaxis: {
            mode: 'categories',
            tickLength: 0
        }
    })
    /* END TODAY CHART */



})

/*
 * Custom Label formatter
 * ----------------------
 */
function labelFormatter(label, series) {
    return '<div style="font-size:13px; text-align:center; padding:2px; color: #fff; font-weight: 600;">'
            + label
            + '<br>'
            + Math.round(series.percent) + '%</div>'
}
</script>

@endsection