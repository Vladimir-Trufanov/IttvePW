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
      <li><a href="/">ММС Лада-Нива</a>
         <ul>
            <li><a href="?Com=s-chego-vse-nachalos">С чего все началось</a></li>     
            <li><a href="index.php?Com=s-chego-vse-nachalos">А что внутри?</a></li>
            <li><a href="/">Эксперименты со строками</a></li>
         </ul>
      </li>
      <li><a href="/">Стиль</a>
         <ul>
            <li><a href="?Com=ehlementy-stilya-programmirovaniya">Элементы стиля программирования</a></li>
            <li><a href="?Com=pishite-programmy-prosto">Пишите программы просто</a></li>
         </ul>
      </li>
      <li><a href="?Com=s-chego-vse-nachalos">Моделирование</a></li>
      <li><a href="#">Учебники</a></li>
      <li><a href="#">Сайт</a>
         <ul>
            <li><a href="/">Авторизоваться</a></li>
            <li><a href="/">Зарегистрироваться</a></li>
            <li><a href="/">О сайте</a></li>
            <li><a href="/">Редактировать материал</a></li>
            <li><a href="/">Изменить настройки</a></li>
            <li><a href="/">Отключиться</a></li>
         </ul>
      </li>
   </ul>
</nav>
';
}
// *** <!-- --> ************************************************ nBlock.php ***
