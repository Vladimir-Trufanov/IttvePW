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
define ("ihref",'href="');        
define ("comequ",'?com='); 
define ("ehref",'">'); 
define ("ibr",''); 
*/
// ------------------------ Отладочный режим формирования тегов списка меню ---
define ("ili",'(li)');        
define ("eli",'(/li)');        
define ("iul",'(ul)');        
define ("eul",'(/ul)'); 
define ("ia",'(a ');        
define ("ea",'(/a)'); 
define ("ihref",'href="');        
define ("comequ",'?com='); 
define ("ehref",'")'); 
define ("ibr",'<br>'); 
// ****************************************************************************
// *  Сформировать подстроку из трех пробелов для каждого уровня со второго   *
// ****************************************************************************
function MakeSpases($level)
{
   //$spases='...';
   $spases='';
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
/*
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
*/
// ****************************************************************************
// *                               Сформировать меню                          *
// ****************************************************************************
/*
$Menu='
   <li><a href="/">ММС Лада-Нива</a>
      <ul>
         <li><a href="?Com=s-chego-vse-nachalos">С чего все началось</a></li>     
         <li><a href="index.php?Com=s-chego-vse-nachalos">А что внутри?</a></li>
         <li><a href="/">Эксперименты со строками</a></li>
      </ul>
   </li>
   <li><a href="/">Стиль</a>
      <ul>
         <li><a href="?Com=ehlementy-stilya-programmirovaniya">Элементы стиля программирования</a></li>
         <li><a href="?Com=pishite-programmy-prosto">Пишите программы просто</a></li>
      </ul>
   </li>
   <li><a href="?Com=s-chego-vse-nachalos">Моделирование</a></li>
   <li><a href="#">Учебники</a></li>
   <li><a href="#">Сайт</a>
      <ul>
         <li><a href="/">Авторизоваться</a></li>
         <li><a href="/">Зарегистрироваться</a></li>
         <li><a href="/">О сайте</a></li>
         <li><a href="?Com=redaktirovat-material">Редактировать материал</a></li>
         <li><a href="/">Изменить настройки</a></li>
         <li><a href="/">Отключиться</a></li>
      </ul>
   </li>
';
*/
function aViewMenu($array)
{
   $Result='';   // html-текст формируемого меню
   echo '<pre>';
   // Выводим шапку
   echo '<table border=2>';
   // Выводим данные
   foreach ($array as $value)
   {
      echo '<tr>';
      echo '<td>'; 
      echo ' '.$value['Translit'];
      echo '</td>'; 
      echo '<td>'; 
      echo ' '.$value['Name']; 
      echo '</td>'; 
      echo '<td>'; 
      echo ' '.$value['Level'];
      echo '</td>'; 
      echo '<td>'; 
      echo ' '.$value['LevelOld'];
      echo '</td>'; 
      echo '<td>'; 
      echo ' '.$value['IdCue'];
      echo '</td>'; 
      echo '</tr>';
   }
   echo '</table>';
   echo '</pre>';
}



function aViewMenu1($array)
{
   $Result='';   // html-текст формируемого меню
   $Resold='';   // html-текст меню, сформированный на предыдущем шаге
   $levelOld=0;
   $isUL=true;
   // Выводим данные
   foreach ($array as $value)
   {
      // Строку с названием сайта = нулевой уровень не обрабатываем
      if (!$value['level']==0)
      {
         // Если новый уровень меньше старого, то формируем /ul
         $Result=$Result.MakeEul($value['level'],$levelOld,$isUL);
         // Если новый уровень больше старого, то формируем ul
         // и отрезаем /li
         if (($value['level']>$levelOld)and($levelOld>0)) 
         {
            // Отрезаем /li
            $Result=$Resold.ibr; 
            // Формируем смещение для html-строки меню
            $Result=$Result.MakeSpases($value['level']); 
            // Добавляем ul
            $Result=$Result.iul;
            //$isUL=false;
         }
         // Формируем смещение для li
         $Result=$Result.MakeSpases($value['level']); 
         // Формируем li (если не граничная строка 'ittve.end')
         if (!($value['Name']=='ittve.end'))
         {
         if ($value['IdCue']==tisRazdel)
         {
            // Формируем li пункта меню с разделом
            $Result=$Result.ili.ia.ihref."/".ehref.$value['Name'].ea;
         }
         else
         {
            // Формируем обычную li пункта меню c материалом
            $Result=$Result.ili.ia.ihref.comequ.$value['Translit'].ehref.$value['Name'].ea;
         }
         // Запоминаем текст меню без последнего /li 
         // для возможного использования на следующем шаге
         $Resold=$Result;   
         // Добавляем /li
         $Result=$Result.eli;
         }
         // Запоминаем текущий обработанный уровень
         $levelOld=$value['level'];
      }
   }
   return $Result;
}
// ************************************************************ iniMenu.php ***
