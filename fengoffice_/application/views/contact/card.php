<?php 
  set_page_title(lang('contact card of').' '.$contact->getDisplayName());
  if($contact->canEdit(logged_user())) {
    add_page_action(lang('edit contact'), $contact->getEditUrl(), 'ico-edit');
    add_page_action(lang('update picture'), $contact->getUpdatePictureUrl(), 'ico-picture');
	add_page_action(lang('assign to project'), $contact->getAssignToProjectUrl(), 'ico-workspace');
  }
  if($contact->canDelete(logged_user())) {
    add_page_action(lang('delete contact'), "javascript:if(confirm(lang('confirm delete contact'))) og.openLink('" . $contact->getDeleteUrl() ."');", 'ico-delete');
  } // if
  if(can_manage_security(logged_user())){
  	if(! $contact->getUserId() || $contact->getUserId() == 0){
  		add_page_action(lang('create user from contact'), $contact->getCreateUserUrl() , 'ico-user');
  	}
  } 
?>
   
   
<div style="padding:7px">
<div class="contact">

<?php
	if ($contact->hasPicture()){
		$image = '<div class="cardIcon">';
		
		if ($contact->canEdit(logged_user()))
			$image .= '<a class="internalLink" href="' .
			$contact->getUpdatePictureUrl() .'" title="' . lang('update picture') . '">';
		
		$image .= '<img src="' . $contact->getPictureUrl() .'" alt="'. clean($contact->getDisplayName()) .' picture" />';
		
		if ($contact->canEdit(logged_user()))
			$image .= '</a>';
		
		$image .= '</div>';
		
		tpl_assign("image",$image);
	}
	$description = "";
	$company = $contact->getCompany();
	if ($company instanceof Company)
		$description = '<a class="internalLink coViewAction ico-company" href="' . $company->getCardUrl() . '">' . clean($company->getName()) . '</a>';
	
	if ($contact->getJobTitle() != ''){
		if($description != '')
			$description .= ' - ';
		$description .= clean($contact->getJobTitle());
	}
	
	if ($contact->getDepartment() != ''){
		if($description != ''){
			if ($contact->getJobTitle() != '')
				$description .= ', ';
			else
				$description .= ' - ';
		}
		$description .= clean($contact->getDepartment());
	}
	
	$userLink = '';
	if ($contact->getUserId() > 0){
		if($description != '')
			$description .= '<br/>';
		$description .= '<a class="internalLink coViewAction ico-user" href="' . $contact->getUser()->getCardUrl() . '" title="' . lang('contact linked to user', clean($contact->getUser()->getUsername())) . '">' . clean($contact->getUser()->getUsername()) . '</a>';
	}
		
    
	tpl_assign("description", $description);
	tpl_assign("content_template", array('card_content', 'contact'));
	tpl_assign("object", $contact);
	tpl_assign("title", lang('contact') . ': ' . clean($contact->getDisplayName()));
		
  	$this->includeTemplate(get_template_path('view', 'co'));
  	
  	clear_page_actions();
?>

</div>
</div>