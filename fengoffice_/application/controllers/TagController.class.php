<?php

/**
 * Tag controller
 *
 * @version 1.0
 * @author Ilija Studen <ilija.studen@gmail.com>
 */
class TagController extends ApplicationController {

	/**
	 * Construct the TagController
	 *
	 * @access public
	 * @param void
	 * @return TagController
	 */
	function __construct() {
		parent::__construct();
		prepare_company_website_controller($this, 'website');
	} // __construct

	/**
	 * Delete tag URL
	 *
	 * @access public
	 * @param void
	 * @return null
	 */
	function delete_tag() {
		$tag_name=array_var($_GET,'tag_name');
		$project_id=array_var($_GET,'project_id');
		$object_id=array_var($_GET,'object_id');
		$manager_class=array_var($_GET,'manager_class');
		if($project_id)
		Tags::deleteObjectTag($tag_name,  $object_id,  $manager_class,Projects::findById($project_id));
		else
		Tags::deleteObjectTag($tag_name,  $object_id,  $manager_class);
		$this->redirectToReferer('');
	}
	/**
	 * Show project objects tagged with specific tag
	 *
	 * @access public
	 * @param void
	 * @return null
	 */
	function project_tag() {

		$tag = array_var($_GET, 'tag');
		if(trim($tag) == '') {
			flash_error(lang('tag dnx'));
			$this->redirectTo('project', 'tags');
		} // if

		$tagged_objects = active_or_personal_project()->getObjectsByTag($tag);
		$total_tagged_objects = Tags::countObjectsByTag($tag);
		if(is_array($tagged_objects)) {
			foreach($tagged_objects as $type => $objects) {
				if(is_array($objects)) $total_tagged_objects += count($objects);
			} // foreach
		} // if

		tpl_assign('tag', $tag);
		tpl_assign('tagged_objects', $tagged_objects);
		tpl_assign('total_tagged_objects', $total_tagged_objects);

	} // project_tag

	/**
	 * List all tags
	 *
	 */
	function list_tags() {
		$this->setTemplate(get_template_path("json"));
		ajx_current("empty");
		$ts = array();
		$tags = Tags::getTagNames();
		if ($tags) {
			foreach ($tags as $t) {
				$ts[] = array(
					"name" => $t
				);
			}
		}
		$extra = array();
		$extra['tags'] = $ts;
		ajx_extra_data($extra);
	}
} // TagController

?>