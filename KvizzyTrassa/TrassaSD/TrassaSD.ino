/** Arduino C/C++ ******************************************** TrassaSD.ino ***
 *
 * Обеспечить снятие показаний разного рода и запись на SD-карту
 * 
 * v1.0.1, 17.05.2026                                 Автор:      Труфанов В.Е.
 * Copyright © 2025 tve                               Дата создания: 30.04.2026
 *
**/

#include <SoftwareSerial.h>

// Обеспечиваем взаимодействие и выборку данных из приёмника GPS VKEL_TTL 

uint32_t ncikl=0;                       // счетчик циклов

#include "VKEL_TTL.h" 
#include "SIM900.h"   
#include "s32nRF24L01.h"    

/*
#include "GyverWDT.h"
#include <iarduino_VCC.h>
#include <EEPROM.h>

// Обеспечиваем взаимодействие с SIM900 и передачу данных на сайт  

// Определяем переменные адреса (обычного и изменённого) для записи данных в EEPROM
int address; int oldaddress; 
// Определяем переменную флага для записи даты перезагрузки
// (после перезагрузки флаг устанавливается в значение true для того,
// чтобы записать дату первого поступления координат после перезагрузки
// для постоянного хранения)
bool isReboot;       
// Определяем переменную счетчика перезагрузок контроллера для  постоянного хранения
uint16_t nReboot;  

//bool isSIM900=false;                    // "Не работает SIM900" = SIM900 does not work
uint32_t ncikl=0;                       // счетчик циклов
//bool isFullCikl=true;                   // 9: true - "Выполняем прослушивание";        false - "Отрабатываем пустой цикл"
//bool isMemTrass=false;                  // 8: true - "Показываем свободную память";    false - "Отменяем трассирование памяти"
//bool isATTrass=true;                    // 7: true - "Показываем ответ на AT-команды"; false - "Отменяем трассирование AT-команд"
*/

void setup()
{
  Serial.begin(9600);
  Serial.println(F("9600"));
  VKEL_TTL.begin(9600); 
  SIM900.begin(9600);

  /*
  // Переопределяем счетчик перезагрузок контроллера
  address=0; 
  EEPROM.get(address, nReboot);
  if (nReboot==65535) nReboot=0;
  nReboot++;
  EEPROM.put(address,nReboot);
  // Устанавливаем флаг и определяем адрес для записи 
  // даты первого поступления координат после перезагрузки
  isReboot=true; 
  address += sizeof(nReboot); 
  // Запускаем watchdog с таймаутом ~8c
  Watchdog.enable(INTERRUPT_RESET_MODE, WDT_PRESCALER_1024);  
  //delay(1500);
  */
}

/*
// Первый тайм-аут вызовет прерывание и если Watchdog не будет перезапущен,
// то на втором прерывании произойдет жёсткая перезагрузка контроллера
ISR(WATCHDOG) 
{
  // Перезапускаем watchdog с таймаутом ~8c
  Watchdog.enable(INTERRUPT_RESET_MODE, WDT_PRESCALER_1024); 
}
*/

void loop()
{
  ncikl++;

  // Прослушиваем приемник GPS V.KEL-TTL
  // (по умолчанию прослушивается последний инициализированный порт,
  // если требуется прослушивать другой, следует его явно указать)
  VKEL_TTL.listen();
  // Выбираем данные навигации из приёмника GPS V.KEL TTL 
  isVKEL_TTL=Talk_VKEL_TTL(ncikl);
  // Принимаем и запоминаем данные от приемника GPS
  if (isVKEL_TTL)
  {
    //Serial.println(F("Данные от приемника GPS есть"));
  }
  // Выводим причину, пересчитываем и указываем интервал отсутствия сигнала GPS
  else
  {
    Serial.println(F("Отсутствие сигнала GPS"));
    /*
      // Формируем уточняющее сообщение о задержке
      delayGPS=millis()-BdelayGPS; 
      uint32_t deltaSec=delayGPS/1000;
      if (deltaSec<100) SecToChar(deltaSec);
      else 
      {
        uint32_t deltaMin=deltaSec/60;
        if (deltaMin<100) SecToChar(deltaMin,false);
        else DefToChar(m1_Delay99); 
      } 
      // Выводим уточняющее сообщение о задержке
      saymess(charMess);
    */
  } 

  // Работаем с SIM900
  SIM900.listen();
  // Проверяем, реагирует ли на команды SIM900
  // и включаем GPRS, если нет ответа
  uint8_t answeri=AT_com(AT_AT);                  
  // Инициируем переменные
  if (answeri!=0)
  { 
    //Serial.print(F("answeri=")); Serial.println(answeri);
    Serial.println(F("Включаем SIM900, ждем 10 секунд!"));
    // Включаем SIM900
    // saymess(DefToChar(m1_TurnOnSIM900));
    SIM900powerUpOrDown();
    // Начинаем новый отсчет времени для передачи на сайт 
    // BdelaySIM=millis();  
  }
  // Отсчитываем время и отправляем данные положения на сайт
  else
  {
    Serial.println(F("Есть SIM900"));
    /*
        delaySIM=millis()-BdelaySIM; 
        if (delaySIM>dTimeSIM) 
        {
          // Отправляем данные положения на сайт и начинаем новый отсчет времени для передачи на сайт 
          CoordSend();
        }
    */
  }



  delay(100);

  /*
  // Отрабатываем управляющие команды из последовательного порта
  if (Serial.available())
  {
    int ccom = Serial.read();
    // Выполняем команду на пустое зацикливание
    // (например для того, чтобы посмотреть предыдущие сообщения)
    // или отменяем её
    if (ccom == '9') 
    {
      if (isFullCikl) {isFullCikl=false; saymess(DefToChar(m1_EmptyLoop));}
      else            {isFullCikl=true;  saymess(DefToChar(m1_anAudition));}
    }
    // Выполняем команду по трассировке утечек памяти
    // (показывать оставшуюся свободную память)
    // или отменяем её
    if (ccom == '8') 
    {
      if (isMemTrass) 
      {
        isMemTrass=false; 
        saymess(DefToChar(m1_NoMemoryTrace));
        if (!isFullCikl) {isFullCikl=true; saymess(DefToChar(m1_anAudition));}
      }
      else {isMemTrass=true; saymess(DefToChar(m1_FreeMemory));}
    }
    // Выполняем команды по трассировке AT-команд SIM900
    if (ccom == '7') 
    {
      if (isATTrass) 
      {
        isATTrass=false; 
        saymess(DefToChar(m1_NoATtrass));
        if (!isFullCikl) {isFullCikl=true; saymess(DefToChar(m1_anAudition));}
      }
      else {isATTrass=true; saymess(DefToChar(m1_ATcom));}
    }
    // Выполняем принудительную передачу последних принятых координат на сайт
    if (ccom == '1') 
    {
      SIM900.listen();
      CoordSend();
      VKEL_TTL.listen();
    }
  }
  // При необходимости трассируем память
  if (isMemTrass) saymess(FreeMemoryToChar());

  // Начинаем прослушивать устройства и выводить информацию, так как разрешено
  if (isFullCikl)
  {
    ncikl++;

    // Проверяем температуру в коробке
    float R1 = 10000; // значение R1 на модуле
    float logR2,R2;
    float c1 = 0.001129148, c2 = 0.000234125, c3 = 0.0000000876741; // коэффициенты Штейнхарта-Харта для термистора

    int t0 = analogRead(ThermistorPin);
    R2 = R1 * (1023.0 / (float)t0 - 1.0); // вычислили сопротивление на термисторе
    logR2 = log(R2);
    float ti=(1.0/(c1+c2*logR2+c3*logR2*logR2*logR2)); // температура по Кельвину
    ti = ti - 273.15;                                  // температура по Цельсию
    // Считываем напряжение питания
    float vi = analogRead_VCC();      

    // Прослушиваем приемник GPS V.KEL-TTL
    // (по умолчанию прослушивается последний инициализированный порт,
    // если требуется прослушивать другой, следует его явно указать)
    VKEL_TTL.listen();
    // Выбираем данные навигации из приёмника GPS V.KEL TTL 
    isVKEL_TTL=Talk_VKEL_TTL(ncikl);
    // Если данные от приемника GPS есть, то
    // начинаем прослушивать и работать с портом SIM900
    if (isVKEL_TTL)
    {
      // Выводим сообщение о температуре и напряжении питания
      saymess(TempVoltToChar(ti,vi,chardec));
      delay(1000);
      // При необходимости записываем дату перезагрузки
      // и выводим сообщение по перезагрузкам 
      saymess(DateToEEPROM(gday,gmonth,gyear));
      delay(1000);
      // При ненулевых данных выводим сообщение о количестве спутников и точности измерений
      if (HDOP>0) {if (SAT>0) saymess(SatHdopToChar(HDOP,SAT,chardec));}
      delay(1000);
      // Выводим сообщение о времени и смещении от предыдущей точки     
      saymess(DistTimeToChar(DistanceBetween,ghour,gmin,gsec,chardec));
      delay(1000);
      // Выводим сообщение о локации 
      saymess(LocationToChar(lat,lng,chardec));
      // Работаем с SIM900
      SIM900.listen();
      // Проверяем, реагирует ли на команды SIM900
      // и включаем GPRS, если нет ответа
      if (AT_com(AT_AT)!=0)
      { 
        // Включаем SIM900
        saymess(DefToChar(m1_TurnOnSIM900));
        SIM900powerUpOrDown();
        // Начинаем новый отсчет времени для передачи на сайт 
        BdelaySIM=millis();   
      }
      // Отсчитываем время и отправляем данные положения на сайт
      else
      {
        delaySIM=millis()-BdelaySIM; 
        if (delaySIM>dTimeSIM) 
        {
          // Отправляем данные положения на сайт и начинаем новый отсчет времени для передачи на сайт 
          CoordSend();
        }
      }
      // Получаем состояние батареи
      AT_com(AT_CBC);
      // Выбираем первые 4 цифры в ответе
      lipo=getIntByMatch(response,"%d%d%d%d");
      // Проверяем уровень сигнала
      AT_com(AT_CSQ);
      // Выбираем первые одну или более цифры в ответе
      dB=getIntByMatch(response,"%d(%d*)");
      // При ненулевых данных выводим сообщение об уровне сигнала и батареи 
      if (lipo>0) {if (dB>0) saymess(DbAndVoltToChar(lipo,dB,chardec));}
      // Начинаем отсчет интервал в мс до следующего опроса GPS 
      BdelayGPS=millis();   
    }
    // Выводим причину, пересчитываем и указываем интервал отсутствия сигнала GPS
    else
    {
      // Формируем уточняющее сообщение о задержке
      delayGPS=millis()-BdelayGPS; 
      uint32_t deltaSec=delayGPS/1000;
      if (deltaSec<100) SecToChar(deltaSec);
      else 
      {
        uint32_t deltaMin=deltaSec/60;
        if (deltaMin<100) SecToChar(deltaMin,false);
        else DefToChar(m1_Delay99); 
      } 
      // Выводим уточняющее сообщение о задержке
      saymess(charMess);
    } 
  }
  // Если закрыто прослушивание, то делаем заглушку 1 сек 
  else delay(1000);
  */
}
