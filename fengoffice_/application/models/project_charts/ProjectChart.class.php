<?php
 
  /**
  * ProjectChart class
  *
  * @author Carlos Palma <chonwil@gmail.com>
  */
  class ProjectChart extends BaseProjectChart {
    
    protected $data;
    
    protected $graph;
    
    protected $hasParameters = false;
    
    protected $parameters;
    
	/* This project object is taggable
	 *
	 * @var boolean
	 */
	protected $is_taggable = true;

	protected $is_searchable = true;

	protected $searchable_columns = array('title');

	protected $is_commentable = false;
	
	protected $attr_protected = null;
	protected $colours = array('#356aa0', '#a03535');
    
	function getHasParameters(){
		return $this->hasParameters;
	}
	
	function getParameters(){
		if (!$this->hasParameters)
			return null;
		else {
			if (!isset($this->parameters))
				$this->parameters = ProjectChartParams::getProjectChartParams($this);
		}
		return $this->parameters;
	}
	
    /**
     * Return the graph of this chart
     *
     * @return graph
     */
    function getGraph(){
    	if (!isset($this->graph) || is_null($this->graph))
    		$this->graph = new graph();
    	return $this->graph;
    }
    
    /**
    * Return project part of the relationship
    *
    * @param void
    * @return Project
    */
    function getProject() {
      if(is_null($this->project)) {
        $this->project = Projects::findById($this->getProjectId());
      } // if
      return $this->project;
    } // getProject
    
    function getColour($c){
    	return $this->colours[$c % count($this->colours)];
    }
    
    function DashboardDraw(ProjectChart $g = null){
		if (is_null($g))
  			$g = $this->getGraph();
    	$g2 = $this->Draw($g, true);
  		$g2->set_title('');
  		if ($this->getDisplayId() == 20)
  			$g2->set_height(180);
  		else
    		$g2->set_height(240);
    	$g2->set_width(240);
    	$g2->set_x_label_style(6);
    	$g2->set_y_label_style(6);
    	return $g2->render();
    }
    
  	function Draw($g, $returnGraphObject = false){
		if (!isset($g))
  			$g = $this->getGraph();
		$g->set_bg_colour("#FFFFFF");
		$g->set_title($this->getTitle(),"font-size: 12px; color: #404040;" );
		
		$max = 0;
		$min = 0;
		
		$g->set_x_labels($this->data['values'][0]['labels']);
		$c = 0;
		$seriesCount = count($this->data['values']);
		foreach($this->data['values'] as $series){
			$max = max(array($max, max($series['values'])));
			$min = min(array($min, min($series['values'])));
			switch($this->getDisplayId()){
				case 10: //Bar chart
					$g->set_data($series['values']);
					$g->bar(70,$this->getColour($c),$series['name'], $seriesCount>1 ? 10: -1);
					break;
				case 11: //Bar glass chart
					$g->set_data($series[0]['values']);
					$g->bar_glass(70,$this->getColour($c), '#505050',$series['name'], $seriesCount>1 ? 10: -1);
					break;
				case 12: //Bar 3d chart
					$g->set_data($series['values']);
					$g->bar_3D(70,$this->getColour($c),$series['name'], $seriesCount>1 ? 10: -1);
					break;
				case 13: // Bar sketch
					$g->set_data($series['values']);
					$g->bar_sketch(60,9,$this->getColour($c),'#505050',$series['name'], $seriesCount>1 ? 10: -1);
					break;
				case 20: // Pie chart
					$g->pie(60,'#505050',"font-size: 10px; color: #404040;");
					$g->pie_slice_colours( array('#d01f3c','#356aa0','#C79810') );
					$g->pie_values($series['values'], $series['labels'] );
					break;
				case 30: // Line chart
					$g->set_data($series['values']);
					$g->line(3,$this->getColour($c),$series['name'], $seriesCount > 1 ? 10: -1);
					break;
			}
			$c++;
		}
		$g->set_y_min($min);
		$g->set_y_max($max);
		//echo with_slash(ROOT_URL) . "public/assets/reporting/open-flash-chart.swf"; die();
		$g->set_swf_path(with_slash(ROOT_URL) . "public/assets/reporting/");
		$g->set_js_path(with_slash(ROOT_URL) . "public/assets/javascript/og/swfobject.js");
		$g->set_output_type('js');
		$g->set_height(400);
		$g->set_width(600);
		if (isset($returnGraphObject) && $returnGraphObject)
			return $g;
		else
			return $g->render();
  	}
  	
  	function PrintInfo(){
  		return '';
  	}
  	
  	function printData(){
  		return var_dump($this->data);
  	}
  	
  	function ExecuteQuery(){
  		
  	}
  	// ---------------------------------------------------
	//  Permissions
	// ---------------------------------------------------

	/**
	 * Check CAN_MANAGE_MESSAGES permission
	 *
	 * @access public
	 * @param User $user
	 * @return boolean
	 */
	function canManage(User $user) {
		return true;
	} // canManage

	/**
	 * Returns true if $user can access this message
	 *
	 * @param User $user
	 * @return boolean
	 */
	function canView(User $user) {
		return true;
	} // canView

	/**
	 * Check if specific user can add messages to specific project
	 *
	 * @access public
	 * @param User $user
	 * @param Project $project
	 * @return booelean
	 */
	function canAdd(User $user, Project $project) {
		return true;
	} // canAdd

	/**
	 * Check if specific user can edit this messages
	 *
	 * @access public
	 * @param User $user
	 * @return boolean
	 */
	function canEdit(User $user) {		
		return true;
	} // canEdit

	/**
	 * Check if $user can update message options
	 *
	 * @param User $user
	 * @return boolean
	 */
	function canUpdateOptions(User $user) {
		return true;
	} // canUpdateOptions

	/**
	 * Check if specific user can delete this messages
	 *
	 * @access public
	 * @param User $user
	 * @return boolean
	 */
	function canDelete(User $user) {
		return true;
	} // canDelete

	/**
	 * Check if specific user can comment this message
	 *
	 * @access public
	 * @param void
	 * @return boolean
	 */
	function canAddComment(User $user) {
		return true;
	} // canAddComment
  	
  	// ---------------------------------------------------
	//  System
	// ---------------------------------------------------

	/**
	 * Delete this object
	 *
	 * @access public
	 * @param void
	 * @return boolean
	 */
	function delete() {
		return parent::delete();
	} // delete

	/**
	 * Validate before save
	 *
	 * @access public
	 * @param array $errors
	 * @return null
	 */
	function validate(&$errors) {
		if($this->validatePresenceOf('title')) {
			if(!$this->validateUniquenessOf('title', 'project_id')) $errors[] = lang('chart title unique');
		} else {
			$errors[] = lang('chart title required');
		} // if
		//if(!$this->validatePresenceOf('text')) $errors[] = lang('message text required');
	} // validate

	function save(){
		parent::save();
		if ($this->hasParams && isset($this->params) && is_array($this->params)){
			foreach ($this->params as $param){
				$param->save();
			}
		}
	}
	
	// ---------------------------------------------------
	//  URLS
	// ---------------------------------------------------

	/**
	 * Return view message URL
	 *
	 * @access public
	 * @param void
	 * @return string
	 */
	function getViewUrl() {
		return get_url('reporting', 'chart_details', array('id' => $this->getId(), 'active_project' => $this->getProjectId()));
	} // getViewUrl

	/**
	 * Return edit message URL
	 *
	 * @access public
	 * @param void
	 * @return string
	 */
	function getEditUrl() {
		return get_url('reporting', 'edit_chart', array('id' => $this->getId(), 'active_project' => $this->getProjectId()));
	} // getEditUrl

	/**
	 * Return delete message URL
	 *
	 * @access public
	 * @param void
	 * @return string
	 */
	function getDeleteUrl() {
		return get_url('reporting', 'delete_chart', array('id' => $this->getId(), 'active_project' => $this->getProjectId()));
	} // getDeleteUrl

	// ---------------------------------------------------
	//  Override ApplicationDataObject methods
	// ---------------------------------------------------

	/**
	 * Return object name
	 *
	 * @access public
	 * @param void
	 * @return string
	 */
	function getObjectName() {
		return $this->getTitle();
	} // getObjectName

	/**
	 * Return object type name
	 *
	 * @param void
	 * @return string
	 */
	function getObjectTypeName() {
		return 'chart';
	} // getObjectTypeName

	/**
	 * Return object URl
	 *
	 * @access public
	 * @param void
	 * @return string
	 */
	function getObjectUrl() {
		return '';
	} // getObjectUrl
  	
    
  } // ProjectChart 
?>