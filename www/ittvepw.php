<?php
// PHP7/HTML5, EDGE/CHROME                                  *** ittvepw.php ***

// ****************************************************************************
// * ittve.pw                                    Блок вспомогательных функций *
// ****************************************************************************

//                                                   Автор:       Труфанов В.Е.
//                                                   Дата создания:  04.05.2021
// Copyright © 2021 tve                              Посл.изменение: 03.04.2022

// ****************************************************************************
// *          Проверить существование и удалить файл из файловой системы      *
// *         (используется в случаях, когда необходимо перезаполнить файл)    *
// ****************************************************************************
function UnlinkFile($filename)
{
   if (file_exists($filename)) 
   {
      if (!unlink($filename))
      {
         // Для файла базы данных выводится сообщение о неудачном удалении 
         // в случаях:
         //    а) база данных подключена к стороннему приложению;
         //    б) база данных еще привязана к другому объекту класса;
         //    в) прочее
         throw new Exception("Не удалось удалить файл $filename!");
      } 
   } 
}
// ****************************************************************************
// *          Сформировать массив для представления таблицы до уровня         *
// *              (по мотивам - https://m.habr.com/ru/post/280944/)           *
// ****************************************************************************
function aRecursLevel(&$array,$data,$pid = 0,$level = 0)
{
   foreach ($data as $row)   
   {
      // Смотрим строки, pid которых передан в функцию,
      // начинаем с нуля, т.е. с корня сайта
      if ($row['pid'] == $pid)   
      { 
         // Собираем строку в ассоциативный массив
         $_row['uid']=$row['uid'];
         $_row['pid']=$row['pid'];
         // Функцией str_pad добавляем точки
         $_row['NameArt']=$_row['NameArt']=str_pad('', $level*3, '.').$row['NameArt']; 
         // Добавляем уровень
         $_row['level']=$level;      
         $_row['IdCue']=$row['IdCue'];
         $_row['access']=$row['access'];
         $_row['Translit']=$row['Translit'];       
         $_row['Name']=$row['NameArt'];       
         // Прибавляем каждую строку к выходному массиву
         $array[]=$_row; 
         // Строка обработана, теперь запустим эту же функцию для текущего uid, то есть
         // пойдёт обратотка дочерней строки (у которой этот uid является pid-ом)
         aRecursLevel($array,$data,$row['uid'],$level + 1);
      }
   }
}
// ****************************************************************************
// *          ---------------Сформировать массив для представления таблицы до уровня         *
// *          ---------------    (по мотивам - https://m.habr.com/ru/post/280944/)           *
// ****************************************************************************
function aRecursForMenu(&$array,$data,$pid=0,$level=0)
{
   foreach ($data as $row)   
   {
      // Смотрим строки, pid которых передан в функцию,
      // начинаем с нуля, т.е. с корня сайта
      if ($row['pid'] == $pid)   
      { 
         // Собираем строку в ассоциативный массив,
         // кроме 'ittve.pw' и 'ittve.end'
         if (($row['NameArt']<>'ittve.pw'))
         {
            if (($row['NameArt']<>'ittve.end'))
            {
               $IdCue=$row['IdCue']; 
               if (count($array)==0) $levelOld=$level;     
               else $levelOld=$array[count($array)-1]['Level'];       

               // Функцией str_pad добавляем точки
               $points=str_pad('',$level*3,'.');
               $_row['Translit']=$points;

               if ($level>$levelOld)
               {
                  $_row['Translit']=$_row['Translit'].iul;       
               }
               if ($level<$levelOld)
               {
                  $_row['Translit']=$_row['Translit'].eul;       
               }



               if ($IdCue==0) 
               {
                  $_row['Translit']=$_row['Translit'].ili.$row['Translit'];  
                  $_row['Name']=$row['NameArt'].eli; 
                  $_row['IdCue']=$IdCue;
                  $_row['Level']=$level;
                  $_row['LevelOld']=$levelOld;
                  $array[]=$_row;
               }      
               // Или формируем пункт меню для начала раздела
               // <li><a href="/">Стиль</a>
               else if ($IdCue==-1)
               {
                  $_row['Translit']=$points."/";
                  $_row['Name']=$row['NameArt']; 
                  $_row['IdCue']=$IdCue;
                  $_row['Level']=$level;
                  $_row['LevelOld']=$levelOld;
                  $array[]=$_row;
               }  
               // Прибавляем каждую строку к выходному массиву
            } 
         } 
         // Строка обработана, теперь запустим эту же функцию для текущего uid, то есть
         // пойдёт обратотка дочерней строки (у которой этот uid является pid-ом)
         aRecursForMenu($array,$data,$row['uid'],$level+1);
      }
   }
}
function aRecursForMenuOld(&$array,$data,$pid=0,$level=0)
{
   foreach ($data as $row)   
   {
      // Смотрим строки, pid которых передан в функцию,
      // начинаем с нуля, т.е. с корня сайта
      if ($row['pid'] == $pid)   
      { 
         // Собираем строку в ассоциативный массив,
         // кроме 'ittve.pw' и 'ittve.end'
         if (($row['NameArt']<>'ittve.pw'))
         {
            if (($row['NameArt']<>'ittve.end'))
            {
               $_row['IdCue']=$row['IdCue']; 
               $_row['Level']=$level; 
               if (count($array)==0) $_row['LevelOld']=$level;     
               else $_row['LevelOld']=$array[count($array)-1]['Level'];       

               if ($_row['Level']>$_row['LevelOld'])
               {
                  $points=str_pad('',$_row['Level']*3,'.');
                  $_row['Translit']=$points.iul;       
                  $_row['Name']='';       
                  $array[]=$_row;
               }
               if ($_row['Level']<$_row['LevelOld'])
               {
                  // Закрываем <ul>
                  $points=str_pad('',$_row['LevelOld']*3,'.');
                  $_row['Translit']=$points.eul;       
                  $_row['Name']='';       
                  $array[]=$_row;
                  // Закрываем все родительские <li>
                  $points=str_pad('',$_row['Level']*3,'.');
                  $_row['Translit']=$points.eli;       
                  $_row['Name']='';       
                  $array[]=$_row;
               }
               // Функцией str_pad добавляем точки
               $points=str_pad('',$_row['Level']*3,'.');
               // Формируем пункт меню для статьи
               // <li><a href="?Com=pishite-programmy-prosto">Пишите программы просто</a></li>   
               if ($_row['IdCue']==0) 
               {
                  $_row['Translit']=$points.ili.ia.ihref.comequ.$row['Translit'].ehref;  
                  $_row['Name']=$row['NameArt'].ea.eli; 
                  $array[]=$_row;
               }      
               // Или формируем пункт меню для начала раздела
               // <li><a href="/">Стиль</a>
               else if ($_row['IdCue']==-1)
               {
                  $_row['Translit']=$points.ili.ia.ihref."/".ehref;
                  $_row['Name']=$row['NameArt'].ea; 
                  $array[]=$_row;
               }  
               // Прибавляем каждую строку к выходному массиву
            } 
         } 
         // Строка обработана, теперь запустим эту же функцию для текущего uid, то есть
         // пойдёт обратотка дочерней строки (у которой этот uid является pid-ом)
         aRecursForMenu($array,$data,$row['uid'],$level+1);
      }
   }
}
// ****************************************************************************
// *         Сформировать массив представления таблицы c указанием путей      *
// ****************************************************************************
function aRecursPath(&$array,&$array_idx_lvl,$data,$pid=0,$level=0,$path="")
{
   foreach ($data as $row)   
   {
      // Смотрим строки, pid которых передан в функцию,
      // начинаем с нуля, т.е. с корня сайта
      if ($row['pid'] == $pid)   
      { 
         // Собираем строку в ассоциативный массив
         $_row['uid']=$row['uid'];
         $_row['pid']=$row['pid'];
         // Функцией str_pad добавляем точки
         $_row['NameArt']=$_row['NameArt']=str_pad('', $level*3, '.').$row['NameArt']; 
         // Добавляем уровень
         $_row['level']=$level;      
         $_row['IdCue']=$row['IdCue'];
         $_row['path']=$path."/".$row['NameArt'];   // добавляем имя к пути
         $_row['Translit']=$row['Translit'];        // добавляем транслит
         $_row['access']=$row['access'];
         $array[$row['uid']] = $_row;   // Результирующий массив индексируемый по uid
         // Для быстрой выборки по level, формируем индекс
         $array_idx_lvl[$level][$row['uid']] = $row['uid'];
         // Строка обработана, теперь запустим эту же функцию для текущего uid, то есть
         // пойдёт обработка дочерней строки (у которой этот uid является pid-ом)
         aRecursPath($array,$array_idx_lvl,$data,$row['uid'],$level+1,$_row['path']);
      } 
   }
}
// ****************************************************************************
// *           Вывести содержимое массива в первом виде - до уровня           *
// ****************************************************************************
function aViewLevel($array)
{
   echo '<pre>';
   // Выводим шапку
   echo '<table border=2>';
   echo '<tr>';
   echo '<td>UID</td>'; 
   echo '<td>'.str_pad('PID',4," ",STR_PAD_LEFT).'</td>'; 
   echo '<td> NAMEART</td>'; 
   echo '<td>LEVEL</td>'; 
   echo '<td>'.str_pad('IDCUE',6," ",STR_PAD_LEFT).'</td>'; 
   echo '<td>'.' access'.'</td>'; 
   echo '</tr>';        
   // Выводим данные
   foreach ($array as $value)
   {
      echo '<tr>';
      echo '<td>'; 
      echo str_pad($value['uid'],3," ",STR_PAD_LEFT);
      echo '</td>'; 
      echo '<td>'; 
      echo str_pad($value['pid'],4," ",STR_PAD_LEFT);
      echo '</td>'; 
      echo '<td>'; 
      echo ' '.$value['NameArt']; 
      echo '</td>'; 
      echo '<td>'; 
      echo str_pad($value['level'],5," ",STR_PAD_LEFT);
      echo '</td>'; 
      echo '<td>'; 
      echo str_pad($value['IdCue'],6," ",STR_PAD_LEFT);
      echo '</td>'; 
      echo '<td>'; 
      if ($value['access']==acsAutor) echo ' АВТОР';
      else if ($value['access']==acsClose) echo ' Закрыт';
      else echo ' Все';
      echo '</td>'; 
      echo '</tr>';
   }
   echo '</table>';
   echo '</pre>';
}
// ****************************************************************************
// *             Вывести содержимое массива с путями и транслитом             *
// ****************************************************************************
function aViewPath($array)
{
   echo '<pre>';
   // Выводим шапку
   echo '<table border=2>';
   echo '<tr>';
   echo '<td>UID</td>'; 
   echo '<td>'.str_pad('PID',4," ",STR_PAD_LEFT).'</td>'; 
   echo '<td> NAMEART</td>'; 
   echo '<td>LEVEL</td>'; 
   echo '<td> PATH</td>'; 
   echo '<td> TRANSLIT</td>'; 
   echo '<td>'.str_pad('IDCUE',6," ",STR_PAD_LEFT).'</td>'; 
   echo '<td>'.' access'.'</td>'; 
   echo '</tr>';        
   // Выводим данные
   foreach ($array as $value)
   {
      echo '<tr>';
      echo '<td>'; 
      echo str_pad($value['uid'],3," ",STR_PAD_LEFT);
      echo '</td>'; 
      echo '<td>'; 
      echo str_pad($value['pid'],4," ",STR_PAD_LEFT);
      echo '</td>'; 
      echo '<td>'; 
      echo ' '.$value['NameArt']; 
      echo '</td>'; 
      echo '<td>'; 
      echo str_pad($value['level'],5," ",STR_PAD_LEFT);
      echo '</td>'; 
      echo '<td>'; 
      echo ' '.$value['path'];
      echo '</td>'; 
      echo '<td>'; 
      echo ' '.$value['Translit'];
      echo '</td>'; 
      echo '<td>'; 
      echo str_pad($value['IdCue'],6," ",STR_PAD_LEFT);
      echo '</td>'; 
      echo '<td>'; 
      if ($value['access']==acsAutor) echo ' АВТОР';
      else if ($value['access']==acsClose) echo ' Закрыт';
      else echo ' Все';
      echo '</td>'; 
      echo '</tr>';
   }
   echo '</table>';
   echo '</pre>';
}
// ****************************************************************************
// *                       Извлечь из базы массив таблицы меню                *
// ****************************************************************************
function MakeTableOfMenu($filename)
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
   // Выбирается таблица для меню из базы данных
   $stmt = $pdo->query("SELECT * FROM stockpw");
   $table = $stmt->fetchAll();   
   
   //$arrayl = array(); 
   //aRecursLevel($arrayl,$table); 
   //aViewLevel($arrayl);
   
   $array = array();                         // выходной массив
   $array_idx_lvl = array();                 // индекс по полю level
   aRecursPath($array,$array_idx_lvl,$table); 
   aViewPath($array);

   echo '<br>';
          
   // Формируется массив для представления таблицы
   $arrayl = array(); 
   aRecursForMenu($arrayl,$table); 
   return $arrayl;
}

// ************************************************************ ittvepw.php ***
