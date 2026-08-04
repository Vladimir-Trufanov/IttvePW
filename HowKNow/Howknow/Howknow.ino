/** Arduino - ESP32 ******************************************* Howknow.ino ***
 * 
 * "Как в скетче ардуино узнать ..." - подготовить список определений и констант
 * 
 * v1.0.2, 04.08.2026                                 Автор:      Труфанов В.Е.
 * Copyright © 2025 tve                               Дата создания: 31.07.2026
**/

#include <Arduino.h>
#include <PriUint64.h>

#if defined(ARDUINO_ARCH_ESP32)
  #include "WiFi.h"
#elif defined(ARDUINO_ARCH_ESP8266)
  #include <ESP8266WiFi.h> 
#else
  #define notwifi
#endif

#include "config.h"  

void setup() 
{
  Serial.begin(115200);
  delay(5000);
  Serial.println("\n");

  /* 
  Список определений и констант 
  -----------------------------
  BOARD_TYPE   - тип платы
  BOARD_NAME   - название платы в менеджере плат IDE Arduino
  MAC_ADDRESS  - MAC-адрес платы 
  MAC_FORMATED - MAC-адрес платы для протокола ESP-NOW
  */

  // Определяем тип платы
  #if defined(ARDUINO_ARCH_AVR)
    // Uno/Nano/Mega
    #define uBOARD_TYPE "AVR"
  #elif defined(ARDUINO_ARCH_SAMD)
    // Zero/MKR
    #define uBOARD_TYPE "SAMD"
  #elif defined(ARDUINO_ARCH_ESP32)
    #define uBOARD_TYPE ARDUINO_ARCH_ESP32
  #elif defined(ARDUINO_ARCH_ESP8266)
    #define uBOARD_TYPE "ESP8266"
  #endif
  Serial.println("uBOARD_TYPE: " + String(uBOARD_TYPE));
  Serial.println(" BOARD_TYPE: " + String(BOARD_TYPE));
  if (uBOARD_TYPE == BOARD_TYPE) Serial.println(" Равны! \n"); 

  Serial.println(" BOARD_NAME:  " + String(BOARD_NAME) + "\n");

  #if defined(ARDUINO_ARCH_ESP32)
 
  // Определяем MAC-ADDRESS платы
  String uMAC_ADDRESS;  
  #if defined(notwifi)
    uMAC_ADDRESS = "00:00:00:00:00:00";
  #else
    WiFi.mode(WIFI_STA); 
    #if defined(ARDUINO_ARCH_ESP8266)
      delay(1000); 
    #else
      while (!(WiFi.STA.started())) delay(10);
    #endif
    uMAC_ADDRESS = WiFi.macAddress();
  #endif
  Serial.println("uMAC_ADDRESS: " + String(uMAC_ADDRESS));
  Serial.println(" MAC_ADDRESS: " + String(MAC_ADDRESS));
  if (uMAC_ADDRESS == MAC_ADDRESS) Serial.println(" Равны! \n"); 

  // Определяем MAC-адрес платы для протокола ESP-NOW
  Serial.print("MAC_FORMATED: ");
  Serial.print("{");
  int index = 0;
  for(int i=0; i<6; i++)
  {
    Serial.print("0x");
    Serial.print(uMAC_ADDRESS.substring(index, index+2));
    if(i<5)
    {
      Serial.print(", ");
    }
    index += 3;
  }
  Serial.println("}");

  #endif

  #if defined(ARDUINO_ARCH_ESP32)
    // Читаем серийный номер
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
    uint64_t uCHIPID = ESP.getEfuseMac();  // Получаем MAC-адрес
    // Выводим результат в шестнадцатеричном формате https://github.com/yoursunny/PriUint64
    Serial.print("uCHIPID: "); Serial.print(PriUint64<HEX>(uCHIPID)); Serial.print(" = "); Serial.println(PriUint64<DEC>(uCHIPID));
    Serial.print(" CHIPID: "); Serial.print(PriUint64<HEX>(CHIPID));  Serial.print(" = "); Serial.println(PriUint64<DEC>(CHIPID));
  #endif
}

void loop() 
{
  // put your main code here, to run repeatedly:
}

// ************************************************************ Howknow.ino ***
