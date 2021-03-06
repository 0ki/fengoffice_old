<?php

$panel = TabPanels::instance()->findById('documents-panel');
if ($panel instanceof TabPanel && $panel->getEnabled()) {
	$limit = 5 ;
	$result =  ProjectFiles::instance()->listing(array(
		"order" => "name",
		"order_dir" => "asc",
		"start" => 0,
		"limit" => $limit
	)) ;
	$cmember = current_member();
	if($cmember != NULL){
		$widget_title = lang("documents") . " " . lang("in") . " " . $cmember->getName();
	}
	
	$total = $result->total ;
	$documents = $result->objects;
	$genid = gen_id();
	if ($total) {
		include_once 'template.php';
	}
}