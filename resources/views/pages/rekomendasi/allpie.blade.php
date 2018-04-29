<!-- Styles -->
<style>
#chartdiv {
	width		: 100%;
	height		: 400px;
	font-size	: 11px;
}							
</style>
@section('js')

<!-- Chart code -->
<script>
var chart = AmCharts.makeChart("chartdiv", {
    "type": "pie",
    "theme": "light",
    "innerRadius": "40%",
	"titles" : [{"text": "Hari Ini"}],
    "dataProvider": [{
        "Cagub": "Khofifah - Emil",
		'color': "#1FBED6",
        "jumlah": {{ \App\Http\Controllers\CumulativeController::getAllYesterday(1)+\App\Http\Controllers\CumulativeController::getAllYesterday(3) }}
    }, {
        "Cagub": "Gus Ipul - Puti",
		'color': 'red',
        "jumlah": {{ \App\Http\Controllers\CumulativeController::getAllYesterday(2)+\App\Http\Controllers\CumulativeController::getAllYesterday(4) }}
    }],
    "balloonText": "[[title]] : [[percents]]%",
    "valueField": "jumlah",
    "titleField": "Cagub",
	'labelsEnabled': false,
	'autoMargins': true,
	"colorField": "color",
    "balloon": {
        
        "adjustBorderColor": false,
        "color": "#FFFFFF",
        "fontSize": 14
    },
	"legend":{
		"position":"bottom",
		"valueText": "[[percents]]%",
		"align" : "center"
	  }
});


</script>
@append
<!-- HTML -->
<div id="chartdiv"></div>	