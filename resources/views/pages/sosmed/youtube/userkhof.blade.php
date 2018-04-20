<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>amCharts examples</title>
       


        <!-- Chart code -->
		<script>
		
		
		var chartmedia = AmCharts.makeChart( "chartdivmediakhof", {
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
		} );
		</script>
    </head>

    <body>
        <div id="chartdivmediakhof" style="width: 100%; height: 400px;"></div>
    </body>

</html>