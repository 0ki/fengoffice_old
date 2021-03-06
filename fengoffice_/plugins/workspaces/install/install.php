<?php

function _workspaces_check_custom_prop_exists($table_prefix, $cp_code, $ot_name) {
	$exists_cp = false;

	$ot_subquery = "SELECT id FROM ".$table_prefix."object_types WHERE name='$ot_name'";
	$sql = "SELECT count(id) as total FROM ".$table_prefix."member_custom_properties WHERE code='$cp_code' AND object_type_id = ($ot_subquery)";
	$mysql_res = mysql_query($sql);
	if ($mysql_res) {
		$rows = mysql_fetch_assoc($mysql_res);
		if (is_array($rows) && count($rows) > 0) {
			$exists_cp = $rows['total'] > 0;
		}
	}
	return $exists_cp;
}

function workspaces_get_additional_install_queries($table_prefix) {
	
	$queries = array();
	$is_installed_mem_custom_props = false;
	
	$sql = "SELECT is_installed FROM ".$table_prefix."plugins WHERE name='member_custom_properties'";
	$mysql_res = mysql_query($sql);
	if ($mysql_res) {
		$rows = mysql_fetch_assoc($mysql_res);
		
		if (is_array($rows) && count($rows) > 0) {
			
			$is_installed_mem_custom_props = $rows['is_installed'] > 0;
		}
	}
	
	if ($is_installed_mem_custom_props) {
		
		if (!_workspaces_check_custom_prop_exists($table_prefix, 'color_special', 'workspace')) {
			$queries[] = "INSERT INTO `".$table_prefix."member_custom_properties` (`object_type_id`, `name`, `code`, `type`, `description`, `values`, `default_value`, `is_system`, `is_required`, `is_multiple_values`, `property_order`, `visible_by_default`, `is_special`, `is_disabled`)
				SELECT mt.id, 'Color', 'color_special','color','','','',0,0,0,30,1, 1, 0
				FROM ".$table_prefix."object_types mt WHERE mt.`type` IN ('dimension_object','dimension_group') AND name IN ('workspace','tag')
				ON DUPLICATE KEY UPDATE `code`=`code`;";
		}
		
		if (!_workspaces_check_custom_prop_exists($table_prefix, 'description_special', 'workspace')) {
			$queries[] = "INSERT INTO `".$table_prefix."member_custom_properties` (`object_type_id`, `name`, `code`, `type`, `description`, `values`, `default_value`, `is_system`, `is_required`, `is_multiple_values`, `property_order`, `visible_by_default`, `is_special`, `is_disabled`)
				SELECT mt.id, 'Description', 'description_special', 'memo','','','',0,0,0,31,1, 1, 0
				FROM ".$table_prefix."object_types mt WHERE mt.`type` IN ('dimension_object','dimension_group') AND name IN ('workspace','tag')
			ON DUPLICATE KEY UPDATE `code`=`code`;";
		}
		
	}
	
	return $queries;

}
?>