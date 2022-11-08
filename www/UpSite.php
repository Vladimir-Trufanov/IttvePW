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
// При отладке воссоздаем базу данных
// require_once 'MakeItBase.php';
echo '1------------------------------------------------<br>'; 
$Menu=aViewMenu(MakeTableOfMenu($basename));
echo '2------------------------------------------------<br>'; 

//$Menu=aViewMenu(MakeTableOfMenu($basename)); 
echo  $Menu;
//echo '$NamePage='.$NamePage;
//require_once $NamePage;
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


// ****************************************************************************
// *                 Выполнить GET-запрос данных с GisMeteo                   *
// ****************************************************************************

// Указываем координаты дачи в Лососинном
$dacha='latitude=61.701941&longitude=34.154539'; // 61.701941,34.154539
$icon='icon=n_c3_rs3_st';
// Назначаем URL о погоде по координатам
$url = 'https://api.gismeteo.net/v2/weather/current/?'.$icon; //$dacha;
// Указываем заголовок с моим токеном
$headers = ['X-Gismeteo-Token: 61f2622da85fe2.06084651']; 
// Назначаем поля нашего запроса и переводим их в формат JSON
$post_data = ['field1'=>'val_1','field2'=>'val_2',];
//$post_data = [];
$data_json = json_encode($post_data);
// Инициируем новый сеанс cURL и возвращаем дескриптор
$curl = curl_init();
// Загружаем URL
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl, CURLOPT_VERBOSE, 1);
curl_setopt($curl, CURLOPT_POSTFIELDS, $data_json);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
$result = curl_exec($curl); // результат POST запроса
if (curl_error($curl)) echo 'Ошибка запроса о погоде: '.curl_error($curl).'<br>';
else echo 'Данные о погоде: '.$result.'<br>';
 
// ****************************************************************************


/*
// ****************************************************************************
// *                Выполнить GET-запрос данных с Яндекс-Погоды               *
// ****************************************************************************
// Указываем координаты дачи в Лососинном
$dacha='lat=61.701941&lon=34.154539'; // 61.701941,34.154539
// Назначаем URL о погоде по координатам
$url = 'https://api.weather.yandex.ru/v2/informers?'.$dacha;

// https://api.weather.yandex.ru/v2/informers?lat=55.75396&lon=37.620393

// Указываем заголовок с моим токеном
$headers = ['X-Yandex-API-Key: 71dbce1b-477f-4dff-8aa1-45924134f92d']; 
// Назначаем поля нашего запроса и переводим их в формат JSON
//$post_data = ['field1'=>'val_1','field2'=>'val_2',];
$post_data = [];
$data_json = json_encode($post_data);
// Инициируем новый сеанс cURL и возвращаем дескриптор
$curl = curl_init();
// Загружаем URL
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl, CURLOPT_VERBOSE, 1);
curl_setopt($curl, CURLOPT_POSTFIELDS, $data_json);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
$result = curl_exec($curl); // результат POST запроса
if (curl_error($curl)) echo 'Ошибка запроса о погоде: '.curl_error($curl).'<br>';
else echo 'Данные о погоде: '.$result.'<br>';
// ****************************************************************************
*/

/*
// ****************************************************************************
// *                Выполнить GET-запрос данных с openweathermap.org               *
// ****************************************************************************
// Указываем координаты дачи в Лососинном
$dacha='lat=61.701941&lon=34.154539'; // 61.701941,34.154539
// Указываем API-key
$appid='080b7a11c05216a4b86317b92370b484';
// Назначаем URL о погоде по координатам
$url = 'https://api.openweathermap.org/data/2.5/weather?'.$dacha.'&appid='.$appid;

$headers = []; $post_data = []; $data_json = json_encode($post_data);
// Инициируем новый сеанс cURL и возвращаем дескриптор
$curl = curl_init();
// Загружаем URL
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl, CURLOPT_VERBOSE, 1);
curl_setopt($curl, CURLOPT_POSTFIELDS, $data_json);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
$result = curl_exec($curl); // результат POST запроса
if (curl_error($curl)) echo 'Ошибка запроса о погоде: '.curl_error($curl).'<br>';
else echo 'Данные о погоде: '.$result.'<br>';
// ****************************************************************************
*/




//print_r('response: '.$result.'<br>');
//phpinfo();
// Выводим завершающие теги страницы
echo '</body>'; 
echo '</html>';

// *** <!-- --> ************************************************ UpSite.php ***
