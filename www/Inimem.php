<?php 
// PHP7/HTML5, EDGE/CHROME                                   *** Inimem.php ***

// ****************************************************************************
// * ittve.pw                    Произвести установки общесайтовых переменных *
// ****************************************************************************

//                                                   Автор:       Труфанов В.Е.
//                                                   Дата создания:  03.12.2018
// Copyright © 2018 tve                              Посл.изменение: 12.12.2018

// Определяем сайтовые константы
define ("Atfirst",    "atf");    // Перевести расчет в начальные условия  
define ("ChangeSize", "chs");    // "Изменить размер базового шрифта"  
define ("Computer", "Computer"); // "Устройство, запросившее сайт - компьютер"  
define ("Mobile", "Mobile");     // "Устройство, запросившее сайт - смартфон"  
define ("Tablet", "Tablet");     // "Устройство, запросившее сайт - планшет"  

// Инициализируем общесайтовые переменные
$uagent=$_SERVER['HTTP_USER_AGENT'];    // HTTP_USER_AGENT
$SiteDevice=prown\getSiteDevice();      // 'Computer','Mobile','Tablet'

// ************************************************************* Inimem.php *** 
