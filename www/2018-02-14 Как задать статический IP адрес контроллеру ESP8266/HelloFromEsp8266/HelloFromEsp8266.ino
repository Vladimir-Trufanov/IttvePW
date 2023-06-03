#include <ESP8266WiFi.h>
#include <WiFiClient.h>
#include <ESP8266WebServer.h>

// НЕ ПОЛУЧИЛОСЬ 2023-06-02 !!!

const char* ssid     = "OPPO A9 2020";
const char* password = "b277a4ee84e8";

IPAddress ip(192,168,1,17);  //статический IP
IPAddress gateway(192,168,1,1);
IPAddress subnet(255,255,255,0);

/*
 . Variables and constants in RAM (global, static), used 28672 / 80192 bytes (35%)
║   SEGMENT  BYTES    DESCRIPTION
╠══ DATA     1504     initialized variables
╠══ RODATA   1056     constants       
╚══ BSS      26112    zeroed variables
. Instruction RAM (IRAM_ATTR, ICACHE_RAM_ATTR), used 60375 / 65536 bytes (92%)
║   SEGMENT  BYTES    DESCRIPTION
╠══ ICACHE   32768    reserved space for flash instruction cache
╚══ IRAM     27607    code in IRAM    
. Code in flash (default, ICACHE_FLASH_ATTR), used 270080 / 1048576 bytes (25%)
║   SEGMENT  BYTES    DESCRIPTION
╚══ IROM     270080   code in flash 

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
Compressed 304400 bytes to 221444...
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
Wrote 304400 bytes (221444 compressed) at 0x00000000 in 19.8 seconds (effective 123.1 kbit/s)...
Hash of data verified.

Leaving...
Hard resetting via RTS pin...


 */

ESP8266WebServer server(80);
const int led = 13;

void handleRoot() 
{
  digitalWrite(led, 1);
  server.send(200, "text/plain", "hello from esp8266!");
  digitalWrite(led, 0);
}

void setup(void)
{
  pinMode(led, OUTPUT);
  digitalWrite(led, 0);
  Serial.begin(115200);
  WiFi.begin(ssid, password);
  WiFi.config(ip, gateway, subnet);
  Serial.println("");
  // ожидание соединения
  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }
  Serial.println("");
  Serial.print("Connected to ");
  Serial.println(ssid);
  Serial.print("IP address: ");
  Serial.println(WiFi.localIP());
  server.on("/", handleRoot);
  server.begin();
  Serial.println("HTTP server started");
}

void loop(void){
  server.handleClient();
}
