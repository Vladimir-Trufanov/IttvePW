/** Arduino UNO, SIM900 **************************************** VKEL_TTL.h ***
 * 
 * Обеспечить взаимодействие и выборку данных из приёмника GPS VKEL_TTL 
 * 
 * v6.0.4, 31.05.2026                                 Автор:      Труфанов В.Е.
 * Copyright © 2025 tve                               Дата создания: 16.10.2025
**/

#ifndef VKEL_TTL_h
#define VKEL_TTL_h
#pragma once  

#include "s32nRF24L01.h"    

// Настраиваем переменные и модули для работы с V.KEL TTL
#include <TinyGPSPlus.h>
TinyGPSPlus gps;
SoftwareSerial VKEL_TTL(2,3);       // синий на 2 - RX; зеленый на 3 - TX
bool isVKEL_TTL=false;              // "Приемник GPS не подает сигналы" = The GPS receiver does not send signals

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
  // Чуть более секунды считываем данные приёмника GPS
  bool newdata = smartDelay(1100);
  if (newdata)
  {
    // Определяем координаты и перемещение от предыдущей точки
    if (gps.location.isValid())
    {
      //Serial.println(F("gps.location.isValid()"));
      lat=gps.location.lat();
      lng=gps.location.lng();
      Serial.print(F("lat = ")); Serial.println(lat);
      Serial.print(F("lng = ")); Serial.println(lng);
      // Если первое обнаружение координат, инициируем нарастающее расстояние
      if ((lat0==-1)&&(lng0==-1)) 
      {
        DistanceBetween = 0; increase_distance = 0;
      }
      // Иначе уже пересчитываем расстояние между точками
      else
      {
        DistanceBetween = gps.distanceBetween(lat,lng,lat0,lng0);
        // Если есть продвижение более 10 см, пересчитываем нарастающее расстояние 
        //if (DistanceBetween>0.1)
        //{
        //  increase_distance = increase_distance + DistanceBetween*100;
        //  lat0=lat; lng0=lng;  
        //  Serial.print(F("DistanceBetween   = ")); Serial.println(DistanceBetween);
        //  Serial.print(F("increase_distance = ")); Serial.println(increase_distance);
        //}
      }
      Serial.print(F("DistanceBetween   = ")); Serial.println(DistanceBetween);
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
