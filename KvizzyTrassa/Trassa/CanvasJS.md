## CanvasJS: Вывод графиков

---

#### [Graph-PHP Graph charts in PHP - Графики в PHP](https://github.com/vivesweb/graph-php)

#### [Красивые PHP-диаграммы для веб-приложений ](https://canvasjs.com/php-charts/)

#### [CanvasJS - Documentation](https://manuals.muthu.co/posts/javascript-libraries-and-functions/canvasjs.html#basic-chart-configuration)

#### [PHP Dynamic / Live Multi Series Chart](https://canvasjs.com/php-charts/dynamic-live-multi-series-chart/)

#### [How to Implement Range Charts using CanvasJS](https://www.geeksforgeeks.org/html/how-to-implement-range-charts-using-canvasjs/)

---

***Динамическая диаграмма PHP / многосерийная диаграмма в реальном времени***

Графики с несколькими рядами также поддерживают динамическое обновление данных. В приведенном примере показан динамический линейный график с несколькими рядами. Он также содержит исходный код на PHP, который можно запустить локально.

```
<?php

$dataPoints1 = array();
$dataPoints2 = array();
$updateInterval = 2000; //in millisecond
$initialNumberOfDataPoints = 100;
$x = time() * 1000 - $updateInterval * $initialNumberOfDataPoints;
$y1 = 1500;
$y2 = 1550;
// generates first set of dataPoints 
for($i = 0; $i < $initialNumberOfDataPoints; $i++){
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
window.onload = function() {

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

	// updating legend text with  updated with y Value 
	chart.options.data[0].legendText = "Building A " + yValue1 + " watts";
	chart.options.data[1].legendText = " Building B " + yValue2+ " watts"; 
	chart.render();
}

}
</script>
</head>
<body>
<div id="chartContainer" style="height: 370px; width: 100%;"></div>
<script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
</body>
</html>                              
```

### Как использовать valueFormatString в CanvasJS

valueFormatString в CanvasJS — это свойство, которое определяет формат отображения значений на осях диаграммы (X и Y). Оно позволяет настраивать отображение чисел, дат и времени в соответствии с требуемыми настройками. 

Для осей X и Y можно задавать формат отображения значений. Это улучшает читаемость диаграмм. Поддерживаются как числовые, так и дата/временные значения. Можно использовать специальные спецификаторы для форматирования.

Например, для чисел доступны такие опции, как:

- '0', заполнитель для нуля (заменяет ноль, если он есть, иначе в строке появится ноль);

- '#', заполнитель для цифры (если цифра есть, символ # заменяется на неё, иначе в строке ничего не появится);

- '...', литеральный разделитель строк, который копирует указанные символы в итоговую строку без изменений.

Для дат доступны специфические спецификаторы, например:

- D, день месяца от 1 до 31;

- DDD, сокращённое название дня недели;

- DDDD, полное название дня недели;

- MM, месяц (от 1 до 12);

- MMM, сокращённое название месяца;

- YY, год от 0 до 99;

- YYYY, год как четырёхзначное число.
 
#### Пример использования:

```
var chart = new CanvasJS.Chart("container", 
{
  axisX: 
  {
    valueFormatString: "#,##0.##"
  },
  axisY: 
  {
    valueFormatString: "#,##0.##"
  }
});
chart.render();
```

В этом примере значения на осях X и Y будут отображаться с форматом #,##0.##. 

#### Дополнительные возможности

- Пользовательские функции форматирования. Можно передать функцию в valueFormatString, чтобы реализовать сложное форматирование. 

- Динамическое изменение формата. Например, можно переопределять valueFormatString для небольших временных диапазонов (секунд, минут), сохраняя автоматический расчёт интервалов для больших диапазонов.

- Форматирование в подсказках (toolTip). Для этого можно использовать аналогичные функции форматирования, как для осей.

#### Важные замечания

valueFormatString применяется только к меткам на осях, а не к меткам точек данных.
При работе с датами важно убедиться, что они представлены в стандартном формате JavaScript (например, new Date()).

Спецификаторы формата могут варьироваться в зависимости от версии CanvasJS, поэтому стоит проверять актуальную документацию.
 
### [Более удобное форматирование меток осей](https://dev.to/ananya_deka/smarter-axis-label-formatting-based-on-zoom-level-in-canvasjs-2pc7) 

При построении графиков временных рядов от того, как вы отформатируете подписи к осям, может зависеть удобство их восприятия, особенно когда пользователи переключаются между секундами и годами. CanvasJS предоставляет отличную встроенную поддержку подписей к осям, основанным на времени, но при работе с данными с точностью до секунды или часа (например, показаниями датчиков, дашбордами в реальном времени) стандартное поведение не всегда обеспечивает наилучшую читаемость. 

В этом руководстве показано, как настроить подписи к осям для небольших временных интервалов (секунды, минуты), сохранив при этом автоматическое вычисление интервалов в CanvasJS для больших интервалов.

#### Задача

Для небольших временных интервалов (например, 30 секунд или 10 минут) CanvasJS может:

- не указывать секунды в подписях, даже если это важно для точности;

- выбирать интервалы, которые приводят к загромождению подписей (например, 1 секунда для диапазона в 30 секунд);

- не соответствовать ожиданиям пользователей в отношении формата подписей (например, указывайте 14:00 вместо 14:00:00).

#### Решение

Мы переопределим свойство valueFormatString только для диапазонов с точностью до получаса, а для больших диапазонов оставим обработку на усмотрение CanvasJS.

Основные улучшения:

Точность до секунды для диапазонов менее 1 минуты.
Четкие интервалы (например, с шагом в 5 секунд или 1 минуту).
Динамические переходы между форматами (секунды → минуты → часы).

#### Динамическое форматирование меток осей для коротких диапазонов

```
function getFormatString(axis) 
{
    var min = axis.viewportMinimum || axis.minimum;
    var max = axis.viewportMaximum || axis.maximum;
    var rangeMs = max - min;
    var MINUTE = 60 * 1000;
    var HOUR = 60 * MINUTE;
    var DAY = 24 * HOUR;
    var MONTH = 30 * DAY; // Approximation
    var YEAR = 365 * DAY;

    if (rangeMs < 1 * MINUTE) 
        return "HH:mm:ss"; // <1 minute: show seconds
    if (rangeMs < 1 * HOUR) 
        return "HH:mm"; // 1min–1hr: minutes
    if (rangeMs < 1 * DAY) 
        return "HH:mm"; // 1hr–1 day: hours
    if (rangeMs < 10 * DAY) 
        return "MMM DD HH:mm"; // 1 day–10 days: day + month + hours
    if (rangeMs < 3 * MONTH) 
        return "MMM DD"; // 10 days–3 months: day + month
    if (rangeMs < 3 * YEAR) 
        return "MMM YYYY"; // 3 months–3 years: month + year

    return "YYYY"; // >3 years: year only
}

```

#### Подключение к событиям диаграммы

```
var chart = new CanvasJS.Chart("chartContainer", {
    zoomEnabled: true,
    axisX: {
        valueFormatString: "MMM DD, YYYY" // Initial format, may be overridden
    },
    data: [{
        type: "line",
        xValueType: "dateTime",
        dataPoints: generateDataPoints() // Generate your time-series data
    }],
    rangeChanged: function (e) {
        var formatString = null;
        if (e.trigger != "reset")
            formatString = getFormatString(e.axisX[0]);
        e.chart.axisX[0].set("valueFormatString", formatString);
    }
});

```

