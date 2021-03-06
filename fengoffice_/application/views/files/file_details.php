<?php
$options = array();

	if ($file->isCheckedOut()){
		if ($file->canCheckin(logged_user())){
			add_page_action(lang('checkin file'), $file->getCheckinUrl(), 'ico-checkin'); 
			add_page_action(lang('undo checkout'), $file->getUndoCheckoutUrl() . "&show=redirect", 'ico-undo'); 
		}
	} else {
		if ($file->canCheckout(logged_user())) 
			add_page_action(lang('checkout file'), $file->getCheckoutUrl(). "&show=redirect", 'ico-checkout');
	}
	
	if($file->canDownload(logged_user())) 
		add_page_action(lang('download') . ' (' . format_filesize($file->getFilesize()) . ')', $file->getDownloadUrl(), 'ico-download', "_blank");
	
	if($file->canEdit(logged_user()))
		add_page_action(lang('file properties'), $file->getEditUrl(), 'ico-properties');
	
	if($file->canDelete(logged_user())) 
		add_page_action(lang('delete'), "javascript:if(confirm(lang('confirm delete file'))) og.openLink('" . $file->getDeleteUrl() ."');", 'ico-delete');
	
	if ($file->isModifiable()) 
		add_page_action(lang('edit'), $file->getModifyUrl(), 'ico-edit');
		
	if (strcmp($file->getTypeString(), 'prsn')==0) {
		add_page_action(lang('slideshow'), "javascript:og.slideshow(".$file->getId().")", 'ico-slideshow');
	}

// Arreglar el slideshow!!!!
//	if(strcmp($file->getTypeString(),'prsn')==0 ) 
//		add_page_action($options[] = '<a href="javascript:og.slideshow(' . 	$file->getId()	. ')">' . lang('slideshow') . '</a>';

  //add_javascript_to_page('file/slideshow.js');
?>


<div style="padding:7px">
<div class="files">

<?php 
	$description = '';
  	if($last_revision instanceof ProjectFileRevision) { 
  		$description .= '<div id="fileLastRevision"><span class="propertyName">' . lang('last revision') . ':</span>'; 
		if($last_revision->getCreatedBy() instanceof User) {
      		$description .= lang('file revision info long', $last_revision->getRevisionNumber(), $last_revision->getCreatedBy()->getCardUrl(), $last_revision->getCreatedBy()->getDisplayName(), format_descriptive_date($last_revision->getCreatedOn()));
		} else {
			$description .= lang('file revision info short', $last_revision->getRevisionNumber(), format_descriptive_date($last_revision->getCreatedOn()));
		}
	} // if
	
	tpl_assign('image', '<div><img src="' .
		$file->getTypeIconUrl() .'" alt="' . $file->getFilename() . '" /></div>');
	tpl_assign('iconclass', 'ico-large-files');
	tpl_assign('description', $description);
	tpl_assign('title', clean($file->getFilename()));
	tpl_assign("content_template", array('file_details_content', 'files'));
	tpl_assign('object', $file);

	$this->includeTemplate(get_template_path('view', 'co'));
?>
</div>
</div>


