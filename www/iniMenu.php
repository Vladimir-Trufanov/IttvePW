<?php
// PHP7/HTML5, EDGE/CHROME                                  *** iniMenu.php ***

// ****************************************************************************
// * ittve.pw             Блок функций построения меню по таблице базы данных *
// ****************************************************************************

//                                                   Автор:       Труфанов В.Е.
//                                                   Дата создания:  04.05.2021
// Copyright © 2021 tve                              Посл.изменение: 18.05.2021

// -------------------------- Режим формирования реальных тегов списка меню ---
/*
define ("ili",'<li>');        
define ("eli",'</li>');        
define ("iul",'<ul>');        
define ("eul",'</ul>'); 
define ("ia",'<a ');        
define ("ea",'</a>'); 
define ("ihref",'href="?com=');        
define ("ehref",'">'); 
define ("ibr",''); 
*/
// ------------------------ Отладочный режим формирования тегов списка меню ---
define ("ili",'(li)');        
define ("eli",'(/li)<br>');        
define ("iul",'(ul)<br>');        
define ("eul",'(/ul)<br>'); 
define ("ia",'(a ');        
define ("ea",'(/a)'); 
define ("ihref",'href="');        
define ("com",'?com='); 
define ("ehref",'")'); 
define ("ibr",'<br>'); 

// ****************************************************************************
// *  Сформировать подстроку из трех пробелов для каждого уровня со второго   *
// ****************************************************************************
function MakeSpases($level)
{
   $spases='...';
   $Result='';
   if ($level>1)
   {
      $i=$level-1;
      while ($i>0) 
      {
         $Result=$Result.$spases;
         $i--;
      }
   } 
   return $Result;
}
// ****************************************************************************
// *                         Если новый уровень меньше старого,               *
// *                 то сформировать все /ul до совмещения уровней            *
// ****************************************************************************
function MakeEul($level,$levelOldi,&$isUL)
{
   $i=-9;
   // Формируем трассировочный текст при отладке
   $c='$level='.strval($level).' '.'$levelOldi='.strval($levelOldi);
   $Result='';
   if ($level>0)
   {
      while ($level<=$levelOldi) 
      {
         // Пересчитываем переменную, 
         // чтобы определить условие для разблокировки вывода eul
         $i=$level-$levelOldi;
         //if (!$i==0) $Result=$Result.MakeSpases($levelOldi).'***'.strval($i).'***'.eul;
         if (!$i==0) $Result=$Result.MakeSpases($levelOldi).eul.MakeSpases($levelOldi-1).eli;
         $levelOldi--;
      }
      if ($i==-9) $Result='';
      else if ($level=$levelOldi) $Result='';
      else $isUL=true;
      //else $Result=$Result.'...............'.$c.'***'.strval($i).'***';
   }
   return $Result;
}
// ****************************************************************************
// *                               Сформировать меню                          *
// ****************************************************************************
function aViewMenu($array)
{
   $Result='';
   $levelOld=0;
   $isUL=true;
   // Выводим данные
   foreach ($array as $value)
   {
      // Строку с названием сайта = нулевой уровень не обрабатываем
      if (!$value['level']==0)
      {
         /*
         // Если новый уровень меньше старого, то формируем /ul
         $Result=$Result.MakeEul($value['level'],$levelOld);
         // Формируем смещение для пункта меню
         $Result=$Result.MakeSpases($value['level']); 
         // Если новый уровень больше старого, то формируем ul
         if (($value['level']>$levelOld)and($levelOld>0)) $Result=$Result.iul.MakeSpases($value['level']);
         // Формируем li
         if ($value['IdCue']==tisRazdel)
         {
            // Формируем li пункта меню с разделом
            $Result=$Result.ili.ia.ihref."/".ehref.$value['Name'].ea.eli;
         }
         else
         {
            // Формируем обычную li пункта меню c материалом
            $Result=$Result.ili.ia.ihref.com.$value['Translit'].ehref.$value['Name'].ea.eli;
         }
         */

         // Если новый уровень меньше старого, то формируем /ul
         $Result=$Result.MakeEul($value['level'],$levelOld,$isUL);
         // Формируем смещение для пункта меню
         $Result=$Result.MakeSpases($value['level']); 
         // Если новый уровень больше старого, то формируем ul
         if (($value['level']>$levelOld)and($levelOld>0)) 
         {
            $Result=$Result.iul.MakeSpases($value['level']);
            $isUL=false;
         }
         // Формируем li
         if ($value['IdCue']==tisRazdel)
         {
            // Формируем li пункта меню с разделом
            $Result=$Result.ili.ia.ihref."/".ehref.$value['Name'].ea;
         }
         else
         {
            // Формируем обычную li пункта меню c материалом
            $Result=$Result.ili.ia.ihref.com.$value['Translit'].ehref.$value['Name'].ea;
         }
         if ($isUL) $Result=$Result.ibr;
         else $Result=$Result.eli;
         // Запоминаем текущий обработанный уровень
         $levelOld=$value['level'];
      }
   }
   return $Result;
}
// ************************************************************ iniMenu.php ***
