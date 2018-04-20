<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>amCharts examples</title>
       


        <!-- Chart code -->
		<script>
		AmCharts.addInitHandler(function(chart) { 
  
  //method to handle removing/adding columns when the marker is toggled
  function handleCustomMarkerToggle(legendEvent) {
      var dataProvider = legendEvent.chart.dataProvider;
      var itemIndex; //store the location of the removed item

      //Set a custom flag so that the dataUpdated event doesn't fire infinitely, in case you have
      //a dataUpdated event of your own
      legendEvent.chart.toggleLegend = true; 
      // The following toggles the markers on and off.
      // The only way to "hide" a column and reserved space on the axis is to remove it
      // completely from the dataProvider. You'll want to use the hidden flag as a means
      // to store/retrieve the object as needed and then sort it back to its original location
      // on the chart using the dataIdx property in the init handler
      if (undefined !== legendEvent.dataItem.hidden && legendEvent.dataItem.hidden) {
        legendEvent.dataItem.hidden = false;
        dataProvider.push(legendEvent.dataItem.storedObj);
        legendEvent.dataItem.storedObj = undefined;
        //re-sort the array by dataIdx so it comes back in the right order.
        dataProvider.sort(function(lhs, rhs) {
          return lhs.dataIdx - rhs.dataIdx;
        });
      } else {
        // toggle the marker off
        legendEvent.dataItem.hidden = true;
        //get the index of the data item from the data provider, using the 
        //dataIdx property.
        for (var i = 0; i < dataProvider.length; ++i) { 
          if (dataProvider[i].dataIdx === legendEvent.dataItem.dataIdx) {
            itemIndex = i;
            break;
          }
        }
        //store the object into the dataItem
        legendEvent.dataItem.storedObj = dataProvider[itemIndex];
        //remove it
        dataProvider.splice(itemIndex, 1);
      }
      legendEvent.chart.validateData(); //redraw the chart
  }

  //check if legend is enabled and custom generateFromData property
  //is set before running
  if (!chart.legend || !chart.legend.enabled || !chart.legend.generateFromData) {
    return;
  }
  
  var categoryField = chart.categoryField;
  var colorField = chart.graphs[0].lineColorField || chart.graphs[0].fillColorsField || chart.graphs[0].colorField;
  var legendData =  chart.dataProvider.map(function(data, idx) {
    var markerData = {
      "title": data[categoryField] + ": " + data[chart.graphs[0].valueField], 
      "color": data[colorField],
      "dataIdx": idx //store a copy of the index of where this appears in the dataProvider array for ease of removal/re-insertion
    };
    if (!markerData.color) {
      markerData.color = chart.graphs[0].lineColor;
    }
    data.dataIdx = idx; //also store it in the dataProvider object itself
    return markerData;
  });
  
  chart.legend.data = legendData;
  
  //make the markers toggleable
  chart.legend.switchable = true;
  chart.legend.addListener("clickMarker", handleCustomMarkerToggle);
  
}, ["serial"]);
		
		var chart = AmCharts.makeChart( "chartdivtoday", {
		  "type": "serial",
		  "theme": "light",
		  "dataProvider": [ {
			"color" : "#1FBED6",  
			"Cagub": "Khofifah",
			"Jumlah": {{ \App\Http\Controllers\YoutubeController::getToday(1)}}
		  },{
			"color" : "blue",  
			"Cagub": "Emil",
			"Jumlah": {{ \App\Http\Controllers\YoutubeController::getToday(2)}}
		  }, {
			"color" : "red",
			"Cagub": "Gus Ipul",
			"Jumlah": {{ \App\Http\Controllers\YoutubeController::getToday(3)}}
		  },{
			"color" : "pink",  
			"Cagub": "Puti",
			"Jumlah": {{ \App\Http\Controllers\YoutubeController::getToday(4)}}
		  }],
		  "valueAxes": [ {
			"minimum": 0,
			"gridColor": "#FFFFFF",
			"gridAlpha": 0.2,
			"dashLength": 0
		  } ],
		  "gridAboveGraphs": true,
		  "startDuration": 1,
		  "graphs": [ {
			"balloonText": "[[category]]: <b>[[value]]</b>",
			"colorField" : "color",
			"fillAlphas": 0.8,
			"lineAlpha": 0.2,
			"type": "column",
			"valueField": "Jumlah"
		  } ],
		  "chartCursor": {
			"categoryBalloonEnabled": false,
			"cursorAlpha": 0,
			"zoomable": false
		  },
		  "categoryField": "Cagub",
		  "categoryAxis": {
			"gridPosition": "start",
			"gridAlpha": 0,
			"tickPosition": "start",
			"tickLength": 20
		  },
		  "legend": { 
			"align" : "center", 
			"generateFromData": true //custom property for the plugin
		  }

		} );
		</script>
    </head>

    <body>
        <div id="chartdivtoday" style="width: 100%; height: 400px;"></div>
    </body>

</html>