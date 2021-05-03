<?php
// PHP7/HTML5, EDGE/CHROME                                 *** EditText.php ***

// ****************************************************************************
// * ittve.me                              Создать или редактировать материал *
// ****************************************************************************

//                                                   Автор:       Труфанов В.Е.
//                                                   Дата создания:  28.11.2020
// Copyright © 2020 tve                              Посл.изменение: 28.11.2020

/**  ЗАМЕЧАНИЕ:
 *   --- Данный модуль для вывода картинки запускается из 2 мест: из галереи 
 * изображений и из самого себя.
 *   --- При вызове из галереи задается режим вывода на странице - vimOnPage.
 *   --- Для возможного вызова картинки их данного модуля, в конце этого модуля 
 * меняется режим страничного вывода на полноформатный и наоборот.
 * 
 * Передаваемые общесайтовые переменные
 *    $ImgdirSite="C:/IttveIMG/IttvePW/";  // каталог изображений сайта
 *    $PrefSite="itpw";                    // префикс изображений и статей сайта

*/

?>
<!-- 
<form action="textarea1.php" method="post">
-->
   <div id="NewGallery">
      <?php
      require_once "GalleryNews.php";
      ?>
   </div>

   <?php
      // Создаем каталог для хранения изображений, если его нет.
      // И отдельно (чтобы сработало на старых Windows) задаем права
      $imgDir = "GalleryProba";
      if (!is_dir($imgDir))
      {
         mkdir($imgDir);      
         chmod($imgDir,0777);
      }
      // set the maximum upload size in bytes
      $max = 57200;
      //if (isset($_POST['upload'])) 
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
   
      echo '<p><textarea id="TitleArea" name="areat">Заголовок</textarea></p>';
      echo '<div id="EditDebug">
            <p><b>Создать материал или редактировать его</b></p>';
      echo '<br>';
      //prown\ViewGlobal(avgPOST);
      
      // Выводим сообщения по итогам загрузки файла
      if (isset($result)) 
      {
         echo '<ul>';
         foreach ($result as $message) 
         {
            echo "<li>$message</li>";
         }
         echo '</ul>';
      }

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
       echo '<p><textarea id="ContentArea" name="areac">Текст нового материала';
       prown\ViewGlobal(avgREQUEST);
       echo '</textarea></p>';
   ?>
   <p><input id="InputArea" type="submit" value="Отправить"></p>
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
   /*
   ?>
   <!-- -->
   <div class="Card">
   <!-- 
   <button class="bCard" type="submit" name="Upload" value="FileName">
   -->
   <input type="file" name="image" id="image">
   <img class="imgCard" src="sampo.jpg" alt="FileName">
   <input type="submit" name="upload" id="upload" value="Upload">
   <!-- 
   </button>
   -->
   <textarea class="taCard" name="aream">Текст комментария к картинке</textarea>
   </div>
   <?php
   */
      ?>
   <!-- -->
   <div class="Card">
   <button class="bCard" type="submit" name="upload" value="FileName">
   <input type="hidden" name="MAX_FILE_SIZE" value="57200">
   <input type="file" name="image" id="image">
   <img class="imgCard" src="sampo.jpg" alt="FileName">
   <!-- 
   <input type="submit" name="upload" id="upload" value="Upload">
   -->
   </button>
   <textarea class="taCard" name="aream">Текст комментария к картинке</textarea>
   </div>
   <?php
}



// *********************************************************** EditText.php ***
