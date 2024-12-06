<?php
// PHP7/HTML5, EDGE/CHROME                                    *** index.php ***

// ****************************************************************************
// *                                            KwinTiny-редактор материалов! *
// ****************************************************************************

//                                                   Автор:       Труфанов В.Е.
//                                                   Дата создания:  23.01.2019
// Copyright © 2019 tve                              Посл.изменение: 18.10.2022

// $page="/Tiny4711.php";
// $page="/Tiny5001.php";
// $page="/Tiny581.php";
$page="/TinyItTve.php";
Header("Location: http://".$_SERVER['HTTP_HOST'].$page);


//echo '<img src="data:image/jpeg;base64,'.base64_encode(file_get_contents("test.jpg")).'"/>';

/*
header("Content-type: image/jpeg"); 
$file = base64_encode(file_get_contents("test.jpg")); 
echo(base64_decode($file)); 
*/

/*
header("Content-type: image/jpeg");  
echo file_get_contents("test.jpg"); 
*/

// ************************************************************** index.php ***
