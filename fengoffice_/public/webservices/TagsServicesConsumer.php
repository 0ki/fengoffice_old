<?php
require_once('SOAP/Client.php');

	$client = new SOAP_Client("http://www.fengoffice.com/plugin/public/webservices/TagsServices.php?wsdl");
	$params = array('username' => 'admin', 'password' => 'admin');
//	$client = new SOAP_Client("http://localhost/opengoo/public/webservices/tagsservices.php?wsdl");
//	$params = array('username' => 'alvaro', 'password' => 'alvaro');
	
	$ok = $client->call('checkUser', $params);

	if (!$ok) echo 'Usuario mal';	
	else {
		$result = $client->call('listTags', $params);
		
		if (isset($result)) {
			if (is_array($result)) {
				echo 'Inicio Lista de Tags<br>';
				foreach ($result as $k => $item) {
					echo "[$item]" . '<br>';
				}
				echo 'Fin Lista de Tags<br>';
			} else { 
				echo $result;//"result not an array";
			}
		} else echo "result not set";
	}
?>