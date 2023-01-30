# ms_email_socket
 microservices
 
## Socket сервер для отправки Email + Безопасность данных
 
Требования к Запуску Теста:<br>
- Composer<br>
- ^PHP7<br>
- PHP Sockets Extensions Installed<br>
 
1. Перейдите в корневой каталог<br>
2. Запустите composer install для установки необходимых пакетов<br>
3. Откройте две вкладки в вашей консоли<br>
4. На одной вкладке запустите php server.php<br>
5. На другой вкладке запустите php client.php<br>
 
_________________________________________________________________________________

### Создание сервера

```php
$server = new Socket('127.0.0.1', 8000, array(
  'bind' => true,
  'listen' => true
));

$server->startServer('', function($message) {
  //Logic will go in here
}, 'closure');
```

### Отправить сообщение на Сервер

```php
$host = '127.0.0.1';
$port = 8002;
$socket = new Socket($host, $port, array('connect' => true));

$response = $socket->send($message);
```
