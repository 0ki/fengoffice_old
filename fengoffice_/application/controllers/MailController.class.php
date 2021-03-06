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
      if (is_ajax_request()) {
		prepare_company_website_controller($this, 'ajax');
	  } else {
		prepare_company_website_controller($this, 'website');
	  }
    } // __construct
    
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
    	if (!$email instanceof MailContents || $email->getIsDeleted()){
    		flash_error(lang('email dnx'));
			ajx_current("empty");
			return;
    	}
    	
    	if (!$email->canDelete(logged_user())){
			flash_error(lang('no access permissions'));
			ajx_current("empty");
			return;
    	}
    	
    	$account = $email->getAccount();
    	$email->deleteContents();
    	try
    	{
    		DB::beginWork();
    		$email->save();
    		DB::commit();
    		
        	flash_success(lang('success delete email'));
        	ajx_current("start");
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
	
	      				$tempFileName = ROOT ."/tmp/saveatt/". logged_user()->getId()."x".$att["FileName"];
	      				$fh = fopen($tempFileName, 'w') or die("Can't open file");
	      				fwrite($fh, $att["Data"]);
	      				fclose($fh);
	
	      				$file = new ProjectFile();
	      				$file->setFilename($att["FileName"]);
						$file->setIsVisible(true);
	      				$file->setProjectId($project->getId());
	      				$file->setIsPrivate(false);
      					$file->setIsImportant(false);
      					$file->setCommentsEnabled(true);
      					$file->setAnonymousCommentsEnabled(false);
	
	      				try
	      				{
	      					DB::beginWork();
	      					$file->save();
	      					DB::commit();
	
	      					$file->setTagsFromCSV($csv);
	      					$ext = substr($att["FileName"],strrpos($att["FileName"],'.')+1);
	      					$fileToSave = array(
	      					"name" => $att["FileName"], 
	      					"type" => Mime_Types::instance()->get_type($ext), 
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
	      		ajx_current("start");
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
    
    function checkFileWritability($classification_data, $parsedEmail){
    	$c = 0;
    	while(isset($classification_data["att_".$c]))
    	{
    		if ($classification_data["att_".$c])
    		{
    			$att = $parsedEmail["Attachments"][$c];
    			$tempFileName = ROOT ."/tmp/saveatt/". logged_user()->getId()."x".$att["FileName"];
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
    	MailUtilities::getmails($accounts, $err, $succ, $errAccounts, $mailsReceived);
        $errMessage = lang('success check mail', $mailsReceived);
    	if ($err > 0){
    		foreach($errAccounts as $error) {
        		$errMessage .= '<br/><br/>' . lang('error check mail', $error["accountName"], $error["message"]);
    		}
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
          
          DB::beginWork();
          $mailAccount->save();
          DB::commit();
          
          evt_add("mail account added", array(
					"id" => $mailAccount->getId(),
					"name" => $mailAccount->getName(),
					"email" => $mailAccount->getEmail()
          ));
          
          flash_success(lang('success add mail account', $mailAccount->getName()));
          ajx_current("start");
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
          'password' => MailUtilities::ENCRYPT_DECRYPT($mailAccount->getPassword()),
          'server' => $mailAccount->getServer(),
          'is_imap' => $mailAccount->getIsImap(),
          'incoming_ssl' => $mailAccount->getIncomingSsl(),
          'incoming_ssl_port' => $mailAccount->getIncomingSslPort()
        ); // array
      } // if
      
      tpl_assign('mailAccount', $mailAccount);
      tpl_assign('mailAccount_data', $mailAccount_data);
      
      if(is_array(array_var($_POST, 'mailAccount'))) {
        try {
          $mailAccount->setFromAttributes($mailAccount_data);
          $mailAccount->setPassword(MailUtilities::ENCRYPT_DECRYPT($mailAccount->getPassword()));
          
          DB::beginWork();
          $mailAccount->save();
          DB::commit();
          
          flash_success(lang('success edit mail account', $mailAccount->getName()));
      	  ajx_current("empty");
          
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
		$this->setLayout('json');
    	$this->setTemplate(get_template_path('json'));
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
		tpl_assign('object', $object);
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
    		
    		DB::beginWork();
    		foreach ($mails as $mail){
    			$mail->delete();
    		}
    		$account->delete();
    		DB::commit();

    		flash_success(lang('success delete mail account'));
      		ajx_current("start");
    	} catch(Exception $e) {
    		DB::rollback();
    		flash_error(lang('error delete mail account'));
			ajx_current("empty");
    	}
    } // delete

  } // MailController
  
?>