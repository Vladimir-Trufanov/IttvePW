// Ex1-zapis-vremeni-i-temperatury-na-sd-kartu.ino

/*
 *  Arduino SD Card Tutorial Example
 *  
 *  by Dejan Nedelkovski, www.HowToMechatronics.com
 */

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