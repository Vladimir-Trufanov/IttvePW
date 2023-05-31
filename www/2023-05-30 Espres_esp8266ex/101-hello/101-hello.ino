/*
 * Таков был запуск моей модели esp01-tve58 на платформе Интернета вещей 31.05.2023:
 * https://dev.rightech.io/#?n=root&v=map&m=objects&p=journal-v3&id=6476f06d23ae4a72e893ba2d&t=ric-handler-v2
 * 
 * https://dev.rightech.io       - подключение к платформе Интернета вещей Rightech IoT
 * E-mail/логин                  - tve58@inbox.ru
 * Пароль                        - Esp8266-tve
 * Проект                        - Project of tve58@inbox.ru
 * Объект (идентификатор модели) - esp01-tve58
 * Имя модели                    - tve58-esp01-test
 * 
 * Имя                     - tve
 * Телефон                 - 89214524295
 * Организация             - Vidan17B
 * 
 */


#include "Arduino.h"
#include "EspMQTTClient.h" 
/* https://github.com/plapointe6/EspMQTTClient */
/* https://github.com/knolleary/pubsubclient */
#define PUB_DELAY (5 * 1000) /* 5 seconds */

EspMQTTClient client(
  "OPPO A9 2020",
  "b277a4ee84e8",

  "dev.rightech.io",
  "esp01-tve58"
);

void setup() {
  Serial.begin(9600);
}

void onConnectionEstablished() {
  client.subscribe("base/relay/led1", [] (const String & payload)  {
    Serial.println(payload);
  });
}

long last = 0;
void publishTemperature() {
  long now = millis();
  if (client.isConnected() && (now - last > PUB_DELAY)) {
    client.publish("base/state/temperature", String(random(20, 30)));
    client.publish("base/state/humidity", String(random(40, 90)));
    last = now;
  }
}

void loop() {
  client.loop();
  publishTemperature();
}
