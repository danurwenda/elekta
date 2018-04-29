@section('js')
<script>
    var chartemil = AmCharts.makeChart("chartdivemil", {
    "type": "pie",
            "theme": "light",
            "innerRadius": "40%",
            "titles": [{"text":"Emil"}],
            "dataProvider": [{
            "Platform": "News",
                    "jumlah": {{ \App\Http\Controllers\MainmediaController::getYesterday(3) }}
            }, {
            "Platform": "Twitter",
                    "jumlah": {{ \App\Http\Controllers\TwitterController::getYesterday(3) }}
            }, {
            "Platform": "Youtube",
                    "jumlah": {{ \App\Http\Controllers\YoutubeController::getYesterday(3) }}
            }, {
            "Platform": "Facebook",
                    "jumlah": 0
            }, {
            "Platform": "Google+",
                    "jumlah": {{ \App\Http\Controllers\GplusController::getYesterday(3) }}
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
    #chartdivemil {
        width		: 100%;
        height		: 400px;
        font-size	: 11px;
    }							
</style>
<!-- HTML -->
<div id="chartdivemil"></div>	