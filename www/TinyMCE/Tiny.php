<?php

// Записываем материал в файл при запросе 
if(isset($_POST['enter']))
{
   // Открыть текстовый файл
   $f = fopen("../KwinTiny/Arc/textfile.html","w");
   // Записать текст
   fwrite($f, $_POST['dor']); 
   // Закрыть текстовый файл
   fclose($f);
}
?>

<!DOCTYPE html>
<!-- 
-->
<html lang="ru">
<head>
   <title>KwinTiny-редактор материалов!</title>
   <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
   <meta name="description" content="Труфанов Владимир Евгеньевич, редактор материалов TinyMCE">
   <meta name="keywords" content="Труфанов Владимир Евгеньевич,KwinTiny,TinyMCE,редактор материалов">
   <link rel="stylesheet"
      href="https://fonts.googleapis.com/css?family=Anonymous+Pro:400,400i,700,700i&amp;
      subset=cyrillic">
   <link rel="stylesheet" 
      href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
   <link rel="stylesheet" type="text/css" href="/TinyMCE/Styles.css">

   <!-- 
        theme: 'modern',
   -->

   <script src="/TinyMCE/tinymce.min.js"></script>
   <script>tinymce.init
    ({
        selector: '#mytextarea',
        height: 420,
        width:  810,
        content_css: '/TinyMCE/TinyMCE.css',
        plugins:
        [ 
            'advlist autolink link image imagetools lists charmap print preview hr anchor',
            'pagebreak spellchecker searchreplace wordcount visualblocks',
            'visualchars code fullscreen insertdatetime media nonbreaking',
            'save table contextmenu directionality emoticons template paste',
            'textcolor'
        ],
        language: "ru",
        toolbar:
        [
            'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons'
        ],
        a_plugin_option: true,
        a_configuration_option: 400
    });
    </script>
    
</head>

<body>
<div class="Info">

   <div class="InfoLeft">
      <?php
      // Извлекаем прежнее содержимое материала в переменную
      $filename="../KwinTiny/Arc/textfile.html";
      $handle = fopen($filename, "r");
      $contents = fread($handle, filesize($filename));
      fclose($handle);
      // Показываем содержимое материала в переменной
      // echo '888'.$contents.'999';
      ?>
      
      <form id="frmTinyText" method="post" action="/TinyMCE/Tiny.php">
         <textarea id="mytextarea" name="dor">
         <?php
            echo htmlspecialchars($contents);
         ?> 
         </textarea>
      </form>
   </div>
   
   <div class="InfoRight">
      <input type="submit" name='enter' value="Сохранить материал" form="frmTinyText">
   </div>
</div>

<div class="Footer">
   <div class="LeftFooter">
      <img id="KwinLogo" src="../Images/Kwinflat.jpg" alt="Kwinflat-близкий всем!"/>
   </div>
   <div class="RightFooter">
      Copyright &copy; Владимир Труфанов
   </div>
</div>

</body>
</html>
