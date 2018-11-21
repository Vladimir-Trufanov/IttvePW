// DELPHI7, WIN98\XP                                       *** ErrEvent.pas ***

// ****************************************************************************
// * ErrEvent [0110]                              Диспетчер ошибок приложения *
// ****************************************************************************

//                                                   Автор:       Труфанов В.Е.
//                                                   Дата создания:  24.10.2003
// Copyright © 2003 TVE                              Посл.изменение: 12.01.2006

// Свойства
//
//   ModuleName - наименование последнего вызванного модуля;
//   LockMessage - блокиратор вывода сообщения при возникновении исключения;
//   TryError - код исключения (только для чтения);

// Методы

//   Возвращаемые значения методов при возникновении исключения

unit ErrEvent;

interface

uses
  Td7Profi,
  Classes,Controls,Graphics,SysUtils,
  DBTables,              // Определение класса EBDEngineError,
  Dialogs,               // Определение модуля MessageDlg
  ExtCtrls,              // Определение класса TIMage
  Forms,                 // Определение класса TApplication
  StdCtrls;              // Определение класса TМемо

type

  TErrEvent = class(TComponent)

  private

    cModulName:String;       // Наименование текущего модуля
    FLockMessage:Boolean;
    FTryError:Integer;

    procedure MyExcept(Sender:TObject; E:Exception);
    procedure BDEMessage(cMessage:String);
    procedure DATMessage(cMessage:String);
    procedure TVEMessage(cMessage:String);

  protected
    procedure SetLockMessage(Value: Boolean);
  public
    constructor Create(AOwner:TComponent); override;
    destructor Destroy; override;

  published
    property LockMessage: Boolean
      read FLockMessage write SetLockMessage default False;
    property TryError: Integer read FTryError;
  end;

  procedure Register;

implementation

uses
  erANYMesUni,erBDEMesUni,erDATMesUni,erTVEMesUni;

procedure Register;
begin
  RegisterComponents('TD7TOOLS', [TErrEvent]);
end;

{  ............................... ДОСТУП К СВОЙСТВАМ ........................}

procedure TErrEvent.SetLockMessage(Value: Boolean);
begin
  if Value then 
  FLockMessage:=Value;
end;

{  ..................................... МЕТОДЫ ..............................}

// ****************************************************************************
// *                                Создать объект                            *
// ****************************************************************************

constructor TErrEvent.Create(AOwner:TComponent);
begin
  inherited Create(AOwner);
  cModulName:='ERREVENT';
  Application.OnException:=MyExcept;
end;

// ****************************************************************************
// *                                Уничтожить объект                         *
// ****************************************************************************

destructor TErrEvent.Destroy;
begin
  inherited;
end;

// ****************************************************************************
// *                                Разобрать сообщение                       *
// ****************************************************************************

procedure TErrEvent.MyExcept(Sender:TObject; E:Exception);
begin
  if E is ETVError then
    TVEMessage(E.Message)
  else if E is EDBEngineError then
    BDEMessage(E.Message)
  else if E is EConvertError then
    DATMessage(E.Message)
  else if not erANYMes(E.Message,E) then begin
    ShowMessage('Неучтенная ошибка!');
    Application.ShowException(E);
  end;
end;

// ****************************************************************************
// * Реакция на ошибку 1:             Просто ретранслировать сообщение от BDE *
// ****************************************************************************

procedure TErrEvent.BDEMessage(cMessage:String);
begin
  erBDEMes(cMessage,FLockMessage,FTryError);
end;

// ****************************************************************************
// * Реакция на ошибку 2:             Расшифровать приватное сообщение от TVE *
// ****************************************************************************

procedure TErrEvent.TVEMessage(cMessage:String);
begin
 erTVEMes(cMessage,FLockMessage,FTryError);
end;

// ****************************************************************************
// * Реакция на ошибку 3:             Расшифровать сообщение по формату даты  *
// ****************************************************************************

procedure TErrEvent.DATMessage(cMessage:String);
begin
 erDATMes(cMessage);
end;

end.

// *********************************************************** ErrEvent.pas ***
