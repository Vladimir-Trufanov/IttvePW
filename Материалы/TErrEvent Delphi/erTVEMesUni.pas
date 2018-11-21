// DELPHI7, WIN98\XP                                    *** erTVEMesUni.pas ***

// ****************************************************************************
// * ErrEvent [0110]    ���������� ������� �� ������ TVE, ��������� ��������� *
// ****************************************************************************

//                                                   �����:       �������� �.�.
//                                                   ���� ��������:  11.11.2003
// Copyright � 2003 TVE                              ����.���������: 12.01.2006

// ������ ������������ ��� ���������� � ����� ETVError �� �������:
//                   'XXX'+'����� �� ������� ��������� �� �� ����� 60 ��������'

unit erTVEMesUni;

interface


uses
  Controls,Dialogs,  // ����������� ������ MessageDlg
  Forms,             // ����������� ������ TApplication
  SysUtils;          // ����������� ������ UpperCase

procedure erTVEMes(cMessage:String; LockMessage:Boolean; var TryError:Integer);

implementation

procedure erTVEMes(cMessage:String; LockMessage:Boolean; var TryError:Integer);

var
  coMessage: String;
  cCodeError: String;
  cPostMes: String;

begin
  cCodeError:=Copy(cMessage,1,5);
  cPostMes:=UpperCase(Copy(cMessage,6,60));
  coMessage:=cMessage+'::= �� �������� ���������';

  // ��� ����, ����� ��������������� ���� �� ����������� �������� �������
  // ��������� �������� ��������� �� �����������

  // TD7PROWN

  if Copy(cCodeError,1,3)='001' then begin
    cCodeError:=Copy(cCodeError,4,2);
    if cCodeError='01' then      // FILEERASE
      coMessage:=cPostMes;
    cCodeError:='001'+cCodeError;
  end;

  // TVARSAVER

  if Copy(cCodeError,1,3)='100' then begin
    cCodeError:=Copy(cCodeError,4,2);

    if cCodeError='15' then      // VARSAVER.ISSTRING/ISINTEGER
      coMessage:='�������� �� ���� �������� ����������� ���������� '+
      UpperCase(cPostMes)
    else if cCodeError='16' then // VARSAVER.ISSTRING/ISINTEGER
      coMessage:='�� ���������� ������������ INI-�����';
    cCodeError:='100'+cCodeError;
  end;

  // TBASEMAKER

  if Copy(cCodeError,1,3)='120' then begin
    cCodeError:=Copy(cCodeError,4,2);

    if cCodeError='03' then
      coMessage:='�������� ������������ �����: '+cPostMes
    else if cCodeError='04' then // BASEMAKER. ... .BMREDEFINENAME
      coMessage:='��� ������������ ������� (��� ����������) �������: '+cPostMes
    else if cCodeError='05' then // BASEMAKER.BMGETTABLETYPE
      coMessage:='���� '+cPostMes+' �� ����� ���� �������� �������� Paradox'
    else if cCodeError='06' then // BASEMAKER.BMGETTABLETYPE
      coMessage:='���� '+cPostMes+' �� ����� ���� �������� �������� DBase'
    //else if cCodeError='07' then
    //  coMessage:='����� ������� �� � ���������: '+cPostMes+' <> [1,12]'
    //else if cCodeError='08' then
    //  coMessage:='��� ������� �� � ���������: '+cPostMes
    else if cCodeError='09' then // BASEMAKER.BMGETTABLETYPE
      coMessage:='������� [ttDefault] '+cPostMes+
      ' ������ ���� ������� ����������'
    else if cCodeError='10' then // BASEMAKER.BMGETTABLETYPE
      coMessage:='� ����� [ttDefault] '+cPostMes+
      ' ������ ���� ���������� DB/DBF'
    else if cCodeError='11' then // BASEMAKER.BMGETTABLETYPE
      coMessage:='��� ������� '+cPostMes+' �� �� {ttParadox/ttDBase/ttDefault}'
    else if cCodeError='12' then // BASEMAKER.BMCREATETABLE
      coMessage:='��� ������� '+cPostMes+' �� ���������� ����'
    else if cCodeError='13' then // BASEMAKER.BMERASE
      coMessage:='����� ��������� ������� '+cPostMes+' ������ ���� �������'
    else if cCodeError='14' then // BASEMAKER.COPYRECORD.BMCOPYRECORD
      coMessage:='������� '+cPostMes+' ����� ������������ ������ �� �������'
    else if cCodeError='15' then // BASEMAKER.COPYRECORD.BMCOPYRECORD
      coMessage:='������� '+cPostMes+' ����� ������������ ������ '+
      '�� � ������ ����� ��� ��������������'
    else if cCodeError='16' then // BASEMAKER.BMCLEARINDEXBYTE[BMISINDEXBYTE]
      coMessage:='���� ������� '+cPostMes+' �� ���������� '
    else if cCodeError='17' then // BASEMAKER.BMCLEARINDEXBYTE[BMISINDEXBYTE]
      coMessage:='���� ������� �������� � �������: '+cPostMes
    else if cCodeError='18' then // BASEMAKER.BMCLEARINDEXBYTE[BMISINDEXBYTE]
      coMessage:='�������� �� ��������� ����� ������� '+cPostMes
    else if cCodeError='19' then // BASEMAKER.BMCLEARINDEXBYTE[BMISINDEXBYTE]
      coMessage:='���� ������� �������� � �������: '+cPostMes
    else if cCodeError='20' then // BASEMAKER.BMERASE[BMISINDEX]
      coMessage:='��� �������: '+cPostMes+' ������� ����� 8 ��������'
    else if cCodeError='21' then // BASEMAKER.BMINDEX
      coMessage:='��� �������: '+cPostMes+' ��� ��������������'
    else if cCodeError='22' then // BASEMAKER.SETACTIVE
      coMessage:=
      '�������� ������ ���������� ��-�� ���������� �������: '+cPostMes
    else if cCodeError='23' then // BASEMAKER.BMCLEARINDEXBYTE[BMISINDEXBYTE]
      coMessage:='������ ������ �� �����:'+cPostMes
    else if cCodeError='24' then // BASEMAKER.BMCLEARINDEXBYTE
      coMessage:='������ ������ � ����:'+cPostMes
    else if cCodeError='25' then // BASEMAKER.BMPACK
      coMessage:='����� ��������� ������� '+cPostMes+' ������ ���� �������'
    else if cCodeError='26' then // BASEMAKER.BMSHOWDELETED
      coMessage:='��� ��������� ������ ��������� ������� ������� '+
      cPostMes+' ������ ���� � ������ ���������'
    else if cCodeError='27' then // BASEMAKER.TAKE
      coMessage:='� ���� '+cPostMes+' ������ �������� ���� varEmpty'
    else if cCodeError='32' then // BASEMAKER.BMCLEARINDEXBYTE[BMISINDEXBYTE]
      coMessage:='������� �������� ���������� �������� ����� '+cPostMes
    ;
    cCodeError:='120'+cCodeError;
  end;

  // TSTRUFIELDS

  if Copy(cCodeError,1,3)='121' then begin
    cCodeError:=Copy(cCodeError,4,2);
    if cCodeError='01' then      // BMSTRUFIELDSUNI.GETITEMS
      coMessage:='����� �������� ��� ������ ����� ��� ��������� [0..'+
      UpperCase(cPostMes)+']';
    cCodeError:='121'+cCodeError;
  end;

  // TSTRUINDEXES

  if Copy(cCodeError,1,3)='122' then begin
    cCodeError:=Copy(cCodeError,4,2);
    if cCodeError='01' then      // BMSTRUINDEXES.GETITEMS
      coMessage:='����� �������� ��� ������ �������� ��� ��������� [0..'+
      UpperCase(cPostMes)+']';
    cCodeError:='122'+cCodeError;
  end;

  TryError:=StrToInt(cCodeError);
  if not LockMessage then begin
    if MessageDlg(cCodeError+': '+coMessage+
      chr(13)+chr(10)+'��������� ������?',
      mtInformation,[mbYes,mbNo],0) = mrYes then Application.Terminate;
  end;
end;

end.

// ******************************************************** erTVEMesUni.pas ***
