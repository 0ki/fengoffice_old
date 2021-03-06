<?php 
  set_page_title(lang('contact card of').' '.$contact->getDisplayName());
  if($contact->canEdit(logged_user())) {
    add_page_action(array(
      lang('edit contact')  => $contact->getEditUrl(),
      lang('update picture')   => $contact->getUpdatePictureUrl(),
	  lang('assign to project')   => $contact->getAssignToProjectUrl()
    ));
  }
    
  if($contact->canDelete(logged_user())) {
    add_page_action(array(
      lang('delete contact') => $contact->getDeleteUrl()
    ));
  } // if
  
  $this->includeTemplate(get_template_path('contact_card', 'contact'));
?>