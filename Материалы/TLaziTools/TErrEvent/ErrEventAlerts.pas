// LAZARUS WIN10\XP                                  *** ErreventAlerts.pas ***

// ****************************************************************************
// *              Реестр сообщений диспетчера ошибок приложения               *
// ****************************************************************************

//                                                   Автор:       Труфанов В.Е.
//                                                   Дата создания:  21.08.2017
// Copyright © 2017 TVE                              Посл.изменение: 10.09.2017

unit ErreventAlerts;

{$mode objfpc}{$H+}

interface

uses
  Classes, SysUtils;

const

// =============================================================== ErrEvent ===
ereUnaccountedError = 'Неучтенная ошибка'+LineEnding+'"%s"';                     // Unaccounted error

// ============================================================ erANYMesUni ===
{2000} eanDivisionByZero = 'Деление целого на ноль';                             // Division by zero
{2001} eanAccessViolation = 'Обращение к несуществующему объекту';               // Access Violation
{2002} eanFOpenError = 'Не удается найти файл: %s';
{2003} eanFCreateError = 'Не удается создать файл: %s';
{2004} eanConvertError = 'Неверно указано число для преобразования: %s';

implementation

end.

// ***************************************************** ErreventAlerts.pas ***


