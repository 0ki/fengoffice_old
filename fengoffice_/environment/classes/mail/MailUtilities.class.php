<?php
require_once 'Net/IMAP.php';
require_once "Net/POP3.php";

class MailUtilities {

	function getmails($accounts = null, &$err, &$succ, &$errAccounts, &$mailsReceived, $maxPerAccount = 0) {
		Env::useHelper('permissions');
		if (is_null($accounts)) {
			$accounts = MailAccounts::findAll();
		}
		if (config_option('max_email_fetch') && ($maxPerAccount == 0 || config_option('max_email_fetch') < $maxPerAccount)) {
			$maxPerAccount = config_option('max_email_fetch');
		}

		$old_memory_limit = ini_get('memory_limit');
		if (php_config_value_to_bytes($old_memory_limit) < 96*1024*1024) {
			ini_set('memory_limit', '96M');
		}

		$err = 0;
		$succ = 0;
		$errAccounts = array();
		$mailsReceived = 0;

		if (isset($accounts)) {
			foreach($accounts as $account) {
				if (!$account->getServer()) continue;
				try {
					$lastChecked = $account->getLastChecked();
					$minutes = 5;
					if ($lastChecked instanceof DateTimeValue && $lastChecked->getTimestamp() + $minutes*60 >= DateTimeValueLib::now()->getTimestamp()) {
						$succ++;
						continue;
					} else {
						$account->setLastChecked(DateTimeValueLib::now());
						$account->save();
					}
					$accId = $account->getId();
					$emails = array();
					if (!$account->getIsImap()) {
						$mailsReceived += self::getNewPOP3Mails($account, $maxPerAccount);
					} else {
						$mailsReceived += self::getNewImapMails($account, $maxPerAccount);
					}
					$account->setLastChecked(EMPTY_DATETIME);
					$account->save();

					$succ++;
				} catch(Exception $e) {
					$account->setLastChecked(EMPTY_DATETIME);
					$account->save();
					$errAccounts[$err]["accountName"] = $account->getEmail();
					$errAccounts[$err]["message"] = $e->getMessage();
					$err++;
				}
			}
		}

		ini_set('memory_limit', $old_memory_limit);

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

	private function SaveContentToFilesystem($uid, &$content) {
		$tmp = ROOT . '/tmp/' . rand();
		$handle = fopen($tmp, "wb");
		fputs($handle, $content);
		fclose($handle);
		$date = DateTimeValueLib::now()->format("Y_m_d_H_i_s__");
		$repository_id = FileRepository::addFile($tmp, array('name' => $date.$uid, 'type' => 'text/plain', 'size' => strlen($content)));

		unlink($tmp);

		return $repository_id;
	}
	
	private function getFromAddressFromContent($content) {
		$address = array(array('name' => '', 'address' => ''));
		if (strpos($content, 'From') !== false) {
			$ini = strpos($content, 'From');
			if ($ini !== false) {
				$str = substr($content, $ini, strpos($content, ">", $ini) - $ini);
				$ini = strpos($str, ":") + 1;
				$address[0]['name'] = trim(substr($str, $ini, strpos($str, "<") - $ini));
				$address[0]['address'] = trim(substr($str, strpos($str, "<") + 1));
			}
		}
		return $address;
	}
	
	private function getHeaderValueFromContent($content, $headerName) {
		if (stripos($content, $headerName) !== FALSE && stripos($content, $headerName) == 0) {
			$ini = 0;
		} else {
			$ini = stripos($content, "\n$headerName");
			if ($ini === FALSE) return "";
		}
				
		$ini = stripos($content, ":", $ini);
		if ($ini === FALSE) return "";
		$ini++;
		$end = stripos($content, "\n", $ini);
		$res = trim(substr($content, $ini, $end - $ini));
		
		return $res;
	}
	
	private function SaveMail(&$content, MailAccount $account, $uidl, $state = 0, $imap_folder_name = '') {
		if (strpos($content, '+OK ') > 0) $content = substr($content, strpos($content, '+OK '));
		self::parseMail($content, $decoded, $parsedMail, $warnings);
		$encoding = array_var($parsedMail,'Encoding', 'UTF-8');
		$enc_conv = EncodingConverter::instance();
		$to_addresses = self::getAddresses(array_var($parsedMail, "To"));
		$from = self::getAddresses(array_var($parsedMail, "From"));
		
		$message_id = self::getHeaderValueFromContent($content, "Message-ID");
		$in_reply_to_id = self::getHeaderValueFromContent($content, "In-Reply-To");
		
		$uid = trim($uidl);
		if (str_starts_with($uid, '<') && str_ends_with($uid, '>')) {
			$uid = utf8_substr($uid, 1, utf8_strlen($uid, $encoding) - 2, $encoding);
		}
		if ($uid == '') {
			$uid = trim($message_id);
			if ($uid == '') {
				$uid = array_var($parsedMail, 'Subject', 'MISSING UID');
			}
			if (str_starts_with($uid, '<') && str_ends_with($uid, '>')) {
				$uid = utf8_substr($uid, 1, utf8_strlen($uid, $encoding) - 2, $encoding);
			}
			if (MailContents::mailRecordExists($account->getId(), $uid, $imap_folder_name == '' ? null : $imap_folder_name)) {
				return;
			}
		}
		
		if (!$from) {
			$parsedMail["From"] = self::getFromAddressFromContent($content);
			$from = array_var($parsedMail["From"][0], 'address', '');
		}
		
		if ($state == 0) {
			if ($from == $account->getEmailAddress()) {
				if (strpos($to_addresses, $from) !== FALSE) $state = 5; //Show in inbox and sent folders
				else $state = 1; //Show only in sent folder
			}
		}
		
		$from_spam_junk_folder = strpos(strtolower($imap_folder_name), 'spam') !== FALSE 
			|| strpos(strtolower($imap_folder_name), 'junk')  !== FALSE || strpos(strtolower($imap_folder_name), 'trash') !== FALSE;
		$user_id = logged_user() instanceof User ? logged_user()->getId() : $account->getUserId();
		$max_spam_level = user_config_option('max_spam_level', null, $user_id);
		if ($max_spam_level < 0) $max_spam_level = 0;
		$mail_spam_level = strlen(trim( array_var($decoded[0]['Headers'], 'x-spam-level:', '') ));
		// if max_spam_level >= 10 then nothing goes to junk folder
		if ($max_spam_level < 10 && ($mail_spam_level > $max_spam_level || $from_spam_junk_folder)) {
			$state = 4; // send to Junk folder
		}

		if (!isset($parsedMail['Subject'])) $parsedMail['Subject'] = '';
		$mail = new MailContent();
		$mail->setAccountId($account->getId());
		$mail->setState($state);
		$mail->setImapFolderName($imap_folder_name);
		$mail->setFrom($from);
		$mail->setCc(self::getAddresses(array_var($parsedMail, "Cc")));
		
		$from_name = trim(array_var(array_var(array_var($parsedMail, 'From'), 0), 'name'));
		if ($from_name == '') $from_name = $from;
		if (array_key_exists('Encoding', $parsedMail)){
			$utf8_from = $enc_conv->convert($encoding, 'UTF-8', $from_name);
			if ($enc_conv->hasError()) {
				$utf8_from = utf8_encode($from_name);
			}
			$utf8_from = utf8_safe($utf8_from);
			$mail->setFromName($utf8_from);
			
			$utf8_subject = $enc_conv->convert($encoding, 'UTF-8', $parsedMail['Subject']);
			if ($enc_conv->hasError()) {
				$utf8_subject = utf8_encode($parsedMail['Subject']);
			}
			$utf8_subject = utf8_safe($utf8_subject);
			$mail->setSubject($utf8_subject);
		} else {
			$mail->setFromName($from_name);
			$utf8_subject = utf8_safe($parsedMail['Subject']);
			$mail->setSubject($utf8_subject);
		}
		$mail->setTo($to_addresses);
		$sent_timestamp = false;
		if (array_key_exists("Date", $parsedMail)) {
			$sent_timestamp = strtotime($parsedMail["Date"]);
		}
		if ($sent_timestamp === false || $sent_timestamp === -1 || $sent_timestamp === 0) {
			$mail->setSentDate(DateTimeValueLib::now());
		} else {
			$mail->setSentDate(new DateTimeValue($sent_timestamp));
		}
		
		// if this constant is defined, mails older than this date will not be fetched 
		if (defined('FIRST_MAIL_DATE')) {
			$first_mail_date = DateTimeValueLib::makeFromString(FIRST_MAIL_DATE);
			if ($mail->getSentDate()->getTimestamp() < $first_mail_date->getTimestamp()) {
				// return true to stop getting older mails from the server
				return true;
			}
		}
		
		$received_timestamp = false;
		if (array_key_exists("Received", $parsedMail) && $parsedMail["Received"]) {
			$received_timestamp = strtotime($parsedMail["Received"]);
		}
		if ($received_timestamp === false || $received_timestamp === -1 || $received_timestamp === 0) {
			$mail->setReceivedDate($mail->getSentDate());
		} else {
			$mail->setReceivedDate(new DateTimeValue($received_timestamp));
		}
		$mail->setSize(strlen($content));
		$mail->setHasAttachments(!empty($parsedMail["Attachments"]));
		$mail->setCreatedOn(new DateTimeValue(time()));
		$mail->setCreatedById($account->getUserId());
		$mail->setAccountEmail($account->getEmail());
		
		$mail->setMessageId($message_id);
		$mail->setInReplyToId($in_reply_to_id);

		$mail->setUid($uid);
		$type = array_var($parsedMail, 'Type', 'text');
		
		switch($type) {
			case 'html':
				$utf8_body = $enc_conv->convert($encoding, 'UTF-8', array_var($parsedMail, 'Data', ''));
				if ($enc_conv->hasError()) $utf8_body = utf8_encode(array_var($parsedMail, 'Data', ''));
				$utf8_body = utf8_safe($utf8_body);
				$mail->setBodyHtml($utf8_body);
				break;
			case 'text': 
				$utf8_body = $enc_conv->convert($encoding, 'UTF-8', array_var($parsedMail, 'Data', ''));
				if ($enc_conv->hasError()) $utf8_body = utf8_encode(array_var($parsedMail, 'Data', ''));
				$utf8_body = utf8_safe($utf8_body);
				$mail->setBodyPlain($utf8_body);
				break;
			case 'delivery-status': 
				$utf8_body = $enc_conv->convert($encoding, 'UTF-8', array_var($parsedMail, 'Response', ''));
				if ($enc_conv->hasError()) $utf8_body = utf8_encode(array_var($parsedMail, 'Response', ''));
				$utf8_body = utf8_safe($utf8_body);
				$mail->setBodyPlain($utf8_body);
				break;
			default: break;
		}
			
		if (isset($parsedMail['Alternative'])) {
			foreach ($parsedMail['Alternative'] as $alt) {
				if ($alt['Type'] == 'html' || $alt['Type'] == 'text') {
					$body = $enc_conv->convert(array_var($alt,'Encoding','UTF-8'),'UTF-8', array_var($alt, 'Data', ''));
					if ($enc_conv->hasError()) $body = utf8_encode(array_var($alt, 'Data', ''));
					
					// remove large white spaces
					$exploded = preg_split("/[\s]+/", $body, -1, PREG_SPLIT_NO_EMPTY);
					$body = implode(" ", $exploded);
					// remove html comments
					$body = preg_replace('/<!--.*-->/i', '', $body);
				}
				$body = utf8_safe($body);
				if ($alt['Type'] == 'html') {
					$mail->setBodyHtml($body);
				} else if ($alt['Type'] == 'text') {
					$mail->setBodyPlain($body);
				}
				// other alternative parts (like images) are not saved in database.
			}
		}

		$repository_id = self::SaveContentToFilesystem($mail->getUid(), $content);
		$mail->setContentFileId($repository_id);
		
		
		try {
			if ($in_reply_to_id != "") {
				if ($message_id != "") {
					$conv_mail = MailContents::findOne(array("conditions" => "`in_reply_to_id` = '$message_id'"));
					if (!$conv_mail) {
						$conv_mail = MailContents::findOne(array("conditions" => "`message_id` = '$in_reply_to_id'"));
					}
				} else {
					$conv_mail = MailContents::findOne(array("conditions" => "`message_id` = '$in_reply_to_id'"));
				}
				
				if ($conv_mail instanceof MailContent && strpos(strtolower($mail->getSubject()), strtolower($conv_mail->getSubject())) !== false) {
					$mail->setConversationId($conv_mail->getConversationId());
				} else {
					$conv_id = MailContents::getNextConversationId($account->getId());
					$mail->setConversationId($conv_id);
				}
			} else {
				$conv_id = MailContents::getNextConversationId($account->getId());
				$mail->setConversationId($conv_id);
			}
			
			$mail->save();

			// CLASSIFY MAILS IF THE ACCOUNT HAS A WORKSPACE
			if ($account->getColumnValue('workspace',0) != 0) {
				$workspace = Projects::findById($account->getColumnValue('workspace',0));
				if ($workspace && $workspace instanceof Project && !$mail->hasWorkspace($workspace)) {
					$mail->addToWorkspace($workspace);
			 	}
			}
			//END CLASSIFY
		
			$user = Users::findById($account->getUserId());
			if ($user instanceof User) {
				$mail->subscribeUser($user);
			}
		} catch(Exception $e) {
			FileRepository::deleteFile($repository_id);
			if (strpos($e->getMessage(), "Query failed with message 'Got a packet bigger than 'max_allowed_packet' bytes'") === false) {
				Logger::log($e->getMessage());
			}
		}
		unset($parsedMail);
		return false;
	}
	
	function parseMail(&$message, &$decoded, &$results, &$warnings) {
		$mime = new mime_parser_class;
		$mime->mbox = 0;
		$mime->decode_bodies = 1;
		$mime->ignore_syntax_errors = 1;

		$parameters=array('Data'=>$message);

		if($mime->Decode($parameters, $decoded)) {
			for($msg = 0; $msg < count($decoded); $msg++) {
				$mime->Analyze($decoded[$msg], $results);
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
		$pop3 = new Net_POP3();

		$received = 0;
		// Connect to mail server
		if ($account->getIncomingSsl()) {
			$pop3->connect("ssl://" . $account->getServer(), $account->getIncomingSslPort());
		} else {
			$pop3->connect($account->getServer());
		}
		if (PEAR::isError($ret=$pop3->login($account->getEmail(), self::ENCRYPT_DECRYPT($account->getPassword()), 'USER'))) {
			throw new Exception($ret->getMessage());
		}
		
		$mailsToGet = array();
		$summary = $pop3->getListing();

		$uids = MailContents::getUidsFromAccount($account->getId());
		foreach ($summary as $k => $info) {
			if (!in_array($info['uidl'], $uids)) {
				$mailsToGet[] = $k;
			}
		}
		
		if ($max == 0) $toGet = count($mailsToGet);
		else $toGet = min(count($mailsToGet), $max);

		// fetch newer mails first
		$mailsToGet = array_reverse($mailsToGet, true);
		foreach ($mailsToGet as $idx) {
			if ($toGet <= $received) break;
			$content = $pop3->getMsg($idx+1); // message index is 1..N
			if ($content != '') {
				$uid = $summary[$idx]['uidl'];
				$stop_checking = self::SaveMail($content, $account, $uid);
				if ($stop_checking) break;
				unset($content);
				$received++;
			}
		}
		$pop3->disconnect();

		return $received;
	}

	public function displayMultipleAddresses($addresses, $clean = true, $add_contact_link = true) {
		$addresses = self::parse_to(html_entity_decode($addresses));
		$list = self::parse_to(explode(',', $addresses));
		$result = "";
		
		foreach($list as $addr){
			if (count($addr) > 0) {
				$name = "";
				if (count($addr) > 1) {
					$address = trim($addr[1]);
					$name = $address != trim($addr[0]) ? trim($addr[0]) : "";
				} else {
					$address = trim($addr[0]);
				}
				$link = self::getPersonLinkFromEmailAddress($address, $name, $clean, $add_contact_link);
				if ($result != "")
				$result .= ', ';
				$result .= $link;
			}
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

	private static function getPersonLinkFromEmailAddress($email, $addr_name, $clean = true, $add_contact_link = true) {
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
			return '<a class="internalLink" href="'.$url.'" title="'.$email.'">'.$name." &lt;$email&gt;</a>";
		} else {
			if(!(active_project() instanceof Project ? Contact::canAdd(logged_user(),active_project()) : can_manage_contacts(logged_user()))) {
				return $email;
			} else {
				$url = get_url('contact', 'add', array('ce' => $email));
				$to_show = $addr_name == '' ? $email : $addr_name." &lt;$email&gt;";
				return $to_show . ($add_contact_link ? '&nbsp;<a class="internalLink link-ico ico-add" style="padding-left:12px;" href="'.$url.'" title="'.lang('add contact').'">&nbsp;</a>' : '');
			}
		}
	}


	function sendMail($smtp_server, $to, $from, $subject, $body, $cc, $bcc, $attachments=null, $smtp_port=25, $smtp_username = null, $smtp_password ='', $type='text/plain', $transport=0, $message_id=null, $in_reply_to=null, $inline_images = null, &$complete_mail) {
		//Load in the files we'll need
		Env::useLibrary('swift');
		// Load SMTP config
		$smtp_authenticate = $smtp_username != null;
		switch ($transport) {
			case 'ssl': $transport = SWIFT_SSL; break;
			case 'tls': $transport = SWIFT_TLS; break;
			default: $transport = 0; break;
		}

		//Start Swift
		$mailer = new Swift(new Swift_Connection_SMTP($smtp_server, $smtp_port, $transport));
		$mailer->loadPlugin(new SwiftLogger());
		if(!$mailer->isConnected()) {
			Logger::log($mailer->lastError);
			throw new Exception($mailer->lastError);
		} // if
		$mailer->setCharset('UTF-8');
		if($smtp_authenticate) {
			if(!($mailer->authenticate($smtp_username, self::ENCRYPT_DECRYPT($smtp_password)))) {
				Logger::log($mailer->lastError);
				throw new Exception($mailer->lastError);
			} // if
		}
		if(! $mailer->isConnected() )  {
			Logger::log($mailer->lastError);
			throw new Exception($mailer->lastError);
		}
		// Send Swift mail
		foreach ($to as $k => $v) {
			if (is_array($v)) {
				if (isset($v[1]) && trim($v[1]) == '') unset($to[$k]);
			} 
			else if (trim($v) == '') unset($to[$k]);
		}
		
		$ccArr = preg_split('/;|,/', $cc);
		foreach ($ccArr as $k => $v) {
			if (trim($v) == '') unset($ccArr[$k]);
		}
		if(count($ccArr)>0) $mailer->addCc($ccArr);
		
		$bccArr = preg_split('/;|,/', $bcc);
		foreach ($bccArr as $k => $v) {
			if (trim($v) == '') unset($bccArr[$k]);
		}
		if(count($bccArr)>0) $mailer->addBcc($bccArr);
		
		if ($message_id) $mailer->setMessageId($message_id);
		if ($in_reply_to) $mailer->setInReplyToId($in_reply_to);
		
		// add inline images
 		if (is_array($inline_images)) {
 			foreach ($inline_images as $image_url => $image_path) {
 				$cid = $mailer->addImage($image_path);
 				$body = str_replace($image_url, $cid, $body);
 			}
 		}

 		self::adjustBody($mailer, $type, $body);
 		$mailer->addPart($body, $type); // real body
 		$body = false; // multipart
 		
		// add attachments
 		if (is_array($attachments)) {
         	foreach ($attachments as $att) {
         		if (substr($att['name'], -4) == '.eml') {
 					$mailer->addAttachment($att["data"], $att["name"], $att["type"], '7bit', 'attachment');
         		} else {
         			$mailer->addAttachment($att["data"], $att["name"], $att["type"]);
         		}
 			}
 		}
 		$mailer->useExactCopy();
 		$ok = $mailer->send($to, $from, $subject, $body, $type, false, $complete_mail);
 		$mailer->close();
 		
 		if (!$ok) throw new Exception($mailer->lastError);
		
		return $ok;
	}
	
	private function adjustBody($mailer, $type, &$body) {
		// add <html> tag
		if ($type == 'text/html' && stripos($body, '<html>') === FALSE) {
			$pre = '<html>';
			$post = '</html>';
			if (stripos($body, '<body>') === FALSE) {
				$pre .= '<body>';
				$post = '</body>' . $post;
			}
			$body = $pre . $body . $post;
		}
		
		// add text/plain alternative part
		if ($type == 'text/html') {
			$onlytext = html_to_text($body);
 			$mailer->addPart($onlytext, 'text/plain');
 		}
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

		if ($account->getIncomingSsl()) {
			$imap = new Net_IMAP($ret, "ssl://" . $account->getServer(), $account->getIncomingSslPort());
		} else {
			$imap = new Net_IMAP($ret, "tcp://" . $account->getServer());
		}
		if (PEAR::isError($ret)) {
			//Logger::log($ret->getMessage());
			throw new Exception($ret->getMessage());
		}
		$ret = $imap->login($account->getEmail(), self::ENCRYPT_DECRYPT($account->getPassword()));
		$mailboxes = MailAccountImapFolders::getMailAccountImapFolders($account->getId());
		if (is_array($mailboxes)) {
			foreach ($mailboxes as $box) {
				if ($max > 0 && $received >= $max) break;
				if ($box->getCheckFolder()) {
					if ($imap->selectMailbox(utf8_decode($box->getFolderName()))) {
						$oldUids = $account->getUids($box->getFolderName());
						$numMessages = $imap->getNumberOfMessages(utf8_decode($box->getFolderName()));
						if (!is_array($oldUids) || count($oldUids) == 0 || PEAR::isError($numMessages) || $numMessages == 0) {
							$lastReceived = 0;
							if (PEAR::isError($numMessages)) {
								//Logger::log($numMessages->getMessage());
								continue;
							}
						} else {
							$lastReceived = 0;
							$maxUID = $account->getMaxUID($box->getFolderName());
							$imin = 1;
							$imax = $numMessages;
							$i = floor(($imax + $imin) / 2);
							while (true) {
								$summary = $imap->getSummary($i);
								if (PEAR::isError($summary)) {
									$i--;
									if ($i == 0) break;
									continue;
								}
								$iprev = $i;
								$uid = $summary[0]['UID'];
								if ($maxUID > $uid) {
									$imin = $i;
									$lastReceived = $imin;
								} else if ($maxUID < $uid) {
									$imax = $i;
								} else {
									$lastReceived = $i;
									break;
								}
								$i = floor(($imax + $imin) / 2);
								if ($i == $iprev) {
									break;
								} 
							}
						}
						
						$uids = MailContents::getUidsFromAccount($account->getId(), $box->getFolderName());

						// get mails since last received (last received is not included)
						for ($i = $lastReceived; ($max == 0 || $received < $max) && $i < $numMessages; $i++) {
							$index = $i+1;
							$summary = $imap->getSummary($index);
							if (PEAR::isError($summary)) {
								Logger::log($summary->getMessage());
							} else {
								if (!in_array($summary[0]['UID'], $uids)) {
									if ($imap->isDraft($index)) $state = 2;
									else $state = 0;
									
									$messages = $imap->getMessages($index);
									if (PEAR::isError($messages)) {
										continue;
									}
									$content = array_var($messages, $index, '');
									if ($content != '') {
										$stop_checking = self::SaveMail($content, $account, $summary[0]['UID'], $state, $box->getFolderName());
										if ($stop_checking) break;
										$received++;
									} // if content
								}
							}
						}
					}
				}
			}
		}
		$imap->disconnect();
		return $received;
	}

	function getImapFolders(MailAccount $account) {
		if ($account->getIncomingSsl()) {
			$imap = new Net_IMAP($ret, "ssl://" . $account->getServer(), $account->getIncomingSslPort());
		} else {
			$imap = new Net_IMAP($ret, "tcp://" . $account->getServer());
		}
		if (PEAR::isError($ret)) {
			//Logger::log($ret->getMessage());
			throw new Exception($ret->getMessage());
		}
		$ret = $imap->login($account->getEmail(), self::ENCRYPT_DECRYPT($account->getPassword()));
		if ($ret !== true || PEAR::isError($ret)) {
			//Logger::log($ret->getMessage());
			throw new Exception($ret->getMessage());
		}
		$result = array();
		if ($ret === true) {
			$mailboxes = $imap->getMailboxes('',0,true);
			if (is_array($mailboxes)) {
				foreach ($mailboxes as $mbox) {
					$select = true;
					$attributes = array_var($mbox, 'ATTRIBUTES');
					if (is_array($attributes)) {
						foreach($attributes as $att) {
							if (strtolower($att) == "\\noselect") $select = false;
							if (!$select) break;
						}
					}
					$name = array_var($mbox, 'MAILBOX');
					if ($select && isset($name)) $result[] = utf8_encode($name);
				}
			}
		}
		$imap->disconnect();
		return $result;
	}

	function deleteMailsFromServerAllAccounts() {
		$accounts = MailAccounts::findAll();
		$count = 0;
		foreach ($accounts as $account) {
			try {
				$count += self::deleteMailsFromServer($account);
			} catch (Exception $e) {
				Logger::log($e->getMessage());
			}
		}
		return $count;
	}
	
	function deleteMailsFromServer(MailAccount $account) {
		$count = 0;
		if ($account->getDelFromServer() > 0) {
			$max_date = DateTimeValueLib::now();
			$max_date->add('d', -1 * $account->getDelFromServer());
			if ($account->getIsImap()) {
				if ($account->getIncomingSsl()) {
					$imap = new Net_IMAP($ret, "ssl://" . $account->getServer(), $account->getIncomingSslPort());
				} else {
					$imap = new Net_IMAP($ret, "tcp://" . $account->getServer());
				}
				if (PEAR::isError($ret)) {
					Logger::log($ret->getMessage());
					throw new Exception($ret->getMessage());
				}
				$ret = $imap->login($account->getEmail(), self::ENCRYPT_DECRYPT($account->getPassword()));

				$result = array();
				if ($ret === true) {
					$mailboxes = MailAccountImapFolders::getMailAccountImapFolders($account->getId());
					if (is_array($mailboxes)) {
						foreach ($mailboxes as $box) {
							if ($box->getCheckFolder()) {
								$numMessages = $imap->getNumberOfMessages(utf8_decode($box->getFolderName()));
								for ($i = 1; $i <= $numMessages; $i++) {
									$summary = $imap->getSummary($i);
									if (is_array($summary)) {
										$m_date = DateTimeValueLib::makeFromString($summary[0]['INTERNALDATE']);
										if ($m_date instanceof DateTimeValue && $max_date->getTimestamp() > $m_date->getTimestamp()) {
											if (MailContents::mailRecordExists($account->getId(), $summary[0]['UID'], $box->getFolderName(), true)) {
												$imap->deleteMessages($i);
												$count++;
											}
										} else {
											break;
										}
									} 
								}
								$imap->expunge();
							}
						}
					}
				}

			} else {
				//require_once "Net/POP3.php";
				$pop3 = new Net_POP3();
				// Connect to mail server
				$pop3->connect($account->getServer());
				if (PEAR::isError($ret=$pop3->login($account->getEmail(), self::ENCRYPT_DECRYPT($account->getPassword()), 'USER'))) {
					throw new Exception($ret->getMessage());
				}
				$emails = $pop3->getListing();
				foreach ($emails as $email) {
					if (MailContents::mailRecordExists($account->getId(), $email['uidl'], null, true)) {
						$headers = $pop3->getParsedHeaders($email['msg_id']);
						$date = DateTimeValueLib::makeFromString($headers['Date']);
						if ($date instanceof DateTimeValue && $max_date->getTimestamp() > $date->getTimestamp()) {
							$pop3->deleteMsg($email['msg_id']);
							$count++;
						}
					}
				}
				$pop3->disconnect();

			}
		}
		return $count;
	}

	function getContent($smtp_server, $smtp_port, $transport, $smtp_username, $smtp_password, $body, $attachments)
	{
		//Load in the files we'll need
		Env::useLibrary('swift');

		switch ($transport) {
			case 'ssl': $transport = SWIFT_SSL; break;
			case 'tls': $transport = SWIFT_TLS; break;
			default: $transport = 0; break;
		}

		//Start Swift
		$mailer = new Swift(new Swift_Connection_SMTP($smtp_server, $smtp_port, $transport));

		if(!$mailer->isConnected()) {
			return false;
		} // if
		$mailer->setCharset('UTF-8');

		if($smtp_username != null) {
			if(!($mailer->authenticate($smtp_username, self::ENCRYPT_DECRYPT($smtp_password)))) {
				return false;
			}
		}
		if(! $mailer->isConnected() )  return false;

		// add attachments
		$mailer->addPart($body); // real body
		if (is_array($attachments) && count($attachments) > 0) {
			foreach ($attachments as $att)
			$mailer->addAttachment($att["data"], $att["name"], $att["type"]);
		}

		$content = $mailer->getFullContent(false);
		$mailer->close();
		return $content;
	}

	public function saveContent($content)
	{
		return $this->saveContentToFilesystem("UID".rand(), $content);
	}
	
	public function replaceQuotedText($text, $replacement = "") {
		$lines = explode("\n", $text);
		$text = "";
		$quoted = false;
		foreach ($lines as $line) {
			if (!str_starts_with($line, ">")) {
				if ($quoted) $text .= $replacement . "\n";
				$quoted = false;
				$text .= $line . "\n";
			} else {
				$quoted = true;
			}
		}
		return $text;
	}
	
	public function hasQuotedText($text) {
		return strpos($text, "\n>") === false ? false : true;
	}
	
	public function replaceQuotedBlocks($html, $replacement = "") {
		$start = stripos($html, "<blockquote");
		while ($start !== false) {
			$end = stripos($html, "</blockquote>", $start);
			$next = stripos($html, "<blockquote", $start + 1);
			while ($next !== false & $end !== false && $next < $end) {
				$end = stripos($html, "</blockquote>", $end + 1);
				$next = stripos($html, "<blockquote", $next + 1);
			}
			if ($end === false) $end = strlen($html);
			else $end += strlen("</blockquote>");
			$html = substr($html, 0, $start) . $replacement . substr($html, $end);
			$start = stripos($html, "<blockquote");
		}
		return $html;
	}
	
	public function hasQuotedBlocks($html) {
		return stripos($html, "<blockquote") !== false;
	}
	
	static function generateMessageId($email_address = null) {
		$id_right = null;
		if ($email_address) {
			// get a valid right-part id from the email address (domain name)
			$id_right = substr($email_address, strpos($email_address, '@'));
			if (strpos($id_right, ">") !== false) {
				$id_right = substr($id_right, 0, strpos($id_right, ">"));
			}
			$id_right = preg_replace('/[^a-zA-Z0-9\.\!\#\/\$\%\&\'\*\+\-\=\?\^\_\`\{\|\}\~]/', '', $id_right);
		}
		if (!$id_right) $id_right = gen_id();
	 	return "<" . gen_id() . "@" . $id_right . ">";
 	}
	
}
?>