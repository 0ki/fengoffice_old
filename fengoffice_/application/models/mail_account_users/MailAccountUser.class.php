<?php

/**
 * MailAccountUser class
 *
 * @author Ignacio de Soto <ignacio.desoto@opengoo.org>
 */
class MailAccountUser extends BaseMailAccountUser {

	function getUser() {
		return Users::findById($this->getUserId());
	}
	
	function getAccount() {
		return MailAccounts::findById($this->getAccountId());
	}

}
?>