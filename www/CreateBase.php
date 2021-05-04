<?php
// PHP7/HTML5, EDGE/CHROME                               *** CreateBase.php ***

// ****************************************************************************
// * ittve.pw              Создать базу данных itpw.db3 в начальном состоянии *
// ****************************************************************************

//                                                   Автор:       Труфанов В.Е.
//                                                   Дата создания:  04.05.2021
// Copyright © 2021 tve                              Посл.изменение: 04.05.2021

// ****************************************************************************
// *          Проверить существование и удалить файл из файловой системы      *
// ****************************************************************************
function UnlinkFile($filename)
{
   if (file_exists($filename)) 
   {
      if (!unlink($filename))
      {
         // Выводим сообщение о неудачном удалении файла базы данных в случаях:
         // а) база данных подключена к стороннему приложению;
         // б) база данных еще привязана к другому объекту класса;
         // в) прочее
         throw new Exception("Не удалось удалить файл $filename!");
      } 
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

// Строятся таблицы базы данных
try 
{
   $pdo->beginTransaction();
   // Создаём таблицу разделов   
   $sql='CREATE TABLE charter ('.
      'IdCharter      INTEGER PRIMARY KEY NOT NULL UNIQUE,'.
      'NameCharter    VARCHAR,'.
      'TranslitCarter VARCHAR )';
   $st = $pdo->query($sql);
   // Создаём таблицу указателей наличия примеров   
   $sql='CREATE TABLE cue ('.
      'IdCue          INTEGER PRIMARY KEY NOT NULL UNIQUE,'.
      'NameCue        VARCHAR )';
   $st = $pdo->query($sql);
   // Включаем действие внешних ключей
   $sql='PRAGMA foreign_keys=on;';
   $st = $pdo->query($sql);
   // Создаём таблицу материалов   
   $sql='CREATE TABLE stock ('.
      'Numb           INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,'.
      'IdCharter      INTEGER NOT NULL REFERENCES charter(IdCharter),'.
      'IdCue          INTEGER NOT NULL REFERENCES cue(IdCue),'.
      'NameArt        VARCHAR,'.
      'Translit       VARCHAR,'.
      'Art            VARCHAR )';
   $st = $pdo->query($sql);

   
   /*   
      $sql='CREATE TABLE colours (
         [id-colour] INTEGER PRIMARY KEY,
         colour      TEXT
      )';
      $st = $pdo->query($sql);
      
      $sql='CREATE TABLE produkts (
         name        TEXT PRIMARY KEY,
         [id-colour] INTEGER NOT NULL REFERENCES colours ([id-colour]),
         calories    NUMERIC( 5, 1 ),
         [id-vid]    INTEGER
      )';
      $st = $pdo->query($sql);
      
      // https://art-life-spb.ru/kaiioraz_frukty
      // https://sostavproduktov.ru/produkty/yagody
      // https://sostavproduktov.ru/potrebitelyu/vidy-produktov/frukty

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




echo '<br>';  
// ********************************************************* CreateBase.php ***
