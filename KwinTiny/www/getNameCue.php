<?php

// PHP7/HTML5, EDGE/CHROME                               *** getNameCue.php ***

// ****************************************************************************
// * TArticleMaker       По указанному идентификатору в аякс-запросе вытащить *
// *                         данные о группе материалов и вернуть на страницу *
// *                                                                          *
// * v1.0, 04.02.2023                              Автор:       Труфанов В.Е. *
// * Copyright © 2022 tve                          Дата создания:  13.11.2022 *
// ****************************************************************************

// Указываем тип базы данных (по сайту) для управления классом ArticlesMaker   
define ("articleSite",'IttveMe'); 
// Указываем каталог размещения файлов, связанных c материалом
define("editdir",'ittveEdit');

// Готовим начальные значения параметров возвращаемого сообщения
$NameGru='NoDefine'; $Piati=0; $iif='NoDefine';
// Извлекаем пути к библиотекам прикладных функций и классов
define ("pathPhpPrown",$_POST['pathPrown']);
define ("pathPhpTools",$_POST['pathTools']);
// Подгружаем нужные модули библиотек
require_once pathPhpTools."/TArticlesMaker/ArticlesMakerClass.php";
require_once pathPhpPrown."/CommonPrown.php";
// Подключаем объект для работы с базой данных материалов
// (при необходимости создаем базу данных материалов)
$NameGru='Группа материалов';
$basename=$_SERVER['DOCUMENT_ROOT'].'/ittve'; $username='tve'; $password='23ety17'; 
$Arti=new ttools\ArticlesMaker($basename,$username,$password);
$pdo=$Arti->BaseConnect();
// Выбираем запись по идентификатору группы материалов
$table=$Arti->SelRecord($pdo,$_POST['idCue']); 
// Выделяем из записи элементы
$NameGru=$table[0]['NameArt'];
// Освобождаем память
unset($Arti); unset($pdo); unset($table);
// Возвращаем сообщение
$message='{"NameGru":"'.$NameGru.'", "Piati":'.$Piati.', "iif":"'.$iif.'"}';
$message=\prown\makeLabel($message,'ghjun5','ghjun5');
echo $message;
exit;

// ********************************************************* getNameCue.php ***
