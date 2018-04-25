@section('js')
<script>


    var chartmediaputi = AmCharts.makeChart("chartdivmediaputi", {
    "type": "serial",
            "theme": "light",
            "dataProvider":
    {!! \App\Http\Controllers\MainmediaController::getMediaCount(4)!!},
            "gridAboveGraphs": true,
            "startDuration": 1, "valueAxes": [ {
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
            "categoryField": "media",
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
<div id="chartdivmediaputi" style="width: 100%; height: 400px;"></div>