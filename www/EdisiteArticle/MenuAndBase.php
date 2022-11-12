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

// Построить ***15*** меню 
function ShowTree15($pdo,$ParentID,$PidIn,&$cLast,&$nLine,&$cli,$FirstUl,&$lvl=-1) 
{ 
   $lvl++; 
   $cSQL="SELECT uid,NameArt,Translit,pid FROM stockpw WHERE pid=".$ParentID." ORDER BY uid";
   $stmt = $pdo->query($cSQL);
   $table = $stmt->fetchAll();

   if (count($table)>0) 
   {
      // Выводим <ul>. Перед ним </li> не выводим.
      echo(SpacesOnLevel($lvl,$cLast,0,0).'<ul'.$FirstUl.'>'."\n"); $cLast='+ul';
      // 
      foreach ($table as $row)
      {
         $nLine++; $cLine='';//.' #'.$nLine.'#';
         $Uid = $row["uid"]; $Pid = $row["pid"]; $Translit = $row["Translit"];
         
         // Перед <li> выводим предыдущее </li>, если не было <ul>.
         if ($cLast<>'+ul') 
         {
             $cli=SpacesOnLevel($lvl,$cLast,$Uid,$Pid)."</li>\n";
             echo($cli); $cLast='-li';
         }
         //  
         echo(SpacesOnLevel($lvl,$cLast,$Uid,$Pid)."<li> "); $cLast='+li';
         echo("<a href=\""."?id=".$Translit."\">".$row["NameArt"].$cLine."</a>"."\n"); 
         // Вместо вывода </li> формируем строку для вывода по условию перед <ul> и <li>
         ShowTree15($pdo,$Uid,$Pid,$cLast,$nLine,$cli,'',$lvl); 
         $lvl--; 
      }
      // -----Перед </ul> ставим предыдущее </li>
      $cli=SpacesOnLevel($lvl,$cLast,0,0)."</li>\n";
      echo($cli); $cLast='-li';
      echo(SpacesOnLevel($lvl,$cLast,0,0)."</ul>\n");  $cLast='-ul';
   }
}
// Построить ***16*** меню 
function ShowTree16($pdo,$ParentID,$PidIn,&$cLast,&$nLine,&$cli,$FirstUl,&$lvl=-1) 
{ 
   $lvl++; 
   $cSQL="SELECT uid,NameArt,Translit,pid FROM stockpw WHERE pid=".$ParentID." ORDER BY uid";
   $stmt = $pdo->query($cSQL);
   $table = $stmt->fetchAll();

   if (count($table)>0) 
   {
      // Выводим <ul>. Перед ним </li> не выводим.
      echo(SpacesOnLevel($lvl,$cLast,0,0).'<ul'.$FirstUl.'>'."\n"); $cLast='+ul';
      // 
      foreach ($table as $row)
      {
         $nLine++; $cLine='';//.' #'.$nLine.'#';
         $Uid = $row["uid"]; $Pid = $row["pid"]; $Translit = $row["Translit"];
         
         // Перед <li> выводим предыдущее </li>, если не было <ul>.
         if ($cLast<>'+ul') 
         {
             $cli=SpacesOnLevel($lvl,$cLast,$Uid,$Pid)."</li>\n";
             echo($cli); $cLast='-li';
         }
         //  
         echo(SpacesOnLevel($lvl,$cLast,$Uid,$Pid)."<li> "); $cLast='+li';
         
         if ($Translit=='/')
         {
            echo('<a href="'.$Translit.'">'.$row['NameArt'].$cLine.'</a>'."\n"); 
         }
         else
         {
            echo('<a href="'.'?Com='.$Translit.'">'.$row['NameArt'].$cLine.'</a>'."\n"); 
         }
         // Вместо вывода </li> формируем строку для вывода по условию перед <ul> и <li>
         ShowTree16($pdo,$Uid,$Pid,$cLast,$nLine,$cli,'',$lvl); 
         $lvl--; 
      }
      // -----Перед </ul> ставим предыдущее </li>
      $cli=SpacesOnLevel($lvl,$cLast,0,0)."</li>\n";
      echo($cli); $cLast='-li';
      echo(SpacesOnLevel($lvl,$cLast,0,0)."</ul>\n");  $cLast='-ul';
   }
}

function SpacesOnLevel($lvl,$cLast,$Uid,$Pid)
{
   $i=1; $c=''; $c=cUidPid($Uid,$Pid,$cLast); 
   while ($i<=$lvl)
   {
      $c=$c.'...';
      $i++;
   }
   $c='';
   return $c;
}

function cUidPid($Uid,$Pid,$cLast)
{
   $c='<!-- '.$cLast.' '.(1000+$Uid).'-'.(1000+$Pid).' --> ';
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
