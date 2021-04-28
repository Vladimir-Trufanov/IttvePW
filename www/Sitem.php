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
markupMobileSite($c_SiteMode,$SiteDevice,$TitleMain,$isCalc);

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
function markupMobileSite($SiteMode,$SiteDevice,$TitleMain,$isCalc)
{
   echo '
   <div data-role = "page" id = "page1">
      <div data-role = "header">
         <div data-role="controlgroup" data-type="horizontal"> 
         <div id="bTasks" class="dibtn">
         <a href="https://kwinflat.ru"><i class="fa fa-tasks fa-lg" aria-hidden="true"> </i></a>
         </div>
   ';
   echo  '<div id="cTitle"> <h1>'.$TitleMain.'</h1></div>';
   echo '
         <div id="bHandoright" class="dibtn">
         <a href="#"><i class="fa fa-hand-o-right fa-lg" aria-hidden="true"> </i></a>
         </div>
         </div>
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
         <div data-role="controlgroup" data-type="horizontal"> 
         <div id="bTasks" class="dibtn">
         <a href="https://kwinflat.ru"><i class="fa fa-hand-o-left fa-lg" aria-hidden="true"> </i></a>
         </div>
   ';
   echo  '<div id="cTitle"> <h1>Текст фрагмента программы</h1></div>';
   echo '
         <div id="bHandoright" class="dibtn">
         <a href="#"><i class="fa fa-sign-out fa-lg" aria-hidden="true"> </i></a>
         </div>
         </div>
      </div>
      <div role="main" class="ui-content" id="exPhp">
   ';
   //require_once 'Pages/exPhp.php';
   //require_once 'Pages/MobIcons.php';
   require_once 'Pages/DisplayParm.php';
   echo '
      </div>
      <div data-role = "footer">
         <p><a href = "#page1">Back to previous page</a></p>
      </div>
   </div>
   ';
}
// *** <!-- --> ************************************************* Sitem.php ***
