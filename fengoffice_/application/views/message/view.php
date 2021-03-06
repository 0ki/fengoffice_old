<?php
  if(!active_project() || (active_project() && ProjectMessage::canAdd(logged_user(), active_project()))) {
    add_page_action(lang('add message'), get_url('message', 'add'), 'ico-message');
  } // if
  if($message->canEdit(logged_user())) {
  	add_page_action(lang('edit'), $message->getEditUrl(), 'ico-edit');
  } // if
  if($message->canDelete(logged_user())) {
  	add_page_action(lang('delete'), "javascript:if(confirm(lang('confirm delete message'))) og.openLink('" . $message->getDeleteUrl() ."');", 'ico-delete');
  } // if

?>

<div style="padding:7px">
<div class="message">
	<?php 
		$content = do_textile($message->getText());
		if(trim($message->getAdditionalText())) {
    		$content .= '<div class="messageSeparator">' . lang('message separator') . '</div>' 
    			. do_textile($message->getAdditionalText());
		}
		
		tpl_assign("content", $content);
		tpl_assign("object", $message);
		
		$this->includeTemplate(get_template_path('view', 'co'));
	?>
</div>
</div>