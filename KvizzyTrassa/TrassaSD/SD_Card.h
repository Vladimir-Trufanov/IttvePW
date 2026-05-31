/** Arduino UNO, SIM900 ***************************************** SD_Card.h ***
 * 
 * Обеспечить запись данных на SD 
 * 
 * v2.0.3, 31.05.2026                                 Автор:      Труфанов В.Е.
 * Copyright © 2026 tve                               Дата создания: 25.05.2026
**/

#ifndef SD_Card_h
#define SD_Card_h
#pragma once  

#include <SD.h>
#include <SPI.h>
#include <iarduino_VCC.h>
#include "s32nRF24L01.h"    

// ****************************************************************************
// *          Сформировать фрагменты записи данных в файл на SD-карте         *
// ****************************************************************************

#define tsz      F(";")
#define dZero    F("0")    
#define Twodots  F(":") 
#define LocToCh  F("-")    
#define Point    F(".")    

#define pref_tid F("tid")    
#define pref_krd F("krd")    
#define pref_sim F("sim")  
#define pref_dtd F("dtd")  
#define Space    F(" ")  

#define vg       F("vg")    
#define vc       F("vc")    

// Определяем макрос для вывода значения в файл
#define fp(value) myFile.print(value)
#define fpi(integer) myFile.print(IntToChar(integer))
//#define fpd(integer) if (integer<10) {fp(dZero); fp(IntToChar(integer));} else fp(IntToChar(integer))
#define fco(coord) dtostrf(coord,2,5,charNumby); fp(charNumby)
#define fuu(volti) dtostrf(volti,1,2,charNumby); fp(charNumby)
#define fpln(value) myFile.println(value)

#define fnamesize 20    // размер поля даты/времени в имени файла         

// ****************************************************************************
// *    По строке символов принятой информации с часов контроллера SIM900:    *
// *                 '+CCLK: "26/05/28,11:23:13+12"'                          *
// *        сформировать имя для формирования файла с данными GPS/GSM:        *
// *                       "gps260518_1123.txt"                               *
// ****************************************************************************
_DS(pref_gps,"g")    
_DS(ptxt,".txt")    

bool Talk_SD_Card()
{
  // !!! Стандартная библиотека SD.h ограничивает длину имени файла 8 символами 
  // (плюс возможное расширение из 3 символов). 
  // Это связано с форматом 8.3, который используется в файловых системах FAT. 
  File myFile;                         // дескриптор файла
  bool result=false;
  char fname[fnamesize]="testGPS.txt"; // "g260518x.txt"    

  // Считываем напряжение питания
  float vi = analogRead_VCC(); 
  // Формируем имя файла    
  memset(fname,'\0',fnamesize); 
  strcat_P(fname,pref_gps); 
  strcat(fname,charDatdt); 
  strcat_P(fname,ptxt); 

  //fname[fnamesize]="g05291138.txt";
  //fname[fnamesize]="gps.txt";
  Serial.print(fname); Serial.print(Space); Serial.print(ncikl); Serial.print(Space);   
  // Создаём/открываем файл для записи 
  myFile = SD.open(fname, FILE_WRITE);
  if (myFile) 
  {
    // Формируем индекс по номеру цикла
    fp(ncikl); fp(tsz);
    // "tid260518_1123;"
    fp(pref_tid); 
    fp(charNumby); fp(tsz);
    // "krd61.80191-34.32987-11;"
    fp(pref_krd); fco(lat); fp(LocToCh); 
    fco(lng); fp(LocToCh); 
    fpi(SAT); fp(tsz);
    // "sim24-vg4.12-vc4.54;"
    fp(pref_sim); fpi(dB); fp(LocToCh); fp(vg); double vig=double(lipo)/1000; fuu(vig); fp(LocToCh); 
    fp(vc); fuu(vi); fp(tsz); 
    // "dtd123456789;"
    fp(pref_dtd); fpi(increase_distance); fp(tsz); 
    fpln("");
    myFile.close(); // close the file
    Serial.println(Point);  
    result=true;
  }
  // если файл не открылся выводим сообщение об ошибке
  // и перезагружаем контроллер
  else 
  {
    Serial.println(F("ошибка открытия "));
  }
  return result;
}

#endif

// ************************************************************** SD_Card.h ***
