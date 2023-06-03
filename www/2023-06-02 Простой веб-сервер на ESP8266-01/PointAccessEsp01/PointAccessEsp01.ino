// Arduino C/C++                                   *** PointAccessEsp01.ino ***

// ****************************************************************************
// * IttvePW           Превратить ESP8266 в точку доступа (AP) и обрабатывать *
// *                            веб-страницы для любого подключенного клиента *
// *    Здесь из HTML-страницы буде зажигать синюю лампочку на Esp8266-01 или *
// *                                                                мигать ею *
// ****************************************************************************

//                                                   Автор:       Труфанов В.Е.
//                                                   Дата создания:  02.06.2023
// Copyright © 2023 tve                              Посл.изменение: 02.06.2023

// Подключаем ESP8266WiFi.h - данная библиотека предоставляет специальные методы 
// ESP8266 для работы с Wi-Fi, которые мы вызываем для подключения к сети
#include <ESP8266WiFi.h>
// Подключаем библиотеку ESP8266WebServer.h, для настроики сервера и 
// обработки HTTP запросов
#include <ESP8266WebServer.h>

// Назначаем имя сети (точке доступа) и пароль
const char* ssid =         "Esculap61";  // SSID
const char* password = "psw-Esculap61";  // пароль

// Настраиваем IP адреса - устанавливаем IP адрес, маску подсети и IP шлюз 
IPAddress local_ip(192,168,  1,1);
IPAddress  gateway(192,168,  1,1);
IPAddress   subnet(255,255,255,0);

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

// Объявляем объект библиотеки ESP8266WebServer для получить доступ к функциям,
// передаем конструктору объекта номер порта (который сервер будет прослушивать). 
// Задаем, как принято по умолчанию для HTTP, порт 80 (теперь при URL-запросе
// к серверу порт можно будет не указывать
ESP8266WebServer server(80);

// Используем штатный светодиод ESP8266-01, соединенный с контактом TX и 
// загрузчиком PL2303-PL2101, который используется для загрузки скетча, а затем 
// при отключенном контакте IO0 остаётся источником питания
#define LED1pin 1
#define LED2pin 2  // убрать после отладки


#define LedShines      1 
#define LedTerminate   2 
#define LedBlink       3  

// Инициируем состояния кнопок
int LedStatus = LedBlink;
bool LED1status = LOW;  // "синяя горит"
bool LED2status = LOW;  // "погашена"
bool LED3status = LOW;  // "синяя мигает"

void setup() 
{
  // Открываем последовательное соединение и устанавливаем порты контакта GPIO
  Serial.begin(115200);
  pinMode(LED1pin, OUTPUT);
  pinMode(LED2pin, OUTPUT);
  // Настраиваем точку доступа для создания сети Wi-Fi, указав SSID, пароль, 
  // IP адрес, маску подсети и адрес шлюза.
  WiFi.softAP(ssid, password);
  WiFi.softAPConfig(local_ip, gateway, subnet);
  // Делаем технологическую задержку
  delay(100);
  
  // Связываем HTTP запросы с обрабатывающими функциями через метод сервера "on"
  // (то есть указываем какой код выполнять, при поступлении определенного 
  // запроса URL. Этот метод принимает два параметра. Первый – это URL путь, а 
  // второй – имя функции, которую мы хотим выполнить.
  
  // Обращаем внимание, что URL-запрос представляет собой относительный путь
  server.on("/", handle_OnConnect);               // запрос по корневому пути
  server.on("/bulb-shines",    handle_shines);    // "лампочка горит"   
  server.on("/bulb-terminate", handle_terminate); // "погашена"
  server.on("/bulb-blink",     handle_blink);     // "мигает"   

  server.on("/led1on", handle_led1on);
  server.on("/led1off", handle_led1off);
  server.on("/led2on", handle_led2on);
  server.on("/led2off", handle_led2off);
  
  // Подключаем обработку неопределенного запроса (если клиент запрашивает 
  // какой-либо URL, отличающийся от указанных в server.on(). Он должен выдать 
  // ответ с HTTP статусом 404 (Not Found, «страница не найдена») и сообщением 
  // для пользователя. Помещаем эти действия в отдельную функцию и используем 
  // метод server.onNotFound()
  server.onNotFound(handle_NotFound);
  
  // Запускаем сервер и отправляем сообщение
  server.begin();
  Serial.println("HTTP server started");
  // Делаем задержку для подключения порта для просмотра процесса
  delay(100);
}

void loop() 
{
  // Настраиваем сервер для принятия запроса
  server.handleClient();
  // Переводим лампочку в заданное состояние
  if(LedStatus==LedBlink) loop_blink();
  else if (LedStatus==LedShines) loop_shines();
  else loop_terminate();

  /*
  if(LED1status)
    digitalWrite(LED1pin, HIGH);
  else
    digitalWrite(LED1pin, LOW);
  
  if(LED2status)
    digitalWrite(LED2pin, HIGH);
  else
    digitalWrite(LED2pin, LOW);
  */
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
  server.send(200, "text/html", SendHTML(LED1status,LED2status,LedStatus)); 
}

void handle_shines() 
{
}

void handle_terminate() 
{
  LedStatus = LedTerminate;
  Serial.println("LedTerminate");
  server.send(200, "text/html", SendHTML(true,LED2status,LedStatus)); 
}

void handle_blink() 
{
}

void handle_led1on() 
{
  LED1status = HIGH;
  Serial.println("GPIO7 Status: ON");
  server.send(200, "text/html", SendHTML(true,LED2status,LedStatus)); 
}

void handle_led1off() 
{
  LED1status = LOW;
  Serial.println("GPIO7 Status: OFF");
  server.send(200, "text/html", SendHTML(false,LED2status,LedStatus)); 
}

void handle_led2on() 
{
  LED2status = HIGH;
  Serial.println("GPIO6 Status: ON");
  server.send(200, "text/html", SendHTML(LED1status,true,LedStatus)); 
}

void handle_led2off() 
{
  LED2status = LOW;
  Serial.println("GPIO6 Status: OFF");
  server.send(200, "text/html", SendHTML(LED1status,false,LedStatus)); 
}

void handle_NotFound()
{
  server.send(404, "text/plain", "Not found");
}

// ****************************************************************************
// *          "Перерисовать страницу" - подготовить строку с разметкой        *
// *                        для нового вывода страницы                        *
// ****************************************************************************
String SendHTML(uint8_t led1stat,uint8_t led2stat,int LedStatus)
{
  String ptr = "<!DOCTYPE html> <html lang=\"ru\">\n";
  ptr +="<head><meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0, user-scalable=no\">\n";
  ptr +="<meta http-equiv=\"content-type\" content=\"text/html; charset=utf-8\">\n";
  ptr +="<title>Управление синей лампочкой</title>\n";
  ptr +="<style>html{font-family:Helvetica; display:inline-block; margin:0px auto; text-align:center;}\n";
  ptr +="body{margin-top:50px;} h1{color:#444444; margin:50px auto 30px;} h3{color:#444444; margin-bottom:50px;}\n";
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
  ptr +="<h3>Используется режим точки доступа</h3>\n";

  // Переводим лампочку в заданное состояние
  if(LedStatus==LedBlink) 
    ptr +="<p>Лампочка блинкует</p>\n";
  else if (LedStatus==LedShines) 
    ptr +="<p>Лампочка горит</p>\n";
  else 
    ptr +="<p>Лампочка погашена</p>\n";

    ptr +="<a class=\"button button-off\" href=\"/bulb-terminate\">выключить</a>\n";

  
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


// ****************************************************************************
// *   "Включить лампочку" - для включения светодиода используется значение   * 
// *    LOW это из-за того, что на ESP-01 активным состоянием является LOW    *
// ****************************************************************************
void loop_shines() 
{
  digitalWrite(LED1pin, LOW); 
}
// ****************************************************************************
// *   "ВЫКЛЮЧИТЬ лампочку" - выключаем светодиод, используя состояние HIGH   *
// ****************************************************************************
void loop_terminate() 
{
  digitalWrite(LED1pin, HIGH);   
}
// ****************************************************************************
// *                            "Мигать лампочкой"                            *
// ****************************************************************************
void loop_blink() 
{
  digitalWrite(LED1pin, LOW); 
  delay(1000); 
  digitalWrite(LED1pin, HIGH); 
  delay(2000);                    
}

// *************************************************** PointAccessEsp01.ino ***
