// DELPHI7, WIN98\XP                                    *** erTVEMesUni.pas ***

// ****************************************************************************
// * ErrEvent [0110]    Отработать реакцию на ошибку TVE, генерируя сообщение *
// ****************************************************************************

//                                                   Автор:       Труфанов В.Е.
//                                                   Дата создания:  11.11.2003
// Copyright © 2003 TVE                              Посл.изменение: 12.01.2006

// Модуль обрабатывает все исключения с типом ETVError по формату:
//                   'XXX'+'Текст об объекте сообщения из не более 60 символов'

unit erTVEMesUni;

interface


uses
  Controls,Dialogs,  // Определения модуля MessageDlg
  Forms,             // Определение класса TApplication
  SysUtils;          // Определение модуля UpperCase

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
  coMessage:=cMessage+'::= Не учтенное сообщение';

  // Для того, чтобы контроллировать стек по вложенности проверок условий
  // разбиваем проверку сообщений по компонентам

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
      coMessage:='Неверное по типу значение сохраняемой переменной '+
      UpperCase(cPostMes)
    else if cCodeError='16' then // VARSAVER.ISSTRING/ISINTEGER
      coMessage:='Не определено наименование INI-файла';
    cCodeError:='100'+cCodeError;
  end;

  // TBASEMAKER

  if Copy(cCodeError,1,3)='120' then begin
    cCodeError:=Copy(cCodeError,4,2);

    if cCodeError='03' then
      coMessage:='Неверная спецификация файла: '+cPostMes
    else if cCodeError='04' then // BASEMAKER. ... .BMREDEFINENAME
      coMessage:='Нет наименования таблицы (без расширения) объекта: '+cPostMes
    else if cCodeError='05' then // BASEMAKER.BMGETTABLETYPE
      coMessage:='Файл '+cPostMes+' не может быть объявлен таблицей Paradox'
    else if cCodeError='06' then // BASEMAKER.BMGETTABLETYPE
      coMessage:='Файл '+cPostMes+' не может быть объявлен таблицей DBase'
    //else if cCodeError='07' then
    //  coMessage:='Месяц расчета не в диапазоне: '+cPostMes+' <> [1,12]'
    //else if cCodeError='08' then
    //  coMessage:='Год расчета не в диапазоне: '+cPostMes
    else if cCodeError='09' then // BASEMAKER.BMGETTABLETYPE
      coMessage:='Таблице [ttDefault] '+cPostMes+
      ' должно быть указано расширение'
    else if cCodeError='10' then // BASEMAKER.BMGETTABLETYPE
      coMessage:='У файла [ttDefault] '+cPostMes+
      ' должно быть расширение DB/DBF'
    else if cCodeError='11' then // BASEMAKER.BMGETTABLETYPE
      coMessage:='Тип таблицы '+cPostMes+' не из {ttParadox/ttDBase/ttDefault}'
    else if cCodeError='12' then // BASEMAKER.BMCREATETABLE
      coMessage:='Для таблицы '+cPostMes+' не определены поля'
    else if cCodeError='13' then // BASEMAKER.BMERASE
      coMessage:='Перед удалением таблица '+cPostMes+' должна быть закрыта'
    else if cCodeError='14' then // BASEMAKER.COPYRECORD.BMCOPYRECORD
      coMessage:='Таблица '+cPostMes+' перед копированием записи не открыта'
    else if cCodeError='15' then // BASEMAKER.COPYRECORD.BMCOPYRECORD
      coMessage:='Таблица '+cPostMes+' перед копированием записи '+
      'не в режиме ввода или редактирования'
    else if cCodeError='16' then // BASEMAKER.BMCLEARINDEXBYTE[BMISINDEXBYTE]
      coMessage:='Файл таблицы '+cPostMes+' не существует '
    else if cCodeError='17' then // BASEMAKER.BMCLEARINDEXBYTE[BMISINDEXBYTE]
      coMessage:='Файл таблицы открылся с ошибкой: '+cPostMes
    else if cCodeError='18' then // BASEMAKER.BMCLEARINDEXBYTE[BMISINDEXBYTE]
      coMessage:='Закрытие не открытого файла таблицы '+cPostMes
    else if cCodeError='19' then // BASEMAKER.BMCLEARINDEXBYTE[BMISINDEXBYTE]
      coMessage:='Файл таблицы закрылся с ошибкой: '+cPostMes
    else if cCodeError='20' then // BASEMAKER.BMERASE[BMISINDEX]
      coMessage:='Для таблицы: '+cPostMes+' создано более 8 индексов'
    else if cCodeError='21' then // BASEMAKER.BMINDEX
      coMessage:='Нет таблицы: '+cPostMes+' для индексирования'
    else if cCodeError='22' then // BASEMAKER.SETACTIVE
      coMessage:=
      'Прервана работа приложения из-за отсутствия таблицы: '+cPostMes
    else if cCodeError='23' then // BASEMAKER.BMCLEARINDEXBYTE[BMISINDEXBYTE]
      coMessage:='Ошибка чтения из файла:'+cPostMes
    else if cCodeError='24' then // BASEMAKER.BMCLEARINDEXBYTE
      coMessage:='Ошибка записи в файл:'+cPostMes
    else if cCodeError='25' then // BASEMAKER.BMPACK
      coMessage:='Перед упаковкой таблица '+cPostMes+' должна быть закрыта'
    else if cCodeError='26' then // BASEMAKER.BMSHOWDELETED
      coMessage:='При изменении показа удаленных записей таблица '+
      cPostMes+' должна быть в режиме просмотра'
    else if cCodeError='27' then // BASEMAKER.TAKE
      coMessage:='В поле '+cPostMes+' пустое значение типа varEmpty'
    else if cCodeError='32' then // BASEMAKER.BMCLEARINDEXBYTE[BMISINDEXBYTE]
      coMessage:='Попытка открытия монопольно занятого файла '+cPostMes
    ;
    cCodeError:='120'+cCodeError;
  end;

  // TSTRUFIELDS

  if Copy(cCodeError,1,3)='121' then begin
    cCodeError:=Copy(cCodeError,4,2);
    if cCodeError='01' then      // BMSTRUFIELDSUNI.GETITEMS
      coMessage:='Номер элемента для списка полей вне диапазона [0..'+
      UpperCase(cPostMes)+']';
    cCodeError:='121'+cCodeError;
  end;

  // TSTRUINDEXES

  if Copy(cCodeError,1,3)='122' then begin
    cCodeError:=Copy(cCodeError,4,2);
    if cCodeError='01' then      // BMSTRUINDEXES.GETITEMS
      coMessage:='Номер элемента для списка индексов вне диапазона [0..'+
      UpperCase(cPostMes)+']';
    cCodeError:='122'+cCodeError;
  end;

  TryError:=StrToInt(cCodeError);
  if not LockMessage then begin
    if MessageDlg(cCodeError+': '+coMessage+
      chr(13)+chr(10)+'Завершить работу?',
      mtInformation,[mbYes,mbNo],0) = mrYes then Application.Terminate;
  end;
end;

end.

// ******************************************************** erTVEMesUni.pas ***
