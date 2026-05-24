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

#include "s32nRF24L01.h"    

uint32_t dTimeSD=10000;       // заданный интервал между записями на SD в мс (180000 = 3 мин)  
uint32_t BdelaySD=millis();   // начало отсчета интервала записи данных на SD 
uint32_t delaySD;             // фактическое время после предыдущей записи на SD

// ****************************************************************************
// *         Выбрать данные навигации из буфера приёмника GPS V.KEL TTL,      *
// *                в случае неудачи вывести сообщение об ошибке              *
// ****************************************************************************
bool Talk_SD_Card(uint32_t ncikl)
{
  if (ncikl<11) 
  {
    Serial.println(F("Talk_SD_Card: ожидается прием координат"));
  }
  else
  {
    // Формируем строку выходного сообщения
    //Serial.print(F("--SD1: ")); Serial.println(ncikl); 
    /*
    */
    FillToSD(ncikl); 
    Serial.print(F("--SD2: ")); Serial.println(sdline); 
    Serial.print(F("--SD3: ")); Serial.println(tidMess); 
  
 

  }
  return true;
}


#endif

// ************************************************************** SD_Card.h ***
