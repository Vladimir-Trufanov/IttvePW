<?php
// PHP7/HTML5, EDGE/CHROME                               *** CreateBase.php ***

// ****************************************************************************
// * ittve.pw              Создать базу данных itpw.db3 в начальном состоянии *
// ****************************************************************************

//                                                   Автор:       Труфанов В.Е.
//                                                   Дата создания:  04.05.2021
// Copyright © 2021 tve                              Посл.изменение: 06.05.2021

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
         'access   INTEGER NOT NULL,'.                            // доступ к пунктам меню (All/Autor)
         'DateArt  DATETIME,'.                                    // дата\время статьи сайта
         'Art      TEXT)';                                        // материал = статья сайта
      $st = $pdo->query($sql);
      
      // Заполняем таблицу материалов в начальном состоянии
      $aCharters=[
         [ 1, 0,-1, 'ittve.pw',                           'ittvepw',                            acsAll,  0,''],
         /*
         [ 2, 1,-1, 'Проба0',                             'proba0',                             acsAll,  0,''],
         [ 3, 2, 0,    'Проба01',                         'proba01',                            acsAll,  0,''],
         [ 4, 2,-1,    'Проба02',                         'proba02',                            acsAll,  0,''],
         [ 5, 4,-1,       'Проба03',                      'proba03',                            acsAll,  0,''],
         */
         [ 6, 1,-1, 'ММС Лада-Нива',                      'mms-lada-niva',                      acsAll,  0,''],
         [ 7, 6, 0,    'С чего все началось',             's-chego-vse-nachalos',               acsAll,  0,''],
         [ 8, 6, 0,    'А что внутри?',                   'a-chto-vnutri',                      acsAll,  0,''],
         [ 9, 6, 0,    'Эксперименты со строками',        'ehksperimenty-so-strokami',          acsAll,  0,''],
         [10, 1,-1, 'Стиль',                              'stil',                               acsAll,  0,''],
         [11,10, 0,    'Элементы стиля программирования', 'ehlementy-stilya-programmirovaniya', acsAll,  0,''],
         [12,10, 0,    'Пишите программы просто',         'pishite-programmy-prosto',           acsAll,  0,''],
         [13, 1,-1, 'Моделирование',                      'modelirovanie',                      acsAll,  0,''],
         [14, 1,-1, 'Учебники',                           'uchebniki',                          acsAll,  0,''],
         [15, 1,-1, 'Сайт',                               'sajt',                               acsAll,  0,''],
         [16,15, 0,    'Авторизоваться',                  'avtorizovatsya',                     acsAll,  0,''],
         [17,15, 0,    'Зарегистрироваться',              'zaregistrirovatsya',                 acsAll,  0,''],
         [18,15, 0,    'О сайте',                         'o-sajte',                            acsAll,  0,''],
         [19,15, 0,    'Редактировать материал',          'redaktirovat-material',              acsAutor,0,''],
         [20,15, 0,    'Изменить настройки',              'izmenit-nastrojki',                  acsAll,  0,''],
         [21,15, 0,    'Отключиться',                     'otklyuchitsya',                      acsAll,  0,''],
         /*
         [22, 1,-1, 'Проба',                              'proba',                              acsAll,  0,''],
         [23,22, 0,    'Проба21',                         'proba21',                            acsAll,  0,''],
         [24,22, 0,    'Проба22',                         'proba22',                            acsAll,  0,''],
         [25,22,-1,    'Проба23',                         'proba23',                            acsAll,  0,''],
         [26,25, 0,       'Проба31',                      'proba31',                            acsAll,  0,''],
         [27,25, 0,       'Проба32',                      'proba32',                            acsAll,  0,''],
         [28, 1,-1, 'Проба11',                            'proba11',                            acsAll,  0,''],
         */
         [29, 1,-1, 'ittve.end',                          'ittveend',                           acsAll,  0,'']
      ];

      $statement = $pdo->prepare("INSERT INTO [stockpw] ".
         "([uid], [pid], [IdCue], [NameArt], [Translit], [access], [DateArt], [Art]) VALUES ".
         "(:uid,  :pid,  :IdCue,  :NameArt,  :Translit,  :access,  :DateArt,  :Art);");
      $i=0;
      foreach ($aCharters as
          [$uid,  $pid,  $IdCue,  $NameArt,  $Translit,  $access,  $DateArt,  $Art])
      $statement->execute([
         "uid"      => $uid, 
         "pid"      => $pid, 
         "IdCue"    => $IdCue, 
         "NameArt"  => $NameArt, 
         "Translit" => $Translit, 
         "access"   => $access, 
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
echo '<br>';  
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

// Выбирается таблица для меню из базы данных
$stmt = $pdo->query("SELECT * FROM stockpw");
$table = $stmt->fetchAll();          
echo 'Выбрана таблица из базы данных<br>'; 

// Формируется массив для представления таблицы
$arrayl = array(); 
aRecursLevel($arrayl,$table); 
echo 'Сформирован массив для представления таблицы<br>'; 
echo '<br>';  
aViewLevel($arrayl);
echo '<br>'; 

// Формируем массив c указанием путей  
$array = array();                         // выходной массив
$array_idx_lvl = array();                 // индекс по полю level
aRecursPath($array,$array_idx_lvl,$table); 
echo 'Сформирован массив c указанием путей и транслита<br>'; 
echo '<br>';  
aViewPath($array);
// ********************************************************* CreateBase.php ***
