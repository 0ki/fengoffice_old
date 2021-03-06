<?php
require_once('SOAP/Server.php');
require_once('SOAP/Disco.php');

class Hello {
	
	function Hello() {
		$this->__dispatch_map['sayHello'] = array(
            "in"  => array(),
            "out" => array("text" => "string"));
	}
	
	function sayHello() {
		return 'Hello - Test WS';
	}
}

$server = new SOAP_Server();
$webservice = new Hello();

$server->addObjectMap($webservice,'http://schemas.xmlsoap.org/soap/envelope/');

// start serve

if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD']=='POST') {
     $server->service($HTTP_RAW_POST_DATA);
} else {
     $disco = new SOAP_DISCO_Server($server,'HelloWebService');
     header("Content-type: text/xml");

     if (isset($_SERVER['QUERY_STRING']) && strcasecmp($_SERVER['QUERY_STRING'],'wsdl') == 0) {
         // show only the WSDL/XML output if ?wsdl is set in the address bar
         echo $disco->getWSDL();
     } else {
         echo $disco->getDISCO();
     }

}

?>