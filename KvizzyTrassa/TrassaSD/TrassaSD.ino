/** Arduino C/C++ ******************************************** TrassaSD.ino ***
 *
 * Обеспечить снятие показаний разного рода и запись на SD-карту
 * 
 * v2.0.2, 28.05.2026                                 Автор:      Труфанов В.Е.
 * Copyright © 2026 tve                               Дата создания: 30.04.2026
 *
**/

#include <SoftwareSerial.h>
#include <EEPROM.h>
#include <avr/wdt.h>
#include <SD.h>
#include <SPI.h>

#define fnamesize 16    // размер поля для имени файла         
File myFile;            // дескриптор файла
char fname[fnamesize]="testGPS"; 
bool firstmyfile=true;  // ожидается первый запрос датs/времени с SIM900
int pinCS = 10;         // контакт 10 на плате Arduino Uno для CS на SD

#include "s32nRF24L01.h"    
#include "VKEL_TTL.h" 
#include "SIM900.h"   
#include "SD_Card.h"   

// Определяем адрес для записи данных в EEPROM
int address; 
// Определяем переменную счетчика перезагрузок контроллера для  постоянного хранения
uint16_t nReboot;  

void setup()
{
  Serial.begin(9600);
  VKEL_TTL.begin(9600); 
  SIM900.begin(9600);

  pinMode(pinCS, OUTPUT);
  // инициализация SD карты
  if (SD.begin()) Serial.println(F("SD-карта готова"));
  else Serial.println(F("Ошибка инициализации SD"));
  // Переопределяем счетчик перезагрузок контроллера
  address=0; 
  EEPROM.get(address, nReboot);
  if (nReboot==65535) nReboot=0;
  nReboot++;
  EEPROM.put(address,nReboot);
  Serial.print(F("Контроллер перезагрузился: ")); Serial.println(nReboot);

  // Инициализируем часы на московское время 26/05/28,09:51:10
  /*
  SIM900.listen();
  AT_com(AT_AT);
  AT_com(ST);
  */

  /*
  // Считываем время с часов и формируем имя файла
  SIM900.listen();
  if (AT_com(AT_CCLK)!=0)
  { 
  }
  else
  {
    Serial.println(F("a"));
  }
  */
  // Запускаем watchdog с таймаутом ~8c
  wdt_enable(WDTO_8S); 
}

void loop()
{
  ncikl++;  // изменили счетчик 
  // Работаем с SIM900
  // (по умолчанию прослушивается последний инициализированный порт,
  // если требуется прослушивать другой, следует его явно указать)
  SIM900.listen();
  // Проверяем, реагирует ли на команды SIM900
  // и включаем GPRS, если нет ответа
  // 28.05.2026: здесь включена команда проверки времени
  // (это решение в связи с тем, что сигнал gps может не появиться до записи файла)
  // if (AT_com(AT_AT)!=0)
  if (AT_com(AT_CCLK)!=0)
  { 
    Serial.println(F("Включаем SIM900, ждем 10 секунд!"));
    // Включаем SIM900
    SIM900powerUpOrDown();
  }
  // Выбираем данные по SIM900 
  else
  {
    // Формируем имя файла
    if (firstmyfile) 
    {
      //Serial.println(F("1"));
      firstmyfile=false;
    }
    //Serial.println(F("Есть SIM900"));
    isSIM900=Talk_SIM900(ncikl);
  }
  // Прослушиваем приемник GPS V.KEL-TTL
  VKEL_TTL.listen();
  // Выбираем данные навигации из приёмника GPS V.KEL TTL 
  isVKEL_TTL=Talk_VKEL_TTL(ncikl);
  if (isVKEL_TTL)
  {
    //Serial.println(F("Данные от приемника GPS есть"));
  }
  // Проверяем интервал и делаем запись данных в файл 
  delaySD=millis()-BdelaySD; 
  if (delaySD>dTimeSD) 
  {
    Talk_SD_Card();      // записали данные на SD
    BdelaySD=millis();   // начали отсчет нового интервала для записи данных на SD 
  }
  // Отрабатываем управляющие команды из последовательного порта
  if (Serial.available())
  {
    int ccom = Serial.read();
    // Выполняем иммитацию зацикливания для проверки watchdog
    if (ccom == '9') while (true) {}
  }
  // Сбрасываем счетчик watchdog
  wdt_reset();
  // Делаем паузу на нормализацию состояния контроллера
  delay(100);
}

// *********************************************************** TrassaSD.ino ***
