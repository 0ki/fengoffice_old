<?php


define('MYSQLDUMP_COMMAND', 'mysqldump'); // For Windows: define('MYSQLDUMP_COMMAND', '"c:\Program Files\MySQL\MySQL Server 5.0\bin\mysqldump"');
define('DB_BACKUP_FILENAME', 'db.sql');
define('BACKUP_FOLDER',"tmp/backup");
define('BACKUP_TIME_LIMIT',"300");
define('BACKUP_FILENAME',"opengoo_backup.zip");


/**
 * Backup controller
 *
 * @version 1.0
 * @author Marcos Saiz <marcos.saiz@opengoo.org>
 */
class  BackupController extends ApplicationController {

	/**
	 * Construct the BackupController
	 *
	 * @access public
	 * @param void
	 * @return BackupController
	 */
	function __construct() {
		parent::__construct();
		prepare_company_website_controller($this, 'website');

		// Access permissios
		if(!(logged_user()->isAccountOwner())){
			flash_error(lang('no access permissions'));
			ajx_current("empty");
		} // if
	} // __construct

	
	/**
	 * Shows the backup menu
	 *
	 */
	function index(){
		// Access permissios
		if(!(logged_user()->isAccountOwner())){
			flash_error(lang('no access permissions'));
			ajx_current("empty");
		} // if
		$filename =  BACKUP_FILENAME;
		$folder = BACKUP_FOLDER;
		$last_backup=filectime($folder . '/' .$filename );
		if($last_backup){
			$date = new DateTimeValue($last_backup);
			$date = $date->format("Y/m/d H:i:s");
		}
		tpl_assign('last_backup',$date);
	}
	
	/**
	 * Download bakcup file
	 *
	 */
	function download(){
		// Access permissios
		if(!(logged_user()->isAccountOwner())){
			flash_error(lang('no access permissions'));
			ajx_current("empty");
			return ;
		} // if
		if(!(can_manage_configuration(logged_user()) && can_manage_security(logged_user()))){
			flash_error(lang('no access permissions'));
			ajx_current("empty");
			return ;
		}
		$filename = BACKUP_FOLDER . '/' . BACKUP_FILENAME;
		if(file_exists($filename)){
			$content = file_get_contents($filename);
		}
		else {
			flash_error(lang('file dnx'));
			ajx_current("empty");
			return ;
		}
		
		$last_backup=filectime($filename );
		$date = new DateTimeValue($last_backup);
		$date_str = $date->format("y_m_d");
		
		$size = strlen($content);
		download_contents( $content, 'application/zip', BACKUP_FILENAME , $size, true);
		die();
	}
	
	/**
	 * Delete backup located in tmp/backup
	 *
	 */
	function delete(){
		// Access permissios
		if(!(logged_user()->isAccountOwner())){
			flash_error(lang('no access permissions'));
			ajx_current("empty");
			return ;
		} // if
		$filename = BACKUP_FOLDER .'/'. BACKUP_FILENAME;
		if(is_file($filename)) {
			$ret = unlink($filename);
			if(!$ret){
				$ret = chown($filename,'nobody1234') && unlink($filename);
			}
			
		}
		if(!$ret){
			flash_error(lang('error delete backup'));
		}
		else {
			flash_success(lang('success delete backup'));
		}
		$this->redirectTo('backup');
	}
	
	/**
	 * Launch backup process
	 *
	 */
	function launch(){
		// Access permissios
		if(!(logged_user()->isAccountOwner())){
			flash_error(lang('no access permissions'));
			ajx_current("empty");
			return ;
		} // if
		try{
			$filename = BACKUP_FOLDER .'/'. BACKUP_FILENAME;
			$folder = BACKUP_FOLDER;
			if(!dir($folder)){
				$ret = mkdir($folder);
				if(!$ret){
					flash_error(lang('error create backup folder'));						
					ajx_current("empty");
					return ;	
				}		
			}
			//start backup
			$db_user = DB_USER;
			$db_pass = DB_PASS;
			$db_name = DB_NAME;
			$db_backup = BACKUP_FOLDER .'/'. DB_BACKUP_FILENAME;
			$mysqldump_cmd = MYSQLDUMP_COMMAND;
			set_time_limit(BACKUP_TIME_LIMIT);
			exec("$mysqldump_cmd --user=$db_user --password=$db_pass $db_name > $db_backup",$ret);
			if(filesize ($db_backup)){
				if(file_exists($filename)){
					unlink($filename);
				}
				$ret = $this->create_zip();
				unlink($db_backup);
			}
			else{
				unlink($db_backup);
				flash_error(lang('error db backup'));
				ajx_current("empty");
				return ;
			}
		}
		catch (Exception $ex){
				flash_error(lang('error db backup') . $ex);
				ajx_current("empty");
				return ;
		}
		$this->redirectTo('backup');
	}
	private function create_zip(){		
		$filename = BACKUP_FOLDER .'/'. BACKUP_FILENAME;
		$test = new zip_file($filename);
		$test->set_options(array('inmemory' => 0, 'recurse' => 1, 'storepaths' => 1));
		$test->add_files(array("*")); 
		$test->create_archive();
	}
} // BackupController

?>