// Ex3-zapis-vremeni-i-temperatury-na-sd-kartu.ino

/*
 * Проверка работы модуля часов DS3231. Здесь используется библиотека Хеннинга Карлсена. 
 *
 * Демонстрационный пример, чтобы первоначально активировать часы модуля RTC. В разделе настройки кода 
 * демонстрационного примера мы можем заметить, что есть три строки, которые нам нужно раскомментировать, 
 * чтобы изначально установить день недели, время и дату. 
 */

#include <DS3231.h>
DS3231 rtc(SDA, SCL);

void setup()
{
  // Setup Serial connection
  Serial.begin(9600);
  // Uncomment the next line if you are using an Arduino Leonardo
  while (!Serial) {}
  
  // Initialize the rtc object
  rtc.begin();
  
  // The following lines can be uncommented to set the date and time
  // rtc.setDOW(WEDNESDAY);     // Set Day-of-Week to SUNDAY
  // rtc.setTime(12, 0, 0);     // Set the time to 12:00:00 (24hr format)
  // rtc.setDate(1, 1, 2014);   // Set the date to January 1st, 2014

  /*
  Названия дней недели на английском языке: 
  Monday — понедельник;
  Tuesday — вторник;
  Wednesday — среда;
  Thursday — четверг;
  Friday — пятница;
  Saturday — суббота;
  Sunday — воскресенье.
  */

  //rtc.setDOW(MONDAY);        
  //rtc.setTime(21, 39, 10);     
  //rtc.setDate(20, 4, 2026);  

  // Первая строка предназначена для установки дня недели, вторая строка — для установки 
  // времени в часах, минутах и ​​секундах, третья строка — для установки даты в днях, месяцах и годах.
  // Как только мы загрузим этот код, нам нужно будет закомментировать три строки и повторно загрузить код.
}

void loop()
{
  // Send Day-of-Week
  Serial.print(rtc.getDOWStr());
  Serial.print(" ");
  
  // Send date
  Serial.print(rtc.getDateStr());
  Serial.print(" -- ");

  // Send time
  Serial.println(rtc.getTimeStr());
  
  // Wait one second before repeating
  delay (1000);
}
