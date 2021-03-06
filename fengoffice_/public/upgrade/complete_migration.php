<?php
chdir(dirname(__FILE__) . "/../../");
define("CONSOLE_MODE", true);
define('PUBLIC_FOLDER', 'public');
include "init.php";

Env::useHelper('format');

@set_time_limit(0);

define('SCRIPT_MEMORY_LIMIT', 1024 * 1024 * 1024); // 1 GB
define('COMPLETE_MIGRATION_OUT', isset($_REQUEST['out']) ? $_REQUEST['out'] : 'console');

ini_set('memory_limit', ((SCRIPT_MEMORY_LIMIT / (1024*1024))+50).'M');

function complete_migration_print($text) {
	if (COMPLETE_MIGRATION_OUT == 'console') {
		echo $text;
	} else if (COMPLETE_MIGRATION_OUT == 'file') {
		file_put_contents(ROOT . "/complete_migration_out.txt", $text);
	}
}

function complete_migration_check_table_exists($table_name, $connection) {
	$res = mysql_query("SHOW TABLES", $connection);
	while ($row = mysql_fetch_array($res)) {
		if ($row[0] == $table_name) return true;
	}
	return false;
}


if (!complete_migration_check_table_exists(TABLE_PREFIX . "processed_objects", DB::connection()->getLink())) {
	DB::execute("CREATE TABLE `" . TABLE_PREFIX . "processed_objects` (
				  `object_id` INTEGER UNSIGNED,
				  PRIMARY KEY (`object_id`)
				) ENGINE = InnoDB;");
}



$sql = "";
$first_row = true;

$cant = 0;
$count = 0;
$processed_objects = array();


$objects = Objects::findAll(array('id'=>true, "conditions" => "id NOT IN(SELECT object_id FROM ".TABLE_PREFIX."processed_objects)"));

foreach ($objects as $obj) {
	$cobj = Objects::findObject($obj);
	if ($cobj instanceof ContentDataObject) {
		$cobj->addToSearchableObjects(true);
		$cobj->addToSharingTable();
		
		// add mails to sharing table for account owners
		if ($cobj instanceof MailContent) {
			//$macs = MailAccountContacts::findAll(array('conditions' => array('`account_id` = ?', $cobj->getAccountId())));
			$db_result = DB::execute("SELECT contact_id FROM ".TABLE_PREFIX."mail_accounts WHERE id = ".$cobj->getAccountId());
			$macs = $db_result->fetchAll();
			if ($macs && is_array($macs) && count($macs) > 0) {
				$pgs = array();
				foreach ($macs as $mac) {
					$contact_id = $mac['contact_id'];
					$db_result = DB::execute("SELECT permission_group_id FROM ".TABLE_PREFIX."contact_permission_groups WHERE contact_id = ".$contact_id);
					$mac_pgs = $db_result->fetchAll();
					foreach ($mac_pgs as $mac_pg) $pgs[$mac_pg['permission_group_id']] = $mac_pg['permission_group_id'];
					//$mac_pgs = ContactPermissionGroups::findAll(array("conditions" => "contact_id = ".$mac->getContactId()));
					//foreach ($mac_pgs as $mac_pg) $pgs[$mac_pg->getPermissionGroupId()] = $mac_pg->getPermissionGroupId();
				}
				if ($sql == "" && count($pgs) > 0) $sql = "INSERT INTO ".TABLE_PREFIX."sharing_table (group_id, object_id) VALUES ";
				foreach ($pgs as $pgid) {
					$sql .= ($first_row ? "" : ", ") . "('$pgid', '{$cobj->getId()}')";
					$first_row = false;
				}
				unset($macs);
				unset($pgs);
				
				$count = ($count + 1) % 500;
				if ($sql != "" && $count == 0) {
					$sql .= " ON DUPLICATE KEY UPDATE group_id=group_id;";
					DB::execute($sql);
					$sql = "";
					$first_row = true;
				}
			}
		}
		$processed_objects[] = $cobj->getId();
		
		// check memory to stop script
		if (memory_get_usage(true) > SCRIPT_MEMORY_LIMIT) {
			$processed_objects_ids = "(" . implode("),(", $processed_objects) . ")";
			DB::execute("INSERT INTO ".TABLE_PREFIX."processed_objects (object_id) VALUES $processed_objects_ids ON DUPLICATE KEY UPDATE object_id=object_id");
			
			complete_migration_print("\n".date("H:i:s")." - Memory limit exceeded (".format_filesize(memory_get_usage(true)).") script terminated. Objects: ".count($processed_objects));
			$processed_objects = array();
			break;
		}
		$cant++;
		
		//complete_migration_print("\n".date("H:i:s")." - ".format_filesize(memory_get_usage(true)));
	}
	$cobj = null;
}

// add mails to sharing table for account owners
if ($sql != "") {
	$sql .= " ON DUPLICATE KEY UPDATE group_id=group_id;";
	DB::execute($sql);
	$sql = "";
}
if (count($processed_objects) > 0) {
	$processed_objects_ids = "(" . implode("),(", $processed_objects) . ")";
	DB::execute("INSERT INTO ".TABLE_PREFIX."processed_objects (object_id) VALUES $processed_objects_ids ON DUPLICATE KEY UPDATE object_id=object_id");
	
//	complete_migration_print("\n".date("H:i:s")." - Finished with all objects (".count($processed_objects).")");
}

//complete_migration_print("\nSearchable Objects & Sharing Table generated for ".$cant);


if (COMPLETE_MIGRATION_OUT != 'console') {
	redirect_to(ROOT_URL . "/" . PUBLIC_FOLDER ."/upgrade");
}
