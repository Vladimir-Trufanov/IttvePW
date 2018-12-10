<?php  
                                         
// PHP7/HTML5, EDGE/CHROME                               *** ViewGlobal.php ***

// ****************************************************************************
// *                  Показать значения глобальных переменных                 *
// ****************************************************************************

//                                                   Автор:       Труфанов В.Е.
//                                                   Дата создания:  30.01.2018
// Copyright © 2018 TVE                              Посл.изменение: 10.02.2018

define ('avgAll',0);        // Все массивы
define ('avgSERVER',1);     // Информация о сервере и среде исполнения $_SERVER
define ('avgGET',2);        // Массив параметров $_GET, явно переданных скрипту через URL 
define ('avgPOST',4);       // Массив параметров, скрыто переданных скрипту $_POST 
define ('avgCOOKIE',8);     // Массив значений $_COOKIE, переданных скрипту через HTTP Cookies
define ('avgREQUEST',16);   // Массив \$_REQUEST, по умолчанию содержащий переменные \$_GET,\$_POST,\$_COOKIE
define ('avgSESSION',32);   // Переменные сессии, которые доступны для текущего скрипта $_SESSION
define ('avgFILES',64);     // Элементы $_FILES, загруженные в текущий скрипт через метод HTTP POST
define ('avgENV',128);      // Массив значений, переданных скрипту через переменные окружения \$_ENV
define ('avgGLOBALS',256);  // Ссылки на все переменные глобальной области видимости $GLOBALS 

// Вывести шапку таблицы                          
function ViewCaption($Caption)
{
    echo "   
    <style>
    h2 
    {
        background: white;
    }
    .vgTABLE 
    {
        font-size: 1.2em;
        background: yellow;
    }
    </style>
    "; 
    
    echo "<h2>".$Caption."</h2>";
    echo "<table class=\"vgTABLE\" width=\"100%\">";
    echo "<tr>";
    echo "<th class=\"vgKey\">ПАРАМЕТР</th>";
    echo "<th class=\"vgValue\">ЗНАЧЕНИЕ</th>";
    echo "</tr>";
}
	
// Вывести данные массива
function ViewMiddle($aArray,$Name)
{
    foreach($aArray as $key => $value)
    {
        echo 
        "<tr>".
        "<td class=\"vgKey\">".$Name." [\"".$key."\"]"."</td>".
        "<td class=\"vgValue\">".$value."</td>".
        "<tr>";
    }
}
	
// Вывести подвал таблицы                      
function ViewEnd()
{
    echo "</table>";
}

// Вывести таблицу                      
function ViewArr($Caption,$aArray,$Name)
{
    ViewCaption($Caption); ViewMiddle($aArray,$Name); ViewEnd();
}

// Показать значения глобальных переменных 
function ViewGlobal($Parm)
{
    if ($Parm=='avgCOOKIE')
    {
        ViewArr("Массив значений \$_COOKIE, переданных скрипту через HTTP Cookies",$_COOKIE,"\$_COOKIE");
    }
    
    elseif ($Parm=='avgREQUEST')
    {
        ViewArr("Массив \$_REQUEST, содержащий переменные \$_GET, \$_POST, \$_COOKIE",$_REQUEST,"\$_REQUEST");
    }
    
    elseif ($Parm=='avgGET')
    {
        ViewArr("Массив параметров \$_GET, явно переданных скрипту через URL",$_GET,"\$_GET");
    }
    elseif ($Parm=='avgSESSION')
    {
        //echo "<h2>".$Caption."</h2>";
        if (IsSet($_SESSION))
        ViewArr("Переменные сессии, которые доступны для текущего скрипта \$_SESSION",$_SESSION,"\$_SESSION");
    }
}


// ViewArr("Информация о сервере и среде исполнения \$_SERVER",$_SERVER,"\$_SERVER");
// 
// ViewArr("Массив параметров, скрыто переданных скрипту \$_POST",$_POST,"\$_POST");

// ViewArr("Элементы \$_FILES, загруженные в текущий скрипт через метод HTTP POST",$_FILES,"\$_FILES");
/*
The problem occurs when you have a form that uses both single file and HTML array feature. 
The array isn't normalized and tends to make coding for it really sloppy. 
I have included a nice method to normalize the $_FILES array.

<?php
  function normalize_files_array($files = []) {
    $normalized_array = [];
	foreach($files as $index => $file) {
      if (!is_array($file['name'])) {
        $normalized_array[$index][] = $file;
        continue;
      }
      foreach($file['name'] as $idx => $name) {
        $normalized_array[$index][$idx] = [
          'name' => $name,
          'type' => $file['type'][$idx],
          'tmp_name' => $file['tmp_name'][$idx],
          'error' => $file['error'][$idx],
          'size' => $file['size'][$idx]
        ];
      }
    }
    return $normalized_array;
  }
?>
*/


// ViewArr("Массив значений, переданных скрипту через переменные окружения \$_ENV",$_ENV,"\$_ENV");
// ViewArr("Ссылки на все переменные глобальной области видимости \$GLOBALS",$GLOBALS,"\$GLOBALS");

// ********************************************************* ViewGlobal.php ***

