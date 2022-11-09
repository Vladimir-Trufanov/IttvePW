<?php
// PHP7/HTML5, EDGE/CHROME                                     *** Main.php ***

// ****************************************************************************
// * ittve.pw                                   В программировании моя жизнь! *
// ****************************************************************************

//                                                   Автор:       Труфанов В.Е.
//                                                   Дата создания:  23.11.2018
// Copyright © 2018 tve                              Посл.изменение: 03.04.2022

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
require_once $TPhpTools."/TPhpTools/TBaseMaker/BaseMakerClass.php";

// Выполняем начальную инициализацию
require_once "Common.php";     // Всегда 1-ый корневой модуль в списке
require_once "iniMem.php";     // Всегда 2-ой корневой модуль в списке
require_once "iniMenu.php";   
require_once "ittvepw.php";    
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
// Уточняем раздел и редактируемую статью
$c_NameCharter=prown\MakeCookie('NameCharter','Моделирование',tStr);  
$TranslitCharter=prown\getTranslit($c_NameCharter);
$c_NameArt=prown\MakeCookie('NameCharter',
   'Особенности устройства винтиков в моей голове',tStr);
$Translit=prown\getTranslit($c_NameArt);  

/*
// Выводим меню
if (prown\isComRequest('LifeMenu','com'))
{
   //require_once "Html/iniHtmlLifeMenu.php";
   //require_once "iniHtml1.php";
   //echo 'Жизнь и путешествия!'.'<br>';
   //require_once "Nastr.php";
}
// Выбираем страницу для отправки сообщения автору
else if (prown\isComRequest('Inbox','com'))
{
   //echo 'Отправить сообщение автору'.'<br>';
   //$page='/DetmanPage/www/index1.php';
   // Header("Location: http://".$_SERVER['HTTP_HOST'].$page);
}
// Выбираем страницу для редактирования или создания материала
else if (prown\isComRequest('redaktirovat-material','com'))
{
   $NamePage="EdisiteArticle/_Edit/EdisiteArticle.php";
}
// Запускаем страницу с активным материалом
else
{
   $TitleMain='Основная тема страницыeeee';
   if ($SiteDevice==Mobile) $NamePage='Sitem.php';
   else $NamePage='Site.php';
}
*/
require_once "UpSite.php";

/**
 * Сайт работает следующим образом:
 * 
 * Контекст всех статей строится только на CSS и HTML5 ("желательно").
 * 
 * Сайт (и соответственно разметка) может работать в нескольких режимах: 
 *    rzmMain=1, когда на экране представлена статья и программный код;
 *    (rzmCompare=2, когда вместе со статьей представляются коды в сравнении 
 * нескольких систем программирования;) 04/04/2022 - до новой идеи исключено
 *    rzmWithLeft=4, когда к статьям добавляется левая колонка (режимы 5 или 6) 
 *    с развлекательным текстом (либо "умные мысли", либо что-то другое).
 * 
 * Имя загружаемого файла страницы всегда интерпретируется, как заголовок 
 * страницы. С этим именем файл хранится и во время редактирования в
 * каталоге EdisiteArticle/_Current. В базу данных и хранилище наиболее 
 * популярных статей записывается транслитированным именем.
 * 
 * Разметка сайта разная для настольной версии и для мобильной. Настройка 
 * изображений и форматирование текстов ведется через CSS.
 * 
 * При запросе любой страницы сайта с контентом присутствует параметр "Com",
 * например: https://ittve.pw?Com=About
 * 
 * в запросе начальной страницы сайта параметры отсутствуют:   https://ittve.pw
 * 
 * Главное меню горит всегда малозаметно наверху. Подвал стилизован с верхом.
 * Текст меню формируется после изменения статей в базе данных и сохраняется в 
 * PHP-файле.
 * 
 * В начальном варианте статьи хранятся в "образах базы данных" на диске
 * (на сайте) в каталоге EdisiteArticle по следующему образцу:
 * 
 * itpw002005-pogoda-20220403.php
 * itpw006007-s-chego-vse-nachalos-20210501.php,
 * 
 * где itpw-признак принадлежности к сайту ittve.pw, далее uid раздела сайта
 * (максимум 999), далее uid статьи (максимум 999), далее через дефис транслит 
 * статьи, далее через дефис дата создания статьи
 * 
 * Аналогично именуются фотографии к статьям, которые находятся в общем 
 * каталоге для всех сайтов - IttveIMG, в подкаталоге для сайта itpw.
**/
// *************************************************************** Main.php ***
