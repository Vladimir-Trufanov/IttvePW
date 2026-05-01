/** Arduino C/C++ ******************************** testwdt_ClausKuehnel.ino ***
 *
 * Проверка работоспособности watchdog на основе статьи:
 * https://microcontrollerslab.com/arduino-watchdog-timer-tutorial/
 * 
 * v1.0.0, 01.05.2026                                 Автор:      Труфанов В.Е.
 * Copyright © 2025 tve                               Дата создания: 01.05.2026
 *
**/

// Title : Watchdog
// Author : Claus Kuehnel <ckuehnel@gmx.ch>
// Date : 2017-05-10
// Id : watchdog.ino
// Tested w/ : Arduino 1.8.0
//
// DISCLAIMER:
// The author is in no way responsible for any problems or damage caused by
// using this code. Use at your own risk.
//
// LICENSE:
// This code is distributed under the GNU Public License
// which can be found at http://www.gnu.org/licenses/gpl.txt
//

// Определяем имена прерываний и процедуру обработки прерываний ISR
#include <avr/io.h>
#include <avr/interrupt.h>

// Задаем функцию сброса сторожевого таймера с помощью встроенного ассемблерного 
// оператора wdt_reset() (она должна запускаться приложением до истечения заданного 
// периода сторожевого таймера)
#define wdt_reset() __asm__ __volatile__ ("wdr")
// Определяем номер контакта встроенного светодиод и счетчик циклов
const int pLED = 13; 
int idx;
// Определяем обработку прерывания сторожевого таймера
ISR(WDT_vect)
{
  flash();
}
// ---
// Переключить светодиод при срабатывании прерывания.
// ---
void flash()
{
  static boolean output = HIGH;
  digitalWrite(pLED, output);
  output = !output;
}
// ---
// Выполнить начальный запуск приложения: открыть последовательную связь на заданной скорости 
// передачи данных. Настроить контакт led как выходной и установить для него значение LOW. 
// Вызвать функцию wdt_reset(), чтобы сбросить сторожевой таймер. Затем установить
// приблизительный период ожидания в 1 секунду, инициализировав сторожевой регистр WDTCSR 
// [Arduino noInterrupts, interrupts, sei() & cli() Functions](https://deepbluembedded.com/arduino-nointerrupts-sei-cli-functions/)
// ---
void setup()
{
  Serial.begin(9600);
  pinMode(pLED, OUTPUT);
  digitalWrite(pLED, LOW);
  // Начинаем критическую секцию, защищенную от прерываний, для 
  // замены значений регистра WDTCSR
  cli();
  wdt_reset();
  WDTCSR |= (1<<WDCE) | (1<<WDE);              // запустили временную последовательность
  WDTCSR = (1<<WDIE) | (1<<WDP2) | (1<<WDP1);  // установили отсчет = 128K соответствующий 1 секунде
  // Закрываем защиту от прерываний
  sei();
  Serial.print("WDTCSR: ");
  Serial.println(WDTCSR, HEX);
  Serial.println("Setup finished.");
}
// ---
// Изменить в цикле значение счетчика, затем добавить задержку в 1500 мс. 
// Поскольку сброс сторожевого таймера не может произойти в течение заданного 
// периода, сторожевой таймер запустит прерывание, которое приведет к переключению 
// встроенного светодиода. После этого снова сбросить сторожевой таймер.

// Если установить задержку менее времени ожидания сторожевого таймера (то есть здесь 
// менее 1 секунды), светодиод не переключится
// ---
void loop()
{
  Serial.println(idx++); 
  delay(1500); // delay(1500) или delay(500)
  wdt_reset();
}

// *********************************************** testwdt_ClausKuehnel.ino ***
