@section('js')
<script>
    var chart = AmCharts.makeChart("chartdivtoday", {
    "type": "serial",
            "theme": "light",
            "legend": {
            "horizontalGap": 10,
                    "maxColumns": 1,
                    "position": "right",
                    "useGraphSettings": true,
                    "markerSize": 10
            },
            "dataProvider": [
            {
            "Platform": "News",
                    "khofifah": {{ \App\Http\Controllers\MainmediaController::getToday(1)}},
                    "emil": {{ \App\Http\Controllers\MainmediaController::getToday(3)}},
                    "gusipul": {{ \App\Http\Controllers\MainmediaController::getToday(2)}},
                    "puti": {{ \App\Http\Controllers\MainmediaController::getToday(4)}}
            }, {
            "Platform": "Facebook",
                    "khofifah": {{ \App\Http\Controllers\FacebookController::getToday(1)}},
                    "gusipul": {{ \App\Http\Controllers\FacebookController::getToday(2)}},
            }, {
            "Platform": "Twitter",
                    "khofifah": {{ \App\Http\Controllers\TwitterController::getToday(1)}},
                    "emil": {{ \App\Http\Controllers\TwitterController::getToday(3)}},
                    "gusipul": {{ \App\Http\Controllers\TwitterController::getToday(2)}},
                    "puti": {{ \App\Http\Controllers\TwitterController::getToday(4)}}
            }, {
            "Platform": "Youtube",
                    "khofifah": {{ \App\Http\Controllers\YoutubeController::getToday(1)}},
                    "emil": {{ \App\Http\Controllers\YoutubeController::getToday(3)}},
                    "gusipul": {{ \App\Http\Controllers\YoutubeController::getToday(2)}},
                    "puti": {{ \App\Http\Controllers\YoutubeController::getToday(4)}}
            }, {
            "Platform": "Google+",
                    "khofifah": {{ \App\Http\Controllers\GplusController::getToday(1)}},
                    "emil": {{ \App\Http\Controllers\GplusController::getToday(3)}},
                    "gusipul": {{ \App\Http\Controllers\GplusController::getToday(2)}},
                    "puti": {{ \App\Http\Controllers\GplusController::getToday(4)}}
            }],
            "valueAxes": [{
            "stackType": "none",
                    "axisAlpha": 0.3,
                    "gridAlpha": 0
            }],
            "graphs": [{
            "balloonText": "<b>[[title]]</b><br><span style='font-size:14px'>[[category]]: <b>[[value]]([[percents]]%)</b></span>",
                    "fillAlphas": 0.8,
                    "labelText": "[[value]]",
                    "lineAlpha": 0.3,
                    "title": "Khofifah",
                    "type": "column",
                    "color": "#000000",
                    "fillColors" : "#1FBED6",
                    "valueField": "khofifah"
            }, {
            "balloonText": "<b>[[title]]</b><br><span style='font-size:14px'>[[category]]: <b>[[value]]([[percents]]%)</b></span>",
                    "fillAlphas": 0.8,
                    "labelText": "[[value]]",
                    "lineAlpha": 0.3,
                    "title": "Emil",
                    "type": "column",
                    "color": "#000000",
                    "fillColors" : "blue",
                    "valueField": "emil"
            }, {
            "balloonText": "<b>[[title]]</b><br><span style='font-size:14px'>[[category]]: <b>[[value]]([[percents]]%)</b></span>",
                    "fillAlphas": 0.8,
                    "labelText": "[[value]]",
                    "lineAlpha": 0.3,
                    "title": "Gus Ipul",
                    "type": "column",
                    "color": "#000000",
                    "fillColors" : "red",
                    "valueField": "gusipul"
            }, {
            "balloonText": "<b>[[title]]</b><br><span style='font-size:14px'>[[category]]: <b>[[value]]([[percents]]%)</b></span>",
                    "fillAlphas": 0.8,
                    "labelText": "[[value]]",
                    "lineAlpha": 0.3,
                    "title": "Puti",
                    "type": "column",
                    "color": "#000000",
                    "fillColors" : "pink",
                    "valueField": "puti"
            }],
            "categoryField": "Platform",
            "categoryAxis": {
            "gridPosition": "start",
                    "axisAlpha": 0,
                    "gridAlpha": 0,
                    "position": "left"
            }

    });
</script>
@append
<div id="chartdivtoday" style="width: 100%; height: 400px;"></div>
