<?php

// PHP7/HTML5, EDGE/CHROME                                *** SaveStuff.php ***

// ****************************************************************************
// * TKwinGallery                       По переданному фрагменту кода галереи *
// *                 текущей статьи перенести файлы изображений в базу данных *
// *                                                                          *
// * v1.0, 03.02.2023                              Автор:       Труфанов В.Е. *
// * Copyright © 2022 tve                          Дата создания:  13.11.2022 *
// ****************************************************************************

// Выбираем массив файлов галереи для записи в базу данных 
$GalleryText=$_POST['area'];

// Формат галереи на 02.02.2023: 
//
// <div class="Card">
// <button class="bCard" type="submit" name="Image">
//    <img class="imgCard" src="ittveEdit/ittve2-3-Подъём-настроения.jpg">
// </button>
// <p class="pCard">Ночная прогулка по Ладоге до рассвета и подъёма настроения.</p>
// </div>
//
// <div class="Card">
// <form method="get" enctype="multipart/form-data">
//    <input type="hidden" name="MAX_FILE_SIZE" id="inhCard" value="1600000">
//    <input type="file" name="IMG" id="infCard" accept="image/jpeg,image/png,image/gif" onchange="readFile(this);">
//    <img id="imgCardi" src="ittveEdit/sampo.jpg" alt="FileName">
//    <textarea class="taCard" name="AREAM">Текст комментария</textarea>
//    <input type="submit" name="SUBMI" id="insCard" value="Загрузить">
// </form>
// </div>
//
// <div class="Card">
// <button class="bCard" type="submit" name="Image">
//    <img class="imgCard" src="ittveEdit/ittve2-3-На-Сампо.jpg">
// </button>
// <p class="pCard">На горе Сампо всем хорошо!</p>
// </div>
//
// <div class="Card">
// <button class="bCard" type="submit" name="Image">
//    <img class="imgCard" src="ittveEdit/ittve2-3-С-заботой-и-к-мамам.jpg">
// </button>
// <p class="pCard">'С заботой и к мамам' - такой мамочкин хвостик.</p>
// </div> 
//
// <script> ...

// Указываем тип базы данных (по сайту) для управления классом ArticlesMaker   
//define ("articleSite",'IttveMe'); 
// Указываем каталог размещения файлов, связанных c материалом
//define("editdir",'ittveEdit');

// Готовим начальные значения параметров возвращаемого сообщения
$NameArt='NoDefine'; $Piati=0; $iif='NoDefine';
// Извлекаем пути к библиотекам прикладных функций и классов
define ("pathPhpPrown",$_POST['pathPrown']);
define ("pathPhpTools",$_POST['pathTools']);
// Подгружаем нужные модули библиотек
//require_once pathPhpTools."/TArticlesMaker/ArticlesMakerClass.php";
require_once pathPhpPrown."/CommonPrown.php";
require_once pathPhpTools."/CommonTools.php";

// Выбираем загруженные изображения в массив
$nym=$_POST['nym']; // 'ittve' - префикс имен файлов для фотографий галереи и материалов
$pid=$_POST['pid']; // 2 - идентификатор текущей группы статей
$uid=$_POST['uid']; // 25 - идентификатор текущей статьи 
$aImgLoad=getImgLoad($GalleryText,$nym,$pid,$uid);
// Выбираем введенные комментарии в массив
$aComLoad=getComLoad($GalleryText);
 
$NameArt='Галерея записана!';
$Piati=0; //count($matches);

// Подключаем объект для работы с базой данных материалов
// (при необходимости создаем базу данных материалов)
$basename=$_SERVER['DOCUMENT_ROOT'].'/ittve'; $username='tve'; $password='23ety17'; 
$Arti=new ttools\ArticlesMaker($basename,$username,$password);
$pdo=$Arti->BaseConnect();
// Выбираем запись по идентификатору группы материалов
//$table=$Arti->SelRecord($pdo,$_POST['idCue']); 
// Определяем количество найденных записей
//$count=count($table);
/*
// Если записей не найдено, то готовим сообщение
if ($count<1) $NameArt=gncNoCue;
// Иначе готовим удаление записи
else
{
   // Формируем сообщение удачного удаления
   $NameArt='Удаляется статья. '.$table[0]['NameArt'].'.';
   // Удаляем запись
   $messa=$Arti->DelRecord($pdo,$_POST['idCue']);
   // Если удаление с ошибкой, то готовим сообщение
   if ($messa<>imok) $NameArt='Ошибка. '.$messa;
}
*/
// Освобождаем память
//unset($Arti); unset($pdo); unset($table);
// Возвращаем сообщение
$message='{"NameArt":"'.$NameArt.'", "Piati":'.$Piati.', "iif":"'.$iif.'"}';
$message=\prown\makeLabel($message,'ghjun5','ghjun5');

/*
\ttools\PutString(
    '$GalleryText='.$GalleryText.
    '  pathPhpPrown='.$_POST['pathPrown'].
    '  pathPhpTools='.$_POST['pathTools'],'proba.txt');
*/
echo $message;
exit;

// ****************************************************************************
// *                 Выбрать загруженные изображения в массив                 *
// ****************************************************************************
function getImgLoad($GalleryText,$nym,$pid,$uid)
{
   $aImgLoad=array();
   // Формируем префикс для поиска
   $pref=$nym.$pid.'-'.$uid.'-'; $point=strlen($pref);
   \ttools\PutString('$pref='.$pref);
   $pattern='/'.$pref.'([0-9a-zA-Zа-яёА-ЯЁ\.-]+)(jpg|png|jpeg|gif)/u';
   preg_match_all($pattern,$GalleryText,$matches,PREG_SET_ORDER);
   foreach ($matches as $val) 
   {
      $FileName=substr($val[0],$point);
      \ttools\PutString('$FileName='.$FileName);
   }
}

// ****************************************************************************
// *                 Выбрать загруженные комментарии в массив                 *
// ****************************************************************************
function getComLoad($GalleryText)
{
   // '<p class="pCard">На горе Сампо всем хорошо!</p>'
   $aComLoad=array();
   $pattern ="/pCard(.*?)\<\/p/u"; $point=7; 
   preg_match_all($pattern,$GalleryText,$matches,PREG_SET_ORDER);
   foreach ($matches as $val) 
   {
      $Comment=substr($val[0],$point);
      $Comment=substr($Comment,0,strlen($Comment)-3);
      \ttools\PutString('$Comment='.$Comment);
   }
}
// ********************************************************** SaveStuff.php ***
