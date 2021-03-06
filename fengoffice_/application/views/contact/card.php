<?php 
  set_page_title(lang('contact card of').' '.$contact->getDisplayName());
  if($contact->canEdit(logged_user())) {
    add_page_action(lang('edit contact'), $contact->getEditUrl(), 'ico-edit');
    add_page_action(lang('update picture'), $contact->getUpdatePictureUrl(), 'ico-picture');
	add_page_action(lang('assign to project'), $contact->getAssignToProjectUrl(), 'ico-workspace');
  }
    
  if($contact->canDelete(logged_user())) {
    add_page_action(lang('delete contact'), $contact->getDeleteUrl(), 'ico-delete');
  } // if
  
  $this->includeTemplate(get_template_path('contact_card', 'contact'));
?>