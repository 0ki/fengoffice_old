<?php
	if (!$email->isTrashed()) {
		add_page_action(lang('reply mail'), $email->getReplyMailUrl()  , 'ico-reply', null, null, true);
		add_page_action(lang('reply to all mail'), $email->getReplyMailUrl()."&all=1"  , 'ico-reply-all', null, null, true);
		add_page_action(lang('forward mail'), $email->getForwardMailUrl()  , 'ico-forward', null, null, true);
		add_page_action(lang('print'), $email->getPrintUrl(), 'ico-print', "_blank", null, true);
	}
	if($email->canDelete(logged_user()) && $email->getCreatedById() == logged_user()->getId()) {
		if ($email->isTrashed()) {
			add_page_action(lang('restore from trash'), "javascript:if(confirm(lang('confirm restore objects'))) og.openLink('" . $email->getUntrashUrl() ."');", 'ico-restore', null, null, true);
			add_page_action(lang('delete permanently'), "javascript:if(confirm(lang('confirm delete permanently'))) og.openLink('" . $email->getDeletePermanentlyUrl() ."');", 'ico-delete', null, null, true);
		} else {
			add_page_action(lang('move to trash'), "javascript:if(confirm(lang('confirm move to trash'))) og.openLink('" . $email->getTrashUrl() ."');", 'ico-trash', null, null, true);
		}
	}
	if ($email->canEdit(logged_user()) && !$email->isTrashed()){
		add_page_action(lang('classify'), $email->getClassifyUrl(), 'ico-classify', null, null, true);
		// if is classified, allow unclassify
		if ($email->getWorkspacesIdsCSV(logged_user()->getWorkspacesQuery())) {
			add_page_action(lang('unclassify'), "javascript:if(confirm(lang('confirm unclassify email'))) og.openLink('" . $email->getUnclassifyUrl() ."');", 'ico-unclassify');
		}
		if (!$email->isArchived()) {
			add_page_action(lang('archive'), "javascript:if(confirm(lang('confirm archive object'))) og.openLink('" . $email->getArchiveUrl() ."');", 'ico-archive-obj');
		} else {
			add_page_action(lang('unarchive'), "javascript:if(confirm(lang('confirm unarchive object'))) og.openLink('" . $email->getUnarchiveUrl() ."');", 'ico-unarchive-obj', null, null, true);
		}
	}
	if (count($email->getWorkspaces())) {
		add_page_action(lang('create task from email'), get_url('task', 'add_task', array('from_email' => $email->getId())), 'ico-task', null, null, true);
	}
	add_page_action(lang('download email'), get_url('mail', 'download', array('id' => $email->getId())), 'ico-download', '_self');
  
	$c = 0;
	$genid = gen_id();
	$use_24_hours = user_config_option('time_format_use_24');
	$time_format = $use_24_hours ? 'G:i' : 'g:i a';
?>

<script>
	var viewing_quotes = false;
	var viewing_images = false;
	var genid = '<?php echo $genid ?>';
	var tt = '<?php echo logged_user()->getTwistedToken() ?>';
	og.showMailImages = function(pre, rand) {
		if (viewing_quotes) pre = "wiq_" + pre.substring(pre.indexOf("_")+1);
		og.changeContentIframeSrc(pre, rand);
		document.getElementById(genid + 'showImagesLink').style.display = 'none';
		viewing_images = true;
	}
	
	og.showQuotedHtml = function(pre, rand) {
		if (viewing_images) pre = "wi" + pre;
		og.changeContentIframeSrc(pre, rand); 
		document.getElementById(genid + 'showQuotedText').style.display = 'none';
		viewing_quotes = true;
	}
	
	og.changeContentIframeSrc = function(pre, rand) {
		var iframe = document.getElementById(genid + 'ifr');
		if (og.sandboxName) {
			iframe.src = og.getSandboxUrl('feed', 'show_html_mail', {acc: pre, r: rand, id: og.loggedUser.id, token: tt});
		} else {
			iframe.src = og.getUrl('mail', 'show_html_mail', {acc: pre, r: rand, id: og.loggedUser.id, token: tt});
		}

		/*iframe.style.display = 'none';
		iframe.style.display = 'block';
		if (Ext.isIE) iframe.contentWindow.location.reload();*/
	}
</script>

<?php if ($email instanceof MailContent) {?>
<div style="padding:7px">
<div class="email">

	<?php $description = '<div class="coInfo">
	<table>
	<tr><td style="width:100px">' . lang('from') . ':</td><td>' . MailUtilities::displayMultipleAddresses(clean($email->getFromName()." <".$email->getFrom().">")) . '</td></tr>
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
		if (($email_count = MailContents::countMailsInConversation($email)) > 1) {
			$emails_info = MailContents::getMailsFromConversation($email);
			$conversation_block = '';
			$conversation_block .= '<div id="'.$genid.'conversation" style="margin-bottom:10px;' . 
				(count($emails_info) > 6 ? 'max-height:101px;overflow:auto' : ''  ) . '"><table style="width:100%;">';
			
			$unread = 0;
			foreach($emails_info as $count => $info) { 
				$row_cls = $count % 2 ? 'odd' : 'even';
				$is_current = $info->getId() == $email->getId();
				$style = $is_current ? "style='background-color:#FFDD78'" : "";
				$conversation_block .= '<tr class="'.$row_cls.'" ' . $style . '>';
				
				$state = $info->getState();
				$show_user_icon = false;
				if ($state == 1 || $state == 3 || $state == 5) {
					if ($info->getCreatedById() == logged_user()->getId()) {
						$from = lang('you');
					} else {
						$from = $info->getCreatedByDisplayName();
					}
					$show_user_icon = true;
				} else {
					$from = $info->getFrom();
				}
				
				$read_style = "";
				if (!$info->getIsRead(logged_user()->getId()) ) {
					$read_style = "font-weight: bold;";
					$unread++;
				}
				
				$conversation_block .= '<td style="width:20px;'.$read_style.'">';
				if ($info->getHasAttachments()) { 
					$conversation_block .= '<div class="db-ico ico-attachment"></div>';
				}
				$conversation_block .= '<td style="width:20px;'.$read_style.'">';
				if ($show_user_icon) { 
					$conversation_block .= '<div class="db-ico ico-user"></div>';
				}
				
				$info_text = $info->getBodyPlain();
				if (strlen_utf($info_text) > 90) $info_text = substr_utf($info_text, 0, 90) . "...";
				
				$view_url = get_url('mail', 'view', array('id' => $info->getId(), 'replace' => 1));
				$conversation_block .= '<td>';
				$conversation_block .= '	<a style="'.$read_style.'" class="internalLink" href="'.$view_url.'" onclick="og.openLink(\''.$view_url.'\');return false;" title="'.$info->getFrom().'">';
				$conversation_block .= $from;
				if (!$is_current) $conversation_block .= '	</a><span class="desc">- '.$info_text.'</span></td>';
				
				$info_date = $info->getSentDate() instanceof DateTimeValue ? ($info->getSentDate()->isToday() ? format_time($info->getSentDate()) : format_datetime($info->getSentDate())) : lang('n/a');
				$conversation_block .= '</td><td style="text-align:right;padding-right:3px"><span class="desc">'. lang('date').': </span>'. $info_date .'</td>';

			} //foreach
			$conversation_block .= '</table>';
			$conversation_block .= '</div>';
		} else {
			$conversation_block = '';
		}
  
		if($email->getBodyHtml() != ''){
			if (defined('SANDBOX_URL')) {
				$html_content = $email->getBodyHtml();
			} else {
				$html_content = purify_html($email->getBodyHtml());
			}
			// links must open in a new tab or window
			$html_content = str_replace('href', 'target="_blank" href', $html_content);
			
			$mail_html_content = MailUtilities::removeQuotedBlocks($html_content);
			$html_content = array_var($mail_html_content, 'unquoted', '');
			$quoted_html_content = array_var($mail_html_content, 'quoted');
			
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
				$content_wimages = $html_content;
				
				$html_content = remove_images_from_html($html_content);
				$content = '<div id="'.$genid.'showImagesLink" style="background-color:#FFFFCC">'.lang('images are blocked').' 
					<a href="#" onclick="og.showMailImages(\'wi_'.$email->getAccountId().'\', '.rand().');" style="text-decoration: underline;">'.lang('show images').'</a>
				</div>';
			}
			
			if (file_exists(ROOT.'/tmp/'.$tmphtml)) unlink(ROOT.'/tmp/'.$tmphtml);
			$handle = fopen(ROOT.'/tmp/'.$tmphtml, 'wb');
			fwrite($handle, $html_content);
			fclose($handle);
			if (defined('SANDBOX_URL')) {
				$url = get_sandbox_url('feed', 'show_html_mail', array('acc' => $email->getAccountId(), 'r' => gen_id(), 'id' => logged_user()->getId(), 'token' => logged_user()->getTwistedToken()));
			} else {
				$url = get_url('mail', 'show_html_mail', array('acc' => $email->getAccountId(), 'r' => gen_id()));
			}
			$content .= '<iframe id="'.$genid.'ifr" name="'.$genid.'ifr" style="width:100%;" frameborder="0" src="'.$url.'" 
							onload="javascipt:iframe=document.getElementById(\''.$genid.'ifr\'); iframe.height = Math.min(600, iframe.contentWindow.document.body.scrollHeight) ;">
						</iframe>';
			'<script>if (Ext.isIE) document.getElementById(\''.$genid.'ifr\').contentWindow.location.reload();</script>';

			if ($quoted_html_content) {
				$q_link = "<a id='".$genid."showQuotedText' style='font-family:verdana,arial,helvetica,sans-serif; font-size:11px; line-height:150%; cursor:pointer; color:#003562; padding-left:10px;'";
				$q_link .= " onclick='og.showQuotedHtml(\"q_".$email->getAccountId()."\", ".rand().");'>";
				$q_link .= ":: ".lang('show quoted text')." ::</a>";
				
				file_put_contents(ROOT."/tmp/q_".$tmphtml, $html_content . $quoted_html_content);
				if (isset($content_wimages)) {
					file_put_contents(ROOT."/tmp/wiq_".$tmphtml, $content_wimages . $quoted_html_content);
				}
				$content .= $q_link;
			}
			
		} else {
			if ($email->getBodyPlain() != ''){
				$mail_content = MailUtilities::removeQuotedText($email->getBodyPlain());
				$content = array_var($mail_content, 'unquoted', '');
				$quoted_content = array_var($mail_content, 'quoted');
				
				$content =  '<div>' . nl2br(convert_to_links(clean($content))) . '</div>';
				if ($quoted_content != '') {
					$content .= "<a class='internalLink' style='padding-left:10px;' href='#' onclick='document.getElementById(\"".$genid."quoted_text\").style.display=\"block\"; this.style.display = \"none\";'>
					:: ".lang('show quoted text')." ::</a><div id='".$genid."quoted_text' style='display:none'>". nl2br(convert_to_links(clean($quoted_content))) ."</div>";
				}
				$content = '<div style="max-height: 600px; overflow: auto;">' . $content . '</div>';
			} else $content = '<div></div>';
		}
		$strDraft = '';
		if ($email->getIsDraft()) {
			$strDraft = "<span style='font-size:80%;color:red'>&nbsp;".lang('draft')."</style>";
		}
				
		tpl_assign("title", lang('email') . ': ' . clean($email->getSubject()).$strDraft);
		tpl_assign("iconclass", 'ico-large-email');
		tpl_assign("mail_conversation_block" , $conversation_block);
		tpl_assign("content", $content);
		tpl_assign("object", $email);
		tpl_assign("description", $description);
		
		$this->includeTemplate(get_template_path('view', 'co'));
	?>

</div>
</div>
<?php } else { echo lang('email not available'); } //if ?>

