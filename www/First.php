<?php

 // Включить и создать экземпляр класса.
require_once 'Mobile_Detect.php' ;
$detect = new Mobile_Detect ;  

$MobileDevice='Computer'; 
// Любое мобильное устройство (телефоны или планшеты).
if ($detect -> isMobile()) 
{   
   $MobileDevice='MobileDevice'; 
}
// Любой планшет.
if ($detect -> isTablet()) 
{ 
   $MobileDevice='Tablet'; 
}

 $uagent=$_SERVER['HTTP_USER_AGENT'];
 //if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$uagent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($uagent,0,4)))
 //   header('location: http://site.ru/mobile/');



                                            
// PHP7/HTML5, EDGE/CHROME                                     *** Main.php ***

// ****************************************************************************
// * KwinFlat.ru                                  Развернуть главную страницу *
// ****************************************************************************

//                                                   Автор:       Труфанов В.Е.
//                                                   Дата создания:  23.11.2018
// Copyright © 2018 tve                              Посл.изменение: 26.11.2018

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
   <!-- -->
   <head>
      <title>В программировании моя жизнь!</title>
      <meta charset="utf-8">
      <link rel="stylesheet" type="text/css" href="Allcss/Styles.css">
   </head>
   <body>

      <div id="hBlock">
         <nav id="pLine">
            Параметры сайта по алфавиту = <?php echo $MobileDevice.': '.$uagent ?>
         </nav>
         <nav class="cNav" id="tLine">
            Навигация в глубину сайта
         </nav>
      </div>

      <div id="lSideTOrSide">
      <aside id="lSide">
         <p>Разум — это Будда, а прекращение умозрительного мышления — это путь. 
         Перестав мыслить понятиями и размышлять о путях существования и небытия, 
         о душе и плоти, о пассивном и активном и о других подобных вещах, 
         начинаешь осознавать, что разум — это Будда, 
         что Будда — это сущность разума, 
         и что разум подобен бесконечности.</p>
         
         <!-- Див с меню и скрипт его обработки -->
         <div id="wrapper">
         
	         <ul class="accordion">
		      <li id="one" class="files"> <a href="#" class="">Мои файлы<span>495</span></a>
			   <ul class="sub-menu" style="display: none; ">
				   <li><a href="#"><em>01</em>Dropbox<span>42</span></a></li>
				   <li><a href="#"><em>02</em>Skydrive При оформлении разделов группы важное значение имеет формат контента<span>87</span></a></li>
				   <li><a href="#"><em>03</em>FTP Сервер<span>366</span></a></li>
				   <li><a href="#"><em>04</em>Google Drive<span>1</span></a></li>
				   <li><a href="#"><em>05</em>Skydrive<span>10</span></a></li>
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
            
		      <li id="four" class="sign"> <a href="#" class="active">Библиотеки классов tTOOLS<span>58</span></a>
			   <ul class="sub-menu" style="display: block; ">
				   <li><a href="#"><em>01</em>Выход</a></li>
				   <li><a href="#"><em>02</em>Удалить профиль</a></li>
				   <li><a href="#"><em>03</em>Параметры</a></li>
			   </ul>
		      </li>
	         </ul>
         </div>
         
         <script type="text/javascript" src="js/jquery-2.0.1.js"></script>
         <script type="text/javascript">
         $(document).ready(function() {			
	      var accordion_head = $('.accordion > li > a'),
		   accordion_body = $('.accordion li > .sub-menu');
	      accordion_head.first().addClass('active').next().slideDown('normal');
	      accordion_head.on('click', function(event) {			
		   event.preventDefault();
		   if ($(this).attr('class') != 'active'){
			accordion_body.slideUp('normal');
			$(this).next().stop(true,true).slideToggle('normal');
			accordion_head.removeClass('active');
			$(this).addClass('active');
		   }
	      });
         });
         </script>

      </aside>

      <article id="cCenter">
         <h1>Основная тема страницы</h1>
При оформлении разделов группы важное значение имеет формат контента. Например, оптимальным форматом для прайс-листов и расписаний является таблица. Сегодня я расскажу, как сделать таблицу с помощью вики-разметки. 
1. Откройте нужную вам страницу в режиме редактирования (кнопка справа вверху страницы). 
2. Убедитесь, что включен режим редактирования вики-кода (наведите курсор мыши на значок <> в правом верхнем углу. Если всплывет текст Режим визуального редактирования, оставьте как есть, если всплывет Режим wiki-разметки, нажмите на значок). 
3. Теперь начнем создавать таблицу. Тег начала строки таблицы выглядит вот так: 
|- 
Он вставляется в отдельную строчку. 
4. Тег начала ячейки (столбца) строки выглядит вот так: 
| 
Он вставляется в начале строки перед содержимым. Сколько ячеек – столько строк со знаком |. 
Код строки из трех столбцов будет выглядеть вот так: 
|- 
|содержимое 
|содержимое 
|содержимое 
Это одна строка, все остальные строки таблицы будут выглядеть аналогично, соответственно, их можно размножить копированием (ctrl+c ctrl+v) К сожалению, сделать таблицу с разным числом столбцов в разных ячейках невозможно. 
5. После того, как вы заполните всю таблицу, нужно поставить в начале и в конце таблицы на отдельных строках теги начала ({|) и конца (|}) таблицы соответственно. 
Вот так будет выглядеть код таблицы из трех строк по три столбца: 
код вики таблицы 
Вот так будет выглядеть результат: 
содержимое	содержимое	содержимое
содержимое	содержимое	содержимое
содержимое	содержимое	содержимое
6. Сохраните полученный результат. В таком формате вы легко сможете при необходимости отредактировать вашу таблицу, потому что для каждой ячейки создана отдельная строка: все просто, понятно и, главное, наглядно. Перед началом работы с таблицей убедитесь, что включен режим редактирования вики-кода. 
Если вам нужна таблица, с количеством строк и столбцов не больше пяти, вы можете воспользоваться готовыми шаблонами, скопировав их из текстового документа: 
СКАЧАТЬ ШАБЛОНЫ ВИКИ-ТАБЛИЦ 
Этот способ создания таблицы удобен, если вам нужно составить ее с нуля. Но если у вас уже есть готовая таблица в документе Word, проще будет перенести ее по-другому. Об этом вы можете прочитать в статье Как сделать вики таблицу из таблицы в MS Word. 
Хотите больше полезных статей, уроков и шаблонов?
Примите посильное участие в развитии проекта.
      </article>

      <aside id="rSide">
         <section class="cSection" id="exLaz">
            <h1>Примеры на Lazarus</h1>
            https://ru.wikipedia.org/wiki/Lazarus Lazarus — открытая среда разработки программного обеспечения на языке Object Pascal для компилятора Free Pascal (часто используется сокращение FPC — Free Pascal Compiler, бесплатно распространяемый компилятор языка программирования Pascal). Интегрированная среда разработки предоставляет возможность кроссплатформенной разработки приложений в Delphi-подобном окружении.
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
            <h1>Примеры на JavaAndroid</h1>
            https://stfalcon.com/ru/blog/post/android-developer-java-review Что же такое Java и откуда она к нам пришла? А пришла она к нам с далёкого 1995. Поначалу язык назывался Oak («дуб»), разрабатывал его бородатый Джеймсон Гослинг для программирования бытовых электронных устройств. В дальнейшем получил язык название Java, которое, по одной из версий, происходит от марки элитного кофе. Помните логотип?
Приложения Java обычно транслируются в специальный байт-код, поэтому они могут работать на любой виртуальной Java-машине вне зависимости от компьютерной архитектуры.
Моё изучение Java началось с разработки приложения под Android. Разработчиков, которые специализировались в этой сфере, поблизости не было, потому многое оставалось без внимания просто по причине незнания о существовании тех или иных вещей.
Думаю, каждый оказывался в ситуации, когда ты понимаешь, что что-то в твоем коде не так. Имея огромное желание это исправить, ты начинаешь искать ответ на вопрос, который не можешь сформулировать, да еще и подсказать некому...
В этой статье я попробую собрать все особенности программирования на Java для Android, которые в свое время мне пришлось выискивать в безграничной сети. Возможно, кому-то они покажутся очевидными, но мне в свое время такая подборка фишек Java очень бы помогла. Надеюсь, все же найдутся те, кому это пригодится :).
         </section>
         
         <section class="cSection" id="exPhp">
            <h1>Примеры на PHP</h1>
            http://www.php.su/php/?php Если вы только начинаете знакомиться с PHP, то вам нужно знать определения. Итак, что же такое PHP?
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
      </aside>
      </div>

      <footer id="fBlock">
         Copyright, TinyMce, обратная связь
         <p>Copyright © 2018 tve </p>
         <p>Контакты: <a href="mailto:tve58@inbox.ru">tve58@inbox.ru</a></p>
            <!-- 

         Сайты для мобильных устройств
Поисковые системы улучшают выдачу результатов поиска для пользователей мобильных устройств (смартфонов, планшетов). Таким пользователям вероятнее всего будет показан сайт с адаптивным дизайном, динамической версткой страниц, мобильная версия сайта или Турбо-страница.

Сайт с адаптивным дизайном
Динамическая верстка страниц
Турбо-страница
Мобильная версия сайта (отдельный домен или поддомен)
Общие рекомендации
Ниже представлены рекомендации для вебмастеров вне зависимости от выбранного способа адаптации сайта.

Ресурсы должны быть доступны для индексирующего робота Яндекса: Mozilla/5.0 (iPhone; CPU iPhone OS 8_1 like Mac OS X) AppleWebKit/600.1.4 (KHTML, like Gecko) Version/8.0 Mobile/12B411 Safari/600.1.4 (compatible; YandexBot/3.0; +http://yandex.com/bots). Разрешите в файле robots.txt сканирование CSS, JavaScript, от которых зависит отображение сайта на мобильных устройствах. Иначе страницы сайта могут некорректно отображаться в результатах поиска.
Страницы сайта должны отправлять серверу ответ с HTTP-кодом 200 OK. Вы можете проверить ответ сервера в Яндекс.Вебмастере.
Не используйте технологии Flash, Silverlight или Applet на страницах, ориентированных на мобильных пользователей — эти технологии могут не поддерживаться на мобильных устройствах.

Совет. Например, пользователи не смогут просмотреть интерактивную часть сайта или видеоролик, встроенные на Flash. Поэтому рекомендуем встраивать контент с помощью HTML5 или отказаться от тяжелых и сложных интерактивных элементов.
Размещайте контент вашего сайта таким образом, чтобы он был максимально виден на экране мобильного устройства.
Содержимое страниц не должно выходить за рамки экрана по горизонтали.
Размер текста в пикселях должен быть таким, чтобы весь текст удобно читался на экране мобильного устройства.
       -->
      </footer>

   </body> 
</html>

<?php

// *************************************************************** Main.php ***
