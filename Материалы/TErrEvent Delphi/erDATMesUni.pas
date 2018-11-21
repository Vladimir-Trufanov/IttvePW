// DELPHI7, WIN98\XP                                    *** erDATMesUni.pas ***

// ****************************************************************************
// * ErrEvent [0110]             ���������� ������� �� ������ ������� ������� *
// *                                              � ��������������� ��������� *
// ****************************************************************************

//                                                   �����:       �������� �.�.
//                                                   ���� ��������:  24.10.2003
//                                                   ����.���������: 15.11.2004

unit erDATMesUni;

interface

uses
  Dialogs,               // ����������� ������ MessageDlg
  Forms,                 // ����������� ������ TApplication
  SysUtils;              // ����������� ������ UpperCase

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
    coMessage:='�������� ������ ����: '+Copy(cMessage,1,nPoint-1);

  nPoint:=Pos('is not a valid integer value',cMessage);
  if nPoint<>0 then
    coMessage:='�������� ������ ����� ����� ���������������: '+
    Copy(cMessage,1,nPoint-1);

  MessageDlg(coMessage+'!',mtInformation,[mbOk],0);
end;

end.

// ******************************************************** erDATMesUni.pas ***
