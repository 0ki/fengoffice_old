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
    * Return email list
    *
    * @access public
    * @param void
    * @return null
    */
    function index() {
      $accounts = logged_user()->getMailAccounts();
      if (isset($accounts))
      {
      	$this->view_account($accounts[0]);
      	$this->setTemplate('view_account');
      }
    } // index
    
    function view()
    {
    	$email = MailContents::findById(get_id());
        MailUtilities::parseMail($email->getContent(),$decoded,$parsedEmail,$warnings);
    	tpl_assign('email', $email);
        tpl_assign('parsedEmail', $parsedEmail);
        
        if ($email->getIsClassified()){
    		tpl_assign('project', $email->getProject());
        }
    }
    
    /**
    * View mail account
    *
    * @access public
    * @param void
    * @return null
    */
    function view_account($account = null) {
      if (!isset($account))
      	$account = MailAccounts::findById(get_id());
      
      $page = (integer) array_var($_GET, 'page', 1);
      if($page < 0) $page = 1;
      
      list($emails, $pagination) = MailContents::paginate(
        array(
          'conditions' => '`is_deleted` = 0 AND `account_id` = ' .$account->getId(),
          'order' => '`sent_date` DESC'
        ),
        config_option('emails_per_page', 25), 
        $page
      ); // paginate
      
      tpl_assign('account', $account);
      tpl_assign('emails', $emails);
      tpl_assign('emails_pagination', $pagination);
    } // view
    
    /**
    * View project emails
    *
    * @access public
    * @param void
    * @return null
    */
    function index_project() {
      $page = (integer) array_var($_GET, 'page', 1);
      if($page < 0) $page = 1;
      
      list($emails, $pagination) = MailContents::paginate(
        array(
          'conditions' => '`project_id` = ' .active_project()->getId(),
          'order' => '`sent_date` DESC'
        ),
        config_option('emails_per_page', 20), 
        $page
      ); // paginate
      
      tpl_assign('emails', $emails);
      tpl_assign('emails_pagination', $pagination);
    } // view
    
    /**
    * Delete specific email
    *
    * @access public
    * @param void
    * @return null
    */
    function delete() {
    	$email = MailContents::findById(get_id());
    	$account = $email->getAccount();
    	$email->delete();
    	try
    	{
    		DB::beginWork();
    		$email->save();
    		DB::commit();
    		
        	flash_success(lang('success delete email'));
          	$this->redirectToUrl($account->getViewUrl());
    	} catch(Exception $e) {
    		DB::rollback();
        	flash_error(lang('error delete email'));
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
	
    function classify()
    {
      $email = MailContents::findById(get_id());
      MailUtilities::parseMail($email->getContent(),$decoded,$parsedEmail,$warnings);
      
      if(!$email->canEdit(logged_user())) {
        flash_error(lang('no access permissions'));
        $this->redirectToReferer(get_url('mail'));
      } // if
    
      $projects = logged_user()->getActiveProjects();
      tpl_assign('projects', $projects);
      
      $classification_data = array_var($_POST, 'classification');
      tpl_assign('classification_data', $classification_data);
      tpl_assign('email', $email);
      tpl_assign('parsedEmail', $parsedEmail);
      
      if(is_array(array_var($_POST, 'classification')))
      {
      	try
      	{
      		$project_id = $classification_data["project_id"];
      		$project = Projects::findById($project_id);
      		$email->setProjectId($project_id);
      		DB::beginWork();
      		$email->save();
      		DB::commit();
      		
      		$csv = array_var($classification_data, 'tag_'.$project_id);
      		
      		$email->setTagsFromCSV($csv);
      		
      		$c = 0;
      		while(isset($classification_data["att_".$c]))
      		{
      			if ($classification_data["att_".$c])
      			{
      				$att = $parsedEmail["Attachments"][$c];

      				$tempFileName = ROOT ."/tmp/saveatt/". logged_user()->getId()."x".$att["FileName"];
      				$fh = fopen($tempFileName, 'w') or die("can't open file");
      				fwrite($fh, $att["Data"]);
      				fclose($fh);

      				$file = new ProjectFile();
      				$file->setFilename($att["FileName"]);
					$file->setIsVisible(true);
      				$file->setProjectId($project->getId());

      				if(!logged_user()->isMemberOfOwnerCompany()) {
      					$file->setIsPrivate(false);
      					$file->setIsImportant(false);
      					$file->setCommentsEnabled(true);
      					$file->setAnonymousCommentsEnabled(false);
      				} // if

      				try
      				{
      					DB::beginWork();
      					$file->save();
      					DB::commit();
      					ApplicationLogs::createLog($file, $project, ApplicationLogs::ACTION_ADD);

      					$file->setTagsFromCSV($csv);
      					$ext = substr($att["FileName"],strrpos($att["FileName"],'.')+1);
      					$fileToSave = array(
      					"name" => $att["FileName"], 
      					"type" => Mime_Types::instance()->get_type($ext), 
      					"tmp_name" => $tempFileName,
      					"error" => 0,
      					"size" => filesize($tempFileName));
      					fclose($fh);
      					$revision = $file->handleUploadedFile($fileToSave, true); // handle uploaded file
      					
      					// Error...
      				} catch(Exception $e) {
      					DB::rollback();
      					tpl_assign('error', $e);
      				}
      				unlink($tempFileName);
      			}
      			$c++;
      		}
      		
          	flash_success(lang('success classify email'));
          	$this->redirectToUrl($email->getAccount()->getViewUrl());
          // Error...
      	} catch(Exception $e) {
          DB::rollback();
          tpl_assign('error', $e);
        } // try
      	
      }
    }
    
    // ---------------------------------------------------
    //  Mail Accounts
    // ---------------------------------------------------
    
    /**
    * Add account
    *
    * @access public
    * @param void
    * @return null
    */
    function add_account() {
      $this->setTemplate('add_account');
      
      if(!MailAccount::canAdd(logged_user())) {
        flash_error(lang('no access permissions'));
        $this->redirectToReferer(get_url('mail'));
      } // if
      
      $mailAccount = new MailAccount();
      tpl_assign('mailAccount', $mailAccount);
      
      $mailAccount_data = array_var($_POST, 'mailAccount');
      tpl_assign('mailAccount_data', $mailAccount_data);
      
      if(is_array(array_var($_POST, 'mailAccount'))) {
        
        try {
          $mailAccount_data['user_id'] = logged_user()->getId();
          $mailAccount->setFromAttributes($mailAccount_data);
          
          DB::beginWork();
          $mailAccount->save();
          DB::commit();
          
          flash_success(lang('success add mail account', $mailAccount->getName()));
          $this->redirectTo('mail');
          
        // Error...
        } catch(Exception $e) {
          DB::rollback();
          tpl_assign('error', $e);
        } // try
        
      } // if
    } // add_account
    
    function edit_account() {
      $this->setTemplate('add_account');
      
      $mailAccount = MailAccounts::findById(get_id());
      if(!($mailAccount instanceof MailAccount)) {
        flash_error(lang('mailAccount dnx'));
        $this->redirectTo('mail');
      } // if
      
      if(!$mailAccount->canEdit(logged_user())) {
        flash_error(lang('no access permissions'));
        $this->redirectTo('mailAccount');
      } // if
      
      $mailAccount_data = array_var($_POST, 'mailAccount');
      if(!is_array($mailAccount_data)) {
        $mailAccount_data = array(
          'user_id' => logged_user()->getId(),
          'name' => $mailAccount->getName(),
          'email' => $mailAccount->getEmail(),
          'password' => $mailAccount->getPassword(),
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
          
          DB::beginWork();
          $mailAccount->save();
          DB::commit();
          
          flash_success(lang('success edit mail account', $mailAccount->getName()));
          $this->redirectTo('mail');
          
        // Error...
        } catch(Exception $e) {
          DB::rollback();
          tpl_assign('error', $e);
        } // try
      } // if
    } // edit
    
    /**
    * Delete specific mail account
    *
    * @access public
    * @param void
    * @return null
    */
    function delete_account() {
    	$account = MailAccounts::findById(get_id());
    	try
    	{
    		DB::beginWork();
    		$account->delete();
    		DB::commit();

    		flash_success(lang('success delete mail account'));
    		$this->redirectTo('message','main');
    	} catch(Exception $e) {
    		DB::rollback();
    		flash_error(lang('error delete mail account'));
    	}
    } // delete

  } // MailController
  
?>