<?php

// PHP7/HTML5, EDGE/CHROME                                 *** TestBase.php ***

// ****************************************************************************
// * TArticleMaker      Проверить целостность базы данных по десяти очередным *
// *   записям. Если при проверке текущих 10 записей нет ни одной, то выбирем все
         // uid и находим (принимаем, какая будет) следующую запись
         

// *                                                                          *
// * v1.0, 06.02.2023                              Автор:       Труфанов В.Е. *
// * Copyright © 2022 tve                          Дата создания:  04.02.2023 *
// ****************************************************************************

// Указываем тип базы данных (по сайту) для управления классом ArticlesMaker   
// define ("articleSite",'IttveMe'); 
// Указываем каталог размещения файлов, связанных c материалом
// define("editdir",'ittveEdit');

// Готовим начальные значения параметров возвращаемого сообщения
$messa='NoDefine'; $TestPoint=$_POST['TestPoint']; $error=false;
// Извлекаем пути к библиотекам прикладных функций и классов
define ("pathPhpPrown",$_POST['pathPrown']);
define ("pathPhpTools",$_POST['pathTools']);
// Подгружаем нужные модули библиотек
require_once pathPhpTools."/TArticlesMaker/ArticlesMakerClass.php";
require_once pathPhpPrown."/CommonPrown.php";
require_once pathPhpTools."/CommonTools.php";

// Подключаем объект для работы с базой данных материалов
// (при необходимости создаем базу данных материалов)
$basename=$_SERVER['DOCUMENT_ROOT'].'/ittve'; $username='tve'; $password='23ety17'; 
$Arti=new ttools\ArticlesMaker($basename,$username,$password);
$pdo=$Arti->BaseConnect();
// Выбираем до 16 нарастающих записей, начиная с заданного Uid
$table=get16TestBase($pdo,$TestPoint,$messa); 
// Если выборка с ошибкой, то готовим сообщение
if ($messa<>imok) $error=true;
// Если первая выборка успешна, то анализируем выбранные записи
else if (count($table)>0)
{
   $pass=1; // будем анализировать первую выборку
   $TestPoint=noPid16TestBase($pdo,$TestPoint,$table,$pass,$messa,$Arti); 
   // Если тест с ошибкой, то готовим сообщение
   if ($messa<>imok) $error=true; 
}
// Если в первой выборке нет записей, то делаем её с начала
else
{
   $TestPoint=0;
   $table=get16TestBase($pdo,$TestPoint,$messa); 
   if ($messa<>imok) $error=true;
   // Если вторая выборка успешна, то анализируем выбранные записи
   else if (count($table)>0)
   {
      $pass=2; // будем анализировать вторую выборку
      $TestPoint=noPid16TestBase($pdo,$TestPoint,$table,$pass,$messa,$Arti); 
      // Если тест с ошибкой, то готовим сообщение
      if ($messa<>imok) $error=true; 
   }
}
// Освобождаем память
unset($Arti); unset($pdo); unset($table);
// Возвращаем сообщение
$message='{"messa":"'.$messa.'", "TestPoint":'.$TestPoint.', "error":"'.$error.'"}';
$message=\prown\makeLabel($message,'ghjun5','ghjun5');
echo $message;
exit;
// ****************************************************************************
// *        Выбрать до 16 нарастающих записей, начиная с заданного Uid,       *
// *               если записей нет, то выбрать, начиная с начала.            *
// ****************************************************************************
function get16TestBase($pdo,$TestPoint,&$messa) 
{
   $table=array();
   $LastPoint=$TestPoint+17;
   try
   {
      $pdo->beginTransaction();
      $cSQL='SELECT uid,pid FROM stockpw WHERE (uid > '.$TestPoint.') AND (uid < '.$LastPoint.')';
      $stmt = $pdo->query($cSQL);
      $table = $stmt->fetchAll();
      $pdo->commit();
      $messa=imok;
   } 
   catch (\Exception $e) 
   {
      $messa=$e->getMessage();
      if ($pdo->inTransaction()) $pdo->rollback();
   }
   return $table;
}
// ****************************************************************************
// *        Проверить все выбранные записи, если есть неверным pid-ом,        *
// *              удалить их. Изменить проверенный uid.                       *
// ****************************************************************************
function noPid16TestBase($pdo,$TestPoint,$tableCtrl,$pass,&$messa,$Arti) 
{
   define("uidWithInvalidPid",-21); // uid c неверным pid-ом
   $table=array();
   $uid=$TestPoint;
   $errorUid=uidWithInvalidPid; // uid c неверным pid-ом
   try
   {
      $messa=imok;
      $pdo->beginTransaction();
      foreach ($tableCtrl as $val) 
      {
         $uid=$val[0];
         $pid=$val[1];
         \ttools\PutString($pass.': $uid='.$uid.'  $pid='.$pid,'proba.txt');
         // Проверяем правильность pid
         if ($pid==0)
         {
            if (($uid==1)||($uid==21)) { /* это "ittve.me" или "ittve.end" */ }
            else
            {
               $messa="Назначен нулевой pid";  
            }
         }
         // Проверяем запись по родительскому идентификатору
         else
         {
            $cSQL='SELECT uid FROM stockpw WHERE uid = '.$pid;
            $stmt = $pdo->query($cSQL);
            $table = $stmt->fetchAll();
            $count=count($table);
            // Отмечаем неверный uid и выходим из цикла 
            if ($count==0) {$errorUid=$uid; break;}
         }  
      }
      $pdo->commit();
      // Удаляем запись по идентификатору uid c неверным pid-ом: в случае 
      // успешного удаления функция возвращает сообщение, что все хорошо, 
      // иначе сообщение об ошибке 
      if ($errorUid!=uidWithInvalidPid)
      {
         $messa='Неверный $pid='.$pid.' для $uid='.$uid.'.  Удаляем!';
         //\ttools\PutString($messa,'proba.txt');
         $messa=$Arti->DelRecord($pdo,$uid);
      }
   } 
   catch (\Exception $e) 
   {
      $messa=$e->getMessage();
      if ($pdo->inTransaction()) $pdo->rollback();
   }
   return $uid;
}
// *********************************************************** TestBase.php ***
