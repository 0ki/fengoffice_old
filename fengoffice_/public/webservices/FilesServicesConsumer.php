<?php
require_once('SOAP/Client.php');
	
	$client = new SOAP_Client("http://www.fengoffice.com/plugin/public/webservices/FilesServices.php?wsdl");
	$params = array('timeout' => 60, 'username' => 'admin', 'password' => 'admin');
	$client = new SOAP_Client("http://localhost/opengoo/public/webservices/filesservices.php?wsdl");
	$params = array('username' => 'alvaro', 'password' => 'alvaro');
	
	$ok = $client->call('checkUser', $params);

	if (!$ok) echo 'Usuario mal';	
	else {
/*
// UPLOAD
		$sourcePath = "C:\sarasa.pdf";
		$handle = fopen($sourcePath, "rb");
		$size = filesize($sourcePath);
		$file_content = fread($handle, $size);
		fclose($handle);
		
		$params['workspaces'] = '1';
		$params['tags'] = '';
		$params['generate_rev'] = true;
		$params['filename'] = "sarasa2.pdf";
//		$params['data'] = new SOAP_Attachment(null, "application/octet", "para_upload.pdf", $file_content);
		$params['do_checkin'] = false;
		$params['description'] = 'Aca va la descripcion, lalala.';
		$params['data'] = base64_encode($file_content); 
		$params['msg'] = '';
		
		$result = $client->call('uploadFileBase64', $params);
		
		echo $result;
*/
/*
// DOWNLOAD
		$params['fileid'] = 6497;
		$params['do_checkout'] = true;
		
		$result = $client->call('downloadFileBase64', $params);
		
		if (!is_array($result)) {
			$handle = fopen("c:\\info.txt", "wb");
			fwrite($handle, $result);
			fclose($handle);
			
			$handle = fopen("c:\\name.doc", "wb");
			fwrite($handle, base64_decode($result));
			fclose($handle);
		}
*/
/*
// LIST FILES
		$params['tags'] = '';
		$params['workspaces'] = '1';//'1,2,3';
		$params['name'] = '';
		
		$result = $client->call('listFiles', $params);
		
		if (isset($result)) {
			echo $result;
		} else echo "result not set";
*/


// FILE EXISTS
		$params['filename'] = 'sarasa.pdf';
		$result = $client->call('fileExists', $params);
		
		echo $result;

/*
// CHECK OUT
		$params['fileid'] = 10;
		$result = $client->call('checkoutFile', $params);
		
		echo $result;
*/	
/*
// CHECK IN
		$params['fileid'] = 10;
		$result = $client->call('checkinFile', $params);
		
		echo $result;
*/
	}
	
	
?>