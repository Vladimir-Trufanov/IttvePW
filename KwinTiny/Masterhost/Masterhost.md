## [Мой Masterhost](#) 

#### 2024-12-06 - Домен doortry.ru добавлен на площадку **u542632** (тарифный план ***V4-Eco***)
```
Primary Name Server:   ns1.masterhost.ru
Secondary Name Server: ns2.masterhost.ru
Third Name Server:      ns.masterhost.ru
```
Служебный адрес: [http://doortry.ru.masterhost.tech](http://doortry.ru.masterhost.tech)

Пути к директориям:
```
Домашняя директория:  /home/u542632
Файлы сайта:          /home/u542632/doortry.ru/www
CGI скрипты:          /home/u542632/doortry.ru/cgi-bin
```
Почта: cоздание и управление почтовыми ящиками осуществляется 
через карточку Вашей площадки хостинга:
```
Сервер POP3:  pop.masterhost.ru
Сервер SMTP: smtp.masterhost.ru
Сервер IMAP: imap.masterhost.ru
Сервер MX:    mx1.masterhost.ru
```
Веб-интерфейс: [https://webmail.masterhost.ru/](https://webmail.masterhost.ru/)

Документация по работе с почтой: [https://masterhost.ru/support/mail/hosting/](https://masterhost.ru/support/mail/hosting/)

Техническая поддержка: [https://masterhost.ru/support/hosting/](https://masterhost.ru/support/hosting/)

Регистрация домена: [https://masterhost.ru/domain/](https://masterhost.ru/domain/)

```
sla6en9edged
```
```
Для вас зарегистрирована площадка по тарифу "V4-Eco"
Ваш промокод: ADAYY-HGUKSJGQM

ОБЩИЕ УСЛУГИ ДЛЯ ВСЕХ ДОМЕНОВ ПЛОЩАДКИ:

SSH:
Сервер: u542632.ssh.masterhost.ru
Логин:  u542632
Пароль: susex2edg6ssla

FTP:
Сервер: u542632.ftp.masterhost.ru
Логин:  u542632
Пароль: seasseme2gena

MySQL:
Сервер:           u542632.mysql.masterhost.ru
Имя базы данных:  u542632
Логин:            u542632
Пароль:           .A.ingEd5el9r
PHPMyAdmin:       https://phpmyadmin.masterhost.ru/

Почта:
Создание и управление почтовыми ящиками: https://mail.masterhost.ru/
Логин администратора:                    u542632
Пароль:                                  trian4ssingute
```
 	 	
***https://masterhost.ru/ | info@masterhost.ru | Тел. +7 (495) 772‑97‑20***

---
#### 2024-12-06 Диалог

Здравствуйте.
Я поместил на хостинг сайт doortry.ru, но браузеры его не находят. Почему?

> Для того, чтобы сайт работал от нас, Вам необходимо на стороне nic.ru добавить А-записи с IP-адресами площадки: 
> 90.156.201.51, 90.156.201.56, 90.156.201.71, 90.156.201.87 
> 
> Сайт в сети не отображается, т.к. в DNS нет информации, где он размещен.
> 
> А-запись - это один из видов записей в DNS-зоне, которая указывает, к какому IP должен обращаться, условно, браузер, когда Вы вводите http://doortry.ru Точно не могу подсказать, как добавить записи на nic.ru, так как из их инструкции не совсем понятно: https://www.nic.ru/help/rabota-s-resursnymi-zapisyami_11686.html 
> 
> Вы можете обратиться в поддержку nic.ru и попросить их добавить A-записи для doortry.ru и www.doortry.ru со следующими IP: 
> 90.156.201.51, 90.156.201.56, 90.156.201.71, 90.156.201.87

Здравствуйте, еще раз. Сейчас настраиваю сайт doortry.ru. Дошла очередь до .htaccess. Устанавливаю его и начальная страница не загружается. Выдается ответ: "Сайт doortry.ru выполнил слишком много перенаправлений". Что мне делать дальше.

> u542632@red26:~/doortry.ru/www$ ls -la .htaccess
> ls: cannot access '.htaccess': No such file or directory
> Где файл .htaccess?

Сейчас перебросил в корневой каталог.

> Станислав:
> 
> RewriteCond %{ENV:HTTPS} !on
> RewriteRule ^.*$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
> 
> замените на 
> 
> RewriteCond %{HTTP:PORT} !^443$
> RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R]
 	 
Хорошо, заменю. Разберусь, что это я сделал и продолжу. Спасибо!
 	  	 
