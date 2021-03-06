<?php
	if (!$cotemplate->isTrashed()){
		if($cotemplate->canEdit(logged_user())) {
			add_page_action(lang('edit'), $cotemplate->getEditUrl(), 'ico-edit');
		} // if
	} // if
	
	if($cotemplate->canDelete(logged_user())) {
		add_page_action(lang('delete'), "javascript:if(confirm(lang('confirm delete object'))) og.openLink('" . $cotemplate->getDeleteUrl() ."');", 'ico-delete');
	} // if
?>

<div style="padding:7px">
<div class="template">
	<?php 
		$variables = array(
			"description" => nl2br(clean($cotemplate->getDescription())),
			"objects" => $cotemplate->getObjects()
		);
		tpl_assign("variables", $variables);
		tpl_assign("content_template", array('content', 'template'));
		tpl_assign("content", $content);
		tpl_assign("object", $cotemplate);
		tpl_assign('iconclass', $cotemplate->isTrashed()? 'ico-large-template-trashed' :  'ico-large-template');
		
		$this->includeTemplate(get_template_path('view', 'co'));
	?>
</div>
</div>