<?php
// PHP7/HTML5, EDGE/CHROME                                     *** Main.php ***

// ****************************************************************************
// * ittve.pw                                   В программировании моя жизнь! *
// ****************************************************************************

//                                                   Автор:       Труфанов В.Е.
//                                                   Дата создания:  23.11.2018
// Copyright © 2018 tve                              Посл.изменение: 20.04.2021

session_start(); 

// Подключаем файлы библиотеки прикладных модулей:
$TPhpPrown=$SiteHost.'/TPhpPrown';
require_once $TPhpPrown."/TPhpPrown/getTranslit.php";
require_once $TPhpPrown."/TPhpPrown/isCalcInBrowser.php";
require_once $TPhpPrown."/TPhpPrown/MakeCookie.php";
require_once $TPhpPrown."/TPhpPrown/MakeSession.php";
require_once $TPhpPrown."/TPhpPrown/MakeUserError.php";
require_once $TPhpPrown."/TPhpPrown/ViewGlobal.php";

// Подключаем файлы библиотеки прикладных классов:
$TPhpTools=$SiteHost.'/TPhpTools';
//require_once $TPhpTools."/TPhpTools/TDownloadFromServer/DownloadFromServerClass.php";
//require_once $TPhpTools."/TPhpTools/TUploadToServer/UploadToServerClass.php";
//require_once $TPhpTools."/TPhpTools/TBaseMaker/BaseMakerClass.php";

// Выполняем начальную инициализацию
require_once "Common.php";     // Всегда 1-ый корневой модуль в списке
require_once "iniMem.php";     // Всегда 2-ой корневой модуль в списке
// require_once "DebugNews.php";

// Изменяем счетчик запросов сайта из браузера и, таким образом,       
// регистрируем новую загрузку страницы
$c_BrowEntry=prown\MakeCookie('BrowEntry',$c_BrowEntry+1,tInt);  
// Изменяем счетчик посещений текущим посетителем      
$c_PersEntry=prown\MakeCookie('PersEntry',$c_PersEntry+1,tInt);
// Изменяем счетчик посещений за сессию                 
$s_Counter=prown\MakeSession('Counter',$s_Counter+1,tInt);   
// echo "Вы обновили эту страницу ".$_SESSION['Counter']." раз. ";
// echo "<br><a href=".$_SERVER['PHP_SELF'].">обновить"; 
// Если после авторизации изменилось имя пользователя,
// то перенастраиваем счетчики и посетителя
if ($c_PersName<>$c_UserName)
{
   $c_PersEntry=prown\MakeCookie('PersEntry',1,tInt);
   $s_Counter=prown\MakeSession('Counter',1,tInt); 
   $c_PersName=prown\MakeCookie('PersName',$c_UserName,tStr);
}

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

require_once "UpSite.php";
   
// При необходимости выводим дополнительную информацию
/*
Header("Content-type: text/plain");
$headers = getallheaders();
print_r($headers);
print_r($_SERVER);
*/

/**
 * Сайт работает следующим образом:
 * 
 * Первая версия сайта строится только на CSS для HTML5.
 * 
 * Сайт (и соответственно разметка) может работать в нескольких режимах: 
 *    rzmMain=1, когда на экране представлена статья и программный код;
 *    rzmCompare=2, когда вместе со статьей представляются коды в сравнении 
 * нескольких систем программирования;
 *    rzmWithLeft=4, когда к статьям добавляется левая колонка (режимы 5 или 6) 
 *    с развлекательным текстом (либо "умные мысли", либо что-то другое).
 *    
 * Разметка сайта единая и для настольной версии, и для мобильной. Настройка 
 * изображений и форматирование текстов ведется через CSS.
 * 
 * При запросе любой страницы сайта с контентом присутствует параметр "Com",
 * например: https://ittve.pw/?Com=About
 * 
 * в запросе начальной страницы сайта параметры отсутствуют:   https://ittve.me
 * 
 * ---Два рабочих каталога используются для контента:
 * ---    ittveLife - каталог (совместно с базой статей) архивных изображений;
 * ---    ittveNews - каталог редактируемой статьи и её изображений.
 *     
 * Главное меню горит всегда малозаметно наверху. Подвал стилизован с верхом.
 * 
**/
// *************************************************************** Main.php ***
