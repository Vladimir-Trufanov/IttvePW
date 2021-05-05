<?php
// PHP7/HTML5, EDGE/CHROME                              *** TreeActions.php ***

// ****************************************************************************
// * ittve.pw       Исследовать пример https://m.habr.com/ru/post/280944/ для *
// *                      для загрузки меню нескольких уровней из базы данных *
// ****************************************************************************

//                                                   Автор:       Труфанов В.Е.
//                                                   Дата создания:  04.05.2021
// Copyright © 2021 tve                              Посл.изменение: 05.05.2021

// ****************************************************************************
// *          Проверить существование и удалить файл из файловой системы      *
// ****************************************************************************
function UnlinkFile($filename)
{
   if (file_exists($filename)) 
   {
      if (!unlink($filename))
      {
         // Выводится сообщение о неудачном удалении файла базы данных в случаях:
         // а) база данных подключена к стороннему приложению;
         // б) база данных еще привязана к другому объекту класса;
         // в) прочее
         throw new Exception("Не удалось удалить файл $filename!");
      } 
   } 
}
// ****************************************************************************
// *     Создать и заполнить таблицу "post280944" базы данных "olegmorozov"   *
// ****************************************************************************
function CreateTables($pdo)
/**
 *  Сайт
 *     Документы
 *        Секретные
 *           Паспортные данные
 *           Декларация за 2015 год
 *        Общие
 *           Телефонные номера
 *     Отчетность
 *        Бухгалтерская отчетность
 *           Отчет для налоговой
 *           Отчет в ПФРФ
 *     Сведения
**/
{
   try 
   {
      $pdo->beginTransaction();
      // Создаём таблицу    
      $sql='CREATE TABLE post280944 ('.
         'uid      INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,'.
         'pid      INTEGER,'.
         'name     VARCHAR,'.
         'access   VARCHAR )';
      $st = $pdo->query($sql);
      // Заполняем таблицу
      $aPost280944=[
         [ 1, 0,'Сайт',                     'DomainUsers'],
         [ 2, 1,'Документы',                'inherit'],
         [ 3, 1,'Отчетность',               'inherit'],
         [ 4, 1,'Сведения',                 'inherit'],
         [ 5, 2,'Секретные',                'ADGroupSecret'],
         [ 6, 2,'Общие',                    'inherit'],
         [ 7, 5,'Паспортные данные',        'inherit'],
         [ 8, 5,'Декларация за 2015 год',   'inherit'],
         [ 9, 6,'Телефонные номера',        'inherit'],
         [10, 3,'Бухгалтерская отчетность', 'ADGroupSecret'],
         [11,10,'Отчет для налоговой',      'inherit'],
         [12,10,'Отчет в ПФРФ',             'inherit']
      ];
      $statement = $pdo->prepare("INSERT INTO [post280944] ".
         "([uid], [pid], [name], [access]) VALUES ".
         "(:uid,  :pid,  :name,  :access);");
      $i=0;
      foreach ($aPost280944 as [$uid,$pid,$name,$access])
      $statement->execute([
         /*"uid"    => $uid, автоинкрементное поле не трогаем */ 
         "pid"    => $pid, 
         "name"   => $name,
         "access" => $access
      ]);
      $pdo->commit();
   } 
   catch (Exception $e) 
   {
      // Если в транзакции, то делаем откат изменений
      if ($pdo->inTransaction()) 
      {
         $pdo->rollback();
      }
      // Продолжаем исключение
     throw $e;
   }
}
// ****************************************************************************
// *              Сформировать массив для представления таблицы               *
// ****************************************************************************
function recursive(&$array,$data,$pid = 0,$level = 0)
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
         $_row['name']=$_row['name']=str_pad('', $level*3, '.').$row['name']; 
         // Добавляем уровень
         $_row['level']=$level;      
         $_row['groups']=$row['access'];
         // Прибавляем каждую строку к выходному массиву
         $array[]=$_row; 
         // Строка обработана, теперь запустим эту же функцию для текущего uid, то есть
         // пойдёт обратотка дочерней строки (у которой этот uid является pid-ом)
         recursive($array,$data,$row['uid'],$level + 1);
      }
   }
}
// ****************************************************************************
// *           Вывести содержимое массива в первом виде - до уровня           *
// ****************************************************************************
function ViewLevel($array)
{
   echo '<pre>';
   // Выводим шапку
   echo '<table border=2>';
   echo '<tr>';
   echo '<td>UID</td>'; 
   echo '<td>'.str_pad('PID',4," ",STR_PAD_LEFT).'</td>'; 
   echo '<td> NAME</td>'; 
   echo '<td>LEVEL</td>'; 
   echo '<td>'.str_pad('GROUPS',14," ",STR_PAD_LEFT).'</td>'; 
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
      echo ' '.$value['name']; 
      echo '</td>'; 
      echo '<td>'; 
      echo str_pad($value['level'],5," ",STR_PAD_LEFT);
      echo '</td>'; 
      echo '<td>'; 
      echo str_pad($value['groups'],14," ",STR_PAD_LEFT);
      echo '</td>'; 
      echo '</tr>';
   }
   echo '</table>';
   echo '</pre>';
}
// ****************************************************************************
// *   Сформировать массив представления таблицы c указанием путей и доступа  *
// ****************************************************************************
function recursiveM(&$array,&$array_idx_lvl,
   $data,$pid=0,$level=0,$path="",$access_parent="inherit")
{
  // Перебираем строки
  foreach ($data as $row)
  {
    // Работаем со строками, pid которых передан в функцию (с 0, с корня сайта)
    if ($row['pid'] == $pid)
    {
      // Собираем строку в ассоциативный массив
      $_row['uid']    = $row['uid'];
      $_row['pid']    = $row['pid'];
      $_row['name']   = str_pad('', $level*3, '.').$row['name'];
      $_row['level']  = $level;                   // добавляем уровень
      $_row['path']   = $path."/".$row['name'];   // добавляем имя к пути
      $_row['view']   = ".";
      $_row['groups']=$row['access'];
      $_row['access'] = $access_parent;
      // Разруливаем доступы
      if ($row['access'] == 'inherit')
      {
         $_row['access'] = $access_parent; // Если наследование, делаем как у родителя
      }
      else 
      {
         if ($row['access'] == 'ADGroupSecret') $_row['access']='deny'; 
         else $_row['access']='allow'; 
      }
      $array[$row['uid']] = $_row;   // Результирующий массив индексируемый по uid
      // Для быстрой выборки по level, формируем индекс
      $array_idx_lvl[$level][$row['uid']] = $row['uid'];
      // Строка обработана, теперь запустим эту же функцию для текущего uid, то есть
      // пойдёт обработка дочерней строки (у которой этот uid является pid-ом)
      recursiveM($array,$array_idx_lvl,$data,$row['uid'], $level + 1,$_row['path'],$_row['access']);
    } 
  }
}
// ****************************************************************************
// *           Вывести содержимое массива в первом виде - до уровня           *
// ****************************************************************************
function ViewAccess($array)
{
   echo '<pre>';
   // Выводим шапку
   echo '<table border=2>';
   echo '<tr>';
   echo '<td>UID</td>'; 
   echo '<td>'.str_pad('PID',4," ",STR_PAD_LEFT).'</td>'; 
   echo '<td> NAME</td>'; 
   echo '<td>LEVEL</td>'; 
   echo '<td> PATH</td>'; 
   // echo '<td>'.str_pad('GROUPS',14," ",STR_PAD_LEFT).'</td>'; 
   echo '<td>ACCESS</td>'; 
   echo '<td> VIEW</td>'; 
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
      echo ' '.$value['name']; 
      echo '</td>'; 
      echo '<td>'; 
      echo str_pad($value['level'],5," ",STR_PAD_LEFT);
      echo '</td>'; 
      echo '<td>'; 
      echo ' '.$value['path'];
      echo '</td>'; 
      //echo '<td>'; 
      //echo str_pad($value['groups'],14," ",STR_PAD_LEFT);
      //echo '</td>'; 
      echo '<td>'; 
      echo ' '.$value['access'];
      echo '</td>'; 
      echo '<td>'; 
      echo ' '.$value['view'];
      echo '</td>'; 
      echo '</tr>';
   }
   echo '</table>';
   echo '</pre>';
}

// ****************************************************************************
// *           Создать базу данных olegmorozov.db3 в начальном состоянии      *
// ****************************************************************************
echo '<br>';  
// Проверяется существование и удаляется файл базы данных 
$filename=$_SERVER['DOCUMENT_ROOT'].'/olegmorozov.db3';
UnlinkFile($filename);
echo 'Удалена база данных: olegmorozov.db3<br>';  

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
echo 'Создан объект PDO и файл базы данных<br>'; 

// Создаются таблицы базы данных
CreateTables($pdo);
echo 'Создана и заполнена таблица базы данных<br>'; 

// Выбираем таблицу из базы данных
$stmt = $pdo->query("SELECT * FROM post280944");
$table = $stmt->fetchAll();          
echo 'Выбрана таблица из базы данных<br>'; 

// Формируем массив для представления таблицы
$array = array(); 
recursive($array,$table); 
echo 'Сформирован массив для представления таблицы<br>'; 
echo '<br>';  
ViewLevel($array);
echo '<br>'; 

// Формируем массив c указанием путей и доступа 
$array = array();                         // выходной массив
$array_idx_lvl = array();                 // индекс по полю level
recursiveM($array,$array_idx_lvl,$table); 
echo 'Сформирован массив c указанием путей и доступа<br>'; 
echo '<br>';  
ViewAccess($array);
echo '<br>';  

 
echo '<br>';  
// ******************************************************** TreeActions.php ***
