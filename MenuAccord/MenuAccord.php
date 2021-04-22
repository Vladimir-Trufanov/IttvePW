<?php
// PHP7/HTML5, EDGE/CHROME                               *** MenuAccord.php ***

// ****************************************************************************
// * ittve.pw            Меню-аккордеон с дивом для компьютерной версии сайта *
// ****************************************************************************

//                                                   Автор:       Труфанов В.Е.
//                                                   Дата создания:  23.11.2018
// Copyright © 2018 tve                              Посл.изменение: 07.02.2019

?>
   <div id="MenuAccord">
   <ul class="accordion">
   
      <li id="one" class="files"> <a href="#" class="">Мои файлы<span>495</span></a>
         <ul class="sub-menu" style="display: none; ">
         <li><a href="#"><em>01</em>Dropbox<span>42</span></a></li>
         <li><a href="#"><em>02</em>Skydrive При оформлении разделов группы важное значение имеет формат контента<span>87</span></a></li>
         <li><a href="#"><em>03</em>FTP Сервер<span>366</span></a></li>
         <li><a href="#"><em>04</em>Google Drive<span>1</span></a></li>
         <li><a href="#"><em>05</em>Skydrive<span>10</span></a></li>
         <li><a href="index.php?Com=Common">Дом и квартира</a></li>";
         </ul>
      </li>
      
      <li id="two" class="mail"> <a href="#" class="">Обработка исключений<span>26</span></a>
         <ul class="sub-menu" style="display: none; ">
         <li><a href="#"><em>01</em>Gmail<span>9</span></a></li>
         <li><a href="#"><em>02</em>Yandex<span>14</span></a></li>
         </ul>
      </li>
      
      <li id="three" class="cloud"> <a href="#" class="">Библиотеки функций tPROWM функций функций <span>58</span></a>
         <ul class="sub-menu" style="display: none; ">
         <li><a href="#"><em>01</em>Отправка<span>12</span></a></li>
         <li><a href="#"><em>02</em>Сайты<span>19</span></a></li>
         <li><a href="#"><em>03</em>Сделать<span>27</span></a></li>
         <li><a href="#"><em>04</em>Пароли<span>12</span></a></li>
         <li><a href="#"><em>05</em>Профили<span>19</span></a></li>
         <li><a href="#"><em>06</em>Опции<span>27</span></a></li>
         </ul>
      </li>
      
      <li id="four" class="sign"> <a href="#" class="active">Библиотеки классов tTOOLS<span>39</span></a>
         <ul class="sub-menu" style="display: block; ">
         <li><a href="#"><em>01</em>Выход</a></li>
         <li><a href="#"><em>02</em>Удалить профиль</a></li>
         <li><a href="#"><em>03</em>Параметры</a></li>
         </ul>
      </li>
   </ul>
   </div>
   
   <script type="text/javascript">
   $(document).ready(function() {
      var accordion_head = $('.accordion > li > a'),
      accordion_body = $('.accordion li > .sub-menu');
      accordion_head.first().addClass('active').next().slideDown('normal');
      accordion_head.on('click', function(event) {
         event.preventDefault();
		   if ($(this).attr('class') != 'active') {
            accordion_body.slideUp('normal');
            $(this).next().stop(true,true).slideToggle('normal');
            accordion_head.removeClass('active');
            $(this).addClass('active');
         }
      });
   });
   </script>
<?php

// ********************************************************* MenuAccord.php ***
