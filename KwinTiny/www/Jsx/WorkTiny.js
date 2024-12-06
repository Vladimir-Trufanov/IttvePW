// Выполняем действия  по завершении загрузки страницы
$(document).ready(function()
{
   // 
  $('#nsDate').on('focusin',function()
  {
    $(this).siblings('#nsName').css({
      'z-index'   :'1',
      'background':'rgba(0,0,0,.1)',
    });
     $(this).css({
      'z-index' : '2',
      'background' : '#fff',
      });
  });
  
   $('#nsName').on('focusin',function(){
    $(this).siblings('#nsDate').css({
      'z-index'   :'1',
      'background':'rgba(0,0,0,.1)'
    });
    $(this).css({
      'z-index' : '2',
      'background' : '#fff'
     });
  });
  
  
  $('#nsDate').on('focusout',function(){
    $(this).siblings('#nsName').css({
      'z-index'   :'1',
      'background':'rgba(0,0,0,.1)'
    });
    $(this).css({
      'z-index' : '2',
      'background' : '#fff'
    });
  });
  
   $('#nsName').on('focusout',function(){
    $(this).siblings('#nsDate').css({
      'z-index'   :'1',
      'background':'rgba(0,0,0,.1)'
    });
    $(this).css({
      'z-index' : '2',
      'background' : '#fff'
     });
  });
})


// По клику на кнопке выполнить выбор файла и 
// активировать клик для загрузки файла
function alf1FindFile() 
{
   document.getElementById('infCard').click(); // alf2LoadFile()
} 
// При изменении состояния input file активизировать кнопку "submit" для
// загрузки выбранного файла во временное хранилище на сервере 
function alf2LoadFile() 
{
   // По нажатию кнопки "submit" отправляем запрос из формы на выполнение
   // модуля проверки параметров файла, загруженного во временное хранилище,
   // его переброски на постоянное хранение и переименование  
   document.getElementById('insCard').click(); // "submit"
   // Удаляем старые файлы
   //alfEraseFiles();
}
// Инициировать запись в базу данных изображения и комментария
function alf3SaveImgComm() 
{
   document.getElementById('insCard').click(); // "submit"
} 

/*
function readFile(input) 
{
  file = input.files[0];
  reader = new FileReader();
  reader.readAsText(file);
  reader.onload = function() 
  {
    ss=reader.result;
    console.log(ss);
    $('#imgCardi').attr('src',ss); 
  };
  reader.onerror = function() 
  {
    console.log(reader.error);
  };
  // $('#imgCardi').attr('src',reader.result);
}
*/

/*
// При изменении состояния input file 
function alf2LoadFile(input) 
{
   console.log('Articles.js');
   file = input.files[0];
   nname=file.name;
   ddate=file.lastModified;
   console.log('File name: '+nname); 
   console.log('Last modified: '+ddate); 
   
   niname='ittveEdit/'+nname;
   $('#imgCardi').attr('src',niname); 
   $('.taCard').css('background','yellow');
}

function readFile(input) 
{
  file = input.files[0];
  reader = new FileReader();
  reader.readAsText(file);
  reader.onload = function() 
  {
    ss=reader.result;
    console.log(ss);
    $('#imgCardi').attr('src',ss); 
  };
  reader.onerror = function() 
  {
    console.log(reader.error);
  };
  // $('#imgCardi').attr('src',reader.result);
}
*/

/*
// Готовим обработку события при изменении положения устройства
function doOnOrientationChange()
// http://greymag.ru/?p=175, 07.09.2011. При повороте устройства браузер 
// отсылает событие orientationchange. Это актуально для обеих операционных 
// систем. Но подписка на это событие может осуществляться по разному. 
// При проверке на разных устройствах iPhone, iPad и Samsung GT (Android),
// выяснилось что в iOS срабатывает следующий вариант установки обработчика: 
// window.onorientationchange = handler; А для Android подписка осуществляется 
// иначе: window.addEventListener( 'orientationchange', handler, false ); 
//
// Примечание: В обоих примерах handler - функция-обработчик. Текущую ориентацию
// экрана можно узнать проверкой свойства window.orientation, принимающего одно
// из следующих значений: 0 — нормальная портретная ориентация, -90 —
// альбомная при повороте по часовой стрелке, 90 — альбомная при повороте 
// против часовой стрелки, 180 — перевёрнутая портретная ориентация (пока 
// только для iPad).
//         
// Отследить переворот экрана:
// https://www.cyberforum.ru/javascript/thread2242547.html, 08.05.2018
{
   if ((window.orientation==0)||(window.orientation==180))
   {
      window.location=SignaPortraitUrl;
   } 
   if ((window.orientation==90)||(window.orientation==-90))
   { 
      window.location=SignaUrl;
   }
}
function OnOrientationChange(xOrient) 
{
   // console.log(window.orientation);
   // Если фактически портрет, а кукис ландшафт, то перегружаем на портрет
   if ((window.orientation==0)||(window.orientation==180))
   {
      if (xOrient==oriLandscape) window.location=SignaPortraitUrl;
   } 
   // Если фактически альбом, а кукис портрет, то перегружаем на альбом
   if ((window.orientation==90)||(window.orientation==-90)||(window.orientation==undefined))
   { 
      if (xOrient==oriPortrait) window.location=SignaUrl;
   }
}
// По клику на кнопке выполнить выбор файла и 
// активировать клик для загрузки файла
function alf1FindFile() 
{
   document.getElementById('my_hidden_file').click(); // alf2LoadFile()
} 
// По клику на кнопке  
// активировать клик на форме для подписания файла
function alf1MakeStamp()
{
   document.getElementById('my_Stamp_Do').click(); 
} 
// По клику на кнопке  
// активировать клик на форме для изменения настроек
function alf1Tunein()
{
   document.getElementById('my_Tune_In').click(); 
} 
function alfSubmitTunein()
{
   document.getElementById('my_Tune_Submit').click(); 
   alfEraseFiles();
} 
// ****************************************************************************
// *     Изменить цвет поля ввода процентов смещения штампа в малозаметный,   *
// * указав таким образом пользователю, что при сохранении пропорциональности *
// *                    штампа, данное поле не работает                       *
// ****************************************************************************
function alf1MaintainProp()
{
   if (document.getElementById('MaintainProp').checked) 
   {
      $('.PerSizeImg').css('color','DarkGoldenRod');
      $('#PerSizeInput').css('color','DarkGoldenRod');
      $('#PerSizeImg').html('Процент размера подписи по ширине изображения:');
      $('#MaintainProp').attr('value',ohMaintainTrue);
      $('#MaintainCtrl').attr('value',ohMaintainFalse);
      $('#MaintainCtrl').prop('checked',false);
   } 
   else 
   {
      $('.PerSizeImg').css('color','black'); 
      $('#PerSizeInput').css('color','black');
      $('#PerSizeImg').html('Процент размера подписи к изображению:');
      $('#MaintainCtrl').attr('value',ohMaintainTrue);
      $('#MaintainProp').attr('value',ohMaintainFalse);
      $('#MaintainCtrl').prop('checked',true);
   }   
} 
function alf1sFindFile() 
   {document.getElementById('my_shidden_file').click();} 
function alf2sLoadFile()
{
   document.getElementById('my_shidden_load').click();
   alfEraseFiles();
}
// ****************************************************************************
// *                      Выйти на главную страницу сайта                     *
// ****************************************************************************
function alf1Home()
{
   alfEraseFiles();
   location.replace(urlHome);
}   
// ****************************************************************************
// *   Определить спосов выравнивания ('по ширине','по высоте') изображения   *
// *                                 по диву                                  *
// ****************************************************************************
function getAlignImg(cDiv,cImg,wImg,hImg)
{
   // Определяем размеры дива на экране
   oDiv=document.getElementById(cDiv)
   widthDiv=oDiv.offsetWidth;
   heightDiv=oDiv.offsetHeight;
   // Считаем, что нужно выровнять по ширине
   alignImg='по ширине';
   // Через пропорцию вычисляем высоту     *** widthDiv --> wImg ***
   // растянутого изображения по ширине:   ***        x --> hImg ***
   p_heightDiv=(widthDiv*hImg/wImg);
   // Сравниваем расчетную высоту изображения с высотой дива и,
   // если высота изображения превышает высоту дива,
   // то считаем, что изображение нужно растянуть по высоте
   if (p_heightDiv>heightDiv) alignImg='по высоте';
   return alignImg;
}
// ****************************************************************************
// *     Расчитать изображение по центру дива: cDiv - идентификатор дива,     *
// *                    cImg - идентификатор изображения,                     *
// *  wImg - реальная ширина изображения, hImg - реальная высота изображения  *
// *        mAligne - первичное выравнивание ('по ширине','по высоте'),       *
// *    perWidth - процент ширины изображения от ширины дива (или высоты),    *
// ****************************************************************************
function CalcPicOnDiv(cDiv,cImg,wImg,hImg,mAligne,perWidth)
{
   // Определяем возвращаемый массив
   aCalcPicOnDiv=
   { 
      "widthImg":  32,
      "heightImg": 32,
      "nLeft":     10,
      "nTop":      10
   }
   // Определяем размеры дива на экране
   oDiv=document.getElementById(cDiv)
   widthDiv=oDiv.offsetWidth;
   heightDiv=oDiv.offsetHeight;
   // Выравниваем по ширине
   if (mAligne=='по ширине')
   {
      // Определяем ширину изображения            ***   nWidth --> x        ***
      // в диве из пропорции:                     ***     100% --> widthDiv ***
      widthImg=nWidth*widthDiv/100;
      aCalcPicOnDiv.widthImg=widthImg;
      // Определяем высоту изображения            ***     wImg --> hImg     ***  
      // в диве из пропорции:                     *** widthImg --> x        ***
      heightImg=widthImg*hImg/wImg;
      aCalcPicOnDiv.heightImg=heightImg;
   }
   // Выравниваем по высоте
   else
   {
      // Вначале задаем высоту изображения в диве через проценты
      nHeight=perWidth; 
      // Определяем высоту изображения в диве через пикселы
      heightImg=nHeight*heightDiv/100;
      aCalcPicOnDiv.heightImg=heightImg;
      // Определяем ширину изображения               *** wImg --> hImg      ***
      // в диве через пикселы:                       ***    x --> heightImg ***
      widthImg=wImg*heightImg/hImg;
      aCalcPicOnDiv.widthImg=widthImg;
   } 
   // Центрируем изображение по диву
   aCalcPicOnDiv.nLeft=(widthDiv-widthImg)/2;
   aCalcPicOnDiv.nTop=(heightDiv-heightImg)/2;
   return aCalcPicOnDiv;
}
// ****************************************************************************
// *          Отработать ajax-запрос для удаления старых файлов               *
// ****************************************************************************
function formatDateTime(date) 
{
   dd=date.getDate();
   if (dd < 10) dd = '0' + dd;
   mm = date.getMonth() + 1;
   if (mm < 10) mm = '0' + mm;
   yy = date.getFullYear();
   if (yy < 10) yy = '0' + yy;

   hh=date.getHours();
   if (hh < 10) hh = '0' + hh;
   ii=date.getMinutes();
   if (ii < 10) ii = '0' + ii;
   ss=date.getSeconds();
   if (ss < 10) ss = '0' + ss;
   return yy+'-'+mm+'-'+dd+' '+hh+':'+ii+':'+ss;
}
function alfEraseFiles() 
{
   $.ajax({
      type:'POST',                        // тип запроса
      url: 'ajaEraseFiles.php',           // скрипт обработчика
      dataType: "json",
      data:  {first:1, second:"second"},  // данные которые мы передаем
      cache: true,  // запрошенные страницы кэшировать браузером (задаем явно для IE)
      processData: false,                 // отключаем, так как передаем файл
      // Отмечаем результат выполнения скрипта по аякс-запросу (успешный или нет)
      success:function(data)
      {
         //alert(data[0].text);
      },
      // Отмечаем безуспешное удаление старых файлов
      error:function(data)
      {
         alert(formatDateTime(new Date())+' '+ajUndeletionOldFiles+'!');
      }
   });
} 
*/