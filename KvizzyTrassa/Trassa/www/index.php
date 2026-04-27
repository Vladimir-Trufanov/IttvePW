<?php

?>
<!DOCTYPE HTML>
<html lang="ru">
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<head>
<?php
// Для последующих привязок определяем протокол
if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') $http='https'; 
else $http='http';
// Привязываем скрипт построения графиков, указывая полный путь
echo '<script src="'.$http.'://'.$_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT'].'/canvasjs.min.js"></script>';

// 
require_once 'Ex7_MultiSeriesColumnChart.php';
// 
// require_once 'Ex3.php';

/*
echo '<br><br>'; 
echo '$_SERVER["DOCUMENT_ROOT"]   '.$_SERVER['DOCUMENT_ROOT'].'<br>'; 
echo '$_SERVER["SCRIPT_NAME"]     '.$_SERVER['SCRIPT_NAME'].'<br>'; 
echo '__FILE__                    '.__FILE__.'<br>'; 
echo '$_SERVER["SERVER_NAME"]     '.$_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT'].'<br>'; 
echo '$_SERVER["SCRIPT_FILENAME"] '.$_SERVER['SCRIPT_FILENAME'].'<br>'; 
echo '$_SERVER["SERVER_PORT"]     '.$_SERVER['SERVER_PORT'].'<br>'; 
echo '$_SERVER["HTTPS"]           '.$_SERVER['HTTPS'].'<br>'; 
*/

?>
</body>
</html>      
