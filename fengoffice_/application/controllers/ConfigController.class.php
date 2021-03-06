<?php

/**
 * Config controller is responsible for handling all config related operations
 *
 * @version 1.0
 * @author Ilija Studen <ilija.studen@gmail.com>, Marcos Saiz <marcos.saiz@opengoo.org>
 */
class ConfigController extends ApplicationController {

	/**
	 * Construct the ApplicationController
	 *
	 * @param void
	 * @return ApplicationController
	 */
	function __construct() {
		parent::__construct();
		prepare_company_website_controller($this, 'website');

		// Access permissios
		if(!can_manage_configuration(logged_user())) {
			flash_error(lang('no access permissions'));
			ajx_current("empty");
		} // if
	} // __construct

	/**
	 * Show and process config category form
	 *
	 * @param void
	 * @return null
	 */
	function update_category() {
		// Access permissios
		if(!can_manage_configuration(logged_user())) {
			flash_error(lang('no access permissions'));
			ajx_current("empty");
			return ;
		} // if
		$category = ConfigCategories::findById(get_id());
		if(!($category instanceof ConfigCategory)) {
			flash_error(lang('config category dnx'));
			$this->redirectToReferer(get_url('administration'));
		} // if

		if($category->isEmpty()) {
			flash_error(lang('config category is empty'));
			$this->redirectToReferer(get_url('administration'));
		} // if

		$options = $category->getOptions(false);
		$categories = ConfigCategories::getAll(false);

		tpl_assign('category', $category);
		tpl_assign('options', $options);
		tpl_assign('config_categories', $categories);

		$submited_values = array_var($_POST, 'options');
		if(is_array($submited_values)) {
			foreach($options as $option) {
				$new_value = array_var($submited_values, $option->getName());
				if(is_null($new_value) || ($new_value == $option->getValue())) continue;
				
				$option->setValue($new_value);
				$option->save();
				evt_add("config ".$option->getName()." changed", $option->getValue());
			} // foreach
			flash_success(lang('success update config category', $category->getDisplayName()));
			ajx_current("back");
		} // if

	} // update_category

	/**
	 * List user preferences
	 *
	 */
	function list_user_categories(){		
		tpl_assign('config_categories', UserWsConfigCategories::getAll());
	} //list_preferences

	/**
	 * List user preferences
	 *
	 */
	function update_user_preferences(){
		$category = UserWsConfigCategories::findById(get_id());
		if(!($category instanceof UserWsConfigCategory)) {
			flash_error(lang('config category dnx'));
			$this->redirectToReferer(get_url('user','card'));
		} // if

		if($category->isEmpty()) {
			flash_error(lang('config category is empty'));
			$this->redirectToReferer(get_url('user','card'));
		} // if

		$options = $category->getUserWsOptions(false);
		$categories = UserWsConfigCategories::getAll(false);

		tpl_assign('category', $category);
		tpl_assign('options', $options);
		tpl_assign('config_categories', $categories);

		$submited_values = array_var($_POST, 'options');
		if(is_array($submited_values)) {
			try{
				DB::beginWork();
				foreach($options as $option) {
					$new_value = array_var($submited_values, $option->getName());
					if(is_null($new_value) || ($new_value == $option->getUserValue(logged_user()->getId()))) continue;
	
					$option->setUserValue($new_value, logged_user()->getId());
					$option->save();
				} // foreach
				DB::commit();
				flash_success(lang('success update config value', $category->getDisplayName()));
				ajx_current("back");
			}
			catch (Exception $ex){
				DB::rollback();
				flash_success(lang('error update config value', $category->getDisplayName()));
			}
		} // if
	} //list_preferences
} // ConfigController

?>