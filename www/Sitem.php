<?php
// PHP7/HTML5, EDGE/CHROME                                    *** Sitem.php ***

// ****************************************************************************
// * ittve.pw                     В мобильном программировании моё увлечение! *
// ****************************************************************************

//                                                   Автор:       Труфанов В.Е.
//                                                   Дата создания:  23.11.2018
// Copyright © 2018 tve                              Посл.изменение: 23.04.2021

// Устанавливаем режим работы сайта и настройки разметки 
iniMobileSite($c_SiteMode);
markupMobileSite($c_SiteMode,$SiteDevice);

// ****************************************************************************
// *           Установить режим работы сайта и настройки разметки             *
// ****************************************************************************
function iniMobileSite($SiteMode)
{
   if ($SiteMode==rzmMain)
   {
      echo '<style>'; 
      echo '
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
function markupMobileSite($SiteMode)
{
   echo '
   <div data-role = "page" id = "page1">
      <div data-role = "header">
         <h4>Header</h4>
      </div>
      <div role="main" class="ui-content" id="cCenter">
   ';
   require_once 'Pages/cCenter.php';
   echo '
      </div>
      <div data-role = "footer">
         <p>For more information <a href = "#page2">click here</a></p>
      </div>
   </div>
   '; 
   echo '
   <div data-role = "page" id = "page2">
      <div data-role = "header">
         <h4>Header Text</h4>
      </div>
      <div role="main" class="ui-content" id="exPhp">
   ';
   require_once 'Pages/exPhp.php';
   echo '
      </div>
      <div data-role = "footer">
         <p><a href = "#page1">Back to previous page</a></p>
      </div>
   </div>
   ';
}
// ************************************************************** Sitem.php ***
