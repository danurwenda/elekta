@section('js')
<!-- Chart code -->
<script>
    var chartipul = AmCharts.makeChart("chartdivipul", {
    "type": "pie",
            "theme": "light",
            "innerRadius": "40%",
            "titles": [{"text":"Gus Ipul"}],
            "dataProvider": [{
            "Platform": "News",
                    "jumlah": {{ \App\Http\Controllers\MainmediaController::getYesterday(2) }}
            }, {
            "Platform": "Twitter",
                    "jumlah": {{ \App\Http\Controllers\TwitterController::getYesterday(2) }}
            }, {
            "Platform": "Youtube",
                    "jumlah": {{ \App\Http\Controllers\YoutubeController::getYesterday(2) }}
            }, {
            "Platform": "Facebook",
                    "jumlah": {{ \App\Http\Controllers\FacebookController::getYesterday(2) }}
            }, {
            "Platform": "Google+",
                    "jumlah": {{ \App\Http\Controllers\GplusController::getYesterday(2) }}
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
    #chartdivipul {
        width		: 100%;
        height		: 400px;
        font-size	: 11px;
    }							
</style>
<!-- HTML -->
<div id="chartdivipul"></div>	
