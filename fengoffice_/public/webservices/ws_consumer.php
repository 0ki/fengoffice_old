<?php
require_once('SOAP/Client.php');

$client = new SOAP_Client("http://localhost/opengoo/webservices/hello_ws.php?wsdl", true);

$params = array();
$result = $client->call('sayHello', $params);

echo $result;

?>