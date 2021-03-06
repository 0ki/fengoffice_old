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
		$default_account = MailAccountUsers::findOne(array('conditions' => array('`user_id` = ? AND `is_default` = ?', $user->getId(), true)));
		if ($default_account instanceof MailAccountUser && $default_account->getAccount() instanceof MailAccount) {
			return $default_account->getAccount()->getId();
		}
		return 0;
	}
	
	private function build_original_mail_info($original_mail, $type = 'plain') {
		$loc = new Localization();
		$loc->setDateTimeFormat("D, d M Y H:i:s O");
		if ($type == 'plain') {
			$str = "\n\n----- ".lang('original message')."-----\n".lang('mail from').": ".$original_mail->getFrom()."\n".lang('mail to').": ".$original_mail->getTo()."\n".lang('mail sent').": ".$loc->formatDateTime($original_mail->getSentDate(), logged_user()->getTimezone())."\n".lang('mail subject').": ".$original_mail->getSubject()."\n\n";
		} else {
			$str = "<br><br><table><tr><td>----- ".lang('original message')." -----</td></tr><tr><td>".lang('mail from').": ".$original_mail->getFrom()."</td></tr><tr><td>".lang('mail to').": ".$original_mail->getTo()."</td></tr><tr><td>".lang('mail sent').": ".$loc->formatDateTime($original_mail->getSentDate(), logged_user()->getTimezone())."</td></tr><tr><td>".lang('mail subject').": ".$original_mail->getSubject()."</td></tr></table><br>";
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
			$re_subject = str_starts_with(strtolower($original_mail->getSubject()), 're:') ? $original_mail->getSubject() : 'Re: ' . $original_mail->getSubject();
			
			if ($original_mail->getBodyHtml() != '') $type = 'html';
			else $type = user_config_option('last_mail_format');
			if (!$type) $type = 'plain';
			
			$re_body = $original_mail->getBodyHtml() != '' && $type == 'html' ? $original_mail->getBodyHtml() : $original_mail->getBodyPlain();
			if ($type == 'html') {
				$pre_quote = "<blockquote type='cite' style='padding:0 10px; border-left: 1px solid #987ADD;'>";
				$post_quote = "</blockquote>";
			} else {
				$pre_quote = "";
				$post_quote = "";
				$lines = explode("\n", $re_body);
				$re_body = "";
				foreach($lines as $line) {
					$re_body .= ">$line\n";
				}
			}
			if ($original_mail->getBodyHtml() == '' && $type == 'html') {
				$re_body = str_replace("\n", "<br>", $re_body);
			}
			$re_info = $this->build_original_mail_info($original_mail, $type);
			
			$pos = stripos($re_body, "<body");
			if ($pos !== FALSE) {
				$pos = stripos($re_body, ">", $pos);
			}
			
			if ($pos !== FALSE) {
				$re_body = substr($re_body, 0, $pos+1) . $re_info . $pre_quote . substr($re_body, $pos+1) . $post_quote;
			} else {
				$re_body = $re_info . $pre_quote . $re_body . $post_quote;
			}
			$re_body = $re_body;
			
			// Put original mail images in the reply
			if ($original_mail->getBodyHtml() != '') {
				MailUtilities::parseMail($original_mail->getContent(), $decoded, $parsedEmail, $warnings);
				$tmp_folder = "/tmp/" . $original_mail->getId() . "_reply";
				if (is_dir(ROOT . $tmp_folder)) remove_dir(ROOT . $tmp_folder);
				$re_body = self::rebuild_body_html($re_body, $decoded[0]['Parts'], $tmp_folder);
			}
			
			$to = $original_mail->getFrom();
			$cc = "";
			$my_address = $original_mail->getAccount()->getEmailAddress();
			if (array_var($_GET,'all','') != '') {
				if ($original_mail->getFrom() != $my_address) {
					$cc = $original_mail->getTo() . "," . $original_mail->getCc();
					$regexp = '/[^\,]*' . preg_quote($my_address) . '[^,]*/';
					$cc = preg_replace($regexp, "", $cc);
					$cc = preg_replace('/\,\s*?\,/', ',', $cc);
					$cc = trim($cc, ',');
					$to = $original_mail->getFrom();
				} else {
					$cc = $original_mail->getCc();
					$to = $original_mail->getTo();
				}
			}

			$mail_data = array(
				'to' => $to,
				'cc' => $cc,
				'type' => $type,
				'subject' => $re_subject,
				'account_id' => $original_mail->getAccountId(),
				'body' => $re_body,
				'conversation_id' => $original_mail->getConversationId(),
				'in_reply_to_id' => $original_mail->getMessageId(),
				'original_id' => $original_mail->getId(),
				'last_mail_in_conversation' => MailContents::getLastMailIdInConversation($original_mail->getConversationId(), true),
			); // array
		} // if
		$mail_accounts = MailAccounts::getMailAccountsByUser(logged_user());
		tpl_assign('mail', $mail);
		tpl_assign('mail_data', $mail_data);
		tpl_assign('mail_accounts', $mail_accounts);
	}
	
	private function checkRequiredCustomPropsBeforeSave($custom_props) {
		$errors = array();
		if (is_array($custom_props)) {
			foreach ($custom_props as $id => $value) {
				$cp = CustomProperties::findById($id);
				if (!$cp) continue;
				if ($cp->getIsRequired() && $value == '') {
					 $errors[] = lang('custom property value required', $cp->getName());
				}
			}
		}
		return $errors;
	}
	
	function change_email_folder() {
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
		}
		
		$folder = array_var($_GET, 'newf');
		if (is_numeric($folder)) {
			try {
				DB::beginWork();
				$email->setState($folder);
				$email->save();
				DB::commit();
				ajx_current("back");
				return;
			} catch(Exception $e) {
				DB::rollback();
				flash_error($e->getMessage());
				ajx_current("empty");
				return;
			}
		} else {
			flash_error($e->getMessage());
			ajx_current("empty");
			return;
		}
	}

	/**
	 * Add single mail
	 *
	 * @access public
	 * @param void
	 * @return null
	 */
	function add_mail() {
		$this->addHelper('textile');
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
		
		tpl_assign('mail_to', urldecode(array_var($_GET, 'to')));
		tpl_assign('link_to_objects', array_var($_GET, 'link_to_objects'));

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
			$accountUser = MailAccountUsers::getByAccountAndUser($account, logged_user());
			if (!$accountUser instanceof MailAccountUser) {
				flash_error(lang('no access permissions'));
				ajx_current("empty");
				return;
			}
			if ($account->getOutgoingTrasnportType() == 'ssl' || $account->getOutgoingTrasnportType() == 'tls') {
				$available_transports = stream_get_transports();
				if (array_search($account->getOutgoingTrasnportType(), $available_transports) === FALSE) {
					flash_error('The server does not support SSL.');
					ajx_current("empty");
					return;
				}
			}
			$cp_errs = $this->checkRequiredCustomPropsBeforeSave(array_var($_POST, 'object_custom_properties', array()));
			if (is_array($cp_errs) && count($cp_errs) > 0) {
				foreach ($cp_errs as $err) {
					flash_error($err);
				}
				ajx_current("empty");
				return;
			}

			$subject = array_var($mail_data, 'subject');
			$body = array_var($mail_data, 'body');
			if (array_var($mail_data, 'format') == 'html') {
				$css = "font-family:Arial,Verdana,sans-serif;font-size:12px;color:#222;";
				Hook::fire('email_base_css', null, $css);
				str_replace(array("\r","\n"), "", $css);
				$body = '<div style="' . $css . '">' . $body . '</div>';
				$body = str_replace('<blockquote>', '<blockquote style="border-left:1px solid #987ADD;padding-left:10px;">', $body);
			}
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
			
			if (!$isDraft && trim($to.$cc.$bcc) == '') {
				flash_error(lang('recipient must be specified'));
				ajx_current("empty");
				return;
			}
			
			$last_mail_in_conversation = array_var($mail_data, 'last_mail_in_conversation');
			$conversation_id = array_var($mail_data, 'conversation_id');
			if ($last_mail_in_conversation && $conversation_id) {
				$new_mail_in_conversation = MailContents::getLastMailIdInConversation($conversation_id, true);
				if ($new_mail_in_conversation != $last_mail_in_conversation) {
					ajx_current("empty");
					evt_add("new email in conversation", array(
						'id' => $new_mail_in_conversation,
						'genid' => array_var($_POST, 'instanceName')
					));
					return;
				}
			}
			
			$mail->setFromAttributes($mail_data);
				
			$utils = new MailUtilities();
			
			// attachment
			$linked_attachments = array();
 			$attachments = array();
 			$objects = array_var($_POST, 'linked_objects');
 			$attach_contents = array_var($_POST, 'attach_contents', array());
 			
 			if (is_array($objects)) {
 				$err = 0;
 				$count = -1;
 				foreach ($objects as $objid) {
 					$count++;
 					$split = explode(":", $objid);
 					if (count($split) == 2) {
 						$object = get_object_by_manager_and_id($split[1], $split[0]);
 					} else if (count($split) == 4) {
 						if ($split[0] == 'FwdMailAttach') {
 							$tmp_filename = ROOT . "/tmp/" . logged_user()->getId() . "_" . $mail_data['account_id'] . "_FwdMailAttach_" . $split[3];
 							if (is_file($tmp_filename)) {	 						
	 							$attachments[] = array(
			 						"data" => file_get_contents($tmp_filename),
			 						"name" => $split[1],
			 						"type" => $split[2]
			 					);
			 					continue;
 							}
 						}
 					}
 					
 					if (!isset($object) || !$object) {
 						flash_error(lang('file dnx'));
	 					$err++;
 					} else {
	 					if (isset($attach_contents[$count])) {
	 						if ($split[0] == 'ProjectFiles') {
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
	 						} else if ($split[0] == 'MailContents') {
	 							$email = MailContents::findById($object->getId());
			 					if (!($email instanceof MailContent)) {
			 						flash_error(lang('email dnx'));
			 						$err++;
			 					} // if
			 					if(!$email->canView(logged_user())) {
			 						flash_error(lang('no access permissions'));
			 						$err++;
			 					} // if
			 
			 					$attachments[] = array(
			 						"data" => $email->getContent(),
			 						"name" => $email->getSubject() . ".eml",
			 						"type" => 'message/rfc822'
			 					);
	 						}
	 					} else {
	 						$linked_attachments[] = array(
		 						"data" => $object->getViewUrl(),
		 						"name" => $object->getObjectName(),
		 						"type" => lang($object->getObjectTypeName())
		 					);
	 					}
 					}
 				}
 				if ($err > 0) {
 					flash_error(lang('some objects could not be linked', $err));
 					ajx_current('empty');
 					return;
 				}
 			}
				
			$to = explode(",", $to);
			$to = $utils->parse_to($to);
			
			if ($body == '') $body.=' ';

			try {
				if (count($linked_attachments)) {
					$linked_atts = $type == 'text/html' ? '<div style="font-family:arial;"><br><br><br><span style="font-size:12pt;font-weight:bold;color:#777">'.lang('linked attachments').'</span><ul>' : "\n\n\n-----------------------------------------\n".lang('linked attachments')."\n\n";
					foreach ($linked_attachments as $att) {
						$linked_atts .= $type == 'text/html' ? '<li><a href="'.$att['data'].'">' . $att['name'] . ' (' . $att['type'] . ')</a></li>' : $att['name'] . ' (' . $att['type'] . '): ' . $att['data'] . "\n";
					}
					$linked_atts .= $type == 'text/html' ? '</ul></div>' : '';
				} else $linked_atts = '';
				$body .= $linked_atts;
				
				if (count($attachments) > 0) {
					$i = 0;
					$str = "";
					foreach ($attachments as $att) {
						$str .= "--000000000000000000000000000$i\n";
						$str .= "Name: ".$att['name'] .";\n";
						$str .= "Type: ".$att['type'] .";\n";
						//$str .= "Encoding: ".$att['type'] .";\n";
						$str .= base64_encode($att['data']) ."\n";
						$str .= "--000000000000000000000000000$i--\n";
						$i++;
					}
					// save attachments, when mail is sent this file is deleted and full content is saved
					$repository_id = $utils->saveContent($str);
					if (!$isNew) {
						if (FileRepository::isInRepository($mail->getContentFileId())) {
							FileRepository::deleteFile($mail->getContentFileId());
						}
					}
					$mail->setContentFileId($repository_id);
				}

				$mail->setHasAttachments((is_array($attachments) && count($attachments) > 0) ? 1 : 0);
				$mail->setAccountEmail($account->getEmailAddress());

 				$mail->setSentDate(DateTimeValueLib::now());
 				$mail->setReceivedDate(DateTimeValueLib::now());
 				
				DB::beginWork();
				
				$msg_id = MailUtilities::generateMessageId($account->getEmailAddress());
				$conversation_id = array_var($mail_data, 'conversation_id');
				$in_reply_to_id = array_var($mail_data, 'in_reply_to_id');
				if ($conversation_id) {
					$in_reply_to = MailContents::findById(array_var($mail_data, 'original_id'));
					if ($in_reply_to instanceof MailContent && $in_reply_to->getSubject() && strpos(strtolower($mail->getSubject()), strtolower($in_reply_to->getSubject())) === false) {
						$conversation_id = null;
						$in_reply_to_id = '';
					}
				}
				if (!$conversation_id) $conversation_id = MailContents::getNextConversationId($account->getId());;
				
				
				$mail->setMessageId($msg_id);
				$mail->setConversationId($conversation_id);
				$mail->setInReplyToId($in_reply_to_id);
				
				$mail->setUid(gen_id());
				$mail->setState($isDraft ? 2 : 200);
				$mail->setIsPrivate(false);
				
				set_user_config_option('last_mail_format', array_var($mail_data, 'format', 'plain'), logged_user()->getId());
				$body = utf8_safe($body);
				if (array_var($mail_data,'format') == 'html') {
					$mail->setBodyHtml($body);
					$mail->setBodyPlain(utf8_safe(html_to_text($body)));
				} else {
					$mail->setBodyPlain($body);
					$mail->setBodyHtml('');
				}
				$mail->setFrom($account->getEmailAddress());
				$mail->setFromName(logged_user()->getDisplayName());

				$mail->save();
				$mail->setIsRead(logged_user()->getId(), true);
				$mail->setTagsFromCSV(array_var($mail_data, 'tags'));
				
				// autoclassify sent email
				// if replying a classified email classify on same workspace
				$classified = false;
				if ($in_reply_to_id) {
					$in_reply_to = MailContents::findById(array_var($mail_data, 'original_id'));
					if ($in_reply_to instanceof MailContent) {
						$workspaces = $in_reply_to->getWorkspaces();
						foreach ($workspaces as $w) {
							if ($mail->canAdd(logged_user(), $w)) {
								$mail->addToWorkspace($w);
								$classified = true;
							}
						}
					}
				}
				if (!$classified && $account->getWorkspace() instanceof Project) {
					$mail->addToWorkspace($account->getWorkspace());
				}

				$object_controller = new ObjectController();
				$object_controller->add_custom_properties($mail);
				$object_controller->link_to_new_object($mail);

				if (array_var($mail_data, 'link_to_objects') != ''){
					$lto = explode('|', array_var($mail_data, 'link_to_objects'));
					foreach ($lto as $object_string){
						$split_object = explode('-', $object_string);
						$object = get_object_by_manager_and_id($split_object[1], $split_object[0]);
						if ($object instanceof ProjectDataObject){
							$mail->linkObject($object);
						}
					}
				}
				ApplicationLogs::createLog($mail, $mail->getWorkspaces(), ApplicationLogs::ACTION_ADD);
				
				if (user_config_option('create_contacts_from_email_recipients') && can_manage_contacts(logged_user())) {
					// automatically create contacts
					foreach ($to as $recipient) {
						$recipient_name = trim($recipient[0]);
						$recipient_address = trim($recipient[1]);
						if (!$recipient_address) continue;
						$contact = Contacts::getByEmail($recipient_address);
						if (!$contact instanceof Contact) {
							try {
								$contact = new Contact();
								$contact->setEmail($recipient_address);
								if ($recipient_name && $recipient_name != $recipient_address) {
									$contact->setFirstName($recipient_name);
								} else {
									$index = strpos($recipient_address, "@");
									$recipient_name = substr($recipient_address, 0, $index);
									$contact->setFirstName($recipient_name);
								}
								$contact->save();
							} catch (Exception $e) {
								// TODO: show error message?
							}
						}
					}
				}
				
				DB::commit();

				if (!$autosave) {
					if ($isDraft) {
						flash_success(lang('success save mail'));
						ajx_current("empty");
					} else {
						evt_add("must send mails", array("account" => $mail->getAccountId()));
						//flash_success(lang('mail is being sent'));
						ajx_current("back");
					}
					evt_add("email saved", array("id" => $mail->getId(), "instance" => array_var($_POST, 'instanceName')));
				} else {
					evt_add("draft mail autosaved", array("id" => $mail->getId(), "hf_id" => $mail_data['hf_id']));
					flash_success(lang('success autosave draft'));
					ajx_current("empty");
				}
			} catch(Exception $e) {
				DB::rollback();
				flash_error($e->getMessage());
				ajx_current("empty");
			} // try
		} // if
	} // add_mail

	private function readAttachmentsFromFileSystem(MailContent $mail) {
		if ($mail->getHasAttachments() && FileRepository::isInRepository($mail->getContentFileId())) {
					
			$attachments = array();
			$content = FileRepository::getFileContent($mail->getContentFileId());
			$i=0; $offset = 0;
			while ($offset < strlen($content)) {
				$delim = "--000000000000000000000000000$i";
				if (strpos($content, $delim, $offset) !== FALSE) {
					$offset = strpos($content, $delim) + strlen($delim);
					$endline = strpos($content, ";", $offset);
					$name = substr($content, $offset + 1, $endline - $offset - 1);
					$pos = strpos($name, ":");
					$name = trim(substr($name, $pos+1, strlen($name) - $pos - 1));
					
					$offset = $endline + 1;
					$endline = strpos($content, ";", $offset);
					$type = substr($content, $offset + 1, $endline - $offset - 1);
					$pos = strpos($type, ":");
					$type = trim(substr($type, $pos+1, strlen($type) - $pos - 1));
					
					/*$offset = $endline + 1;
					$endline = strpos($content, ";", $offset);
					$encoding = substr($content, $offset + 1, $endline - $offset - 1);
					$pos = strpos($encoding, ":");
					$encoding = trim(substr($type, $pos+1, strlen($type) - $pos - 1));*/

					$offset = $endline + 1;
					$endline = strpos($content, "$delim--");
					$data = trim(substr($content, $offset, strpos($content, "$delim--") - $offset - 1));
					$attachments[] = array('name' => $name, 'type' => $type, 'data' => base64_decode($data));

					$offset = strpos($content, "$delim--") + strlen("$delim--")+1;
				} else break;
				$i++;
			}
		} else $attachments = null;
		
		return $attachments;
	}
	
	function send_outbox_mails() {
		session_commit();
		set_time_limit(0);
		
		$utils = new MailUtilities();
		
		if (!array_var($_GET, 'acc_id')) {
			$userAccounts = MailAccounts::getMailAccountsByUser(logged_user());
		} else {
			$account = MailAccounts::findById(array_var($_GET, 'acc_id'));
			$userAccounts = array($account);
		}
		
		foreach ($userAccounts as $account) {
			
			$accountUser = MailAccountUsers::getByAccountAndUser($account, logged_user());
			
			if (!$account || !$accountUser) {
				flash_error(lang('no access permissions'));
				ajx_current("empty");
				return;
			}
			$errorMailId = 0;
			
			try {
				DB::beginWork();
				$mails = MailContents::findAll(array("conditions" => array("`state` >= 200 AND `account_id` = ? AND `created_by_id` = ?", $account->getId(), logged_user()->getId())));
				foreach ($mails as $mail) {
					$errorMailId = $mail->getId();
					$to = explode(",", $mail->getTo());
					$from = $account->getFromName() . " <" . $account->getEmailAddress() . ">";
					$subject = $mail->getSubject();
					$body = $mail->getBodyHtml() != '' ? $mail->getBodyHtml() : $mail->getBodyPlain();
					$cc = $mail->getCc();
					$bcc = $mail->getBcc();
					$type = $mail->getBodyHtml() != '' ? 'text/html' : 'text/plain';
					$msg_id = $mail->getMessageId();
					$in_reply_to_id = $mail->getInReplyToId();
	
					$attachments = self::readAttachmentsFromFileSystem($mail);
					
					if ($mail->getBodyHtml() != '') {
						$images = get_image_paths($body);
					} else {
						$images = null;
					}
					
					$sentOK = $utils->sendMail($account->getSmtpServer(), $to, $from, $subject, $body, $cc, $bcc, $attachments, $account->getSmtpPort(), $account->smtpUsername(), $account->smtpPassword(), $type, $account->getOutgoingTrasnportType(), $msg_id, $in_reply_to_id, $images, $complete_mail);

					if ($sentOK) {
						if (FileRepository::isInRepository($mail->getContentFileId())) {
							FileRepository::deleteFile($mail->getContentFileId());
						}
						
						//$content = $utils->getContent($account->getSmtpServer(), $account->getSmtpPort(), $account->getOutgoingTrasnportType(), $account->smtpUsername(), $account->smtpPassword(), $body, $attachments);
						$content = $complete_mail;
						$repository_id = $utils->saveContent($content);
						
						$mail->setContentFileId($repository_id);
						$mail->setSize(strlen($content));
						$mail->setState(3);
						$mail->setSentDate(DateTimeValueLib::now());
						$mail->setReceivedDate(DateTimeValueLib::now());
						$mail->save();
						evt_add("mail sent", array("mail_id" => $mail->getId()));
					} else {
						throw new Exception(lang('send mail error'));
					}
				}
				DB::commit();
			} catch (Exception $e) {
				DB::rollback();
				
				//Change email state
				$errorEmailUrl = '';
				if ($errorMailId > 0){
					$email = MailContents::findById($errorMailId);
					if ($email instanceof MailContent){
						DB::beginWork();
						$email->setState(2);
						$email->save();
						DB::commit();
						
						$errorEmailUrl = $email->getEditUrl();
					}
				}
				
				flash_error($errorEmailUrl != '' ? ($e->getMessage() /*. '<br/><a href="' . $errorEmailUrl . '">' . lang('view email') . '</a>'*/) : $e->getMessage());
				ajx_current("empty");
			}
		}
		ajx_current("empty");
	}
	
	function mark_as_unread() {
		ajx_current("empty");
		$email = MailContents::findById(array_var($_GET, 'id', 0));
		if ($email instanceof MailContent) {
			$email->setIsRead(logged_user()->getId(), false);
			ajx_current("back");
		} else {
			flash_error(lang("email dnx"));
		}
	}
	
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
			$tmp_folder = "/tmp/" . $email->getAccountId() . "_" . logged_user()->getId() . "_temp_mail_content_res";
			if (is_dir(ROOT . $tmp_folder)) remove_dir(ROOT . $tmp_folder);
			$parts_array = array_var($decoded, 0, array('Parts' => ''));
			$email->setBodyHtml(self::rebuild_body_html($email->getBodyHtml(), $parts_array['Parts'], $tmp_folder));
		}
		
		tpl_assign('attachments', $attachments);
		ajx_extra_data(array("title" => $email->getSubject(), 'icon' => 'ico-email'));
		ajx_set_no_toolbar(true);
		if (array_var($_GET, 'replace')) {
			ajx_replace(true);
		}

		$email->setIsRead(logged_user()->getId(),true);
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
		
		if ($this->do_unclassify($email) ) {
			flash_success(lang('success unclassify email'));
			ajx_current("back");
		} else {
			DB::rollback();
			Logger::log("Error: Unclassify email\r\n".$e->getMessage());
			flash_error(lang('error unclassify email'));
			ajx_current("empty");
		}
	}
	
	function do_unclassify($email) {
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
		
			return true;
		} catch (Exception $e) {
			DB::rollback();
			return false;
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

		MailUtilities::parseMail($email->getContent(), $decoded, $parsedEmail, $warnings);

		$projects = logged_user()->getActiveProjects();
		tpl_assign('projects', $projects);

		$classification_data = array_var($_POST, 'classification');
		if(!is_array($classification_data)) {
			$tag_names = $email->getTagNames();
			$classification_data = array(
          'tag' => is_array($tag_names) ? implode(', ', $tag_names) : '',
			); // array
		} // if
		if (is_array(array_var($_POST, 'classification'))){
			try {
				$create_task = array_var($classification_data, 'create_task') == 'checked';
				
				$canWriteFiles = $this->checkFileWritability($classification_data, $parsedEmail);
				if ($canWriteFiles) {
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
					
					DB::beginWork();
					$conversation = MailContents::getMailsFromConversation($email);
					foreach ($conversation as $conv_email) {

						$conv_email->removeFromWorkspaces(logged_user()->getWorkspacesQuery());
						foreach ($validWS as $w) {
							$conv_email->addToWorkspace($w);
						}
						$conv_email->save();
						
						MailUtilities::parseMail($conv_email->getContent(), $decoded, $parsedEmail, $warnings);
					
						$csv = array_var($classification_data, 'tag');
						$conv_email->setTagsFromCSV($csv);
					
						if ($conv_email->getHasAttachments()) {
							//Classify attachments
							$this->classifyFile($classification_data, $conv_email, $parsedEmail, $validWS, true, $csv);
						}
					}
					DB::commit();
					flash_success(lang('success classify email'));	
					if ($create_task) {
						ajx_replace(true);
						$this->redirectTo('task', 'add_task', array('from_email' => $email->getId(), 'replace' =>  1));
					} else {
						ajx_current("back");
					}
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

		if (!isset($parsedEmail["Attachments"])) throw new Exception(lang('no attachments found for email'));
		
		for ($c = 0; $c < count($classification_data); $c++) {
			if (isset($classification_data["att_".$c]) && $classification_data["att_".$c]) {
				$att = $parsedEmail["Attachments"][$c];
				$fName = iconv_mime_decode($att["FileName"], 0, "UTF-8");
				$tempFileName = ROOT ."/tmp/". logged_user()->getId()."x".gen_id();
				$fh = fopen($tempFileName, 'w') or die("Can't open file");
				fwrite($fh, $att["Data"]);
				fclose($fh);

				$file = ProjectFiles::findOne(array('conditions' => "`filename` = '".mysql_real_escape_string($fName)."' AND `mail_id` = ".$email->getId()));
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
				
				try {
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
	
	function show_html_mail() {
		$pre = array_var($_GET, 'pre');
		$filename = ROOT."/tmp/".$pre."_temp_mail_content.html";		
		if (!file_exists($filename)) {
			ajx_current("empty");
			return;
		}
		
		$content = file_get_contents($filename);		
		$encoding = detect_encoding($content, array('UTF-8', 'ISO-8859-1', 'WINDOWS-1252'));
		
		header("Expires: " . gmdate("D, d M Y H:i:s", mktime(date("H") + 2, date("i"), date("s"), date("m"), date("d"), date("Y"))) . " GMT");
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		header("Content-Type: text/html;charset=".$encoding);
		header("Content-Length: " . (string) strlen($content));
		
		print($content);
		die();		
	}

	function checkFileWritability($classification_data, $parsedEmail){
		$c = 0;
		while(isset($classification_data["att_".$c]))
		{
			if ($classification_data["att_".$c])
			{
				$att = $parsedEmail["Attachments"][$c];
				$fName = iconv_mime_decode($att["FileName"], 0, "UTF-8");
				$tempFileName = ROOT ."/tmp/". logged_user()->getId()."x".$fName;
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
		@set_time_limit(0);
		$accounts = MailAccounts::getMailAccountsByUser(logged_user());

		session_commit();
		if (is_array($accounts) && count($accounts) > 0){
			// check a maximum of $max emails per account
			$max = config_option("user_email_fetch_count", 10);
			MailUtilities::getmails($accounts, $err, $succ, $errAccounts, $mailsReceived, $max);

			$errMessage = "";
			if ($succ > 0) {
				$errMessage = lang('success check mail', $mailsReceived);
			}
			if ($err > 0){
				foreach($errAccounts as $error) {
					$errMessage .= lang('error check mail', $error["accountName"], $error["message"]);
				}
			}
			if ($succ > 0) $err = 0;
		} else {
			$err = 1;
			$errMessage = lang('no mail accounts set for check');
		}
		
		ajx_add("overview-panel", "reload");

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

		// get mail account users
		$mau = array(
			logged_user()->getId() => array(
				'name' => logged_user()->getDisplayName(),
				'can_edit' => true,
			)
		);
		tpl_assign('mailAccountUsers', $mau);
		
		if(is_array(array_var($_POST, 'mailAccount'))) {
			$email_address = array_var(array_var($_POST, 'mailAccount'), 'email_addr');
			/*if (MailAccounts::findOne(array('conditions' => "`email` = '$email_address'")) != null) {
				flash_error(lang('email address already exists'));
				ajx_current("empty");
				return;
			}*/

			try {
				$mailAccount_data['user_id'] = logged_user()->getId();
				if (!array_var($mailAccount_data, 'del_mails_from_server', false)) $mailAccount_data['del_from_server'] = 0;
				$mailAccount->setFromAttributes($mailAccount_data);
				$mailAccount->setPassword(MailUtilities::ENCRYPT_DECRYPT($mailAccount->getPassword()));
				$mailAccount->setSmtpPassword(MailUtilities::ENCRYPT_DECRYPT($mailAccount->getSmtpPassword()));

				DB::beginWork();
				$mailAccount->save();
				
				// process users
				$account_users = logged_user()->getCompany()->getUsers();
				$user_access = array_var($_POST, 'user_access');
				foreach ($account_users as $account_user) {
					$user_id = $account_user->getId();
					$access = $user_access[$user_id];
					if ($access != 'none') {
						$account_user = new MailAccountUser();
						$account_user->setAccountId($mailAccount->getId());
						$account_user->setUserId($user_id);
						$account_user->setCanEdit($access == 'write');
						$account_user->save();
					}
				}

				if ($mailAccount->getIsImap() && is_array(array_var($_POST, 'check'))) {
					$real_folders = MailUtilities::getImapFolders($mailAccount);
					foreach ($real_folders as $folder_name) {
						if (!MailAccountImapFolders::findById(array('account_id' => $mailAccount->getId(), 'folder_name' => $folder_name))) {
							$acc_folder = new MailAccountImapFolder();
							$acc_folder->setAccountId($mailAccount->getId());
							$acc_folder->setFolderName($folder_name);
							$acc_folder->setCheckFolder($folder_name == 'INBOX');// By default only INBOX is checked
		
							$acc_folder->save();
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
				
				// personal settings
				if (array_var($_POST, 'is_default')) {
					$user_accounts = MailAccountUsers::getByUser(logged_user());
					foreach ($user_accounts as $acc) {
						if ($acc->getAccountId() != $mailAccount->getId()) {
							$acc->setIsDefault(false);
							$acc->save();				
						} else {
							$acc->setIsDefault(true);
							$acc->save();
						}
					}
				}
				$logged_user_settings = MailAccountUsers::getByAccountAndUser($mailAccount, logged_user());
				$logged_user_settings->setSignature(array_var($_POST, 'signature'));
				$logged_user_settings->setSenderName(array_var($_POST, 'sender_name'));
				$logged_user_settings->save();


				if ($mailAccount->canView(logged_user())) {
					evt_add("mail account added", array(
						"id" => $mailAccount->getId(),
						"name" => $mailAccount->getName(),
						"email" => $mailAccount->getEmail()
					));
				}

				// Restore old emails, if account was deleted and its emails weren't
				$old_emails = MailContents::findAll(array('conditions' => '`created_by_id` = ' . logged_user()->getId() . " AND `account_email` = '" . $mailAccount->getEmail() . "' AND `account_id` NOT IN (SELECT `id` FROM `" . TABLE_PREFIX . "mail_accounts`)"));
				if (isset($old_emails) && is_array($old_emails) && count($old_emails)) {
					foreach ($old_emails as $email) {
						$email->setAccountId($mailAccount->getId());
						$email->save();
					}
				}
				
				DB::commit();

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

		// get mail account users
		$mailAccountUsers = MailAccountUsers::getByAccount($mailAccount);
		$mau = array();
		foreach ($mailAccountUsers as $au) {
			$mau[$au->getUserId()] = array(
				'name' => $au->getUser()->getDisplayName(),
				'can_edit' => $au->getCanEdit(),
			);
		}
		tpl_assign('mailAccountUsers', $mau);
		
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
			  'workspace' => $mailAccount->getColumnValue('workspace',0),
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
				DB::beginWork();
				foreach ($real_folders as $folder_name) {
					if (!MailAccountImapFolders::findById(array('account_id' => $mailAccount->getId(), 'folder_name' => $folder_name))) {
						$acc_folder = new MailAccountImapFolder();
						$acc_folder->setAccountId($mailAccount->getId());
						$acc_folder->setFolderName($folder_name);
						$acc_folder->setCheckFolder($folder_name == 'INBOX');// By default only INBOX is checked
					 
						$acc_folder->save();
					}
				}
				DB::commit();
			} catch (Exception $e) {
				DB::rollback();
				flash_error($e->getMessage());
			}
			 
			$imap_folders = MailAccountImapFolders::getMailAccountImapFolders($mailAccount->getId());
			tpl_assign('imap_folders', $imap_folders);
		}

		tpl_assign('mailAccount', $mailAccount);
		tpl_assign('mailAccount_data', $mailAccount_data);

		if(array_var($_POST, 'submitted')) {
			try {
				DB::beginWork();
				$logged_user_settings = MailAccountUsers::getByAccountAndUser($mailAccount, logged_user());
				$logged_user_can_edit = $logged_user_settings instanceof MailAccountUser && $logged_user_settings->getCanEdit();
				if ($logged_user_can_edit) {
					if (!array_var($mailAccount_data, 'del_mails_from_server', false)) $mailAccount_data['del_from_server'] = 0;
					$mailAccount->setFromAttributes($mailAccount_data);
					$mailAccount->setPassword(MailUtilities::ENCRYPT_DECRYPT($mailAccount->getPassword()));
					$mailAccount->setSmtpPassword(MailUtilities::ENCRYPT_DECRYPT($mailAccount->getSmtpPassword()));
	
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
			
					$mailAccount->save();
					
					// process users
					$account_users = logged_user()->getCompany()->getUsers();
					$user_access = array_var($_POST, 'user_access');
					foreach ($account_users as $account_user) {
						$user_id = $account_user->getId();
						$access = array_var($user_access, $user_id, 'none');
						$account_user = MailAccountUsers::getByAccountAndUser($mailAccount, $account_user);
						if ($access != 'none') {
							if (!$account_user instanceof MailAccountUser) {
								$account_user = new MailAccountUser();
								$account_user->setAccountId($mailAccount->getId());
								$account_user->setUserId($user_id);
							}
							$account_user->setCanEdit($access == 'write');
							$account_user->save();
						} else if ($account_user instanceof MailAccountUser) {
							$account_user->delete();
						}
					}
					/*// delete any remaining ones
					$account_users = MailAccountUsers::getByAccount($mailAccount);
					foreach ($account_users as $account_user) {
						if ($access = array_var($user_access, $account_user->getId(), 'none') == 'none') {
							$account_user->delete();
						}
					}*/
					
					evt_add("mail account edited", array(
							"id" => $mailAccount->getId(),
							"name" => $mailAccount->getName(),
							"email" => $mailAccount->getEmail()
					));
				}
				
				// personal settings
				if (array_var($_POST, 'is_default')) {
					$user_accounts = MailAccountUsers::getByUser(logged_user());
					foreach ($user_accounts as $acc) {
						if ($acc->getAccountId() != $mailAccount->getId()) {
							$acc->setIsDefault(false);
							$acc->save();				
						} else {
							$acc->setIsDefault(true);
							$acc->save();
						}
					}
				}
				$logged_user_settings = MailAccountUsers::getByAccountAndUser($mailAccount, logged_user());
				if ($logged_user_settings instanceof MailAccountUser) { 
					$logged_user_settings->setSignature(array_var($_POST, 'signature'));
					$logged_user_settings->setSenderName(array_var($_POST, 'sender_name'));
					$logged_user_settings->save();
				}
				
				DB::commit();

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
		 
		$accounts = MailAccounts::getMailAccountsByUser(logged_user());
		 
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
		if (!$account instanceof MailAccount) {
			flash_error(lang('error delete mail account'));
			ajx_current("empty");
			return;
		}
		if (!$account->canDelete(logged_user())) {
			flash_error(lang('no access permissions'));
			ajx_current("empty");
			return;
		}
		$deleteMails = array_var($_GET, 'deleteMails', false);
		try {
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
			if (array_var($_GET, 'reload', false)) {
				ajx_current("reload");
			} else {
				ajx_current("back");
			}
    
		} catch(Exception $e) {
			DB::rollback();
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
			$fwd_subject = str_starts_with(strtolower($original_mail->getSubject()),'fwd:') ? $original_mail->getSubject() : 'Fwd: ' . $original_mail->getSubject();
			
			if ($original_mail->getBodyHtml() != '') $type = 'html';
			else $type = user_config_option('last_mail_format');
			if (!$type) $type = 'plain';
			
			$body = $original_mail->getBodyHtml() != '' && $type == 'html' ? $original_mail->getBodyHtml() : $original_mail->getBodyPlain();
			if ($type == 'html') {
				$pre_quote = "<blockquote type='cite' style='padding:0 10px; border-left-color:#987ADD;'>";
				$post_quote = "</blockquote>";
			} else {
				$pre_quote = "";
				$post_quote = "";
				$lines = explode("\n", $body);
				$body = "";
				foreach($lines as $line) {
					$body .= ">$line\n";
				}
			}
			if ($original_mail->getBodyHtml() == '' && $type == 'html') {
				$body = str_replace("\n", "<br>", $body);
			}
			$fwd_info = $this->build_original_mail_info($original_mail, $type);
						
			$pos = stripos($body, "<body");
			if ($pos !== FALSE) {
				$pos = stripos($body, ">", $pos);
			}
			
			if ($pos !== FALSE) {
				$fwd_body = substr($body, 0, $pos+1) . $fwd_info . $pre_quote . substr($body, $pos+1) . $post_quote;
			} else {
				$fwd_body = $fwd_info . $pre_quote . $body . $post_quote;
			}
			$fwd_body = $fwd_body;
			
			// Put original mail images in the forwarded mail
			if ($original_mail->getBodyHtml() != '') {
				MailUtilities::parseMail($original_mail->getContent(), $decoded, $parsedEmail, $warnings);
				$tmp_folder = "/tmp/" . $original_mail->getId() . "_fwd";
				if (is_dir(ROOT . $tmp_folder)) remove_dir(ROOT . $tmp_folder);
				$fwd_body = self::rebuild_body_html($fwd_body, $decoded[0]['Parts'], $tmp_folder);
			}
			
			//Attachs
			$attachs = array();
			if ($original_mail->getHasAttachments()) {
				$utils = new MailUtilities();
				if (!isset($parsedEmail)) {
					MailUtilities::parseMail($original_mail->getContent(), $decoded, $parsedEmail, $warns);
				}
				if (isset($parsedEmail['Attachments'])) $attachments = $parsedEmail['Attachments'];
				foreach($attachments as $att) {
					$fName = iconv_mime_decode($att["FileName"], 0, "UTF-8");
					$fileType = $att["content-type"];
					$fid = gen_id();
					$attachs[] = "FwdMailAttach:$fName:$fileType:$fid";
					file_put_contents(ROOT . "/tmp/" . logged_user()->getId() . "_" .$original_mail->getAccountId() . "_FwdMailAttach_$fid", $att['Data']);
				}
			}
			
			$mail_data = array(
	          'to' => '',
	          'subject' => $fwd_subject,
	          'body' => $fwd_body,
	          'type' => $type,
			  'attachs' => $attachs,
	          'account_id' => $original_mail->getAccountId()
			); // array
		} // if
		$mail_accounts = MailAccounts::getMailAccountsByUser(logged_user());
		tpl_assign('mail', $mail);
		tpl_assign('mail_data', $mail_data);
		tpl_assign('mail_accounts', $mail_accounts);
	}//forward_mail


	/**
	 * Edit email
	 *
	 * @param void
	 * @return null
	 */
	function edit_mail(){
		$this->setTemplate('add_mail');
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

			//Attachs
			$attachs = array();
			if ($original_mail->getHasAttachments()) {
				$attachments = self::readAttachmentsFromFileSystem($original_mail);
				foreach($attachments as $att) {
					$fName = $att["name"];
					$fileType = $att["type"];
					$fid = gen_id();
					$attachs[] = "FwdMailAttach:$fName:$fileType:$fid";
					file_put_contents(ROOT . "/tmp/" . logged_user()->getId() . "_" .$original_mail->getAccountId() . "_FwdMailAttach_$fid", $att['data']);
				}
			}
			
			$mail_data = array(
	          'to' => $original_mail->getTo(),
	          'cc' => $original_mail->getCc(),
	          'bcc' => $original_mail->getBcc(),
	          'subject' => $original_mail->getSubject(),
	          'body' => $body,
	          'type' => $original_mail->getBodyHtml() != '' ? 'html' : 'plain',
	          'account_id' => $original_mail->getAccountId(),
			  'conversation_id' => $original_mail->getConversationId(),
			  'in_reply_to_id' => $original_mail->getMessageId(),
			  'original_id' => $original_mail->getId(),
			  'last_mail_in_conversation' => MailContents::getLastMailIdInConversation($original_mail->getConversationId(), true),
	          'id' => $original_mail->getId(),
			  'draft_edit' => 1,
			  'attachs' => $attachs
			); // array
		} // if
		
		$mail_accounts = MailAccounts::getMailAccountsByUser(logged_user());
		tpl_assign('mail', $original_mail);
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
			"classify_atts" => array_var($_GET, 'classify_atts'),
		);
		$dir = array_var($_GET,'dir');
		if ($dir != 'ASC' && $dir != 'DESC') {
			$dir = 'ASC';
		}
		$order = array_var($_GET,'sort');
		switch ($order){
			case 'title':
			case 'subject':
				$order = '`subject`';
			break;
			case 'accountName':
				$order = '`account_email`';
			break;
			case 'from':
				$order = "`from_name` $dir, `from`";
			break;
			case 'folder':
				$order = '`imap_folder_name`';
			break;
			default:
				$order = "`received_date`";
			break;
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
		//ajx_extra_data(array('unreadCount' => MailContents::countUserInboxUnreadEmails()));
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
		$classif_filter = array_var($attributes, 'classifType');
		$read_filter = array_var($attributes, 'readType');
		
		set_user_config_option('mails account filter', $account, logged_user()->getId());
		set_user_config_option('mails classification filter', $classif_filter, logged_user()->getId());
		set_user_config_option('mails read filter', $read_filter, logged_user()->getId());
		
		$state = array_var($attributes, 'stateType');
		list($objects, $pagination) = MailContents::getEmails($tag, $account, $state, $read_filter, $classif_filter, $project, $start, $limit, $order_by, $dir);
		$totalCount = $pagination->getTotalItems();
		
		return $objects;
	}

	function get_user_preferences() {
		ajx_current("empty");
		$prefereneces = array(
			'accFilter' => user_config_option('mails account filter'),
			'classifFilter' => user_config_option('mails classification filter'),
			'readFilter' => user_config_option('mails read filter'),
		);
		ajx_extra_data($prefereneces);
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
		$ids = array();
		for ($i = 0; $i < $limit; $i++) {
			if (isset($totMsg[$i])) {
				$msg = $totMsg[$i];
				if ($msg instanceof MailContent) {/* @var $msg MailContent */
					$ids[] = $msg->getId();
				}
			}
		}
		MailContents::populateData($totMsg);
		for ($i = 0; $i < $limit; $i++) {
			if (isset($totMsg[$i])) {
				$msg = $totMsg[$i];
				if ($msg instanceof MailContent) {/* @var $msg MailContent */
					$text = $msg->getBodyPlain();
					// plain body is already converted to UTF-8 (when mail was saved)
					if (strlen_utf($text) > 150) {
						$text = substr_utf($text, 0, 150) . "...";
					}
					$show_as_conv = user_config_option('show_emails_as_conversations');
					if ($show_as_conv) {
						$conv_total = MailContents::countMailsInConversation($msg);
						$conv_unread = MailContents::countUnreadMailsInConversation($msg);
					}
					$properties = array(
					    "id" => $msg->getId(),
						"ix" => $i,
						"object_id" => $msg->getId(),
						"type" => 'email',
						"hasAttachment" => $msg->getHasAttachments(),
						"accountId" => $msg->getAccountId(),
						"accountName" => ($msg->getAccount() instanceof MailAccount ? $msg->getAccount()->getName() : lang('n/a')),
						"projectId" => $msg->getWorkspacesIdsCSV(logged_user()->getWorkspacesQuery()),
						"subject" => $msg->getSubject(),
						"text" => $text,
						"date" => $msg->getReceivedDate() instanceof DateTimeValue ? ($msg->getReceivedDate()->isToday() ? format_time($msg->getReceivedDate()) : format_datetime($msg->getReceivedDate())) : lang('n/a'),
						"userId" => ($msg->getAccount() instanceof MailAccount  && $msg->getAccount()->getOwner() instanceof User ? $msg->getAccount()->getOwner()->getId() : 0),
						"userName" => ($msg->getAccount() instanceof MailAccount  && $msg->getAccount()->getOwner() instanceof User ? $msg->getAccount()->getOwner()->getDisplayName() : lang('n/a')),
						"tags" => implode(", ", $msg->getTagNames()),
						"isRead" => $show_as_conv ? ($conv_unread == 0) : $msg->getIsRead(logged_user()->getId()),
						"from" => $msg->getFromName()!=''?$msg->getFromName():$msg->getFrom(),
						"from_email" => $msg->getFrom(),
						"isDraft" => $msg->getIsDraft(),
						"isSent" => $msg->getIsSent(),
						"folder" => $msg->getImapFolderName(),
						"to" => $msg->getTo(),
					);
					if ($show_as_conv) {
						$properties["conv_total"] = $conv_total;
						$properties["conv_unread"] = $conv_unread;
					}
					$object["messages"][] = $properties;
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
							if (isset($email) && $email->canDelete(logged_user())) {
								if ($email->getState() == 2) {
									// we are deleting a draft email
									$emails_in_conversation = array($email);
								} else {
									if (user_config_option('show_emails_as_conversations', true, logged_user()->getId())) {
										$emails_in_conversation = MailContents::getMailsFromConversation($email);
									} else { 
										$emails_in_conversation = array($email);
									}
								}
								foreach ($emails_in_conversation as $email){
									if ($email->canDelete(logged_user())) {
										try {
											$email->trash();
											ApplicationLogs::createLog($email, $email->getWorkspaces(), ApplicationLogs::ACTION_TRASH);
											$succ++;
										} catch(Exception $e) {
											$err++;
										}
									} else {
										$err++;
									}
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
				if (!trim($tag)) break;
				for($i = 0; $i < count($attributes["ids"]); $i++){
					$id = $attributes["ids"][$i];
					$type = $attributes["types"][$i];
					switch ($type){
						case "email":
							$email = MailContents::findById($id);
							if (isset($email)) {
								if (user_config_option('show_emails_as_conversations',true,logged_user()->getId())) {
									$emails_in_conversation = MailContents::getMailsFromConversation($email);
								} else { 
									$emails_in_conversation = array($email);
								}
								foreach ($emails_in_conversation as $email){
									if ($email->canEdit(logged_user())){
										Tags::addObjectTag($tag, $email);
										ApplicationLogs::createLog($email, $email->getWorkspaces(), ApplicationLogs::ACTION_TAG, false, null, true, $tag);
									}
								}
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
			case "untag":
				$tag = $attributes["tag"];
				for($i = 0; $i < count($attributes["ids"]); $i++){
					$id = $attributes["ids"][$i];
					$type = $attributes["types"][$i];
					switch ($type){
						case "email":
							$email = MailContents::findById($id);
							if (isset($email)){
								if (user_config_option('show_emails_as_conversations',true,logged_user()->getId())) {
									$emails_in_conversation = MailContents::getMailsFromConversation($email);
								} else {
									$emails_in_conversation = array($email);
								}
								foreach ($emails_in_conversation as $email){
									if ($email->canEdit(logged_user())){
										if ($tag != ''){
											Tags::deleteObjectTag($tag, $email->getId(),get_class($email->manager()));
										}else{
											$email->clearTags();
										}
									}
								}
								//ApplicationLogs::createLog($email, $email->getWorkspaces(), ApplicationLogs::ACTION_TAG,false,null,true,$tag);
								$resultMessage = lang("success untag objects", '');
							};
							break;

						default:
							$resultMessage = lang("Unimplemented type: '" . $type . "'");// if
							$resultCode = 2;
							break;
					}; // switch
				}; // for
				break;
			case "unclassify":
				for($i = 0; $i < count($attributes["ids"]); $i++){
					$id = $attributes["ids"][$i];
					$type = $attributes["types"][$i];
					switch ($type){
						case "email":
							$email = MailContents::findById($id);
							if (isset($email) && !$email->isDeleted() && $email->canEdit(logged_user())){
								$this->do_unclassify($email);
								ApplicationLogs::createLog($email, $email->getWorkspaces(), ApplicationLogs::ACTION_TAG,false,null,true,$tag);
								$resultMessage = lang("success unclassify emails", count($attributes["ids"]));
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
		
				if (!$destination instanceof Project) {
					$resultMessage = lang('project dnx');
					$resultCode = 1;
				} else if (!can_add(logged_user(), $destination, 'MailContents')) {
					$resultMessage = lang('no access permissions');
					$resultCode = 1;
				} else {
					$count = 0;
					for($i = 0; $i < count($attributes["ids"]); $i++){
						$id = $attributes["ids"][$i];
						$type = $attributes["types"][$i];
						switch ($type){
							case "email":
								$email = MailContents::findById($id);
								if (user_config_option('show_emails_as_conversations',true,logged_user()->getId())) {
									$conversation = MailContents::getMailsFromConversation($email);
								} else {
									$conversation = array($email);
								}
								foreach ($conversation as $conv_email) {
									$this->addEmailToWorkspace($conv_email->getId(), $destination, array_var($attributes, "mantainWs", true));
								
									if (array_var($attributes, 'classify_atts') && $conv_email->getHasAttachments()) {
										MailUtilities::parseMail($conv_email->getContent(), $decoded, $parsedEmail, $warnings);
										$classification_data = array();
										for ($j=0; $j < count(array_var($parsedEmail, "Attachments", array())); $j++) {
											$classification_data["att_".$j] = true;
										}
										$tags = implode(",", $conv_email->getTagNames());
										$this->classifyFile($classification_data, $conv_email, $parsedEmail, array($destination), array_var($attributes, "mantainWs", true), $tags);
									}
								}
								$count++;
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
							if (isset($email)) {
								if (user_config_option('show_emails_as_conversations', true, logged_user()->getId())) {
									$emails_in_conversation = MailContents::getMailsFromConversation($email);
								} else {
									$emails_in_conversation = array($email);
								}
								foreach ($emails_in_conversation as $email) {
									if ($email->canEdit(logged_user())) {
										$email->setIsRead(logged_user()->getId(), $action == 'markAsRead');
									}
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
			case "archive":
				$err = 0; $succ = 0;
				for($i = 0; $i < count($attributes["ids"]); $i++){
					$id = $attributes["ids"][$i];
					$type = $attributes["types"][$i];
						
					switch ($type){
						case "email":
							$email = MailContents::findById($id);
							if (isset($email)) {
								if (user_config_option('show_emails_as_conversations', true, logged_user()->getId())) {
									$emails_in_conversation = MailContents::getMailsFromConversation($email);
								} else {
									$emails_in_conversation = array($email);
								}
								foreach ($emails_in_conversation as $email) {
									if ($email->canEdit(logged_user())) {
										try {
											$email->archive(null);
											ApplicationLogs::createLog($email, $email->getWorkspaces(), ApplicationLogs::ACTION_ARCHIVE);
											$succ++;
										} catch(Exception $e) {
											$err++;
										}
									}
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
					$resultMessage = lang("error archive objects", $err) . "<br />" . ($succ > 0 ? lang("success archive objects", $succ) : "");
				} else {
					$resultMessage = lang("success archive objects", $succ);
				}
				ajx_add("overview-panel", "reload");
				break;
			default:
				if ($action) {
					$resultMessage = lang("Unimplemented action: '" . $action . "'");// if
					$resultCode = 2;
				}
				break;
		} // switch
		return array("errorMessage" => $resultMessage, "errorCode" => $resultCode);
	}
	
	function addEmailToWorkspace($id, $destination, $mantainWs = true) {
		$email = MailContents::findById($id);
		if ($email instanceof MailContent && $email->canEdit(logged_user())){
			if (!$mantainWs) {
				$ws = $email->getWorkspaces();
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
		tpl_assign('genid', $genid);

		$account = new MailAccount();
		$account->setIncomingSsl($ssl);
		$account->setIncomingSslPort($port);
		$account->setEmail($email);
		$account->setPassword(MailUtilities::ENCRYPT_DECRYPT($pass));
		$account->setServer($server);

		try {
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
		} catch (Exception $e) {
			Logger::log($e->getTraceAsString());
		}
	}
	
	function get_conversation_info() {
		$email = MailContents::findById(array_var($_GET, 'id'));
		if (!$email instanceof MailContent) {
			flash_error(lang('email dnx'));
			ajx_current("empty");
			return;
		}

		$info = array();
		$mails = MailContents::getMailsFromConversation($email);
		foreach ($mails as $mail) {
			$text = $mail->getBodyPlain();
			if (strlen_utf($text) > 80) $text = substr_utf($text, 0, 80) . "...";
			$state = $mail->getState();
			$show_user_icon = false;
			if ($state == 1 || $state == 3 || $state == 5) {
				if ($mail->getCreatedById() == logged_user()->getId()) {
					$from = lang('you');
				} else {
					$from = $mail->getCreatedByDisplayName();
				}
				$show_user_icon = true;
			} else {
				$from = $mail->getFrom();
			}
			
			$info[] = array(
				'id' => $mail->getId(),
				'date' => $mail->getReceivedDate() instanceof DateTimeValue ? ($mail->getReceivedDate()->isToday() ? format_time($mail->getReceivedDate()) : format_datetime($mail->getReceivedDate())) : lang('n/a'),
				'has_att' => $mail->getHasAttachments(),
				'text' => htmlentities($text),
				'read' => $mail->getIsRead(logged_user()->getId()),
				'from_name' => ($state == 1 || $state == 3 || $state == 5) ? lang('you') : $mail->getFromName(),
				'from' => $from,
				'show_ico' => $show_user_icon
			);
		}

		tpl_assign('source_email_id', array_var($_GET, 'id'));
		tpl_assign('emails_info', $info);
		$this->setLayout("html");
		$this->setTemplate("llo_email_conversation");
		ajx_current("empty");
	}
	
	function get_unread_count() {
		ajx_current("empty");
		ajx_extra_data(array('unreadCount' => MailContents::countUserInboxUnreadEmails()));
	}
	
	function print_mail() {
		$this->setLayout("html");
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
		 
		if ($email->getBodyHtml() != '') {
			MailUtilities::parseMail($email->getContent(), $decoded, $parsedEmail, $warnings);
			$tmp_folder = "/tmp/" . $email->getAccountId() . "_" . logged_user()->getId() . "_temp_mail_content_res";
			if (is_dir(ROOT . $tmp_folder)) remove_dir(ROOT . $tmp_folder);
			$email->setBodyHtml(self::rebuild_body_html($email->getBodyHtml(), $decoded[0]['Parts'], $tmp_folder));
		}
		
		tpl_assign('email', $email);
		$this->setTemplate("print_view");
		//ajx_current("empty");
	}
	
	function download() {
		$this->setTemplate(get_template_path('back'));
		$id = array_var($_GET, 'id');
		$email = MailContents::findById($id);
		if (!$email instanceof MailContent) {
			flash_error(lang('email dnx'));
			return;
		}
		if (!$email->canView(logged_user())) {
			flash_error(lang('no access permissions'));
			return;
		}
		if ($email->getContent()) {
			download_contents($email->getContent(), 'message/rfc822', $email->getSubject() . ".eml", strlen($email->getContent()), true);
			die();
		} else {
			download_from_repository($email->getContentFileId(), 'message/rfc822', $email->getSubject() . ".eml", true);
			die();
		}
	}
	
	function get_mail_css() {
		$css = file_get_contents('public/assets/javascript/ckeditor/contents.css');
		$css .= "\nbody {\n";
		Hook::fire('email_base_css', null, $css);
		$css .= "\n}\n";
		header("Content-type: text/css");
		echo $css;
		die();
	}

} // MailController

?>