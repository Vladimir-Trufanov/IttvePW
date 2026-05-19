<?php
 
?>
<script>
window.onload = function () 
{

  var chart = new CanvasJS.Chart("chartContainer", 
  {
    zoomEnabled: true,
    axisX: 
    {
      valueFormatString: "MMM DD, YYYY" // Initial format, may be overridden
    },
    data: [
    {
      type: "line",
      xValueType: "dateTime",
      dataPoints: generateDataPoints() // Generate your time-series data
    }],
    rangeChanged: function (e) 
    {
      var formatString = null;
      if (e.trigger != "reset") formatString = getFormatString(e.axisX[0]);
      e.chart.axisX[0].set("valueFormatString", formatString);
    }
  });
  chart.render();

  function generateDataPoints() 
  {
    var dataPoints = [];

    var startDate = new Date("2025-01-01T00:00:00Z"); // Start: Jan 1, 2025
    var endDate = new Date("2025-02-01T00:00:00Z"); // End: Feb 1, 2025
    var startMillis = startDate.getTime();
    var endMillis = endDate.getTime();

    var interval = 30 * 60 * 1000;
    var currentMillis = startMillis;

    while (currentMillis < endMillis) 
    {
      var secondsSinceStart = (currentMillis - startMillis) / 1000;

      // Sine wave + random noise
      var value = 50 + 10 * Math.sin(secondsSinceStart / 3600) + Math.random() * 2;

      dataPoints.push({
        x: new Date(currentMillis),
        y: Math.round(value * 100) / 100 // Round to 2 decimal places
      });

      currentMillis += interval;
    }
    return dataPoints;
  }
  
  /*
  https://dev.to/ananya_deka/smarter-axis-label-formatting-based-on-zoom-level-in-canvasjs-2pc7
  Такой подход позволяет переопределять интервалы и форматы только для диапазонов, кратных часу, 
  и сочетать индивидуальную настройку со встроенными интеллектуальными функциями CanvasJS. 
  Разработчики получают возможность детально настраивать отображение секунд и минут, 
  не жертвуя при этом надежностью библиотеки при работе с более длительными временными 
  интервалами. Используйте этот подход для создания информационных панелей, которые 
  будут отлично смотреться при любом масштабе — от миллисекунд до десятилетий!
  */
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

    if (rangeMs < 1 * MINUTE) return "HH:mm:ssTT"; // <1 minute: show seconds
    if (rangeMs < 1 * HOUR) return "hh:mmTT"; // 1min–1hr: minutes
    if (rangeMs < 1 * DAY) return "hh:mmTT"; // 1hr–1 day: hours
    if (rangeMs < 10 * DAY) return "MMM DD hh:mm"; // 1 day–10 days: day + month + hours
    if (rangeMs < 3 * MONTH) return "MMM DD"; // 10 days–3 months: day + month
    if (rangeMs < 3 * YEAR) return "MMM YYYY"; // 3 months–3 years: month + year
    return "YYYY"; // >3 years: year only
  }
}
</script>

</head>
<body>
<div id="chartContainer" style="height: 370px; width: 100%;"></div>
