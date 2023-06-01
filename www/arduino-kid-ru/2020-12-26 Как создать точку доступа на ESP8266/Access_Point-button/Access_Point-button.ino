#include <ESP8266WiFi.h>
#include <WiFiClient.h>
#include <ESP8266WebServer.h>

/*
  Компиляция:
  
. Variables and constants in RAM (global, static), used 29336 / 80192 bytes (36%)
║   SEGMENT  BYTES    DESCRIPTION
╠══ DATA     1508     initialized variables
╠══ RODATA   1668     constants       
╚══ BSS      26160    zeroed variables
. Instruction RAM (IRAM_ATTR, ICACHE_RAM_ATTR), used 59951 / 65536 bytes (91%)
║   SEGMENT  BYTES    DESCRIPTION
╠══ ICACHE   32768    reserved space for flash instruction cache
╚══ IRAM     27183    code in IRAM    
. Code in flash (default, ICACHE_FLASH_ATTR), used 268144 / 1048576 bytes (25%)
║   SEGMENT  BYTES    DESCRIPTION
╚══ IROM     268144   code in flash   

 Загрузка:

 esptool.py v3.0
Serial port COM4
Connecting....
Chip is ESP8266EX
Features: WiFi
Crystal is 26MHz
MAC: fc:f5:c4:88:91:ed
Uploading stub...
Running stub...
Stub running...
Configuring flash size...
Auto-detected Flash size: 1MB
Compressed 302656 bytes to 220157...
Writing at 0x00000000... (7 %)
Writing at 0x00004000... (14 %)
Writing at 0x00008000... (21 %)
Writing at 0x0000c000... (28 %)
Writing at 0x00010000... (35 %)
Writing at 0x00014000... (42 %)
Writing at 0x00018000... (50 %)
Writing at 0x0001c000... (57 %)
Writing at 0x00020000... (64 %)
Writing at 0x00024000... (71 %)
Writing at 0x00028000... (78 %)
Writing at 0x0002c000... (85 %)
Writing at 0x00030000... (92 %)
Writing at 0x00034000... (100 %)
Wrote 302656 bytes (220157 compressed) at 0x00000000 in 19.7 seconds (effective 123.2 kbit/s)...
Hash of data verified.

Leaving...
Hard resetting via RTS pin...

COM4:
*/

#ifndef APSSID
#define APSSID "Esculap61"     // "System Access"
#define APPSK  "psw-Esculap61" // "Password"
#endif

const char *ssid = APSSID;
const char *password = APPSK;

ESP8266WebServer server(80);

#define LED 1
int statusLED = HIGH; // Начальный статус светодиода ВЫКЛЮЧЕН. Светодиод инверсный

const String HtmlHtml = "<html><head><meta charset=\"utf-8\">"
"<meta name=\"viewport\" content=\"width=device-width, initial-scale=1\" /></head>";
const String HtmlTitle = "<h1>Мигаем системным светодиодом из созданной точки доступа</h1><br/>\n";
const String HtmlLedStateLow = "<big>Светодиод <b>Включен</b></big><br/><br/>\n";
const String HtmlLedStateHigh = "<big>Светодиод <b>Выключен</b></big><br/><br/>\n";
const String HtmlButtons = 
"<a href=\"LEDOff\"><button style=\"background-color:red;color:white;width:20%;height:5%;\">Выключить </button></a>\n"
"<a href=\"LEDOn\"><button style=\"background-color:green;color:white;width:20%;height:5%;\">Включить </button></a><br/>";
const String HtmlHtmlClose = "</html>";

void handleLedOn() {
  statusLED = HIGH; // conditions to make the LED turn on
  digitalWrite(LED, statusLED);
  Serial.println("Светодиод >Выключен");
  response();
}

void handleLedOff() {
  statusLED = LOW; // conditions to make the LED turn off
  digitalWrite(LED, statusLED);
  Serial.println("Светодиод Включен");
  response();
}

void response(){
  String htmlRes = HtmlHtml + HtmlTitle;
  if(statusLED == LOW){
    htmlRes += HtmlLedStateLow;
  }else{
    htmlRes += HtmlLedStateHigh;
  }
 
  htmlRes += HtmlButtons;
  htmlRes += HtmlHtmlClose; 
  server.send(200, "text/html", htmlRes);
}
 
void setup() {
    delay(1000); 
    WiFi.softAP(ssid, password); 
    IPAddress apip = WiFi.softAPIP();     
    server.on("/", response); 
    server.on("/LEDOff", handleLedOn);
    server.on("/LEDOn", handleLedOff); 
    server.begin();    
    pinMode(LED, OUTPUT);
    digitalWrite(LED, statusLED);
}
 
void loop() {
    server.handleClient();
}
