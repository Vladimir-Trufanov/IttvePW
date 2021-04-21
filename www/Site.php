<?php
// PHP7/HTML5, EDGE/CHROME                                     *** Site.php ***

// ****************************************************************************
// * ittve.pw                                   В программировании моя жизнь! *
// ****************************************************************************

//                                                   Автор:       Труфанов В.Е.
//                                                   Дата создания:  23.11.2018
// Copyright © 2018 tve                              Посл.изменение: 21.04.2021

// Устанавливаем режим работы сайта и настройки разметки 
iniSiteMode($c_SiteMode);

// Загружаем разметку
echo         '<div id="hBlock">';
require_once 'Pages/hBlock.php';
echo         '</div>';

echo         '<div id="lSideTOrSide">';

echo            '<div id="lSide">';
require_once    'Pages/lSide.php';
echo            '</div>';

echo            '<div id="cCenter">';
require_once    'Pages/cCenter.php';
echo            '</div>';

echo            '<div id="rSide">';

echo                '<div class="cSection" id="exLaz">';
require_once        'Pages/exLaz.php';
echo                '</div>';

echo                '<div class="cSection" id="exJav">';
require_once        'Pages/exJav.php';
echo                '</div>';

echo                '<div class="cSection" id="exPhp">';
require_once        'Pages/exPhp.php';
echo                '</div>';

echo            '</div>';
echo         '</div>';

echo         '<footer id="fBlock">';
require_once 'Pages/fBlock.php';
echo         '</footer>';

// ****************************************************************************
// *           Установить режим работы сайта и настройки разметки             *
// ****************************************************************************
function iniSiteMode($SiteMode)
{
   if ($SiteMode==rzmMain)
   {
      echo '<style>'; 
      echo '
         #lSide{display:none;}
         #exLaz{display:none;}
         #exJav{display:none;}
         #rSide{width:50%;}
         #cCenter
         {width:50%; border-right:dashed 0.1rem rgb(153,153,153);}
      ';
      echo'</style>';
   }
   else if ($SiteMode==rzmCompare)
   {
   } 
   else
   {
   }
   $Result=true;
   return $Result;
}

// *************************************************************** Site.php ***
