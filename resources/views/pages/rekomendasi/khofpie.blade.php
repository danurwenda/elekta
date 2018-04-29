@section('js')
<script>
    var chartkhof = AmCharts.makeChart("chartdivkhof", {
    "type": "pie",
            "theme": "light",
            "innerRadius": "40%",
            "titles": [{"text":"Khofifah"}],
            "dataProvider": [{
            "Platform": "News",
                    "jumlah": {{ \App\Http\Controllers\MainmediaController::getYesterday(1) }}
            }, {
            "Platform": "Twitter",
                    "jumlah": {{ \App\Http\Controllers\TwitterController::getYesterday(1) }}
            }, {
            "Platform": "Youtube",
                    "jumlah": {{ \App\Http\Controllers\YoutubeController::getYesterday(1) }}
            }, {
            "Platform": "Facebook",
                    "jumlah": {{ \App\Http\Controllers\FacebookController::getYesterday(1) }}
            }, {
            "Platform": "Google+",
                    "jumlah": {{ \App\Http\Controllers\GplusController::getYesterday(1) }}
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
<!-- HTML -->
<style>
    #chartdivkhof {
        width		: 100%;
        height		: 400px;
        font-size	: 11px;
    }							
</style>
<div id="chartdivkhof"></div>	
