<?php
// PHP7/HTML5, EDGE/CHROME                                   *** UpSite.php ***

// ****************************************************************************
// * ittve.pw            Разобрать параметры запроса и открыть страницу сайта *
// ****************************************************************************

//                                                   Автор:       Труфанов В.Е.
//                                                   Дата создания:  13.01.2019
// Copyright © 2019 tve                              Посл.изменение: 20.04.2021

// ****************************************************************************
// *              Формируем общие начальные теги разметки страницы,           *
// *           разбираем параметры запроса и открываем страницу сайта         *
// ****************************************************************************
echo '<!DOCTYPE html>';
echo '<html lang="ru">';
echo '<head>';
echo '<meta http-equiv="content-type" content="text/html; charset=utf-8"/>';
// SeoTags()
echo '<meta name="description" content="Труфанов Владимир Евгеньевич, его жизнь и жизнь его близких">';
echo '<meta name="keywords" content="Труфанов Владимир Евгеньевич, жизнь и увлечения">';
// Выводим данные о favicon
echo '
<link rel="manifest" href="manifest.json">
<link rel="apple-touch-icon" sizes="180x180" href="/favicon260x260/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="/favicon260x260/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="/favicon260x260/favicon-16x16.png">
<link rel="mask-icon" href="/favicon260x260/safari-pinned-tab.svg" color="#5bbad5">
<link rel="shortcut icon" href="/favicon260x260/favicon.ico">
<meta name="msapplication-TileColor" content="#da532c">
<meta name="msapplication-config" content="/favicon260x260/browserconfig.xml">
<meta name="theme-color" content="#ffffff">
';
// Подключаем стили
echo '
   <link rel="stylesheet" 
      href="https://fonts.googleapis.com/css?family=Anonymous+Pro:400,400i,700,700i&amp;subset=cyrillic"> 
   <link rel="stylesheet" type="text/css" href="Styles/Reset.css">
';
// Подключаем font-awesome/4.7.0
echo '
 <link rel="stylesheet" 
   href="https://kwinflat.ru/font-awesome-4.7.0/css/font-awesome.min.css">
';
// Подключаем jQuery
echo '
   <script src="/Js/jquery.js" type="text/javascript"></script>
   <script src="/Js/jquery.smartmenus.js" type="text/javascript"></script>
   <script type="text/javascript"> $(function() 
   {
		$("#main-menu").smartmenus({
			subMenusSubOffsetX: 6,
			subMenusSubOffsetY: -8
		});
	});
</script>
';
if ($SiteDevice==Mobile) 
{   
   echo '<title>В мобильном программировании моё увлечение!</title>';
   echo '
      <link rel="stylesheet" type="text/css" href="Styles/Stylesm.css">
      <!-- 
      <link rel="stylesheet" type="text/css" href="Styles/Buttonsm.css">
      -->
   ';
}
else 
{   
   echo '<title>В программировании моя жизнь!</title>';
   echo '
      <link rel="stylesheet" type="text/css" href="Styles/Styles.css">
      <!-- 
      <link rel="stylesheet" type="text/css" href="Styles/Buttons.css">
      -->
   ';
   // Подключаем smartmenus
   echo "
      <link href='sm-mint/sm-core-css.css' rel='stylesheet' type='text/css' />
      <link href='sm-mint/sm-mint.css' rel='stylesheet' type='text/css' />
      <style type='text/css'> @media (min-width: 768px) 
      {#main-menu > li 
         {
			   float: none;
			   display: table-cell;
			   width: 1%;
			   text-align: center;
		   }
	   }
      </style>
   ";
}

//require_once "iJsJquery.php";
 
// Начинаем html-страницу
echo '</head>'; 
echo '<body>'; 

?>
   <script>
      //ScreenInfo33();
   </script> 
<?php

require_once 'Site.php';
//echo 'Привет Вам! <br>';

/*
// При необходимости показываем кукисы и переменные сессий
prown\ViewGlobal(avgSESSION);
prown\ViewGlobal(avgCOOKIE);
*/
// Выводим завершающие теги страницы
echo '</body>'; 
echo '</html>';

// *** <!-- --> ************************************************ UpSite.php ***
