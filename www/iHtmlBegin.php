<?php
// PHP7/HTML5, EDGE/CHROME                               *** iHtmlBegin.php ***

// ****************************************************************************
// * ittve.pw                                           Загрузить начало HTML * 
// *                              c подключением основного или мобильного CSS *
// ****************************************************************************

//                                                   Автор:       Труфанов В.Е.
//                                                   Дата создания:  05.12.2018
// Copyright © 2018 tve                              Посл.изменение: 11.12.2018

if ($SiteDevice==Mobile) 
{   
   ?>
   <!DOCTYPE html>
   <html>
   <head>
      <title>В мобильном программировании моё увлечение!</title>
      <meta charset="utf-8">
      <link href="https://fonts.googleapis.com/css?family=Anonymous+Pro:400,400i,700,700i&amp;subset=cyrillic" rel="stylesheet">
      <link rel="stylesheet" type="text/css" href="Styles/mStyles.css">
   </head>
   <body>
   <script>
      ScreenInfo33();
   </script> 
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
      <link href="https://fonts.googleapis.com/css?family=Anonymous+Pro:400,400i,700,700i&amp;subset=cyrillic" rel="stylesheet">
      <link rel="stylesheet" type="text/css" href="Styles/Styles.css">
      <!--
      <link rel="stylesheet" type="text/css" href="Styles/MenuAccord.css">
      -->
      <script src="/js/IttvePW.js"></script>
      <script> 
         TurnOnHotkeys() 
      </script>
   </head>
   <body>
   <script>
      //ScreenInfo33();
   </script> 
   <?php
}

// ********************************************************* iHtmlBegin.php ***
