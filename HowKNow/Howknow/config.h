/** Arduino - ESP32 ********************************************** config.h ***
 * 
 * Cконфигурировать определения и консанты приложения Howknow.ino
 * 
 * v1.0.1, 02.08.2026                                 Автор:      Труфанов В.Е.
 * Copyright © 2025 tve                               Дата создания: 31.07.2026
**/

#pragma once 

/* 
Список определений и констант 
-----------------------------
BOARD_TYPE   - тип платы: ESP32, ESP8266, AVR, SAMD, ...
BOARD_NAME   - название платы в менеджере плат IDE Arduino
MAC_ADDRESS  - MAC-адрес платы 
MAC_FORMATED - MAC-адрес платы для протокола ESP-NOW
*/

#if defined(ARDUINO_ARCH_ESP32)
  #include "WiFi.h"
#elif defined(ARDUINO_ARCH_ESP8266)
  #include <ESP8266WiFi.h> 
#else
  #define notwifi
#endif


// Определяем тип платы
#if defined(ARDUINO_ARCH_AVR)
  // Uno/Nano/Mega
  #define BOARD_TYPE "AVR"
#elif defined(ARDUINO_ARCH_SAMD)
  // Zero/MKR
  #define BOARD_TYPE "SAMD"
#elif defined(ARDUINO_ARCH_ESP32)
  #define BOARD_TYPE "ESP32"
#elif defined(ARDUINO_ARCH_ESP8266)
  #define BOARD_TYPE "ESP8266"
#endif

// Указываем название платы в менеджере плат IDE Arduino
/*
#define BOARD_NAME "AI Thinker ESP32-CAM"
#define BOARD_NAME "Generic ESP8266 Module"
*/
#define BOARD_NAME "AI Thinker ESP32-CAM"

void initconfig();


static String  MAC_ADDRESS;  // MAC-адрес платы
static uint8_t MAC_FORMATED[] = {0xB8, 0xD6, 0x1A, 0x5C, 0xF9, 0x54};

void initconfig() {
// ----------------

  // Определяем MAC-ADDRESS платы
  #if defined(notwifi)
    MAC-Address = "00:00:00:00:00:00";
  #else
    WiFi.mode(WIFI_STA); 
    #if defined(ARDUINO_ARCH_ESP8266)
      delay(1000); 
    #else
      while (!(WiFi.STA.started())) delay(10);
    #endif
    MAC_ADDRESS = WiFi.macAddress();
  #endif

  // Указываем MAC-адрес платы для протокола ESP-NOW
//static uint8_t MAC_FORMATED[] = {0xB8, 0xD6, 0x1A, 0x5C, 0xF9, 0x54};
//static uint8_t MAC_FORMATED[] = {0xB8, 0xD6, 0x1A, 0x5C, 0xF9, 0x54};
//static uint8_t MAC_FORMATED[] = {0xB8, 0xD6, 0x1A, 0x5C, 0xF9, 0x54};
//static uint8_t MAC_FORMATED[] = {0xB8, 0xD6, 0x1A, 0x5C, 0xF9, 0x54};
//static uint8_t MAC_FORMATED[] = {0xB8, 0xD6, 0x1A, 0x5C, 0xF9, 0x54};
//static uint8_t MAC_FORMATED[] = {0xB8, 0xD6, 0x1A, 0x5C, 0xF9, 0x54};
//static uint8_t MAC_FORMATED[] = {0xB8, 0xD6, 0x1A, 0x5C, 0xF9, 0x54};
//static uint8_t MAC_FORMATED[] = {0xB8, 0xD6, 0x1A, 0x5C, 0xF9, 0x54};

// ----------------
}

// Получить MAC-адрес платы для протокола ESP-NOW
void macformated(String mac) 
{
//  S
// ----------------
}

/* 
Реестр используемых плат 
------------------------

[6: ESP32-CAM] 
BOARD_TYPE:  ESP32
BOARD_NAME:  AI Thinker ESP32-CAM
MAC_ADDRESS: F8:B3:B7:A7:E1:18

[7: ESP32-2432S028 (CYD)]        MAC-Address: B8:D6:1A:5C:F9:54
                  Formated: {0xB8, 0xD6, 0x1A, 0x5C, 0xF9, 0x54} 

[11-ESP01] 
BOARD_TYPE:   ESP8266
BOARD_NAME:   Generic ESP8266 Module
MAC_ADDRESS:  68:C6:3A:FC:97:30
MAC_FORMATED: {0x68, 0xC6, 0x3A, 0xFC, 0x97, 0x30}                 
*/

// *************************************************************** config.h ***
