<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>amCharts examples</title>
       
		<!-- Resources -->


        <!-- Chart code -->
		<script>
		
		
		var chartweeks = AmCharts.makeChart( "chartdivweeks", {
			"theme": "light",
			"type": "serial",
			"marginRight": 80,
			"autoMarginOffset": 20,
			"marginTop":20,
			"dataProvider": {!! \App\Http\Controllers\GplusController::getWeeks() !!},
			"valueAxes": [{
				"id": "v1",
				"axisAlpha": 0.1
			}],
			"graphs": [{
				"valueAxis": "v1",
				"title" : "Khofifah",
				"useNegativeColorIfDown": true,
				"balloonText": "[[category]]<br><b>[[title]]: [[value]]</b>",
				"bullet": "round",
				"bulletBorderAlpha": 1,
				"bulletBorderColor": "#FFFFFF",
				"hideBulletsCount": 50,
				"lineThickness": 2,
				"lineColor": "#1FBED6",
				"valueField": "khofifah"
			},
			{
				"valueAxis": "v1",
				"title" : "Emil",
				"useNegativeColorIfDown": true,
				"balloonText": "[[category]]<br><b>[[title]]: [[value]]</b>",
				"bullet": "round",
				"bulletBorderAlpha": 1,
				"bulletBorderColor": "#FFFFFF",
				"hideBulletsCount": 50,
				"lineThickness": 2,
				"lineColor": "blue",
				"valueField": "emil"
			},
			{
				"valueAxis": "v1",
				"title" : "Gus Ipul",
				"useNegativeColorIfDown": true,
				"balloonText": "[[category]]<br><b>[[title]]: [[value]]</b>",
				"bullet": "round",
				"bulletBorderAlpha": 1,
				"bulletBorderColor": "#FFFFFF",
				"hideBulletsCount": 50,
				"lineThickness": 2,
				"lineColor": "red",
				"valueField": "ipul"
			},
			{
				"valueAxis": "v1",
				"title" : "Puti",
				"useNegativeColorIfDown": true,
				"balloonText": "[[category]]<br><b>[[title]]: [[value]]</b>",
				"bullet": "round",
				"bulletBorderAlpha": 1,
				"bulletBorderColor": "#FFFFFF",
				"hideBulletsCount": 50,
				"lineThickness": 2,
				"lineColor": "pink",
				"valueField": "puti"
			}],
			"chartScrollbar": {
				"scrollbarHeight": 5,
				"backgroundAlpha": 0.1,
				"backgroundColor": "#868686",
				"selectedBackgroundColor": "#67b7dc",
				"selectedBackgroundAlpha": 1
			},
			"chartCursor": {
				"valueLineEnabled": true,
				"valueLineBalloonEnabled": true
			},
			"categoryField": "date",
			"categoryAxis": {
				"parseDates": true,
				"axisAlpha": 0,
				"minHorizontalGap": 60
			},
			"legend": { 
				"align" : "center",
				"useGraphSettings": true
			}
		});
		
	
		</script>
    </head>

    <body>
        <div id="chartdivweeks" style="width: 100%; height: 400px;"></div>
    </body>

</html>