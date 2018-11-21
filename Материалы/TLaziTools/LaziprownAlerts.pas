// LAZARUS WIN10\XP                                 *** LaziprownAlerts.pas ***

// ****************************************************************************
// *                 Реестр сообщений набора модулей TLaziPrown               *
// ****************************************************************************

//                                                   Автор:       Труфанов В.Е.
//                                                   Дата создания:  21.08.2017
// Copyright © 2017 TVE                              Посл.изменение: 21.08.2017

unit LaziprownAlerts;

{$mode objfpc}{$H+}

interface

uses
  Classes, SysUtils;

const

// ==================================================== ArrayFrm.pas [1000] ===
//                                  Обеспечить работу с вариантными t-массивами
{1001} arrInvalidIncludeArray = 'Недопустимое значение для включения в массив';      // Invalid value to include in the array
{1002} arrIncluArrayNotCreated = 'Включение в еще не созданный массив';              // Inclusion in an array not yet created
{1003} arrUnrecognizeIncluArray = 'Неучтенный тип для включения в массив: %s -> %s'; // Unrecognized value type for inclusion in array
{1004} arrNoItemsInArray = 'Нет элементов в массиве';                                // No items in the array
{1005} arrLowerParameterOutside = 'Нижний параметр вне границ массива';              // The lower parameter outside the bounds of the array
{1006} arrUpperParameterOutside = 'Верхний параметр вне границ массива';             // The upper parameter outside the array bounds
{1007} arrArrayNotFill = 'Массив %s не заполнен!';

// =================================================== TellmeFrm.pas [1100] ===
tlmAttention = 'ВНИМАНИЕ! О данной ошибке сообщите на email: tve@karelia.ru';
tlmCloseWork = 'Завершить работу?';
tlmAppWillbeComplet = 'Работа приложения будет завершена!';                          // The application will be completed

implementation

end.

// **************************************************** LaziprownAlerts.pas ***


