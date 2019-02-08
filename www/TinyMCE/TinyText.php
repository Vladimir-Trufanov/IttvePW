<!DOCTYPE html> 
<!-- 
-->
<html>

<head>
   <meta http-equiv="content-type" content="text/html; charset=utf-8" />
   <title>Сохранение!</title>
   <script src="/js/IttvePW.js"></script>
</head>

<body>

<article>

<?php
if(isset($_POST['enter']))
{
   // Открыть текстовый файл
   $f = fopen("textfile.html", "w");
   // Записать текст
   fwrite($f, $_POST['dor']); 
   // Закрыть текстовый файл
   fclose($f);
}
?>

Приветик!

</article>


</body>
</html>
