<?php                                           
// PHP7/HTML5, EDGE/CHROME                                     *** Main.php ***

// ****************************************************************************
// * KwinFlat.ru                                  Развернуть главную страницу *
// ****************************************************************************

//                                                   Автор:       Труфанов В.Е.
//                                                   Дата создания:  01.11.2016
// Copyright © 2016 TVE                              Посл.изменение: 05.03.2018

/*
// Объявляем и инициируем сайтовые переменные
require_once $_SERVER['DOCUMENT_ROOT']."/TPHPPROWN/GetAbove.php";
require_once $_SERVER['DOCUMENT_ROOT']."/TPHPPROWN/MakeCookie.php";
require_once $_SERVER['DOCUMENT_ROOT']."/VerifyParm.php";
require_once $_SERVER['DOCUMENT_ROOT']."/Common.php";
require_once $_SERVER['DOCUMENT_ROOT']."/Inimem.php";

// Подключаем рабочие модули
require_once $SiteRoot."/TException/ExceptionClass.php";
require_once $SiteRoot."/TException/UserMessages.php";
require_once $SiteRoot."/IniMenu.php";

require_once $SiteRoot."/TPHPPROWN/OutFit.php";
require_once $SiteRoot."/TPHPPROWN/NoZero.php";
require_once $SiteRoot."/TPHPPROWN/regx.php";
require_once $SiteRoot."/TPHPPROWN/ViewGlobal.php";
require_once $SiteRoot."/TPHPPROWN/ViewArray.php";
require_once $SiteRoot."/TPHPPROWN/StringFilters.php";
require_once $SiteRoot."/TPHPPROWN/Number1string.php";
require_once $SiteRoot."/TPHPPROWN/CtrlNumber.php";
require_once $SiteRoot."/TPHPPROWN/CtrlArray.php";
require_once $SiteRoot."/TPHPPROWN/PullArray.php";
require_once $SiteRoot."/TPHPPROWN/isCountArrays.php";
require_once $SiteRoot."/TPHPPROWN/SqueezeArrays.php";
require_once $SiteRoot."/TPHPPROWN/TestNumerical.php";
require_once $SiteRoot."/TPHPPROWN/isSubstrInUri.php";

require_once $SiteRoot.'/TDomikva/DomikvaClass.php';
require_once $SiteRoot.'/TViewNach/VerifyNach.php';
require_once $SiteRoot.'/TViewNach/ViewNachClass.php';
require_once $SiteRoot.'/TViewLgo/ViewLgoClass.php';
require_once $SiteRoot.'/TRefbooks/RefbooksClass.php';
require_once $SiteRoot.'/TViewLaws/ViewLawsClass.php';

require_once $SiteRoot.'/TViewNorms/ViewNormsClass.php';
require_once $SiteRoot.'/TViewNorms/getNorms.php';

require_once $SiteRoot."/Codif.php";
require_once $SiteRoot."/IniCtrlObj.php";
require_once $SiteRoot."/IniSeoTags.php";
require_once $SiteRoot."/ShowLgo.php";
require_once $SiteRoot."/ShowNch.php";
require_once $SiteRoot."/ShowCommon.php";

// Подключаем динамические страницы с SEO-тегами, H1 и вступлениями
if (isComRequest('refNormotop'))
    require $SiteRoot.'/Pages/Normativy_po_otopleniyu.php';
elseif (isComRequest('Norms'))
    require $SiteRoot.'/Pages/Sotsialnyye_normy_ploshchadi_zhilya.php';
else
    require $SiteRoot.'/Pages/Other_Main.php';
*/    

/*
// Определяем, следуем ли инициировать начальные условия расчетов
$Atfirst=Inane;
if (IsSet($_GET['Com'])) 
{                                      
    if ($_GET['Com']=='Atfirst')
    {
        $Atfirst=Atfirst;
    }
}
// Изменяем высоту дива инструкции                       *
IniHeightInstr($wi);
// Инициируем параметры расчета
IniCtrlObj($db,$Domik,$Nch,$Lgo,$Ref,$Law,$Norm,$Comm,$Atfirst);
// Инициируем SEO-теги и начало главной страницы
IniSeoTags();
echo "<div id=\"notes\" style=\"max-height: ".$wi."rem\">";

// Формируем заголовок H1, настраиваем плюс-минус и
// выводим текстовое наполнение динамической страницы
макеh1();
IniPlusMinus(Instr);
intro();

// Заполняем страницу браузера
echo "</div>";
*/
?>

<!DOCTYPE html>
<html>
   <head>
      <title>В программировании моя жизнь!</title>
      <meta charset="utf-8">
   </head>
   <body>
      <p>Разум — это Будда, а прекращение умозрительного мышления — это путь. 
      Перестав мыслить понятиями и размышлять о путях существования и небытия, 
      о душе и плоти, о пассивном и активном и о других подобных вещах, 
      начинаешь осознавать, что разум — это Будда, 
      что Будда — это сущность разума, 
      и что разум подобен бесконечности.</p>
      
      <header class="cHeader" id="hBlock">
         Это header
      </header>
      
      <details class="cDetails" id="pLine">
         Параметры сайта по алфавиту
      </details>
      
      <nav class="cNav" id="tLine">
         Навигация в глубину сайта
      </nav>

      <div id="lSide">
         Левый блок краткого меню и новостей
         
         <menu id="waMenu">
            Меню - кратко
         </menu>
         
         <article id="waNews">
            Новости
         </article>                                        
      </div>

      <div id="cCenter">
         Основная тема страницы
      </div>

      <div id="rSide">
         Примеры в разных системах программирования
         <section class="cSection" id="exLaz">
            Примеры на Lazarus
         </section>
         <section class="cSection" id="exJav">
            Примеры на JavaAndroid
         </section>
         <section class="cSection" id="exPhp">
            Примеры на PHP
         </section>
      </div>
      
      <footer class="cFooter" id="fBlock">
         Copyright, TinyMce, обратная связь
      </footer>

   </body> 
</html>

<?php

// *************************************************************** Main.php ***
