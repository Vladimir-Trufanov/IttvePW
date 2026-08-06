/** Arduino - ESP32 ********************************************** config.h ***
 * 
 * Cконфигурировать определения и консанты приложения Howknow.ino
 * 
 * v1.0.6, 06.08.2026                                 Автор:      Труфанов В.Е.
 * Copyright © 2025 tve                               Дата создания: 31.07.2026
**/

#pragma once 

// Назначаем рабочую (для скетча) плату
// #define WORK_BOARD 6   // 6_ESP32_CAM 
// #define WORK_BOARD 7   // 7_ESP32_2432S028_CYD 
// #define WORK_BOARD 11  // 11_ESP01 
   #define WORK_BOARD 13  // 13_ESP32_2432S028_CYD 

/* 
Список определений и констант 
-----------------------------
BOARD_TYPE   - тип платы
BOARD_NAME   - название платы в менеджере плат IDE Arduino
MAC_ADDRESS  - MAC-адрес платы 
MAC_FORMATED - MAC-адрес платы для протокола ESP-NOW [ESP32, ESP8266]
CHIPID       - cерийный номер [ESP32]
*/

// Указываем название платы в менеджере плат IDE Arduino
/*
#define BOARD_NAME "AI Thinker ESP32-CAM"
#define BOARD_NAME 
*/

// ------------------------------------------------ 6_ESP32_CAM
#if (WORK_BOARD == 6)      
  #define BOARD_TYPE ARDUINO_ARCH_ESP32             // тип платы
  #define BOARD_NAME "AI Thinker ESP32-CAM"         // название платы в менеджере плат IDE Arduino
  #define MAC_ADDRESS "F8:B3:B7:A7:E1:18"           // MAC-адрес платы
  // MAC-адрес платы для протокола ESP-NOW
  uint8_t  MAC_FORMATED[] = {0xF8, 0xB3, 0xB7, 0xA7, 0xE1, 0x18};
  // Cерийный номер 
  uint64_t CHIPID = 0x18E1A7B7B3F8;  
 
// ------------------------------------------------ 7_ESP32_2432S028_CYD
#elif (WORK_BOARD == 7)   // 7_ESP32-2432S028_CYD)
  #define BOARD_TYPE ARDUINO_ARCH_ESP32             // тип платы
  #define BOARD_NAME "ESP32-2432S028 CYD"           // название платы в менеджере плат IDE Arduino
  #define MAC_ADDRESS "B8:D6:1A:5C:F9:54"           // MAC-адрес платы
  // MAC-адрес платы для протокола ESP-NOW
  uint8_t  MAC_FORMATED[] = {0xB8, 0xD6, 0x1A, 0x5C, 0xF9, 0x54};
  // Cерийный номер 
  uint64_t CHIPID = 0x54F95C1AD6B8;  

// ------------------------------------------------ 11_ESP01
#elif (WORK_BOARD == 11)  // 11_ESP01)
  #define BOARD_TYPE ARDUINO_ARCH_ESP8266           // тип платы
  #define BOARD_NAME "Generic ESP8266 Module"       // название платы в менеджере плат IDE Arduino
  #define MAC_ADDRESS "68:C6:3A:FC:97:30"           // MAC-адрес платы
  // MAC-адрес платы для протокола ESP-NOW
  uint8_t  MAC_FORMATED[] = {0x68, 0xC6, 0x3A, 0xFC, 0x97, 0x30};

// ------------------------------------------------ 13_ESP32_2432S028_CYD
#elif (WORK_BOARD == 13)   // 13_ESP32-2432S028_CYD)
  #define BOARD_TYPE ARDUINO_ARCH_ESP32             // тип платы
  #define BOARD_NAME "ESP32-2432S028 CYD"           // название платы в менеджере плат IDE Arduino
  #define MAC_ADDRESS "A4:F0:0F:5A:B5:54"           // MAC-адрес платы
  // MAC-адрес платы для протокола ESP-NOW
  uint8_t  MAC_FORMATED[] = {0xA4, 0xF0, 0x0F, 0x5A, 0xB5, 0x54};
  // Cерийный номер 
  uint64_t CHIPID = 0x54B55A0FF0A4;  
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

// *************************************************************** config.h ***
