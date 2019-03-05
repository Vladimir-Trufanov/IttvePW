<?php

/*
$ds = DIRECTORY_SEPARATOR;
$storeFolder = 'uploads'; // Указываем папку для загрузки
if (!empty($_FILES)) 
{ 
    // Проверяем пришли ли файлы от клиента
    $tempFile = $_FILES['file']['tmp_name']; //Получаем загруженные файлы из временного хранилища
    $targetPath = dirname( __FILE__ ) . $ds. $storeFolder . $ds;
    $targetFile =  $targetPath. $_FILES['file']['name'];
    // Перемещаем загруженные файлы из временного хранилища в нашу папку uploads
    move_uploaded_file($tempFile,$targetFile); 
}
*/

$ds          = DIRECTORY_SEPARATOR; 
 
$storeFolder = 'uploads';  
 
if (!empty($_FILES)) {
 
    $tempFile = $_FILES['file']['tmp_name'];         
 
    $targetPath = dirname( __FILE__ ) . $ds. $storeFolder . $ds; 
 
    $targetFile =  $targetPath. $_FILES['file']['name']; 
 
    move_uploaded_file($tempFile,$targetFile);
 
} else {                                                           
    $result  = array();
 
    $files = scandir($storeFolder);                 //1
    if ( false!==$files ) {
        foreach ( $files as $file ) {
            if ( '.'!=$file && '..'!=$file) {       //2
                $obj['name'] = $file;
                $obj['size'] = filesize($storeFolder.$ds.$file);
                $result[] = $obj;
            }
        }
    }
     
    header('Content-type: text/json');              //3
    header('Content-type: application/json');
    echo json_encode($result);
}

?>