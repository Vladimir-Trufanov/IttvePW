<?php                                           
// PHP7/HTML5, EDGE/CHROME                                   *** Common.php ***
// ****************************************************************************
// * ittve.pw                                       Блок общесайтовых функций *
// ****************************************************************************

//                                                   Автор:       Труфанов В.Е.
//                                                   Дата создания:  24.02.2018
// Copyright © 2018 tve                              Посл.изменение: 20.04.2021

// ****************************************************************************
// *                      Определить - работаем ли на сайте                   *
// ****************************************************************************
function isIttvepw()
{
   $Result=false;
   if ($_SERVER['HTTP_HOST']=='ittve.pw') $Result=true;
   return $Result;
}
// ****************************************************************************
// *                     Определить - работаем ли на хостинге                 *
// ****************************************************************************
function isNichost()
{ 
   $Result=false;
   if (($_SERVER['HTTP_HOST']=='ittve.pw')||($_SERVER['HTTP_HOST']=='kwinflatht.nichost.ru'))
   {
      $Result=true;
   }
   return $Result;
}
// ************************************************************* Common.php *** 
