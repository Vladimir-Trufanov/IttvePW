/** Arduino C/C++ ******************************************* Kvizzy900.ino ***
 *
 * Выводить данные GPS на сайт                  
 * (ориентировочно - от окна гостинной:  по гармину = 61.80193,  34.32983   
 *                                       по яндекс  = 61.802082, 34.329586)  
 * По материалам сайтов:
 * https://github.com/arduino/ArduinoCore-primo/blob/master/libraries/SoftwareSerial/examples/TwoPortReceive/TwoPortReceive.ino
 * https://docs.arduino.cc/tutorials/communication/TwoPortReceive/
 * 
 * В скетче принимает данные с двух программных последовательных портов и
 * отправляет их на аппаратный последовательный порт.
 * 
 * Чтобы прослушать программный порт, вызывается метод port.listen().
 * При использовании двух программных последовательных портов необходимо переключать порты,
 * прослушивая каждый из них по очереди. Следует выбирать логичное время для переключения
 * портов, например, в конце ожидаемой передачи или когда буфер пуст. 
 *
 * Вместо устаревшей TinyGPS используется TinyGPSPlus.
 * 
 * v3.0.8, 06.04.2026                                 Автор:      Труфанов В.Е.
 * Copyright © 2025 tve                               Дата создания: 16.10.2025
 *
 * Скетч использует 25928 байт (80%) памяти устройства. Всего доступно 32256 байт.
 * Глобальные переменные используют 1415 байт (69%) динамической памяти, оставляя 633 байт для локальных переменных. Максимум: 2048 байт.
 * "C:\Users\Евгеньевич\AppData\Local\Arduino15\packages\arduino\tools\avrdude\8.0.0-arduino1/bin/avrdude" "-CC:\Users\Евгеньевич\AppData\Local\Arduino15\packages\arduino\tools\avrdude\8.0.0-arduino1/etc/avrdude.conf" -v -V -patmega328p -carduino "-PCOM15" -b115200 -D "-Uflash:w:C:\Users\Евгеньевич\AppData\Local\arduino\sketches\5EBB7E33EDD7F94B809681A5B41B83AC/Kvizzy900.ino.hex:i"
 * Avrdude version 8.0-arduino.1
 * Copyright see https://github.com/avrdudes/avrdude/blob/main/AUTHORS
 * 
 * v3.0.7, 10.12.2025:  26052 = 80% => 1544 => 504 [446]
 * v3.0.8, 06.04.2026:  25928 = 80% => 1415 => 633
 *
**/

#include <SoftwareSerial.h>
#include "GyverWDT.h"
#include <iarduino_VCC.h>
#include <EEPROM.h>

// Определяем переменные адреса (обычного и изменённого) для записи данных в EEPROM
int address; int oldaddress; 
// Определяем переменную флага для записи даты перезагрузки
// (после перезагрузки флаг устанавливается в значение true для того,
// чтобы записать дату первого поступления координат после перезагрузки
// для постоянного хранения)
bool isReboot;       
// Определяем переменную счетчика перезагрузок контроллера для  постоянного хранения
uint16_t nReboot;  

SoftwareSerial VKEL_TTL(12,13);  // синий на 12 - будет RX; зеленый на 13 - будет TX
SoftwareSerial   SIM900( 7,8 );  // SIM900 
int ThermistorPin = A0;          // аналоговый пин для снятия температуры

// Подключаем список 16-символьных сообщений приложения Kvizzy900
// и функцию вывода сообщений
#include "s16_Kvizzy900v3.h"

bool isSIM900=false;                    // "Не работает SIM900" = SIM900 does not work
uint32_t ncikl=0;                       // счетчик циклов
bool isFullCikl=true;                   // 9: true - "Выполняем прослушивание";        false - "Отрабатываем пустой цикл"
bool isMemTrass=false;                  // 8: true - "Показываем свободную память";    false - "Отменяем трассирование памяти"
bool isATTrass=true;                    // 7: true - "Показываем ответ на AT-команды"; false - "Отменяем трассирование AT-команд"

// Обеспечиваем взаимодействие и выборку данных из приёмника GPS VKEL_TTL 
#include "VKEL_TTL.h"     
// Обеспечиваем взаимодействие с SIM900 и передачу данных на сайт  
#include "SIM900.h"   

void setup()
{
  Serial.begin(115200);
  VKEL_TTL.begin(9600); 
  SIM900.begin(9600);
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
  // Выводим сводку по памяти в начале программы
  saymess(DefToChar(m1_Fill));
  saymess(FreeMemoryToChar());
  delay(1500);
}

// Первый тайм-аут вызовет прерывание и если Watchdog не будет перезапущен,
// то на втором прерывании произойдет жёсткая перезагрузка контроллера
ISR(WATCHDOG) 
{
  // Перезапускаем watchdog с таймаутом ~8c
  Watchdog.enable(INTERRUPT_RESET_MODE, WDT_PRESCALER_1024); 
}

void loop()
{
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
}

// Arduino C/C++ ******************************************** Kvizzy900.ino ***
                                                                                                                                                                                                  
