<?php

/**
 * MailAccountContact class
 *
 * @author Diego Castiglioni <diego20@gmail.com>
 */
class MailAccountContact extends BaseMailAccountContact {

	function getContact() {
		return Contacts::findById($this->getContactId());
	}
	
	function getAccount() {
		return MailAccounts::findById($this->getAccountId());
	}

}
?>