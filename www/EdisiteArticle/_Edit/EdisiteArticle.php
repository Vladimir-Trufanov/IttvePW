<?php
// PHP7/HTML5, EDGE/CHROME                           *** EdisiteArticle.php ***

// ****************************************************************************
// *                     Создать или редактировать материал                   *
// ****************************************************************************

//                                                   Автор:       Труфанов В.Е.
//                                                   Дата создания:  28.11.2020
// Copyright © 2020 tve                              Посл.изменение: 04.05.2021

/**  ЗАМЕЧАНИЕ:
 *   --- Данный модуль для вывода картинки запускается из 2 мест: из галереи 
 * изображений и из самого себя.
 *   --- При вызове из галереи задается режим вывода на странице - vimOnPage.
 *   --- Для возможного вызова картинки их данного модуля, в конце этого модуля 
 * меняется режим страничного вывода на полноформатный и наоборот.
 * 
 * Передаваемые общесайтовые переменные
 * 
 * $c_NameCharter                     - наименование раздела
 * $c_NameArt                         - заголовок=имя файла редактируемой статьи
 * $TranslitCharter                   - транслит наименования раздела
 * $Translit                          - транслит заголовка редактируемой статьи
 * $ImgdirSite="C:/IttveIMG/IttvePW/" - каталог изображений сайта
 * $PrefSite="itpw"                   - префикс изображений и статей сайта
 *    
**/
?>
<!-- 
<form action="textarea1.php" method="post">
-->
<?php
// Обеспечиваем загрузку изображений для страницы сайта
echo '<div id="NewGallery">';
   // Подключаем загруженные картинки
   require_once "GalleryNews.php";
   // Готовим загрузку новой картинки
   //echo '<form id="fGallery" action="'.$SpecSite.'">';
   echo '<form action="" method="post" enctype="multipart/form-data" id="uploadiImage">';
   $FileName="ittveNews/ittve01-001-С-заботой-и-к-мамам.jpg";
   $Comment="'С заботой и к мамам' - такой мамочкин хвостик.";
   GLoadImage($FileName,$Comment,true,"Upload");
   echo '</form>';
   // Из галереи задаем режим представления выбранной картинки - "на высоту страницы"
   //$s_ModeImg=prown\MakeSession('ModeImg',vimOnPage,tInt);           
echo '</div>';
// Создаем каталог для хранения изображений, если его нет.
// И отдельно (чтобы сработало на старых Windows) задаем права
$imgDir = "EdisiteArticle/_Current";
if (!is_dir($imgDir))
{
   mkdir($imgDir);      
   chmod($imgDir,0777);
}
// Устанавливаем максимальный размер в байтах для загружаемого файла в форму
$max = 57200;
// Загружаем выбранный файл, если был запрос
if (isset($_POST['upload'])) 
{     
   // define the path to the upload folder
   $destination = $imgDir.'/';
   try 
   {
      $upload = new ttools\UploadToServer($destination);
      $upload->move();
      $upload->setMaxSize($max);
      $result = $upload->getMessages();
   } 
   catch (Exception $e) 
   {
      echo $e->getMessage();
   }
}

// Воспроизводим разметку и подготовленные материалы   
//echo '<p><textarea id="TitleArea" name="areat">'.$c_NameArt.'</textarea></p>';

// Воспроизводим материал   
echo '<div id="EditDebug">';

// Формируем контрольный транслит
// echo  prown\getTranslit('Отключиться').'<br>';
// При отладке воссоздаем базу данных
// require_once 'EdisiteArticle/MakeItBase.php';

/*
echo '1------------------------------------------------<br>'; 
aViewMenu(MakeTableOfMenu($basename));
echo '2------------------------------------------------<br>'; 
*/

// Выводим меню
//echo '<ul id="main-menu" class="sm sm-mint">'.$Menu.'</ul>';

//echo '3------------------------------------------------<br>'; 
//$table=CreateMenuFromBase($basename);
//echo 'NumRowsTable($table)='.NumRowsTable($table).'<br>';

echo "123\n"; 

?> 
<!-- 
<ul id="main-menu" class="sm sm-blue">
  <li><a href="#">Item 1</a></li>
  <li><a href="#">Item 2</a>
    <ul>
      <li><a href="#">Item 2-1</a></li>
      <li><a href="#">Item 2-2</a></li>
      <li><a href="#">Item 2-3</a></li>
    </ul>
  </li>
  <li><a href="#">Item 3</a></li>
</ul>
--> 
<!--
<ul id="main-menu" class="sm sm-mint">
   <li><a href="/">ММС Лада-Нива</a>
      <ul>
         <li><a href="?Com=s-chego-vse-nachalos">С чего все началось</a></li>     
         <li><a href="?Com=a-chto-vnutri">А что внутри?</a></li>
         <li><a href="?Com=ehksperimenty-so-strokami">Эксперименты со строками</a></li>
      </ul>
   </li>
   <li><a href="/">Стиль</a>
      <ul>
         <li><a href="?Com=ehlementy-stilya-programmirovaniya">Элементы стиля программирования</a></li>
         <li><a href="?Com=pishite-programmy-prosto">Пишите программы просто</a></li>
      </ul>
   </li>
   <li><a href="/">Моделирование</a></li>
   <li><a href="/">Учебники</a></li>
   <li><a href="/">Сайт</a>
      <ul>
         <li><a href="?Com=avtorizovatsya">Авторизоваться</a></li>
         <li><a href="?Com=zaregistrirovatsya">Зарегистрироваться</a></li>
         <li><a href="?Com=o-sajte">О сайте</a></li>
         <li><a href="?Com=redaktirovat-material">Редактировать материал</a></li>
         <li><a href="?Com=izmenit-nastrojki">Изменить настройки</a></li>
         <li><a href="?Com=otklyuchitsya">Отключиться</a></li>
      </ul>
   </li>
</ul>
-->
<?php

?> 
<!--
<ul id="main-menu" class="sm sm-mint">
<li>
<a href="?id=2">Ардуино</a>
<ul>
<li>
<a href="?id=3">Как было</a>
</li>
<li>
<a href="?id=4">Вид из окна</a>
</li>
<li>
<a href="?id=5">Погода</a>
</li>
<li>
<a href="?id=22">Статья2 по Ардуино</a>
<ul>
<li>
<a href="?id=24">Тема4 по Ардуино</a>
</li>
<li>
<a href="?id=25">Тема5 по Ардуино</a>
<ul>
<li>
<a href="?id=26">Проба51</a>
</li>
<li>
<a href="?id=27">Проба52</a>
</li>
</ul>
</li>
</ul>
</li>
<li>
<a href="?id=23">Статья3 по Ардуино</a>
</li>
</ul>
</li>
<li>
<a href="?id=6">Лада-Нива</a>
<ul>
<li>
<a href="?id=7">С чего все началось</a>
</li>
<li>
<a href="?id=8">А что внутри?</a>
</li>
<li>
<a href="?id=9">Эксперименты со строками</a>
</li>
</ul>
</li>
<li>
<a href="?id=10">Стиль</a>
<ul>
<li>
<a href="?id=11">Элементы стиля программирования</a>
</li>
<li>
<a href="?id=12">Пишите программы просто</a>
</li>
</ul>
</li>
<li>
<a href="?id=13">Моделирование</a>
</li>
<li>
<a href="?id=14">Учебники</a>
</li>
<li>
<a href="?id=15">Сайт</a>
<ul>
<li>
<a href="?id=16">Авторизоваться</a>
</li>
<li>
<a href="?id=17">Зарегистрироваться</a>
</li>
<li>
<a href="?id=18">О сайте</a>
</li>
<li>
<a href="?id=19">Редактировать материал</a>
</li>
<li>
<a href="?id=20">Изменить настройки</a>
</li>
<li>
<a href="?id=21">Отключиться</a>
</li>
</ul>
</li>
<li>
<a href="?id=28">Проба11</a>
</li>
</ul>
-->
<?php

// Подключаемся к базе данных
BaseOpen($basename,$pdo);
$lvl=1;  $nspace=0; $cLast='+++';
$nLine=0; $cli="";
ShowTree($pdo,1,1,$lvl,$nspace,$cLast,$nLine,$cli,' id="main-menu" class="sm sm-mint"');
//echo '4------------------------------------------------<br>'; 


//prown\ViewGlobal(avgPOST);
// Выводим сообщения по итогам загрузки файла
/*
if (isset($result)) 
{
   echo '<ul>';
   foreach ($result as $message) 
   {
      echo "<li>$message</li>";
   }
   echo '</ul>';
}
*/
            ?>
            
            <!-- 
            <p><a href="download.php?file=pic.png">Download image</a></p>
            
            <form action="" method="post" enctype="multipart/form-data" id="uploadImage">
            <p>
            <label for="image">Upload images:</label>
            <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $max; ?>">
            <input type="file" name="image" id="image1">
            </p>
            <p>
            <input type="submit" name="upload" id="upload1" value="Upload">
            </p>
            </form>
            -->
            
            
            <?php
            
echo '</div>';
// Заполняем область редактирования
echo '<p><textarea id="ContentArea" name="areac">';
require $c_NameArt.".html";
echo '</textarea></p>';
echo '<p><input id="InputArea" type="submit" value="Отправить"></p>';
?>
<!-- 
</form>
-->
<?php
// ****************************************************************************
// *            Вывести (определить HTML-разметку) одну карточку галереи      *
// ****************************************************************************
function GViewImage($FileName,$Comment,$AreaText=false,$Action='Image')
{
   echo 
      '<div class="Card"> '.
      '<button class="bCard" type="submit" name="'.$Action.'" value="'.$FileName.'">'.
      '<img class="imgCard" src="'.$FileName.'" alt="'.$FileName.'">'.
      '</button>';
   // Выводим существующий комментарий или 
   // текст для редактирования
   if ($AreaText) 
   {
      echo '
         <textarea class="taCard" name="aream">Текст комментария к картинке</textarea>
         ';
   }
   else echo '<p class="pCard">'.$Comment.'</p>';
   echo 
      '</div>';
}
function GLoadImage($FileName,$Comment,$AreaText=false,$Action='Image')
{
   echo '
      <div class="Card">
      <button class="bCard" type="submit" name="upload" value="'.
      $FileName.'>';
   echo '
      <input type="hidden" name="MAX_FILE_SIZE" value="57200">
      <input type="file" name="image" id="image">
      <img class="imgCard" src="EdisiteArticle/_Edit/ImgTemplate.jpg" alt="'.
      $FileName.'>';
   echo '
      </button>
      <textarea class="taCard" name="aream">Текст комментария к картинке</textarea>
      </div>';
   ?>
   <!-- 
   <input type="submit" name="upload" id="upload" value="Upload">
   -->
   <?php
   
   
}
// *** <!-- --> **************************************** EdisiteArticle.php ***
