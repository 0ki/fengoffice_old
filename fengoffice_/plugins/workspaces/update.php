<?php 
	/**
	 * Feng2 Plugin update engine 
	 * @author Ignacio Vazquez <elpepe.uy at gmail.com>
	 */
	function workspaces_update_1_2() {
		$workspaces = Workspaces::findAll();
		if (!is_array($workspaces)) return;
		foreach  ( $workspaces as $ws ){
			if ($obj instanceof ContentDataObject) {
				$obj->addToSearchableObjects(1);
			}
			$ws->addToSharingTable();
		}
	}
	
	
	function workspaces_update_2_3() {
		$ws_options = '{"defaultAjax":{"controller":"dashboard", "action": "main_dashboard"}, "quickAdd":true,"showInPaths":true,"useLangs":true}';
		DB::executeAll("UPDATE ".TABLE_PREFIX."dimensions SET options='$ws_options' WHERE code='workspaces'");
		$tag_options = '{"defaultAjax":{"controller":"dashboard", "action": "init_overview"},"quickAdd":true,"showInPaths":true,"useLangs":true}';
		DB::executeAll("UPDATE ".TABLE_PREFIX."dimensions SET options='$tag_options' WHERE code='tags'");
	}
	
	function workspaces_update_3_4() {
		DB::execute("
			UPDATE ".TABLE_PREFIX."dimensions SET permission_query_method='not_mandatory' WHERE code='tags';
		");
	}
	
	function workspaces_update_4_5() {
		DB::execute("
			INSERT INTO ".TABLE_PREFIX."dimension_object_type_contents (dimension_id,dimension_object_type_id,content_object_type_id,is_required,is_multiple) VALUES 
			((SELECT id FROM ".TABLE_PREFIX."dimensions WHERE code='feng_persons'), (SELECT id FROM ".TABLE_PREFIX."object_types WHERE name='person'), (SELECT id FROM ".TABLE_PREFIX."object_types WHERE name='mail'),0,1),
			((SELECT id FROM ".TABLE_PREFIX."dimensions WHERE code='feng_persons'), (SELECT id FROM ".TABLE_PREFIX."object_types WHERE name='company'), (SELECT id FROM ".TABLE_PREFIX."object_types WHERE name='mail'),0,1),
			((SELECT id FROM ".TABLE_PREFIX."dimensions WHERE code='workspaces'), (SELECT id FROM ".TABLE_PREFIX."object_types WHERE name='workspace'), (SELECT id FROM ".TABLE_PREFIX."object_types WHERE name='mail'),0,1),
			((SELECT id FROM ".TABLE_PREFIX."dimensions WHERE code='tags'), (SELECT id FROM ".TABLE_PREFIX."object_types WHERE name='tag'), (SELECT id FROM ".TABLE_PREFIX."object_types WHERE name='mail'),0,1)
			ON DUPLICATE KEY UPDATE dimension_id=dimension_id;
		");
	}