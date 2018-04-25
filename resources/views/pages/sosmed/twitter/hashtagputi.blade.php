@section('js')
<script>


    var charthashtagputi = AmCharts.makeChart("chartdivhashtagputi", {
    "type": "serial",
            "theme": "light",
            "dataProvider":
    {!! \App\Http\Controllers\TwitterController::getHashtagCount(4)!!},
            "gridAboveGraphs": true,
            "startDuration": 1,
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
            "categoryField": "hashtag",
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
<div id="chartdivhashtagputi" style="width: 100%; height: 400px;"></div>