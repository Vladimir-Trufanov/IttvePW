<?php

// Открыть соединение с базой данных
function dbopen()
{
   $hostName = "";
   $userName = "yura";
   $password = "yura";
   $databaseName = "tree";
   if (!($link=mysql_connect($hostName,$userName,$password))) 
   {
      printf("Ошибка при соединении с MySQL !\n");
      exit();
   }
   if (!mysql_select_db($databaseName, $link)) 
   {
      printf("Ошибка базы данных !");
      exit();
   } 
}

/*
// Построить меню (рекурсивно)
function ShowTree($ParentID, $lvl) 
{ 
   global $link; 
   global $lvl; 
   $lvl++; 

   $sSQL="SELECT id,title,pid FROM catalogue WHERE pid=".$ParentID." ORDER BY title";
   //$result=mysql_query($sSQL, $link);

   if (mysql_num_rows($result) > 0) 
   {
      echo("<UL>\n");
      while ($row = mysql_fetch_array($result)) 
      {
         $ID1 = $row["id"];
         echo("<LI>\n");
         echo("<A HREF=\""."?ID=".$ID1."\">".$row["title"]."</A>"."  \n");
         ShowTree($ID1, $lvl); 
         $lvl--;
      }
      echo("</UL>\n");
   }
}
*/

//ShowTree(0, 0); 
//mysql_close($link); 

// Открыть соединение с базой данных
function BaseOpen($filename,&$pdo)
{
   // Создается объект PDO и файл базы данных
   $pathBase='sqlite:'.$filename; 
   $username='tve';
   $password='23ety17';     
   // Подключаем PDO к базе
   $pdo = new PDO(
      $pathBase, 
      $username,
      $password,
      array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)
   );
}

/*
// Построить меню (рекурсивно) В ДРУГОЙ РЕАЛИЗАЦИИ РАБОТАТЬ С МАССИВОМ
function ShowTree($pdo,$ParentID,$PidIn,&$lvl,&$nspace,&$cLast,&$nLine,&$cli) 
{ 
   $nLine++;
   $lvl++; $nspace=$nspace+3;

   $cSQL="SELECT uid,NameArt,pid FROM stockpw WHERE pid=".$ParentID." ORDER BY uid";
   $stmt = $pdo->query($cSQL);
   $table = $stmt->fetchAll();

   if (count($table)>0) 
   {
      // Выводим <ul>. Перед ним </li> не выводим.
      if ($ParentID<>$PidIn)
      { 
         echo("<ul>"."\n"); $cLast='+ul';
      }
      // 
      foreach ($table as $row)
      {
         $Uid = $row["uid"]; $Pid = $row["pid"];
         // Перед <li> выводим предыдущее </li>, если не было <ul>.
         if ($cLast<>'+ul') {echo($cli); $cLast='-li';}
         //  
         echo("<li>\n"); $cLast='+li';
         echo("<a href=\""."?id=".$Uid."\">".$row["NameArt"]."</a>"."\n");
         // Вместо вывода </li> формируем строку для вывода по условию перед <ul> и <li>
         $cli="</li>"."\n";
         ShowTree($pdo,$Uid,$Pid,$lvl,$nspace,$cLast,$nLine,$cli); 
         $lvl--; $nspace=$nspace-3; 
      }
      // -----Перед </ul> ставим предыдущее </li>, если не было </ul>
      if ($cLast=='+li') 
      {
         echo($cli); $cLast='-li';
         if ($ParentID<>$PidIn)
         { 
            echo("</ul>"."\n");  $cLast='-ul';
         }
      }
   }
}
*/



// Построить меню (рекурсивно) В ДРУГОЙ РЕАЛИЗАЦИИ РАБОТАТЬ С МАССИВОМ
function ShowTree($pdo,$ParentID,$PidIn,&$lvl,&$nspace,&$cLast,&$nLine,&$cli) 
{ 
   $nLine++;
   //echo(cLast($cLast).spaces($nspace)."</li>".cUidPid($ParentID,$PidIn)."\n"); $cLast='-li';
   $lvl++; $nspace=$nspace+3;

   //$cSQL="SELECT uid,NameArt,pid FROM stockpw WHERE pid=".$ParentID." ORDER BY NameArt";
   $cSQL="SELECT uid,NameArt,pid FROM stockpw WHERE pid=".$ParentID." ORDER BY uid";
   $stmt = $pdo->query($cSQL);
   $table = $stmt->fetchAll();

   if (count($table)>0) 
   {
      // Выводим <ul>. Перед ним </li> не выводим.
      echo(cLast($cLast).spaces($nspace)."<ul>".cUidPid($ParentID,$PidIn)."\n"); $cLast='+ul';
      // 
      foreach ($table as $row)
      {
         $Uid = $row["uid"]; $Pid = $row["pid"];
         
         // Перед <li> выводим предыдущее </li>, если не было <ul>.
         if ($cLast<>'+ul') {echo($cli); $cLast='-li';}
         //  
         echo(cLast($cLast).spaces($nspace)."<li>\n"); $cLast='+li';
         echo(cLast($cLast).spaces($nspace)."<a href=\""."?id=".$Uid."\">".$row["NameArt"].' ='.$nspace.'-'.$Uid.'-'.$Pid.' $nLine='.$nLine."</a>"."  \n");
         // Вместо вывода </li> формируем строку для вывода по условию перед <ul> и <li>
         $cli=cLast($cLast).spaces($nspace)."</li>".cUidPid($ParentID,$PidIn)."\n";
         ShowTree($pdo,$Uid,$Pid,$lvl,$nspace,$cLast,$nLine,$cli); 
         $lvl--; $nspace=$nspace-3; 
      }
      // -----Перед </ul> ставим предыдущее </li>
      echo($cli); $cLast='-li';
      echo(cLast($cLast).spaces($nspace)."</ul>\n");  $cLast='-ul';
   }
}

function spaces($nspace)
{
   $i=1; $c='';
   while ($i<=$nspace)
   {
      $c=$c.'.';
      $i++;
   }
   return $c;
}

function cLast($cLast)
{
   $c='<!-- '.$cLast.' -->';
   return $c;
}

function cUidPid($Uid,$Pid)
{
   $c='<!-- '.$Uid.'='.$Pid.' -->';
   return $c;
}

function NumRowsTable($table)
{
   $NumRows=0;
   $NumRows=count($table);
   return $NumRows;
}

function CreateMenuFromBase($filename)
{
   // Подключаемся к базе данных
   BaseOpen($filename,$pdo);
   // Выбираем строку таблицы для меню из базы данных
   //$stmt = $pdo->query("SELECT uid,NameArt,pid FROM stockpw");
   $stmt = $pdo->query("SELECT uid,NameArt,pid FROM stockpw WHERE pid='1' ORDER BY NameArt");
   //"SELECT id,title,pid FROM catalogue WHERE pid=".$ParentID." ORDER BY title"
   $table = $stmt->fetchAll();
   print_r($table);       
   return $table;
}


?> 
