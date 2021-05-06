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
// *                         Создать таблицы базы данных                      *
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
      $sql='CREATE TABLE stock ('.
         'uid      INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,'.  // идентификатор пункта меню (раздел или статья сайта)
         'pid      INTEGER NOT NULL,'.                            // указатель элемента уровнем выше - uid родителя	
         'IdCue    INTEGER NOT NULL REFERENCES cue(IdCue),'.      // указатель типа статьи
         'NameArt  VARCHAR,'.                                     // заголовок материала = статьи сайта
         'Translit VARCHAR,'.                                     // транслит заголовка
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
      
      /*
      $statement = $pdo->prepare("INSERT INTO [charter] ".
         "([IdCharter], [NameCharter], [TranslitCarter]) VALUES ".
         "(:IdCharter,  :NameCharter,  :TranslitCarter);");
      $i=0;
      foreach ($aCharters as [$IdCharter,$NameCharter,$TranslitCarter])
      $statement->execute([
         "IdCharter"      => $IdCharter, 
         "NameCharter"    => $NameCharter, 
         "TranslitCarter" => prown\getTranslit($NameCharter)
      ]);
      */
      
      
      
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
// *                  Выполнить начальное заполнение таблиц                   *
// ****************************************************************************
function Befill($pdo)
{
   // https://art-life-spb.ru/kaiioraz_frukty
   // https://sostavproduktov.ru/produkty/yagody
   // https://sostavproduktov.ru/potrebitelyu/vidy-produktov/frukty
   try 
   {
      $pdo->beginTransaction();
      // Заполняем таблицу разделов
      $aCharters=[
         [ 1,'ММС Лада-Нива', ''],
         [ 2,'Стиль',         ''],
         [ 3,'Моделирование', ''],
         [ 4,'Учебники',      ''],
         [ 5,'Сайт',          '']
      ];
      $statement = $pdo->prepare("INSERT INTO [charter] ".
         "([IdCharter], [NameCharter], [TranslitCarter]) VALUES ".
         "(:IdCharter,  :NameCharter,  :TranslitCarter);");
      $i=0;
      foreach ($aCharters as [$IdCharter,$NameCharter,$TranslitCarter])
      $statement->execute([
         "IdCharter"      => $IdCharter, 
         "NameCharter"    => $NameCharter, 
         "TranslitCarter" => prown\getTranslit($NameCharter)
      ]);

      
      
      
      
      
      
   /*
      $sql="INSERT INTO [vids] ([id-vid], [vid]) VALUES ('1', 'фрукты');";
      $st = $pdo->query($sql);
      $sql="INSERT INTO [vids] ([id-vid], [vid]) VALUES ('2', 'ягоды');";
      $st = $pdo->query($sql);

      $sql="INSERT INTO [colours] ([id-colour], [colour]) VALUES (1, 'красные');";
      $st = $pdo->query($sql);
      $sql="INSERT INTO [colours] ([id-colour], [colour]) VALUES (2, 'голубые');";
      $st = $pdo->query($sql);
      $sql="INSERT INTO [colours] ([id-colour], [colour]) VALUES (3, 'жёлтые');";
      $st = $pdo->query($sql);
      $sql="INSERT INTO [colours] ([id-colour], [colour]) VALUES (4, 'оранжевые');";
      $st = $pdo->query($sql);
      $sql="INSERT INTO [colours] ([id-colour], [colour]) VALUES (5, 'зелёные');";
      $st = $pdo->query($sql);

      $aProducts=[
         ['голубика',  2, 41, 2],
         ['брусника',  1, 41, 2],
         ['груши',     3, 42, 1],
         ['земляника', 1, 34, 2],
         ['рябина',    4, 81, 2],
         ['виноград',  5, 70, 1]
      ];
      $statement = $pdo->prepare("INSERT INTO [produkts] ".
         "([name], [id-colour], [calories], [id-vid]) VALUES ".
         "(:name,  :idcolour,   :calories,  :idvid);");
      $i=0;
      foreach ($aProducts as [$name,$idcolor,$calories,$idvid])
      $statement->execute(["name"=>$name, "idcolour"=>$idcolor, "calories"=>$calories, "idvid"=>$idvid]);
   */   



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
echo 'Созданы таблицы базы данных<br>'; 
// Выполняется начальное заполнение таблиц
//Befill($pdo);
//echo 'Выполнено начальное заполнение таблиц<br>'; 

echo '<br>';  
// ********************************************************* CreateBase.php ***
