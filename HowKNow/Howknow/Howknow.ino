/** Arduino - ESP32 ******************************************* Howknow.ino ***
 * 
 * "Как в скетче ардуино узнать ..."
 * 
 * v1.0.1, 31.07.2026                                 Автор:      Труфанов В.Е.
 * Copyright © 2025 tve                               Дата создания: 31.07.2026
**/

#include <Arduino.h>
#include "config.h"  


#include <PriUint64.h>

void setup() 
{
  Serial.begin(115200);
  delay(5000);
  Serial.println("\n");




  
  initconfig();
   
  Serial.println("BOARD_TYPE:  " + String(BOARD_TYPE));
  Serial.println("BOARD_NAME:  " + String(BOARD_NAME));
  Serial.println("MAC_ADDRESS: " + String(MAC_ADDRESS));

  #if defined(ARDUINO_ARCH_AVR)
    // код для Uno/Nano/Mega
    Serial.println("код для Uno/Nano/Mega");
  #elif defined(ARDUINO_ARCH_SAMD)
    // код для Zero/MKR
    Serial.println("код для Zero/MKR");
  #elif defined(ARDUINO_ARCH_ESP32)
    Serial.println("код для ESP32");
  #elif defined(ARDUINO_ARCH_ESP8266)
    // код для ESP8266
    Serial.println("код для ESP8266");
  #endif


  //if (BOARD_NAME == "Generic ESP8266 Module") Serial.println("BOARD_NAME == Generic ESP8266 Module");
  //else Serial.println("BOARD_NAME => проверка не сработала");

  /*
  Как в скетче прочитать серийный номер esp32
  -------------------------------------------
  В скетче для ESP32 «серийный номер» — это фактически MAC-адрес платы 
  (униканый идентификатор чипа, записанный в энергонезависимую память). 
  Получить его можно с помощью функции ESP.getEfuseMac().

  Функция ESP.getEfuseMac() возвращает 64-битное число, которое представляет 
  собой конкатенацию байтов MAC-адреса. Чтобы вывести его читаемо, мы 
  используем printf и форматируем вывод как шестнадцатеричные числа 
  (%04X для двух байтов, %08X для четырёх байтов). 

  Энергонезависимая память. Значение, возвращаемое getEfuseMac(), записано 
  в чип при производстве (в «эфьюз», энергонезависимую область) и не меняется 
  при перезагрузке устройства.

  На некоторых платах (особенно S3) значение может содержать только 32 бита 
  (6 байт), а не полные 64, из-за особенностей реализации в конкретной версии SDK.
  Если нужно использовать этот идентификатор в программе (например, для 
  генерации имени устройства), следует сначала преобразовать uint64_t в 
  строку (String), как показано в примере.
 
  Альтернатива: WiFi.macAddress(). Если нужен именно MAC-адрес (например, 
  для сетевых настроек), можно использовать WiFi.macAddress(), который 
  возвращает строку. 
  */

  uint64_t CHIPID = ESP.getEfuseMac();  // Получаем MAC-адрес
  // Выводим результат в шестнадцатеричном формате
  // https://github.com/yoursunny/PriUint64
  Serial.println(PriUint64<HEX>(CHIPID));
}

void loop() 
{
  // put your main code here, to run repeatedly:
}

// ************************************************************ Howknow.ino ***
