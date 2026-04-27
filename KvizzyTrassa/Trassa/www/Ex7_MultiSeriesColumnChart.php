<?php
// Ex7_MultiSeriesColumnChart.php
?>
<script type="text/javascript">
window.onload = function () 
{
  var chart = new CanvasJS.Chart("chartContainer", 
  {            
    title:
    {
      text: "Фрукты, проданные в первом и втором кварталах"              
    },
    data: 
    [     
      { // dataSeries - first quarter
        /*** Change type "column" to "bar", "area", "line" or "pie"***/        
        // type: "column",
        // type: "bar",
        // type: "area",
        type: "spline",
        name: "First Quarter",
        dataPoints: 
        [
          {label: "banana", y: 58},
          {label: "orange", y: 69},
          {label: "apple",  y: 80},                                    
          {label: "mango",  y: 74},
          {label: "grape",  y: 64}
        ]
      },
      { // dataSeries - first quarter
        /*** Change type "column" to "bar", "area", "line" or "pie"***/        
        // type: "column",
        // type: "bar",
        // type: "area",
        type: "spline",
        name: "ещё",
        dataPoints: 
        [
          {label: "banana", y: 158},
          {label: "orange", y: 169},
          {label: "apple",  y: 180},                                    
          {label: "mango",  y: 174},
          {label: "grape",  y: 364}
        ]
      },
      { //dataSeries - second quarter
        // type: "column",
        // type: "bar",
        // type: "area",
        type: "spline",
        name: "Second Quarter",                
        dataPoints: 
        [
          {label: "banana", y: 63},
          {label: "orange", y: 73},
          {label: "apple",  y: 88},                                    
          {label: "mango",  y: 77},
          {label: "grape",  y: 60}
        ]
      }
    ]
  });
  chart.render();
}
</script>
</head>
<body>
<div id="chartContainer" style="height: 600px; width: 100%;"></div>
