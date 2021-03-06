<style>
	.error {
		color: red  ;	
	}
</style>

<?php
	$plugin_id  = 3 ; //TODO Hardcoded
	$type_id = 7 ;
	
	
	function executeMultipleQueries($sql, &$total_queries = null , &$executed_queries = null ) {
		if(!trim($sql)) {
			$total_queries = 0;
			$executed_queries = 0;
			return true;
		} // if

		// Make it work on PHP 5.0.4
		$sql = str_replace(array("\r\n", "\r"), array("\n", "\n"), $sql);
		
		$queries = explode(";\n", $sql);
		if(!is_array($queries) || !count($queries)) {
			$total_queries = 0;
			$executed_queries = 0;
			return true;
		} 

		$total_queries = count($queries);
		foreach($queries as $query) {
			echo $query."<br/>" ;
			if(trim($query)) {
				if (@mysql_query(trim($query))){	
					$executed_queries++;
				}else{
					echo "<span class='error'> Errors executing query: $query </span></br>";
					echo "<span class='error'>".mysql_error()."</span><br/>";
					//return false; 
				} 
			}
		}

	} 
	// Include constants 
	set_time_limit(0);
	if(!defined("TABLE_PREFIX")) {		
		include_once "../../../config/config.php";
	}
	$table_prefix = TABLE_PREFIX;
	$default_charset = "DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci" ;
	$default_collation = "collate utf8_unicode_ci";
	$engine = "InnoDB" ; // Sorry about this.. alll this data is pseudo-hardcoded in installation/acInstallation.class.php
	
	// Connect to db
	mysql_connect(DB_HOST, DB_USER, DB_PASS) or die(mysql_error()) ;
	mysql_select_db(DB_NAME) or die(mysql_error()) ;
	
	
	// Create schema sql query
	ob_start();
	include "sql/mysql_schema.php";
	$sql = ob_get_clean() ;
	
	// Excute schema Query
	executeMultipleQueries($sql);

	// Create data sql query
	ob_start();
	include "sql/mysql_initial_data.php";
	$sql = ob_get_clean() ;
	
	// Excute data Query
	executeMultipleQueries($sql);
