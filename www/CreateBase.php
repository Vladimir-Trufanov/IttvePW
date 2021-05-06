<?php
// PHP7/HTML5, EDGE/CHROME                               *** CreateBase.php ***

// ****************************************************************************
// * ittve.pw              Создать базу данных itpw.db3 в начальном состоянии *
// ****************************************************************************

//                                                   Автор:       Труфанов В.Е.
//                                                   Дата создания:  04.05.2021
// Copyright © 2021 tve                              Посл.изменение: 06.05.2021

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
// *      Создать таблицы базы данных и выполнить начальное заполнение        *
// ****************************************************************************
function CreateTables($pdo)
{
   try 
   {
      $pdo->beginTransaction();

      // Включаем действие внешних ключей
      $sql='PRAGMA foreign_keys=on;';
      $st = $pdo->query($sql);

      // Создаём таблицу указателей типов статей   
      $sql='CREATE TABLE cue ('.
         'IdCue          INTEGER PRIMARY KEY NOT NULL UNIQUE,'.
         'NameCue        VARCHAR )';
      $st = $pdo->query($sql);

      // Заполняем таблицу указателей типов статей
      $aСues=[
         [ -1, 'Раздел'],
         [  0, 'Статья для сайта = материал'],
         [  1, 'Пример на умалчиваемом языке (по статье)'],
         [  2, 'Пример на PHP'],
         [  4, 'Пример на JavaScript'],
         [  8, 'Пример на Лазарусе/Delphi']
      ];
      $statement = $pdo->prepare("INSERT INTO [cue] ".
         "([IdCue], [NameCue]) VALUES ".
         "(:IdCue,  :NameCue);");
      $i=0;
      foreach ($aСues as [$IdCue,$NameCue])
      $statement->execute([
         "IdCue"      => $IdCue, 
         "NameCue"    => $NameCue
      ]);

      // Создаём таблицу материалов   
      $sql='CREATE TABLE stockpw ('.
         'uid      INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,'.  // идентификатор пункта меню (раздел или статья сайта)
         'pid      INTEGER NOT NULL,'.                            // указатель элемента уровнем выше - uid родителя	
         'IdCue    INTEGER NOT NULL REFERENCES cue(IdCue),'.      // указатель типа статьи
         'NameArt  VARCHAR NOT NULL,'.                            // заголовок материала = статьи сайта
         'Translit VARCHAR NOT NULL,'.                            // транслит заголовка
         'DateArt  DATETIME,'.                                    // дата\время статьи сайта
         'Art      TEXT)';                                        // материал = статья сайта
      $st = $pdo->query($sql);
      
      // Заполняем таблицу материалов в начальном состоянии
      $aCharters=[
         [ 1, 0,-1, 'Сайт ittve.pw',                      'sajt-ittvepw',                       0,''],
         [ 2, 1,-1, 'ММС Лада-Нива',                      'mms-lada-niva',                      0,''],
         [ 3, 2, 0,    'С чего все началось',             's-chego-vse-nachalos',               0,''],
         [ 4, 2, 0,    'А что внутри?',                   'a-chto-vnutri',                      0,''],
         [ 5, 2, 0,    'Эксперименты со строками',        'ehksperimenty-so-strokami',          0,''],
         [ 6, 1,-1, 'Стиль',                              'stil',                               0,''],
         [ 7, 6, 0,    'Элементы стиля программирования', 'ehlementy-stilya-programmirovaniya', 0,''],
         [ 8, 6, 0,    'Пишите программы просто',         'pishite-programmy-prosto',           0,''],
         [ 9, 1,-1, 'Моделирование',                      'modelirovanie',                      0,''],
         [10, 1,-1, 'Учебники',                           'uchebniki',                          0,''],
         [11, 1,-1, 'Сайт',                               'sajt',                               0,''],
         [12,11, 0,    'Авторизоваться',                  'avtorizovatsya',                     0,''],
         [13,11, 0,    'Зарегистрироваться',              'zaregistrirovatsya',                 0,''],
         [14,11, 0,    'О сайте',                         'o-sajte',                            0,''],
         [15,11, 0,    'Редактировать материал',          'redaktirovat-material',              0,''],
         [16,11, 0,    'Изменить настройки',              'izmenit-nastrojki',                  0,''],
         [17,11, 0,    'Отключиться',                     'otklyuchitsya',                      0,'']
      ];

      $statement = $pdo->prepare("INSERT INTO [stockpw] ".
         "([uid], [pid], [IdCue], [NameArt], [Translit], [DateArt], [Art]) VALUES ".
         "(:uid,  :pid,  :IdCue,  :NameArt,  :Translit,  :DateArt,  :Art);");
      $i=0;
      foreach ($aCharters as
          [$uid,  $pid,  $IdCue,  $NameArt,  $Translit,  $DateArt,  $Art])
      $statement->execute([
         "uid"      => $uid, 
         "pid"      => $pid, 
         "IdCue"    => $IdCue, 
         "NameArt"  => $NameArt, 
         "Translit" => $Translit, 
         "DateArt"  => $DateArt, 
         "Art"      => $Art
      ]);

      // Создаём таблицу для списка изображений   
      $sql='CREATE TABLE picturepw ('.
         'uid         INTEGER NOT NULL REFERENCES stockpw(uid),'.  // идентификатор пункта меню (раздел или статья сайта)
         'NamePic     VARCHAR NOT NULL,'.                          // заголовок изображения к статье сайта
         'TranslitPic VARCHAR NOT NULL,'.                          // транслит заголовка изображения
         'DatePic     DATETIME,'.                                  // дата\время изображения
         'Сomment     TEXT)';                                      // комментарий к изображению
      $st = $pdo->query($sql);

      // Создаём контрольную таблицу базы данных   
      $sql='CREATE TABLE ctrlpw ('.
         'bid         VARCHAR NOT NULL,'.    // наименование базы данных
         'СommBase    TEXT)';                // комментарий по базе данных
      $st = $pdo->query($sql);
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
// *               Создать базу данных itpw.db3 в начальном состоянии         *
// ****************************************************************************
echo '<br>';  
// Проверяется существование и удаляется файл базы данных 
$filename=$_SERVER['DOCUMENT_ROOT'].'/itpw.db3';
UnlinkFile($filename);
echo 'Проверено существование и удалён старый файл базы данных: itpw.db3<br>';  

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
echo 'Созданы таблицы и выполнено начальное заполнение<br>'; 

echo '<br>';  
// ********************************************************* CreateBase.php ***
