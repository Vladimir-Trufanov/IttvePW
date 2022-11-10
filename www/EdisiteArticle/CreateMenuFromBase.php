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

// Построить меню (рекурсивно)
function ShowTree($ParentID, $lvl) 
{ 
   global $link; 
   global $lvl; 
   $lvl++; 

   $sSQL="SELECT id,title,pid FROM catalogue WHERE pid=".$ParentID." ORDER BY title";
   $result=mysql_query($sSQL, $link);

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

ShowTree(0, 0); 
mysql_close($link); 

?> 
