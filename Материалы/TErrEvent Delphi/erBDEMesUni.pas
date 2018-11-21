// DELPHI7, WIN98\XP                                    *** erBDEMesUni.pas ***

// ****************************************************************************
// * ErrEvent [0110]   ���������� ������� �� ������ BDE, ���������� ��������� *
// ****************************************************************************

//                                                   �����:       �������� �.�.
//                                                   ���� ��������:  24.10.2003
// Copyright � 2003 TVE                              ����.���������: 12.01.2006

unit erBDEMesUni;

interface

uses
  Controls,Dialogs,  // ����������� ������ MessageDlg
  Forms,             // ����������� ������ TApplication
  SysUtils;          // ����������� ������ UpperCase

procedure erBDEMes(cMessage:String; LockMessage:Boolean; var TryError:Integer);

implementation

procedure erBDEMes(cMessage:String; LockMessage:Boolean; var TryError:Integer);

var
  coMessage:String;
  nPoint:Integer;
  nPointK:Integer;

begin

  //ShowMessage(Copy(cMessage,1,20));

  // ������ 00000 ����� ����������: �) ���� ��� ������� ������� �� ����������
  // �������������� �������
  if Copy(cMessage,1,22)='Invalid index/tag name' then begin
    coMessage:='00000 �� ���������� �������������� �������';
    nPointK:=pos('Index: ',cMessage);
    if nPointK<>0 then begin
      coMessage:=coMessage+' '+UpperCase(Copy(cMessage,nPointK+6,40))
    end;
  end

  // ������ 00000 ����� ����������: �) ���� ��������� ������������ �� ������,
  // �������� �� ����������
  else if Copy(cMessage,1,20)='Index does not exist' then begin
    coMessage:='00000 ����������� ������ �� ����������:';
    nPointK:=pos('Index: ',cMessage);
    if nPointK<>0 then begin
      coMessage:=coMessage+' '+UpperCase(Copy(cMessage,nPointK+6,40))
    end;
  end

  // ������ 00000 ����� ����������: �) ���� ������� ���� �������������
  // �� ������, � ��������� ����� �������� �������
  else if Copy(cMessage,1,20)='Index is out of date' then begin
    coMessage:='00000 ��������� ����� �� ���� �� ������������� �������';
    nPointK:=pos('Table: ',cMessage);
    if nPointK<>0 then begin
      coMessage:=coMessage+' '+UpperCase(Copy(cMessage,nPointK+6,40))
    end;
  end

  // ������ 00048 ����� ����������: �) ��� �������� �������, ���� ��� ������
  // ��� ���������� ����� �� �������������� ��� ������� ���� �������
  else if Copy(cMessage,1,24)='Capability not supported' then
    coMessage:='00048 ���� ��������� ���������� ����� ������������ � ��������'

  // ������ 08961 ����� ����������: �) ���� ���� ������� ��� ��������� ����
  // ����� �������� ���������
  else if Copy(cMessage,1,26)='Corrupt table/index header' then
    coMessage:='08961 ��������� ��������� ����� ������� ��� ���������� '+
    UpperCase(Copy(cMessage,36,40))

  else if Copy(cMessage,1,13)='Key violation' then
    coMessage:='09729 ������������ ���� ������'

  // ������ 09985 ����� ����������: �) ���� ���� ���� ftString, �������� �
  // ��������� ������
  else if Copy(cMessage,1,22)='Number is out of range' then
    coMessage:='09985 ������ �� ��������� ��������� � ������� '+
    UpperCase(Copy(cMessage,56,40))

  else if Copy(cMessage,1,17)='Invalid directory' then
    coMessage:='10018 �������� �������: '+UpperCase(Copy(cMessage,32,40))

  // ������ 10022 ����� ����������: �) ���� ��������� ������������� ���������
  // ������� ������� Paradox �������� ������
  else if Copy(cMessage,1,22)='Invalid index/tag name' then begin
    coMessage:=cMessage;
    nPoint:=pos('Index: ',cMessage);
    if nPoint<>0 then begin
      nPointK:=pos('File or',cMessage);
      if nPointK<>0 then begin
        coMessage:='10022 �������������� ������� '+
          Copy(cMessage,nPoint+7,nPointK-nPoint-7-2)+
          ' ���������� �������';
          nPointK:=pos('File: ',cMessage);
          if nPointK<>0 then begin
            coMessage:=coMessage+' � ������� '+UpperCase(Copy(cMessage,nPointK+6,40))
          end;
      end;
    end;
  end

  // ������ 10023 ����� ����������: �) ���� � ������� DBase ��������������
  // ������� ����������, ��� "ixCaseInsensitive"
  else if Copy(cMessage,1,24)='Invalid index descriptor' then
    coMessage:='10023 �������������� ������� �� ������������� ���� ������� '+
    UpperCase(Copy(cMessage,57,40))

  // ������ 10024 ����� ����������: �) ���� ���������� ������� ����������� ���
  // ���� ������ �������
  else if Copy(cMessage,1,20)='Table does not exist' then
    coMessage:='10024 ������� ����������� ��� ���� ������ ������� '+
    UpperCase(Copy(cMessage,64,40))

  // ������ 10027 ����� ����������: �) ���� ��������� ������ � ������,
  // ������� ��� ������������
  else if cMessage='Index already exists.' then
    coMessage:='10027 ������ ��� ����������'

  // ������ 10253 ����� ����������: �) ����� ���������� ���������� ������
  // ������� � ������� Paradox, �������� ��� ��������������� �������
  else if Copy(cMessage,1,40)='Table cannot be opened for exclusive use' then
    coMessage:='10253 ������� �� ������� ��� ��������������� �������������'

  // ������ 10757 ����� ����������: �) ���� � ������� Paradox �� ���������
  // ��������� ������
  else if Copy(cMessage,1,20)='Table is not indexed' then begin
    coMessage:='10757 �� ������������� �������';
    nPointK:=pos('File: ',cMessage);
    if nPointK<>0 then begin
      coMessage:=coMessage+' '+UpperCase(Copy(cMessage,nPointK+6,40))
    end;
  end

  else if Copy(cMessage,1,14)='Path not found' then
    coMessage:='XXXXX �������� �������: '+UpperCase(Copy(cMessage,32,40))
  else
    coMessage:='????? "'+cMessage+'"';

  if not LockMessage then
    if MessageDlg('B'+coMessage+chr(13)+chr(10)+'��������� ������?',
    mtInformation,[mbYes,mbNo],0) = mrYes then Application.Terminate;
end;

end.

// ******************************************************** erBDEMesUni.pas ***
