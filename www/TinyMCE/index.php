<!DOCTYPE html> 
<!-- 
-->
<html>

<head>
   <meta http-equiv="content-type" content="text/html; charset=utf-8" />
   <title>KwinFlat-редактор текстов!</title>
   <link rel="stylesheet" type="text/css" href="Allcss/Reset.css" />
   <script src="/TinyMCE/tinymce.min.js"></script>
   <script>tinymce.init
    ({
        selector: '#mytextarea',
        theme: 'modern',
        width:  860,
        height: 300,
        plugins:
        [ 
            'advlist autolink link image imagetools lists charmap print preview hr anchor',
            'pagebreak spellchecker searchreplace wordcount visualblocks',
            'visualchars code fullscreen insertdatetime media nonbreaking',
            'save table contextmenu directionality emoticons template paste',
            'textcolor'
        ],
        content_css: '/TinyMCE/TinyMCE.css',
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

<header>
    <div class="header-bg">
    <img src="../Images/Kwinflat.jpg" alt="Kwinflat-близкий всем!" />
    </div>
</header>

<article>
   <?php
      // advlist - списки
      // <textarea id="mytextarea" name="dor">qwerty</textarea>
      // <form id="frmTinyText" method="get" action="/TinyMCE/TinyText.php">
   ?>
   
   
   <form id="frmTinyText" method="post" action="/TinyMCE/TinyText.php">
      <textarea id="mytextarea" name="dor">qwertyi</textarea>
   </form>
   <input type="submit" name='enter' value="ssave" form="frmTinyText">
</article>

<footer>
    Copyright &copy; Владимир Труфанов
</footer>

</body>
</html>
