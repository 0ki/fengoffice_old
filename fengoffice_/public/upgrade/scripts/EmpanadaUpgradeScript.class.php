<?php

  /**
  * Empanada upgrade script will upgrade OpenGoo 0.8 to OpenGoo 0.9
  *
  * @package ScriptUpgrader.scripts
  * @version 1.0
  * @author Marcos Saiz <marcos.saiz@opengoo.org>
  */
  class EmpanadaUpgradeScript extends ScriptUpgraderScript {
    

    /**
    * Array of files and folders that need to be writable
    *
    * @var array
    */
    private $check_is_writable = array(
      '/config/config.php',
    	'/config',
      '/public/files',
      '/cache',
      '/tmp',
      '/upload'
    ); // array
      
    /**
    * Array of extensions taht need to be loaded
    *
    * @var array
    */
    private $check_extensions = array(
      'mysql', 'gd', 'simplexml'
    ); // array
  
    /**
    * Construct the EmpanadaUpgradeScript
    *
    * @param Output $output
    * @return EmpanadaUpgradeScript
    */
    function __construct(Output $output) {
      parent::__construct($output);
      $this->setVersionFrom('0.8');
      $this->setVersionTo('0.9');
    } // __construct
    
  	function getCheckIsWritable() {
		return $this->check_is_writable;
	}

	function getCheckExtensions() {
		return $this->check_extensions;
	}
    
    /**
    * Execute the script
    *
    * @param void
    * @return boolean
    */
    function execute() {
      // ---------------------------------------------------
      //  Connect to database
      // ---------------------------------------------------
      
      if($this->database_connection = mysql_connect(DB_HOST, DB_USER, DB_PASS)) {
        if(mysql_select_db(DB_NAME, $this->database_connection)) {
          $this->printMessage('Upgrade script has connected to the database.');
        } else {
          $this->printMessage('Failed to select database ' . DB_NAME);
          return false;
        } // if
      } else {
        $this->printMessage('Failed to connect to database');
        return false;
      } // if
      
      // ---------------------------------------------------
      //  Check MySQL version
      // ---------------------------------------------------
      
      $mysql_version = mysql_get_server_info($this->database_connection);
      if($mysql_version && version_compare($mysql_version, '4.1', '>=')) {
        $constants['DB_CHARSET'] = 'utf8';
        @mysql_query("SET NAMES 'utf8'", $this->database_connection);
        tpl_assign('default_collation', $default_collation = 'collate utf8_unicode_ci');
        tpl_assign('default_charset', $default_charset = 'DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci');
      } else {
        tpl_assign('default_collation', $default_collation = '');
        tpl_assign('default_charset', $default_charset = '');
      } // if
      
      tpl_assign('table_prefix', TABLE_PREFIX);
      
      // ---------------------------------------------------
      //  Check test query
      // ---------------------------------------------------
      
      $test_table_name = TABLE_PREFIX . 'test_table';
      $test_table_sql = "CREATE TABLE `$test_table_name` (
        `id` int(10) unsigned NOT NULL auto_increment,
        `name` varchar(50) $default_collation NOT NULL default '',
        PRIMARY KEY  (`id`)
      ) ENGINE=InnoDB $default_charset;";
      
      if($this->executeMultipleQueries($test_table_sql, $total_queries, $executed_queries, $this->database_connection)) {
        $this->printMessage('Test query has been executed. Its safe to proceed with database migration.');
        @mysql_query("DROP TABLE `$test_table_name`", $this->database_connection);
      } else {
        $this->printMessage('Failed to executed test query. MySQL said: ' . mysql_error($this->database_connection), true);
        return false;
      } // if
      
      //return ;
      
      // ---------------------------------------------------
      //  Execute migration
      // ---------------------------------------------------
      
      $total_queries = 0;
      $executed_queries = 0;
      $upgrade_script = tpl_fetch(get_template_path('db_migration/empanada'));
      
      if($this->executeMultipleQueries($upgrade_script, $total_queries, $executed_queries, $this->database_connection)) {
        $this->printMessage("Database schema transformations executed (total queries: $total_queries)");
      } else {
        $this->printMessage('Failed to execute DB schema transformations. MySQL said: ' . mysql_error(), true);
        return false;
      } // if
      
      if ($this->upgradeParentIds($this->database_connection)){
        $this->printMessage("Parent workspace ID information upgraded correctly");
      } else {
        $this->printMessage('Failed to execute DB schema transformations. MySQL said: ' . mysql_error(), true);
        return false;
      } // if
      
      $total_queries = 0;
      $executed_queries = 0;
      if($this->executeMultipleQueries("ALTER TABLE `". TABLE_PREFIX . "projects` DROP COLUMN `parent_id`;", $total_queries, $executed_queries, $this->database_connection)) {
        $this->printMessage("Parent id system upgraded");
      } else {
        $this->printMessage('Failed to execute DB schema transformations. MySQL said: ' . mysql_error(), true);
        return false;
      } // if
      
      $this->printMessage('OpenGoo has been upgraded. You are now running OpenGoo '.$this->getVersionTo().' Enjoy!');
    } // execute
    
    function upgradeParentIds($connection){
        $resource = mysql_query("SELECT id, parent_id from " . TABLE_PREFIX . "projects", $connection);
        
    	$sortedws = array();
    	while ($row = mysql_fetch_array($resource, MYSQL_ASSOC)) {
    		$sortedws[$row["id"]] = array("id" => $row["id"], "parent_id" => $row["parent_id"]);
		}
    	
		$finalSql = '';
		
    	foreach($sortedws as $ws){
    		$parents = $this->findParents($ws["id"], $sortedws);
    		if (count($parents)){
    			$sql =  "UPDATE " . TABLE_PREFIX . "projects set ";
    			$c = 1;
    			foreach ($parents as $p){
    				if ($c > 1)
    					$sql .= ', ';
    				$sql .= "p$c = $p";
    				$c++;
    			}
    			$sql .= " where id = " . $ws["id"] . ";\n";
    			$finalSql .= $sql;
    		}
    	}
      
      	$total_queries = 0;
      	$executed_queries = 0;
    	return $this->executeMultipleQueries($finalSql, $total_queries, $executed_queries, $connection);
    	
    	//$this->printMessage($finalSql);
    }
    
    function findParents($wsid, $sortedws){
    	$pid = $sortedws[$wsid]["parent_id"];
    	$result = array();
    	if ($pid && $pid > 0)
    		$result = $this->findParents($pid,$sortedws);
    	$result[] = $wsid;
    	return $result;
    }
  } // EmpanadaUpgradeScript

?>