<?php
// Ex6_BasicColumnChart.php

/*

1. Создаём новый объект Сhart, передав идентификатор элемента div, в котором будет 
отображаться диаграмма (можно передать элемент DOM вместо идентификатора).

2. Передаём “options” (все «параметры», связанные с диаграммой) в конструктор в качестве второго параметра.

3. Вызываем метод chart.render(), чтобы отобразить диаграмму.

4. Параметр “options” в основном состоит из 4 важных элементов:

title      - объект с заданным свойством text;
dataPoints - массив всех элементов данных (точек), которые нужно отобразить;
dataSeries - родительский элемент dataPoints, который определяет тип диаграммы и другие параметры серии;
data       - массив, представляющий собой коллекцию из одного или нескольких объектов dataSeries. 
*/

?>
<script type="text/javascript">
window.onload = function () 
{
  var chart = new CanvasJS.Chart("chartContainer", 
  {
    title:
    {
      text: "Фрукты, проданные в первом квартале"              
    },
    // Определяем массив объектов dataSeries 
    data: 
    [
      // Определяем первый и единственный объект dataSeries           
      { 
        /*** Change type "column" to "bar", "area", "line" or "pie"***/
        // type: "column",
        // type: "bar",
        // type: "area",
        type: "pie",
        // Определяем массив точек, которые нужно отобразить
        dataPoints: 
        [
          {label: "banana", y: 18},
          {label: "orange", y: 29},
          {label: "apple",  y: 40},                                    
          {label: "mango",  y: 34},
          {label: "grape",  y: 24}
        ]
      }
    ]
  });
  chart.render();
}
</script>
</head>
<body>
<div id="chartContainer" style="height: 300px; width: 100%;"></div>

