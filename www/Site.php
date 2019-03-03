<?php
// PHP7/HTML5, EDGE/CHROME                                     *** Site.php ***

// ****************************************************************************
// * ittve.pw                                   В программировании моя жизнь! *
// ****************************************************************************

//                                                   Автор:       Труфанов В.Е.
//                                                   Дата создания:  23.11.2018
// Copyright © 2018 tve                              Посл.изменение: 23.02.2019

?>

<div id="hBlock">
   <?php
      require_once "Pages/hBlock.php";
   ?>
</div>

<div id="lSideTOrSide">

   <aside id="lSide">
      <?php
         require_once "Pages/lSide.php";
      ?>
   </aside>
   
   <article id="cCenter">
      <?php
         require_once "Pages/cCenter.php";
      ?>
   </article>
   
   <aside id="rSide">
      <section class="cSection" id="exLaz">
         <?php
            require_once "Pages/exLaz.php";
         ?>
      </section>
      <section class="cSection" id="exJav">
         <?php
            require_once "Pages/exJav.php";
         ?>
      </section>
      <section class="cSection" id="exPhp">
         <?php
            require_once "Pages/exPhp.php";
         ?>
      </section>
</div>

<footer id="fBlock">
   <div id="Fooleft">
      Copyright, TinyMce, обратная связь
      <p>Copyright © 2018 tve </p>
      <p>Контакты: <a href="mailto:tve58@inbox.ru">tve58@inbox.ru</a></p>
   </div>
   <div id="Fooright">
      <form id="frmTiny" method="get" action="/TinyMCE/Tiny.php"></form>
      <button class="btnItPW" id="btnTiny" form="frmTiny">
         <img class="imgItPW" src="Images/Buttons/Tiny.svg" height="32">
         Tiny
      </button>
   </div>
</footer>

<?php
// *************************************************************** Site.php ***
