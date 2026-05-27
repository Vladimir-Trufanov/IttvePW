/** Arduino UNO, SIM900 ***************************************** SD_Card.h ***
 * 
 * Обеспечить запись данных на SD 
 * 
 * v2.0.1, 27.05.2026                                 Автор:      Труфанов В.Е.
 * Copyright © 2026 tve                               Дата создания: 25.05.2026
**/

#ifndef SD_Card_h
#define SD_Card_h
#pragma once  

#include "s32nRF24L01.h"    

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
#define signd    F("d")    

#define pref_tid F("tid")    
#define pref_krd F("krd")    
#define pref_sim F("sim")  
#define pref_ddt F("ddt")  
#define Space    F(" ")  

#define vg       F("vg")    
#define vc       F("vc")    

// Определяем макрос для вывода значения в файл
#define fp(value) myFile.print(value)
#define fpi(integer) myFile.print(IntToChar(integer))
#define fpd(integer) if (integer<10) {fp(dZero); fp(IntToChar(integer));} else fp(IntToChar(integer))
#define fco(coord) dtostrf(coord,2,5,charNumby); fp(charNumby)
#define fuu(volti) dtostrf(volti,1,2,charNumby); fp(charNumby)
#define fpln(value) myFile.println(value)

_DS(pref_gps,"gps")    
_DS(diZero,"0")    
_DS(diSubo,"_")    
_DS(ptxt,".txt")    

bool Talk_SD_Card()
{
  bool result=false;
  //char fname = makefilename();
  //char fname[] = "testGPS1.txt";
  char fname[22] = "testGPS2.txt";

  // "gps20260518_2043.txt"
  memset(fname,'\0',22); 
  strcat_P(fname,pref_gps); 
  //IntToChar(gyear); Serial.println(charNumby);
  /*
  strcat(fname,IntToChar(gyear)); 
  if (gmonth<10) {strcat_P(fname,diZero); strcat(fname,IntToChar(gmonth));}
  else strcat(fname,IntToChar(gmonth)); 
  if (gday<10) {strcat_P(fname,diZero); strcat(fname,IntToChar(gday));}
  else strcat(fname,IntToChar(gday)); strcat_P(fname,diSubo);
  if (ghour<10) {strcat_P(fname,diZero); strcat(fname,IntToChar(ghour));}
  else strcat(fname,IntToChar(ghour)); 
  if (gmin<10) {strcat_P(fname,diZero); strcat(fname,IntToChar(gmin));}
  else strcat(fname,IntToChar(gmin)); 
  */










  //char fname[22] = "testGPS.txt";
  //Serial.print(F("file: ")); Serial.print(ncikl); Serial.print(Space);   
  Serial.print(fname); Serial.print(Space); Serial.print(ncikl); Serial.print(Space);   
  // Создаём/открываем файл для записи 
  myFile = SD.open(fname, FILE_WRITE);
  if (myFile) 
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
    fp(pref_ddt); fpi(increase_time);     fp(LocToCh); 
    fp(signd);    fpi(increase_distance); fp(tsz); 
    fpln("");
    myFile.close(); // close the file
    result=true;
  }
  // если файл не открылся выводим сообщение об ошибке
  // и перезагружаем контроллер
  else 
  {
    Serial.print(F("ошибка открытия "));
  }
  Serial.println(DistanceBetween);
  return result;
}

#endif

// ************************************************************** SD_Card.h ***
