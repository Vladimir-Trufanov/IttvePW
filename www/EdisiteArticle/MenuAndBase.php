<?php

// ������� ���������� � ����� ������
function dbopen()
{
   $hostName = "";
   $userName = "yura";
   $password = "yura";
   $databaseName = "tree";
   if (!($link=mysql_connect($hostName,$userName,$password))) 
   {
      printf("������ ��� ���������� � MySQL !\n");
      exit();
   }
   if (!mysql_select_db($databaseName, $link)) 
   {
      printf("������ ���� ������ !");
      exit();
   } 
}

/*
// ��������� ���� (����������)
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

// ������� ���������� � ����� ������
function BaseOpen($filename,&$pdo)
{
   // ��������� ������ PDO � ���� ���� ������
   $pathBase='sqlite:'.$filename; 
   $username='tve';
   $password='23ety17';     
   // ���������� PDO � ����
   $pdo = new PDO(
      $pathBase, 
      $username,
      $password,
      array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)
   );
}

// ��������� ���� (����������)
function ShowTree($pdo,$ParentID,&$lvl,&$nspace,&$cLast) 
{ 
   $lvl++; 

   //$cSQL="SELECT uid,NameArt,pid FROM stockpw WHERE pid=".$ParentID." ORDER BY NameArt";
   $cSQL="SELECT uid,NameArt,pid FROM stockpw WHERE pid=".$ParentID." ORDER BY uid";
   $stmt = $pdo->query($cSQL);
   $table = $stmt->fetchAll();

   if (count($table)>0) 
   {
      $nspace=$nspace+3; echo(cLast($cLast).spaces($nspace)."<ul> \n"); $cLast='+ul';
      foreach ($table as $row)
      {
         $ID1 = $row["uid"];
         echo(cLast($cLast).spaces($nspace)."<li>\n"); $cLast='+li';
         echo(cLast($cLast).spaces($nspace)."<a href=\""."?id=".$ID1."\">".$row["NameArt"].' ='.$nspace.'-'.$ID1.'-'.$row["pid"]."</a>"."  \n");
         if ($cLast=='+li')
         {
            echo(cLast($cLast).spaces($nspace)."</li>\n"); $cLast='-li';
         } 
         ShowTree($pdo,$ID1,$lvl,$nspace,$cLast); 
         $lvl--;
      }
      $nspace=$nspace-3; echo(cLast($cLast).spaces($nspace)."</ul>\n");  $cLast='-ul';
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

function NumRowsTable($table)
{
   $NumRows=0;
   $NumRows=count($table);
   return $NumRows;
}

function CreateMenuFromBase($filename)
{
   // ������������ � ���� ������
   BaseOpen($filename,$pdo);
   // �������� ������ ������� ��� ���� �� ���� ������
   //$stmt = $pdo->query("SELECT uid,NameArt,pid FROM stockpw");
   $stmt = $pdo->query("SELECT uid,NameArt,pid FROM stockpw WHERE pid='1' ORDER BY NameArt");
   //"SELECT id,title,pid FROM catalogue WHERE pid=".$ParentID." ORDER BY title"
   $table = $stmt->fetchAll();
   print_r($table);       
   return $table;
}


?> 
