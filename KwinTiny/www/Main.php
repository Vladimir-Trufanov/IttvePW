<?php
// PHP7/HTML5, EDGE/CHROME                                     *** Main.php ***

// ****************************************************************************
// *                                            KwinTiny-редактор материалов! *
// ****************************************************************************

//                                                   Автор:       Труфанов В.Е.
//                                                   Дата создания:  23.11.2018
// Copyright © 2018 tve                              Посл.изменение: 10.02.2023

// ------------------------------------------------------------------- ZERO ---
// Указываем место размещения библиотеки прикладных функций TPhpPrown
define ("pathPhpPrown",$SiteHost.'/TPhpPrown/TPhpPrown');
// Указываем место размещения библиотеки прикладных классов TPhpTools
define ("pathPhpTools",$SiteHost.'/TPhpTools/TPhpTools');
// Указываем тип базы данных (по сайту) для управления классом ArticlesMaker   
define ("articleSite",'IttveMe'); 
// Указываем каталоги размещения файлов
define("editdir",'ittveEdit');  // файлы, связанные c материалом
define("stylesdir",'Styles');   // стили элементов разметки и фонты
define("jsxdir",'Jsx');         // файлы javascript
define("imgdir",'Images');      // файлы служебных для сайта изображений
// Указываем префикс имен файлов для фотографий галереи и материалов
define('nym','ittve');
// Инициализируем общесайтовые переменные
$UserName="tve";                   // Логин посетителя для авторизации
$ModeError=2;                      // Режим вывода сообщений об ошибках
// Подключаем файлы библиотеки прикладных модулей:
require_once pathPhpPrown."/ViewGlobal.php";
require_once pathPhpPrown."/CommonPrown.php";
require_once pathPhpPrown."/getTranslit.php";
require_once pathPhpPrown."/iniConstMem.php";

// Подгружаем нужные модули библиотеки прикладных классов
require_once pathPhpTools."/TArticlesMaker/ArticlesMakerClass.php";
require_once pathPhpTools."/TKwinGallery/KwinGalleryClass.php";
require_once pathPhpTools."/TTinyGallery/TinyGalleryClass.php";
require_once pathPhpTools."/TNotice/NoticeClass.php";

// Подключаем межязыковые (PHP-JScript) определения внутри HTML
//require_once pathPhpTools."/TTinyGallery/WorkTinyDef.php";
//DefinePHPtoJS();

// Подключаем объект единообразного вывода сообщений
$note=new ttools\Notice();
// Подключаем объект для работы с базой данных материалов
// (при необходимости создаем базу данных материалов)
$basename=$_SERVER['DOCUMENT_ROOT'].'/ittve'; $username='tve'; $password='23ety17'; 
$Arti=new ttools\ArticlesMaker($basename,$username,$password,$note);
if (!file_exists($basename.'.db3')) $Arti->BaseFirstCreate();
$Arti->setKindMessage($note);
// Подключаем объект по редактированию материала - для работы в галерее 
// и рабочей области редактирования (в том числе создаем объект для управления
// изображениями в галерее, связанной с материалом сайта из базы данных)
$WorkTinyHeight='75'; $FooterTinyHeight='15'; $KwinGalleryWidth='30'; $EdIzm='%';
$Edit=new ttools\TinyGallery($SiteRoot,$urlHome,
      $WorkTinyHeight,$FooterTinyHeight,$KwinGalleryWidth,$EdIzm,$Arti);
// ---------------------------------------------------------- HEAD and LAST ---
echo '
   <!DOCTYPE html>
   <html lang="ru">
   <head>
   <title>KwinTiny-редактор материалов!</title>
   <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
   <meta name="description" content="Труфанов Владимир Евгеньевич, редактор материалов TinyMCE">
   <meta name="keywords" content="Труфанов Владимир Евгеньевич,KwinTiny,TinyMCE,редактор материалов">
';
// Подключаем шрифты и стили документа
echo '
   <link rel="stylesheet"
      href="https://fonts.googleapis.com/css?family=Anonymous+Pro:400,400i,700,700i&amp;
      subset=cyrillic">
   <link rel="stylesheet" 
      href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
   <link rel="stylesheet" type="text/css" href="/Styles/Styles.css">
   <link rel="stylesheet" type="text/css" href="/jQuery/jquery-ui.min.css">
';
// Подключаем js скрипты 
?> 
   <script src="/jQuery/jquery-3.6.3.min.js"></script>
   <script src="/jQuery/jquery-ui.min.js"></script>
<?php






// Подключаем стили для редактирования материалов
$Edit->IniEditSpace();
$note->Init();
$Arti->Head();
echo '</head>'; 
// ------------------------------------------------------------------- BODY ---
echo '<body>'; 
echo '<div id="Info">'; 
// Разворачиваем область для редактирования материала
$Edit->OpenEditSpace();
// prown\ViewGlobal(avgCOOKIE);
// echo '<img src="data:image/jpeg;base64,'.base64_encode(file_get_contents("test.jpg")).'"/>';
// Помещаем значение переменной в область редактирования TinyMCE
echo '</div>';

echo '<div id="Niz">'; 
if (prown\isComRequest(mmlVernutsyaNaGlavnuyu))
{
   echo '<pre>';
   echo prown\getTranslit('Подъём настроения').'<br>';
   //print_r($_FILES);
   echo '</pre>';
}
echo '</div>';
// Трассируем страницы
if (prown\isComRequest(mmlVernutsyaNaGlavnuyu)) prown\ConsoleLog('Вернулись на главную страницу');
echo '</body></html>';
// -------------------------------------------------------------------- OUT ---
// *** <!-- --> ************************************************** Main.php ***
