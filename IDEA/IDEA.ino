// ****************************************************** skaner-ehfira.ino ***
// *                                                                          *
// * ----Сканер каналов                                                           *
// * ----Пример обнаружения помех на различных доступных каналах. Это хороший     *
// * ----диагностический инструмент для проверки того, правильно ли вы выбран     *
// * ----канал для беспроводной передачи данных TZT: NRF24L01, NRF24L01+PA+LNA    *
// *                                                                          *
// * v1.0.1, 05.05.2026                            Автор:       Труфанов В.Е. *
// * Copyright © 2024 tve                          Дата создания:  09.04.2024 *
// ****************************************************************************

#include <SPI.h>
#include <RF24.h>
#include <BTLE.h>
#include <DHT.h>                                                           

#define DHTPIN 4                                                          
#define DHTTYPE DHT22                                                       
DHT dht(DHTPIN, DHTTYPE);

RF24 radio(6,7); 
BTLE btle(&radio);

void setup() 
{
  Serial.begin(115200);
  delay(1000);
  Serial.print("BLE and DHT Starting... ");
  Serial.println("Send Temperature Data over BTLE");
  //dht.begin();   
  btle.begin("My DHT");    // 8 chars max
  Serial.println("Successfully Started");
}

float temp=15.3; 

void loop() 
{ 
  temp=temp+0.01;                                            
  /*
  float temp = dht.readTemperature(); 
  if (isnan(temp)) 
  {                                               
    Serial.println(F("Failed to read from DHT sensor!"));
    return;
  }
  */
  Serial.print(" Temperature: ");  
  Serial.print(temp);  
  Serial.println("°C ");
  
  nrf_service_data buf;
  buf.service_uuid = NRF_TEMPERATURE_SERVICE_UUID;
  buf.value = BTLE::to_nRF_Float(temp);

  if (!btle.advertise(0x16, &buf, sizeof(buf))) 
  {
    Serial.println("BTLE advertisement failed..!");
  }
  btle.hopChannel(); 
  delay(2000);
}





/*

#include <SPI.h>
#include "nRF24L01.h"
#include "RF24.h"
#include "printf.h"

RF24 radio(6,7); 

// Channel info
const uint8_t num_channels = 128;
uint8_t values[num_channels];

void setup(void)
{
  // Print preamble
  Serial.begin(9600);
  Serial.println("Scanner Air On");
  printf_begin();
  // Setup and configure rf radio
  radio.begin();
  radio.setAutoAck(false);
  // Get into standby mode
  radio.startListening();
  radio.printDetails();  
  delay(5000);              
  // Print out header, high then low digit
  int i = 0;
  while ( i < num_channels )
  {
    printf("%x", i >> 4);
    ++i;
  }
  printf("\n\r");
  i = 0;
  while ( i < num_channels )
  {
    printf("%x", i & 0xf);
    ++i;
  }
  printf("\n\r");
}

const int num_reps = 100;
void loop(void)
{
  // Clear measurement values
  memset(values, 0, sizeof(values));

  // Scan all channels num_reps times
  int rep_counter = num_reps;
  while (rep_counter--)
  {
    int i = num_channels;
    while (i--)
    {
      // Select this channel
      radio.setChannel(i);

      // Listen for a little
      radio.startListening();
      delayMicroseconds(512);
      radio.stopListening();

      // Did we get a carrier?
      if ( radio.testCarrier() )
        ++values[i];
    }
  }

  // Print out channel measurements, clamped to a single hex digit
  int i = 0;
  while ( i < num_channels )
  {
    printf("%x", min(0xf, values[i] & 0xf));
    ++i;
  }
  printf("\n\r");
}
*/

// ****************************************************** skaner-ehfira.ino ***
