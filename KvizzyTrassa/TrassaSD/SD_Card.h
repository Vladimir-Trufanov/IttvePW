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
bool Talk_SD_Card(uint32_t ncikl)
{
  // Формируем строку для файла
  // FillToSD(ncikl); 

  // создание/открытие файла 
  myFile = SD.open("testGPS.txt", FILE_WRITE);
  // if the file opened okay, write to it:
  if (myFile) 
  {
    Serial.print(F("to file...")); Serial.println(ncikl); 
    // Write to file
    myFile.print(ncikl); myFile.print(":");
    myFile.println("Testing text 11, 2 ,3...");
    myFile.close(); // close the file
    //Serial.println("Done.");
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
