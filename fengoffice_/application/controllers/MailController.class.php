<?php
/**
 * Mail controller
 *
 * @version 1.0
 * @author Carlos Palma <chonwil@gmail.com>
 */
class MailController extends ApplicationController {

	/**
	 * Construct the MailController
	 *
	 * @access public
	 * @param void
	 * @return MailController
	 */
	function __construct() {
		parent::__construct();
		prepare_company_website_controller($this, 'website');
	} // __construct

	function init() {
		require_javascript('og/EmailAccountMenu.js');
		require_javascript("og/MailManager.js");
		ajx_current("panel", "mails-containerpanel", null, null, true);
		ajx_replace(true);
	}
	
	private function getDefaultAccountId($user = null) {
		if (!$user) $user = logged_user();
		$accounts = MailAccounts::findAll(array('conditions' => '`user_id` = ' . $user->getId()));
		foreach($accounts as $acc) {
			if ($acc->getIsDefault()) return $acc->getId();
		}
		return 0;
	}
	
	private function build_original_mail_info($original_mail) {
		$loc = new Localization();
		$loc->setDateTimeFormat("D, d M Y H:i:s O");
		if ($original_mail->getBodyHtml() == '') {
			$str = "\n\n\n\n----- ".lang('original message')."-----\n".lang('mail from').": ".$original_mail->getFrom()."\n".lang('mail to').": ".$original_mail->getTo()."\n".lang('mail sent').": ".$loc->formatDateTime($original_mail->getSentDate(), logged_user()->getTimezone())."\n".lang('mail subject').": ".$original_mail->getSubject()."\n\n";
		} else {
			$str = "<br><br><br><table><tr><td>----- ".lang('original message')." -----</td></tr><tr><td>".lang('mail from').": ".$original_mail->getFrom()."</td></tr><tr><td>".lang('mail to').": ".$original_mail->getTo()."</td></tr><tr><td>".lang('mail sent').": ".$loc->formatDateTime($original_mail->getSentDate(), logged_user()->getTimezone())."</td></tr><tr><td>".lang('mail subject').": ".$original_mail->getSubject()."</td></tr></table><br>";
		}		 
		return $str;
	}
	
	function reply_mail() {
		$this->setTemplate('add_mail');
		$mail = new MailContent();
		if (array_var($_GET,'id','') == '') {
			flash_error('Invalid parameter.');
			ajx_current("empty");
		}
		$original_mail = MailContents::findById(get_id('id',$_GET));
		if(! $original_mail) {
			flash_error('Invalid parameter.');
			ajx_current("empty");
		}
		$mail_data = array_var($_POST, 'mail', null);
		if (!is_array($mail_data)) {
			$re_subject = str_starts_with($original_mail->getSubject(), 'Re:') ? $original_mail->getSubject(): 'Re: ' . $original_mail->getSubject();
			$re_body = $original_mail->getBodyHtml() == '' ? $original_mail->getBodyPlain() : $original_mail->getBodyHtml();

			$arr_body=preg_split("/<body.*>/i",$re_body);
			$re_body = $this->build_original_mail_info($original_mail);

			if (count($arr_body)>1)
				$re_body = $arr_body[0]."<body>".$re_body.$arr_body[1];
			else
				$re_body = $re_body.$arr_body[0];
		
			$cc = "";
			if (array_var($_GET,'all','') != '') {
				MailUtilities::parseMail($original_mail->getContent(), $decoded, $parsedEmail, $warnings);
				if (isset($parsedEmail["Cc"])) {
					foreach ($parsedEmail["Cc"] as $cc_value) {
						if ($cc != '') $cc .= ", ";
						$cc .= $cc_value['address'];
					}
				}
				$accounts = MailAccounts::findAll(array(
		    		"conditions" => "`user_id` = " . logged_user()->getId()
				));
				 
				$account_emails = array();
				foreach ($accounts as $account){
					$account_emails[] =  $account->getEmailAddress();
				}
				 
				foreach ($parsedEmail["To"] as $to_value) {
					if (!in_array($to_value['address'], $account_emails)) {
						if ($cc != '') $cc .= ", ";
						$cc .= $to_value['address'];
					}
				}
			}
			 
			$mail_data = array(
				'to' => $original_mail->getFrom(),
				'cc' => $cc,
				'type' => $original_mail->getBodyHtml() != '' ? 'html' : 'plain',
				'subject' => $re_subject,
				'account_id' => $original_mail->getAccountId(),
				'body' => $re_body
			); // array
		} // if
		$mail_accounts = MailAccounts::getMailAccountsByUser(logged_user());
		tpl_assign('mail', $mail);
		tpl_assign('mail_data', $mail_data);
		tpl_assign('mail_accounts', $mail_accounts);
	}

	/**
	 * Add single mail
	 *
	 * @access public
	 * @param void
	 * @return null
	 */
	function add_mail() {

		$mail_accounts = MailAccounts::getMailAccountsByUser(logged_user());
		if (count($mail_accounts) < 1){
			flash_error(lang('no mail accounts set'));
			ajx_current("empty");
			return;
		}
		$this->setTemplate('add_mail');
		$mail_data = array_var($_POST, 'mail');
		$isDraft = array_var($mail_data, 'isDraft', '') == 'true' ? true : false;
		$isUpload = array_var($mail_data, 'isUpload', '') == 'true' ? true : false;
		$autosave = array_var($mail_data,'autosave', '') == 'true';

		$id = array_var($mail_data, 'id');
		$mail = MailContents::findById($id);
		$isNew = false;
		if (!$mail) {
			$isNew = true;
			$mail = new MailContent();
		}

		$def_acc = $this->getDefaultAccountId();
		if ($def_acc > 0) tpl_assign('default_account', $def_acc);
		tpl_assign('mail', $mail);
		tpl_assign('mail_data', $mail_data);
		tpl_assign('mail_accounts', $mail_accounts);

		// Form is submited
		if (is_array($mail_data)) {
			$account = 	MailAccounts::findById(array_var($mail_data, 'account_id'));
			if (!$account instanceof MailAccount) {
				flash_error(lang('mail account dnx'));
				ajx_current("empty");
				return;
			}
			$subject = array_var($mail_data, 'subject');
			$body = array_var($mail_data, 'body');
			$type = 'text/' . array_var($mail_data, 'format');
			
			$to = trim(array_var($mail_data, 'to'));
			if (str_ends_with($to, ",")) $to = substr($to, 0, strlen($to) - 1);
			$mail_data['to'] = $to;
			$cc = trim(array_var($mail_data,'cc'));
			if (str_ends_with($cc, ",")) $cc = substr($cc, 0, strlen($cc) - 1);
			$mail_data['cc'] = $cc;			
			$bcc = trim(array_var($mail_data,'bcc'));
			if (str_ends_with($bcc, ",")) $bcc = substr($bcc, 0, strlen($bcc) - 1);
			$mail_data['bcc'] = $bcc;
			
			$mail->setFromAttributes($mail_data);
				
			$utils = new MailUtilities();
			
			// attachment
			$linked_attachments = array();
 			$attachments = array();
 			$objects = array_var($_POST, 'linked_objects');
 			$attach_contents = array_var($_POST, 'attach_contents', array());
 			ob_start();
 			print_r($attach_contents);
 			$a = ob_get_clean();
 			alert("ATCON: " . $a);
 			if (is_array($objects)) {
 				$err = 0;
 				$count = 0;
 				foreach ($objects as $objid) {
 					$split = split(":", $objid);
 					$object = get_object_by_manager_and_id($split[1], $split[0]);
 					
 					if (!$object) {
 						flash_error(lang('file dnx'));
	 					$err++;
 					} else {
 						alert("ATCON[$count] = " . $attach_contents[$count]);
	 					if (isset($attach_contents[$count]) && $split[0] == 'ProjectFiles') {
	 						alert("ATTACHING: " . $objid);
		 					$file = ProjectFiles::findById($object->getId());
		 					if (!($file instanceof ProjectFile)) {
		 						flash_error(lang('file dnx'));
		 						$err++;
		 					} // if
		 					if(!$file->canDownload(logged_user())) {
		 						flash_error(lang('no access permissions'));
		 						$err++;
		 					} // if
		 
		 					$attachments[] = array(
		 						"data" => $file->getFileContent(),
		 						"name" => $file->getFilename(),
		 						"type" => $file->getTypeString()
		 					);
	 					} else {
	 						$linked_attachments[] = array(
		 						"data" => $object->getViewUrl(),
		 						"name" => $object->getObjectName(),
		 						"type" => lang($object->getObjectTypeName())
		 					);
	 					}
 					}
 					$count++;
 				}
 				if ($err > 0) {
 					flash_error(lang('some objects could not be linked'));
 				}
 			}
				
			$to = explode(",", $to);
			$to = $utils->parse_to($to);
			
			if ($body == '') $body.=' ';

			try {

				$from = logged_user()->getDisplayName() . " <" . $account->getEmailAddress() . ">";
				$sentOK = false;
				if (!$isDraft) {
					if ($account->getOutgoingTrasnportType() == 'ssl' || $account->getOutgoingTrasnportType() == 'tls') {
						$available_transports = stream_get_transports();
						if (array_search($account->getOutgoingTrasnportType(), $available_transports) === FALSE) {
							flash_error('The server does not support SSL.');
							ajx_current("empty");
							return;
						}
					}
					if (count($linked_attachments)) {
						$linked_atts = $type == 'text/html' ? '<div style="font-family:arial;"><br><br><br><span style="font-size:12pt;font-weight:bold;color:#777">'.lang('linked attachments').'</span><ul>' : "\n\n\n-----------------------------------------\n".lang('linked attachments')."\n\n";
						foreach ($linked_attachments as $att) {
							$linked_atts .= $type == 'text/html' ? '<li><a href="'.$att['data'].'">' . $att['name'] . ' (' . $att['type'] . ')</a></li>' : $att['name'] . ' (' . $att['type'] . '): ' . $att['data'] . "\n";
						}
						$linked_atts .= $type == 'text/html' ? '</ul></div>' : '';
					} else $linked_atts = '';
					$body .= $linked_atts;
					
					$sentOK = $utils->sendMail($account->getSmtpServer(), $to, $from, $subject, $body, $cc, $bcc, $attachments, $account->getSmtpPort(), $account->smtpUsername(), $account->smtpPassword(), $type, $account->getOutgoingTrasnportType());
				}
				if ((!$isDraft && $sentOK)|| $isDraft) {
					$content = $utils->getContent($account->getSmtpServer(), $account->getSmtpPort(), $account->getOutgoingTrasnportType(), $account->smtpUsername(), $account->smtpPassword(), $body, $attachments);
					$repository_id = $utils->saveContent($content);
					$mail->setContentFileId($repository_id);
					$mail->setHasAttachments((is_array($attachments) && count($attachments) > 0) ? 1 : 0);
					$mail->setSize(strlen($content));
					$mail->setAccountEmail($account->getEmailAddress());

 					$mail->setSentDate( DateTimeValueLib::now());
					DB::beginWork();
					$mail->setUid('UID');
					$mail->setState($isDraft ? 2 : 3);
					$mail->setIsPrivate(true);

					set_user_config_option('last_mail_format', array_var($mail_data, 'format', 'plain'), logged_user()->getId());
					if (array_var($mail_data,'format') == 'html') {
						$mail->setBodyHtml($body);
					} else {
						$mail->setBodyPlain($body);
						$mail->setBodyHtml('');
					}
					$mail->setFrom($account->getEmailAddress());
					$mail->setFromName(logged_user()->getDisplayName());
					$mail->save();
					$mail->setTagsFromCSV(array_var($mail_data, 'tags'));

					$object_controller = new ObjectController();
					$object_controller->add_custom_properties($mail);

					ApplicationLogs::createLog($mail, $mail->getWorkspaces(), ApplicationLogs::ACTION_ADD);
					
					DB::commit();

					if (!$autosave) {
						if ($isDraft) {
							flash_success(lang('success save mail'));
							ajx_current("back");
						} else {
							flash_success(lang('success add mail'));
							ajx_current("back");
						}
						evt_add("email saved", array("id" => $mail->getId(), "instance" => array_var($_POST, 'instanceName')));
					} else {
						evt_add("draft mail autosaved", array("id" => $mail->getId(), "hf_id" => $mail_data['hf_id']));
						flash_success(lang('success autosave draft'));
						ajx_current("empty");
					}
				}
				else {
					flash_error(lang('send mail error'));
					ajx_current("empty");
				}
			} catch(Exception $e) {
				DB::rollback();
				flash_error($e->getMessage());
				ajx_current("empty");
			} // try
		} // if
	} // add_mail

	/**
	 * View specific email
	 *
	 */
	function view() {
		$this->addHelper('textile');
		$email = MailContents::findById(get_id());
		if (!$email instanceof MailContent) {
			flash_error(lang('email dnx'));
			ajx_current("empty");
			return;
		}
		if ($email->getIsDeleted()) {
			flash_error(lang('email dnx deleted'));
			ajx_current("empty");
			return;
		}
		if (!$email->canView(logged_user())) {
			flash_error(lang('no access permissions'));
			ajx_current("empty");
			return;
		}
		 
		tpl_assign('email', $email);

		$attachments = array();
		MailUtilities::parseMail($email->getContent(), $decoded, $parsedEmail, $warnings);
		if (isset($parsedEmail['Attachments'])) $attachments = $parsedEmail['Attachments'];
		
		if ($email->getBodyHtml() != '') {
			$tmp_folder = "/tmp/" . $email->getAccount()->getId() . "temp_mail_content_res";
			if (is_dir(ROOT . $tmp_folder)) remove_dir(ROOT . $tmp_folder);
			$email->setBodyHtml(self::rebuild_body_html($email->getBodyHtml(), $decoded[0]['Parts'], $tmp_folder));
		}
				
		tpl_assign('attachments', $attachments);
		ajx_extra_data(array("title" => $email->getSubject(), 'icon' => 'ico-email'));
		ajx_set_no_toolbar(true);

		if (!$email->getIsRead(logged_user()->getId())) {
			try {
				DB::beginWork();
				$email->setIsRead(1, logged_user()->getId());
				DB::commit();
			} catch(Exception $e) {
				DB::rollback();
				flash_error(lang('error mark email'));
			}
		}
	}
	
	/**
	 * Images that are attachments are saved to the filesystem and the links to them are rebuilt
	 * files are saved in root/tmp directory
	 */
	private function rebuild_body_html($html, $parts, $tmp_folder) {
		$end_find = false;
		$to_find = 'src="cid:';
		$end_pos = 0;
		while (!$end_find) {
			$part_name = "";
			$cid_pos = strpos($html, $to_find, $end_pos);
			if ($cid_pos !== FALSE) {
				$cid_pos += strlen($to_find);
				$end_pos = strpos($html, '"', $cid_pos);
				$part_name = substr($html, $cid_pos, $end_pos-$cid_pos);
			} else 
				$end_find = true;

			if (!$end_find) {
				if (!is_dir(ROOT."$tmp_folder")) mkdir(ROOT."$tmp_folder");
				foreach ($parts as $part) {
					if (is_array($part['Headers'])) {
						
						if (isset($part['Headers']['content-id:']) && $part['Headers']['content-id:'] == "<$part_name>") {
							$filename = isset($part['FileName']) ? $part['FileName'] : $part_name;
							$file_content = $part['Body'];
							$handle = fopen(ROOT."$tmp_folder/$filename", "wb");
							fwrite($handle, $file_content);
							fclose($handle);
							
							$html = str_replace("src=\"cid:$part_name\"", "src=\"".ROOT_URL."$tmp_folder/$filename\"", $html);
						} else {
							if (isset($part['Parts'])) $html = self::rebuild_body_html($html, $part['Parts'], $tmp_folder);
						}
					}
				}
			}
		}
		return $html;
	}
	
	function discard() {
		$email = MailContents::findById(get_id());
		if ($email && $email->getState() == 2) { // if mc is Draft
			$this->delete();
		}
		else ajx_current("back");
	}
	
	/**
	 * Delete specific email
	 *
	 * @access public
	 * @param void
	 * @return null
	 */
	function delete() {
		$email = MailContents::findById(get_id());
		if (!$email instanceof MailContent || $email->getIsDeleted()){
			flash_error(lang('email dnx'));
			ajx_current("empty");
			return;
		}
		 
		if (!$email->canDelete(logged_user())){
			flash_error(lang('no access permissions'));
			ajx_current("empty");
			return;
		}
		try {
			DB::beginWork();
			$email->trash();
			ApplicationLogs::createLog($email, $email->getWorkspaces(), ApplicationLogs::ACTION_TRASH);
			DB::commit();
			flash_success(lang('success delete email'));
			ajx_current("back");
			 
		} catch(Exception $e) {
			DB::rollback();
			flash_error(lang('error delete email'));
			ajx_current("empty");
		}
	} // delete

	/**
	 * Download specific file
	 *
	 * @param void
	 * @return null
	 */
	function download_attachment() {
		$emailId = array_var($_GET, 'email_id');
		$email = MailContents::findById($emailId);
		$attId = array_var($_GET, 'attachment_id');

		MailUtilities::parseMail($email->getContent(), $decoded, $parsedEmail, $warnings);
		$attachment = $parsedEmail["Attachments"][$attId];

		$content = $attachment['Data'];
		$filename = $attachment["FileName"];
		$typeString = "application/octet-stream";
		$filesize = strlen($content);
		$inline = false;
		 
		download_contents($content, $typeString, $filename, $filesize, !$inline);
		die();
	} // download_file

		/**
	 * Classify specific email
	 *
	 */
	function unclassify() {
		$email = MailContents::findById(get_id());
		if (!$email instanceof MailContent) {
			flash_error(lang('email dnx'));
			ajx_current("empty");
			return;
		}
		if ($email->getIsDeleted()) {
			flash_error(lang('email dnx deleted'));
			ajx_current("empty");
			return;
		}
		if (!$email->canEdit(logged_user())) {
			flash_error(lang('no access permissions'));
			ajx_current("empty");
			return;
		} // if
		
		try {
			DB::beginWork();
			// unclassify attachments
			if ($email->getHasAttachments()) {
				MailUtilities::parseMail($email->getContent(),$decoded,$parsedEmail,$warnings);
				if (isset($parsedEmail['Attachments'])) {
					$files = ProjectFiles::findAll(array('conditions' => 'mail_id = '.$email->getId()));
					foreach ($files as $file) {
						$file->delete();
					}
				}
			}
			// remove associated workspaces
			$email->removeFromWorkspaces(logged_user()->getWorkspacesQuery());
			DB::commit();
			
			flash_success(lang('success unclassify email'));
			ajx_current("back");
		} catch (Exception $e) {
			DB::rollback();
			Logger::log("Error: Unclassify email\r\n".$e->getMessage());
			flash_error(lang('error unclassify email'));
			ajx_current("empty");
		}
	}
	
	/**
	 * Classify specific email
	 *
	 */
	function classify() {
		$email = MailContents::findById(get_id());
		if (!$email instanceof MailContent){
			flash_error(lang('email dnx'));
			ajx_current("empty");
			return;
		}
		if ($email->getIsDeleted()){
			flash_error(lang('email dnx deleted'));
			ajx_current("empty");
			return;
		}
		if(!$email->canEdit(logged_user())) {
			flash_error(lang('no access permissions'));
			ajx_current("empty");
			return;
		} // if

		MailUtilities::parseMail($email->getContent(),$decoded,$parsedEmail,$warnings);

		$projects = logged_user()->getActiveProjects();
		tpl_assign('projects', $projects);

		$classification_data = array_var($_POST, 'classification');
		if(!is_array($classification_data)) {
			$tag_names = $email->getTagNames();
			$classification_data = array(
          'tag' => is_array($tag_names) ? implode(', ', $tag_names) : '',
			); // array
		} // if
		if(is_array(array_var($_POST, 'classification'))){
			try{
				$canWriteFiles = $this->checkFileWritability($classification_data, $parsedEmail);
				if ($canWriteFiles){
					$project_ids = $classification_data["project_ids"];
					$enteredWS = Projects::findByCSVIds($project_ids);
					$validWS = array();
					if (isset($enteredWS)) {
						foreach ($enteredWS as $ws) {
							if (ProjectFile::canAdd(logged_user(), $ws)) {
								$validWS[] = $ws;
							}
						}
					}
					if (empty($validWS)) {
						flash_error(lang('must choose at least one workspace error'));
						ajx_current("empty");
						return;
					}

					$email->removeFromWorkspaces(logged_user()->getWorkspacesQuery());
					foreach ($validWS as $w) {
						$email->addToWorkspace($w);
					}

					DB::beginWork();
					$email->save();
					DB::commit();
					$csv = array_var($classification_data, 'tag');
					$email->setTagsFromCSV($csv);
					
					//Classify attachments
					$this->classifyFile($classification_data, $email,$parsedEmail, $validWS, $csv);	
					
					flash_success(lang('success classify email'));
					ajx_current("back");
				} else {
					flash_error(lang("error classifying attachment cant open file"));
					ajx_current("empty");
				} // If can write files
				// Error...
			} catch(Exception $e) {
				DB::rollback();
				flash_error($e->getMessage());
				ajx_current("empty");
			} // try
		} else {
			$classification_data["project_ids"] = $email->getWorkspaces();
		}
		tpl_assign('classification_data', $classification_data);
		tpl_assign('email', $email);
		tpl_assign('parsedEmail', $parsedEmail);
	}

	function classifyFile($classification_data, $email, $parsedEmail, $validWS, $mantainWs = true, $csv = '') {
		if (!is_array($classification_data)) $classification_data = array();
		
		for ($c = 0; $c < count($classification_data); $c++) {
			if (isset($classification_data["att_".$c]) && $classification_data["att_".$c]) {
				$att = $parsedEmail["Attachments"][$c];
				$fName = iconv_mime_decode($att["FileName"], 0, "UTF-8");
				$tempFileName = ROOT ."/tmp/saveatt/". logged_user()->getId()."x".$fName;
				$fh = fopen($tempFileName, 'w') or die("Can't open file");
				fwrite($fh, $att["Data"]);
				fclose($fh);
							
				$file = ProjectFiles::getByFilename($fName);
				if ($file == null){
					$file = new ProjectFile();
					$file->setFilename($fName);
					$file->setIsVisible(true);
					$file->setIsPrivate(false);
					$file->setIsImportant(false);
					$file->setCommentsEnabled(true);
					$file->setAnonymousCommentsEnabled(false);
					$file->setMailId($email->getId());
				}
						
				try
				{
					DB::beginWork();
					$file->save();
					if (!$mantainWs) {
						$file->removeFromWorkspaces(logged_user()->getWorkspacesQuery());
					}
					foreach ($validWS as $w) {
						if (!$file->hasWorkspace($w)) {
							$file->addToWorkspace($w);
						}
					}
					DB::commit();

					$file->setTagsFromCSV($csv);
					$enc = array_var($parsedMail,'Encoding','UTF-8');
					
					$ext = utf8_substr($fName, strrpos($fName,'.')+1, utf8_strlen($fName, $enc), $enc);
					
								
					$mime_type = '';
					if (Mime_Types::instance()->has_type($att["content-type"]))
						$mime_type = $att["content-type"]; //mime type is listed & valid
					else
						$mime_type = Mime_Types::instance()->get_type($ext); //Attempt to infer mime type

					$fileToSave = array(
	      				"name" => $fName, 
	      				"type" => $mime_type, 
	      				"tmp_name" => $tempFileName,
	      				"error" => 0,
	      				"size" => filesize($tempFileName));

					$revision = $file->handleUploadedFile($fileToSave, true); // handle uploaded file
					$email->linkObject($file);
					ApplicationLogs::createLog($file, $email->getWorkspaces(), ApplicationLogs::ACTION_ADD);
					// Error...
				} catch(Exception $e) {
						DB::rollback();
						flash_error($e->getMessage());
						ajx_current("empty");
				}
				unlink($tempFileName);
			}
			$c++;
		}		
	}
	
	function showContents(){
		$email = MailContents::findById(get_id());
		$mailContents = MailContents::findById(get_id());
		if (!$email instanceof MailContent){
			flash_error(lang('email dnx'));
			ajx_current("empty");
			return;
		}
		if ($email->getIsDeleted()){
			flash_error(lang('email dnx deleted'));
			ajx_current("empty");
			return;
		}
		if (!$email->canView(logged_user())){
			flash_error(lang('no access permissions'));
			ajx_current("empty");
			return;
		}
		 
		echo $email->getContent(); die();
	}


	function checkFileWritability($classification_data, $parsedEmail){
		$c = 0;
		while(isset($classification_data["att_".$c]))
		{
			if ($classification_data["att_".$c])
			{
				$att = $parsedEmail["Attachments"][$c];
				$fName = iconv_mime_decode($att["FileName"], 0, "UTF-8");
				$tempFileName = ROOT ."/tmp/saveatt/". logged_user()->getId()."x".$fName;
				$fh = fopen($tempFileName, 'w');
				if (!$fh){
					return false;
				}
				fclose($fh);
				unlink($tempFileName);
			}
			$c++;
		}
		return true;
	}


	function checkmail() {
		 
		set_time_limit(0);
		$accounts = MailAccounts::getMailAccountsByUser(logged_user());

		session_commit();
		if (is_array($accounts) && count($accounts) > 0){
			// check a maximum of $max emails per account
			$max = config_option("user_email_fetch_count", 10);
			MailUtilities::getmails($accounts, $err, $succ, $errAccounts, $mailsReceived, $max);

			$errMessage = lang('success check mail', $mailsReceived);
			if ($err > 0){
				foreach($errAccounts as $error) {
					$errMessage .= lang('error check mail', $error["accountName"], $error["message"]);
				}
			}
		} else {
			$err = 1;
			$errMessage = lang('no mail accounts set for check');
		}
		try {
			foreach ($accounts as $acc) {
				if ($acc->getDelFromServer() >= 0) {
					MailUtilities::deleteMailsFromServer($acc);
				}
			}
		} catch (Exception $e) {
			Logger::log($e->getTraceAsString());
			flash_error($e->getMessage());
		}
		ajx_add("overview-panel", "reload");
		ajx_current("empty");
		 
		return array($err, $errMessage);
	}

	// ---------------------------------------------------
	//  Mail Accounts
	// ---------------------------------------------------

	/**
	 * Add email account
	 *
	 * @access public
	 * @param void
	 * @return null
	 */
	function add_account() {
		$this->setTemplate('add_account');

		if(!MailAccount::canAdd(logged_user())) {
			flash_error(lang('no access permissions'));
			ajx_current("empty");
			return;
		} // if

		$mailAccount = new MailAccount();
		tpl_assign('mailAccount', $mailAccount);

		$mailAccount_data = array_var($_POST, 'mailAccount');
		tpl_assign('mailAccount_data', $mailAccount_data);

		if(is_array(array_var($_POST, 'mailAccount'))) {
			$email_address = array_var(array_var($_POST, 'mailAccount'), 'email_addr');
			if (MailAccounts::findOne(array('conditions' => "`email` = '$email_address'")) != null) {
				flash_error(lang('email address already exists'));
				ajx_current("empty");
				return;
			}

			try {
				$mailAccount_data['user_id'] = logged_user()->getId();
				if (!array_var($mailAccount_data, 'del_mails_from_server', false)) $mailAccount_data['del_from_server'] = -1;
				if (!array_var($mailAccount_data, 'is_default', false)) $mailAccount_data['is_default'] = 0;
				$mailAccount->setFromAttributes($mailAccount_data);
				$mailAccount->setPassword(MailUtilities::ENCRYPT_DECRYPT($mailAccount->getPassword()));
				$mailAccount->setSmtpPassword(MailUtilities::ENCRYPT_DECRYPT($mailAccount->getSmtpPassword()));

				DB::beginWork();
				$mailAccount->save();

				if ($mailAccount->getIsImap() && is_array(array_var($_POST, 'check'))) {
					$real_folders = MailUtilities::getImapFolders($mailAccount);
					foreach ($real_folders as $folder_name) {
						if (!MailAccountImapFolders::findById(array('account_id' => $mailAccount->getId(), 'folder_name' => $folder_name))) {
							$acc_folder = new MailAccountImapFolder();
							$acc_folder->setAccountId($mailAccount->getId());
							$acc_folder->setFolderName($folder_name);
							$acc_folder->setCheckFolder($folder_name == 'INBOX');// By default only INBOX is checked
		
							DB::beginWork();
							$acc_folder->save();
							DB::commit();
						}
					}
					$imap_folders = MailAccountImapFolders::getMailAccountImapFolders($mailAccount->getId());
					
					$checks = array_var($_POST, 'check');
					if (is_array($imap_folders) && count($imap_folders)) {
						foreach ($imap_folders as $folder) {
							$folder->setCheckFolder(false);
							foreach ($checks as $name => $cf) {
								$name = str_replace(array('¡','!'), array('[',']'), $name);//to avoid a mistaken array if name contains [ 
								if (strcasecmp($name, $folder->getFolderName()) == 0) {
									$folder->setCheckFolder($cf == 'checked');
									break;
								}
							}
							$folder->save();
						}
					}
				}
				
				if ($mailAccount->getIsDefault()) {
					$user_accounts = MailAccounts::find(array('conditions' => '`user_id` = '.logged_user()->getId()));
					foreach ($user_accounts as $acc) {
						if ($acc->getId() != $mailAccount->getId()) {
							$acc->setIsDefault(false);
							$acc->save();				
						}
					}
				}

				DB::commit();

				evt_add("mail account added", array(
					"id" => $mailAccount->getId(),
					"name" => $mailAccount->getName(),
					"email" => $mailAccount->getEmail()
				));

				// Restore old emails, if account was deleted and its emails didn't
				$old_emails = MailContents::findAll(array('conditions' => 'created_by_id = ' . logged_user()->getId() . " AND account_email = '" . $mailAccount->getEmail() . "'"));
				if (isset($old_emails) && is_array($old_emails) && count($old_emails)) {
					DB::beginWork();
					foreach ($old_emails as $email) {
						$email->setAccountId($mailAccount->getId());
						$email->save();
					}
					DB::commit();
				}

				flash_success(lang('success add mail account', $mailAccount->getName()));
				ajx_current("back");
				// Error...
			} catch(Exception $e) {
				DB::rollback();
				ajx_current("empty");
				flash_error($e->getMessage());
			} // try

		} // if
	} // add_account

	/**
	 * Edit email account
	 *
	 * @access public
	 * @param void
	 * @return null
	 */
	function edit_account() {
		$this->setTemplate('add_account');

		$mailAccount = MailAccounts::findById(get_id());
		if(!($mailAccount instanceof MailAccount)) {
			flash_error(lang('mailAccount dnx'));
			ajx_current("empty");
			return;
		} // if

		if(!$mailAccount->canEdit(logged_user())) {
			flash_error(lang('no access permissions'));
			ajx_current("empty");
			return;
		} // if

		$mailAccount_data = array_var($_POST, 'mailAccount');
		if(!is_array($mailAccount_data)) {
			$mailAccount_data = array(
	          'user_id' => logged_user()->getId(),
	          'name' => $mailAccount->getName(),
	          'email' => $mailAccount->getEmail(),
	          'email_addr' => $mailAccount->getEmailAddress(),
	          'password' => MailUtilities::ENCRYPT_DECRYPT($mailAccount->getPassword()),
	          'server' => $mailAccount->getServer(),
	          'is_imap' => $mailAccount->getIsImap(),
	          'incoming_ssl' => $mailAccount->getIncomingSsl(),
	          'incoming_ssl_port' => $mailAccount->getIncomingSslPort(),
	          'smtp_server' => $mailAccount->getSmtpServer(),
	          'smtp_port' => $mailAccount->getSmtpPort(),
	          'smtp_username' => $mailAccount->getSmtpUsername(),
	          'smtp_password' => MailUtilities::ENCRYPT_DECRYPT($mailAccount->getSmtpPassword()),
	          'smtp_use_auth' => $mailAccount->getSmtpUseAuth(),
	          'del_from_server' => $mailAccount->getDelFromServer(),
	          'outgoing_transport_type' => $mailAccount->getOutgoingTrasnportType(),
			  'is_default' => $mailAccount->getIsDefault(),
			  'signature' => $mailAccount->getSignature(),
			); // array
		} else {
			if (!isset($mailAccount_data['incoming_ssl']))
				$mailAccount_data['incoming_ssl'] = false;
			if (!isset($mailAccount_data['is_default']))
				$mailAccount_data['is_default'] = false;
		}
		
		if ($mailAccount->getIsImap()) {
			try {
				$real_folders = MailUtilities::getImapFolders($mailAccount);
				foreach ($real_folders as $folder_name) {
					if (!MailAccountImapFolders::findById(array('account_id' => $mailAccount->getId(), 'folder_name' => $folder_name))) {
						$acc_folder = new MailAccountImapFolder();
						$acc_folder->setAccountId($mailAccount->getId());
						$acc_folder->setFolderName($folder_name);
						$acc_folder->setCheckFolder($folder_name == 'INBOX');// By default only INBOX is checked
					 
						DB::beginWork();
						$acc_folder->save();
						DB::commit();
					}
				}
			} catch (Exception $e) {
				flash_error($e->getMessage());
			}
			 
			$imap_folders = MailAccountImapFolders::getMailAccountImapFolders($mailAccount->getId());
			tpl_assign('imap_folders', $imap_folders);
		}

		tpl_assign('mailAccount', $mailAccount);
		tpl_assign('mailAccount_data', $mailAccount_data);

		if(is_array(array_var($_POST, 'mailAccount'))) {
			try {
				if (!array_var($mailAccount_data, 'del_mails_from_server', false)) $mailAccount_data['del_from_server'] = -1;
				$mailAccount->setFromAttributes($mailAccount_data);
				$mailAccount->setPassword(MailUtilities::ENCRYPT_DECRYPT($mailAccount->getPassword()));
				$mailAccount->setSmtpPassword(MailUtilities::ENCRYPT_DECRYPT($mailAccount->getSmtpPassword()));

				DB::beginWork();
				//If imap, save folders to check
				if($mailAccount->getIsImap() && is_array(array_var($_POST, 'check'))) {
				  	$checks = array_var($_POST, 'check');
				  	if (is_array($imap_folders) && count($imap_folders)) {
					  	foreach ($imap_folders as $folder) {
					  		$folder->setCheckFolder(false);
					  		foreach ($checks as $name => $cf) {
					  			$name = str_replace(array('¡','!'), array('[',']'), $name);//to avoid a mistaken array if name contains [ 
					  			if (strcasecmp($name, $folder->getFolderName()) == 0) {
					  				$folder->setCheckFolder($cf == 'checked');
					  				break;
					  			}
					  		}
					  		$folder->save();
					  	}
				  	}
				}
					
				if ($mailAccount->getIsDefault()) {
					$user_accounts = MailAccounts::find(array('conditions' => '`user_id` = '.logged_user()->getId()));
					foreach ($user_accounts as $acc) {
						if ($acc->getId() != $mailAccount->getId()) {
							$acc->setIsDefault(false);
							$acc->save();				
						}
					}
				}
		
				$mailAccount->save();
				DB::commit();

				evt_add("mail account edited", array(
						"id" => $mailAccount->getId(),
						"name" => $mailAccount->getName(),
						"email" => $mailAccount->getEmail()
				));

				flash_success(lang('success edit mail account', $mailAccount->getName()));
				ajx_current("back");

		  // Error...
			} catch(Exception $e) {
				DB::rollback();
				ajx_current("empty");
				flash_error($e->getMessage());
			} // try
		} // if
	} // edit

	/**
	 * List user email accounts
	 *
	 * @access public
	 * @param void
	 * @return null
	 */
	function list_accounts(){
		ajx_current("empty");
		$type = array_var($_GET,'type');
		 
		$accounts = MailAccounts::findAll(array(
      		'conditions' => '`user_id` = ' . logged_user()->getId()));
		 
		$object = array();
		if (isset($accounts)){
			foreach($accounts as $acc)
			{
				$loadAcc = true;
				if (isset($type))
				{
					if ($type == "view")
					$loadAcc = $acc->canView(logged_user());
					if ($type == "edit")
					$loadAcc = $acc->canEdit(logged_user());
				}
				if ($loadAcc)
				$object[] = array(
						"id" => $acc->getId(),
						"name" => $acc->getName(),
						"email" => $acc->getEmail()
				);
			}
		}
		ajx_extra_data(array("accounts" => $object));
	}

	/**
	 * Delete specific mail account
	 *
	 * @access public
	 * @param void
	 * @return null
	 */
	function delete_account() {
		$account = MailAccounts::findById(get_id());
		if (isset($account)) {
			$deleteMails = array_var($_GET, 'deleteMails', false);
			try
			{
				$accId = $account->getId();
				$accName = $account->getName();
				$accEmail = $account->getEmail();
				 
				DB::beginWork();
				$account->delete($deleteMails);
				DB::commit();

				evt_add("mail account deleted", array(
						"id" => $accId,
						"name" => $accName,
						"email" => $accEmail
				));

				flash_success(lang('success delete mail account'));
				ajx_current("back");
	    
			} catch(Exception $e) {
				DB::rollback();
				flash_error(lang('error delete mail account'));
				ajx_current("empty");
			}
		} else {
			flash_error(lang('error delete mail account'));
			ajx_current("empty");
		}
	} // delete





	/**
	 * Forward email
	 *
	 * @param void
	 * @return null
	 */
	function forward_mail(){
		$this->setTemplate('add_mail');
		$mail = new MailContent();
		if(array_var($_GET,'id','') == ''){
			flash_error('Invalid parameter.');
			ajx_current("empty");
		}
		$original_mail = MailContents::findById(get_id('id',$_GET));
		if(! $original_mail){
			flash_error('Invalid parameter.');
			ajx_current("empty");
		}
		$mail_data = array_var($_POST, 'mail', null);

		if(!is_array($mail_data)) {
			$fwd_subject = str_starts_with($original_mail->getSubject(),'Fwd:')?$original_mail->getSubject():'Fwd: '.$original_mail->getSubject();

			$fwd_body = $this->build_original_mail_info($original_mail);
			
			$body = $original_mail->getBodyHtml() == '' ? $original_mail->getBodyPlain() : $original_mail->getBodyHtml();
			$arr_body=preg_split("/<body.*>/i",$body);
			if (count($arr_body)>1)
				$fwd_body = $arr_body[0].$fwd_body.$arr_body[1];
			else
				$fwd_body = $fwd_body.$arr_body[0];
			 
			 
			$mail_data = array(
	          'to' => '',
	          'subject' => $fwd_subject,
	          'body' => $fwd_body,
	          'type' => $original_mail->getBodyHtml() != '' ? 'html' : 'plain',
	          'account_id' => $original_mail->getAccountId()
			); // array
		} // if
		$mail_accounts = MailAccounts::getMailAccountsByUser(logged_user());
		tpl_assign('mail', $mail);
		tpl_assign('mail_data', $mail_data);
		tpl_assign('mail_accounts', $mail_accounts);
	}//forward_mail


	/**
	 * Forward email
	 *
	 * @param void
	 * @return null
	 */
	function edit_mail(){
		$this->setTemplate('add_mail');
		$mail = new MailContent();
		if(array_var($_GET,'id','') == ''){
			flash_error('Invalid parameter.');
			ajx_current("empty");
		}
		$original_mail = MailContents::findById(get_id('id',$_GET));
		if(! $original_mail){
			flash_error('Invalid parameter.');
			ajx_current("empty");
		}
		$mail_data = array_var($_POST, 'mail', null);

		if(!is_array($mail_data)) {
			$body = $original_mail->getBodyHtml() == '' ? $original_mail->getBodyPlain() : $original_mail->getBodyHtml();

			$mail_data = array(
	          'to' => $original_mail->getTo(),
	          'cc' => $original_mail->getCc(),
	          'bcc' => $original_mail->getBcc(),
	          'subject' => $original_mail->getSubject(),
	          'body' => $body,
	          'type' => $original_mail->getBodyHtml() != '' ? 'html' : 'plain',
	          'account_id' => $original_mail->getAccountId(),
	          'id' => $original_mail->getId(),
			  'draft_edit' => 1,
			); // array
		} // if
		
		$mail_accounts = MailAccounts::getMailAccountsByUser(logged_user());
		tpl_assign('mail', $mail);
		tpl_assign('mail_data', $mail_data);
		tpl_assign('mail_accounts', $mail_accounts);
	}//forward_mail


	/**
	 * Lists emails.
	 *
	 */
	function list_all() {
		ajx_current("empty");

		// Get all variables from request
		$start = array_var($_GET, 'start');
		$limit = config_option('files_per_page');
		if (!is_numeric($start)) {
			$start = 0;
		}
		$tag = array_var($_GET,'tag');
		$action = array_var($_GET,'action');
		$attributes = array(
			"ids" => explode(',', array_var($_GET,'ids')),
			"types" => explode(',', array_var($_GET,'types')),
			"tag" => array_var($_GET,'tagTag'),
			"accountId" => array_var($_GET,'account_id'),
			"viewType" => array_var($_GET,'view_type'),
			"classifType" => array_var($_GET,'classif_type'),
			"readType" => array_var($_GET,'read_type'),
			"stateType" => array_var($_GET,'state_type'),
			"moveTo" => array_var($_GET, 'moveTo'),
			"mantainWs" => array_var($_GET, 'mantainWs'),
		);
		$order = array_var($_GET,'sort');
		switch ($order){
			case 'title':
				$order = '`subject`';
			break;
			case 'accountName':
				$order = '`account_email`';
			break;
			case 'from':
				$order = '`from_name`, `from`';
			break;
			case 'date':
				$order = '`sent_date`';
			break;
			case 'folder':
				$order = '`imap_folder_name`';
			break;
			default:
				$order = '`sent_date`';
			break;
		}
		$dir = array_var($_GET,'dir');
		if (! $dir == 'ASC' ||! $dir == 'DEC') {
			$dir = 'ASC';
		}
		//Resolve actions to perform
		$actionMessage = array();
		if (isset($action)) {
			$actionMessage = $this->resolveAction($action, $attributes);
			if ($actionMessage["errorCode"] == 0) {
				flash_success($actionMessage["errorMessage"]);
			} else {
				flash_error($actionMessage["errorMessage"]);
			}
		}

		// Get all emails to display
		$pid = array_var($_GET, 'active_project', 0);
		$project = Projects::findById($pid);
		$emails = $this->getEmails($tag, $attributes, $project, $start, $limit, $order, $dir, $total);
		
		// Prepare response object
		$object = $this->prepareObject($emails, $start, $limit, $total);
		ajx_extra_data($object);
		tpl_assign("listing", $object);
	}


	/**
	 * Returns a list of emails according to the requested parameters
	 *
	 * @param string $action
	 * @param string $tag
	 * @param array $attributes
	 * @param Project $project
	 * @return array
	 */
	private function getEmails($tag, $attributes, $project = null, $start = null, $limit = null, $order_by = 'sent_date', $dir = 'ASC', &$totalCount = 0) {
		// Return if no emails should be displayed
		if (!isset($attributes["viewType"]) || ($attributes["viewType"] != "all" && $attributes["viewType"] != "emails")) return null;
		$account = array_var($attributes, "accountId");
		$classif_filter = array_var($attributes, 'classifType', '');
		$read_filter = array_var($attributes, 'readType', '');
		$state = array_var($attributes, 'stateType');
		list($objects, $pagination) = MailContents::getEmails($tag, $account, $state, $read_filter, $classif_filter, $project, $start, $limit, $order_by, $dir);
		$totalCount = $pagination->getTotalItems();
		return $objects;
	}

	 
	/**
	 * Prepares return object for a list of emails and messages
	 *
	 * @param array $totMsg
	 * @param integer $start
	 * @param integer $limit
	 * @return array
	 */
	private function prepareObject($totMsg, $start, $limit, $total, $attributes = null) {
		$object = array(
			"totalCount" => intval($total),
			"start" => $start,//(integer)min(array(count($totMsg) - (count($totMsg) % $limit),$start)),
			"messages" => array()
		);
		for ($i = 0; $i < $limit; $i++) {
			if (isset($totMsg[$i])) {
				$msg = $totMsg[$i];
				if ($msg instanceof MailContent) {/* @var $msg MailContent */
					$text = $msg->getBodyPlain();
					// plain body is already converted to UTF-8 (when mail was saved)
					if (strlen_utf($text) > 100) {
						$text = substr_utf($text, 0, 100) . "...";
					}
					$object["messages"][] = array(
					    "id" => $i,
						"object_id" => $msg->getId(),
						"type" => 'email',
						"hasAttachment" => $msg->getHasAttachments(),
						"accountId" => $msg->getAccountId(),
						"accountName" => ($msg->getAccount() != null ? $msg->getAccount()->getName() : lang('n/a')),
						"projectId" => $msg->getWorkspacesIdsCSV(logged_user()->getWorkspacesQuery()),
						"projectName" => $msg->getWorkspacesNamesCSV(logged_user()->getWorkspacesQuery()),
						"workspaceColors" => $msg->getWorkspaceColorsCSV(logged_user()->getWorkspacesQuery()),
						"subject" => $msg->getSubject(),
						"text" => $text,
						"date" => ($msg->getSentDate() != null ? $msg->getSentDate()->getTimestamp() : ($msg->getCreatedOn() instanceof DateTimeValue ? $msg->getCreatedOn()->getTimestamp() : 0)),
						"userId" => ($msg->getAccount() != null ? $msg->getAccount()->getOwner()->getId() : 0),
						"userName" => ($msg->getAccount() != null ? $msg->getAccount()->getOwner()->getDisplayName() : lang('n/a')),
						"tags" => project_object_tags($msg),
						"isRead" => $msg->getIsRead(logged_user()->getId()),
						"from" => $msg->getFromName()!=''?$msg->getFromName():$msg->getFrom(),
						"from_email" => $msg->getFrom(),
						"isDraft" => $msg->getIsDraft(),
						"isSent" => $msg->getIsSent(),
						"folder" => $msg->getImapFolderName()
					);
				}
			}
		}
		return $object;
	}



	/**
	 * Resolve action to perform
	 *
	 * @param string $action
	 * @param array $attributes
	 * @return string $message
	 */
	private function resolveAction($action, $attributes){
		$resultMessage = "";
		$resultCode = 0;
		switch ($action){
			case "delete":
				$err = 0; $succ = 0;
				for($i = 0; $i < count($attributes["ids"]); $i++){
					$id = $attributes["ids"][$i];
					$type = $attributes["types"][$i];
						
					switch ($type){
						case "email":
							$email = MailContents::findById($id);
							if (isset($email) && $email->canDelete(logged_user())){
								try{
									DB::beginWork();
									$email->trash(null);
									ApplicationLogs::createLog($email, $email->getWorkspaces(), ApplicationLogs::ACTION_TRASH);
									DB::commit();
									$succ++;
								} catch(Exception $e){
									DB::rollback();
									$err++;
								}
							} else {
								$err++;
							}
							break;
								
						default:
							$err++;
							break;
					} // switch
				} // for
				if ($err > 0) {
					$resultCode = 2;
					$resultMessage = lang("error delete objects", $err) . "<br />" . ($succ > 0 ? lang("success delete objects", $succ) : "");
				} else {
					$resultMessage = lang("success delete objects", $succ);
				}
				ajx_add("overview-panel", "reload");
				break;

			case "tag":
				$tag = $attributes["tag"];
				for($i = 0; $i < count($attributes["ids"]); $i++){
					$id = $attributes["ids"][$i];
					$type = $attributes["types"][$i];
					switch ($type){
						case "email":
							$email = MailContents::findById($id);
							if (isset($email) && $email->canEdit(logged_user())){
								Tags::addObjectTag($tag, $email);
								ApplicationLogs::createLog($email, $email->getWorkspaces(), ApplicationLogs::ACTION_TAG,false,null,true,$tag);
								$resultMessage = lang("success tag objects", '');
							};
							break;

						default:
							$resultMessage = lang("Unimplemented type: '" . $type . "'");// if
							$resultCode = 2;
							break;
					}; // switch
				}; // for
				break;
				
			case "move":

				$wsid = $attributes["moveTo"];
				$destination = Projects::findById($wsid);
							
				$project_ids = $wsid;
				$enteredWS = Projects::findByCSVIds($project_ids);
				$validWS = array();
				if (isset($enteredWS)) {
					foreach ($enteredWS as $ws) {
						if (ProjectFile::canAdd(logged_user(), $ws)) {
							$validWS[] = $ws;
						}
					}
				}
		
				if (!$destination instanceof Project) {
					$resultMessage = lang('project dnx');
					$resultCode = 1;
				} else if (!can_add(logged_user(), $destination, 'MailContents')) {
					$resultMessage = lang('no access permissions');
					$resultCode = 1;
				} else {
					$count = 0;
					$active = active_project();
					if ($active instanceof Project) {
						$ws_ids = $active->getAllSubWorkspacesQuery(true, logged_user());
					} else {
						$ws_ids = logged_user()->getWorkspacesQuery();
					}
					for($i = 0; $i < count($attributes["ids"]); $i++){
						$id = $attributes["ids"][$i];
						$type = $attributes["types"][$i];
						switch ($type){
							case "email":
								$count += $this->addEmailToWorkspace($id, $destination, $ws_ids, $attributes["mantainWs"]);
							
								$email = MailContents::findById($id);											
								MailUtilities::parseMail($email->getContent(), $decoded, $parsedEmail, $warnings);
								$classification_data = array();
								for ($j=0; $j < count(array_var($parsedEmail, "Attachments", array())); $j++)
								{
									$classification_data["att_".$j] = true;		
								}
								$this->classifyFile($classification_data, $email, $parsedEmail, $validWS, $attributes["mantainWs"]);
								break;	
							default:
								$resultMessage = lang("Unimplemented type: '" . $type . "'");// if
								$resultCode = 2;
								break;
						}; // switch
					}; // for
					$resultMessage = lang("success move objects", $count);
					$resultCode = 0;
				}
				break;
				
			case "checkmail":
				$resultCheck = MailController::checkmail();
				$resultMessage = $resultCheck[1];// if
				$resultCode = $resultCheck[0];
				ajx_add("overview-panel", "reload");
				break;

			case "markAsRead":
			case "markAsUnRead":
				for($i = 0; $i < count($attributes["ids"]); $i++){
					$id = $attributes["ids"][$i];
					$type = $attributes["types"][$i];
					switch ($type){
						case "email":
							$email = MailContents::findById($id);
							if (isset($email) && $email->canEdit(logged_user())){
								try{
									DB::beginWork();
									$email->setIsRead($action=='markAsRead'?1:0,logged_user()->getId());
									DB::commit();
									$resultMessage = lang("success mark objects", '');
								} catch(Exception $e){
									DB::rollback();
									$resultMessage .= $e->getMessage();
									$resultCode = $e->getCode();
								}
							};
							break;

						default:
							$resultMessage = lang("Unimplemented type: '" . $type . "'");// if
							$resultCode = 2;
							break;
					}; // switch
				}; // for

				ajx_add("overview-panel", "reload");
				break;
					
			default:
				$resultMessage = lang("Unimplemented action: '" . $action . "'");// if
				$resultCode = 2;
				break;
		} // switch
		return array("errorMessage" => $resultMessage, "errorCode" => $resultCode);
	}
	
	function addEmailToWorkspace($id, $destination, $ws_ids, $mantainWs = true) {
		$email = MailContents::findById($id);
		if ($email instanceof MailContent && $email->canEdit(logged_user())){
			if (!$mantainWs) {
				$ws = $email->getWorkspaces($ws_ids);
				foreach ($ws as $w) {
					if (can_add(logged_user(), $w, 'MailContents')) {
						$email->removeFromWorkspace($w);
					}
				}
			}
			$email->addToWorkspace($destination);
			ApplicationLogs::createLog($email, $email->getWorkspaces(), ApplicationLogs::ACTION_EDIT);
			return 1;
		} else return 0; 
	}

	function fetch_imap_folders() {
		$server = array_var($_GET, 'server');
		$ssl = array_var($_GET, 'ssl') == "checked";
		$port = array_var($_GET, 'port');
		$email = array_var($_GET, 'email');
		$pass = array_var($_GET, 'pass');
		$genid = array_var($_GET, 'genid');

		$account = new MailAccount();
		$account->setIncomingSsl($ssl);
		$account->setIncomingSslPort($port);
		$account->setEmail($email);
		$account->setPassword(MailUtilities::ENCRYPT_DECRYPT($pass));
		$account->setServer($server);

		$real_folders = MailUtilities::getImapFolders($account);
		$imap_folders = array();
		foreach ($real_folders as $folder_name) {
			$acc_folder = new MailAccountImapFolder();
			$acc_folder->setAccountId(0);
			$acc_folder->setFolderName($folder_name);
			$acc_folder->setCheckFolder($folder_name == 'INBOX');// By default only INBOX is checked
			$imap_folders[] = $acc_folder;
		}
		tpl_assign('imap_folders', $imap_folders);
		tpl_assign('genid', $genid);
	}

} // MailController

?>