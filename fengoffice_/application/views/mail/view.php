<?php
  add_page_action(lang('reply mail'), $email->getReplyMailUrl()  , 'ico-reply');
  add_page_action(lang('reply to all mail'), $email->getReplyMailUrl()."&all=1"  , 'ico-reply-all');
  add_page_action(lang('forward mail'), $email->getForwardMailUrl()  , 'ico-forward');
  if($email->canDelete(logged_user())) {
    add_page_action(lang('delete email'),"javascript:if(confirm(lang('confirm delete mail content'))) {og.openLink('" . $email->getDeleteUrl() ."');" , 'ico-delete');
  }
  if ($email->canEdit(logged_user())){
    add_page_action(lang('classify'), $email->getClassifyUrl(), 'ico-classify');
  }
  $c = 0;
  $genid = gen_id();
?>

<?php if ($email instanceof MailContent) {?>
<div style="padding:7px">
<div class="email">

	<?php $description = '<div class="coInfo">
	<table>
	<tr><td style="width:100px">' . lang('from') . ':</td><td>' . clean($email->getFromName()) . '</td></tr>
	<tr><td>' . lang('to') . ':</td><td>' . MailUtilities::displayMultipleAddresses($email->getTo()) . '</td></tr>
	<tr><td>' . lang('date') . ':</td><td>' . $email->getSentDate()->format('D, d M Y H:i:s') . '</td></tr>';
	
	if ($email->getHasAttachments()) {
		$description .=	'<tr><td colspan=2>	<fieldset>
		<legend class="toggle_collapsed" onclick="og.toggle(\'mv_attachments\',this)">' . lang('attachments') . '</legend>
		<div id="mv_attachments" style="display:none">
		<table>';
		foreach($parsedEmail["Attachments"] as $att) {
			$fName = iconv_mime_decode($att["FileName"], 0, "UTF-8");
			$description .= '<tr><td style="padding-right: 10px">';
			$ext = substr($fName,strrpos($fName,'.') + 1);
			$fileType = FileTypes::getByExtension($ext);
			if (isset($fileType))
				$icon = $fileType->getIcon();
			else
				$icon = "unknown.png";
      		$description .=	'<img src="' . get_image_url("filetypes/".$icon) .'"></td>
			<td><a href="' . get_url('mail', 'download_attachment', 
      			array('email_id' => $email->getId(), 'attachment_id' => $c)) . '">' . clean($fName) . '</a></td></tr>';
      		$c++;
		}
		$description .= '</table></div></fieldset></td></tr>';
  } //if
  $description .= '</table></div>';
  
		if($email->getBodyHtml() != ''){
			$content = convert_to_links($email->getBodyHtml());
			
			$ispan = strpos(strtoupper($content),"<STYLE>");
			$body = strpos(strtoupper($content),"<BODY>");
			while ($ispan > 0 && ($body <= 0 || $ispan < $body)){
				$iendspan = strpos(strtoupper($content), "</STYLE>") + 8;
				$totLength = $iendspan - $ispan;
				if ($totLength > 0)
					$content = substr($content,0,$ispan) . substr($content,$iendspan);
					
				$ispan = strpos(strtoupper($content),"<STYLE>");
				$body = strpos(strtoupper($content),"<BODY>");
			}
		} else {
			if ($email->getBodyPlain() != ''){
				$content =  '<div>' . convert_to_links(nl2br(clean($email->getBodyPlain()))) . '</div>';
			} else {
				$content =  '<div>' . convert_to_links(nl2br(clean($email->getContent()))) . '</div>';
			}
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


