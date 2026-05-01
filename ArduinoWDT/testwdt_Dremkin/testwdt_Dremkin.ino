/** Arduino C/C++ ************************************* testwdt_Dremkin.ino ***
 *
 * Проверка работоспособности watchdog на основе статьи:
 * https://habr.com/ru/articles/189744/
 * 
 * v1.0.0, 01.05.2026                                 Автор:      Труфанов В.Е.
 * Copyright © 2025 tve                               Дата создания: 01.05.2026
 *
**/

#include <avr/wdt.h>

void setup()
{
  wdt_disable();         // бесполезная строка до которой не доходит выполнение при bootloop
  Serial.begin(9600);
  Serial.println("Setup..");
  
  Serial.println("Wait 5 sec..");
  delay(5000);           // задержка, чтобы было время перепрошить устройство в случае bootloop
  // Устанавливаем сторожевой таймер на 8 секунд
  wdt_enable (WDTO_8S);  
  Serial.println("Watchdog enabled.");
}

int timer = 0;

void loop()
{
  // Каждую секунду мигаем светодиодом и значение счетчика пишем в Serial
  if(!(millis()%1000))
  {
    timer++;
    Serial.println(timer);
    digitalWrite(13, digitalRead(13)==1?0:1); delay(1);
  }
  // Сбрасываем (или не сбрасываем, если закомментировать следующую строку) сторожевой таймер
  // wdt_reset();
}


// **************************************************** testwdt_Dremkin.ino ***
