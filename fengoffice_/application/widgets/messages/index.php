<?php 
	// Render only when no context is selected
	// Make calcs, call models, controllers
	$wsDim = Dimensions::findByCode('workspaces');
	if ($wsDim) {
		//if ( current_dimension_id() == $wsDim->getId()) {
			$limit = 5 ;
			$result =  ProjectMessages::instance()->listing(array(
				"order" => "name",
				"order_dir" => "asc",
				"start" => 0,
				"limit" => $limit
			)) ;
			$total = $result->total ;
			$messages = $result->objects;
			$genid = gen_id();
			if ($total) {
				include_once 'template.php';
			}
		//}
	}