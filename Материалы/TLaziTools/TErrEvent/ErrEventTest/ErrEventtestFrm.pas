// LAZARUS WIN10\XP                                 *** ErrEventtestFrm.pas ***

// ****************************************************************************
// *               Проверить работу диспетчера исключений приложения          *
// ****************************************************************************

//                                                   Автор:       Труфанов В.Е.
//                                                   Дата создания:  23.08.2017
// Copyright © 2017 TVE                              Посл.изменение: 23.08.2017

unit ErrEventtestFrm;

{$mode objfpc}{$H+}

interface

uses
  ErrEventClass,
  Classes, SysUtils, FileUtil, Forms, Controls, Graphics, Dialogs, StdCtrls;

type

  { TfrmErrEvent }

  TfrmErrEvent = class(TForm)
    Button1: TButton;
    Button2: TButton;
    lbl: TLabel;
    procedure Button1Click(Sender: TObject);
    procedure Button2Click(Sender: TObject);
    procedure FormCreate(Sender: TObject);
  private
    ErrEvent: TErrEvent;
public
    { public declarations }
  end;

var
  frmErrEvent: TfrmErrEvent;

implementation

{$R *.lfm}

{ TfrmErrEvent }

// Проверить вызов исключения "Ошибка деления целого на ноль"
procedure TfrmErrEvent.Button1Click(Sender: TObject);
var
  a,b,c: Integer;
begin
  a:=5; b:=0; c:= a DIV b;
end;

// Проверить вызов исключения "Обращение к несуществующему объекту"
procedure TfrmErrEvent.Button2Click(Sender: TObject);
var
  o: TErrEvent;
begin
  lbl.Caption:=o.ClassName;
end;

procedure TfrmErrEvent.FormCreate(Sender: TObject);
begin
  ErrEvent:=TErrEvent.Create;
end;


end.

// **************************************************** ErrEventtestFrm.pas ***


