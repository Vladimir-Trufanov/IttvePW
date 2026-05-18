/** Arduino UNO, SIM900 ************************************* s32nRF24L01.h ***
 * 
 * Обеспечить размещение 32-символьных сообщений для nRF24L01.h в программной 
 * памяти и вывод их в последовательный порт или другой интерфейс
 * без копирования в оперативную память
 * 
 * v4.0.1, 18.05.2026                                 Автор:      Труфанов В.Е.
 * Copyright © 2025 tve                               Дата создания: 16.10.2025
**/

#ifndef s32_nRF24L01_h
#define s32_nRF24L01_h
// Указываем, что данный файл нужно подключить только один раз
#pragma once    

// #include <MemoryFree.h>

// Определяем макрос для размещения массива символов в программной памяти:
// const char pstr[] PROGMEM = "Массив символов pgm в программной памяти, Flash вместо RAM";
#define _DS(name,value) const char name[] PROGMEM = value;
// Определяем макрос для выборки массива символов из Flash 
// напрямую, без копирования их в оперативную память RAM:
// (const __FlashStringHelper*) pstr
#define _FS(name) (const __FlashStringHelper*) name

// Готовим массивы символов для формирования сообщений
char chardec[8];    // буфер координат, дистанции, температуры, напряжения - max 7 знаков и точка (nt)
char krdMess[34];   // буфер сообщения c текущими координатами  
char tidMess[34];   // буфер сообщения о дате и времени  

// ****************************************************************************
// *                       Сформировать сообщение о локации                   *
// ****************************************************************************
_DS(LocToCh,"-")    
_DS(pref_krd,"krd")    
char* LocationToChar(double lat, double lng, char chardec[]) 
{
  // "krd61.80191-34.3298"
  memset(krdMess,'\0',34); 
  strcat_P(krdMess,pref_krd); 
  dtostrf(lat,2,5,chardec); strcat(krdMess,chardec);
  strcat_P(krdMess,LocToCh); 
  dtostrf(lng,2,5,chardec); strcat(krdMess,chardec);
  return krdMess;  
} 
/*
// ****************************************************************************
// *               Сформировать сообщение о перемещении и времени             *
// *         (перемещение это расстояние до предыдущей точке локации)         *
// ****************************************************************************
_DS(DistT1," m.")    
_DS(DistT2,":")    
_DS(DistT3,"0")    
_DS(DistT4," ")    
_DS(DistT5,">1000")    
char* DistTimeToChar(double DistanceBetween, int ghour, int gmin, int gsec, char chardec[]) 
{
  // "1234567890123456"
  // "Движение 10.86 м"
  // "Движение 110.8 м"
  // "16:27:31 110.8 м"
  // "16:27:31 >1000 м"
  memset(charMess,'\0',34); 
  if (ghour<10) {strcat_P(charMess,DistT3); strcat(charMess,IntToChar(ghour));}
  else strcat(charMess,IntToChar(ghour)); 
  strcat_P(charMess,DistT2); 
  if (gmin<10) {strcat_P(charMess,DistT3); strcat(charMess,IntToChar(gmin));}
  else strcat(charMess,IntToChar(gmin)); 
  strcat_P(charMess,DistT2); 
  if (gsec<10) {strcat_P(charMess,DistT3); strcat(charMess,IntToChar(gsec));}
  else strcat(charMess,IntToChar(gsec)); 
  strcat_P(charMess,DistT4); 
  if (DistanceBetween<100)         {dtostrf(DistanceBetween,2,2,chardec); strcat(charMess,chardec);} 
  else if (DistanceBetween<999.99) {dtostrf(DistanceBetween,3,1,chardec); strcat(charMess,chardec);}   
  else strcat_P(charMess,DistT5);
  strcat_P(charMess,DistT1); 
  return charMess;  
} 
*/




/*
// Готовим определения для вывода сообщений во внешнее приложение
char app[]="Kvizzy900";   // имя текущего приложения для внешнего приложения
#define _extmess_h        // если определено, то передавать сообщение во внешнее приложение
#ifdef _extmess_h
  #include "mess_Lcd1602v3.h"
#endif

// Представляем все сообщения 1 приложения "m1" (из 16 символов юникода)
// (из-за особенностей драйвера для LCD1602 по максимуму русские буквы
// представлены латинскими)
_DS(m1_Fill,          "                ")    // 16 байт
_DS(m1_Full,          "1234567890123456")    // 16 байт
_DS(m1_NotSignGPS,    "HET CИГHAЛA GPS ")    // "Приемник GPS не подает сигналы"
_DS(m1_SIM900notWork, "OTKЛЮЧEH SIM900 ")    // "Не работает SIM900"
_DS(m1_anAudition,    "ПPOCЛУШИBAEM GPS")    // "Выполняем прослушивание" - Performing an audition
_DS(m1_EmptyLoop,     "ИДET ПУCTOЙ ЦИKЛ")    // "Отрабатываем пустой цикл" - Working out an empty loop
_DS(m1_Delay99,       "ЗAДEPЖKA >99 min")    // "Задержка >99 мин"
_DS(m1_TimeIsNot,     "HET XOДA BPEMEHИ")    // "Не определяется время" - The time is not being determined
_DS(m1_DateIsNot,     "HET ДAHHЫX ДATЫ ")    // "Не определяется дата" - The date is not being determined
_DS(m1_LocateIsNot,   "HE ИДET ЛOKAЦИЯ ")    // "Не определяется локация" - "Location is not being determined"
_DS(m1_TurnOnSIM900,  "BKЛЮЧAEM SIM900 ")    // "Включаем SIM900" - "Turning on the SIM900"
_DS(m1_FreeMemory,    "CMOTPИM ПAMЯTЬ  ")    // "Показываем свободную память" - Showing free memory
_DS(m1_NoMemoryTrace, "HE ГЛЯДИM ПAMЯTЬ")    // "Отменяем трассирование памяти" - Canceling memory tracing
_DS(m1_ATcom,         "ECTЬ AT-KOMAHДЫ ")    // "Показываем ответ на AT-команды"
_DS(m1_NoATtrass,     "HE TPACCИPУEM AT")    // "Отменяем трассирование AT-команд"
_DS(m1_ResponsExceed, "SIM900 > 169 cим")    // "Ответ SIM900 превышает 169 символов" - The SIM900 response exceeds 169 characters
_DS(m1_NoReception,   "HET ПPИEMA GPRS ")    // "За время тайм-аута не начат приём" - No reception is started during the timeout period
_DS(m1_NoConfirmed,   "HE УCПEШEH GPRS ")    // "Oтвет на команду не подтвержден" - The response to the command has not been confirmed
_DS(m1_NotCompleted,  "HE ПOЛHЫЙ OTBET ")    // "За время тайм-аута не завершён ответ" - The response was not completed during the timeout period
_DS(m1_Wait5sek,      "ЖДEM OTBET 5 sec")    // "Ждем 5 сек для получения ответа" - "Waiting for a response for 5 seconds"
_DS(m1_SendCoordints, "----> KOOPДИHATЫ")    // "Отправляем координаты" - "Sending the coordinates"
_DS(m1_CoordinatGone, "KOOPДИHATЫ ====>")    // "Координаты ушли" - "The coordinates are gone"

// ****************************************************************************
// *         Вывести сообщение внутри приложения в последовательный порт      *
// ****************************************************************************
/ *
В Arduino есть специальный класс-обёртка для PROGMEM строк - __FlashStringHelper. 
Ардуиновский же интерфейс Print умеет печатать такие строки напрямую, без копирования 
их в оперативную память. Это позволяет печатать такие строки почти на все существующие дисплеи - 
библиотеки для них обычно поддерживают Print. Arduino-строки String также умеют 
создаваться из таких строк и прибавлять такие строки.

Работа со строками в программной памяти: https://alexgyver.ru/lessons/progmem/
Директивы препроцессора:                 https://alexgyver.ru/lessons/preprocessor/

1)
const char pstri[] PROGMEM = "pgm из программы string";
PGM_P ppstrp = pstri;

Serial.println((const __FlashStringHelper*) ppstrp);   // напечатает "pgm из программы string"
String s =     (const __FlashStringHelper*) ppstrp;    // создаст строку с "pgm из программы string"
Serial.println(s);                                     // напечатает "pgm из программы string"

2)
#define FPSTR(s) (const __FlashStringHelper*)(s)
const char pstr_g[] PROGMEM = "global pgm str";

Serial.println(FPSTR(pstr_g));  // напечатает "global pgm str"
saymess(pstr_g);

void saymess(char mess[])
{
  Serial.println(FPSTR(mess));  // v1
  Serial.println(_FS(mess));    // v2
}
 * /
// **************************************************
// Здесь есть важный момент:
// когда прослушивается SIM900, то не работают A4,A5,
// поэтому переключаем прослушивание на VKEL_TTL
// **************************************************
void saymess(char mess[])
{
  Serial.println(mess);
  #ifdef _extmess_h
    VKEL_TTL.listen();
    delay(500);
    extmess(app,mess);
    delay(500);
    SIM900.listen();
  #endif
}
// ****************************************************************************
// *    Поместить в буфер для вывода на дисплей текст из программной памяти   *
// ****************************************************************************
char* DefToChar(char mess[]) 
{
  memset(charMess,'\0',34); 
  strcat_P(charMess,mess); 
  return charMess; 
}
// ****************************************************************************
// *            Преобразовать беззнаковое  целое в строку символов            *
// ****************************************************************************
char charNumby[10]; // char[9]+'\0'
char* IntToChar(uint32_t numbIn) 
{
  uint32_t numby=numbIn;
  memset(charNumby,'\0',10); 
  if (numby>999999999) numby=999999999;
  String(numby).toCharArray(charNumby,10);
  return charNumby;
}
// ****************************************************************************
// *                       Сформировать сообщение по памяти                   *
// *                      (кириллица занимает 2 байта в UTF8)                 *
// ****************************************************************************
_DS(FreeM1, "ПAMЯTЬ ")    
_DS(FreeM2, " БAЙT")    
char* FreeMemoryToChar() 
{
  memset(charMess,'\0',34); 
  // "1234567890123456"
  // "Память 1017 байт"
  strcat_P(charMess,FreeM1); 
  strcat(charMess,IntToChar(getFreeMemory()));   
  strcat_P(charMess,FreeM2);
  return charMess; 
}  
// ****************************************************************************
// *                Сформировать сообщение о задержке сигнала GPS             *
// ****************************************************************************
_DS(SecToCh1,"ЗAДEPЖKA ")    
_DS(SecToCh2," sec.")    
_DS(SecToCh3," min.")    
char* SecToChar(uint32_t MinSec, bool isSec=true) 
{
  // "1234567890123456"
  // "Задержка 23 сек."
  // "Задержка 99 мин."
  // "Задержка >99 мин"
  memset(charMess,'\0',34); 
  strcat_P(charMess,SecToCh1); 
  strcat(charMess,IntToChar(MinSec));   
  if (isSec) strcat_P(charMess,SecToCh2); 
  else strcat_P(charMess,SecToCh3); 
  return charMess; 
}  
// ****************************************************************************
// *               Сформировать сообщение о перемещении и времени             *
// *         (перемещение это расстояние до предыдущей точке локации)         *
// ****************************************************************************
_DS(DistT1," m.")    
_DS(DistT2,":")    
_DS(DistT3,"0")    
_DS(DistT4," ")    
_DS(DistT5,">1000")    
char* DistTimeToChar(double DistanceBetween, int ghour, int gmin, int gsec, char chardec[]) 
{
  // "1234567890123456"
  // "Движение 10.86 м"
  // "Движение 110.8 м"
  // "16:27:31 110.8 м"
  // "16:27:31 >1000 м"
  memset(charMess,'\0',34); 
  if (ghour<10) {strcat_P(charMess,DistT3); strcat(charMess,IntToChar(ghour));}
  else strcat(charMess,IntToChar(ghour)); 
  strcat_P(charMess,DistT2); 
  if (gmin<10) {strcat_P(charMess,DistT3); strcat(charMess,IntToChar(gmin));}
  else strcat(charMess,IntToChar(gmin)); 
  strcat_P(charMess,DistT2); 
  if (gsec<10) {strcat_P(charMess,DistT3); strcat(charMess,IntToChar(gsec));}
  else strcat(charMess,IntToChar(gsec)); 
  strcat_P(charMess,DistT4); 
  if (DistanceBetween<100)         {dtostrf(DistanceBetween,2,2,chardec); strcat(charMess,chardec);} 
  else if (DistanceBetween<999.99) {dtostrf(DistanceBetween,3,1,chardec); strcat(charMess,chardec);}   
  else strcat_P(charMess,DistT5);
  strcat_P(charMess,DistT1); 
  return charMess;  
} 
// ****************************************************************************
// *    Сформировать сообщение о количестве спутников и точности измерений    *
// ****************************************************************************

/ * Некоторые значения HDOP и их интерпретация:
0–1 — идеальная точность,                             0.0 --> 2.0 метров 
координаты имеют погрешность в пределах 2–5 метров.   1.0 --> 5.0 метров [3] => HDOPm=2+(3*HDOP);

HDOP=0 => HDOPm=2;  HDOP=1 => HDOPm=5;  HDOP=0.5 => HDOPm=3.5 = 4;  

1–3 — высокая точность,                v0=1 --> 5m.  deltaMax=2 --> 5.0 метров 
погрешность обычно в диапазоне 5–10 метров.   (HDOP-1) = deltav --> x метров => x=(HDOP-1)*5/2 => HDOPm-5=(HDOP-1)*5/2 => HDOPm=(HDOP-1)*5/2+5;

HDOP=1 => HDOPm=5;  HDOP=3 => HDOPm=10;  HDOP=2 => HDOPm=7.5 = 8;  

3–6 — средняя точность,               v0=3 --> 10m.  deltaMax=3 --> 40.0 метров 
погрешность может достигать 10–50 метров.     (HDOP-3) = deltav --> x метров => x=(HDOP-3)*40/3 => HDOPm-10=(HDOP-3)*40/3 => HDOPm=(HDOP-3)*40/3+10;

HDOP=3 => HDOPm=10;  HDOP=6 => HDOPm=50;  HDOP=4.5 => HDOPm=30;  

* /
_DS(Equ,"SAT=")    
_DS(Zpt,",")    
_DS(Zptp,", ")    
_DS(b50,">50m")    
_DS(Mto,"m.")    
//_DS(DistT4," ")    
char* SatHdopToChar(double HDOP, int SAT, char chardec[]) 
{
  // Высчитываем погрешность координат (точность) в метрах
  int HDOPm;  
  // "1234567890123456"
  // "SAT=17, TOЧ=17m."
  // "SAT=17,17m. 1.63"  1
  // "SAT=7, 17m. 1.63"  2
  // "SAT=7,  7m. 1.63"  3
  // "SAT=7, >50m 1.63"  4
  memset(charMess,'\0',34);
  // Выводим количество спутников 
  strcat_P(charMess,Equ); 
  if (SAT<10) {strcat(charMess,IntToChar(SAT)); strcat_P(charMess,Zptp);}
  else        {strcat(charMess,IntToChar(SAT)); strcat_P(charMess,Zpt);}
  // Выводим погрешность координат (точность), пересчитанную в метры
  if (HDOP>6) HDOPm=99;
  else if (HDOP>3) HDOPm=round((HDOP-3)*40/3)+10;   
  else if (HDOP>1) HDOPm=round((HDOP-1)*5/2)+5;  
  else HDOPm=2+round((3*HDOP));
  
  if (HDOPm>50) strcat_P(charMess,b50);
  else if (HDOPm>9) {strcat(charMess,IntToChar(HDOPm)); strcat_P(charMess,Mto);}   
  else {strcat_P(charMess,DistT4); strcat(charMess,IntToChar(HDOPm)); strcat_P(charMess,Mto);}  
  // Выводим HDOP
  if (HDOP<10) {strcat_P(charMess,DistT4); dtostrf(HDOP,1,2,chardec); strcat(charMess,chardec);}
  return charMess;  
} 
// ****************************************************************************
// *     Вывести данные о перезапусках, а при необходимости записать для      *
// *            постоянного хранения дату поступления координат               *
// ****************************************************************************
_DS(Tires,"~")    
_DS(Point,".")    
//_DS(DistT4," ")    
char* DateToEEPROM(int gday, int gmonth, int gyear) 
{
  // Если установлен флаг перезагрузки, то записываем дату
  // на постоянное хранение
  if (isReboot)
  {
    oldaddress=address; 
    memset(charMess,'\0',34); 
    if (gday<10) {strcat_P(charMess,DistT3); strcat(charMess,IntToChar(gday));}
    else strcat(charMess,IntToChar(gday)); 
    strcat_P(charMess,Point); 
    if (gmonth<10) {strcat_P(charMess,DistT3); strcat(charMess,IntToChar(gmonth));}
    else strcat(charMess,IntToChar(gmonth)); 
    strcat_P(charMess,Point); 
    strcat(charMess,IntToChar(gyear)); 
    for (int i = 0; i < strlen(charMess); i++) 
    {
      EEPROM.put(address, charMess[i]);
      address += sizeof(char); // Увеличение адреса на размер char (1 байт) для каждого символа
    }
    isReboot=false;
    address=oldaddress;
  }
  oldaddress=address; 
  // Извлекаем дату перезагрузки
  //            123456789012
  char str[12]="            ";  
  memset(str,'\0',12); 
  for (int i = 0; i < 10; i++) 
  {
    EEPROM.get(address,str[i]);
    address += sizeof(char);
  }
  address=oldaddress;
  //Serial.print(" address="); Serial.println(address);
  //Serial.print("     str="); Serial.println(str);
  // Выводим число перезагрузок 
  // "1234567890123456"
  // "12345~25.11.2025"
  memset(charMess,'\0',34); 
  EEPROM.get(0,nReboot);
  if (nReboot>9999) strcat(charMess,IntToChar(nReboot));
  else
  {
    // "4321"
    strcat_P(charMess,DistT4);
    if (nReboot>999) strcat(charMess,IntToChar(nReboot));
    else
    {
      // "321"
      strcat_P(charMess,DistT4);
      if (nReboot>99) strcat(charMess,IntToChar(nReboot));
      else
      {
        // "21"
        strcat_P(charMess,DistT4);
        if (nReboot>9) strcat(charMess,IntToChar(nReboot));
        else
        {
          strcat_P(charMess,DistT4); strcat(charMess,IntToChar(nReboot));
        }
      }
    }
  }
  // Выводим разделитель 
  strcat_P(charMess,Tires);
  // Выводим дату 
  strcat(charMess,str);
  return charMess;  
} 
// ****************************************************************************
// *             Сформировать сообщение о температуре и напряжении            *
// ****************************************************************************
_DS(tEq,"t=")    
_DS(vEq,"C,v=")    
_DS(vvq,"V")    
char* TempVoltToChar(float ti, float vi, char chardec[]) 
{
  // "1234567890123456"
  // "t=25.22C,v=4.56V"
  memset(charMess,'\0',18); 
  strcat_P(charMess,tEq); dtostrf(ti,2,2,chardec); strcat(charMess,chardec);
  strcat_P(charMess,vEq); dtostrf(vi,1,2,chardec); strcat(charMess,chardec);
  strcat_P(charMess,vvq); 
  return charMess;  
}  
// ****************************************************************************
// *         Сформировать сообщение об уровне сигнала и батареи GPRS          *
// ****************************************************************************
_DS(gprs,"GPRS ")    
_DS(dbzpt,"dB, ")
//_DS(DistT4," ")    
char* DbAndVoltToChar(int lipo, int dB, char chardec[]) 
{
  // "1234567890123456"
  // "GPRS  5dB, 4.56V"
  memset(charMess,'\0',18); 
  strcat_P(charMess,gprs); 
  if (dB<10) {strcat_P(charMess,DistT4); strcat(charMess,IntToChar(dB));}
  else strcat(charMess,IntToChar(dB)); 
  strcat_P(charMess,dbzpt); 
  double vib=double(lipo)/1000;
  dtostrf(vib,1,2,chardec); strcat(charMess,chardec);strcat_P(charMess,vvq); 
  return charMess;  
}  
*/

#endif

// ********************************************************** s32nRF24L01.h ***

