<?php
define('CONSOLE_MODE', true);

require_once(realpath(dirname(__FILE__) . '/../../') . DIRECTORY_SEPARATOR . 'index.php');
//set_include_path(realpath(ROOT . '/../../php/PEAR/') . PATH_SEPARATOR . get_include_path());
set_include_path(LIBRARY_PATH . DIRECTORY_SEPARATOR . 'PEAR/' . PATH_SEPARATOR . get_include_path());

require_once(LIBRARY_PATH . DIRECTORY_SEPARATOR . 'PEAR/SOAP/Server.php');
require_once(LIBRARY_PATH . DIRECTORY_SEPARATOR . 'PEAR/SOAP/Disco.php');
require_once(LIBRARY_PATH . DIRECTORY_SEPARATOR . 'PEAR/SOAP/Type/hexBinary.php');

class WebServicesBase {
	
	function WebServicesBase() {
		$this->__dispatch_map['checkUser'] = array(
            'in'  => array('username' => 'string', 'password' => 'string'),
            'out' => array('validUser' => 'boolean')
		);
	}
	
	function checkUser($username, $password) {
		if(trim($username == '')) {
			return false;
		} // if

		if(trim($password) == '') {
			return false;
		} // if

		$user = Users::getByUsername($username, owner_company());
		if(!($user instanceof User)) {
			return false;
		} // if

		if(!$user->isValidPassword($password)) {
			return false;
		} // if
		
		return true;
	}
	
	protected function loginUser($username, $password) {
		if ($this->checkUser($username, $password)) {
			$user = Users::getByUsername($username, owner_company());
			CompanyWebsite::instance()->logUserIn($user, false);
			return true;
		} else return false;
	}
	
	protected function logoutUser($username) {
		if (logged_user()->getUsername() == $username) {
			CompanyWebsite::instance()->logUserOut();
		}
	}
	
	protected function result_to_xml($res, $nodename) {
		if ($res['status']) $res['status'] = 'true';
		else $res['status'] = 'false';
		$this->initXml($nodename);
		if (is_array($res)) {
			foreach ($res as $k => $v) {
				XMLWriter::startElement($k);
				XMLWriter::text($v);
				XMLWriter::endElement();
			}
		}
		return $this->endXml();
	}
	
	protected function initXml($doc_name) {
		XMLWriter::openMemory();
		XMLWriter::setIndent(true);
		XMLWriter::startDocument('1.0', 'utf-8');
		XMLWriter::startElement($doc_name);
	}
	
	protected function endXml() {
		XMLWriter::endElement();
		XMLWriter::endDocument();
		return XMLWriter::outputMemory();
	}
}

?>