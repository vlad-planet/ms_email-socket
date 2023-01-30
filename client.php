<?php

include('vendor/autoload.php');

use prodigyview\network\Socket;
use prodigyview\system\Security;

//Фиктивные данные отправителя
$data = array(
	'to' => 'Jane Doe',
	'email' => 'jane@example.com',
	'subject' => 'Hello Jane',
	'message_html'=> '<p>Dear Jane</p><p>You Are The Best!</p>',
	'message_text'=> 'Dear Jane, You Are The Best!',
);

//Добавить токен для проверки
$data['token'] = 'ABC123-NotRealToken';

//Преобразовать данные в JSON
$message = json_encode($data);

//Зашифровать сообщение
Security::init();
$message = Security::encrypt($message);

//Отправить сообщение на наш Сервер
$host = '127.0.0.1';
$port = 8002;
$socket = new Socket($host, $port, array('connect' => true));

$response = $socket->send($message);

$response = Security::decrypt($response);

echo "$response \n";
