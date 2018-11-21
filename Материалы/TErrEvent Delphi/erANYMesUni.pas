// DELPHI7, WIN98\XP                                    *** erANYMesUni.pas ***

// ****************************************************************************
// * ErrEvent [0110]           Отработать реакцию на несгруппированные ошибки *
// *                                                ретранслировать сообщение *
// ****************************************************************************

//                                                   Автор:       Труфанов В.Е.
//                                                   Дата создания:  11.11.2003
//                                                   Посл.изменение: 23.11.2004

unit erANYMesUni;

interface

uses
  Classes,Controls,Graphics,
  Dialogs,  // Определение модуля MessageDlg
  Forms,    // Определение класса TApplication
  SysUtils; // Определение модуля UpperCase

function erANYMes(cMessage:String; E:Exception): Boolean;
procedure MyMessage(cMessage:String);

implementation

function erANYMes(cMessage:String; E:Exception): Boolean;

var
  coMessage: String;
  nPoint: Integer;

begin
  coMessage:=cMessage;
  Result:=True;

  if E is EAccessViolation then begin
    MyMessage('Обращение к несуществующему объекту!');
  end

  else if E is EDivByZero then
    MyMessage('Деление целого на ноль!')

  else if E is EFOpenError then begin
    coMessage:=Copy(cMessage,19,length(cMessage));
    nPoint:=AnsiPos('"',coMessage);
    if nPoint<>0 then coMessage:=Copy(coMessage,1,nPoint-1)
    else coMessage:='';
    MyMessage('Не удается найти файл: '+coMessage+' ');
  end

  else if E is EInOutError then
    MyMessage(cMessage)

  // Во-первых: Было обращение через указатель к переменной типа AnsiString,
  // которая уже уничтожена (или находится в другом сегменте данных)
  else if E is EInvalidPointer then begin
    MyMessage('Неверный указатель!')
  end

  else if E is EZeroDivide then
    MyMessage('Деление на ноль!')

  else begin
    Result:=False;
  end;

end;

// ****************************************************************************
// *             Вывести сообщение об ошибке  и завершить приложение          *
// ****************************************************************************

procedure MyMessage(cMessage:String);
begin
  if MessageDlg(cMessage+'! Завершить работу?',mtError,[mbYes,mbNo],0)=mrYes
  then Application.Terminate;
end;

end.

// ******************************************************** erANYMesUni.pas ***
