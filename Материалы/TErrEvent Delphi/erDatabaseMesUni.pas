// DELPHI7, WIN98\XP                               *** erDatabaseMesUni.pas ***

// ****************************************************************************
// * Отработать реакцию на ошибку EDatabaseError и ретранслировать сообщение  *
// ****************************************************************************

//                                                   Автор:       Труфанов В.Е.
//                                                   Дата создания:  01.10.2004
//                                                   Посл.изменение: 01.10.2004

unit erDatabaseMesUni;

interface

uses
  Dialogs,  // Определение модуля MessageDlg
  Forms,    // Определение класса TApplication
  SysUtils; // Определение модуля UpperCase

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
        coMessage:='10022 Характеристики индекса '+
          Copy(cMessage,nPoint+7,nPointK-nPoint-7-2)+
          ' определены неверно';
          nPointK:=pos('File: ',cMessage);
          if nPointK<>0 then begin
            coMessage:=coMessage+' в таблице '+UpperCase(Copy(cMessage,nPointK+6,40))
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
    coMessage:='09729 Неуникальный ключ записи'

  // Ошибка 09985 может возникнуть: а) если поле типа ftString, включено в
  // первичный индекс
  else if Copy(cMessage,1,22)='Number is out of range' then
    coMessage:='09985 Индекс за пределами диапазона в таблице '+
    UpperCase(Copy(cMessage,56,40))

  else if Copy(cMessage,1,17)='Invalid directory' then
    coMessage:='10018 Неверный каталог: '+UpperCase(Copy(cMessage,32,40))

  // Ошибка 10022 может возникнуть: а) если множество характеристик заданного
  // индекса таблицы Paradox является пустым
  else if Copy(cMessage,1,22)='Invalid index/tag name' then begin
    coMessage:=cMessage;
    nPoint:=pos('Index: ',cMessage);
    if nPoint<>0 then begin
      nPointK:=pos('File or',cMessage);
      if nPointK<>0 then begin
        coMessage:='10022 Характеристики индекса '+
          Copy(cMessage,nPoint+7,nPointK-nPoint-7-2)+
          ' определены неверно';
          nPointK:=pos('File: ',cMessage);
          if nPointK<>0 then begin
            coMessage:=coMessage+' в таблице '+UpperCase(Copy(cMessage,nPointK+6,40))
          end;
      end;
    end;
  end

  // Ошибка 10023 может возникнуть: а) если в таблице DBase характеристика
  // индекса определена, как "ixCaseInsensitive"
  else if Copy(cMessage,1,24)='Invalid index descriptor' then
    coMessage:='10023 Характеристика индекса не соответствует типу таблицы '+
    UpperCase(Copy(cMessage,57,40))

  else if cMessage='Index already exists.' then
    coMessage:='10027 Индекс уже существует'

  // Ошибка 10253 может возникнуть: а) когда происходит добавление нового
  // индекса к таблице Paradox, открытой без исключительного доступа
  else if Copy(cMessage,1,40)='Table cannot be opened for exclusive use' then
    coMessage:='10253 Таблица не открыта для исключительного использования'

  // Ошибка 10757 может возникнуть: а) если в таблице Paradox не определен
  // первичный индекс
  else if Copy(cMessage,1,20)='Table is not indexed' then begin
    coMessage:='10757 Не индексируется таблица';
    nPointK:=pos('File: ',cMessage);
    if nPointK<>0 then begin
      coMessage:=coMessage+' '+UpperCase(Copy(cMessage,nPointK+6,40))
    end;
  end

  else if Copy(cMessage,1,14)='Path not found' then
    coMessage:='XXXXX Неверный каталог: '+UpperCase(Copy(cMessage,32,40))
  }

end.

// *************************************************** erDatabaseMesUni.pas ***
