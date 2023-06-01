/*
 * Если компиляция не проходит, то нужно: 
 * - в настройках подключить ссылку для менеджера плат: http://arduino.esp8266.com/stable/package_esp8266com_index.json
 * - в менеджере плат выбрать ESP8266 Boards плату Generic ESP8266 Module
*/

/* Компиляция с Esp01 выдала след.текст:

. Variables and constants in RAM (global, static), used 28328 / 80192 bytes (35%)
║   SEGMENT  BYTES    DESCRIPTION
╠══ DATA     1496     initialized variables
╠══ RODATA   1096     constants       
╚══ BSS      25736    zeroed variables
. Instruction RAM (IRAM_ATTR, ICACHE_RAM_ATTR), used 59747 / 65536 bytes (91%)
║   SEGMENT  BYTES    DESCRIPTION
╠══ ICACHE   32768    reserved space for flash instruction cache
╚══ IRAM     26979    code in IRAM    
. Code in flash (default, ICACHE_FLASH_ATTR), used 239140 / 1048576 bytes (22%)
║   SEGMENT  BYTES    DESCRIPTION
╚══ IROM     239140   code in flash   

Загрузка добавила:

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
Compressed 272864 bytes to 200580...
Writing at 0x00000000... (7 %)
Writing at 0x00004000... (15 %)
Writing at 0x00008000... (23 %)
Writing at 0x0000c000... (30 %)
Writing at 0x00010000... (38 %)
Writing at 0x00014000... (46 %)
Writing at 0x00018000... (53 %)
Writing at 0x0001c000... (61 %)
Writing at 0x00020000... (69 %)
Writing at 0x00024000... (76 %)
Writing at 0x00028000... (84 %)
Writing at 0x0002c000... (92 %)
Writing at 0x00030000... (100 %)
Wrote 272864 bytes (200580 compressed) at 0x00000000 in 17.9 seconds (effective 121.7 kbit/s)...
Hash of data verified.

Leaving...
Hard resetting via RTS pin...

Протокол сканирования (работы программы):

начало сканирования
Настройка выполнена
9 сети найдены
1: linksystve (-56)*
2: DOOM (-89)*
3: Citylink-9 (-79)*
4: Citylink-109 (-90)*
5: sampo (-71)*
6: Tenda_1C8688 (-79) 
7: netis (-83)*
8: linksystve (-29)*
9: TP-Link_31A6 (-87)*

*/

#include "ESP8266WiFi.h"
void setup() {
  Serial.begin(115200);
  WiFi.mode(WIFI_STA);
  WiFi.disconnect();
  delay(100);
  Serial.println("Настройка выполнена");
}
void loop() {
  Serial.println("начало сканирования");
  // Запускаем штатную функцию сканирования сетей
  int n = WiFi.scanNetworks();
  Serial.println("Настройка выполнена");
  if (n == 0) {
    Serial.println("сети не найдены");
  } else {
    Serial.print(n);
    Serial.println(" сети найдены");
    // Выводим в цикле все найденные сети
    for (int i = 0; i < n; ++i) {
      Serial.print(i + 1);
      Serial.print(": ");
      Serial.print(WiFi.SSID(i));
      Serial.print(" (");
      Serial.print(WiFi.RSSI(i));
      Serial.print(")");
      Serial.println((WiFi.encryptionType(i) == ENC_TYPE_NONE) ? " " : "*");
      delay(10);
    }
  }
  Serial.println();
  delay(5000);   // Ждём, прежде чем снова сканировать
}
