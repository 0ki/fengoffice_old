<?php
if (isset($file) && $file instanceof ProjectFile) {
	$options = array();

	if (!$file->isTrashed()){
		if ($file && strcmp($file->getTypeString(), 'prsn')==0) {
			add_page_action(lang('slideshow'), "javascript:og.slideshow(".$file->getId().")", 'ico-slideshow');
		}
		
		if ($file && strcmp($file->getTypeString(), 'audio/mpeg')==0) {
			$songname = $file->getProperty("songname");
			$artist = $file->getProperty("songartist");
			$album = $file->getProperty("songalbum");
			$track = $file->getProperty("songtrack");
			$year = $file->getProperty("songyear");
			$duration = $file->getProperty("songduration");
			$songdata = "['" . str_replace("'", "\\'", $songname) . "','" . str_replace("'", "\\'", $artist) . "','" . str_replace("'", "\\'", $album) . "','" . str_replace("'", "\\'", $track) . "','" . str_replace("'", "\\'", $year) . "','" . str_replace("'", "\\'", $duration) . "','" . $file->getDownloadUrl() ."','" . str_replace("'", "\\'", $file->getFilename()) . "'," . $file->getId() . "]";
			add_page_action(lang('play'), "javascript:og.playMP3(" . $songdata . ")", 'ico-play');
			add_page_action(lang('queue'), "javascript:og.queueMP3(" . $songdata . ")", 'ico-queue');
		} else if ($file && strcmp($file->getTypeString(), 'application/xspf+xml')==0) {
			add_page_action(lang('play'), "javascript:og.playXSPF(" . $file->getId() . ")", 'ico-play');
		}
	}
	
	if($file->canDownload(logged_user())) { 
		add_page_action(lang('download') . ' (' . format_filesize($file->getFilesize()) . ')', $file->getDownloadUrl(), 'ico-download', '', array("download" => true));
	}
	
	if (!$file->isTrashed()){
		if ($file->isCheckedOut()){
			if ($file->canCheckin(logged_user())){
				add_page_action(lang('checkin file'), $file->getCheckinUrl(), 'ico-checkin'); 
				add_page_action(lang('undo checkout'), $file->getUndoCheckoutUrl() . "&show=redirect", 'ico-undo'); 
			}
			
		} else {
			if ($file->canCheckout(logged_user())) { 
				add_page_action(lang('checkout file'), $file->getCheckoutUrl(). "&show=redirect", 'ico-checkout');
			}
		}
		
		if($file->canEdit(logged_user())) {
			if ($file->isModifiable()) { 
				add_page_action(lang('edit this file'), $file->getModifyUrl(), 'ico-edit');
			}
			
			add_page_action(lang('edit file properties'), $file->getEditUrl(), 'ico-properties');
		}
	}
		
	if($file->canDelete(logged_user())) {
		if ($file->isTrashed()) {
    		add_page_action(lang('restore from trash'), "javascript:if(confirm(lang('confirm restore objects'))) og.openLink('" . $file->getUntrashUrl() ."');", 'ico-restore');
    		add_page_action(lang('delete permanently'), "javascript:if(confirm(lang('confirm delete permanently'))) og.openLink('" . $file->getDeletePermanentlyUrl() ."');", 'ico-delete');
    	} else {
    		add_page_action(lang('move to trash'), "javascript:if(confirm(lang('confirm move to trash'))) og.openLink('" . $file->getTrashUrl() ."');", 'ico-trash');
    	}
	}

// Fix the slideshow!!!!
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
      		$description .= lang('file revision info long', $last_revision->getRevisionNumber(), $last_revision->getCreatedBy()->getCardUrl(), clean($last_revision->getCreatedBy()->getDisplayName()), format_descriptive_date($last_revision->getCreatedOn()));
		} else {
			$description .= lang('file revision info short', $last_revision->getRevisionNumber(), format_descriptive_date($last_revision->getCreatedOn()));
		}
	} // if
	
	if (!$file->isTrashed())
		tpl_assign('image', '<div><img src="' . $file->getTypeIconUrl(false) .'" alt="' . clean($file->getFilename()) . '" /></div>');
	tpl_assign('iconclass', $file->isTrashed()? 'ico-large-files-trashed' :  'ico-large-files');
	tpl_assign('description', $description);
	tpl_assign('title', clean($file->getFilename()));
	tpl_assign("content_template", array('file_details_content', 'files'));
	tpl_assign('object', $file);

	$this->includeTemplate(get_template_path('view', 'co'));
?>
</div>
</div>
<?php } //if isset ?>

