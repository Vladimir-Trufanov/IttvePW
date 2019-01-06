<?php

// PHP7/HTML5, EDGE/CHROME                                     *** e404.php ***

// ****************************************************************************
// * KwinFlat.ru                                    Обработать ошибки сервера *
// ****************************************************************************

//                                                   Автор:       Труфанов В.Е.
//                                                   Дата создания:  10.04.2018
// Copyright © 2018 tve                              Посл.изменение: 10.04.2018

// Определяем код ошибки
$status=999;
if (IsSet($_GET['err'])) 
{
    $val=$_GET['err'];
    $reg="/".'\d\d\d'."/u"; 
    if (preg_match($reg,$val,$matches)) 
    {
        $status=intval($matches[0]);
    } 
}
// echo '$status='.$status.' ';

// Формируем массивы сообщений
$codes = array
(
    400 => array('400 Плохой запрос', 'Запрос не может быть обработан из-за синтаксической ошибки'),
    403 => array('403 Запрещено', 'Сервер отказывает в выполнении вашего запроса'),
    404 => array('404 Не найдено', 'Запрашиваемая страница не найдена на сервере'),
    405 => array('405 Метод не допускается', 'Указанный в запросе метод не допускается для заданного ресурса'),
    408 => array('408 Время ожидания истекло', 'Ваш браузер не отправил информацию на сервер за отведенное время'),
    500 => array('500 Внутренняя ошибка сервера', 'Запрос не может быть обработан из-за внутренней ошибки сервера'),
    502 => array('502 Плохой шлюз', 'Сервер получил неправильный ответ при попытке передачи запроса'),
    504 => array('504 Истекло время ожидания шлюза', 'Вышестоящий сервер не ответил за установленное время'),
    999 => array('999 Неопределенная ошибка', 'Код ошибки HTTP/HTTPS неправильный'),
);
$err998  = array('998 Незарегистрированная ошибка', 'Код ошибки '.$status.' незарегистрирован');

// Готовим параметры сообщения об ошибке
$title = $err998[0];
$message = $err998[1];
foreach($codes as $key => $val) 
{
    if ($key==$status) 
    {
        $title = $val[0];
        $message = $val[1];
        break;
    }
}
$time = date("d.m.Y H:i:s"); 


?>
<!DOCTYPE HTML>
<html>

<head>
    <meta charset="utf-8">
    <meta name="robots" content="noindex"/>
    <title>Обработка ошибок сервера</title>
	<link rel="stylesheet" media="screen" href="/Allcss/ContactUs.css">
</head>

<body>
    <div id="Ers">

    <?php
    echo '<ul>';
    echo "<li>$title</li>";
    echo "<li>$message</li>";
    echo "<li> --- </li>";
    //echo "<li>".'Запрошенный Вами URL: http-s://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']."</li>";
    echo "<li>".'Ваш IP: '.$_SERVER['REMOTE_ADDR']."</li>";
    echo "<li>".'Ваш браузер: '. $_SERVER['HTTP_USER_AGENT']."</li>";
    echo "<li>".'Текущая дата и время сервера: '.$time."</li>";

    if (IsSet($_SERVER['HTTP_REFERER'])) 
    {
        echo "<li>"."Вы пришли со страницы: ".$_SERVER['HTTP_REFERER']."</li>";
    }
    if (getenv('HTTP_X_FORWARDED_FOR')) 
    {
        echo "<li>".getenv('HTTP_X_FORWARDED_FOR')."</li>";
    }
    echo '</ul>';
    // \prown\ViewArray($_GET,'$_GET');
    ?>

    </div>
    <div id=\"frmE404\">
    </div> 
</body>
</html>

<?php
// *************************************************************** e404.php ***

