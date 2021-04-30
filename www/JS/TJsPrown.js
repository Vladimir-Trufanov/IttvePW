function MakeCatchyQuotes()
{
   var Result=0;
   $(document).ready(function() 
   {
      $('span.pq').each(function() 
      {
         var quote=$(this).clone();
         quote.removeClass('pq');
         quote.addClass('pullquote');
         $(this).before(quote);
      }); // конец each
   }); // конец ready
   return Result;
}

function getTime(secs) {
	var sep = ':'; //separator character
	var hours,minutes,seconds,time,am_pm;
	var now = new Date();
	hours = now.getHours();
	if (hours < 12) {
		am_pm = 'am';
	} else {
		am_pm = 'pm';
	}
	hours = hours % 12;
	if (hours === 0) {
		hours = 12;
	} 
	time = hours;
	minutes = now.getMinutes();
	if (minutes < 10) {
		minutes = '0' + minutes;
	}
	time += sep + minutes;
	if (secs) {
		seconds = now.getSeconds();
		if (seconds < 10) {
			seconds = '0' + seconds;
		}
		time += sep + seconds;
	} 
	return time + ' ' + am_pm;
}
        
  function TurnOnHotkeys(){
  
      document.onkeydown = function(e) {

      // Ctrl+I  Показать установленные настройки сайта
      if (e.ctrlKey && e.keyCode == 'I'.charCodeAt(0)) 
      {
        document.location.replace("index.php?Com=Sett");
        return false;
      }

      // Ctrl+K  Показать кукисы
      else if (e.ctrlKey && e.keyCode == 'K'.charCodeAt(0)) 
      {
        document.location.replace("index.php?Com=Cook");
        return false;
      }
      
      // Ctrl+P  Распечатать страницу (функцию предоставляет браузер)
 
      // Ctrl+Q  Показать параметры запроса к сайту
      else if (e.ctrlKey && e.keyCode == 'Q'.charCodeAt(0)) 
      {
        document.location.replace("index.php?Com=Parm");
        return false;
      }

      // Ctrl+R  Перегрузить сайт без параметров
      else if (e.ctrlKey && e.keyCode == 'R'.charCodeAt(0)) 
      {
        document.location.replace("index.php?Com=Remv");
        return false;
      }

      // Ctrl+S  Сохранить страницу сайта (функцию предоставляет браузер Chrome‎)

      // Ctrl+Z  Передать значение переменной в PHP
      else if (e.ctrlKey && e.keyCode == 'Z'.charCodeAt(0)) 
      {
        var idi = 1352;
        document.location.replace("index.php?idi="+idi);
        return false;
      }
      
    }
  }
  function getScreenInfo(setconsole=true)
{
// http://qaru.site/questions/83058/getting-the-physical-screen-dimensions-dpi-pixel-density-in-chrome-on-android
var aScreenInfo=[];    // массив данных об окне браузера

// Определяем ширину и высоту экрана в пикселях
// https://www.w3schools.com/js/js_window_screen.asp
var we=window.screen.width;   aScreenInfo.push(we);                      // 0
var he=window.screen.height;  aScreenInfo.push(he);                      // 1
// Определяем доступные ширину и высоту экрана посетителя в пикселях
// (ширина экрана посетителя минус интерфейс функции, такой как панель задач 
// Windows и высота экрана минус интерфейс функции, такие как панель задач 
var wea=window.screen.availWidth;   aScreenInfo.push(wea);               // 2
var hea=window.screen.availHeight;  aScreenInfo.push(hea);               // 3
// Определяем ширину и высоту окна браузера  (не включая панели инструментов ---и 
// полосы прокрутки---) в пикселях https://www.w3schools.com/js/js_window.asp
var wb = window.innerWidth||document.documentElement.clientWidth;
aScreenInfo.push(wb);                                                    // 4
var hb = window.innerHeight||document.documentElement.clientHeight;
aScreenInfo.push(hb);                                                    // 5
// Определяем ширину и высоту клиентской части сайта в окне браузера 
var wcl=document.body.clientWidth;  aScreenInfo.push(wcl);               // 6
var hcl=document.body.clientHeight; aScreenInfo.push(hcl);               // 7
// Определяем номинальные толщины вертикальной и горизонтально полос прокрутки 
var ScrollWidth = wb - wcl;  aScreenInfo.push(ScrollWidth);              // 8
var ScrollHeight = hb - hcl; aScreenInfo.push(ScrollHeight);             // 9
// Определяем соотношение пикселей устройства
var DevicePixelRatio=window.devicePixelRatio||1;                         // 10
aScreenInfo.push(DevicePixelRatio);
// Формируем текстовую строку для консоли
var str = 
[
   'Screen width:  '+we+'px',
   'Screen height: '+he+'px',
   'Screen available width: '+wea+'px',
   'Screen available height: '+hea+'px',
   'Browser width: '+wb+'px',
   'Browser height: '+hb+'px',
   'Client width: '+wcl+'px',   
   'Client height: '+hcl+'px',
   'ScrollWidth: '+ScrollWidth+'px',
   'ScrollHeight: '+ScrollHeight+'px',
   'Device Pixel Ratio: '+DevicePixelRatio
].join('\n');

if (setconsole) console.log(str);
return aScreenInfo;
}
// ****************************************************************************
// *          Установить ширину и спозиционировать div "игровой стол"         *
// *              в окне браузера на заданном текущем устройсте               *
// ****************************************************************************
function MakeScreenInfo(aScreenInfo)
{
   //elem.style.color = 'red';
   var elem = document.getElementById("ScreenWidth");
   elem.innerHTML = aScreenInfo[0];
   elem = document.getElementById("ScreenHeight");
   elem.innerHTML = aScreenInfo[1];
   elem = document.getElementById("availWidth");
   elem.innerHTML = aScreenInfo[2];
   elem = document.getElementById("availHeight");
   elem.innerHTML = aScreenInfo[3];
   elem = document.getElementById("BrowserWidth");
   elem.innerHTML = aScreenInfo[4];
   elem = document.getElementById("BrowserHeight");
   elem.innerHTML = aScreenInfo[5];
   elem = document.getElementById("ClientWidth");
   elem.innerHTML = aScreenInfo[6];
   elem = document.getElementById("ClientHeight");
   elem.innerHTML = aScreenInfo[7];
   elem = document.getElementById("ScrollWidth");
   elem.innerHTML = aScreenInfo[8];
   elem = document.getElementById("ScrollHeight");
   elem.innerHTML = aScreenInfo[9];
   elem = document.getElementById("DevicePixelRatio");
   elem.innerHTML = aScreenInfo[10];
}
