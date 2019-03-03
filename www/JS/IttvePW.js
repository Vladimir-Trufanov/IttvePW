

function ScreenInfo33(){
// http://qaru.site/questions/83058/getting-the-physical-screen-dimensions-dpi-pixel-density-in-chrome-on-android
var $el = document.createElement('div');
$el.style.width = '10cm';
$el.style.height = '1cm';
//$el.style.display = 'none';
$el.style.backgroundColor = '#ff00ff'; // показали выстроенный DIV
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

function download()
{
    var text = document.getElementById("my-textarea").value;
    var blob = new Blob([text], { type: "text/plain"});
    var anchor = document.createElement("a");
    anchor.download = "my-filename.txt";
    anchor.href = window.URL.createObjectURL(blob);
    anchor.target ="_blank";
    anchor.style.display = "none"; // just to be safe!
    document.body.appendChild(anchor);
    anchor.click();
    document.body.removeChild(anchor);
 }