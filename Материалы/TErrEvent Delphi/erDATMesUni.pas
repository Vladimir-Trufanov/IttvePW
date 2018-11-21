// DELPHI7, WIN98\XP                                    *** erDATMesUni.pas ***

// ****************************************************************************
// * ErrEvent [0110]             Отработать реакцию на ошибку формата данного *
// *                                              и ретранслировать сообщение *
// ****************************************************************************

//                                                   Автор:       Труфанов В.Е.
//                                                   Дата создания:  24.10.2003
//                                                   Посл.изменение: 15.11.2004

unit erDATMesUni;

interface

uses
  Dialogs,               // Определение модуля MessageDlg
  Forms,                 // Определение класса TApplication
  SysUtils;              // Определение модуля UpperCase

procedure erDATMes(cMessage:String);

implementation

procedure erDATMes(cMessage:String);

var
  coMessage:String;
  nPoint: Integer;

begin
  coMessage:=cMessage;

  nPoint:=Pos('is not a valid date',cMessage);
  if nPoint<>0 then
    coMessage:='Неверный формат даты: '+Copy(cMessage,1,nPoint-1);

  nPoint:=Pos('is not a valid integer value',cMessage);
  if nPoint<>0 then
    coMessage:='Неверный формат числа перед преобразованием: '+
    Copy(cMessage,1,nPoint-1);

  MessageDlg(coMessage+'!',mtInformation,[mbOk],0);
end;

end.

// ******************************************************** erDATMesUni.pas ***
