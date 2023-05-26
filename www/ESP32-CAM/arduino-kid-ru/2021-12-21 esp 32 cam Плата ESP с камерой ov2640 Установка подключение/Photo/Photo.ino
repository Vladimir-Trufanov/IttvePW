// GPIO0 должен быть подключен к GND для загрузки кода

// Подключение необходимых библиотек
#include "esp_camera.h"
#include "Arduino.h"
#include "FS.h"                   // Для работы с файловой системой SD Card
#include "SD_MMC.h"               // Работа с MMC
#include "soc/soc.h"              // Избавляемся с проблемами при отключении
#include "soc/rtc_cntl_reg.h"     // Избавляемся с проблемами при отключении
#include "driver/rtc_io.h"
#include <EEPROM.h>               // Библиотека для работы с EEPROM

#define EEPROM_SIZE 1             // Количество байт 1 позволяет сохранить до 256 фотографий

// контакты для модуля камеры AI-THINKER
#define PWDN_GPIO_NUM     32
#define RESET_GPIO_NUM    -1
#define XCLK_GPIO_NUM      0
#define SIOD_GPIO_NUM     26
#define SIOC_GPIO_NUM     27

#define Y9_GPIO_NUM       35
#define Y8_GPIO_NUM       34
#define Y7_GPIO_NUM       39
#define Y6_GPIO_NUM       36
#define Y5_GPIO_NUM       21
#define Y4_GPIO_NUM       19
#define Y3_GPIO_NUM       18
#define Y2_GPIO_NUM        5
#define VSYNC_GPIO_NUM    25
#define HREF_GPIO_NUM     23
#define PCLK_GPIO_NUM     22

int pictureNumber = 0;            // Переменная для хранения номера фотографии 

void setup() {
  WRITE_PERI_REG(RTC_CNTL_BROWN_OUT_REG, 0); 
 
  Serial.begin(115200);
 // Конфигурациия камеры   
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
    /*
  Формат изображений может быть одним из следующих вариантов:  
    YUV422
    GRAYSCALE
    RGB565
    JPEG
   */
  config.pixel_format = PIXFORMAT_JPEG; 
  /* 
    UXGA (1600 x 1200)
    QVGA (320 x 240)
    CIF (352 x 288)
    VGA (640 x 480)
    SVGA (800 x 600)
    XGA (1024 x 768)
    SXGA (1280 x 1024) 
  */
  // Если есть psram 
  if(psramFound()){
    config.frame_size = FRAMESIZE_UXGA;   // 1600x1200
    config.jpeg_quality = 10;             // Качество сохранения файла от 0 до 63, чем ниже тем лучше
    config.fb_count = 2;                  // Частота кадров??????
  } else {
    config.frame_size = FRAMESIZE_SVGA;   // 800x600
    config.jpeg_quality = 12;             // Качество сохранения файла
    config.fb_count = 1;
  }
  
  // Инициализация камеры
  esp_err_t err = esp_camera_init(&config);
  if (err != ESP_OK) {
    Serial.printf("Ошибка инициализации камеры 0x%x", err);
    return;
  }

/*
 Дополнительные настройки камеры
 
sensor_t * s = esp_camera_sensor_get();

s->set_brightness(s, 0);     // -2 to 2
s->set_contrast(s, 0);       // -2 to 2
s->set_saturation(s, 0);     // -2 to 2
s->set_special_effect(s, 0); // 0 to 6 (0 - No Effect, 1 - Negative, 2 - Grayscale, 3 - Red Tint, 4 - Green Tint, 5 - Blue Tint, 6 - Sepia)
s->set_whitebal(s, 1);       // 0 = disable , 1 = enable
s->set_awb_gain(s, 1);       // 0 = disable , 1 = enable
s->set_wb_mode(s, 0);        // 0 to 4 - if awb_gain enabled (0 - Auto, 1 - Sunny, 2 - Cloudy, 3 - Office, 4 - Home)
s->set_exposure_ctrl(s, 1);  // 0 = disable , 1 = enable
s->set_aec2(s, 0);           // 0 = disable , 1 = enable
s->set_ae_level(s, 0);       // -2 to 2
s->set_aec_value(s, 300);    // 0 to 1200
s->set_gain_ctrl(s, 1);      // 0 = disable , 1 = enable
s->set_agc_gain(s, 0);       // 0 to 30
s->set_gainceiling(s, (gainceiling_t)0);  // 0 to 6
s->set_bpc(s, 0);            // 0 = disable , 1 = enable
s->set_wpc(s, 1);            // 0 = disable , 1 = enable
s->set_raw_gma(s, 1);        // 0 = disable , 1 = enable
s->set_lenc(s, 1);           // 0 = disable , 1 = enable
s->set_hmirror(s, 0);        // 0 = disable , 1 = enable
s->set_vflip(s, 0);          // 0 = disable , 1 = enable
s->set_dcw(s, 1);            // 0 = disable , 1 = enable
s->set_colorbar(s, 0);       // 0 = disable , 1 = enable

*/











  
  //Serial.println("SD Card работает");
  if(!SD_MMC.begin()){
    Serial.println("SD Card не работает");
    return;
  }
  
  uint8_t cardType = SD_MMC.cardType();
  if(cardType == CARD_NONE){
    Serial.println("SD Card не найдена");
    return;
  }
    
  camera_fb_t * fb = NULL;
  
  // Сделать снимок с помощью камеры
  fb = esp_camera_fb_get();  
  if(!fb) {
    Serial.println("Сбой захвата камеры");
    return;
  }
  // инициализировать EEPROM с заданным размером
  EEPROM.begin(EEPROM_SIZE);
  pictureNumber = EEPROM.read(0) + 1;   // Читаем номер из памяти и добавляем 1

  // Путь для сохранения изображения на SD-карте в формате jpg
  String path = "/picture" + String(pictureNumber) +".jpg";
  // Сохраняем фотографию на карте в корне с именем picture и номером
  fs::FS &fs = SD_MMC; 
  Serial.printf("Имя файла: %s\n", path.c_str());
  
  File file = fs.open(path.c_str(), FILE_WRITE);
  if(!file){
    Serial.println("Не удалось открыть файл для записи");
  } 
  else {
    file.write(fb->buf, fb->len); // payload (image), payload length
    Serial.printf("Файл сохранён по адресу: %s\n", path.c_str());
   // Сохраняем номер текущего снимка в память
    EEPROM.write(0, pictureNumber);
    EEPROM.commit();
  }
  file.close();
  esp_camera_fb_return(fb); 
  
  // Выключаем встроенный светодиод ESP32(вспышка), подключенный к GPIO 4
  pinMode(4, OUTPUT);
  digitalWrite(4, LOW);
  rtc_gpio_hold_en(GPIO_NUM_4);
  
  delay(2000);
  Serial.println("Модуль впадает в спячку до следующего нажатия кнопки");
  delay(2000);
  esp_deep_sleep_start();
}

void loop() {
  
}
