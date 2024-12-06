<?php

// PHP7/HTML5, EDGE/CHROME                                *** deleteArt.php ***

// ****************************************************************************
// * TArticleMaker     По указанному идентификатору в аякс-запросе определить *
// *            наименование материала, а затем удалить запись из базы данных *
// *                                                                          *
// * v1.0, 27.01.2023                              Автор:       Труфанов В.Е. *
// * Copyright © 2022 tve                          Дата создания:  13.11.2022 *
// ****************************************************************************

// Готовим начальные значения параметров возвращаемого сообщения
$NameArt='NoDefineART'; $Piati=0; $iif='NoDefine';
// Извлекаем пути к библиотекам прикладных функций и классов
define ("pathPhpPrown",$_POST['pathPrown']);
define ("pathPhpTools",$_POST['pathTools']);

// Для взаимодействия с объектами класса определяем константы:
define("articleSite",'IttveMe');  // тип базы данных (по сайту)
define("editdir",'ittveEdit');    // каталог размещения файлов, относительно корневого
define("stylesdir",'Styles');     // каталог стилей элементов разметки и фонтов
define("imgdir",'Images');        // каталог файлов служебных для сайта изображений

// Подгружаем нужные модули библиотек
require_once pathPhpTools."/TArticlesMaker/ArticlesMakerClass.php";
require_once pathPhpPrown."/CommonPrown.php";
// Подключаем объект для работы с базой данных материалов
// (при необходимости создаем базу данных материалов)
$basename=$_SERVER['DOCUMENT_ROOT'].'/ittve'; $username='tve'; $password='23ety17'; 
$note=NULL;
$Arti=new ttools\ArticlesMaker($basename,$username,$password,$note);
$pdo=$Arti->BaseConnect();
// Выбираем запись по идентификатору группы материалов
$table=$Arti->SelRecord($pdo,$_POST['idCue']); 
// Определяем количество найденных записей
$count=count($table);

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
// Освобождаем память
unset($Arti); unset($pdo); unset($table);
// Возвращаем сообщение
$message='{"NameArt":"'.$NameArt.'", "Piati":'.$Piati.', "iif":"'.$iif.'"}';
$message=\prown\makeLabel($message,'ghjun5','ghjun5');
echo $message;
exit;

// ********************************************************** deleteArt.php ***
