/** Arduino C/C++ ******************************************** TrassaSD.ino ***
 *
 * Обеспечить снятие показаний разного рода и запись на SD-карту
 * 
 * v1.0.3, 22.05.2026                                 Автор:      Труфанов В.Е.
 * Copyright © 2025 tve                               Дата создания: 30.04.2026
 *
**/

#include <SoftwareSerial.h>
#include <iarduino_VCC.h>
#include <EEPROM.h>
#include <avr/wdt.h>

#include <SD.h>
#include <SPI.h>
File myFile;
int pinCS = 10; // контакт 10 на плате Arduino Uno для CS на SD

uint32_t ncikl=0;                       // счетчик циклов

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
  //if (SD.begin())
  //{
  //  Serial.println("SD card is ready to use.");
  //} 
  //else
  //{
  //  Serial.println("SD card initialization failed");
  //  return;
  //}



  // Переопределяем счетчик перезагрузок контроллера
  address=0; 
  EEPROM.get(address, nReboot);
  if (nReboot==65535) nReboot=0;
  nReboot++;
  EEPROM.put(address,nReboot);
  Serial.print(F("Контроллер перезагрузился: ")); Serial.println(nReboot);
  // Запускаем watchdog с таймаутом ~8c
  wdt_enable(WDTO_8S); 
}

void loop()
{
  // Считываем напряжение питания
  vi = analogRead_VCC();      
  // Прослушиваем приемник GPS V.KEL-TTL
  // (по умолчанию прослушивается последний инициализированный порт,
  // если требуется прослушивать другой, следует его явно указать)
  VKEL_TTL.listen();
  // Выбираем данные навигации из приёмника GPS V.KEL TTL 
  isVKEL_TTL=Talk_VKEL_TTL(ncikl);
  if (isVKEL_TTL)
  {
    ncikl++;  // изменили счетчик считанных данных
    //Serial.println(F("Данные от приемника GPS есть"));
  }
  else
  {
    Serial.println(F("Отсутствие сигнала GPS"));
  } 
  // Работаем с SIM900
  SIM900.listen();
  // Проверяем, реагирует ли на команды SIM900
  // и включаем GPRS, если нет ответа
  uint8_t answeri=AT_com(AT_AT);                  
  // Инициируем переменные
  if (answeri!=0)
  { 
    Serial.println(F("Включаем SIM900, ждем 10 секунд!"));
    // Включаем SIM900
    SIM900powerUpOrDown();
  }
  // Отсчитываем время и отправляем данные положения на сайт
  else
  {
    //Serial.println(F("Есть SIM900"));
    // Выбираем данные навигации из приёмника GPS V.KEL TTL 
    isSIM900=Talk_SIM900(ncikl);
  }
  // С 11 цикла, как пошли координаты пересчитываем нарастающее расстояние и время
  if (ncikl==10)
  {
    // Инициируем прежнее время для определения будущих интервалов
    ghour0=ghour; gmin0=gmin; gsec0=gsec; 
  }
  else if (ncikl>10)
  {
    IncreaseToChar(DistanceBetween,ghour,gmin,gsec,ghour0,gmin0,gsec0);
    // Меняем прежнее время для определения будущих интервалов
    ghour0=ghour; gmin0=gmin; gsec0=gsec; 
    Serial.println(ddtMess); 
    Serial.println(""); //("-------"); 
  }
  // Проверяем интервал и делаем запись данных в файл 
  delaySD=millis()-BdelaySD; 
  if (delaySD>dTimeSD) 
  {
    Talk_SD_Card(ncikl); // записали данные на SD
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
