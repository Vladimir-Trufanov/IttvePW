<?php

// PHP7/HTML5, EDGE/CHROME                                *** deleteImg.php ***

// ****************************************************************************
// * TKwinGallery                     Удалить выбранное изображение c данными *
// *                  из базы данных по указанному идентификатору и транслиту *    
// *                                                                          *
// * v1.0, 17.02.2023                               Автор:      Труфанов В.Е. *
// * Copyright © 2022 tve                           Дата создания: 17.02.2023 *
// ****************************************************************************

// Готовим начальные значения параметров возвращаемого сообщения
$NameArt='NoDefineIMG'; $Piati=0; $iif='NoDefine';
// Извлекаем пути к библиотекам прикладных функций и классов
define ("pathPhpPrown",$_POST['pathPrown']);
define ("pathPhpTools",$_POST['pathTools']);

// Для взаимодействия с объектами класса определяем константы:
define("articleSite",'IttveMe');  // тип базы данных (по сайту)
define("editdir",'ittveEdit');    // каталог размещения файлов, относительно корневого
define("stylesdir",'Styles');     // каталог стилей элементов разметки и фонтов
define("imgdir",'Images');        // каталог файлов служебных для сайта изображений
define("jsxdir",'Jsx');           // файлы javascript

// Подгружаем нужные модули библиотек
require_once pathPhpPrown."/CommonPrown.php";
require_once pathPhpTools."/TNotice/NoticeClass.php";
require_once pathPhpTools."/TArticlesMaker/ArticlesMakerClass.php";
// Подключаем объект единообразного вывода сообщений
$note=new ttools\Notice();
// Создаем объект для работы с базой данных материалов
$basename=$_SERVER['DOCUMENT_ROOT'].'/ittve'; $username='tve'; $password='23ety17'; 
$Arti=new ttools\ArticlesMaker($basename,$username,$password,$note);
$pdo=$Arti->BaseConnect();
// Определяем ключи поиска
$uid=$_POST['uid'];
$TranslitPic=$_POST['translitpic'];
// Выбираем сведения об изображении по ключам       
$table=$Arti->SelImgPic($pdo,$uid,$TranslitPic);
// Если ошибка выборки, то возвращаем сообщение
if ($table["TranslitPic"]==Err)
{
   $NameArt=$table["Pic"];
   $iif=$table["TranslitPic"];
}
// Если по ключу ничего не  найдено, то возвращаем сообщение
else if ($table["TranslitPic"]==NULL)
{
   $NameArt='Изображение не удалось выбрать!';
   $iif=Err;
}
else 
{
   // Удаляем запись об изображении
   $messa=$Arti->DelImgRecord($pdo,$uid,$TranslitPic);
   // Если удаление с ошибкой, то готовим сообщение
   if ($messa<>imok)
   {
      $NameArt=addslashes($messa);
      $iif=Err;
   } 
   else $iif=imok;
}
// Возвращаем сообщение
$message='{"NameArt":"'.$NameArt.'", "Piati":'.$Piati.', "iif":"'.$iif.'"}';
$message=\prown\makeLabel($message,'ghjun5','ghjun5');
echo $message;
exit;

// ********************************************************** deleteImg.php ***
