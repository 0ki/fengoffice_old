<?php
  if($message->canEdit(logged_user())) {
  	add_page_action(lang('edit'), $message->getEditUrl(), 'ico-edit');
  } // if
  if($message->canDelete(logged_user())) {
  	add_page_action(lang('delete'), "javascript:if(confirm(lang('confirm delete message'))) og.openLink('" . $message->getDeleteUrl() ."');", 'ico-delete');
  } // if
  add_page_action(lang('print view'), $message->getPrintViewUrl(), "ico-print", "_blank");
  if(!active_project() || (active_project() && ProjectMessage::canAdd(logged_user(), active_project()))) {
    add_page_action(lang('add new message'), get_url('message', 'add'), 'ico-message');
  } // if
?>

<div style="padding:7px">
<div class="message">
	<?php 
		$content = nl2br(clean($message->getText()));
		if(trim($message->getAdditionalText())) {
    		$content .= '<div class="messageSeparator">' . lang('message separator') . '</div>' 
    			. nl2br(clean($message->getAdditionalText()));
		}
		
		tpl_assign("content", $content);
		tpl_assign("object", $message);
		
		$this->includeTemplate(get_template_path('view', 'co'));
	?>
</div>
</div>