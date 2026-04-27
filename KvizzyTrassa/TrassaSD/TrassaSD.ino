/**
 * TrassaSD.ino 
 *
**/

// Подключаем модуль часов DS3231 через библиотеку Хеннинга Карлсена 
#include <DS3231.h>
DS3231 rtc(SDA, SCL);

void setup()
{
  Serial.begin(9600);
  // Ждем подключения последовательного порта (для Arduino Leonardo)
  while (!Serial) {}
  // Инициируем rtc (объект часов)
  rtc.begin();
  // Настраиваем часы при первом запуске:
  // а) устанавливаем день недели на английском языке: Monday—понедельник;Tuesday—вторник;
  // Wednesday—среда;Thursday—четверг;Friday—пятница;Saturday—суббота;Sunday—воскресенье
  // rtc.setDOW(MONDAY); 
  // б) устанавливаем время в часах, минутах и ​​секундах      
  // rtc.setTime(21, 39, 10); 
  // в) устанавливаем дату в днях, месяцах и годах
  // rtc.setDate(20, 4, 2026);  
}

void loop()
{
  Serial.print(rtc.getDOWStr());
  Serial.print(" ");
  Serial.print(rtc.getDateStr());
  Serial.print(" -- ");
  Serial.println(rtc.getTimeStr());
  
 
  delay (3000);
}
