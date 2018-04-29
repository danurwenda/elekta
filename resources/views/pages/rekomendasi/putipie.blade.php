@section('js')
<!-- Chart code -->
<script>
    var chartputi = AmCharts.makeChart("chartdivputi", {
    "type": "pie",
            "theme": "light",
            "innerRadius": "40%",
            "titles": [{"text":"Puti"}],
            "dataProvider": [{
            "Platform": "News",
                    "jumlah": {{ \App\Http\Controllers\MainmediaController::getYesterday(4) }}
            }, {
            "Platform": "Twitter",
                    "jumlah": {{ \App\Http\Controllers\TwitterController::getYesterday(4) }}
            }, {
            "Platform": "Youtube",
                    "jumlah": {{ \App\Http\Controllers\YoutubeController::getYesterday(4) }}
            }, {
            "Platform": "Facebook",
                    "jumlah": 0
            }, {
            "Platform": "Google+",
                    "jumlah": {{ \App\Http\Controllers\GplusController::getYesterday(4) }}
            }],
            "balloonText": "[[title]] : [[percents]]%",
            "valueField": "jumlah",
            "titleField": "Platform",
            'labelsEnabled': false,
            'autoMargins': true,
            "balloon": {
            "drop": true,
                    "adjustBorderColor": false,
                    "color": "#FFFFFF",
                    "fontSize": 14
            },
            "legend":{
            "position":"right",
                    "valueText": "[[percents]]%"
            }
    });


</script>
@append
<!-- Styles -->
<style>
    #chartdivputi {
        width		: 100%;
        height		: 400px;
        font-size	: 11px;
    }							
</style>

<!-- HTML -->
<div id="chartdivputi"></div>	