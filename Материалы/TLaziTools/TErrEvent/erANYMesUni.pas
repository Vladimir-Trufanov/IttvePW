// LAZARUS WIN10\XP                                     *** erANYMesUni.pas ***

// ****************************************************************************
// * ErrEvent [110]                        Отработать реакцию на общие ошибки *
// *                                                ретранслировать сообщение *
// ****************************************************************************

//                                                   Автор:       Труфанов В.Е.
//                                                   Дата создания:  11.11.2003
// Copyright © 2003 TVE                              Посл.изменение: 25.08.2017

unit erANYMesUni;

{$mode objfpc}{$H+}

interface

uses
  Classes,Dialogs,SysUtils;

function erANYMes(E:Exception): Byte;

implementation

uses
  ErreventAlerts,
  TellmeFrm;

// ****************************************************************************
// *               Выбрать из сообщения текст между кавычками                 *
// ****************************************************************************
function geSubmessage(E:Exception): String;
var
  cMessage: String;  // Полное сообщение исключения
  nPoint: Integer;   // Позиция в тексте
  cc: String;        // Вставка в ретранслированное сообщение
begin
  cMessage:=E.Message; cc:='';
  nPoint:=AnsiPos('"',cMessage);
  if nPoint<>0 then cc:=Copy(cMessage,nPoint+1,MaxInt);
  nPoint:=AnsiPos('"',cc);
  if nPoint<>0 then cc:=Copy(cc,1,nPoint-1);
  Result:=cc;
end;

// ****************************************************************************
// *      Отработать реакцию на общие ошибки, ретранслировать сообщение       *
// ****************************************************************************
function erANYMes(E:Exception): Byte;
begin
  Result:=0;
  if E is EDivByZero then Tellme(eanDivisionByZero,2000)
  else if E is EAccessViolation then Tellme(eanAccessViolation,2001)
  // Ошибка 2002 возникает: а) не найден файл по указанной спецификации
  else if E is EFOpenError then begin
    Tellme(Format(eanFOpenError,[geSubmessage(E)]),2002);
  end
  // Ошибка 2003 возникает: а) не указана спецификация (имя файла+путь)
  // создаваемого файла; б) указан неправильный путь к файлу; в) в спецификации
  // файла используются неразрешённые символы; г) файл занят другим приложением
  else if E is EFCreateError then begin
    Tellme(Format(eanFCreateError,[geSubmessage(E)]),2003)
  end
  // Ошибка 2003 возникает: а) не указана спецификация (имя файла+путь)
  // создаваемого файла; б) указан неправильный путь к файлу; в) в спецификации
  // файла используются неразрешённые символы; г) файл занят другим приложением
  else if E is EConvertError then begin
    Tellme(Format(eanConvertError,[geSubmessage(E)]),2004)
  end
  else Result:=1;

  // cKeyWord:=''; nContext:=0; nQTerminate:=queryTerminate;

 {

  else if E is EInOutError then
    MyMessage(cMessage)

  // Во-первых: Было обращение через указатель к переменной типа AnsiString,
  // которая уже уничтожена (или находится в другом сегменте данных)
  else if E is EInvalidPointer then begin
    MyMessage('Неверный указатель!')
  end

  else if E is EZeroDivide then  begin
    cKeyWord:='A0001';  nContext:=840001;
    MyMessage('Выполнено деление на "ноль"',cKeyWord,nContext,nQTerminate);
  end
  // Ошибка A0002 возникает: а) если для таблицы Paradox через BDE
  // устанавливается связь Master-Detail, когда таблица закрыта (характерно для
  // Windows Vista)
  else if pos(cFieldIndexOutOfRange,cMessage)>0 then begin
    nPoint:=pos(cFieldIndexOutOfRange,cMessage);
    coMessage:=Copy(cMessage,1,nPoint-1);
    cKeyWord:='A0002';  nContext:=840002;
    MyMessage(coMessage+' Поле индекса вне границ',cKeyWord,nContext,nQTerminate);
  end

  else if NonStopMessage(coMessage) then MyMessage(coMessage)

  end;}

end;

end.

// ******************************************************** erANYMesUni.pas ***


