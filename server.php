<?php
include('vendor/autoload.php');

use prodigyview\network\Socket;
use prodigyview\system\Security;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$server = new Socket('127.0.0.1', 8002, array(
	'bind' => true,
	'listen' => true
));

$server->startServer('', function($message) {
	
	echo "Processing...\n";
	
	//Расшифровать полученное зашифрованное сообщение
	Security::init();
	$message = Security::decrypt($message);

	//Преобразовать данные в массив
	$data = json_decode($message, true);
	
	$response = 'Not Sent';
	
	//Проверить, что используется правильный токен
	if(isset($data['token']) && $data['token'] == 'ABC123-NotRealToken') {
		
		try{
			$mail = new PHPMailer(true);
			
			$mail->Host = 'smtp1.example.com;smtp2.example.com';  
	    		$mail->SMTPAuth = true;                               
	    		$mail->Username = 'user@example.com';                
	    		$mail->Password = 'secret';                           
	    		$mail->SMTPSecure = 'tls';                           
	    		$mail->Port = 587;
				
			$mail->setFrom('from@example.com', 'Mailer');
			$mail->addAddress($data['email'], $data['to']);
			
			$mail->isHTML(true);                            
	    		$mail->Subject = $data['subject'];
	    		$mail->Body    = $data['message_html'];
	    		$mail->AltBody = $data['message_text'];   
			
			$mail->send();
			
			$response = 'Message Sent';
		} catch (Exception $e) {
			echo 'Log the error somewhere';
		}
	}
	
	//Вернуть зашифрованное сообщение
	return Security::encrypt($response);
	
}, 'closure');
