@section('js')
<script>


    var chartmedia = AmCharts.makeChart("chartdivmediakhof", {
    "type": "serial",
            "theme": "light",
            "dataProvider":
    {!! \App\Http\Controllers\YoutubeController::getUserCount(1)!!},
            "gridAboveGraphs": true,
            "startDuration": 1,
            "valueAxes": [ {
            "minimum": 0
            } ],
            "graphs": [ {
            "balloonText": "[[category]]: <b>[[value]]</b>",
                    "fillAlphas": 0.8,
                    "lineAlpha": 0.2,
                    "type": "column",
                    "valueField": "count"
            } ],
            "chartCursor": {
            "categoryBalloonEnabled": true,
                    "cursorAlpha": 0,
                    "zoomable": true
            },
            "categoryField": "username",
            "categoryAxis": {
            "gridPosition": "start",
                    "gridAlpha": 0,
                    "tickPosition": "start",
                    "tickLength": 20
            },
            "creditsPosition" : "bottom-right",
            "rotate": true
    });
</script>
@append
<div id="chartdivmediakhof" style="width: 100%; height: 400px;"></div>