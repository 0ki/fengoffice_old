<?php
	//limit to the number of users to be displayed in widgets
	$limit = 6;

	
	$current_member = current_member();
	
	$active_members = array();
	$context = active_context();
	foreach ($context as $selection) {
		if ($selection instanceof Member) $active_members[] = $selection;
	}
	//if there are members selcted
	if (count($active_members) > 0) {
		$mnames = array();
		$mids = array();
		$allowed_contact_ids = array();
		foreach ($active_members as $member) {
			$allowed_contact_ids[] = $member->getAllowedContactIds();
			$mnames[] = clean($member->getName());
			$mids[] = clean($member->getid());
		}
		$intersection = $allowed_contact_ids[0];
		if (count($allowed_contact_ids) > 1) {
			for ($i = 1; $i < count($allowed_contact_ids); $i++) {
				$intersection = array_intersect($intersection, $allowed_contact_ids[$i]);
			}
		}
		//user to display on the widget
		$contacts = Contacts::findAll(array(
			'conditions' => 'object_id IN ('.implode(',',$intersection).') AND `is_company` = 0 AND disabled = 0',
			'limit' => $limit,
			'order' => 'last_activity, updated_on',
			'order_dir' => 'desc',
		));
		$total = count($contacts);
		
		$contacts_for_combo = null;
		//if logged user can assign permissions
		if(can_manage_security(logged_user())){
			//users to display on the combo
			$contacts_for_combo = Contacts::findAll(array(
					'conditions' => 'object_id NOT IN ('.implode(',',$intersection).') AND `is_company` = 0 AND `user_type` > '.logged_user()->getUserType().' AND disabled = 0',
					'order' => 'last_activity, updated_on',
					'order_dir' => 'desc',
			));
			
		}
		
		
		
		//add people button name
		if (isset($mnames[0])){
			$add_people_btn = true;
		}
		
		//widget title
		$widget_title = lang("people in", implode(", ", $mnames));
		$mids = implode(",", $mids);
	
	} else {
		
		$result = Contacts::instance()->listing(array(
			"order" => "last_activity, updated_on",
			"order_dir" => "desc",
			"extra_conditions" => " AND `is_company` = 0 AND disabled = 0 AND user_type > 0",
			"start" => 0,
			"limit" => $limit
		));
		$total = $result->total ;
		$contacts = $result->objects;
	}
	
	$render_add = can_manage_security(logged_user());
	$genid = gen_id();
	
	if ($total > 0 || $render_add) {
		include_once 'template.php';
	}