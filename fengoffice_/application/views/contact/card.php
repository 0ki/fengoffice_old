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
         
	tpl_assign("content_template", array('card_content', 'contact'));
	tpl_assign("object", $contact);
	tpl_assign("title", lang('contact') . ': ' . $contact->getDisplayName());
		
  	$this->includeTemplate(get_template_path('view', 'co'));
  	
  	clear_page_actions();
?>

</div>
</div>