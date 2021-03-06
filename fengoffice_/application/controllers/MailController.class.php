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
    
    function reply_mail(){
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
     		$re_subject = str_starts_with($original_mail->getSubject(),'Re:')?$original_mail->getSubject():'Re: '.$original_mail->getSubject();
	        $re_body = $original_mail->getBodyHtml()==''?$original_mail->getBodyPlain():$original_mail->getBodyHtml();
     		
     		$cc = "";
     		if(array_var($_GET,'all','') != ''){
     			MailUtilities::parseMail($original_mail->getContent(), $decoded, $parsedEmail, $warnings);
     			if($parsedEmail["Cc"]){
					foreach ($parsedEmail["Cc"] as $cc_value) {
						if ($cc != '') $cc .= ", ";
						$cc .= $cc_value[address];
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
					if(!in_array($to_value[address], $account_emails)){
						if ($cc != '') $cc .= ", ";
						$cc .= $to_value[address];	
					}					
				}
				
				$arr_body=preg_split("/<body.*>/i",$re_body);
				$re_body = "----- Origianal Message -----\nFrom: ".$original_mail->getFrom()."\nTo: ".$original_mail->getTo()."\nSent:".$original_mail->getDate()."\nSubject:".$original_mail->getSubject()."\n\n";
     			
     			if (count($arr_body)>1)
	     			$re_body = $arr_body[0].$re_body.$arr_body[1];			
	     		else 
	     			$re_body = $re_body.$arr_body[0];			
     		}     		
     		
	        $mail_data = array(
	          'to' => $original_mail->getFrom(),
	          'cc' => $cc,
	          'type' => $original_mail->getBodyHtml()!=''?'html':'plain',
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
		if (!is_array($mail_accounts)){
			flash_error(lang('no mail accounts set'));
			ajx_current("empty");
			return;
		}
		$this->setTemplate('add_mail');
		$mail_data = array_var($_POST, 'mail');
		$isDraft = array_var($mail_data,'isDraft','')=='true'?true:false;
		
		$id = array_var($mail_data,'id');
		$mail = MailContents::findById($id);    	
		$isNew = false;
	    if(! $mail){
	    	$isNew = true;
			$mail = new MailContent();   		
	    }  
		
		
		tpl_assign('mail', $mail);
		tpl_assign('mail_data', $mail_data);
		tpl_assign('mail_accounts', $mail_accounts);

		// Form is submited
		if(is_array($mail_data)) {
			$account = 	MailAccounts::findById(array_var($mail_data,'account_id'));
			$to = str_replace(" ","",array_var($mail_data,'to'));
			$subject = array_var($mail_data,'subject');
			$body = array_var($mail_data,'body');
			$cc = str_replace(" ","",array_var($mail_data,'CC'));
			$bcc = str_replace(" ","",array_var($mail_data,'BCC'));
			$type = 'text/'.array_var($mail_data,'format');
			$mail->setFromAttributes($mail_data);
			
			$utils = new MailUtilities();
			
			$to = explode(",",$to);
			$to = $utils->parse_to($to);
			
//			$assigned_to = explode(':', array_var($mail_data, 'assigned_to', ''));
//			$mail->setAssignedToCompanyId(array_var($assigned_to, 0, 0));
//			$mail->setAssignedToUserId(array_var($assigned_to, 1, 0));
//			$mail->setProjectId(active_or_personal_project()->getId());
//			$mail->setIsPrivate($mail_list->getIsPrivate());
			try {
				
				$from = logged_user()->getDisplayName() . " <" . $account->getEmailAddress() . ">";
				$sentOK = false;
				if (!$isDraft) {
					$sentOK = $utils->sendMail($account->getSmtpServer(),$to,$from,$subject,$body,$cc,$bcc,$account->getSmtpPort(),$account->smtpUsername(),$account->smtpPassword(),$type); 
				}
				if ((!$isDraft && $sentOK)|| $isDraft){
					
					$mail->setSentDate( DateTimeValueLib::now());
					DB::beginWork();
						$mail->setUid('UID');
						$mail->setState($isDraft?2:1);
						$mail->setIsPrivate(true);						
						
						if (array_var($mail_data,'format')=='html')
							$mail->setBodyHtml($body);
						else
							$mail->setBodyPlain($body);
						$mail->setFrom($from);
						$mail->save(); 
						$mail->setTagsFromCSV(array_var($mail_data, 'tags'));
	//					$mail_list->attachmail($mail);
	//			  		$mail->save_properties($mail_data);
				 	 	ApplicationLogs::createLog($mail, active_or_personal_project(), ApplicationLogs::ACTION_ADD);
			  		DB::commit();
			  		
			  		if ($isDraft){
			  			flash_success(lang('success save mail'));
			  			/*if ($isNew){
			  				$mail_data["id"] = $mail->getId();
			  				tpl_assign('mail_data', $mail_data);
							ajx_replace();
			  			}*/
			  		} else {
			  			flash_success(lang('success add mail'));
						ajx_current("back");
			  		}
			  		evt_add("email saved", array("id" => $mail->getId(), "instance" => array_var($_POST, 'instanceName')));
				}
				else {
					flash_error('Error while sending mail. Possibly wrong SMTP settings.');
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
    function view()
    {
    	$this->addHelper('textile');
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
    	if (!$email->canView(logged_user())){
    		flash_error(lang('no access permissions'));
			ajx_current("empty");
			return;
    	}
    	
        MailUtilities::parseMail($email->getContent(),$decoded,$parsedEmail,$warnings);
    	tpl_assign('email', $email);
        tpl_assign('parsedEmail', $parsedEmail);
		ajx_extra_data(array("title" => $email->getSubject(), 'icon'=>'ico-email'));
		ajx_set_no_toolbar(true);
										
		if (!$email->getIsRead(logged_user()->getId())){
			try{			
				DB::beginWork();
				$email->setIsRead(1,logged_user()->getId());
				DB::commit();
			} catch(Exception $e){
				DB::rollback();
				flash_error(lang('error mark email'));
			}
		}
		
        if ($email->getIsClassified()){
    		tpl_assign('project', $email->getProject());
        }
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
    	try
    	{
    		DB::beginWork();
    		$email->deleteContents();
    		$email->save();
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
		MailUtilities::parseMail($email->getContent(), $decoded, $parsedEmail, $warnings);
		
		$attId = array_var($_GET, 'attachment_id');
		$attachment = $parsedEmail["Attachments"][$attId];
		
		$content = $attachment["Data"];
		$typeString = "application/octet-stream";
		$filename = $attachment["FileName"];
		$filesize = strlen($content);
		$inline = false;
	  
		download_contents($content, $typeString, $filename, $filesize, !$inline);
		die();
	} // download_file
	
	/**
	 * Classify specific email
	 *
	 */
    function classify()
    {
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
	      		$project_id = $classification_data["project_id"];
	      		$project = Projects::findById($project_id);
	      		$email->setProjectId($project_id);
	      		DB::beginWork();
	      		$email->save();
	      		DB::commit();
	      		$csv = array_var($classification_data, 'tag');
	      		$email->setTagsFromCSV($csv);
	      		//Classify attachments
	      		$c = 0;
	      		while(isset($classification_data["att_".$c])){
	      			if ($classification_data["att_".$c]){
	      				$att = $parsedEmail["Attachments"][$c];
						$fName = iconv_mime_decode($att["FileName"], 0, "UTF-8");
	      				$tempFileName = ROOT ."/tmp/saveatt/". logged_user()->getId()."x".$fName;
	      				$fh = fopen($tempFileName, 'w') or die("Can't open file");
	      				fwrite($fh, $att["Data"]);
	      				fclose($fh);
	
	      				$file = new ProjectFile();
	      				$file->setFilename($fName);
						$file->setIsVisible(true);
	      				$file->setIsPrivate(false);
      					$file->setIsImportant(false);
      					$file->setCommentsEnabled(true);
      					$file->setAnonymousCommentsEnabled(false);
	
	      				try
	      				{
	      					DB::beginWork();
	      					$file->save();
							$file->addToWorkspace($project);
	      					DB::commit();
	
	      					$file->setTagsFromCSV($csv);
	      					$ext = substr($fName,strrpos($fName,'.')+1);
	      					
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
	      					ApplicationLogs::createLog($file, $project, ApplicationLogs::ACTION_ADD);
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
      	if ($email->getProjectId() > 0)
      		$classification_data["project_id"] = $email->getProjectId();
      	else
      		$classification_data["project_id"] = active_or_personal_project()->getId();
      }
      tpl_assign('classification_data', $classification_data);
      tpl_assign('email', $email);
      tpl_assign('parsedEmail', $parsedEmail);
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
    
    
    function checkmail(){
    	$accounts = MailAccounts::findAll(array(
    		"conditions" => "`user_id` = " . logged_user()->getId()
    	));
    	
    	if ($accounts && count($accounts) > 0){
	    	MailUtilities::getmails($accounts, $err, $succ, $errAccounts, $mailsReceived);
	    	
	        $errMessage = lang('success check mail', $mailsReceived);
	    	if ($err > 0){
	    		foreach($errAccounts as $error) {
	        		$errMessage .= '<br/><br/>' . lang('error check mail', $error["accountName"], $error["message"]);
	    		}
	    	}
    	} else {
    		$err = 1;
    		$errMessage = lang('no mail accounts set for check');
    	}
    	
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
        
        try {
          $mailAccount_data['user_id'] = logged_user()->getId();
          $mailAccount->setFromAttributes($mailAccount_data);
          $mailAccount->setPassword(MailUtilities::ENCRYPT_DECRYPT($mailAccount->getPassword()));
          $mailAccount->setSmtpPassword(MailUtilities::ENCRYPT_DECRYPT($mailAccount->getSmtpPassword()));
          
          DB::beginWork();
          $mailAccount->save();
          DB::commit();
          
          evt_add("mail account added", array(
					"id" => $mailAccount->getId(),
					"name" => $mailAccount->getName(),
					"email" => $mailAccount->getEmail()
          ));
          
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
          'smtp_use_auth' => $mailAccount->getSmtpUseAuth()
        ); // array
      } // if
      
      tpl_assign('mailAccount', $mailAccount);
      tpl_assign('mailAccount_data', $mailAccount_data);
      
      if(is_array(array_var($_POST, 'mailAccount'))) {
        try {
          $mailAccount->setFromAttributes($mailAccount_data);
          $mailAccount->setPassword(MailUtilities::ENCRYPT_DECRYPT($mailAccount->getPassword()));
          $mailAccount->setSmtpPassword(MailUtilities::ENCRYPT_DECRYPT($mailAccount->getSmtpPassword()));
          
          DB::beginWork();
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
    	$mails = $account->getMailContents();
    	try
    	{
    		$accId = $account->getId();
    		$accName = $account->getName();
    		$accEmail = $account->getEmail();
    		
    		DB::beginWork();
    		$account->delete();
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
	       		     		
     		$fwd_body = "----- Origianal Message -----\nFrom: ".$original_mail->getFrom()."\nTo: ".$original_mail->getTo()."\nSent:".$original_mail->getDate()."\nSubject:".$original_mail->getSubject()."\n\n";
     		$body = $original_mail->getBodyHtml()==''?$original_mail->getBodyPlain():$original_mail->getBodyHtml();
     		$arr_body=preg_split("/<body.*>/i",$body);
     		if (count($arr_body)>1)
     			$fwd_body = $arr_body[0].$fwd_body.$arr_body[1];
     		else 
     			$fwd_body = $fwd_body.$arr_body[0];
     		
     		
	        $mail_data = array(
	          'to' => $original_mail->getFrom(),
	          'subject' => $fwd_subject,
	          'body' => $fwd_body,
	          'type' => $original_mail->getBodyHtml()!=''?'html':'plain',
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
     		$body = $original_mail->getBodyHtml()==''?$original_mail->getBodyPlain():$original_mail->getBodyHtml();
     		    		
	        $mail_data = array(
	          'to' => $original_mail->getTo(),
	          'subject' => $original_mail->getSubject(),
	          'body' => $body,
	          'type' => $original_mail->getBodyHtml()!=''?'html':'plain',
	          'account_id' => $original_mail->getAccountId(),
	          'id' => $original_mail->getId()
	        ); // array
      	} // if
		$mail_accounts = MailAccounts::getMailAccountsByUser(logged_user());
		tpl_assign('mail', $mail);
		tpl_assign('mail_data', $mail_data);
		tpl_assign('mail_accounts', $mail_accounts);
    }//forward_mail

  } // MailController
  
?>