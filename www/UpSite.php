<?php
// PHP7/HTML5, EDGE/CHROME                                   *** UpSite.php ***

// ****************************************************************************
// * ittve.pw            Разобрать параметры запроса и открыть страницу сайта *
// ****************************************************************************

//                                                   Автор:       Труфанов В.Е.
//                                                   Дата создания:  13.01.2019
// Copyright © 2019 tve                              Посл.изменение: 23.04.2021

// ****************************************************************************
// *            Сформировать общие начальные теги разметки страницы,          *
// *            разобрать параметры запроса и открыть страницу сайта          *
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
echo '<link rel="stylesheet" type="text/css" href="EdisiteArticle/_Edit/EdisiteArticle.css">';
// Подключаем font-awesome/4.7.0
echo '
 <link rel="stylesheet" 
   href="/font-awesome-4.7.0/css/font-awesome.min.css">
';
// Подключаем jQuery
echo '
   <script src="/Js/jquery-1.11.1.min.js"></script>
';
if ($SiteDevice==Mobile) 
{   
   echo '<title>В мобильном программировании моё увлечение!</title>';
   // Включаем набор meta-тегов для сайтов с адаптивным дизайном:
   // константой device-width задаёт ширину страницы в соответствии с размером 
   // экрана и определяем неизменный начальный масштаб страницы;
   // указываем, что страница оптимизирована под мобильные устройства на Palm 
   // и Blackberry, в таком браузере как AvantGo и других;
   // для мобильных браузеров IE Mobile или Pocket IE определяем ширина страницы
   // в соответствии с размером экрана, аналог device-width; 
   // позволяем работать в полноэкранном режиме на мобильных устройствах Apple.
   echo "
      <!-- <meta name='viewport' content='width=device-width,initial-scale=1'/> -->
      <meta name='viewport' content='width=310,initial-scale=1'/>
      <meta content='true' name='HandheldFriendly'/>
      <meta content='width' name='MobileOptimized'/>
      <meta content='yes' name='apple-mobile-web-app-capable'/>
   ";
   echo '
      <link rel="stylesheet" href="Js/jquery-ui.min.css" />
      <link rel="stylesheet" href="Js/jquery.mobile-1.4.5.min.css" />
      <link rel="stylesheet" type="text/css" href="Styles/Stylesm.css">
      <script src="/Js/jquery-ui.min.js"></script>
      <script src="/Js/jquery.mobile-1.4.5.min.js"></script>
      <script src="/Js/TJsPrown.js"></script>
      <script src="/Js/IttvePW.js"></script>
   ';
   // Подключаем скрипты по завершению загрузки страницы
   echo '<script>$(document).ready(function() 
     {
        aScreenInfo=getScreenInfo(false);  
        MakeScreenInfo(aScreenInfo);
        ApartButtons();
     });</script>';
}
else 
{   
   echo '<title>В программировании моя жизнь!</title>';
   echo '
      <link rel="stylesheet" type="text/css" href="Styles/Styles.css">
   ';
   // Подключаем smartmenus
   echo "
      <link href='sm-mint/sm-core-css.css' rel='stylesheet' type='text/css' />
      <link href='sm-mint/sm-mint.css' rel='stylesheet' type='text/css' />
      <script src='/Js/jquery.smartmenus.js' type='text/javascript'></script>
      <script type='text/javascript'> $(function() 
      {
		   $('#main-menu').smartmenus({
			   subMenusSubOffsetX: 6,
			   subMenusSubOffsetY: -8
		   });
	   });
      </script>
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
// Начинаем html-страницу
echo '</head>'; 
echo '<body>';
echo $basename.'<br>';
// При отладке воссоздаем базу данных
// require_once 'CreateBase.php';
$Menu=aViewMenu(MakeTableOfMenu($basename)); 
require_once $NamePage;
/*
// При необходимости показываем кукисы и переменные сессий
prown\ViewGlobal(avgSESSION);
prown\ViewGlobal(avgCOOKIE);
*/
// При необходимости выводим дополнительную информацию
/*
Header("Content-type: text/plain");
$headers = getallheaders();
print_r($headers);
print_r($_SERVER);
*/
// Выводим завершающие теги страницы
echo '</body>'; 
echo '</html>';

// *** <!-- --> ************************************************ UpSite.php ***
