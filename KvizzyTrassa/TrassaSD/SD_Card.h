/** Arduino UNO, SIM900 ***************************************** SD_Card.h ***
 * 
 * Обеспечить запись данных на SD 
 * 
 * v2.0.0, 26.05.2026                                 Автор:      Труфанов В.Е.
 * Copyright © 2026 tve                               Дата создания: 25.05.2026
**/

#ifndef SD_Card_h
#define SD_Card_h
#pragma once  

#include "s32nRF24L01.h"    

uint32_t dTimeSD=10000;       // заданный интервал между записями на SD в мс (180000 = 3 мин)  
uint32_t BdelaySD=millis();   // начало отсчета интервала записи данных на SD 
uint32_t delaySD;             // фактическое время после предыдущей записи на SD

// ****************************************************************************
// *              Сформировать и записать данные в файл на SD-карте           *
// ****************************************************************************

#define tsz      F(";")
#define dZero    F("0")    
#define Twodots  F(":") 
#define LocToCh  F("-")    
#define Point    F(".")    

#define pref_tid F("tid")    
#define pref_krd F("krd")    
#define pref_sim F("sim")  
#define pref_ddt F("ddt")  

#define vg       F("vg")    
#define vc       F("vc")    

// Определяем макрос для вывода значения в файл
#define fp(value) myFile.print(value)
#define fpi(integer) myFile.print(IntToChar(integer))
#define fpd(integer) if (integer<10) {fp(dZero); fp(IntToChar(integer));} else fp(IntToChar(integer))
#define fco(coord) dtostrf(coord,2,5,charNumby); fp(charNumby)
#define fuu(volti) dtostrf(volti,1,2,charNumby); fp(charNumby)
#define fpln(value) myFile.println(value)

bool Talk_SD_Card()
{
  // создание/открытие файла 
  myFile = SD.open("testGPS.txt", FILE_WRITE);
  // if the file opened okay, write to it:
  if (myFile) 
  {
    Serial.print(F("to file ")); Serial.print(ncikl); 
    if (DistanceBetween>0)
    {
      // Формируем индекс по номеру цикла
      fp(ncikl); fp(tsz);
      // "tid2026.05.18-20:43:23;"
      fp(pref_tid); 
      fpi(gyear); fp(Point);   fpd(gmonth); fp(Point);   fpd(gday); fp(LocToCh);
      fpd(ghour); fp(Twodots); fpd(gmin);   fp(Twodots); fpd(gsec); fp(tsz);
      // "krd61.80191-34.32987-11;"
      fp(pref_krd); fco(lat); fp(LocToCh); fco(lng); fp(LocToCh); fpi(SAT); fp(tsz);
      // "sim24-vg4.12-vc4.54;"
      fp(pref_sim); fpi(dB); fp(LocToCh); fp(vg); double vig=double(lipo)/1000; fuu(vig); fp(LocToCh); 
      fp(vc); fuu(vi); fp(tsz); 
      // "ddt123456789-d123456789;"
      fp(pref_ddt); uint32_t value;
      // Пересчитываем нарастающее время
      value=ghour0*3600+gmin0*60+gsec0;
      value=ghour*3600+gmin*60+gsec-value;
      increase_time=increase_time+value;
      fpi(increase_time); fp(LocToCh); 
      // Пересчитываем нарастающее расстояние
      increase_distance=increase_distance+DistanceBetween*100;
      fpi(increase_distance); fp(tsz); 
      fpln("");
      myFile.close(); // close the file
      Serial.println(F(""));
    }
    else Serial.println(F(" нет записи"));
  }
  // если файл не открылся выводим сообщение об ошибке
  else 
  {
    Serial.println(F("error opening test.txt"));
  }
  
  //  Serial.print(F("--SD2: ")); Serial.println(sdline); 
  return true;
}

#endif

// ************************************************************** SD_Card.h ***
