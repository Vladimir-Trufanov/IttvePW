/** Arduino UNO, SIM900 **************************************** VKEL_TTL.h ***
 * 
 * Обеспечить взаимодействие и выборку данных из приёмника GPS VKEL_TTL 
 * 
 * v6.0.1, 18.05.2026                                 Автор:      Труфанов В.Е.
 * Copyright © 2025 tve                               Дата создания: 16.10.2025
**/

#ifndef VKEL_TTL_h
#define VKEL_TTL_h
// Указываем, что данный файл нужно подключить только один раз
#pragma once  

#include "s32nRF24L01.h"    

// Настраиваем переменные и модули для работы с V.KEL TTL
#include <TinyGPSPlus.h>
TinyGPSPlus gps;

SoftwareSerial VKEL_TTL(2,3);           // синий на 2 - RX; зеленый на 3 - TX

bool isVKEL_TTL=false;                  // "Приемник GPS не подает сигналы" = The GPS receiver does not send signals

// ****************************************************************************
// *       Загрузить и декодировать предложения NMEA в заданное время         *
// *                  (по меньшей мере одно предложение)                      *
// ****************************************************************************
bool smartDelay(unsigned long ms)
{
  static uint32_t charsProc=0;      // счетчик обработанных символов
  bool newdata = false;             // счетчик не увеличился

  unsigned long start = millis();
  do 
  {
    while (VKEL_TTL.available()) gps.encode(VKEL_TTL.read());
  } 
  while (millis() - start < ms);
  // Проверяем, увеличилось ли число обработанных символов
  if (gps.charsProcessed()>charsProc) newdata = true;
  //Serial.print(F("gps.charsProcessed()=")); Serial.println(gps.charsProcessed());
  //Serial.print("charsProcessed-charsProc="); Serial.println(gps.charsProcessed()-charsProc);
  charsProc=gps.charsProcessed();
  return newdata;
}
// ****************************************************************************
// *         Выбрать данные навигации из буфера приёмника GPS V.KEL TTL,      *
// *                в случае неудачи вывести сообщение об ошибке              *
// ****************************************************************************
bool Talk_VKEL_TTL(uint32_t ncikl)
{
  // Инициируем данные приёмника GPS
  ghour=0; gmin=0; gsec=0; 
  gday=0; gmonth=0; gyear=0; 
  lat=0; lng=0; DistanceBetween=0;
  // Чуть более секунды считываем данные приёмника GPS
  bool newdata = smartDelay(1100);
  if (newdata)
  {
    // Определяем координаты и перемещение от предыдущей точки
    if (gps.location.isValid())
    {
      lat=gps.location.lat();
      lng=gps.location.lng();
      DistanceBetween = gps.distanceBetween(lat,lng,lat0,lng0);
      //Serial.print(F("DistanceBetween=")); Serial.println(DistanceBetween);
      //Serial.print(gps.location.lat(), 6); Serial.print(F(",")); Serial.println(gps.location.lng(), 6);
      //LocationToChar(lat,lng,SAT,chardec);
      //Serial.println(LocationToChar(lat,lng,chardec)); 
      //Serial.println(krdMess); 
      //Serial.println("-------"); 
 
      // Меняем прежнее положение для определения будущего расстояния между точками
      lat0=lat; lng0=lng;  
      // Определяем дату
      if (gps.date.isValid())
      {
        gday=gps.date.day(); gmonth=gps.date.month(); gyear=gps.date.year(); 
        // Определяем время
        if (gps.time.isValid())
        {
          ghour=gps.time.hour(); gmin=gps.time.minute(); gsec=gps.time.second();
          ghour=ghour+timezone_hours;
          if (ghour>=24) ghour=ghour-24;
          else if (ghour<0) ghour=ghour+24;
          // Определяем количество спутников и погрешность
          if (gps.satellites.isValid()) SAT=gps.satellites.value(); 
        }
        // "Не определяется время"
        else 
        {
          newdata = false;
          //saymess(DefToChar(m1_TimeIsNot));
          Serial.println(F("Не определяется время"));
        }
      }
      // "Не определяется дата"
      else
      {
        newdata = false;
        //saymess(DefToChar(m1_DateIsNot));
        Serial.println(F("Не определяется дата"));
      }
      //DateTimeToChar(ghour,gmin,gsec,gday,gmonth,gyear); 
      //Serial.println(DateTimeToChar(ghour,gmin,gsec,gday,gmonth,gyear)); 
      //Serial.println(tidMess); 
      //Serial.println(""); //("-------"); 
    }
    // "Не определяется локация" 
    else
    {
      newdata = false;
      Serial.println(F("Не определяется локация"));
    }
  }
  else
  {
    // "Приемник GPS не подает сигналы"
    Serial.println(F("Приемник GPS не подает сигналы"));
  }
  return newdata;
}

#endif

// ************************************************************* VKEL_TTL.h ***
