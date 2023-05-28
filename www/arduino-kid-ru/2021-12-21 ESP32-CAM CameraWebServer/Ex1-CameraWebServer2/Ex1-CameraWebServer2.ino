// Arduino C/C++                                   *** CameraWebServer2.ino ***

// ****************************************************************************
// * IttvePW      Подключить камеру OV2640 с платой ESP32-CAM к WiFi-монитору *
// *                                                   для записи видео, фото *
// ****************************************************************************

//                                                   Автор:       Труфанов В.Е.
//                                                   Дата создания:  28.05.2023
// Copyright © 2023 tve                              Посл.изменение: 28.05.2023


#include "esp_camera.h"
#include <WiFi.h>

//
// WARNING! Для разрешения UXGA и высокого качества JPEG требуется микросхема PSRAM.
// Убедитесь, что выбран модуль ESP32 Wrover или другая плата с PSRAM.
// Изображения будут переданы частично, если изображение превышает размер буфера.
//
// PSRAM — это дополнительный напаянный чип RAM помимо встроенной памяти. Обычно 
// указывается в описании к плате и бывает размером 2 или 8 Мб. Дополнительная 
// оперативная память необходима, если подключается дисплей для вывода

// Select camera model
//#define CAMERA_MODEL_WROVER_KIT // Has PSRAM
//#define CAMERA_MODEL_ESP_EYE // Has PSRAM
//#define CAMERA_MODEL_M5STACK_PSRAM // Has PSRAM
//#define CAMERA_MODEL_M5STACK_V2_PSRAM // M5Camera version B Has PSRAM
//#define CAMERA_MODEL_M5STACK_WIDE // Has PSRAM
//#define CAMERA_MODEL_M5STACK_ESP32CAM // No PSRAM
#define CAMERA_MODEL_AI_THINKER // Has PSRAM
//#define CAMERA_MODEL_TTGO_T_JOURNAL // No PSRAM

#include "camera_pins.h"

//const char* ssid = "linksystve";
//const char* password = "x93k6kq6wf";

const char* ssid = "truflaki";
const char* password = "t1s2wde4bE";

void startCameraServer();

void setup() 
{
  Serial.begin(115200);
  Serial.setDebugOutput(true);
  Serial.println();

  camera_config_t config;
  config.ledc_channel = LEDC_CHANNEL_0;
  config.ledc_timer = LEDC_TIMER_0;
  config.pin_d0 = Y2_GPIO_NUM;
  config.pin_d1 = Y3_GPIO_NUM;
  config.pin_d2 = Y4_GPIO_NUM;
  config.pin_d3 = Y5_GPIO_NUM;
  config.pin_d4 = Y6_GPIO_NUM;
  config.pin_d5 = Y7_GPIO_NUM;
  config.pin_d6 = Y8_GPIO_NUM;
  config.pin_d7 = Y9_GPIO_NUM;
  config.pin_xclk = XCLK_GPIO_NUM;
  config.pin_pclk = PCLK_GPIO_NUM;
  config.pin_vsync = VSYNC_GPIO_NUM;
  config.pin_href = HREF_GPIO_NUM;
  config.pin_sscb_sda = SIOD_GPIO_NUM;
  config.pin_sscb_scl = SIOC_GPIO_NUM;
  config.pin_pwdn = PWDN_GPIO_NUM;
  config.pin_reset = RESET_GPIO_NUM;
  config.xclk_freq_hz = 20000000;
  config.pixel_format = PIXFORMAT_JPEG;
  
  // Если присутствует PSRAM, инициализируем с разрешением UXGA и более высоким
  // качеством JPEG для большего предварительно выделенного буфера кадра 
  if(psramFound())
  {
    config.frame_size = FRAMESIZE_UXGA;
    config.jpeg_quality = 10;
    config.fb_count = 2;
  } 
  else 
  {
    config.frame_size = FRAMESIZE_SVGA;
    config.jpeg_quality = 12;
    config.fb_count = 1;
  }

  #if defined(CAMERA_MODEL_ESP_EYE)
    pinMode(13, INPUT_PULLUP);
    pinMode(14, INPUT_PULLUP);
  #endif

  // camera init
  esp_err_t err = esp_camera_init(&config);
  if (err != ESP_OK) 
  {
    Serial.printf("Инициализация камеры не удалась, ошибка: 0x%x", err);
    return;
  }

  sensor_t * s = esp_camera_sensor_get();
  // initial sensors are flipped vertically and colors are a bit saturated
  // Инициируем поворот датчиков по вертикали, а цвета делаем насыщеннее
  if (s->id.PID == OV3660_PID) 
  {
    s->set_vflip(s, 1);       // flip it back - перевернули обратно
    s->set_brightness(s, 1);  // up the brightness just a bit - немного увеличили яркость
    s->set_saturation(s, -2); // lower the saturation - снизили насыщенность
  }
  // drop down frame size for higher initial frame rate -
  // установили выпадающий размер кадра для более высокой начальной частоты кадров
  s->set_framesize(s, FRAMESIZE_QVGA);

  #if defined(CAMERA_MODEL_M5STACK_WIDE) || defined(CAMERA_MODEL_M5STACK_ESP32CAM)
    s->set_vflip(s, 1);
    s->set_hmirror(s, 1);
  #endif

  WiFi.begin(ssid, password);

  while (WiFi.status() != WL_CONNECTED) 
  {
    delay(500);
    Serial.print(".");
  }
  Serial.println("");
  Serial.println("WiFi connected");

  startCameraServer();

  Serial.print("Camera Ready! Use 'http://");
  Serial.print(WiFi.localIP());
  Serial.println("' to connect");
}

void loop() 
{
  // put your main code here, to run repeatedly:
  // поместите сюда свой основной код для повторного запуска:
  Serial.println("Всем привет!");
  delay(10000);
}

// *************************************************** CameraWebServer2.ino ***

