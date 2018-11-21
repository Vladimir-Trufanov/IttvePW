// LAZARUS WIN10\XP                                        *** ErrEvent.pas ***

// ****************************************************************************
// * ErrEvent [110]                               Диспетчер ошибок приложения *
// ****************************************************************************

//                                                   Автор:       Труфанов В.Е.
//                                                   Дата создания:  24.10.2003
// Copyright © 2003 TVE                              Посл.изменение: 25.08.2017

unit ErrEventClass;

{$mode objfpc}{$H+}

interface

uses
  ErreventAlerts,LazitoolsOutfit,
  Classes, Forms, SysUtils, Dialogs;

type
  TErrEvent = class
  private
    // Принять исключение и разобрать сообщение
    procedure MyExcept(Sender:TObject; E:Exception);
  protected
  public
    constructor Create;
  published
 end;

implementation

uses
  erANYMesUni;

// ****************************************************************************
// *                             Создать объект                               *
// ****************************************************************************
constructor TErrEvent.Create;
begin
  Application.OnException:=@MyExcept;
end;

// ****************************************************************************
// *                Принять исключение и разобрать сообщение                  *
// ****************************************************************************
procedure TErrEvent.MyExcept(Sender:TObject; E:Exception);
begin
  if erANYMes(E)<>0 then begin
    E.Message:=Format(ereUnaccountedError,[E.Message]);
    Application.ShowException(E);
  end;
end;

end.

// *********************************************************** ErrEvent.pas ***

