/** Arduino UNO, SIM900 ***************************************** SD_Card.h ***
 * 
 * Обеспечить запись данных на SD 
 * 
 * v1.0.0, 25.05.2026                                 Автор:      Труфанов В.Е.
 * Copyright © 2026 tve                               Дата создания: 25.05.2026
**/

#ifndef SD_Card_h
#define SD_Card_h
#pragma once  

//#include "s32nRF24L01.h"    

uint32_t dTimeSD=10000;       // заданный интервал между записями на SD в мс (180000 = 3 мин)  
uint32_t BdelaySD=millis();   // начало отсчета интервала записи данных на SD 
uint32_t delaySD;             // фактическое время после предыдущей записи на SD

// ****************************************************************************
// *              Сформировать и записать данные в файл на SD-карте           *
// ****************************************************************************

#define tsz      ";"
#define dZero    "0"    
#define Twodots  ":" 
#define LocToCh  "-"    
#define Point    "."    

#define pref_tid "tid"    
#define pref_krd "krd"    

// Определяем макрос для вывода значения в файл
#define fp(value) myFile.print(value)
#define fpln(value) myFile.println(value)

bool Talk_SD_Card()
{
  // создание/открытие файла 
  myFile = SD.open("testGPS.txt", FILE_WRITE);
  // if the file opened okay, write to it:
  if (myFile) 
  {
    Serial.print(F("to file... ")); Serial.println(ncikl); 
    // Формируем индекс по номеру цикла
    fp(ncikl); fp(tsz);
    // "tid2026.05.18-20:43:23;"
    fp(pref_tid); fp(IntToChar(gyear)); fp(Point);
    if (gmonth<10) {fp(dZero); fp(IntToChar(gmonth));}
    else fp(IntToChar(gmonth)); fp(Point);
    if (gday<10) {fp(dZero); fp(IntToChar(gday));}
    else fp(IntToChar(gday)); fp(LocToCh);
    if (ghour<10) {fp(dZero); fp(IntToChar(ghour));}
    else fp(IntToChar(ghour)); fp(Twodots);
    if (gmin<10) {fp(dZero); fp(IntToChar(gmin));}
    else fp(IntToChar(gmin)); fp(Twodots);
    if (gsec<10) {fp(dZero); fp(IntToChar(gsec));}
    else fp(IntToChar(gsec)); fp(tsz);
    // "krd61.80191-34.32987-11;"
    fp(pref_krd); dtostrf(lat,2,5,chardec); fp(chardec); fp(LocToCh);
    dtostrf(lng,2,5,chardec); fp(chardec); fp(LocToCh);
    IntToChar(SAT); fp(charNumby); fp(tsz);
    // "sim24-vg4.12-vc4.54"
  /*
  memset(simMess,'\0',34); 
  strcat_P(simMess,pref_sim); 
  strcat(simMess,IntToChar(dB)); 
  strcat_P(simMess,LocToCh); 
  strcat_P(simMess,vg); 
  double vib=double(lipo)/1000;
  dtostrf(vib,1,2,chardec); strcat(simMess,chardec);
  strcat_P(simMess,LocToCh); 
  strcat_P(simMess,vc); 
  dtostrf(vi,1,2,chardec); strcat(simMess,chardec);
  */
    fpln("");
    myFile.close(); // close the file
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
