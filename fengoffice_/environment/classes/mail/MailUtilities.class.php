<?php
class MailUtilities {

	function getmails($accounts = null, &$err, &$succ, &$errAccounts, &$mailsReceived, $maxPerAccount = 0) {
		if (is_null($accounts)) {
			$accounts = MailAccounts::findAll();
		}

		$err = 0;
		$succ = 0;
		$errAccounts = array();
		$mailsReceived = 0;

		if (isset($accounts)) {
			foreach($accounts as $account){
				try{
					$accId = $account->getId();
					$emails = array();
					if (!$account->getIsImap()) {
						if (!$account->getIncomingSsl())
						$mailsReceived += self::getNewPOP3Mails($account, $maxPerAccount);
					} else {
						$mailsReceived += self::getNewImapMails($account, $maxPerAccount);
					}

					$succ++;
				} catch(Exception $e) {
					$errAccounts[$err]["accountName"] = $account->getEmail();
					$errAccounts[$err]["message"] = $e->getMessage();
					$err++;
				}
			}
		}
		tpl_assign('err',$err);
		tpl_assign('errAccounts',$errAccounts);
		tpl_assign('accounts',$accounts);
		tpl_assign('mailsReceived',$mailsReceived);
	}

	private function getAddresses($field) {
		$f = '';
		if ($field) {
			foreach($field as $add) {
				if (!empty($f))
				$f = $f . ', ';
				$address = trim(array_var($add, "address", ''));
				if (strpos($address, ' '))
				$address = substr($address,0,strpos($address, ' '));
				$f = $f . $address;
			}
		}
		return $f;
	}

	private function SaveMail($content, MailAccount $account, $uidl, $state = 0, $imap_folder_name = '') {
		if (strpos($content, '+OK ') > 0) $content = substr($content, strpos($content, '+OK '));
		self::parseMail($content, $decoded, $parsedMail, $warnings);

		$encoding = array_var($parsedMail,'Encoding', 'UTF-8');
		
		if (!isset($parsedMail['Subject'])) $parsedMail['Subject'] = '';
		$mail = new MailContent();
		$mail->setAccountId($account->getId());
		$mail->setState($state);
		$mail->setImapFolderName($imap_folder_name);
		$mail->setContent(iconv($encoding, 'UTF-8//IGNORE', $content));
		$mail->setFrom(self::getAddresses(array_var($parsedMail, "From")));
		
		if (array_key_exists('Encoding', $parsedMail)){
			$mail->setFromName(iconv($encoding, 'UTF-8//IGNORE', array_var(array_var(array_var($parsedMail, 'From'), 0), 'name')));
			$mail->setSubject(iconv($encoding, 'UTF-8//IGNORE', $parsedMail['Subject']));
		} else {
			$mail->setFromName(array_var(array_var(array_var($parsedMail, 'From'), 0), 'name'));
			$mail->setSubject($parsedMail['Subject']);
		}
		$mail->setTo(self::getAddresses(array_var($parsedMail, "To")));
		if (array_key_exists("Date", $parsedMail)) {
			$mail->setSentDate(new DateTimeValue(strtotime($parsedMail["Date"])));
		}
		$mail->setSize(strlen($content));
		$mail->setHasAttachments(!empty($parsedMail["Attachments"]));
		$mail->setCreatedOn(new DateTimeValue(time()));
		$mail->setCreatedById($account->getUserId());
		$mail->setAccountEmail($account->getEmail());
		
		$uid = trim($uidl);
		if ($uid[0]== '<') {
			$uid = mb_substr($uid, 1, mb_strlen($uid, $encoding) - 2, $encoding);
		}
		$mail->setUid($uid);

		switch($parsedMail['Type']) {
			case 'html': $mail->setBodyHtml(iconv($encoding, 'UTF-8//IGNORE', isset($parsedMail['Data']) ? $parsedMail['Data'] : '')); break;
			case 'text': $mail->setBodyPlain(iconv($encoding, 'UTF-8//IGNORE', isset($parsedMail['Data']) ? $parsedMail['Data'] : '')); break;
			case 'delivery-status': $mail->setBodyPlain(iconv($encoding, 'UTF-8//IGNORE', $parsedMail['Response'])); break;
		}

			
		if (isset($parsedMail['Alternative'])) {
			if ($parsedMail['Alternative'][0]['Type'] == 'html') {
				$mail->setBodyHtml(iconv(array_var($parsedMail['Alternative'][0],'Encoding','UTF-8'),'UTF-8//IGNORE', array_var($parsedMail['Alternative'][0], 'Data', '')));
			} else {
				$mail->setBodyPlain(iconv(array_var($parsedMail['Alternative'][0],'Encoding','UTF-8'),'UTF-8//IGNORE', array_var($parsedMail['Alternative'][0], 'Data', '')));
			}
		}

		try {
			DB::beginWork();
			$mail->save();
			DB::commit();
		} catch(Exception $e) {
			DB::rollback();
		}
	}

	function parseMail($message, &$decoded, &$results, &$warnings) {
		$mime = new mime_parser_class;
		$mime->mbox = 0;
		$mime->decode_bodies = 1;
		$mime->ignore_syntax_errors = 1;

		$parameters=array('Data'=>$message);

		if($mime->Decode($parameters, $decoded)) {
			for($message = 0; $message < count($decoded); $message++) {
				$mime->Analyze($decoded[$message], $results);
			}
			for($warning = 0, Reset($mime->warnings); $warning < count($mime->warnings); Next($mime->warnings), $warning++) {
				$w = Key($mime->warnings);
				$warnings[$warning] = 'Warning: '. $mime->warnings[$w]. ' at position '. $w. "\n";
			}
		}
	}

	/**
	 * Gets all new mails from a given mail account
	 *
	 * @param MailAccount $account
	 * @return array
	 */
	private function getNewPOP3Mails(MailAccount $account, $max = 0) {
		require_once "Net/POP3.php";
		$mime = new mime_parser_class();
		$pop3 = new Net_POP3();

		// Connect to mail server
		$pop3->connect($account->getServer());
		if (PEAR::isError($ret=$pop3->login($account->getEmail(), self::ENCRYPT_DECRYPT($account->getPassword()), 'USER'))) {
			throw new Exception($ret->getMessage());
		}
		$emails = $pop3->getListing();
		$oldUids = $account->getUids();

		// get the index of the last received email
		$lastReceived = count($emails) - 1;
		while ($lastReceived >= 0 && !in_array($emails[$lastReceived]['uidl'], $oldUids)) {
			$lastReceived--;
		}
		$lastReceived++;
		if ($lastReceived >= count($emails)) {
			// there's no new emails
			$newEmails = array();
		} else {
			// get the first max (or available) unread emails
			if ($max == 0) {
				$newEmails = array_slice($emails, $lastReceived, count($emails) - $lastReceived);
			} else {
				$newEmails = array_slice($emails, $lastReceived, min(array($max, count($emails) - $lastReceived)));
			}
			if (!empty($newEmails)) {
				for ($i=0; $i < count($newEmails); $i++) {
					$content = $pop3->getMsg($newEmails[$i]['msg_id']);
					self::SaveMail($content, $account, $newEmails[$i]['uidl']);
					unset($content);
				}
			}
		}
		$pop3->disconnect();

		return count($newEmails);
	}

	public function displayMultipleAddresses($addresses, $clean = true) {
		$list = explode(',', $addresses);
		$result = "";
		foreach($list as $address){
			$address = trim($address);
			$link = self::getPersonLinkFromEmailAddress($address, $clean);
			if ($result != "")
			$result .= ', ';
			$result .= $link;
		}
		return $result;
	}

	public function ENCRYPT_DECRYPT($Str_Message) {
		//Function : encrypt/decrypt a string message v.1.0  without a known key
		//Author   : Aitor Solozabal Merino (spain)
		//Email    : aitor-3@euskalnet.net
		//Date     : 01-04-2005
		$Len_Str_Message=STRLEN($Str_Message);
		$Str_Encrypted_Message="";
		FOR ($Position = 0;$Position<$Len_Str_Message;$Position++){
			// long code of the function to explain the algoritm
			//this function can be tailored by the programmer modifyng the formula
			//to calculate the key to use for every character in the string.
			$Key_To_Use = (($Len_Str_Message+$Position)+1); // (+5 or *3 or ^2)
			//after that we need a module division because can't be greater than 255
			$Key_To_Use = (255+$Key_To_Use) % 255;
			$Byte_To_Be_Encrypted = SUBSTR($Str_Message, $Position, 1);
			$Ascii_Num_Byte_To_Encrypt = ORD($Byte_To_Be_Encrypted);
			$Xored_Byte = $Ascii_Num_Byte_To_Encrypt ^ $Key_To_Use;  //xor operation
			$Encrypted_Byte = CHR($Xored_Byte);
			$Str_Encrypted_Message .= $Encrypted_Byte;

			//short code of the function once explained
			//$str_encrypted_message .= chr((ord(substr($str_message, $position, 1))) ^ ((255+(($len_str_message+$position)+1)) % 255));
		}
		RETURN $Str_Encrypted_Message;
	} //end function

	private static function getPersonLinkFromEmailAddress($email, $clean = true) {
		$name = $email;
		$url = "";

		$user = Users::getByEmail($email);
		if ($user instanceof User && $user->canSeeUser(logged_user())){
			$name = $clean ? clean($user->getDisplayName()) : $user->getDisplayName();
			$url = $user->getCardUrl();
		} else {
			$contact = Contacts::getByEmail($email);
			if ($contact instanceof Contact && $contact->canView(logged_user()))
			{
				$name = $clean ? clean($contact->getDisplayName()) : $contact->getDisplayName();
				$url = $contact->getCardUrl();
			}
		}
		if ($url != ""){
			return '<a class="internalLink" href="'.$url.'" title="'.$email.'">'.$name."</a>";
		} else {
			return $email;
		}
	}

	function sendMail($smtp_server,$to,$from,$subject,$body,$cc,$bcc,$smtp_port=25,$smtp_username = null, $smtp_password ='',$type='text/plain') {
		//Load in the files we'll need
		Env::useLibrary('swift');
		// Load SMTP config
		$transport = 0;
		$smtp_authenticate = $smtp_username != null;
		
		//Start Swift
		$mailer = new Swift(new Swift_Connection_SMTP($smtp_server, $smtp_port, $transport));		
		if(!$mailer->isConnected()) {
			return false;
		} // if
		$mailer->setCharset('UTF-8');
		//        if($cc) $mailer->addCc($cc);
		//        if($bcc) $mailer->addBcc($bcc);
		if($smtp_authenticate) {
			if(!($mailer->authenticate($smtp_username, self::ENCRYPT_DECRYPT($smtp_password)))) {
				return false;
			} // if
		}
		if(! $mailer->isConnected() )  return false;
		// Send Swift mail
		$mailer->addCc(explode(",",$cc));
		$mailer->addBcc(explode(",",$bcc));
		return $mailer->send($to, $from, $subject,$body,$type);
	}

	function parse_to($to) {
		if (!is_array($to)) return $to;
		$return = array();
		foreach ($to as $elem){
			$mail= preg_replace("/.*\<(.*)\>.*/", "$1", $elem, 1);
			$nam = explode('<', $elem);
			$return[]= array(trim($nam[0]),trim($mail));
		}
		return $return;
	}

	/****************************** IMAP ******************************/
	
	private function getNewImapMails(MailAccount $account, $max = 0) {
		$received = 0;
		// mailbox_string e.g. "{imap.gmail.com:993/imap/ssl}", box = INBOX
		$mailbox_string = "{".$account->getServer().($account->getIncomingSsl() ? ":".$account->getIncomingSslPort() : "")."/imap/".($account->getIncomingSsl() ? "ssl" : "")."}";

		$mailboxes = MailAccountImapFolders::getMailAccountImapFolders($account->getId());
		if (is_array($mailboxes)) {
			foreach ($mailboxes as $box) {
				if ($box->getCheckFolder()) {
					$mailbox = imap_open ($mailbox_string.$box->getFolderName(), $account->getEmail(), self::ENCRYPT_DECRYPT($account->getPassword()));
					$check = imap_check($mailbox);
					if ($check) {
						$oldUids = $account->getUids();
						// get the index of the last received email
						$lastReceived = $check->Nmsgs;
						while ($lastReceived > 0 && !in_array(imap_uid($mailbox, $lastReceived), $oldUids)) {
							$lastReceived--;
						}
						
						if ($max == 0) {
							$toGet = $check->Nmsgs;
						} else {
							$toGet = min($lastReceived + $max, $check->Nmsgs);
						}
						
						// get mails since last received (last received is not included)
						for ($i = $lastReceived; $i < $check->Nmsgs; $i++) {
							$index = $i+1;
							// view if it is Draft or Sent
							$header = imap_header($mailbox, $index);
							$state = '0';
							if (isset($header)) {
								if ($header->Draft == 'D') $state = '2'; //Draft
								else if (strcasecmp($header->from[0]->mailbox.'@'.$header->from[0]->host, $account->getEmail()) == 0) $state = '1'; //Sent
							}
							self::SaveImapMail($mailbox, $account, $index, $state, $box->getFolderName());
							$received++;
						}
					}
					imap_close($mailbox);
				}
			}
		}
		return $received;
	}

	private function SaveImapMail($mailbox, MailAccount $account, $index, $state = 0, $imap_folder_name = '')
	{
		$uidl = imap_uid($mailbox, $index);
		$header = imap_fetchheader($mailbox, $index, FT_INTERNAL);
		$body = imap_body($mailbox, $index);
		
		self::SaveMail($header . $body, $account, $uidl, $state, $imap_folder_name);
	}
	
	function getImapFolders(MailAccount $account) {
		$result = array();
		$mailbox_string = "{".$account->getServer().($account->getIncomingSsl() ? ":".$account->getIncomingSslPort() : "")."/imap".($account->getIncomingSsl() ? "/ssl" : "")."}";
		$mailbox = imap_open ($mailbox_string, $account->getEmail(), self::ENCRYPT_DECRYPT($account->getPassword()));
		if ($mailbox) {
			$check = imap_check($mailbox);
			
			$list = imap_list($mailbox, $mailbox_string, '*');
			if (is_array($list)) {
			    foreach ($list as $val) {
			    	$val = imap_utf7_decode($val);
			        $result[] = substr($val, strpos($val, '}') + 1);
			    }
			}
		}
		return $result;
	}
	
	function deleteMailsFromServer(MailAccount $account) {
		if ($account->getDelFromServer() > 0) {
			$max_date = DateTimeValueLib::now();
			$max_date->add('d', -1 * $account->getDelFromServer());
			if ($account->getIsImap()) {
				$mailbox_string = "{".$account->getServer().($account->getIncomingSsl() ? ":".$account->getIncomingSslPort() : "")."/imap".($account->getIncomingSsl() ? "/ssl" : "")."}";
				$mailboxes = MailAccountImapFolders::getMailAccountImapFolders($account->getId());
				if (is_array($mailboxes)) {
					foreach ($mailboxes as $box) {
						if ($box->getCheckFolder()) {
							$mailbox = imap_open ($mailbox_string.$box->getFolderName(), $account->getEmail(), self::ENCRYPT_DECRYPT($account->getPassword()));
							$check = imap_check($mailbox);
							for ($i = 1; $i < $check->Nmsgs; $i++) {
								$info = imap_header($mailbox, $i);
								if ($info) {
									if ($max_date->getTimestamp() > $info->udate) {
										imap_delete($mailbox, $i);
									} else break;
								}
							}
							imap_expunge($mailbox);
							imap_close($mailbox);
						}
					}
				}
			} else {
				require_once "Net/POP3.php";
				$pop3 = new Net_POP3();
				// Connect to mail server
				$pop3->connect($account->getServer());
				if (PEAR::isError($ret=$pop3->login($account->getEmail(), self::ENCRYPT_DECRYPT($account->getPassword()), 'USER'))) {
					throw new Exception($ret->getMessage());
				}
				$emails = $pop3->getListing();
				foreach ($emails as $email) {
					$headers = $pop3->getParsedHeaders($email['msg_id']);
					$date = DateTimeValueLib::makeFromString($headers['Date']);
					if ($max_date->getTimestamp() > $date->getTimestamp()) {
						$pop3->deleteMsg($email['msg_id']);
					}
				}
				$pop3->disconnect();
										
			}
		}
	}
}
?>