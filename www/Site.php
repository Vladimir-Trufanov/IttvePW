<?php
// PHP7/HTML5, EDGE/CHROME                                     *** Site.php ***

// ****************************************************************************
// * ittve.pw                                   В программировании моя жизнь! *
// ****************************************************************************

//                                                   Автор:       Труфанов В.Е.
//                                                   Дата создания:  23.11.2018
// Copyright © 2018 tve                              Посл.изменение: 23.04.2021

// Устанавливаем режим работы сайта и настройки разметки 
iniDesktopSite($c_SiteMode);
markupDesktopSite($c_SiteMode,$SiteDevice,$TitleMain,$isCalc);

// ****************************************************************************
// *           Установить режим работы сайта и настройки разметки             *
// ****************************************************************************
function iniDesktopSite($SiteMode)
{
   if ($SiteMode==rzmMain)
   {
      echo '<style>'; 
      echo '
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
// ****************************************************************************
// *                      Сформировать разметку страницы                      *
// ****************************************************************************
function markupDesktopSite($SiteMode,$SiteDevice,$TitleMain,$isCalc)
{
  echo         '<div id="hBlock">';
  require_once 'Pages/hBlock.php';
  echo         '</div>';

  echo         '<div id="lSideTOrSide">';
  
  if ($SiteMode==rzmWithLeft)
  {
    echo          '<div id="lSide">';
    require_once  'Pages/lSide.php';
    echo          '</div>';
  }
  
  echo            '<div id="cCenter">';
  echo            '<h1>'.$TitleMain.'</h1>';
  require_once    'Pages/cCenter.php';
  echo            '</div>';

  echo            '<div id="rSide">';

  if ($SiteMode==rzmCompare)
  {
    echo              '<div class="cSection" id="exLaz">';
    require_once      'Pages/exLaz.php';
    echo              '</div>';

    echo              '<div class="cSection" id="exJav">';
    require_once      'Pages/exJav.php';
    echo              '</div>';
  }
  echo                '<h1>Текст фрагмента программы</h1>';  // "Исходный код, как есть"
  echo                '<div class="cSection" id="exPhp">';
  require_once        'Pages/exPhp.php';
  echo                '</div>';

  echo            '</div>';
  echo         '</div>';

  echo         '<footer id="fBlock">';
  require_once 'Pages/fBlock.php';
  echo         '</footer>';
}


// *************************************************************** Site.php ***
