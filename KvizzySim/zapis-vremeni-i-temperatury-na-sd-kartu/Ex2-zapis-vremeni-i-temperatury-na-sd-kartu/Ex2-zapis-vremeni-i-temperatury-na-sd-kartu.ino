// Ex2-zapis-vremeni-i-temperatury-na-sd-kartu.ino

/*
 *  Arduino Temperature Data Logging
 *  
 *  by Dejan Nedelkovski, www.HowToMechatronics.com
 */

#include <SD.h>
#include <SPI.h>
//#include <DS3231.h>

File myFile;
//DS3231 rtc(SDA, SCL);

int pinCS = 10; // Pin 10 on Arduino Uno

void setup() 
{
    
  Serial.begin(9600);
  pinMode(pinCS, OUTPUT);
  
  // SD Card Initialization
  if (SD.begin())
  {
    Serial.println("SD card is ready to use.");
  } else
  {
    Serial.println("SD card initialization failed");
    return;
  }
  //rtc.begin();    
}
void loop() 
{
  //Serial.print(rtc.getTimeStr());
  Serial.print(rtc_getTimeStr());
  Serial.print(",");
  //Serial.println(int(rtc.getTemp()));
  Serial.println(rtc_getTemp());
 
  myFile = SD.open("test.txt", FILE_WRITE);
  if (myFile) 
  {    
    //myFile.print(rtc.getTimeStr());
    myFile.print(rtc_getTimeStr());
    myFile.print(",");    
    //myFile.println(int(rtc.getTemp()));
    myFile.println(rtc_getTemp());
    myFile.close(); // close the file
  }
  // если файл не открылся выводим сообщение об ошибке
  else {
    Serial.println("error opening test.txt");
  }
  delay(3000);
}

String rtc_getTimeStr()
{
  String TimeStr="19:20:06";
  return TimeStr;
}

int rtc_getTemp()
{
  int Temp=30;
  return Temp;
}

/*
#include <SD.h>
#include <SPI.h>

File myFile;

int pinCS = 10; // контакт 10 на плате Arduino Uno

void setup() 
{
    
  Serial.begin(9600);
  pinMode(pinCS, OUTPUT);
  
  // инициализация SD карты
  if (SD.begin())
  {
    Serial.println("SD card is ready to use.");
  } 
  else
  {
    Serial.println("SD card initialization failed");
    return;
  }
  
  // создание/открытие файла 
  myFile = SD.open("test.txt", FILE_WRITE);
  
  // if the file opened okay, write to it:
  if (myFile) 
  {
    Serial.println("Writing to file...");
    // Write to file
    myFile.println("Testing text 1, 2 ,3...");
    myFile.close(); // close the file
    Serial.println("Done.");
  }
  // если файл не открылся выводим сообщение об ошибке
  else 
  {
    Serial.println("error opening test.txt");
  }

  // чтение из файла
  myFile = SD.open("test.txt");
  if (myFile) 
  {
    Serial.println("Read:");
    // Reading the whole file
    while (myFile.available()) 
    {
      Serial.write(myFile.read());
    }
    myFile.close();
  }
  else 
  {
    Serial.println("error opening test.txt");
  }
}

void loop()
{
  // empty
}
*/

