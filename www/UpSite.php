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
if ($SiteDevice==Mobile) 
{   
   echo '<title>В мобильном программировании моё увлечение!</title>';
   /*
   echo '
      <link rel="stylesheet" type="text/css" href="Styles/Fontsm.css">
      <link rel="stylesheet" type="text/css" href="Styles/Buttonsm.css">
      <link rel="stylesheet" type="text/css" href="Styles/Stylesm.css">
   ';
   */
}
else 
{   
   echo '<title>В программировании моя жизнь!</title>';
   /*
   echo '
      <link rel="stylesheet" type="text/css" href="Styles/Fonts.css">
      <link rel="stylesheet" type="text/css" href="Styles/Buttons.css">
      <link rel="stylesheet" type="text/css" href="Styles/Styles.css">
   ';
   */
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

echo 'Привет Вам! <br>';


// Проверяем не требуется ли просто вывести изображение и выводим его
/*
if ($ImageFile<>NULL)
{
   require_once "ViewImage.php";
}
// Выводим другие страницы сайта
else
{
   // Выбираем страницу для отправки сообщения автору
   if (prown\isComRequest('Inbox','Com'))
   {
      //echo 'Отправить сообщение автору'.'<br>';
      $page='/DetmanPage/www/index1.php';
      Header("Location: http://".$_SERVER['HTTP_HOST'].$page);
   }
   // Выбираем страницу для изменения настроек
   else if (prown\isComRequest('Tuning','Com'))
   {
      //echo 'Изменить настройки сайта в браузере'.'<br>';
      //$page='/DownUpLoad/index_01.php';
      //$page='/DownUpLoad/ProbaTest.php';
      $page='/DetmanBase/indexBase.php';
      Header("Location: http://".$_SERVER['HTTP_HOST'].$page);
   }
   // Выбираем страницу для входа по логину или для регистрации
   else if (prown\isComRequest('Signup','Com'))
   {
      echo 'Войти или зарегистрироваться'.'<br>';
   }
   // Выбираем страницу для редактирования или создания материала
   else if (prown\isComRequest('ЕditМaterial','Com'))
   {
      require_once "EditText.php";
   }
   // Запускаем страницу с активным материалом
   else
   {
      require_once "Site.php";
   }
   // Выводим меню
   if (prown\isComRequest('LifeMenu','Com'))
   {
      //require_once "Html/iniHtmlLifeMenu.php";
      //require_once "iniHtml1.php";
      //echo 'Жизнь и путешествия!'.'<br>';
      //require_once "Nastr.php";
   }
}
*/
/*
// При необходимости показываем кукисы и переменные сессий
prown\ViewGlobal(avgSESSION);
prown\ViewGlobal(avgCOOKIE);
*/
// Выводим завершающие теги страницы
echo '</body>'; 
echo '</html>';

// <!-- --> **************************************************** UpSite.php ***
