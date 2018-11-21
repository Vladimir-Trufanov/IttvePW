// DELPHI7, WIN98\XP                                    *** erANYMesUni.pas ***

// ****************************************************************************
// * ErrEvent [0110]           ���������� ������� �� ����������������� ������ *
// *                                                ��������������� ��������� *
// ****************************************************************************

//                                                   �����:       �������� �.�.
//                                                   ���� ��������:  11.11.2003
//                                                   ����.���������: 23.11.2004

unit erANYMesUni;

interface

uses
  Classes,Controls,Graphics,
  Dialogs,  // ����������� ������ MessageDlg
  Forms,    // ����������� ������ TApplication
  SysUtils; // ����������� ������ UpperCase

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
    MyMessage('��������� � ��������������� �������!');
  end

  else if E is EDivByZero then
    MyMessage('������� ������ �� ����!')

  else if E is EFOpenError then begin
    coMessage:=Copy(cMessage,19,length(cMessage));
    nPoint:=AnsiPos('"',coMessage);
    if nPoint<>0 then coMessage:=Copy(coMessage,1,nPoint-1)
    else coMessage:='';
    MyMessage('�� ������� ����� ����: '+coMessage+' ');
  end

  else if E is EInOutError then
    MyMessage(cMessage)

  // ��-������: ���� ��������� ����� ��������� � ���������� ���� AnsiString,
  // ������� ��� ���������� (��� ��������� � ������ �������� ������)
  else if E is EInvalidPointer then begin
    MyMessage('�������� ���������!')
  end

  else if E is EZeroDivide then
    MyMessage('������� �� ����!')

  else begin
    Result:=False;
  end;

end;

// ****************************************************************************
// *             ������� ��������� �� ������  � ��������� ����������          *
// ****************************************************************************

procedure MyMessage(cMessage:String);
begin
  if MessageDlg(cMessage+'! ��������� ������?',mtError,[mbYes,mbNo],0)=mrYes
  then Application.Terminate;
end;

end.

// ******************************************************** erANYMesUni.pas ***
