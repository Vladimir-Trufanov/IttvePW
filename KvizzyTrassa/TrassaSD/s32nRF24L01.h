/** Arduino UNO, SIM900 ************************************* s32nRF24L01.h ***
 * 
 * Обеспечить размещение 32-символьных сообщений для nRF24L01.h в программной 
 * памяти и вывод их в последовательный порт или другой интерфейс
 * без копирования в оперативную память
 * 
 * v4.0.2, 19.05.2026                                 Автор:      Труфанов В.Е.
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
char krdMess[34];   // буфер сообщения c текущими координатами и числом спутников 
char tidMess[34];   // буфер сообщения о дате и времени  
char simMess[34];   // буфер сообщения о дате и времени  

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
// *              Сформировать сообщение о локации и числе спутников          *
// ****************************************************************************
_DS(LocToCh,"-")    
_DS(pref_krd,"krd")    
char* LocationToChar(double lat, double lng, int SAT, char chardec[]) 
{
  // "krd61.80191-34.32987-11"
  memset(krdMess,'\0',34); 
  strcat_P(krdMess,pref_krd); 
  dtostrf(lat,2,5,chardec); strcat(krdMess,chardec);
  strcat_P(krdMess,LocToCh); 
  dtostrf(lng,2,5,chardec); strcat(krdMess,chardec);
  strcat_P(krdMess,LocToCh); 
  strcat(krdMess,IntToChar(SAT));
  return krdMess;  
} 
// ****************************************************************************
// *                   Сформировать сообщение о дате и времени                *
// ****************************************************************************
_DS(pref_tid,"tid")    
_DS(Point,".")    
_DS(Twodots,":") 
_DS(dZero,"0")    
char* DateTimeToChar(int ghour, int gmin, int gsec, int gday, int gmonth, int gyear, char chardec[]) 
{
  // "tid2026.05.18-20:43:23"
  memset(tidMess,'\0',34); 
  strcat_P(tidMess,pref_tid); 
  strcat(tidMess,IntToChar(gyear)); 
  strcat_P(tidMess,Point); 
  if (gmonth<10) {strcat_P(tidMess,dZero); strcat(tidMess,IntToChar(gmonth));}
  else strcat(tidMess,IntToChar(gmonth)); 
  strcat_P(tidMess,Point); 
  if (gday<10) {strcat_P(tidMess,dZero); strcat(tidMess,IntToChar(gday));}
  else strcat(tidMess,IntToChar(gday)); 
  strcat_P(tidMess,LocToCh); 
  if (ghour<10) {strcat_P(tidMess,dZero); strcat(tidMess,IntToChar(ghour));}
  else strcat(tidMess,IntToChar(ghour)); 
  strcat_P(tidMess,Twodots); 
  if (gmin<10) {strcat_P(tidMess,dZero); strcat(tidMess,IntToChar(gmin));}
  else strcat(tidMess,IntToChar(gmin)); 
  strcat_P(tidMess,Twodots); 
  if (gsec<10) {strcat_P(tidMess,dZero); strcat(tidMess,IntToChar(gsec));}
  else strcat(tidMess,IntToChar(gsec)); 
  return tidMess;  
}
// ****************************************************************************
// *         Сформировать сообщение об уровне сигнала и батареи GPRS          *
// ****************************************************************************
_DS(pref_sim,"sim")    
char* DbAndVoltToChar(int lipo, int dB, char chardec[]) 
{
  // "sim24-4.56"
  memset(simMess,'\0',34); 
  strcat_P(simMess,pref_sim); 
  strcat(simMess,IntToChar(dB)); 
  strcat_P(simMess,LocToCh); 
  double vib=double(lipo)/1000;
  dtostrf(vib,1,2,chardec); strcat(simMess,chardec);
 
  /*
  strcat_P(charMess,gprs); 
  if (dB<10) {strcat_P(charMess,DistT4); strcat(charMess,IntToChar(dB));}
  else strcat(charMess,IntToChar(dB)); 
  strcat_P(charMess,dbzpt); 
  double vib=double(lipo)/1000;
  dtostrf(vib,1,2,chardec); strcat(charMess,chardec);strcat_P(charMess,vvq); 
  */
  return simMess;  
}  


/* Пример сообщений:

$GPGSV,4,1,13,01,61,199,19,02,35,173,28,03,59,264,09,04,13,217,24*78
$GPGSV,4,2,13,06,01,318,,12,12,020,,13,14,022,,17,32,287,*7F
$GPGSV,4,3,13,19,24,321,11,25,07,056,18,28,38,105,28,31,23,136,28*7A
$GPGSV,4,4,13,32,36,064,16*4A
$GPGLL,6148.11477,N,03419.79022,E,143322.00,A,A*62
$GPRMC,143323.00,A,6148.11498,N,03419.79004,E,0.241,,170526,,,A*7F
$GPVTG,,T,,M,0.241,N,0.446,K,A*22
$GPGGA,143323.00,6148.11498,N,03419.79004,E,1,05,1.97,73.0,M,14.2,M,,*6A
$GPGSA,A,3,02,28,32,04,31,,,,,,,,4.94,1.97,4.53*09

$GPGSV,4,1,13,01,61,199,18,02,35,173,28,03,59,264,09,04,13,217,23*7E
$GPGSV,4,2,13,06,01,318,,12,12,020,,13,14,022,,17,32,287,*7F
$GPGSV,4,3,13,19,24,321,11,25,07,056,18,28,38,105,28,31,23,136,29*7B
$GPGSV,4,4,13,32,36,064,15*49
$GPGLL,6148.11498,N,03419.79004,E,143323.00,A,A*66
$GPRMC,143324.00,A,6148.11509,N,03419.78991,E,0.226,,170526,,,A*74
$GPVTG,,T,,M,0.226,N,0.418,K,A*28
$GPGGA,143324.00,6148.11509,N,03419.78991,E,1,05,1.97,73.0,M,14.2,M,,*60
$GPGSA,A,3,02,28,32,04,31,,,,,,,,4.94,1.97,4.53*09

Для сообщения:
$GPGGA, 023554.000,4657.9000,N,14243.1000,E,1,05,2.3,89.3,M,25.2,M,,0000*6C

Сообщение GPGGA – это информация о фиксированном решении (есть ещё GPGSV – информация о спутниках) и т.д.
Первый параметр – точное время: 023554.000 – это 02:35:54 UTC, прибавляем 10 часов и получаем 12:35:54 локальное время. 
Прибавку к времени легко узнать по часовому поясу.

Второй и третий параметры – широта и долгота:
4657.9000 = 46°57.9000 N
14343.1000 = 143°43.1000 E

Далее тип решения, 1 – StandAlone – самостоятельный.
05 – количество спутников.
2.3 – относительная горизонтальная точность.
89.3,М – высота над уровнем моря.  Далее высота от эллипсойда WGS84

Последний параметр – контрольная сумма
*/

#endif

// ********************************************************** s32nRF24L01.h ***

