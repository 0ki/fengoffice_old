<?php
class MailUtilities
{
function getmails()
	{
		if ($_SERVER["SERVER_ADDR"] == $_SERVER["REMOTE_ADDR"]);
		$accounts = MailAccounts::findAll();
		$err = 0;
		$succ = 0;
		$errAccounts = array();
		$mailsReceived = 0;
		
		foreach($accounts as $account){
			try{
				$accId = $account->getId();
				$emails = array();
				if (!$account->getIsImap())
				{
					if (!$account->getIncomingSsl())
						$emails[$accId] = self::getNewPOP3Mails($account);
				}
				
				if (isset($emails[$accId]) && isset($emails[$accId]['downloads']))
					for ($i = 0; $i < count($emails[$accId]['downloads']); $i++)
					{
						$email = $emails[$accId];
						self::SaveMail($email['downloads'][$email['messages'][$i]],
					 					$account, $email['uidls'][$i]);
					 	$mailsReceived ++;
					}
				$succ++;
			}
			catch(Exception $e)
			{
				$errAccounts[$err]["accountName"] = $account->getEmail();
				$errAccounts[$err]["message"] = $e->getMessage();
				$err++;
			}
		}
		
		tpl_assign("mailsReceived", $mailsReceived);
		tpl_assign("succ", $succ);
		tpl_assign("err", $err);
		tpl_assign("errAccounts", $errAccounts);
	}
	
	private function getAddresses($field)
	{
		$f = '';
		foreach($field as $add)
		{
			if (!empty($f))
				$f = $f . ', ';
			$address = trim($add["address"]);
			if (strpos($address, ' '))
				$address = substr($address,0,strpos($address, ' '));
			$f = $f . $address;
		}
		return $f;
	}
	
	private function SaveMail($content, MailAccount $account, $uidl)
	{
		self::parseMail($content, $decoded, $parsedMail, $warnings);
		
		$mail = new MailContent();
		$mail->setAccountId($account->getId());
		$mail->setContent($content);
		$mail->setFrom(self::getAddresses($parsedMail["From"]));
		$mail->setTo(self::getAddresses($parsedMail["To"]));
		$mail->setSubject($parsedMail["Subject"]);
		$mail->setSentDate(new DateTimeValue(strtotime($parsedMail["Date"])));
		$mail->setSize(strlen($content));
		$mail->setHasAttachments(!empty($parsedMail["Attachments"]));
		
		$uid = trim($uidl);
		if ($uid[0]== '<')
			$uid = substr($uid,1,strlen($uid)-2);
		$mail->setUid($uid);
		
		switch($parsedMail['Type'])
		{
			case 'html': $mail->setBodyHtml($parsedMail['Data']); break;
			case 'text': $mail->setBodyPlain($parsedMail['Data']); break;
			case 'delivery-status': $mail->setBodyPlain($parsedMail['Response']); break;
		}
			
		if ($parsedMail['Alternative'])
		{
			if ($parsedMail['Alternative'][0]['Type'] == 'html')
				$mail->setBodyHtml($parsedMail['Alternative'][0]['Data']);
			else
				$mail->setBodyPlain($parsedMail['Alternative'][0]['Data']);
		}
		
		try
		{
			DB::beginWork();
			$mail->save();
			DB::commit();
		}
		catch(Exception $e)
		{
			DB::rollback();
		}
	}

	private function parseMail($message, &$decoded, &$results, &$warnings)
	{
		$mime = new mime_parser_class;
		$mime->mbox = 0;
		$mime->decode_bodies = 1;
		$mime->ignore_syntax_errors = 1;

		$parameters=array('Data'=>$message);

		if($mime->Decode($parameters, $decoded))
		{
			for($message = 0; $message < count($decoded); $message++)
			{
				$mime->Analyze($decoded[$message], $results);
			}
			for($warning = 0, Reset($mime->warnings); $warning < count($mime->warnings); Next($mime->warnings), $warning++)
			{
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
	private function getNewPOP3Mails(MailAccount $account)
	{
		$mime = new mime_parser_class;
		$pop3 = new POP3;

		// Connect to mail server
		$pop3->connect ($account->getServer());
		$pop3->login ($account->getEmail(), $account->getPassword());
		$pop3->getOfficeStatus();
		
		$messagesToGet = self::getPOP3MessageList($pop3, $account);
		if(!empty($messagesToGet["messages"]))
			$messagesToGet['downloads'] = $pop3->getMails($messagesToGet["messages"]);

		$pop3->quit();
		return $messagesToGet;
	}
	
	/**
	 * Gets all messages which havent been downloaded from the server
	 *
	 * @param POP3 $pop3
	 * @param MailAccount $account
	 */
	private function getPOP3MessageList(POP3 &$pop3, MailAccount $account)
	{
		$uidList = $pop3->getUidl();
		$serverUidList = $account->getUidls();
		$uidArr = explode("\r\n",$uidList);
		$result = array("messages", "uidls", "downloads");
		$c =0;
		for ($i =0; $i < count($uidArr)-2; $i++)
		{
			$found = false;
			$uidArr[$i] = explode(" ", $uidArr[$i]);
			for($j=0; $j<count($serverUidList); $j++)
			{
				if ($uidArr[$i][1] == $serverUidList[$j]['uid'])
				{
					$found = true;
					continue;
				}
			}
			if(!$found)
			{
				$result["messages"][$c] = (int)$uidArr[$i][0];
				$result["uidls"][$c] = $uidArr[$i][1];
				$c++;
			}
		}
		return $result;
	}
	
	public function displayMultipleAddresses($addresses)
	{
		$list = explode(',', $addresses);
		$result = "";
		foreach($list as $address){
			$address = trim($address);
			$link = self::getPersonLinkFromEmailAddress($address);
			if ($result != "")
				$result .= ', ';
			$result .= $link;
		}
		return $result;
	}
	
	private static function getPersonLinkFromEmailAddress($email)
	{
		$name = $email;
		$url = "";
		
		$user = Users::getByEmail($email);
		if ($user instanceof User && $user->canSeeUser(logged_user())){
			$name = $user->getDisplayName();
			$url = $user->getCardUrl();
		} else {
			$contact = Contacts::getByEmail($email);
			if ($contact instanceof Contact && $contact->canView(logged_user()))
			{
				$name = $contact->getDisplayName();
				$url = $contact->getCardUrl();
			}
		}
		if ($url != ""){
			return '<a class="internalLink" href="'.$url.'" title="'.$email.'">'.$name."</a>";
		} else { 
			return $email;
		}
	}
}
?>