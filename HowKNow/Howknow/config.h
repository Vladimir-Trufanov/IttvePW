/** Arduino - ESP32 ********************************************** config.h ***
 * 
 * Cконфигурировать определения и консанты приложения Howknow.ino
 * 
 * v1.0.2, 04.08.2026                                 Автор:      Труфанов В.Е.
 * Copyright © 2025 tve                               Дата создания: 31.07.2026
**/

#pragma once 

// Назначаем рабочую (для скетча) плату
   #define WORK_BOARD 6   // 6_ESP32_CAM 
// #define WORK_BOARD 7   // 7_ESP32-2432S028_CYD 
// #define WORK_BOARD 11  // 11_ESP01 

/* 
Список определений и констант 
-----------------------------
BOARD_TYPE   - тип платы: ESP32, ESP8266, AVR, SAMD, ...
BOARD_NAME   - название платы в менеджере плат IDE Arduino
MAC_ADDRESS  - MAC-адрес платы 
MAC_FORMATED - MAC-адрес платы для протокола ESP-NOW
*/

// Указываем название платы в менеджере плат IDE Arduino
/*
#define BOARD_NAME "AI Thinker ESP32-CAM"
#define BOARD_NAME "Generic ESP8266 Module"
*/

#if (WORK_BOARD == 6)     // 6_ESP32_CAM
  #define BOARD_TYPE ARDUINO_ARCH_ESP32             // тип платы
  #define BOARD_NAME "AI Thinker ESP32-CAM"         // название платы в менеджере плат IDE Arduino
  #define MAC_ADDRESS "F8:B3:B7:A7:E1:18"           // MAC-адрес платы
  // MAC-адрес платы для протокола ESP-NOW
  uint8_t  MAC_FORMATED[] = {0xF8, 0xB3, 0xB7, 0xA7, 0xE1, 0x18};
  // Cерийный номер 
  uint64_t CHIPID = 0x18E1A7B7B3F8;  
 
#elif (WORK_BOARD == 7)   // 7_ESP32-2432S028_CYD)
  #define BOARD_TYPE ARDUINO_ARCH_ESP32
#elif (WORK_BOARD == 11)  // 11_ESP01)
  #define BOARD_TYPE ARDUINO_ARCH_ESP8266
#else
  // код во всех остальных случаях
  // даже если WORK_BOARD не задан
#endif

void initconfig() 
{
  /*
  #if (WORK_BOARD == 6)     // 6_ESP32_CAM
    // MAC_ADDRESS:     F8:   B3:   B7:   A7:   E1:   18
    // MAC_FORMATED = {0xF8, 0xB3, 0xB7, 0xA7, 0xE1, 0x18};
  #elif (WORK_BOARD == 7)   // 7_ESP32-2432S028_CYD)
  #elif (WORK_BOARD == 11)  // 11_ESP01)
  #else
  #endif
  */
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
