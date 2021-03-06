<?php
require_once('SOAP/Client.php');

	$client = new SOAP_Client("http://www.fengoffice.com/plugin/public/webservices/WorkspaceServices.php?wsdl");
	$params = array('username' => 'admin', 'password' => 'admin');
//	$client = new SOAP_Client("http://localhost/opengoo/public/webservices/Workspaceservices.php?wsdl");
//	$params = array('username' => 'alvaro', 'password' => 'alvaro');
	
	$ok = $client->call('checkUser', $params);
	
	if (!$ok) echo 'Usuario mal';	
	else {
		$result = $client->call('listWorkspaces', $params);
		
		if (isset($result)) {
			echo $result;
		} else echo "result not set";
	}
	
	
?>