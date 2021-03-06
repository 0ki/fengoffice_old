<?php
class MoreController extends ApplicationController {
	
	function __construct() {
		parent::__construct ();
		prepare_company_website_controller ( $this, 'website' );
		
	} // __construct
	
	
	function index() {
		ajx_set_panel("more-panel");
		ajx_set_no_toolbar();
	} // index
	
	function users_and_groups() {
		if (!can_manage_security(logged_user())) {
			flash_error(lang('no access permissions'));
			ajx_current("empty");
			return;
		}
		
		tpl_assign('only_full_users', array_var($_REQUEST, 'only_full_users'));
		
		ajx_set_no_toolbar();
	}
	
	function system_modules() {
		if (!can_manage_configuration(logged_user())) {
			flash_error(lang('no access permissions'));
			ajx_current("empty");
			return;
		}
		ajx_set_no_toolbar();
		
		$tab_panels = TabPanels::findAll(array('conditions' => "id<>'more-panel' AND (plugin_id is NULL OR plugin_id = 0 OR plugin_id IN (SELECT id FROM ".TABLE_PREFIX."plugins WHERE is_activated > 0 AND is_installed > 0))", 'order' => 'ordering'));
		$modules = array();
		foreach ($tab_panels as $panel) {
			$modules[] = array(
					'id' => $panel->getId(),
					'name' => lang($panel->getTitle()),
					'enabled' => $panel->getEnabled(),
					'ico' => str_replace('ico-', 'ico-large-', $panel->getIconCls()),
					'hint' => str_replace("'", "\'", lang('system module '.$panel->getId().' hint')),
			);
		}
		
		$other_modules = array();
		$disabled_modules = array();
/*		
		// mail
		if (!Plugins::instance()->isActivePlugin('mail')) {
			$mail_info = array(
					'id' => 'mails-panel',
					'name' => lang('email tab'),
					'ico' => 'ico-large-mail',
			);
			if (!Plugins::instance()->isActivePlugin('mail')) {
				$disabled_modules[] = $mail_info;
			}
		}
		
		// gantt
		$gantt_info = array(
				'id' => 'gantt',
				'name' => lang('gantt chart'),
				'ico' => 'ico-large-gantt-module',
				'hint' => str_replace("'", "\'", lang('system module gantt hint')),
		);
		if (!Plugins::instance()->isActivePlugin('gantt')) {
			if (Plugins::instance()->isActivePlugin('crpm')) {
				$disabled_modules[] = $gantt_info;
			}
		} else {
			$other_modules[] = $gantt_info;
		}
		
		// expenses
		$expenses_info = array(
				'id' => 'expenses',
				'name' => lang('expenses'),
				'ico' => 'ico-large-expenses-module',
				'hint' => str_replace("'", "\'", lang('system module expenses-panel hint')),
		);
		if (!Plugins::instance()->isActivePlugin('expenses')) {
			if (Plugins::instance()->isActivePlugin('crpm')) {
				$disabled_modules[] = $expenses_info;
			}
		}
		// objectives
		$expenses_info = array(
				'id' => 'objectives',
				'name' => lang('objectives'),
				'ico' => 'ico-large-objectives-module',
				'hint' => str_replace("'", "\'", lang('system module objectives-panel hint')),
		);
		if (!Plugins::instance()->isActivePlugin('objectives')) {
			if (Plugins::instance()->isActivePlugin('crpm')) {
				$disabled_modules[] = $expenses_info;
			}
		}
	*/	
		
		
		$active_dimensions_tmp = Dimensions::findAll(array('order' => 'default_order'));
		$active_dimensions = array();
		foreach ($active_dimensions_tmp as $dim) {
			if ($dim->getCode() == 'feng_persons') continue;
			
			$dname = ( $dim->getOptions() && isset($dim->getOptions(1)->useLangs) && ($dim->getOptions(1)->useLangs) ) ? lang($dim->getCode()) : $dim->getName();
			$active_dimensions[$dim->getCode()] = array(
					'id' => $dim->getId(),
					'name' => $dname,
					'code' => $dim->getCode(),
					'ico' => 'ico-large-'.$dim->getCode(),
					'hint' => lang('system dimension '.$dim->getCode().' hint'),
			);
		}
		$dimensions_set = array_keys($active_dimensions);
		$other_dimensions = array();
		if (!isset($active_dimensions['workspaces'])) {
			$other_dimensions[] = array(
					'name' => lang('workspaces'),
					'ico' => 'ico-large-workspaces',
					'hint' => lang('system dimension workspaces hint'),
			);
		}
		if (!isset($active_dimensions['tags'])) {
			$other_dimensions[] = array(
					'name' => lang('tags'),
					'ico' => 'ico-large-tags',
					'hint' => lang('system dimension tags hint'),
			);
		}
		if (!isset($active_dimensions['customer_project'])) {
			if (Plugins::instance()->isActivePlugin('crpm')) {
				$other_dimensions[] = array(
						'name' => lang('customer_project'),
						'ico' => 'ico-large-customer_project',
						'hint' => lang('system dimension customer_project hint'),
				);
			}
		}
		$user_dimension_ids = config_option('enabled_dimensions');
		
		tpl_assign("modules", $modules);
		tpl_assign("other_modules", $other_modules);
		tpl_assign("disabled_modules", $disabled_modules);
		
		tpl_assign('active_dimensions', $active_dimensions);
		tpl_assign('other_dimensions', $other_dimensions);
		tpl_assign('user_dimension_ids', $user_dimension_ids);
	}
	
	function enable_disable_system_module() {
		ajx_current("empty");
		if (!can_manage_configuration(logged_user())) {
			flash_error(lang('no access permissions'));
			ajx_current("empty");
			return;
		}
		
		$module_id = array_var($_REQUEST, 'module');
		$enabled = array_var($_REQUEST, 'enabled');
		
		$tab_panel = TabPanels::instance()->findById($module_id);
		
		try {
			if ($tab_panel instanceof TabPanel) {
				$tab_panel->setEnabled($enabled > 0);
				$tab_panel->save();
				if ($enabled > 0) {
					DB::execute("INSERT INTO ".TABLE_PREFIX."tab_panel_permissions (permission_group_id, tab_panel_id) VALUES (".logged_user()->getPermissionGroupId().",'".$tab_panel->getId()."') ON DUPLICATE KEY UPDATE tab_panel_id=tab_panel_id;");
				}
				$key = ($enabled > 0) ? "enabled" : "disabled";
				ajx_extra_data(array('ok' => '1', 'msg' => lang("success $key module", lang($tab_panel->getTitle())) ));
			}
		} catch (Exception $e) {
			ajx_extra_data(array('error' => 'Error occurred when enabling/disabling module "'.($tab_panel instanceof TabPanel ? lang($tab_panel->getTitle()) : $module_id).'": '.$e->getMessage()));
		}
	}
	
	function enable_disable_system_modules() {
		ajx_current("empty");
		if (!can_manage_configuration(logged_user())) {
			flash_error(lang('no access permissions'));
			ajx_current("empty");
			return;
		}
	
		$module_list = json_decode(array_var($_REQUEST, 'modules'), true);
		
		try {
			DB::beginWork();
			foreach ($module_list as $module_id => $enabled) {
				$tab_panel = TabPanels::instance()->findById($module_id);
			
				if ($tab_panel instanceof TabPanel) {
					$tab_panel->setEnabled($enabled > 0);
					$tab_panel->save();
					if ($enabled > 0) {
						DB::execute("INSERT INTO ".TABLE_PREFIX."tab_panel_permissions (permission_group_id, tab_panel_id) VALUES (".logged_user()->getPermissionGroupId().",'".$tab_panel->getId()."') ON DUPLICATE KEY UPDATE tab_panel_id=tab_panel_id;");
					}
				}
			}
			DB::commit();
		} catch (Exception $e) {
			DB::rollback();
			Logger::log("Error occurred when trying to enable/disable modules\n".$e->getMessage()."\n".print_r($module_list, 1));
		}
	}
	
	function update_system_module_order() {
		ajx_current("empty");
		if (!can_manage_configuration(logged_user())) {
			flash_error(lang('no access permissions'));
			ajx_current("empty");
			return;
		}
		
		$module_list = json_decode(array_var($_REQUEST, 'modules'), true);
		
		try {
			if (is_array($module_list)) {
				DB::beginWork();
				$pos = 1;
				foreach ($module_list as $mod_id) {
					$mod_id = str_replace("'", "", $mod_id);
					DB::execute("UPDATE ".TABLE_PREFIX."tab_panels SET ordering=$pos WHERE id='$mod_id'");
					$pos++;
				}
				DB::commit();
			}
			ajx_extra_data(array('ok' => '1', 'msg' => lang('success reordering modules')));
			
		} catch (Exception $e) {
			DB::rollback();
			ajx_extra_data(array('error' => 'Error occurred while reordering modules: '.$e->getMessage()));
		}
	}
	
	
	
	function enable_disable_dimensions() {
		ajx_current("empty");
		if (!can_manage_configuration(logged_user())) {
			flash_error(lang('no access permissions'));
			ajx_current("empty");
			return;
		}
		
		$dims = json_decode(array_var($_REQUEST, 'dims'), true);
		
		$root_dids = explode (",", user_config_option('root_dimensions', null, logged_user()->getId()));
		$update_root_dimensions = false;
		
		$enabled_dim_vals = array();
		foreach ($dims as $dim_id => $enabled) {
			if ($enabled) {
				$enabled_dim_vals[] = $dim_id;
				
				if (!in_array($dim_id, $root_dids)) {
					$root_dids[] = $dim_id;
					$update_root_dimensions = true;
				}
			}
			
		}
		set_config_option('enabled_dimensions', implode(',', $enabled_dim_vals));
		
		if ($update_root_dimensions) {
			set_user_config_option('root_dimensions', implode(',', $root_dids), logged_user()->getId());
		}
		
		ajx_extra_data(array('ok' => '1'));
	}
	
	function update_dimension_order() {
		ajx_current("empty");
		if (!can_manage_configuration(logged_user())) {
			flash_error(lang('no access permissions'));
			ajx_current("empty");
			return;
		}
		
		$dim_list = json_decode(array_var($_REQUEST, 'dims'), true);
		
		try {
			if (is_array($dim_list)) {
				DB::beginWork();
				$pos = 1;
				foreach ($dim_list as $dim_id) {
					$dim_id = str_replace("'", "", $dim_id);
					DB::execute("UPDATE ".TABLE_PREFIX."dimensions SET default_order=$pos WHERE id='$dim_id'");
					$pos++;
				}
				DB::commit();
			}
			ajx_extra_data(array('ok' => '1', 'msg' => lang('success reordering dimensions')));
				
		} catch (Exception $e) {
			DB::rollback();
			ajx_extra_data(array('error' => 'Error occurred while reordering dimensions: '.$e->getMessage()));
		}
	}
	
	function set_getting_started_step() {
		ajx_current("empty");
		if (!logged_user()->isAdminGroup()) {
			ajx_current("empty");
			return;
		}
		
		$step = array_var($_REQUEST, 'step');
		
		$current_step = config_option('getting_started_step');
		if ($current_step < $step) {
			set_config_option('getting_started_step', $step);
			
			// change tab title and icon
			if ($step >= 99) {
				DB::execute("UPDATE ".TABLE_PREFIX."tab_panels SET title='settings', icon_cls='ico-administration' WHERE id='more-panel';");
			}
		}
		
		if (array_var($_REQUEST, 'reload_panel')) {
			ajx_add('more-panel', 'reload');
		}
	}
	
	function set_settings_closed() {
		ajx_current("empty");
		
		set_user_config_option('settings_closed', 1, logged_user()->getId());
	}
	
	
	function more_settings() {
		if (!logged_user()->isAdminGroup()) {
			flash_error(lang('no access permissions'));
			ajx_current("empty");
			return;
		}
		ajx_set_no_toolbar();
	}
	
} 