// DELPHI7, WIN98\XP                               *** erDatabaseMesUni.pas ***

// ****************************************************************************
// * ���������� ������� �� ������ EDatabaseError � ��������������� ���������  *
// ****************************************************************************

//                                                   �����:       �������� �.�.
//                                                   ���� ��������:  01.10.2004
//                                                   ����.���������: 01.10.2004

unit erDatabaseMesUni;

interface

uses
  Dialogs,  // ����������� ������ MessageDlg
  Forms,    // ����������� ������ TApplication
  SysUtils; // ����������� ������ UpperCase

procedure erDatabaseMes(cMessage:String);

implementation

procedure erDatabaseMes(cMessage:String);

var
  coMessage:String;
  nPoint:Integer;
  nPointK:Integer;

begin
  if pos('Index does not exist',cMessage)<>0 then begin
    coMessage:='';
    nPoint:=pos('Index: ',cMessage);
    if nPoint<>0 then begin
      coMessage:=
    end

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

  else
    coMessage:='????? "'+cMessage+'"';
  MessageDlg('D'+coMessage+'!',mtInformation,[mbOk],0);
  Application.Terminate;
end;
  {
  if Copy(cMessage,1,13)='Key violation' then
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
  }

end.

// *************************************************** erDatabaseMesUni.pas ***
