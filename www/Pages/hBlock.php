<?php
// PHP7/HTML5, EDGE/CHROME                                   *** nBlock.php ***

// ****************************************************************************
// * ittve.pw                                   В программировании моя жизнь! *
// ****************************************************************************

//                                                   Автор:       Труфанов В.Е.
//                                                   Дата создания:  23.11.2018
// Copyright © 2018 tve                              Посл.изменение: 24.02.2019

?>
<!-- -->
<div id="Buttons">
   <button class="btnItPW" id="btnMenu">
      <img class="imgItPW" src="Images/Buttons/Menu.svg" height="32">
      Menu
   </button>
   <button class="btnItPW" id="btnLazi">
      <img class="imgItPW" src="Images/Buttons/Lazarus.svg" height="32"> 
      Lazarus
   </button>
   <button class="btnItPW" id="btnJava">
      <img class="imgItPW" src="Images/Buttons/Java.svg" height="32">
      Java
   </button>
      <button class="btnItPW" id="btnPhp">
      <img class="imgItPW" src="Images/Buttons/Php.svg" height="32"> 
      Php
   </button>
</div>
      
<div id="Informs">
   <nav id="pLine">
   <?php 
      echo " ".$PersName." ".$_SESSION['Counter'].".".$PersEntry."[".$BrowEntry."]"; 
   ?>
   </nav>
   <nav id="tLine">
   <?php 
      // echo $SiteDevice.': '.$SiteRoot.'-'.$SiteAbove.'-'.$SiteHost; 
      // echo $SiteDevice.': '.$uagent.'<br>';
      echo $SiteDevice;
   ?>
   </nav>
</div>

<?php
// ************************************************************* nBlock.php ***
