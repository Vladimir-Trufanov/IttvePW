<?php
// PHP7/HTML5, EDGE/CHROME                                   *** nBlock.php ***

// ****************************************************************************
// * ittve.pw                                        Развернуть главное меню  *
// ****************************************************************************

//                                                   Автор:       Труфанов В.Е.
//                                                   Дата создания:  23.11.2018
// Copyright © 2018 tve                              Посл.изменение: 22.04.2021

if ($SiteDevice==Mobile) 
{   
   echo '
   <style>
   #custom-border-radius .ui-btn-icon-notext.ui-corner-all {
    -webkit-border-radius: .3125em;
    border-radius: .3125em;
   }
   </style>
   
   
<a href="#" class="ui-btn ui-icon-delete ui-btn-icon-notext ui-corner-all">No text</a>
<div id="custom-border-radius">
    <a href="#" class="ui-btn ui-icon-delete ui-btn-icon-notext ui-corner-all">No text</a>
</div>
';
}
else
{
   echo '
      <nav id="main-nav">
      <ul id="main-menu" class="sm sm-mint">
   ';
   echo $Menu; // html-текст меню
   echo '
      </ul>
      </nav>
   ';
}
// *** <!-- --> ************************************************ nBlock.php ***
