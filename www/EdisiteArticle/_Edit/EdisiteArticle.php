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

// Готовим и выводим меню
$Arti=new ttools\ArticlesMaker($basename,$username,$password);

// Выводим тестовое меню
$Arti->ShowSampleMenu();
// При отладке воссоздаем базу данных
//$Arti->BaseFirstCreate();

// Строим html-код меню по базе данных материалов сайта 
// (предварительно определяем параметры первого тега <ul> для
// связи со SmartMenu) 

$Arti->MakeMenu();

/*
echo '_MakeTblMenu<br>';
$ListFields = array(
   'uid'     => '..Пункт меню..',
   'pid'     => '..Родитель..',
   'NameArt' => '..Статья сайта..',
   'IdCue'   => '..Тип статьи..',
);
$SignAsc='>..';
$SignDesc='<..';

$Arti->MakeTblMenu($ListFields,$SignAsc,$SignDesc);
*/

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
