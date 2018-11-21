// LAZARUS WIN10\XP                                    *** ErrEventtest.lpr ***

// ****************************************************************************
// *               Проверить работу диспетчера исключений приложения          *
// ****************************************************************************

//                                                   Автор:       Труфанов В.Е.
//                                                   Дата создания:  23.08.2017
// Copyright © 2017 TVE                              Посл.изменение: 23.08.2017

program ErrEventTest;

{$mode objfpc}{$H+}

uses
  {$IFDEF UNIX}{$IFDEF UseCThreads}
  cthreads,
  {$ENDIF}{$ENDIF}
  Interfaces, // this includes the LCL widgetset
  Forms, ErrEventtestFrm, ErrEventClass, erANYMesUni, LazitoolsOutfit, TellmeFrm
  { you can add units after this };

{$R *.res}

begin
  RequireDerivedFormResource := True;
  Application.Initialize;
  Application.CreateForm(TfrmErrEvent, frmErrEvent);
  Application.Run;
end.

// ******************************************************* ErrEventtest.lpr ***

