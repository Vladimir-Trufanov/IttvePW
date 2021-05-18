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
// *                               Сформировать меню                          *
// ****************************************************************************
function aViewMenu($array)
{
   $Result='';
   $levelOld=0;
   // Выводим данные
   foreach ($array as $value)
   {
      // Строку с названием сайта = нулевой уровень не обрабатываем
      if (!$value['level']==0)
      {
         // Формируем смещение для пункта меню
         $Result=$Result.MakeSpases($value['level']); 
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
         //$Result=$Result.strval($value['IdCue']).' '.strval($value['level']).
         //   ' -'.$value['Translit'].'='.$value['Name'].'-)<br>';
         // Запоминаем текущий обработанный уровень
         $levelOld=$value['level'];
      }
   }
   return $Result;
}
// ************************************************************ iniMenu.php ***
