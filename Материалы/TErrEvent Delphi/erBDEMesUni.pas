// DELPHI7, WIN98\XP                                    *** erBDEMesUni.pas ***

// ****************************************************************************
// * ErrEvent [0110]   Отработать реакцию на ошибку BDE, транслируя сообщение *
// ****************************************************************************

//                                                   Автор:       Труфанов В.Е.
//                                                   Дата создания:  24.10.2003
// Copyright © 2003 TVE                              Посл.изменение: 12.01.2006

unit erBDEMesUni;

interface

uses
  Controls,Dialogs,  // Определение модуля MessageDlg
  Forms,             // Определение класса TApplication
  SysUtils;          // Определение модуля UpperCase

procedure erBDEMes(cMessage:String; LockMessage:Boolean; var TryError:Integer);

implementation

procedure erBDEMes(cMessage:String; LockMessage:Boolean; var TryError:Integer);

var
  coMessage:String;
  nPoint:Integer;
  nPointK:Integer;

begin

  //ShowMessage(Copy(cMessage,1,20));

  // Ошибка 00000 может возникнуть: а) если для данного индекса не определена
  // характеристика индекса
  if Copy(cMessage,1,22)='Invalid index/tag name' then begin
    coMessage:='00000 Не определена характеристика индекса';
    nPointK:=pos('Index: ',cMessage);
    if nPointK<>0 then begin
      coMessage:=coMessage+' '+UpperCase(Copy(cMessage,nPointK+6,40))
    end;
  end

  // Ошибка 00000 может возникнуть: а) если запрошено переключение на индекс,
  // которого не существует
  else if Copy(cMessage,1,20)='Index does not exist' then begin
    coMessage:='00000 Запрошенный индекс не существует:';
    nPointK:=pos('Index: ',cMessage);
    if nPointK<>0 then begin
      coMessage:=coMessage+' '+UpperCase(Copy(cMessage,nPointK+6,40))
    end;
  end

  // Ошибка 00000 может возникнуть: а) если таблица была восстановлена
  // из архива, а индексные файлы остались прежние
  else if Copy(cMessage,1,20)='Index is out of date' then begin
    coMessage:='00000 Индексные файлы по дате не соответствуют таблице';
    nPointK:=pos('Table: ',cMessage);
    if nPointK<>0 then begin
      coMessage:=coMessage+' '+UpperCase(Copy(cMessage,nPointK+6,40))
    end;
  end

  // Ошибка 00048 может возникнуть: а) при создании таблицы, если тип одного
  // или нескольких полей не поддерживается для данного типа таблицы
  else if Copy(cMessage,1,24)='Capability not supported' then
    coMessage:='00048 Типы некоторых задаваемых полей несовместимы с таблицей'

  // Ошибка 08961 может возникнуть: а) если файл таблицы или индексный файл
  // имеют неверный заголовок
  else if Copy(cMessage,1,26)='Corrupt table/index header' then
    coMessage:='08961 Поврежден заголовок файла таблицы или индексного '+
    UpperCase(Copy(cMessage,36,40))

  else if Copy(cMessage,1,13)='Key violation' then
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

  // Ошибка 10024 может возникнуть: а) если заказанная таблица отсутствует или
  // путь указан неверно
  else if Copy(cMessage,1,20)='Table does not exist' then
    coMessage:='10024 Таблица отсутствует или путь указан неверно '+
    UpperCase(Copy(cMessage,64,40))

  // Ошибка 10027 может возникнуть: а) если создается индекс с именем,
  // которое уже используется
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
  else
    coMessage:='????? "'+cMessage+'"';

  if not LockMessage then
    if MessageDlg('B'+coMessage+chr(13)+chr(10)+'Завершить работу?',
    mtInformation,[mbYes,mbNo],0) = mrYes then Application.Terminate;
end;

end.

// ******************************************************** erBDEMesUni.pas ***
