<?php

  /**
  * MailAccounts
  *
  * @author Carlos Palma <chonwil@gmail.com>
  */
  class MailAccounts extends BaseMailAccounts {
  	
	/**
    * Return Mail accounts by user
    *
    * @param user
    * @return array
    */
  	function getMailAccountsByUser(Contact $user)
  	{
  		$accounts = array();
  		$accountUsers = MailAccountContacts::getByContact($user);
  		foreach ($accountUsers as $au) {
  			$account = $au->getAccount();
  			if ($account instanceof MailAccount) {
  				$accounts[] = $account;
  			}
  		}
  		return $accounts;
  	}
  } // MailAccounts 

?>