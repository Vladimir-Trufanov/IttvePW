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
            Примеры на Lazarus. https://ru.wikipedia.org/wiki/Lazarus Lazarus — открытая среда разработки программного обеспечения на языке Object Pascal для компилятора Free Pascal (часто используется сокращение FPC — Free Pascal Compiler, бесплатно распространяемый компилятор языка программирования Pascal). Интегрированная среда разработки предоставляет возможность кроссплатформенной разработки приложений в Delphi-подобном окружении.
Позволяет достаточно несложно переносить Delphi-программы с графическим интерфейсом в различные операционные системы: Linux, FreeBSD, Mac OS X, Microsoft Windows, Android[1]. Начиная с Delphi XE2 в самом Delphi имеется возможность компиляции программ для Mac OS X, с версии XE4 — для iOS, с версии XE5 — для Android, с версии 10.2 Tokyo — для Linux (x64).
Основан на библиотеке визуальных компонентов Lazarus Component Library (LCL). В настоящее время практически полностью поддерживает виджеты Win32, GTK1, GTK2, Carbon, Qt. В разработке находятся виджеты WinCE[2].
Поддерживает преобразование проектов Delphi
Реализован основной набор элементов управления
Редактор форм и инспектор объектов максимально приближены к Delphi
Интерфейс отладки (используется внешний отладчик GDB)
Простой переход для Delphi программистов благодаря близости LCL к VCL
Полностью юникодный (UTF-8) интерфейс и редактор и поэтому отсутствие проблем с портированием кода, содержащего национальные символы
Мощный редактор, включающий систему подсказок, гипертекстовую навигацию по исходным текстам, автозавершение и рефакторинг
Форматирование исходного текста «из коробки», используя механизмы Jedi Code Format
Поддержка двух стилей ассемблера: Intel и AT&T (поддерживаются со стороны компилятора)
Поддержка множества типов синтаксиса Pascal: Object Pascal, Turbo Pascal, Mac Pascal, Delphi (поддерживаются со стороны компилятора)
Имеет собственный формат управления пакетами
Авто сборка самого себя (под новую библиотеку виджетов) нажатием одной кнопки
Поддерживаемые для компиляции ОС: Linux, Microsoft Windows (Win32, Win64), Mac OS X, FreeBSD, WinCE, OS/2
         </section>
         
         <section class="cSection" id="exJav">
            Примеры на JavaAndroid. https://stfalcon.com/ru/blog/post/android-developer-java-review Что же такое Java и откуда она к нам пришла? А пришла она к нам с далёкого 1995. Поначалу язык назывался Oak («дуб»), разрабатывал его бородатый Джеймсон Гослинг для программирования бытовых электронных устройств. В дальнейшем получил язык название Java, которое, по одной из версий, происходит от марки элитного кофе. Помните логотип?
Приложения Java обычно транслируются в специальный байт-код, поэтому они могут работать на любой виртуальной Java-машине вне зависимости от компьютерной архитектуры.
Моё изучение Java началось с разработки приложения под Android. Разработчиков, которые специализировались в этой сфере, поблизости не было, потому многое оставалось без внимания просто по причине незнания о существовании тех или иных вещей.
Думаю, каждый оказывался в ситуации, когда ты понимаешь, что что-то в твоем коде не так. Имея огромное желание это исправить, ты начинаешь искать ответ на вопрос, который не можешь сформулировать, да еще и подсказать некому...
В этой статье я попробую собрать все особенности программирования на Java для Android, которые в свое время мне пришлось выискивать в безграничной сети. Возможно, кому-то они покажутся очевидными, но мне в свое время такая подборка фишек Java очень бы помогла. Надеюсь, все же найдутся те, кому это пригодится :).
         </section>
         
         <section class="cSection" id="exPhp">
            Примеры на PHP. http://www.php.su/php/?php Если вы только начинаете знакомиться с PHP, то вам нужно знать определения. Итак, что же такое PHP?
PHP – это широко используемый язык сценариев общего назначения с открытым исходным кодом.
Говоря проще, PHP это язык программирования, специально разработанный для написания web-приложений (сценариев), исполняющихся на Web-сервере.
Аббревиатура PHP означает “Hypertext Preprocessor (Препроцессор Гипертекста)". Синтаксис языка берет начало из C, Java и Perl. PHP достаточно прост для изучения. Преимуществом PHP является предоставление web-разработчикам возможности быстрого создания динамически генерируемых web-страниц. Подробнее о преимуществах PHP можно узнать здесь.
Важным преимуществом языка PHP перед такими языками, как языков Perl и C заключается в возможности создания HTML документов с внедренными командами PHP. Подробнее об этой возможность смотрите здесь.
Значительным отличием PHP от какого-либо кода, выполняющегося на стороне клиента, например, JavaScript, является то, что PHP-скрипты выполняются на стороне сервера. Вы даже можете сконфигурировать свой сервер таким образом, чтобы HTML-файлы обрабатывались процессором PHP, так что клиенты даже не смогут узнать, получают ли они обычный HTML-файл или результат выполнения скрипта.
PHP позволяет создавать качественные Web-приложения за очень короткие сроки, получая продукты, легко модифицируемые и поддерживаемые в будущем.
PHP прост для освоения, и вместе с тем способен удовлетворить запросы профессиональных программистов.
Даже если Вы впервые услышали о PHP, изучить этот язык не составит для Вас большого труда. Мы не сомневаемся, что изучив основы PHP в течение нескольких часов, вы уже сможете создавать простые PHP-скрипты.
Язык PHP постоянно совершенствуется, и ему наверняка обеспечено долгое доминирование в области языков web -программирования, по крайней мере, в ближайшее время.
         </section>
      </div>
      
      <footer class="cFooter" id="fBlock">
         Copyright, TinyMce, обратная связь
      </footer>

   </body> 
</html>

<?php

// *************************************************************** Main.php ***
