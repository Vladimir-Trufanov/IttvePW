// DELPHI7, WIN98\XP                                       *** ErrEvent.pas ***

// ****************************************************************************
// * ErrEvent [0110]                              ��������� ������ ���������� *
// ****************************************************************************

//                                                   �����:       �������� �.�.
//                                                   ���� ��������:  24.10.2003
// Copyright � 2003 TVE                              ����.���������: 12.01.2006

// ��������
//
//   ModuleName - ������������ ���������� ���������� ������;
//   LockMessage - ���������� ������ ��������� ��� ������������� ����������;
//   TryError - ��� ���������� (������ ��� ������);

// ������

//   ������������ �������� ������� ��� ������������� ����������

unit ErrEvent;

interface

uses
  Td7Profi,
  Classes,Controls,Graphics,SysUtils,
  DBTables,              // ����������� ������ EBDEngineError,
  Dialogs,               // ����������� ������ MessageDlg
  ExtCtrls,              // ����������� ������ TIMage
  Forms,                 // ����������� ������ TApplication
  StdCtrls;              // ����������� ������ T����

type

  TErrEvent = class(TComponent)

  private

    cModulName:String;       // ������������ �������� ������
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

{  ............................... ������ � ��������� ........................}

procedure TErrEvent.SetLockMessage(Value: Boolean);
begin
  if Value then 
  FLockMessage:=Value;
end;

{  ..................................... ������ ..............................}

// ****************************************************************************
// *                                ������� ������                            *
// ****************************************************************************

constructor TErrEvent.Create(AOwner:TComponent);
begin
  inherited Create(AOwner);
  cModulName:='ERREVENT';
  Application.OnException:=MyExcept;
end;

// ****************************************************************************
// *                                ���������� ������                         *
// ****************************************************************************

destructor TErrEvent.Destroy;
begin
  inherited;
end;

// ****************************************************************************
// *                                ��������� ���������                       *
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
    ShowMessage('���������� ������!');
    Application.ShowException(E);
  end;
end;

// ****************************************************************************
// * ������� �� ������ 1:             ������ ��������������� ��������� �� BDE *
// ****************************************************************************

procedure TErrEvent.BDEMessage(cMessage:String);
begin
  erBDEMes(cMessage,FLockMessage,FTryError);
end;

// ****************************************************************************
// * ������� �� ������ 2:             ������������ ��������� ��������� �� TVE *
// ****************************************************************************

procedure TErrEvent.TVEMessage(cMessage:String);
begin
 erTVEMes(cMessage,FLockMessage,FTryError);
end;

// ****************************************************************************
// * ������� �� ������ 3:             ������������ ��������� �� ������� ����  *
// ****************************************************************************

procedure TErrEvent.DATMessage(cMessage:String);
begin
 erDATMes(cMessage);
end;

end.

// *********************************************************** ErrEvent.pas ***
