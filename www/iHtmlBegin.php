<?php
// PHP7/HTML5, EDGE/CHROME                               *** iHtmlBegin.php ***

// ****************************************************************************
// * ittve.pw                                           Загрузить начало HTML * 
// *                              c подключением основного или мобильного CSS *
// ****************************************************************************

//                                                   Автор:       Труфанов В.Е.
//                                                   Дата создания:  05.12.2018
// Copyright © 2018 tve                              Посл.изменение: 11.12.2018


if ($MobileDevice=='MobileDevice') 
{   
   ?>
   <!DOCTYPE html>
   <html>
   <head>
      <title>В мобильном программировании моё увлечение!</title>
      <meta charset="utf-8">
      <link rel="stylesheet" type="text/css" href="aMobilecss/mStyles.css">
   </head>
   <body>
   <?php
}
else 
{   
   ?>
   <!DOCTYPE html>
   <html>
   <head>
      <title>В программировании моя жизнь!</title>
      <meta charset="utf-8">
      <link rel="stylesheet" type="text/css" href="aComputercss/Styles.css">
      <script src="/js/IttvePW.js"></script>
      <script> TurnOnHotkeys() </script>
   </head>
   <body>
   <?php
}

// ********************************************************* iHtmlBegin.php ***
