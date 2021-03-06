<?php

  /**
  * Controller that is responsible for handling project files related requests
  *
  * @version 1.0
  * @author Ilija Studen <ilija.studen@gmail.com>
  */
  class FilesController extends ApplicationController {
  
    /**
    * Construct the FilesController
    *
    * @access public
    * @param void
    * @return FilesController
    */
    function __construct() {
      parent::__construct();
      prepare_company_website_controller($this, 'project_website');
    } // __construct
    
    /**
    * Show files index page (list recent files)
    *
    * @param void
    * @return null
    */
    function index() {
      $this->addHelper('textile');
      
      $order = array_var($_GET, 'order');
      if(($order <> ProjectFiles::ORDER_BY_NAME) && ($order <> ProjectFiles::ORDER_BY_POSTTIME)) {
        $order = ProjectFiles::ORDER_BY_POSTTIME;
      } // if
      $page = (integer) array_var($_GET, 'page', 1);
      if((integer) $page < 1) $page = 1;
      
      $hide_private = !logged_user()->isMemberOfOwnerCompany();
      $result = ProjectFiles::getProjectFiles(active_project(), null, $hide_private, $order, $page, config_option('files_per_page'), true);
      if(is_array($result)) {
        list($files, $pagination) = $result;
      } else {
        $files = null;
        $pagination = null; 
      } // if
      
      tpl_assign('current_folder', null);
      tpl_assign('order', $order);
      tpl_assign('page', $page);
      tpl_assign('files', $files);
      tpl_assign('pagination', $pagination);
      tpl_assign('folders', active_project()->getFolders());
      tpl_assign('important_files', active_project()->getImportantFiles());
      
      $this->setSidebar(get_template_path('index_sidebar', 'files'));
    } // index
    
    /**
    * List files in specific folder
    *
    * @param void
    * @return null
    */
    function browse_folder() {
      $this->addHelper('textile');
      $this->setTemplate('index'); // use index template
      
      $folder = ProjectFolders::findById(get_id());
      if(!($folder instanceof ProjectFolder)) {
        flash_error(lang('folder dnx'));
        $this->redirectTo('files');
      } // if
      
      $order = array_var($_GET, 'order');
      if(($order <> ProjectFiles::ORDER_BY_NAME) && ($order <> ProjectFiles::ORDER_BY_POSTTIME)) {
        $order = ProjectFiles::ORDER_BY_POSTTIME;
      } // if
      $page = (integer) array_var($_GET, 'page', 1);
      if((integer) $page < 1) $page = 1;
      
      $hide_private = !logged_user()->isMemberOfOwnerCompany();
      $result = ProjectFiles::getProjectFiles(active_project(), $folder, $hide_private, $order, $page, config_option('files_per_page'), true);
      if(is_array($result)) {
        list($files, $pagination) = $result;
      } else {
        $files = null;
        $pagination = null;
      } // if
      
      tpl_assign('current_folder', $folder);
      tpl_assign('order', $order);
      tpl_assign('page', $page);
      tpl_assign('files', $files);
      tpl_assign('pagination', $pagination);
      tpl_assign('folders', active_project()->getFolders());
      tpl_assign('important_files', active_project()->getImportantFiles());
      
      $this->setSidebar(get_template_path('index_sidebar', 'files'));
    } // browse_folder
    
    // ---------------------------------------------------
    //  Folders
    // ---------------------------------------------------
    
    /**
    * Add folder
    *
    * @access public
    * @param void
    * @return null
    */
    function add_folder() {
      if(!ProjectFolder::canAdd(logged_user(), active_project())) {
        flash_error(lang('no access permissions'));
        $this->redirectToReferer(get_url('files'));
      } // if
      
      $folder = new ProjectFolder();
      $folder_data = array_var($_POST, 'folder');
      
      tpl_assign('folder', $folder);
      tpl_assign('folder_data', $folder_data);
      
      if(is_array($folder_data)) {
        $folder->setFromAttributes($folder_data);
        $folder->setProjectId(active_project()->getId());
        
        try {
          DB::beginWork();
          $folder->save();
          ApplicationLogs::createLog($folder, active_project(), ApplicationLogs::ACTION_ADD);
          DB::commit();
          
          flash_success(lang('success add folder', $folder->getName()));
          $this->redirectToUrl($folder->getBrowseUrl());
        } catch(Exception $e) {
          DB::rollback();
          tpl_assign('error', $e);
        } // try
      } // if
    } // add_folder
    
    /**
    * Edit folder
    *
    * @access public
    * @param void
    * @return null
    */
    function edit_folder() {
      $this->setTemplate('add_folder');
      
      $folder = ProjectFolders::findById(get_id());
      if(!($folder instanceof ProjectFolder)) {
        flash_error(lang('folder dnx'));
        $this->redirectTo('files');
      } // if
      
      if(!$folder->canEdit(logged_user())) {
        flash_error(lang('no access permissions'));
        $this->redirectToReferer(get_url('files'));
      } // if
      
      $folder_data = array_var($_POST, 'folder');
      if(!is_array($folder_data)) {
        $folder_data = array('name' => $folder->getName());
      } // if
      
      tpl_assign('folder', $folder);
      tpl_assign('folder_data', $folder_data);
      
      if(is_array(array_var($_POST, 'folder'))) {
        $old_name = $folder->getName();
        
        $folder->setFromAttributes($folder_data);
        $folder->setProjectId(active_project()->getId());
        
        try {
          DB::beginWork();
          $folder->save();
          ApplicationLogs::createLog($folder, active_project(), ApplicationLogs::ACTION_EDIT);
          DB::commit();
          
          flash_success(lang('success edit folder', $old_name));
          $this->redirectToUrl($folder->getBrowseUrl());
        } catch(Exception $e) {
          DB::rollback();
          tpl_assign('error', $e);
        } // try
      } // if
    } // edit_folder
    
    /**
    * Delete folder
    *
    * @access public
    * @param void
    * @return null
    */
    function delete_folder() {
      $folder = ProjectFolders::findById(get_id());
      if(!($folder instanceof ProjectFolder)) {
        flash_error(lang('folder dnx'));
        $this->redirectTo('files');
      } // if
      
      if(!$folder->canDelete(logged_user())) {
        flash_error(lang('no access permissions'));
        $this->redirectToReferer(get_url('files'));
      } // if
      
      try {
        DB::beginWork();
        $folder->delete();
        ApplicationLogs::createLog($folder, active_project(), ApplicationLogs::ACTION_DELETE);
        DB::commit();
        
        flash_success(lang('success delete folder', $folder->getName()));
      } catch(Exception $e) {
        DB::rollback();
        flash_error(lang('error delete folder'));
      } // try
      
      $this->redirectTo('files');
    } // delete_folder
    
    // ---------------------------------------------------
    //  Files
    // ---------------------------------------------------
    
    /**
    * Show file details
    *
    * @param void
    * @return null
    */
    function file_details() {
      $this->addHelper('textile');
      
      $file = ProjectFiles::findById(get_id());
      if(!($file instanceof ProjectFile)) {
        flash_error(lang('file dnx'));
        $this->redirectToReferer(get_url('files'));
      } // if
      
      if(!$file->canView(logged_user())) {
        flash_error(lang('no access permissions'));
        $this->redirectToReferer(get_url('files'));
      } // if
      
      $revisions = $file->getRevisions();
      if(!count($revisions)) {
        flash_error(lang('no file revisions in file'));
        $this->redirectToReferer(get_url('files'));
      } // if
      
      tpl_assign('file', $file);
      tpl_assign('folder', $file->getFolder());
      tpl_assign('last_revision', $file->getLastRevision());
      tpl_assign('revisions', $revisions);
      
      // This variables are required for the sidebar
      tpl_assign('current_folder', $file->getFolder());
      tpl_assign('order', null);
      tpl_assign('page', null);
      tpl_assign('folders', active_project()->getFolders());
      tpl_assign('important_files', active_project()->getImportantFiles());
      
      $this->setSidebar(get_template_path('index_sidebar', 'files'));
    } // file_details
    
    function slideshow()
    {
	     $file = ProjectFiles::findById(get_id());
	     $_SESSION["s5content"]= $file->getFileContent();

	      //header('location: ');
		$this->redirectToUrl('slime/slideshow.php');
    }//slideshow
    
    
    /**
    * Download specific file
    *
    * @param void
    * @return null
    */
    function download_file() {
      $inline = (boolean) array_var($_GET, 'inline', false);
      
      $file = ProjectFiles::findById(get_id());
      if(!($file instanceof ProjectFile)) {
        flash_error(lang('file dnx'));
        $this->redirectToReferer(get_url('files'));
      } // if
      
      if(!$file->canDownload(logged_user())) {
        flash_error(lang('no access permissions'));
        $this->redirectToReferer(get_url('files'));
      } // if
      
      download_contents($file->getFileContent(), $file->getTypeString(), $file->getFilename(), $file->getFileSize(), !$inline);
      die();
    } // download_file
    
    /**
    * Download specific revision
    *
    * @param void
    * @return null
    */
    function download_revision() {
      $revision = ProjectFileRevisions::findById(get_id());
      if(!($revision instanceof ProjectFileRevision)) {
        flash_error(lang('file revision dnx'));
        $this->redirectToReferer(get_url('files'));
      } // if
      
      $file = $revision->getFile();
      if(!($file instanceof ProjectFile)) {
        flash_error(lang('file dnx'));
        $this->redirectToReferer(get_url('files'));
      } // if
      
      if(!($revision->canDownload(logged_user()))) {
        flash_error(lang('no access permissions'));
        $this->redirectToReferer(get_url('files'));
      } // if
      
      download_contents($revision->getFileContent(), $revision->getTypeString(), $file->getFilename(), $file->getFileSize());
      die();
    } // download_revision
    
    /**
    * Add file
    *
    * @access public
    * @param void
    * @return null
    */
    function add_file() {
      if(!ProjectFile::canAdd(logged_user(), active_project())) {
        flash_error(lang('no access permissions'));
        $this->redirectToReferer(get_url('files'));
      } // if      
      $file = new ProjectFile();
      $file_data = array_var($_POST, 'file');      
      $folder = null;
      $folder_id = get_id('folder_id');
      if($folder_id) {
        $folder = ProjectFolders::findById($folder_id);
      } // if
      
      if(($folder instanceof ProjectFolder) && !is_array($file_data)) {
        $file_data = array(
          'folder_id' => $folder->getId()
        ); // array
      } // if
      
      tpl_assign('file', $file);
      tpl_assign('file_data', $file_data);
      
      if(is_array(array_var($_POST, 'file'))) {
        try {
          DB::beginWork();
          $uploaded_file = array_var($_FILES, 'file_file');
          $file->setFromAttributes($file_data);
          
          if(!logged_user()->isMemberOfOwnerCompany()) {
            $file->setIsPrivate(false);
            $file->setIsImportant(false);
            $file->setCommentsEnabled(true);
            $file->setAnonymousCommentsEnabled(false);
          } // if
          $file->setFilename(array_var($uploaded_file, 'name'));
          $file->setProjectId(active_project()->getId());
          $file->setIsVisible(true);
          $file->save();
          
          $file->setTagsFromCSV(array_var($file_data, 'tags'));
          $revision = $file->handleUploadedFile($uploaded_file, true); // handle uploaded file
          
          ApplicationLogs::createLog($file, active_project(), ApplicationLogs::ACTION_ADD);
          DB::commit();
          
          flash_success(lang('success add file', $file->getFilename()));
          $this->redirectToUrl($file->getDetailsUrl());
        } catch(Exception $e) {
          DB::rollback();
          tpl_assign('error', $e);
          tpl_assign('file', new ProjectFile()); // reset file
          
          // If we uploaded the file remove it from repository
          if(isset($revision) && ($revision instanceof ProjectFileRevision) && FileRepository::isInRepository($revision->getRepositoryId())) {
            FileRepository::deleteFile($revision->getRepositoryId());
          } // if
        } // try
      } // if
    } // add_file

    
    
	function save_document()
	{
		if(get_id()>0)
		{ //edit document
		  //if(is_array(array_var($_POST, 'file'))) {
		  
	        try {
	          $file = ProjectFiles::findById(get_id());
//	          $old_is_private = $file->isPrivate();
//	          $old_is_important = $file->getIsImportant();
//	          $old_comments_enabled = $file->getCommentsEnabled();
//	          $old_anonymous_comments_enabled = $file->getAnonymousCommentsEnabled();
	          DB::beginWork();
	          $post_revision      = array_var($_POST, 'new_revision_document') == 'checked'; // change file?
//	          $post_revision    = $handle_file && array_var($file_data, 'version_file_change') == 'checked'; // post revision?
//	          $revision_comment = $post_revision ? trim(array_var($file_data, 'revision_comment')) : ''; // user comment?
	          //$post_revision = true;
	          $revision_comment = '';
	          //$file->setFromAttributes($file_data);
	          
	         // if(!logged_user()->isMemberOfOwnerCompany()) {
//	            $file->setIsPrivate($old_is_private);
//	            $file->setIsImportant($old_is_important);
//	            $file->setCommentsEnabled($old_comments_enabled);
//	            $file->setAnonymousCommentsEnabled($old_anonymous_comments_enabled);
	        //  } // if
   		      $file_dt['name']=$file->getFilename();
		      $file_content=array_var($_POST, 'FCKeditor1');
		      $file_dt['size']=strlen($file_content);
		      $file_dt['type']='txt';
	          $file_dt['tmp_name'] =     './tmp/' . rand () ;
			  $handler=fopen($file_dt['tmp_name'], 'w');
			  fputs($handler,$file_content);
			  fclose($handler);
	          $file->save();
	          //$file->setTagsFromCSV(array_var($file_data, 'tags'));
//	          if($handle_file) {
	          $file->handleUploadedFile($file_dt, $post_revision, $revision_comment);
//	          } // if
	          ApplicationLogs::createLog($file, active_project(), ApplicationLogs::ACTION_EDIT);
	          DB::commit();
		      unlink($file_dt['tmp_name']);
	          
	          flash_success(lang('success add file', $file->getFilename()));
	          $this->redirectToUrl($file->getDetailsUrl());
	        } catch(Exception $e) {
	          //@unlink($file->getFilePath());
	          DB::rollback();
		      unlink($file_dt['tmp_name']);
	          tpl_assign('error', $e);
	        } // try
    	  //} // if
		}
		else 
		{ //new document
		      if(!ProjectFile::canAdd(logged_user(), active_project())) {
		        flash_error(lang('no access permissions'));
		        $this->redirectToReferer(get_url('files'));
		      } // if
		      
		      //armo el objeto file
		      $file = new ProjectFile();
		      $postFile=array_var($_POST,'file');      
		      $file->setFilename(array_var($postFile,'name'));      
		      $file->setProjectId(active_project()->getId());
		      $file->setIsVisible(true);
		      
		    //  if(!logged_user()->isMemberOfOwnerCompany()) {
		      		$file->setIsPrivate(false);
		            $file->setIsImportant(false);
		            $file->setCommentsEnabled(true);
		            $file->setAnonymousCommentsEnabled(false);
		      //} // if      
		      
		      
		      /*Busco la carpeta destino*/    
		      $folder = null;
		      $folder_id = get_id('file[folder_id]'); //este parametro tendira que venir por GET
		      if($folder_id) {
		        $folder = ProjectFolders::findById($folder_id);
		      } // if
		      if(($folder instanceof ProjectFolder) && !is_array($file_data)) {
		        $file_data = array(
		          'folder_id' => $folder->getId()
		        ); // array
		      } // if
		      
		     
		      //seteo esto para despues setear atributos
		      $file_content=array_var($_POST, 'FCKeditor1');
		      $file_dt['name']=array_var($postFile,'name');
		      $file_dt['size']=strlen($file_content);
		      $file_dt['type']='txt';
		     // $file_dt['content']=$file_content;
		      
		      
		      
		      $file->setCreatedOn(new DateTimeValue(time()) );
		      tpl_assign('file', $file);
		      tpl_assign('file_data', $file_data);
		 	  try {
		          DB::beginWork();
				$file_dt['tmp_name'] =     './tmp/' . array_var($postFile,'name');
				$handler=fopen($file_dt['tmp_name'], 'w');
				fputs($handler,array_var($_POST,'FCKeditor1'));
				fclose($handler);
		          //$uploaded_file = stripslashes( $_POST['FCKeditor1'] ); //array_var($_FILES, 'file_file');
		          
		          //$file->setFromAttributes($file_data);
		          $file->save();
		          $file->setTagsFromCSV('');//         TODO: $file->setTagsFromCSV(array_var($file_data, 'tags'));
		          $revision = $file->handleUploadedFile($file_dt, true); // handle uploaded file
		          ApplicationLogs::createLog($file, active_project(), ApplicationLogs::ACTION_ADD);
		          DB::commit();
		          flash_success(lang('success add file', $file->getFilename()));
					unlink($file_dt['tmp_name']);
		          $this->redirectToUrl($file->getDetailsUrl());
		        } catch(Exception $e) {
		          DB::rollback();
		
		          tpl_assign('error', $e);
		          tpl_assign('file', new ProjectFile()); // reset file
		          unlink($file_dt['tmp_name']);
		          // If we uploaded the file remove it from repository
		          if(isset($revision) && ($revision instanceof ProjectFileRevision) && FileRepository::isInRepository($revision->getRepositoryId())) {
		            FileRepository::deleteFile($revision->getRepositoryId());
		          } // if
		        } // try
		      //} // if
		   //  else echo "MALLLL no es array!!";
		}
	}
		
	function save_spreadsheet()
	{
		if(get_id()>0)
		{ //edit spreadsheet
		  //if(is_array(array_var($_POST, 'file'))) {
		  
	        try {
	          $file = ProjectFiles::findById(get_id());
//	          $old_is_private = $file->isPrivate();
//	          $old_is_important = $file->getIsImportant();
//	          $old_comments_enabled = $file->getCommentsEnabled();
//	          $old_anonymous_comments_enabled = $file->getAnonymousCommentsEnabled();
	          DB::beginWork();
	          $post_revision      = array_var($_POST, 'new_revision_spreadsheet') == 'checked'; // change file?
//	          $post_revision    = $handle_file && array_var($file_data, 'version_file_change') == 'checked'; // post revision?
//	          $revision_comment = $post_revision ? trim(array_var($file_data, 'revision_comment')) : ''; // user comment?
	          //$post_revision = true;
	          $revision_comment = '';
	          //$file->setFromAttributes($file_data);
	          
	         // if(!logged_user()->isMemberOfOwnerCompany()) {
//	            $file->setIsPrivate($old_is_private);
//	            $file->setIsImportant($old_is_important);
//	            $file->setCommentsEnabled($old_comments_enabled);
//	            $file->setAnonymousCommentsEnabled($old_anonymous_comments_enabled);
	        //  } // if
   		      $file_dt['name']=$file->getFilename();
		      $file_content=array_var($_POST,"TrimSpreadsheet");
		      $file_dt['size']=strlen($file_content);
		      $file_dt['type']='sprd';
	          $file_dt['tmp_name'] =     './tmp/' . rand () ;
			  $handler=fopen($file_dt['tmp_name'], 'w');
			  fputs($handler,$file_content);
			  fclose($handler);
	          $file->save();
	          //$file->setTagsFromCSV(array_var($file_data, 'tags'));
//	          if($handle_file) {
	          $file->handleUploadedFile($file_dt, $post_revision, $revision_comment);
//	          } // if
	          ApplicationLogs::createLog($file, active_project(), ApplicationLogs::ACTION_EDIT);
	          DB::commit();
		      unlink($file_dt['tmp_name']);
	          
	          flash_success(lang('success add file', $file->getFilename()));
	          $this->redirectToUrl($file->getDetailsUrl());
	        } catch(Exception $e) {
	          //@unlink($file->getFilePath());
	          DB::rollback();
		      unlink($file_dt['tmp_name']);
	          tpl_assign('error', $e);
	        } // try
    	  //} // if
		}
		else 
		{ //new spreadsheet
		      if(!ProjectFile::canAdd(logged_user(), active_project())) {
		        flash_error(lang('no access permissions'));
		        $this->redirectToReferer(get_url('files'));
		      } // if
		      
		      //armo el objeto file
		      $file = new ProjectFile();
		      $postFile=array_var($_POST,'file');      
		      $file->setFilename(array_var($postFile,'name'));      
		      $file->setProjectId(active_project()->getId());
		      $file->setIsVisible(true);
		      
		      //if(!logged_user()->isMemberOfOwnerCompany()) {
		      		$file->setIsPrivate(false);
		            $file->setIsImportant(false);
		            $file->setCommentsEnabled(true);
		            $file->setAnonymousCommentsEnabled(false);
		     // } // if      
		      
		      
		      /*Busco la carpeta destino*/    
		      $folder = null;
		      $folder_id = get_id('file[folder_id]'); //este parametro tendira que venir por GET
		      if($folder_id) {
		        $folder = ProjectFolders::findById($folder_id);
		      } // if
		      if(($folder instanceof ProjectFolder) && !is_array($file_data)) {
		        $file_data = array(
		          'folder_id' => $folder->getId()
		        ); // array
		      } // if
		      
		     
		      //seteo esto para despues setear atributos
		      $file_content=array_var($_POST,"TrimSpreadsheet");
		      $file_dt['name']=array_var($postFile,'name');
		      $file_dt['size']=strlen($file_content);
		      $file_dt['type']='sprd';
		     // $file_dt['content']=$file_content;
		      
		      
		      
		      $file->setCreatedOn(new DateTimeValue(time()) );
		      tpl_assign('file', $file);
		      //tpl_assign('file_data', $file_data);
		 	  try {
		          DB::beginWork();
				$file_dt['tmp_name'] =     './tmp/' . array_var($postFile,'name');
				$handler=fopen($file_dt['tmp_name'], 'w');
				fputs($handler,array_var($_POST,"TrimSpreadsheet"));
				fclose($handler);
		          //$uploaded_file = stripslashes( $_POST['FCKeditor1'] ); //array_var($_FILES, 'file_file');
		          
		          //$file->setFromAttributes($file_data);
		          $file->save();
		          $file->setTagsFromCSV('');//          $file->setTagsFromCSV(array_var($file_data, 'tags'));
		          $revision = $file->handleUploadedFile($file_dt, true); // handle uploaded file
		          ApplicationLogs::createLog($file, active_project(), ApplicationLogs::ACTION_ADD);
		          DB::commit();
		          unlink($file_dt['tmp_name']);
		          flash_success(lang('success add file', $file->getFilename()));		
		          $this->redirectToUrl($file->getDetailsUrl());
		        } catch(Exception $e) {
		          DB::rollback();
		
		          tpl_assign('error', $e);
		          tpl_assign('file', new ProjectFile()); // reset file
		          unlink($file_dt['tmp_name']);
		          // If we uploaded the file remove it from repository
		          if(isset($revision) && ($revision instanceof ProjectFileRevision) && FileRepository::isInRepository($revision->getRepositoryId())) {
		            FileRepository::deleteFile($revision->getRepositoryId());
		          } // if
		        } // try
		      //} // if
			}//new spreadsheet
		}
		
	function save_presentation()
	{
		if(get_id() > 0)
		{ //edit presentation
		  //if(is_array(array_var($_POST, 'file'))) {
		  
	        try {
	          $file = ProjectFiles::findById(get_id());
//	          $old_is_private = $file->isPrivate();
//	          $old_is_important = $file->getIsImportant();
//	          $old_comments_enabled = $file->getCommentsEnabled();
//	          $old_anonymous_comments_enabled = $file->getAnonymousCommentsEnabled();
	          DB::beginWork();
	          $post_revision      = array_var($_POST, 'new_revision_document') == 'checked'; // change file?
//	          $post_revision    = $handle_file && array_var($file_data, 'version_file_change') == 'checked'; // post revision?
//	          $revision_comment = $post_revision ? trim(array_var($file_data, 'revision_comment')) : ''; // user comment?
	          //$post_revision = true;
	          $revision_comment = '';
	          //$file->setFromAttributes($file_data);
	          
	         // if(!logged_user()->isMemberOfOwnerCompany()) {
//	            $file->setIsPrivate($old_is_private);
//	            $file->setIsImportant($old_is_important);
//	            $file->setCommentsEnabled($old_comments_enabled);
//	            $file->setAnonymousCommentsEnabled($old_anonymous_comments_enabled);
	        //  } // if
   		      $file_dt['name']=$file->getFilename();
		      $file_content = unescapeS5(array_var($_POST, 's5content'));
   		      $file_dt['size']=strlen($file_content);
		      $file_dt['type']='prsn';
	          $file_dt['tmp_name'] =     './tmp/' . rand () ;
			  $handler=fopen($file_dt['tmp_name'], 'w');
			  fputs($handler,$file_content);
			  fclose($handler);
	          $file->save();
	          //$file->setTagsFromCSV(array_var($file_data, 'tags'));
//	          if($handle_file) {
	          $file->handleUploadedFile($file_dt, $post_revision, $revision_comment);
//	          } // if
	          ApplicationLogs::createLog($file, active_project(), ApplicationLogs::ACTION_EDIT);
	          DB::commit();
		      unlink($file_dt['tmp_name']);
	          
	          flash_success(lang('success add file', $file->getFilename()));
	          $this->redirectToUrl($file->getDetailsUrl());
	        } catch(Exception $e) {
	          //@unlink($file->getFilePath());
	          DB::rollback();
		      unlink($file_dt['tmp_name']);
	          tpl_assign('error', $e);
	        } // try
    	  //} // if
		}
		else 
		{ //new presentation
		      if(!ProjectFile::canAdd(logged_user(), active_project())) {
		        flash_error(lang('no access permissions'));
		        $this->redirectToReferer(get_url('files'));
		      } // if
		      
		      //armo el objeto file
		      $file = new ProjectFile();
		      $postFile=array_var($_POST,'file');      
		      $file->setFilename(array_var($postFile,'name'));      
		      $file->setProjectId(active_project()->getId());
		      $file->setIsVisible(true);
		      
		    //  if(!logged_user()->isMemberOfOwnerCompany()) {
		      		$file->setIsPrivate(false);
		            $file->setIsImportant(false);
		            $file->setCommentsEnabled(true);
		            $file->setAnonymousCommentsEnabled(false);
		      //} // if      
		      
		      
		      /*Busco la carpeta destino*/    
		      $folder = null;
		      $folder_id = get_id('file[folder_id]'); //este parametro tendira que venir por GET
		      if($folder_id) {
		        $folder = ProjectFolders::findById($folder_id);
		      } // if
		      if(($folder instanceof ProjectFolder) && !is_array($file_data)) {
		        $file_data = array(
		          'folder_id' => $folder->getId()
		        ); // array
		      } // if
		      
		     
		      //seteo esto para despues setear atributos
		      $file_content=array_var($_POST, 's5content');
		      $file_dt['name']=array_var($postFile,'name');
		      $file_dt['size']=strlen($file_content);
		      $file_dt['type']='prsn';
		     // $file_dt['content']=$file_content;
		      
		      
		      
		      $file->setCreatedOn(new DateTimeValue(time()) );
		      tpl_assign('file', $file);
		      tpl_assign('file_data', $file_data);
		 	  try {
		          DB::beginWork();
				$file_dt['tmp_name'] =     './tmp/' . array_var($postFile,'name');
				$handler=fopen($file_dt['tmp_name'], 'w');
				fputs($handler,$file_content);
				fclose($handler);
		          //$uploaded_file = stripslashes( $_POST['FCKeditor1'] ); //array_var($_FILES, 'file_file');
		          
		          //$file->setFromAttributes($file_data);
		          $file->save();
		          $file->setTagsFromCSV('');//         TODO: $file->setTagsFromCSV(array_var($file_data, 'tags'));
		          $revision = $file->handleUploadedFile($file_dt, true); // handle uploaded file
		          ApplicationLogs::createLog($file, active_project(), ApplicationLogs::ACTION_ADD);
		          DB::commit();
		          flash_success(lang('success add file', $file->getFilename()));
					unlink($file_dt['tmp_name']);
		          $this->redirectToUrl($file->getDetailsUrl());
		        } catch(Exception $e) {
		          DB::rollback();
		
		          tpl_assign('error', $e);
		          tpl_assign('file', new ProjectFile()); // reset file
		          unlink($file_dt['tmp_name']);
		          // If we uploaded the file remove it from repository
		          if(isset($revision) && ($revision instanceof ProjectFileRevision) && FileRepository::isInRepository($revision->getRepositoryId())) {
		            FileRepository::deleteFile($revision->getRepositoryId());
		          } // if
		        } // try
		      //} // if
		   //  else echo "MALLLL no es array!!";
		}
	}
		

    function add_document() {
      if(get_id()>0)
      {//open a document

	      	      $this->setTemplate('add_document');
	      
	      $file = ProjectFiles::findById(get_id());
	      if(!($file instanceof ProjectFile)) {
	        flash_error(lang('file dnx'));
	        $this->redirectToReferer(get_url('files'));
	      } // if
	      
	      if(!$file->canEdit(logged_user())) {
	        flash_error(lang('no access permissions'));
	        $this->redirectToReferer(get_url('files'));
	      } // if
	      
	      $file_data = array_var($_POST, 'file');
	      if(!is_array($file_data)) {
	        $tag_names = $file->getTagNames();
	        $file_data = array(
	          'folder_id' => $file->getFolderId(),
	          'description' => $file->getDescription(),
	          'is_private' => $file->getIsPrivate(),
	          'is_important' => $file->getIsImportant(),
	          'comments_enabled' => $file->getCommentsEnabled(),
	          'anonymous_comments_enabled' => $file->getAnonymousCommentsEnabled(),
	          'tags' => is_array($tag_names) && count($tag_names) ? implode(', ', $tag_names) : '',
	        ); // array
	      } // if
	      
	      tpl_assign('file', $file);
	      tpl_assign('file_data', $file_data);
	      
      }//end open document
      else 
      {//new document
	      if(!ProjectFile::canAdd(logged_user(), active_project())) {
	        flash_error(lang('no access permissions'));
	        $this->redirectToReferer(get_url('files'));
	      } // if
	      
	      $file = new ProjectFile();
	      $file_data = array_var($_POST, 'file');
	
		  $folder = null;
	      $folder_id = get_id('folder_id');
	      if($folder_id) {
	        $folder = ProjectFolders::findById($folder_id);
	      } // if
	      
	      if(($folder instanceof ProjectFolder) && !is_array($file_data)) {
	        $file_data = array(
	          'folder_id' => $folder->getId()
	        ); // array
	      } // if
	      
	      tpl_assign('file', $file);
	      tpl_assign('file_data', $file_data);
      }//end new document
    } // add_document

    
    function add_spreadsheet() {
    	if(get_id()>0)
  		{//open a spreadsheet
      	    $this->setTemplate('add_spreadsheet');	      
      		$file = ProjectFiles::findById(get_id());
      		
	      	 if(!($file instanceof ProjectFile)) {
		        flash_error(lang('file dnx'));
		        $this->redirectToReferer(get_url('files'));
		     } // if
		      
		     if(!$file->canEdit(logged_user())) {
		        flash_error(lang('no access permissions'));
		        $this->redirectToReferer(get_url('files'));
		     } // if
		      
		     $file_data = array_var($_POST, 'file');
		     if(!is_array($file_data)) {
		        $tag_names = $file->getTagNames();
		        $file_data = array(
		          'folder_id' => $file->getFolderId(),
		          'description' => $file->getDescription(),
		          'is_private' => $file->getIsPrivate(),
		          'is_important' => $file->getIsImportant(),
		          'comments_enabled' => $file->getCommentsEnabled(),
		          'anonymous_comments_enabled' => $file->getAnonymousCommentsEnabled(),
		          'tags' => is_array($tag_names) && count($tag_names) ? implode(', ', $tag_names) : '',
		        ); // array
		     } // if
		     tpl_assign('file', $file);
		     tpl_assign('file_data', $file_data);
  		}
		else 
		{	// edit a spreadsheet
		      if(!ProjectFile::canAdd(logged_user(), active_project())) {
		        flash_error(lang('no access permissions'));
		        $this->redirectToReferer(get_url('files'));
		      } // if
		      
		      $file = new ProjectFile();
		      $file_data = array_var($_POST, 'file');
		
			$folder = null;
		      $folder_id = get_id('folder_id');
		      if($folder_id) {
		        $folder = ProjectFolders::findById($folder_id);
		      } // if
		      
		      if(($folder instanceof ProjectFolder) && !is_array($file_data)) {
		        $file_data = array(
		          'folder_id' => $folder->getId()
		        ); // array
		      } // if
		      
		      tpl_assign('file', $file);
		      tpl_assign('file_data', $file_data);
		}
    } // add_spreadsheet

    function add_presentation() {
    	if(get_id()>0)
    	{ //open presentation
      	    $this->setTemplate('add_presentation');	      
      		$file = ProjectFiles::findById(get_id());
      		
	      	 if(!($file instanceof ProjectFile)) {
		        flash_error(lang('file dnx'));
		        $this->redirectToReferer(get_url('files'));
		     } // if
		      
		     if(!$file->canEdit(logged_user())) {
		        flash_error(lang('no access permissions'));
		        $this->redirectToReferer(get_url('files'));
		     } // if
		      
		     $file_data = array_var($_POST, 'file');
		     if(!is_array($file_data)) {
		        $tag_names = $file->getTagNames();
		        $file_data = array(
		          'folder_id' => $file->getFolderId(),
		          'description' => $file->getDescription(),
		          'is_private' => $file->getIsPrivate(),
		          'is_important' => $file->getIsImportant(),
		          'comments_enabled' => $file->getCommentsEnabled(),
		          'anonymous_comments_enabled' => $file->getAnonymousCommentsEnabled(),
		          'tags' => is_array($tag_names) && count($tag_names) ? implode(', ', $tag_names) : '',
		        ); // array
		     } // if
		     tpl_assign('file', $file);
		     tpl_assign('file_data', $file_data);
    	}
    	else 
    	{ //new presentation    		
	      if(!ProjectFile::canAdd(logged_user(), active_project())) {
	        flash_error(lang('no access permissions'));
	        $this->redirectToReferer(get_url('files'));
	      } // if
	      
	      $file = new ProjectFile();
	      $file_data = array_var($_POST, 'file');
	
		 $folder = null;
	      $folder_id = get_id('folder_id');
	      if($folder_id) {
	        $folder = ProjectFolders::findById($folder_id);
	      } // if
	      
	      if(($folder instanceof ProjectFolder) && !is_array($file_data)) {
	        $file_data = array(
	          'folder_id' => $folder->getId()
	        ); // array
	      } // if
	      
	      tpl_assign('file', $file);
	      tpl_assign('file_data', $file_data);
    	}
    }
        
        
    /**
    * Edit file properties
    *
    * @access public
    * @param void
    * @return null
    */
    function edit_file() {
      $this->setTemplate('add_file');
      
      $file = ProjectFiles::findById(get_id());
      if(!($file instanceof ProjectFile)) {
        flash_error(lang('file dnx'));
        $this->redirectToReferer(get_url('files'));
      } // if
      
      if(!$file->canEdit(logged_user())) {
        flash_error(lang('no access permissions'));
        $this->redirectToReferer(get_url('files'));
      } // if
      
      $file_data = array_var($_POST, 'file');
      if(!is_array($file_data)) {
        $tag_names = $file->getTagNames();
        $file_data = array(
          'folder_id' => $file->getFolderId(),
          'description' => $file->getDescription(),
          'is_private' => $file->getIsPrivate(),
          'is_important' => $file->getIsImportant(),
          'comments_enabled' => $file->getCommentsEnabled(),
          'anonymous_comments_enabled' => $file->getAnonymousCommentsEnabled(),
          'tags' => is_array($tag_names) && count($tag_names) ? implode(', ', $tag_names) : '',
        ); // array
      } // if
      
      tpl_assign('file', $file);
      tpl_assign('file_data', $file_data);
      
      if(is_array(array_var($_POST, 'file'))) {
        try {
          $old_is_private = $file->isPrivate();
          $old_is_important = $file->getIsImportant();
          $old_comments_enabled = $file->getCommentsEnabled();
          $old_anonymous_comments_enabled = $file->getAnonymousCommentsEnabled();
          
          DB::beginWork();
          $handle_file      = array_var($file_data, 'update_file') == 'checked'; // change file?
          $post_revision    = $handle_file && array_var($file_data, 'version_file_change') == 'checked'; // post revision?
          $revision_comment = $post_revision ? trim(array_var($file_data, 'revision_comment')) : ''; // user comment?
          
          $file->setFromAttributes($file_data);
          
          if(!logged_user()->isMemberOfOwnerCompany()) {
            $file->setIsPrivate($old_is_private);
            $file->setIsImportant($old_is_important);
            $file->setCommentsEnabled($old_comments_enabled);
            $file->setAnonymousCommentsEnabled($old_anonymous_comments_enabled);
          } // if
          $file->save();
          $file->setTagsFromCSV(array_var($file_data, 'tags'));
          if($handle_file) {
            $file->handleUploadedFile(array_var($_FILES, 'file_file'), $post_revision, $revision_comment);
          } // if
          ApplicationLogs::createLog($file, active_project(), ApplicationLogs::ACTION_EDIT);
          DB::commit();
          
          flash_success(lang('success add file', $file->getFilename()));
          $this->redirectToUrl($file->getDetailsUrl());
        } catch(Exception $e) {
          //@unlink($file->getFilePath());
          DB::rollback();
          tpl_assign('error', $e);
        } // try
      } // if
    } // edit_file
    
    /**
    * Delete file
    *
    * @access public
    * @param void
    * @return null
    */
    function delete_file() {
      $file = ProjectFiles::findById(get_id());
      if(!($file instanceof ProjectFile)) {
        flash_error(lang('file dnx'));
        $this->redirectToReferer(get_url('files'));
      } // if
      
      if(!$file->canEdit(logged_user())) {
        flash_error(lang('no access permissions'));
        $this->redirectToReferer(get_url('files'));
      } // if
      
      try {
        DB::beginWork();
        $file->delete();
        ApplicationLogs::createLog($file, $file->getProject(), ApplicationLogs::ACTION_DELETE);
        DB::commit();
        
        flash_success(lang('success delete file', $file->getFilename()));
      } catch(Exception $e) {
        flash_error(lang('error delete file'));
      } // try
      
      $this->redirectTo('files');
    } // delete_file
    
    // ---------------------------------------------------
    //  Revisions
    // ---------------------------------------------------
    
    /**
    * Update file revision (comment)
    *
    * @param void
    * @return null
    */
    function edit_file_revision() {
      $this->setTemplate('add_file_revision');
      
      $revision = ProjectFileRevisions::findById(get_id());
      if(!($revision instanceof ProjectFileRevision)) {
        flash_error(lang('file revision dnx'));
        $this->redirectToReferer(get_url('files'));
      } // if
      
      $file = $revision->getFile();
      if(!($file instanceof ProjectFile)) {
        flash_error(lang('file dnx'));
        $this->redirectToReferer(get_url('files'));
      } // if
      
      if(!$revision->canDelete(logged_user())) {
        flash_error(lang('no access permissions'));
        $this->redirectToReferer(get_url('files'));
      } // if
      
      $revision_data = array_var($_POST, 'revision');
      if(!is_array($revision_data)) {
        $revision_data = array(
          'comment' => $revision->getComment(),
        ); // array
      } // if
      
      tpl_assign('revision', $revision);
      tpl_assign('file', $file);
      tpl_assign('revision_data', $revision_data);
      
      if(is_array(array_var($_POST, 'revision'))) {
        try {
          DB::beginWork();
          $revision->setComment(array_var($revision_data, 'comment'));
          $revision->save();
          ApplicationLogs::createLog($revision, $revision->getProject(), ApplicationLogs::ACTION_EDIT, $revision->isPrivate());
          DB::commit();
          
          flash_success(lang('success edit file revision'));
          $this->redirectToUrl($revision->getDetailsUrl());
        } catch(Exception $e) {
          tpl_assign('error', $e);
          DB::rollback();
        } // try
      } // if
    } // edit_file_revision
    
    /**
    * Delete selected revision (if you have proper permissions)
    *
    * @param void
    * @return null
    */
    function delete_file_revision() {
      $revision = ProjectFileRevisions::findById(get_id());
      if(!($revision instanceof ProjectFileRevision)) {
        flash_error(lang('file revision dnx'));
        $this->redirectToReferer(get_url('files'));
      } // if
      
      $file = $revision->getFile();
      if(!($file instanceof ProjectFile)) {
        flash_error(lang('file dnx'));
        $this->redirectToReferer(get_url('files'));
      } // if
      
      $all_revisions = $file->getRevisions();
      if(count($all_revisions) == 1) {
        flash_error(lang('cant delete only revision'));
        $this->redirectToReferer($file->getDetailsUrl());
      } // if
      
      if(!$revision->canDelete(logged_user())) {
        flash_error(lang('no access permissions'));
        $this->redirectToReferer(get_url('files'));
      } // if
      
      try {
        DB::beginWork();
        $revision->delete();
        ApplicationLogs::createLog($revision, $revision->getProject(), ApplicationLogs::ACTION_DELETE);
        DB::commit();
        
        flash_success(lang('success delete file revision'));
      } catch(Exception $e) {
        DB::rollback();
        flash_error(lang('error delete file revision'));
      } // try
      
      $this->redirectToUrl($file->getDetailsUrl());
    } // delete_file_revision
    
    // ---------------------------------------------------
    //  Attach / detach
    // ---------------------------------------------------
    
    /**
    * Attach files to the object
    *
    * @param void
    * @return null
    */
    function attach_to_object() {
      $manager_class = array_var($_GET, 'manager');
      $object_id = get_id('object_id');
      
      $object = get_object_by_manager_and_id($object_id, $manager_class);
      if(!($object instanceof ProjectDataObject)) {
        flash_error(lang('no access permissions'));
        $this->redirectToReferer(get_url('dashboard'));
      } // if
      
      $already_attached_files = $object->getAttachedFiles();
      $already_attached_file_ids = null;
      if(is_array($already_attached_files)) {
        $already_attached_file_ids = array();
        foreach($already_attached_files as $already_attached_file) {
          $already_attached_file_ids[] = $already_attached_file->getId();
        } // foreach
      } // if
      
      $attach_data = array_var($_POST, 'attach');
      if(!is_array($attach_data)) {
        $attach_data = array('what' => 'existing_file');
      } // if
      
      tpl_assign('attach_to_object', $object);
      tpl_assign('attach_data', $attach_data);
      tpl_assign('already_attached_file_ids', $already_attached_file_ids);
      
      if(is_array(array_var($_POST, 'attach'))) {
        $attach_files = array();
          
        if(array_var($attach_data, 'what') == 'existing_file') {
          $file = ProjectFiles::findById(array_var($attach_data, 'file_id'));
          if(!($file instanceof ProjectFile)) {
            flash_error(lang('no files to attach'));
            $this->redirectToUrl($object->getAttachFilesUrl());
          } // if
          $attach_files[] = $file;
        } elseif(array_var($attach_data, 'what') == 'new_file') {
          try {
            $attach_files = ProjectFiles::handleHelperUploads(active_project());
          } catch(Exception $e) {
            flash_error(lang('error upload file'));
            $this->redirectToUrl($object->getAttachFilesUrl());
          } // try
        } // if
        
        if(!is_array($attach_files) || !count($attach_files)) {
          flash_error(lang('no files to attach'));
          $this->redirectToUrl($object->getAttachFilesUrl());
        } // if
        
        try {
          DB::beginWork();
          
          $counter = 0;
          foreach($attach_files as $attach_file) {
            $object->attachFile($attach_file);
            $counter++;
          } // foreach
          
          DB::commit();
          flash_success(lang('success attach files', $counter));
          $this->redirectToUrl($object->getObjectUrl());
          
        } catch(Exception $e) {
          DB::rollback();
          
          if(array_var($attach_data, 'what') == 'new_file' && count($attach_files)) {
            foreach($attach_files as $attach_file) {
              $attach_file->delete();
            } // foreach
          } // if
          
          tpl_assign('error', $e);
        } // try
      } // if
    } // attach_to_object
    
    /**
    * Detach file from related object
    *
    * @param void
    * @return null
    */
    function detach_from_object() {
      $manager_class = array_var($_GET, 'manager');
      $object_id = get_id('object_id');
      $file_id = get_id('file_id');
      
      $object = get_object_by_manager_and_id($object_id, $manager_class);
      if(!($object instanceof ProjectDataObject)) {
        flash_error(lang('no access permissions'));
        $this->redirectToReferer(get_url('dashboard'));
      } // if
      
      $file = ProjectFiles::findById($file_id);
      if(!($file instanceof ProjectFile)) {
        flash_error(lang('file dnx'));
        $this->redirectToReferer(get_url('dashboard'));
      } // if
      
      $attached_file = AttachedFiles::findById(array(
        'rel_object_manager' => $manager_class,
        'rel_object_id' => $object_id,
        'file_id' => $file_id,
      )); // findById
      
      if(!($attached_file instanceof AttachedFile)) {
        flash_error(lang('file not attached to object'));
        $this->redirectToReferer(get_url('dashboard'));
      } // if
      
      try {
        DB::beginWork();
        $attached_file->delete();
        DB::commit();
        flash_success(lang('success detach file'));
      } catch(Exception $e) {
        flash_error(lang('error detach file'));
        DB::rollback();
      } // try
      
      $this->redirectToReferer($object->getObjectUrl());
    } // detach_from_object
  
  } // FilesController

?>