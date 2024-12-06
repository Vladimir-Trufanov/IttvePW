<?php
// PHP7/HTML5, EDGE/CHROME                             *** iniWorkSpace.php ***
// ****************************************************************************
// *         Cформировать массив параметров рабочего пространства сайта       *
// ****************************************************************************

//                                                   Автор:       Труфанов В.Е.
//                                                   Дата создания:  31.01.2020
// Copyright © 2020 TVE                              Посл.изменение: 22.07.2021

// Определяем константы перечня элементов массива рабочего пространства 
define ("wsSiteRoot",      0);          // Корневой каталог сайта 
define ("wsSiteAbove",     1);          // Надсайтовый каталог
define ("wsSiteHost",      2);          // Каталог хостинга
define ("wsSiteDevice",    3);          // 'Computer' | 'Mobile' | 'Tablet'
define ("wsUserAgent",     4);          // HTTP_USER_AGENT
define ("wsTimeRequest",   5);          // Время запроса сайта
define ("wsRemoteAddr",    6);          // IP-адрес запроса сайта
define ("wsSiteName",      7);          // Доменное имя сайта
define ("wsPhpVersion",    8);          // Версия PHP
define ("wsSiteProtocol",  9);          // HTTP или HTTPS
define ("wsUrlHome",      10);          // Начальная страница сайта
// Формируем массив параметров рабочего пространства сайта 
// и соответствующие глобальные переменные
function iniWorkSpace()
{
   $SiteRoot=$_SERVER['DOCUMENT_ROOT'];  // Корневой каталог сайта
   $SiteAbove=Above($SiteRoot);          // Надсайтовый каталог
   $SiteHost=Above($SiteAbove);          // Каталог хостинга
   include_once($SiteHost.'/TPhpPrown/TPhpPrown/CommonPrown.php');
   include_once($SiteHost.'/TPhpPrown/TPhpPrown/WorkSpace/getSiteDevice.php');
   $_WORKSPACE=array
   (
      wsSiteRoot      => $SiteRoot,  
      wsSiteAbove     => $SiteAbove, 
      wsSiteHost      => $SiteHost, 
      wsSiteDevice    => getSiteDevice(),  // 'Computer' | 'Mobile' | 'Tablet'
      wsUserAgent     => $_SERVER['HTTP_USER_AGENT'],    
      wsTimeRequest   => $_SERVER['REQUEST_TIME'],    
      wsRemoteAddr    => $_SERVER['REMOTE_ADDR'],    
      wsSiteName      => $_SERVER['HTTP_HOST'],    
      wsPhpVersion    => prown\getPhpVersion(), 
      wsSiteProtocol  => isProtocol(), 
      wsUrlHome       => isProtocol().'://'.$_SERVER['HTTP_HOST'], 
   );
   return $_WORKSPACE;
}   
// ****************************************************************************
// *        По абсолютному пути каталога выделить вышестоящий каталог         *
// ****************************************************************************
function Above($SiteRoot)
{
   $Result=$SiteRoot;
   $Point=strrpos($Result,'\\');
   if ($Point==0) 
	{
      $Point=strrpos($Result,'/');
      if ($Point>0) {$Result=substr($SiteRoot,0,$Point);}
   }
   else 
	{
      $Result=substr($SiteRoot,0,$Point);
   }
   return $Result;
}
// ****************************************************************************
// *    Определить соответствует ли текущий сайт заданному доменному имени    *
// *  (в случае, когда указано доменное имя отладочного сайта, то определить  *
// *                    является ли текущий сайт отладочным)                  *
// ****************************************************************************
function isHost($SiteName,$kwinflatht_nichost_ru='')
{
   //print_r('$SiteName='.$SiteName.'<br>');
   //print_r('$kwinflatht_nichost_ru='.$kwinflatht_nichost_ru.'<br>');
   $Result=false;
   // Вначале проверяем сайт по доменному имени в $_SERVER['HTTP_HOST'] 
   $regexp='/'.$SiteName.'/'; 
   // Выполняем регулярное выражение и получаем результаты поиска
   preg_match($regexp,$_SERVER['HTTP_HOST'],$aMatches,PREG_OFFSET_CAPTURE);
   if (isMatches($aMatches)) $Result=true;
   // При необходимости проверяем отладочный сайт
   else if (strlen($kwinflatht_nichost_ru)>0)
   {
      $regexp='/'.$kwinflatht_nichost_ru.'/'; 
      // Выполняем регулярное выражение и получаем результаты поиска
      preg_match($regexp,$_SERVER['HTTP_HOST'],$aMatches,PREG_OFFSET_CAPTURE);
      if (isMatches($aMatches)) $Result=true;
   }
   return $Result;
}
// Функция preg_match в случае неудачного поиска возвращает пустой массив
// или массив вида  Array([0]=>Array([0]=> ''       [1]=>0)), 
// а при удаче      Array([0]=>Array([0]=>$SiteName [1]=>0)) 
function isMatches($aMatches)
{
   $Result=false;
   if (count($aMatches)>0)
   {
      if ($aMatches[0][0]>'')
      { 
         $Result=true;
      }
   }
   return $Result;
}
// ****************************************************************************
// *                Определить тип протокола сайта 'HTTP' или 'HTTPS'         *
// ****************************************************************************
// http://reset.name/php/php-opredelit-https-ili-http-ispolzuetsja-pri-podkljuchenii/
function isProtocol()
{
   if($_SERVER["SERVER_PORT"] == 443)
      $protocol = 'https';
   elseif (isset($_SERVER["HTTPS"]) && (($_SERVER["HTTPS"] == 'on') || ($_SERVER["HTTPS"] == '1')))
      $protocol = 'https';
   elseif (
   !empty($_SERVER["HTTP_X_FORWARDED_PROTO"]) && $_SERVER["HTTP_X_FORWARDED_PROTO"] == 'https' || 
   !empty($_SERVER["HTTP_X_FORWARDED_SSL"]) && $_SERVER["HTTP_X_FORWARDED_SSL"] == 'on')
      $protocol = 'https';
   elseif (strtolower(substr($_SERVER["SERVER_PROTOCOL"],0,5)) == 'https')
      $protocol = 'https';
   else
      $protocol = 'http';
   return $protocol;
}
// ******************************************************* iniWorkSpace.php ***
 
