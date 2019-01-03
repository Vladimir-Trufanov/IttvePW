
       
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
      
    }
  }

function ScreenInfo33(){
// http://qaru.site/questions/83058/getting-the-physical-screen-dimensions-dpi-pixel-density-in-chrome-on-android
var $el = document.createElement('div');
$el.style.width = '1cm';
$el.style.height = '1cm';
// $el.style.backgroundColor = '#ff0000'; // показали выстроенный DIV
$el.style.position = 'fixed';
$el.style.bottom = 0;
document.body.appendChild($el);

var pxRatio=(window.devicePixelRatio || 1);
var eloffsetWidth=$el.offsetWidth/pxRatio;
var eloffsetHeight=$el.offsetHeight/pxRatio;

var screenDiagonal = Math.sqrt(
   Math.pow((window.screen.width / $el.offsetWidth), 2) +
   Math.pow((window.screen.height / $el.offsetHeight), 2));

var screenDiagonalInches = (screenDiagonal / 2.54);

var str = 
[
   '1cm (W):       '+$el.offsetWidth+'px',
   '1cm (H):       '+$el.offsetHeight+'px',
   '1cm (W):       '+eloffsetWidth+'px',
   '1cm (H):       '+eloffsetHeight+'px',
   'Screen width:  '+window.screen.width+'px',
   'Screen height: '+window.screen.height+'px',
   'Browser width: '+window.innerWidth+'px',
   'Browser height: '+window.innerHeight+'px',
   'Screen available width: '+window.screen.availWidth+'px',
   'Screen available height: '+window.screen.availHeight+'px',
   'Screen width: '+(window.screen.width/$el.offsetWidth).toFixed(2)+'cm',
   'Screen width: '+(window.screen.width/eloffsetWidth).toFixed(2)+'cm',
   'Screen height: '+(window.screen.height/$el.offsetHeight).toFixed(2)+'cm',
   'Screen diagonal: '+screenDiagonal.toFixed(2)+'cm',
   'Screen diagonal: '+screenDiagonalInches.toFixed(2)+'in',
   'Device Pixel Ratio: '+(window.devicePixelRatio || 1)
].join('\n');

var $pre=document.createElement('pre');
$pre.innerHTML=str;
document.body.appendChild($pre);
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