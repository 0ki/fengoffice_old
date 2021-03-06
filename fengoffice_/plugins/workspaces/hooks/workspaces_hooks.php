<?php
Hook::register ( "workspaces" );

function workspaces_total_task_timeslots_group_by_criterias($args, &$ret) {
	$wdimension = Dimensions::findByCode ( 'workspaces' );
	$tdimension = Dimensions::findByCode ( 'tags' );
	$ret[] = array('val' => 'dim_'.$wdimension->getId(), 'name' => $wdimension->getName());
	$ret[] = array('val' => 'dim_'.$tdimension->getId(), 'name' => $tdimension->getName());
}


function workspaces_custom_reports_additional_columns($args, &$ret) {
	$dimensions = Dimensions::findAll ( array("conditions" => "code IN ('workspaces','tags')") );
	foreach ($dimensions as $dimension) {
		$doptions = $dimension->getOptions(true);
		
		if( $doptions && isset($doptions->useLangs) && $doptions->useLangs ) {
			$name = lang($dimension->getCode());
		} else {
			$name = $dimension->getName();
		}
		
		$ret[] =  array('id' => 'dim_'.$dimension->getId(), 'name' => $name, 'type' => DATA_TYPE_STRING);
	}
}

function workspaces_total_tasks_times_csv_columns($cols, &$cols) {
	$dimension = Dimensions::findByCode('workspaces');
	$cols[] = $dimension->getName();
}

function workspaces_total_tasks_times_csv_column_values($ts, &$new_values) {
	if (!is_array($new_values)) $new_values = array();
	$dimension = Dimensions::findByCode('workspaces');
	if ($ts instanceof Timeslot) {
		$members = $ts->getMembers();
		$str = "";
		foreach ($members as $m) {
			if ($m->getDimensionId() == $dimension->getId()) {
				$str .= ($str == "" ? "" : " - "). $m->getName();
			}
		}
		$new_values[] = $str;
	}
}

function workspaces_include_tasks_template($ignored, &$more_content_templates) {
	$more_content_templates[] = array(
		'template' => 'groupby',
		'controller' => 'task',
		'plugin' => 'workspaces'
	);
}


function workspaces_quickadd_extra_fields($parameters) {
	if (array_var($parameters, 'dimension_id') == Dimensions::findByCode("workspaces")->getId()) {
		$parent_member = Members::findById(array_var($parameters, 'parent_id'));
		if ($parent_member instanceof Member && $parent_member->getObjectId() > 0) {
			$dimension_object = Objects::findObject($parent_member->getObjectId());
			
			$fields = $dimension_object->manager()->getPublicColumns();
			$color_columns = array();
			foreach ($fields as $f) {
				if ($f['type'] == DATA_TYPE_WSCOLOR) {
					$color_columns[] = $f['col'];
				}
			}
			foreach ($color_columns as $col) {
				foreach ($fields as &$f) {
					if ($f['col'] == $col && $dimension_object->columnExists($col)) {
						$color_code = $dimension_object->getColumnValue($col);
						echo '<input type="hidden" name="dim_obj['.$col.']" value="'.$color_code.'" />';
					}
				}
			}
		}
	}
}

function workspaces_render_widget_member_information(Member $member, &$prop_html="") {
	$ws_ot = ObjectTypes::findByName('workspace');
	if ($member->getObjectTypeId() == $ws_ot->getId()) {
		
		$ws = Workspaces::getWorkspaceById($member->getObjectId());
		if ($ws instanceof Workspace && $ws->getDescription() != "" && $ws->getColumnValue('show_description_in_overview')) {
			$prop_html .= '<div style="margin-bottom:5px;">'.escape_html_whitespace(convert_to_links(clean($ws->getDescription()))).'</div>';
		}
		
	}
}

function workspaces_render_administration_dimension_icons($ignored, &$icons){
	if (logged_user() instanceof Contact && can_manage_dimension_members(logged_user())) {
		$enabled_dimensions = config_option("enabled_dimensions");
		$dimension = Dimensions::instance()->findByCode('workspaces');
		if (in_array($dimension->getId(), $enabled_dimensions)) {
			$icons[] = array(
				'ico' => 'ico-large-workspace',
				'url' => get_url('dimension', 'list_members', array('dim' => $dimension->getId())),
				'name' => lang($dimension->getCode()),
				'extra' => '',
			);
		}
		
		$dimension = Dimensions::instance()->findByCode('tags');
		if (in_array($dimension->getId(), $enabled_dimensions)) {
			$icons[] = array(
				'ico' => 'ico-large-tags',
				'url' => get_url('dimension', 'list_members', array('dim' => $dimension->getId())),
				'name' => lang($dimension->getCode()),
				'extra' => '',
			);
		}
	}
}

function workspaces_more_panel_dimension_links($ignored, &$links) {
	$dimension = Dimensions::findByCode('workspaces');
	$enabled_dimensions = config_option("enabled_dimensions");
	if (!in_array($dimension->getId(), $enabled_dimensions)) return;
	
	$dimension_options = $dimension->getOptions(true);
	if($dimension_options && isset($dimension_options->useLangs) && $dimension_options->useLangs ) {
		$name = lang($dimension->getCode());
	} else {
		$name = $dimension->getName();
	}
	
	$step = Plugins::instance()->isActivePlugin('crpm') ? 5 : 4;
	
	$selector = '#dimension-panel-'.$dimension->getId().' .x-tool.x-tool-options';
	$onclick = 'Ext.getCmp(\'menu-panel\').expand(true); og.highlight_link({selector:\''.$selector.'\', step:'.$step.', time_active:30000, timeout:500, animate_opacity:10, hint_text:\''.lang('click here').'\'}); return false;';
	
	$links[] = array(
			'id' => 'dim_workspaces',
			'ico' => 'ico-large-workspace',
			'url' => get_url('dimension', 'list_members', array('dim' => $dimension->getId())),
			'name' => $name,
			'onclick' => $onclick,
			'extra' => '',
	);
}


function workspaces_add_member_by_type_info($data, &$info) {
	if (array_var($data, 'dim_code') == 'workspaces') {
		$w_ot = ObjectTypes::findByName('workspace');

		if (array_var($data, 'mem_type') == $w_ot->getId()) {
			$dimension = Dimensions::findByCode('workspaces');
			$info = array('name' => lang('add new workspace'), 'url' => get_url('member', 'add', array('dim_id' => $dimension->getId(), 'type' => $w_ot->getId())));
		}
	} else if (array_var($data, 'dim_code') == 'tags') {
		$t_ot = ObjectTypes::findByName('tag');
		
		if (array_var($data, 'mem_type') == $t_ot->getId()) {
			$dimension = Dimensions::findByCode('tags');
			$info = array('name' => lang('add new tag'), 'url' => get_url('member', 'add', array('dim_id' => $dimension->getId(), 'type' => $t_ot->getId())));
		}
	}
}


function workspaces_page_rendered() {
	if (!Plugins::instance()->isActivePlugin('crpm')) {
		$did = Dimensions::instance()->findByCode('workspaces')->getId();
		
		$one_member = Members::findOne(array('conditions' => 'dimension_id = '.$did));
		if (!$one_member instanceof Member) {
			echo "<script>";
			echo "og.menuPanelCollapsed = true;";
			echo "</script>";
		}
	}

}

function workspaces_after_user_add($object, $ignored) {
	/* @var $object Contact */
	$workspaces_dim = Dimensions::findOne(array("conditions" => "`code` = 'workspaces'"));

	if ($workspaces_dim instanceof Dimension) {

		$sql = "INSERT INTO `".TABLE_PREFIX."contact_dimension_permissions` (`permission_group_id`, `dimension_id`, `permission_type`)
				 SELECT `c`.`permission_group_id`, ".$workspaces_dim->getId().", 'check'
				 FROM `".TABLE_PREFIX."contacts` `c`
				 WHERE `c`.`is_company`=0 AND `c`.`user_type`!=0 AND `c`.`disabled`=0 AND `c`.`object_id`=".$object->getId()."
				 ON DUPLICATE KEY UPDATE `dimension_id`=`dimension_id`;";
		DB::execute($sql);
	}
}