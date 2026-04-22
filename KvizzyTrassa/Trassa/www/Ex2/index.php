<?php

// 2026-04-22 ----Это оригинальный пример со страницы:
// -----https://canvasjs.com/php-charts/dynamic-live-multi-series-chart/

$dataPoints1 = array();
$dataPoints2 = array();
$updateInterval = 2000; //in millisecond
$initialNumberOfDataPoints = 100;
$x = time() * 1000 - $updateInterval * $initialNumberOfDataPoints;
$y1 = 1500;
$y2 = 1550;
// generates first set of dataPoints 
for($i = 0; $i < $initialNumberOfDataPoints; $i++)
{
	$y1 += round(rand(-2, 2));
	$y2 += round(rand(-2, 2));	
	array_push($dataPoints1, array("x" => $x, "y" => $y1));
	array_push($dataPoints2, array("x" => $x, "y" => $y2));
	$x += $updateInterval;
}

?>
<!DOCTYPE HTML>
<html>
<head>
<script>
window.onload = function() 
{

var updateInterval = <?php echo $updateInterval ?>;
var dataPoints1 = <?php echo json_encode($dataPoints1, JSON_NUMERIC_CHECK); ?>;
var dataPoints2 = <?php echo json_encode($dataPoints2, JSON_NUMERIC_CHECK); ?>;
var yValue1 = <?php echo $y1 ?>;
var yValue2 = <?php echo $y2 ?>;
var xValue = <?php echo $x ?>;

var chart = new CanvasJS.Chart("chartContainer", {
	zoomEnabled: true,
	title: {
		text: "Live Power Consumption of 2 Buildings"
	},
	axisX: {
		title: "chart updates every " + updateInterval / 1000 + " secs"
	},
	axisY:{
		suffix: " watts"
	}, 
	toolTip: {
		shared: true
	},
	legend: {
		cursor:"pointer",
		verticalAlign: "top",
		fontSize: 22,
		fontColor: "dimGrey",
		itemclick : toggleDataSeries
	},
	data: [{ 
			type: "line",
			name: "Building A",
			xValueType: "dateTime",
			yValueFormatString: "#,### watts",
			xValueFormatString: "hh:mm:ss TT",
			showInLegend: true,
			legendText: "{name} " + yValue1 + " watts",
			dataPoints: dataPoints1
		},
		{				
			type: "line",
			name: "Building B" ,
			xValueType: "dateTime",
			yValueFormatString: "#,### watts",
			showInLegend: true,
			legendText: "{name} " + yValue2 + " watts",
			dataPoints: dataPoints2
	}]
});

chart.render();
setInterval(function(){updateChart()}, updateInterval);

function toggleDataSeries(e) {
	if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
		e.dataSeries.visible = false;
	}
	else {
		e.dataSeries.visible = true;
	}
	chart.render();
}

function updateChart() {
	var deltaY1, deltaY2;
	xValue += updateInterval;
	// adding random value
	yValue1 += Math.round(2 + Math.random() *(-2-2));
	yValue2 += Math.round(2 + Math.random() *(-2-2));

	// pushing the new values
	dataPoints1.push({
		x: xValue,
		y: yValue1
	});
	dataPoints2.push({
		x: xValue,
		y: yValue2
	});

	// Обновляем историю показателей по оси Y
  // --- ение текста условных обозначений со значением updated with y Оupdating legend text with  updated with y Value 
	chart.options.data[0].legendText = "Building A " + yValue1 + " watts";
	chart.options.data[1].legendText = " Building B " + yValue2+ " watts"; 
	chart.render();
}

}
</script>
</head>
<body>
<div id="chartContainer" style="height: 370px; width: 100%;"></div>
<script src="canvasjs.min.js"></script>
</body>
</html>                              
