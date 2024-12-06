// PHP7/HTML5, EDGE/CHROME                             *** ArticlesMaker.js ***

// ****************************************************************************
// * ArticlesMakerClass       Блок функций сопровождения класса на JavaScript *
// *                                                                          *
// * v1.0, 18.02.2023                               Автор:      Труфанов В.Е. *
// * Copyright © 2023 tve                           Дата создания: 09.01.2023 *
// ****************************************************************************

      pathPhpTools="<?php echo pathPhpTools;?>";
      pathPhpPrown="<?php echo pathPhpPrown;?>";
      gncNoCue="<?php echo gncNoCue;?>"; 

      // **********************************************************************
      // *       Проверить целостность базы данных по 16 очередным записям    *
      // **********************************************************************
      function GetPunktTestBase()
      {
         // Выбираем последний проверенный uid
         TestPoint=Number(localStorage.getItem('TestPoint'));
         if (Number.isNaN(TestPoint)) TestPoint=0;
         //console.log('в наче '+TestPoint);
         // Делаем запрос на определение наименования раздела материалов
         pathphp="TestBase.php";
         $.ajax({
            url: pathphp,
            type: 'POST',
            data: {TestPoint:TestPoint, pathTools:pathPhpTools, pathPrown:pathPhpPrown},
            // Выводим ошибки при выполнении запроса в PHP-сценарии
            error: function (jqXHR,exception) {SmarttodoError(jqXHR,exception)},
            // Обрабатываем ответное сообщение
            success: function(message)
            {
               // Вырезаем из запроса чистое сообщение
               messa=FreshLabel(message);
               // Получаем параметры ответа
               parm=JSON.parse(messa);
               // Если ошибка, то выводим сообщение
               if (parm.error==true) Error_Info(parm.messa);
               // Иначе меняем значение проверенного uid-а
               else 
               {
                  //console.log('в коне '+parm.TestPoint);
                  // Отмечаем последний проверенный uid
                  localStorage.setItem('TestPoint',parm.TestPoint);
                  // Выводим сообщение, что все хорошо
                  // Info_Info(parm.messa); 
               }
            }
         });
      }
      // **********************************************************************
      // *        Задать обработчик аякс-запроса по удалению материала        *
      // **********************************************************************
      function UdalitMater(Uid)
      {
         $('#DialogWind').dialog
         ({
            buttons:[{text:"OK",click:function(){xUdalitMater(Uid)}}]
         });
         htmlText="Удалить выбранный материал по "+Uid+"?";
         Notice_Info(htmlText,"Удалить материал");
      }
      function xUdalitMater(Uid)
      {
         // Выводим в диалог предварительный результат выполнения запроса
         htmlText="Удалить статью по "+Uid+" не удалось!";
         // Выполняем запрос на удаление
         pathphp="deleteArt.php";
         // Делаем запрос на определение наименования раздела материалов
         $.ajax({
            url: pathphp,
            type: 'POST',
            data: {idCue:Uid, pathTools:pathPhpTools, pathPrown:pathPhpPrown},
            // Выводим ошибки при выполнении запроса в PHP-сценарии
            error: function (jqXHR,exception) {SmarttodoError(jqXHR,exception)},
            // Обрабатываем ответное сообщение
            success: function(message)
            {
               // Вырезаем из запроса чистое сообщение
               messa=FreshLabel(message);
               // Получаем параметры ответа
               parm=JSON.parse(messa);
               // Выводим результат выполнения
               if (parm.NameArt==gncNoCue) htmlText=parm.NameArt+' Uid='+Uid;
               else htmlText=parm.NameArt;
               $('#DialogWind').html(htmlText);
            }
         });
         // Удаляем кнопку из диалога и увеличиваем задержку до закрытия
         delayClose=1500;
         $('#DialogWind').dialog
         ({
            buttons:[],
            hide:{effect:"explode",delay:delayClose,duration:1000,easing:'swing'},
            title: "Удаление материала",
         });
         // Закрываем окно
         $("#DialogWind").dialog("close");
         // Перезагружаем страницу через 4 секунды
         setTimeout(function() {location.reload();}, 4000);
      }
      // **********************************************************************
      // *  Задать обработчик аякс-запроса по клику выбора раздела материалов *
      // *  при назначении новой статьи:                                      *
      // *         !!! 16.01.2023 - не удалось запускать обработчик из других *
      // *       мест, кроме корневого каталога. Это особенность скорее из-за *
      // *                     того, что работа выполняется в объекте класса. *
      // **********************************************************************
      function SelMatiSection(Uid)
      {
         pathphp="getNameCue.php";
         // Делаем запрос на определение наименования раздела материалов
         $.ajax({
            url: pathphp,
            type: 'POST',
            data: {idCue:Uid, pathTools:pathPhpTools, pathPrown:pathPhpPrown},
            // Выводим ошибки при выполнении запроса в PHP-сценарии
            error: function (jqXHR,exception) {SmarttodoError(jqXHR,exception)},
            // Обрабатываем ответное сообщение
            success: function(message)
            {
               // Вырезаем из запроса чистое сообщение
               messa=FreshLabel(message);
               // Получаем параметры ответа
               parm=JSON.parse(messa);
               $('#Message').html(parm.NameGru+': Указать название и дату для новой статьи');
               $('#nsCue').attr('value',Uid);
               $('#nsGru').attr('value',parm.NameGru);
            }
         });
      }
// ******************************************************* ArticlesMaker.js *** 
