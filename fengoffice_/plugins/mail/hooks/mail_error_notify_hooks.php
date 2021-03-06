<?php

function mail_on_save_mail_error($error_data, &$ret){
	Env::useLibrary('swift');
	
	$mailer = Notifier::getMailer();
	
	$ma = $error_data['account'];
	$ma_info = array();
	if ($ma instanceof MailAccount) {
		foreach ($ma->getColumns() as $col) {
			$ma_info[$col] = $ma->getColumnValue($col);
		} 
	}
	$e = $error_data['exception'];
	
	$body = "\n".$e->__toString();
	if ($e instanceof Error) {
		$body .= "\n\n*******************************\n\nAdditional error info: ".print_r($e->getParams(), 1);
	}
	$body .= "\n\n*******************************\n\nMail Account Info: ".print_r($ma_info, 1);
	$body .= "\n\n*******************************\n\nServer Info: ".print_r($_SERVER, 1);
	$body .= "\n\n*******************************\n\nPOST Info: ".print_r($_POST, 1);
	$body .= "\n\n*******************************\n\nGET Info: ".print_r($_GET, 1);
	$body .= "\n\n*******************************\n\nSESSION Info: ".print_r($_SESSION, 1);
	
	$message = Swift_Message::newInstance("Error when saving email at ".$_SERVER['SERVER_NAME'])
	  ->setFrom('support@fengoffice.com')
	  ->setBody($body)
	  ->setContentType('text/plain')
	;
	
	$attach = Swift_Attachment::newInstance($error_data['content'], 'original_email.eml', 'text/plain');
	$message->attach($attach);
	
	$to_addresses = 'support@fengoffice.com';
	
	$to = prepare_email_addresses(implode(",", explode(";", $to_addresses)));
	foreach ($to as $address) {
		$message->addTo(array_var($address, 0), array_var($address, 1));
	}
	$result = $mailer->send($message);
}