<?php
	if (!$email->isTrashed()) {
		add_page_action(lang('reply mail'), $email->getReplyMailUrl()  , 'ico-reply', null, null, true);
		add_page_action(lang('reply to all mail'), $email->getReplyMailUrl()."&all=1"  , 'ico-reply-all', null, null, true);
		add_page_action(lang('forward mail'), $email->getForwardMailUrl()  , 'ico-forward', null, null, true);
	}
	if($email->canDelete(logged_user()) && $email->getCreatedById() == logged_user()->getId()) {
		if ($email->isTrashed()) {
			add_page_action(lang('restore from trash'), "javascript:if(confirm(lang('confirm restore objects'))) og.openLink('" . $email->getUntrashUrl() ."');", 'ico-restore', null, null, true);
			add_page_action(lang('delete permanently'), "javascript:if(confirm(lang('confirm delete permanently'))) og.openLink('" . $email->getDeletePermanentlyUrl() ."');", 'ico-delete', null, null, true);
		} else {
			add_page_action(lang('move to trash'), "javascript:if(confirm(lang('confirm move to trash'))) og.openLink('" . $email->getTrashUrl() ."');", 'ico-trash', null, null, true);
		}
	}
	if ($email->canEdit(logged_user()) && !$email->isTrashed() && $email->getCreatedById() == logged_user()->getId()){
		add_page_action(lang('classify'), $email->getClassifyUrl(), 'ico-classify', null, null, true);
		// if is classified, allow unclassify
		if ($email->getWorkspacesIdsCSV(logged_user()->getWorkspacesQuery())) {
			add_page_action(lang('unclassify'), "javascript:if(confirm(lang('confirm unclassify email'))) og.openLink('" . $email->getUnclassifyUrl() ."');", 'ico-unclassify');
		}
	}
  
	$c = 0;
	$genid = gen_id();
	$use_24_hours = user_config_option('time_format_use_24');
	$time_format = $use_24_hours ? 'G:i' : 'g:i a';
?>

<script>
	var genid = '<?php echo $genid ?>';
	og.showMailImages = function(pre, rand) {
		var iframe = document.getElementById(genid + 'ifr');
		iframe.src = og.getUrl('mail', 'show_html_mail', {acc: pre, r: rand});

		document.getElementById(genid + 'showImagesLink').style.display = 'none';
		
		iframe.style.display = 'none';
		iframe.style.display = 'block';
		if (Ext.isIE) iframe.contentWindow.location.reload();
	}
</script>

<?php if ($email instanceof MailContent) {?>
<div style="padding:7px">
<div class="email">

	<?php $description = '<div class="coInfo">
	<table>
	<tr><td style="width:100px">' . lang('from') . ':</td><td>' . MailUtilities::displayMultipleAddresses(clean($email->getFrom())) . '</td></tr>
	<tr><td>' . lang('to') . ':</td><td>' . MailUtilities::displayMultipleAddresses(clean($email->getTo())) . '</td></tr>';
	if ($email->getCc() != '') {
		$description .= '<tr><td>' . lang('mail CC') . ':</td><td>' . MailUtilities::displayMultipleAddresses(clean($email->getCc())) . '</td></tr>';
	}
	$description .= '<tr><td>' . lang('date') . ':</td><td>' . format_datetime($email->getSentDate(), 'l, j F Y - '.$time_format, logged_user()->getTimezone()) . '</td></tr>';
	
	if ($email->getHasAttachments()) {
		$description .=	'<tr><td colspan=2>	<fieldset>
		<legend class="toggle_collapsed" onclick="og.toggle(\'mv_attachments\',this)">' . lang('attachments') . '</legend>
		<div id="mv_attachments" style="display:none">
		<table>';
		foreach($attachments as $att) {
			$size = format_filesize(strlen($att["Data"]));
			$fName = iconv_mime_decode($att["FileName"], 0, "UTF-8");
			$description .= '<tr><td style="padding-right: 10px">';
			$ext = get_file_extension($fName);
			$fileType = FileTypes::getByExtension($ext);
			if (isset($fileType))
				$icon = $fileType->getIcon();
			else
				$icon = "unknown.png";
      		$description .=	'<img src="' . get_image_url("filetypes/" . $icon) .'"></td>
			<td><a target="_self" href="' . get_url('mail', 'download_attachment', 
      			array('email_id' => $email->getId(), 'attachment_id' => $c)) . '">' . clean($fName) . " ($size)" . '</a></td></tr>';
      		$c++;
		}
		$description .= '</table></div></fieldset></td></tr>';
  } //if
  $description .= '</table></div>';
  
		if($email->getBodyHtml() != ''){
			$html_content = purify_html($email->getBodyHtml());
			
			// links must open in a new tab or window
			$html_content = str_replace('href', 'target="_blank" href', $html_content);
						
			// put content into an iframe, in order to avoid css to affect the rest of the interface
			$tmphtml = $email->getAccountId().'temp_mail_content.html';
			
			$content = '';
			if (user_config_option('block_email_images') && html_has_images($html_content)) {
				// save content with images
				$filename_with_images = ROOT.'/tmp/wi_'.$tmphtml;
				if (file_exists($filename_with_images)) unlink($filename_with_images);
				$handle = fopen($filename_with_images, 'wb');
				fwrite($handle, $html_content);		
				fclose($handle);
				
				$html_content = remove_images_from_html($html_content);
				$content = '<div id="'.$genid.'showImagesLink" style="background-color:#FFFFCC">'.lang('images are blocked').' 
					<a href="#" onclick="og.showMailImages(\'wi_'.$email->getAccountId().'\', '.rand().');" style="text-decoration: underline;">'.lang('show images').'</a>
				</div>';
			}
			
			if (file_exists(ROOT.'/tmp/'.$tmphtml)) unlink(ROOT.'/tmp/'.$tmphtml);
			$handle = fopen(ROOT.'/tmp/'.$tmphtml, 'wb');
			fwrite($handle, $html_content);
			fclose($handle);
			$url = get_url('mail', 'show_html_mail', array('acc' => $email->getAccountId(), 'r' => rand()));
			$content .= '<iframe id="'.$genid.'ifr" style="width:100%;overflow-y:hidden;" frameborder="0" src="'.$url.'" 
							onload="javascipt:iframe=document.getElementById(\''.$genid.'ifr\'); iframe.height = iframe.contentWindow.document.body.scrollHeight + 30;">
						</iframe>';
			'<script>if (Ext.isIE) document.getElementById(\''.$genid.'ifr\').contentWindow.location.reload();</script>';
		} else {
			if ($email->getBodyPlain() != ''){
				$content =  '<div>' . nl2br(convert_to_links(clean($email->getBodyPlain()))) . '</div>';
			} else $content = '<div></div>';
		}
		$strDraft = '';
		if ($email->getIsDraft()) {
			$strDraft = "<span style='font-size:80%;color:red'>&nbsp;".lang('draft')."</style>";
		}
		tpl_assign("title", lang('email') . ': ' . clean($email->getSubject()).$strDraft);
		tpl_assign("iconclass", 'ico-large-email');
		tpl_assign("content", $content);
		tpl_assign("object", $email);
		tpl_assign("description", $description);
		
		$this->includeTemplate(get_template_path('view', 'co'));
	?>

</div>
</div>
<?php } else { echo lang('email not available'); } //if ?>

