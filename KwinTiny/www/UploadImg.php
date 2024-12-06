<?php
// PHP7/HTML5, EDGE/CHROME                                *** UploadImg.php ***

// ****************************************************************************
// * KwinTiny                                 Обеспечить загрузку изображений *
// *                                        в хранилище подготовки материалов *
// ****************************************************************************

//                                                   Автор:       Труфанов В.Е.
//                                                   Дата создания:  23.01.2019
// Copyright © 2019 tve                              Посл.изменение: 11.03.2019

/**
 * Настройки конфигурации PHP, влияющие на загрузку файлов
 * (настройки находятся в разделе Core файла php.ini)
 *
 * Разрешена ли серверу загрузка файлов?
 * file_uploads = On
 * 
 * Максимальное время в секундах, отводимое на выполнение сценария.
 * Если выполнение сценария занимает больше времени, интерпретатор PHP
 * генерирует фатальную ошибку
 * max_execution_time = 30
 * 
 * Максимальное число секунд, отводимое сценарию PHP на разбор содержимого
 * массивов $_POST, $_GET и загрузку файлов. При загрузке очень больших файлов
 * указанного времени, скорее всего не хватит
 * max_input_time = 60
 * 
 * Максимально допустимый размер всех данных, хранящихся в массиве $_POST,
 * в том числе загружаемых файлов
 * post_max_size = 8M
 * 
 * Временный каталог хранения загруженных файлов до тех пор, пока сценарий не
 * переместит их в постоянное месторасположение. Если не указано, то 
 * используется стандартный системный каталог для временных файлов: 
 * C:\Windows\Temp
 * upload_tmp_dir =
 * 
 * Максимально допустимый размер одного загружаемого файла
 * upload_max_filesize = 2M
**/

require_once prown."/TPhpPrown/CommonPrown.php";

// Устанавливаем максимальный размер загружаемых файлов в байтах
// (по умолчанию 300K)
$MaxLoadSize = 1600000;
if (isset($_POST['UploadImg'])) 
{

   // \prown\ConsoleLog('$_FILES=',count($_FILES)); 

   $destination = $DirImg;
   try 
   {
      $upload = new Ps2_Upload($destination);
      $upload->move();
      $result = $upload->getMessages();
      foreach ($result as $message) 
      {
         \prown\ConsoleLog('$result='.$message); 
      }
   } 
   catch (Exception $e) 
   {
      echo $e->getMessage();
   }
}

// Выводим возможные сообщения от объекта $upload
if (isset($result)) 
{
   /*
   echo '<ul>';
   foreach ($result as $message) 
   {
      echo "<li>===$message===</li>";
   }
   echo '</ul>';
   */
}


class Ps2_Upload 
{
	// Определяем свойства класса
   protected $_uploaded = array();  // Список загруженных файлов 
   protected $_destination;         // Путь к каталогу загрузки
   //protected $_max = 307200;        // Максимальный размер файла = 300Kb
   protected $_max = 1600000;        // Максимальный размер загружаемого файла
   protected $_messages = array();
   protected $_permitted = array    // массив MIME-типов изображений
   (
    'image/gif',
	'image/jpeg',
	'image/jpg',
	'image/pjpeg',
	'image/png'
   );
   protected $_renamed = false;
   protected $_filenames = array();

   // Готовим открытый (публичный) метод-конструктор класса:
   // принимаем путь к каталогу загрузки и список файлов, загруженных во
   // временный системный каталог
   public function __construct($path) 
   {
      if (!is_dir($path) || !is_writable($path)) 
      {
         throw new Exception("$path must be a valid, writable directory.");
	   }
	  $this->_destination = $path;
	  $this->_uploaded = $_FILES;
   }
   
   // Привести размер файла к сокращенному виду
   public function getMaxSize() 
   {
      return number_format($this->_max/1024,1).'Kb';
   }

  public function setMaxSize($num) {
	if (!is_numeric($num)) {
	  throw new Exception("Maximum size must be a number.");
	}
	$this->_max = (int) $num;
  }

   // Перемещаем файлы из временного системного каталога 
   // в каталог для загруженных файлов
   public function move() 
   {
      $field = current($this->_uploaded);
      $OK = $this->checkError($field['name'], $field['error']);
      if ($OK) 
      {
         $sizeOK = $this->checkSize($field['name'], $field['size']);
         $typeOK = $this->checkType($field['name'], $field['type']);
         if ($sizeOK && $typeOK) 
         {
            $success = 
            move_uploaded_file
            (
               $field['tmp_name'], 
               $this->_destination.$field['name']
            );
            if ($success)
            {
               $this->_messages[] = 
               "Файл ".$field['name'].' загружен успешно';
            }
            else
            {
               $this->_messages[] = 
               'Не удалось загрузить файл '.$field['name'];
            }
         }
      }
   }
   
   public function getMessages() 
   {
      return $this->_messages;
   }
   
   // Проверить код ошибки
   protected function checkError($filename, $error) 
   {
   switch ($error) 
      {
         case 0:
         return true;
         
         case 1:
         $this->_messages[] = 
         "Размер файла $filename превышает максимальный размер: ". 
         $this->getMaxSize()." или указанный в php.ini";
         return true;
         
         case 2:
         $this->_messages[] = 
         "Размер файла $filename превышает максимальный размер: " . 
         $this->getMaxSize()." или указанный в форме";
         return true;
         
         case 3:
         $this->_messages[] = 
         "Файл $filename загружен частично. Пожалуйста, повторите загрузку";
		   return false;
         
         case 4:
         $this->_messages[] = 'Файл не выбран';
         return false;
         
         case 6:
         $this->_messages[] = 'Временная папка загрузки отсутствует';
         return false;
         
         case 7:
         $this->_messages[] = 
         "Файл $filename невозможно записать на диск";
         return false;
         
         default:
         $this->_messages[] = 
         "Системная ошибка загрузки файла $filename. Код ошибки = $error";
         return false;
      }
   }
   
   // Проверить размер файла
   protected function checkSize($filename, $size) 
   {
      if ($size == 0) 
      {
         $this->_messages[] = 
         "Файл $filename очень большой или не выбран";
         return false;
      } 
      elseif ($size > $this->_max) 
      {
         $this->_messages[] = 
         "Файл $filename превышает максимальный размер: ".$this->getMaxSize();
         return false;
      } 
      else 
      {
         return true;
      }
   }
   
   // Проверить тип файла
   protected function checkType($filename, $type) 
   {
      if (empty($type)) 
      {
         $this->_messages[] = 
         "Не определен тип файла загрузки";
         return false;
      } 
      elseif (!in_array($type, $this->_permitted)) 
      {
         $this->_messages[] = 
         "Файл $filename имеет тип, неразрешенный для для загрузки";
         return false;
      } 
      else 
      {
         return true;
      }
   }

  public function addPermittedTypes($types) {
	$types = (array) $types;
    $this->isValidMime($types);
	$this->_permitted = array_merge($this->_permitted, $types);
  }

  public function getFilenames() {
	return $this->_filenames;
  }

  protected function isValidMime($types) {
    $alsoValid = array('image/tiff',
				       'application/pdf',
				       'text/plain',
				       'text/rtf');
  	$valid = array_merge($this->_permitted, $alsoValid);
	foreach ($types as $type) {
	  if (!in_array($type, $valid)) {
		throw new Exception("$type is not a permitted MIME type");
	  }
	}
  }

  protected function checkName($name, $overwrite) {
	$nospaces = str_replace(' ', '_', $name);
	if ($nospaces != $name) {
	  $this->_renamed = true;
	}
	if (!$overwrite) {
	  $existing = scandir($this->_destination);
	  if (in_array($nospaces, $existing)) {
		$dot = strrpos($nospaces, '.');
		if ($dot) {
		  $base = substr($nospaces, 0, $dot);
		  $extension = substr($nospaces, $dot);
		} else {
		  $base = $nospaces;
		  $extension = '';
		}
		$i = 1;
		do {
		  $nospaces = $base . '_' . $i++ . $extension;
		} while (in_array($nospaces, $existing));
		$this->_renamed = true;
	  }
	}
	return $nospaces;
  }

  protected function processFile($filename, $error, $size, $type, $tmp_name, $overwrite) {
	$OK = $this->checkError($filename, $error);
	if ($OK) {
	  $sizeOK = $this->checkSize($filename, $size);
	  $typeOK = $this->checkType($filename, $type);
	  if ($sizeOK && $typeOK) {
		$name = $this->checkName($filename, $overwrite);
		$success = move_uploaded_file($tmp_name, $this->_destination . $name);
		if ($success) {
	      // add the amended filename to the array of filenames
	      $this->_filenames[] = $name;
			$message = "$filename uploaded successfully";
			if ($this->_renamed) {
			  $message .= " and renamed $name";
			}
			$this->_messages[] = $message;
		} else {
		  $this->_messages[] = "Could not upload $filename";
		}
	  }
	}
  }

}

// *** <!-- --> ********************************************* UploadImg.php ***
