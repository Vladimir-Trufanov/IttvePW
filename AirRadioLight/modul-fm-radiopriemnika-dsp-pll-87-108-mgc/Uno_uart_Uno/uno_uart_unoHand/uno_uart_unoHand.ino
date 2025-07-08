// *************************************************** uno_uart_unoHand.ino ***
// * Подменить на отладке модуль радиоприемника LCD FM RX v2.0                *
// * второй платой Arduino Uno и продублировать подаваемые команды            * 
// *                                                                          *
// * v1.0, 10.02.2024                              Автор:       Труфанов В.Е. *
// * Copyright © 2024 tve                          Дата создания:  08.02.2024 *
// ****************************************************************************

#include <SoftwareSerial.h>
SoftwareSerial serialRX(4,3);   // RX=4, TX=3

void setup()
{
   pinMode(LED_BUILTIN, OUTPUT);
   serialRX.begin(38400);  
   Serial.begin(115200);
}

void loop()
{
   serialRX.available()?digitalWrite(13,1):digitalWrite(13,0);
   if (serialRX.available())
   {
      char simb=serialRX.read();
      Serial.print(simb);
   }
}
// *************************************************** uno_uart_unoHand.ino ***

