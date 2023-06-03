#include <ESP8266WiFi.h>
#include <ESP8266WebServer.h>

/* Установите здесь свои SSID и пароль */
const char* ssid = "NodeMCU";       // SSID
const char* password = "12345678";  // пароль

/* Настройки IP адреса */
IPAddress local_ip(192,168,1,1);
IPAddress gateway(192,168,1,1);
IPAddress subnet(255,255,255,0);

/*
. Variables and constants in RAM (global, static), used 29984 / 80192 bytes (37%)
║   SEGMENT  BYTES    DESCRIPTION
╠══ DATA     1504     initialized variables
╠══ RODATA   2360     constants       
╚══ BSS      26120    zeroed variables
. Instruction RAM (IRAM_ATTR, ICACHE_RAM_ATTR), used 60375 / 65536 bytes (92%)
║   SEGMENT  BYTES    DESCRIPTION
╠══ ICACHE   32768    reserved space for flash instruction cache
╚══ IRAM     27607    code in IRAM    
. Code in flash (default, ICACHE_FLASH_ATTR), used 270352 / 1048576 bytes (25%)
║   SEGMENT  BYTES    DESCRIPTION
╚══ IROM     270352   code in flash  

 
 */

ESP8266WebServer server(80);

//uint8_t LED1pin = D7;
#define LED1pin 1
bool LED1status = LOW;

//uint8_t LED2pin = D6;
#define LED2pin 2
bool LED2status = LOW;

void setup() 
{
  Serial.begin(115200);
  pinMode(LED1pin, OUTPUT);
  pinMode(LED2pin, OUTPUT);

  WiFi.softAP(ssid, password);
  WiFi.softAPConfig(local_ip, gateway, subnet);
  delay(100);
  
  server.on("/", handle_OnConnect);
  server.on("/led1on", handle_led1on);
  server.on("/led1off", handle_led1off);
  server.on("/led2on", handle_led2on);
  server.on("/led2off", handle_led2off);
  server.onNotFound(handle_NotFound);
  
  server.begin();
  Serial.println("HTTP server started");
}

void loop() 
{
  server.handleClient();
  if(LED1status)
    digitalWrite(LED1pin, HIGH);
  else
    digitalWrite(LED1pin, LOW);
  
  if(LED2status)
    digitalWrite(LED2pin, HIGH);
  else
    digitalWrite(LED2pin, LOW);
}

void handle_OnConnect() 
{ 
  Serial.print("GPIO7 Status: ");
  if(LED1status)
    Serial.print("ON");
  else
    Serial.print("OFF");

  Serial.print(" | GPIO6 Status: ");
  if(LED2status)
    Serial.print("ON");
  else
    Serial.print("OFF");

  Serial.println("");
  server.send(200, "text/html", SendHTML(LED1status,LED2status)); 
}

void handle_led1on() 
{
  LED1status = HIGH;
  Serial.println("GPIO7 Status: ON");
  server.send(200, "text/html", SendHTML(true,LED2status)); 
}

void handle_led1off() 
{
  LED1status = LOW;
  Serial.println("GPIO7 Status: OFF");
  server.send(200, "text/html", SendHTML(false,LED2status)); 
}

void handle_led2on() 
{
  LED2status = HIGH;
  Serial.println("GPIO6 Status: ON");
  server.send(200, "text/html", SendHTML(LED1status,true)); 
}

void handle_led2off() 
{
  LED2status = LOW;
  Serial.println("GPIO6 Status: OFF");
  server.send(200, "text/html", SendHTML(LED1status,false)); 
}

void handle_NotFound()
{
  server.send(404, "text/plain", "Not found");
}

String SendHTML(uint8_t led1stat,uint8_t led2stat)
{
  String ptr = "<!DOCTYPE html> <html>\n";
  ptr +="<head><meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0, user-scalable=no\">\n";
  ptr +="<title>LED Control</title>\n";
  ptr +="<style>html { font-family: Helvetica; display: inline-block; margin: 0px auto; text-align: center;}\n";
  ptr +="body{margin-top: 50px;} h1 {color: #444444;margin: 50px auto 30px;} h3 {color: #444444;margin-bottom: 50px;}\n";
  ptr +=".button {display: block;width: 80px;background-color: #1abc9c;border: none;color: white;padding: 13px 30px;text-decoration: none;font-size: 25px;margin: 0px auto 35px;cursor: pointer;border-radius: 4px;}\n";
  ptr +=".button-on {background-color: #1abc9c;}\n";
  ptr +=".button-on:active {background-color: #16a085;}\n";
  ptr +=".button-off {background-color: #34495e;}\n";
  ptr +=".button-off:active {background-color: #2c3e50;}\n";
  ptr +="p {font-size: 14px;color: #888;margin-bottom: 10px;}\n";
  ptr +="</style>\n";
  ptr +="</head>\n";
  ptr +="<body>\n";
  ptr +="<h1>ESP8266 Web Server</h1>\n";
  ptr +="<h3>Using Access Point(AP) Mode</h3>\n";
  
  if(led1stat)
    ptr +="<p>LED1 Status: ON</p><a class=\"button button-off\" href=\"/led1off\">OFF</a>\n";
  else
    ptr +="<p>LED1 Status: OFF</p><a class=\"button button-on\" href=\"/led1on\">ON</a>\n";

  if(led2stat)
    ptr +="<p>LED2 Status: ON</p><a class=\"button button-off\" href=\"/led2off\">OFF</a>\n";
  else
    ptr +="<p>LED2 Status: OFF</p><a class=\"button button-on\" href=\"/led2on\">ON</a>\n";

  ptr +="</body>\n";
  ptr +="</html>\n";
  return ptr;
}
