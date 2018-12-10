<?php
// PHP7/HTML5, EDGE/CHROME                                     *** ittve.pw ***

// ****************************************************************************
// *                                            В программировании моя жизнь! *
// ****************************************************************************

//                                                   Автор:       Труфанов В.Е.
//                                                   Дата создания:  23.11.2018
// Copyright © 2018 tve                              Посл.изменение: 03.12.2018

// Выполняем начальную инициализацию
//require_once $_SERVER['DOCUMENT_ROOT']."/TPHPPROWN/GetAbove.php";
require_once "iGetAbove.php";
require_once "Inimem.php";

// Подключаем рабочие модули
require_once $SiteHost."/TPhpPrown/ViewArray.php";
require_once $SiteHost."/TPhpPrown/ViewGlobal.php";
//require_once "ViewGlobal.php";
//require_once "ViewArray.php";

// Разворачиваем страницу
require_once "iHtmlBegin.php";

?>
   <!-- -->

      <div id="hBlock">
         <nav id="pLine">
            Параметры сайта по алфавиту = 
            <?php 
               echo $MobileDevice.': '.$SiteRoot.'-'.$SiteAbove.'-'.$SiteHost 
               // echo $uagent
            ?>
         </nav>
         <nav class="cNav" id="tLine">
            Навигация в глубину сайта hhhh jj
         </nav>
         
         <?php prown\ViewGlobal('avgREQUEST'); ?>

         
      </div>

      <div id="lSideTOrSide">
      <aside id="lSide">
         <p>Разум — это Будда, а прекращение умозрительного мышления — это путь. 
         Перестав мыслить понятиями и размышлять о путях существования и небытия, 
         о душе и плоти, о пассивном и активном и о других подобных вещах, 
         начинаешь осознавать, что разум — это Будда, 
         что Будда — это сущность разума, 
         и что разум подобен бесконечности.</p>

         <?php
         if ($MobileDevice<>'MobileDevice')
         {   
            require_once "MenuAccord.php";
         }
         ?>
      </aside>

      <article id="cCenter">
          
  <ul>
    <li>Ctrl-E для начала редактирования.</li>
    <li>Во время редактирования: Ctrl-S для сохранения, Esc для отмены.</li>
  </ul>

  HTML разрешён.

  <textarea id="area"></textarea>
  <div id="view">Текст</div>

  <script>
    document.onkeydown = function(e) {
      if (e.keyCode == 27) { // escape
        cancel();
        return false;
      }

      if ((e.ctrlKey && e.keyCode == 'E'.charCodeAt(0)) && !area.offsetHeight) {
        edit();
        return false;
      }

      if ((e.ctrlKey && e.keyCode == 'S'.charCodeAt(0)) && area.offsetHeight) {
        save();
        return false;
      }
    }

    function edit() {
      view.style.display = 'none';
      area.value = view.innerHTML;
      area.style.display = 'block';
      area.focus();
    }

    function save() {
      area.style.display = 'none';
      view.innerHTML = area.value;
      view.style.display = 'block';
    }

    function cancel() {
      area.style.display = 'none';
      view.style.display = 'block';
    }
  </script>

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
            <h1>Пример на Lazarus</h1>
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
            <h1>Пример на JavaAndroid</h1>
            https://stfalcon.com/ru/blog/post/android-developer-java-review Что же такое Java и откуда она к нам пришла? А пришла она к нам с далёкого 1995. Поначалу язык назывался Oak («дуб»), разрабатывал его бородатый Джеймсон Гослинг для программирования бытовых электронных устройств. В дальнейшем получил язык название Java, которое, по одной из версий, происходит от марки элитного кофе. Помните логотип?
Приложения Java обычно транслируются в специальный байт-код, поэтому они могут работать на любой виртуальной Java-машине вне зависимости от компьютерной архитектуры.
Моё изучение Java началось с разработки приложения под Android. Разработчиков, которые специализировались в этой сфере, поблизости не было, потому многое оставалось без внимания просто по причине незнания о существовании тех или иных вещей.
Думаю, каждый оказывался в ситуации, когда ты понимаешь, что что-то в твоем коде не так. Имея огромное желание это исправить, ты начинаешь искать ответ на вопрос, который не можешь сформулировать, да еще и подсказать некому...
В этой статье я попробую собрать все особенности программирования на Java для Android, которые в свое время мне пришлось выискивать в безграничной сети. Возможно, кому-то они покажутся очевидными, но мне в свое время такая подборка фишек Java очень бы помогла. Надеюсь, все же найдутся те, кому это пригодится :).
         </section>
         
         <section class="cSection" id="exPhp">
            <h1>Пример на PHP</h1>
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
<?php
require_once "iHtmlEnd.php";

// *************************************************************** ittve.pw ***
