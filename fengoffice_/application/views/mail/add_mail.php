<?php
	require_javascript('og/modules/linkToObjectForm.js'); 
	require_javascript('og/ObjectPicker.js'); 
	
include("public/assets/javascript/fckeditor/fckeditor.php");
 
  set_page_title( lang('write mail'));
  
  $genid = gen_id();
 
  $instanceName = "fck" . $genid;
  $type = array_var($mail_data, 'type', user_config_option('last_mail_format', 'plain'));
  $object = $mail;
  $draft_edit = array_var($mail_data, 'draft_edit', false);
?>
<script>
var genid = '<?php echo $genid ?>';
var empty_body = <?php echo $mail_data['body'] == '' ? 'true' : 'false' ?>;

og.mailSetBody = function(iname) {
	var form = Ext.getDom(iname);
	if (Ext.getDom('format_html').checked){
		form['mail[body]'].value = FCKeditorAPI.GetInstance(iname).GetHTML();
	} else {
		form['mail[body]'].value = Ext.getDom('mailBody').value;
	}
	return true;
}

function FCKeditor_OnComplete(fck) {
	fck.ResetIsDirty();
	fck.Events.AttachEvent('OnSelectionChange', function(fck) {
		var p = og.getParentContentPanel(Ext.get(fck.Name));
		if (fck.IsDirty()) {
			Ext.getCmp(p.id).setPreventClose(true);
		} else {
			Ext.getCmp(p.id).setPreventClose(false);
		}
	});
}

og.mailAlertFormat = function(iname, opt) {
	var oEditor = FCKeditorAPI.GetInstance(iname);
	if(opt == 'plain'){
		Ext.MessageBox.confirm('Warning', '<?php echo escape_single_quotes(lang('switch format warn'))?>', function(btn){
			if (btn == 'yes') {
				var mailBody = Ext.getDom('mailBody')
				mailBody.style.display = 'block';				
				Ext.getDom('fck_editor').style.display= 'none';
				var oDOM = oEditor.EditorDocument;
			    var iText;
			
			    // The are two diffent ways to get the text (without HTML markups).
			    // It is browser specific.			
			    if ( document.all ) {     // If Internet Explorer.			    
			      iText = oDOM.body.innerText;
			    }
			    else{               // If Gecko.			    
			      var r = oDOM.createRange();
			      r.selectNodeContents( oDOM.body );
			      iText = oDOM.body.innerHTML;
			    }
			    iText = og.replaceAllOccurrences(iText, '<br>', '\n');
				mailBody.value = og.replaceAllOccurrences(iText, '<br />', '\n');
				og.oldMailBody = mailBody.value;
				actualSignature = og.replaceAllOccurrences(actualSignature, '<br />', '\n');	
			}
			else{
				Ext.getDom('format_html').checked = true;
				Ext.getDom('format_plain').checked = false;
				Ext.getDom('mailBody').style.display= 'none';
				Ext.getDom('fck_editor').style.display= 'block';	
			}
		});	
	} else {
		var mailBody = Ext.getDom('mailBody')
		mailBody.style.display= 'none';			
		Ext.getDom('fck_editor').style.display= 'block';
		actualSignature = og.replaceAllOccurrences(actualSignature, '\n', '<br />');
		actualSignature = og.replaceAllOccurrences(actualSignature, '\r', '');
		html = og.clean(mailBody.value);
		html = og.replaceAllOccurrences(html, '\n', '<br />');
		html = og.replaceAllOccurrences(html, '\r', '');
		oEditor.SetHTML(html);
		og.oldMailBody = html;
	}
}

og.setHfValue = function(id, val) {
	var hf = Ext.getDom(genid + id);
	if (hf) {
		old = hf.value;
		hf.value = val;
		return old;
	}
	return;
}

og.setDiscard = function(val){
	var the_id = Ext.getDom(genid + 'id').value;
	document.frmMail.action = og.getUrl('mail', 'discard', {id:the_id, ajax:'true'});
}

og.addContactsToAdd = function() {
	var mail_contacts = Ext.get(genid+'hf_mail_contacts').getValue();
	var addresses_str = Ext.get('mailTo').getValue() + ',' + Ext.get('mailCC').getValue() + ',' + Ext.get('mailBCC').getValue();
	var addresses = addresses_str.split(',');
	var fieldset = Ext.get(genid + 'fieldset_add_contacts');
	var container = Ext.get(genid + 'add_contacts_container');
	container.remove();
	
	var label_empty = document.getElementById(genid + 'label_no_contacts');
	var old_style_display = label_empty.style.display;
	label_empty.style.display = 'none';
	
	fieldset.insertHtml('beforeEnd', '<div id="'+genid+'add_contacts_container"></div>');
	var container = Ext.get(genid + 'add_contacts_container');
	
	var cant = 0;
	for (i=0; i<addresses.length; i++) {
		addr = addresses[i].trim();
		if (addr != '' && mail_contacts.indexOf(addr) == -1) {
			var url = og.getUrl('contact', 'add', {ce:addr, div_id:genid+'new_contact_'+i, hf_contacts:genid+'hf_mail_contacts'});
			container.insertHtml('beforeEnd', '<div id="'+genid+'new_contact_'+i+'">' + addr + '&nbsp;<a class="coViewAction ico-add" href="javascript:og.openLink(\''+url+'\', {caller:\'contact\'})" ></a></div>');
			cant++;
		}
	} 
	if (cant == 0) {
		label_empty.style.display = 'block';
	}
}

og.changeSignature = function(acc_id) {
	var new_sig = '""';
	for (i=0; i<accountSignatures.length; i++) {
		if (accountSignatures[i].acc == acc_id) {
			new_sig = accountSignatures[i].sig;
			break;
		}
	}
	var signature = new_sig.substring(1, new_sig.length-2); //Remove quotes
	actualSignature = actualSignature.substring(1, actualSignature.length-2);
	
	if (Ext.getDom('format_html').checked){
		actualSignature = og.replaceAllOccurrences(actualSignature, '\n', '<br />');
		actualSignature = og.replaceAllOccurrences(actualSignature, '\r', '');
		signature = og.replaceAllOccurrences(signature, '\n', '<br />');
		signature = og.replaceAllOccurrences(signature, '\r', '');
		
		html = FCKeditorAPI.GetInstance('<?php echo $instanceName ?>').GetHTML();
		if (html.indexOf('--<br />' + actualSignature) != -1)
			html = html.replace('--<br />' + actualSignature, '--<br />' + signature);
		else {
			html += '<br />--<br />' + signature;
		}
		FCKeditorAPI.GetInstance('<?php echo $instanceName ?>').SetHTML(html);
	} else {
		actualSignature = '--\n' + actualSignature;
		if (Ext.getDom('mailBody').value.indexOf(actualSignature) != -1)
			Ext.getDom('mailBody').value = Ext.getDom('mailBody').value.replace(actualSignature, '--\n' + signature);
		else
			Ext.getDom('mailBody').value += '\n\n--\n' + signature;
	}
	
	actualSignature = new_sig;
}

var accountSignatures = [];
var actualSignature = '';

</script>
<div id="main_div" style="height:100%; overflow-y: hidden;">
<form style="height:100%;background-color:white;" id="<?php echo $instanceName ?>" name="frmMail"  class="internalForm" action="<?php echo $mail->getSendMailUrl()?>" method="post"  onsubmit="return og.mailSetBody('<?php echo $instanceName ?>')">
<input type="hidden" name="instanceName" value="<?php echo $instanceName ?>" />
<input type="hidden" name="mail[body]" value="" />
<input type="hidden" name="mail[isDraft]" id="<?php echo $genid ?>isDraft" value="true" />
<input type="hidden" name="mail[id]" id="<?php echo $genid ?>id" value="<?php echo  array_var($mail_data, 'id') ?>" />
<input type="hidden" name="mail[hf_id]" id="<?php echo $genid ?>hf_id" value="<?php echo $genid ?>id" />
<input type="hidden" name="mail[isUpload]" id="<?php echo $genid ?>isUpload" value="false" />
<input type="hidden" name="mail[autosave]" id="<?php echo $genid ?>autosave" value="false" />
<?php 

	tpl_display(get_template_path('form_errors'));
	$contacts = Contacts::instance()->getAllowedContacts();
    $allEmails = array();
    foreach ($contacts as $contact) {
    	if (trim($contact->getEmail()) != "") {
    		$tmp = trim(str_replace(",", " ", $contact->getFirstname() . ' ' . $contact->getLastname() . ' <' . $contact->getEmail() . '>'));
    		$allEmails[] = $tmp;
    	}
    }
    $companies = Companies::getVisibleCompanies(logged_user());
    foreach ($companies as $company) {
    	if (trim($company->getEmail()) != "") {
    		$tmp = trim(str_replace(",", " ", $company->getName() . ' <' . $company->getEmail() . '>'));
    		$allEmails[] = $tmp;
    	}
    }
    
    $acc_id = array_var($mail_data, 'account_id', (isset($default_account) ? $default_account : $mail_accounts[0]->getId()));
    foreach ($mail_accounts as $m_acc) {
    	$sig = $m_acc->getSignature();
    	if ($type == 'html') 
    		$sig = nl2br($sig);
    	if ($acc_id) {
	    	if ($m_acc->getId() == $acc_id) {
	    		$orig_signature = $sig;
	    ?><script type="text/javascript">
	    		actualSignature = <?php echo json_encode($sig) ?>;
	    </script> <?php
	    	}
    	}
?>
<script type="text/javascript">
		accountSignatures[accountSignatures.length] = {acc:'<?php echo $m_acc->getId() ?>', sig:<?php echo json_encode($sig) ?>};
</script>
<?php } ?>

<input type="hidden" id="<?php echo $genid ?>hf_mail_contacts" value="<?php echo implode(',',$allEmails) ?>" />


<div class="mail" id="mail_div" style="height:100%;">
<div class="coInputHeader" id="header_div">
	<div class="coInputHeaderUpperRow">
  		<div class="coInputTitle"><table style="width:535px"><tr><td>
  			<?php echo lang('send mail') ?>
  		</td><td style="text-align:right">
  			<?php echo submit_button(lang('send mail'), '', 
  			array('style'=>'margin-top:0px;margin-left:10px','onclick'=>"og.setHfValue('isDraft', false);og.stopAutosave();"))?>
  		</td>
  		<td style="text-align:right">
  			<?php echo submit_button(lang('save')." ".lang('draft'), '', 
  			array('style'=>'margin-top:0px;margin-left:10px','onclick'=>"og.setHfValue('isDraft', true);og.stopAutosave();")) ?>
  		</td>
  		<td style="text-align:right">
  			<?php
  			$strDisabled = "";//array_var($mail_data, 'id') == ''?'disabled':'';
  			echo submit_button(lang('discard'), '', 
  			array('style'=>'margin-top:0px;margin-left:10px','onclick'=>"og.setDiscard(true);og.stopAutosave();",$strDisabled=>'')) ?>
  		</td>
  		</tr></table>
  		</div>
  	</div>
  
	<div style="padding-top:10px;">
		<table style="width:95%"><tr><td style="width: 60px;">
    	<label for='mailTo'><?php echo lang('mail to')?> <span class="label_required">*</span></label>
    	</td><td>
    	<?php echo autocomplete_emailfield('mail[to]', array_var($mail_data, 'to'), $allEmails, '', 
    		array('class' => 'title', 'tabindex'=>'10', 'id' => 'mailTo', 'style' => 'width:100%;', 'onchange' => 'og.addContactsToAdd()'), false); ?>
    	</td></tr></table>
	</div>
  
 	<div id="add_mail_CC" style="padding-top:7px;">
 		<table style="width:95%"><tr><td style="width: 60px;">
    	<label for="mailCC"><?php echo lang('mail CC')?> </label>
    	</td><td>
    	<?php echo autocomplete_emailfield('mail[cc]', array_var($mail_data, 'cc'), $allEmails, '', 
    		array('class' => 'title', 'tabindex'=>'20', 'id' => 'mailCC', 'style' => 'width:100%;', 'onchange' => 'og.addContactsToAdd()'), false); ?>
    	</td></tr></table>
 	</div>
 	
 	<div id="add_mail_BCC" style="padding-top:7px;display:none;">
 		<table style="width:95%"><tr><td style="width: 60px;">
	    <label for="mailBCC"><?php echo lang('mail BCC')?></label>
	    </td><td>
	    <?php echo autocomplete_emailfield('mail[bcc]', array_var($mail_data, 'bcc'), $allEmails, '', 
    		array('class' => 'title', 'tabindex'=>'30', 'id' => 'mailBCC', 'style' => 'width:100%;', 'onchange' => 'og.addContactsToAdd()'), false); ?>
    	</td></tr></table>
	</div>
 	
	<div style="padding-top:7px;">
		<table style="width:95%"><tr><td style="width: 60px;">
    	<label for='mailSubject'><?php echo lang('mail subject')?></label>
    	</td><td>
    	<?php echo text_field('mail[subject]', array_var($mail_data, 'subject'), 
    		array('class' => 'title', 'tabindex'=>'40', 'id' => 'mailSubject', 'style' => 'width:100%;')) ?>
    	</td></tr></table>
	</div>
		
	<div>
		<?php echo render_object_custom_properties($object, 'MailContents', true) ?>
	</div>
	
	<?php $categories = array(); Hook::fire('object_edit_categories', $object, $categories); ?>
	<?php $cps = CustomProperties::getHiddenCustomPropertiesByObjectType('MailContents'); ?>
	
	<div style="padding-top:5px">
		<?php if (count($mail_accounts) > 1) { ?>
		<a href="#" class="option" onclick="og.toggleAndBolden('add_mail_account', this);og.resizeMailDiv();"><?php echo lang('mail from') ?></a> - 
		<?php } ?>
		<a href="#" class="option" onclick="og.toggleAndBolden('add_mail_BCC', this);og.resizeMailDiv();"><?php echo lang('mail BCC') ?></a> - 
		<a href="#" class="option" onclick="og.toggleAndBolden('add_mail_options', this);og.resizeMailDiv();"><?php echo lang('mail format options') ?></a> -
 		<a href="#" class="option" onclick="og.toggleAndBolden('add_mail_attachments', this);og.resizeMailDiv();"><?php echo lang('mail attachments') ?></a> -
 		<?php if (count($cps) > 0) { ?>
			<a href="#" class="option" onclick="og.toggleAndBolden('<?php echo $genid ?>add_custom_properties_div',this);og.resizeMailDiv();"><?php echo lang('custom properties') ?></a> -
		<?php } ?>
		<a href="#" class="option" onclick="og.toggleAndBolden('<?php echo $genid ?>add_mail_add_contacts',this);og.resizeMailDiv();"><?php echo lang('mail add contacts') ?></a>
		<?php foreach ($categories as $category) { ?>
			- <a href="#" class="option" <?php if ($category['visible']) echo 'style="font-weight: bold"'; ?> onclick="og.toggleAndBolden('<?php echo $genid . $category['name'] ?>', this);og.resizeMailDiv();"><?php echo lang($category['name'])?></a>
		<?php } ?>
	</div>

	<div id="add_mail_account" style="display:none;">
	    <label for="mailAccount"><?php echo lang('mail from')?>: 
	    <span class="desc"><?php echo lang('mail account desc') ?></span></label>
	    <?php echo render_select_mail_account('mail[account_id]',  $mail_accounts, isset($mail_data['account_id']) ? $mail_data['account_id'] : (isset($default_account) ? $default_account : $mail_accounts[0]->getId()),
	    array('id' => 'mailAccount', 'tabindex'=>'44', 'onchange' => 'og.changeSignature(this.value);')) ?>
	</div>
  
	<div id="add_mail_options" style="display:none;">
		<fieldset>
	    <legend><?php echo lang('mail format options')?></legend>
	    <label><?php echo radio_field('mail[format]',$type=='html', array('id' => 'format_html','value' => 'html', 'tabindex'=>'45','onchange'=>"og.mailAlertFormat('$instanceName','html')")) ." ".lang('format html') ?></label>
	    <label><?php echo radio_field('mail[format]',$type=='plain', array('id' => 'format_plain','value' => 'plain', 'tabindex'=>'46', 'onchange'=>"og.mailAlertFormat('$instanceName','plain')"))." ".lang('format plain')  ?></label>
		</fieldset>
	</div>
	
	<div id="add_mail_attachments" style="display:none;">
 	<fieldset>
 	    <legend><?php echo lang('mail attachments')?></legend>
 	    <?php
 	    $checked = user_config_option('attach_docs_content') ? "checked=\\'checked\\'" : '';
 	    $renderName = "function(obj, count) {
 	    	if (obj.manager != 'ProjectFiles') return obj.name;
 	    	var id = Ext.id();
 	    	return obj.name + '<input id=\'' + id +'\' type=\'checkbox\' $checked  name=\'attach_contents[' + count + ']\' style=\'margin-left: 30px;position:relative;top:3px;width:16px;\'>' +
 	    			'<label style=\'display:inline;margin-left:5px;\' for=\'' + id + '\'>" . lang('attach contents') . "</label>';
 	    }";
 	    $renderName = htmlentities($renderName); ?>
 	    
 	<a id="<?php echo $genid ?>before" href="#" onclick="App.modules.linkToObjectForm.pickObject(this, {renderName: <?php echo $renderName ?>});og.resizeMailDiv();"><?php echo lang('attach from workspace') ?></a>
 	</fieldset>
 	</div>
 	
 	<div id="<?php echo $genid ?>add_mail_add_contacts" style="display:none;">
 	<fieldset id="<?php echo $genid ?>fieldset_add_contacts">
 	    <legend><?php echo lang('mail add contacts')?></legend>
 	    <label id="<?php echo $genid ?>label_no_contacts"><?php echo lang('no contacts to add')?></label>
 	    <div id="<?php echo $genid ?>add_contacts_container"></div>
 	</fieldset>
 	</div>
 	
	<?php foreach ($categories as $category) { ?>
	<div <?php if (!$category['visible']) echo 'style="display:none"' ?> id="<?php echo $genid . $category['name'] ?>">
	<fieldset>
		<legend><?php echo lang($category['name'])?><?php if ($category['required']) echo ' <span class="label_required">*</span>'; ?></legend>
		<?php echo $category['content'] ?>
	</fieldset>
	</div>
	<?php } ?>
	
	<?php if (count($cps) > 0) { ?>
		<div id='<?php echo $genid ?>add_custom_properties_div' style="display:none">
			<fieldset>
				<legend><?php echo lang('custom properties') ?></legend>
				<?php echo render_object_custom_properties($object, 'MailContents', false) ?>
			</fieldset>
		</div>	
	<?php } ?>
  
</div>
<div class="coInputSeparator"></div>
<div id="mail_body_container" style="height: 100%; overflow-y: auto">
    <?php 
    $display = ($type == 'html') ? 'none' : 'block';
    $display_fck = ($type == 'html') ? 'block' : 'none';
    
    $plain_body = $draft_edit ? array_var($mail_data, 'body') : "\n\n--\n$orig_signature" . array_var($mail_data, 'body');

    if (!$draft_edit) {
    	$body = array_var($mail_data, 'body');
    	$idx = stripos($body, '<body');
    	if ($idx !== FALSE) {
    		$end_tag = strpos($body, '>', $idx) + 1;
    		$html_body = utf8_substr($body, 0, $end_tag) . "<br />--<br />$orig_signature<br />" . utf8_substr($body, $end_tag); 
    	} else {
    		$html_body = "<br />--<br />$orig_signature" . $body;
    	}
    } else $html_body = array_var($mail_data, 'body');
    
    echo textarea_field('plain_body', $plain_body, array('id' => 'mailBody', 'tabindex' => '50', 
    	'style' => "display:$display;width:97%;height:94%;margin-left:1%;margin-right:1%;margin-top:1%; min-height:250px;", 
    	'onkeypress' => "if (!og.thisDraftHasChanges) og.checkMailBodyChanges();")) ?>

    <div id="fck_editor" style="display:<?php echo $display_fck ?>; width:100%; height:98%; padding:0px; margin:0px; min-height:265px;">
		<?php
			$oFCKeditor = new FCKeditor($instanceName);
			$oFCKeditor->BasePath = 'public/assets/javascript/fckeditor/';
			$oFCKeditor->Width = '100%';
			$oFCKeditor->Height = '100%';
			$oFCKeditor->Config['SkinPath'] = get_theme_url('fckeditor/');
//			$oFCKeditor->Config['StartupFocus'] = true;
			$oFCKeditor->Config['EnterMode'] = 'br';
			$oFCKeditor->Value = $html_body;
			$oFCKeditor->ToolbarSet  = 'Basic' ;
			$oFCKeditor->Create();
		?>
	</div>
</div>
</div>
</form>
</div>

<script>

og.eventManager.addListener("email saved", function(obj) {
	var form = Ext.getDom(obj.instance);
	if (!form) return;
	form['mail[id]'].value = obj.id;
	var fck = FCKeditorAPI.GetInstance(obj.instance);
	if (fck) {
		fck.ResetIsDirty();
		var p = og.getParentContentPanel(Ext.get(fck.Name));
		Ext.getCmp(p.id).setPreventClose(false);
	}
}, null, {replace:true});

og.resizeMailDiv = function() {
	maindiv = document.getElementById('main_div');
	headerdiv = document.getElementById('header_div');
	if (maindiv != null && headerdiv != null) {
		var divHeight = maindiv.offsetHeight - headerdiv.offsetHeight - 15;
		document.getElementById('mail_div').style.height = divHeight + 'px';
	}
}
og.resizeMailDiv();
window.onresize = og.resizeMailDiv;
/*
// Set cursor in mail body field
var orig_type = '<?php echo $mail_data['type']?>';
if (orig_type == 'plain') {
	var body_field = document.getElementById('mailBody');
	if (body_field) {
		body_field.focus();
		body_field.setSelectionRange(0, 0);
	}
}
*/

//autosave drafts
og.autoSaveTOut = null;
og.thisDraftHasChanges = false;
og.oldMailBody = null;

og.getMailBodyFromUI = function() {
	if (Ext.getDom('format_html').checked) {
		return FCKeditorAPI.GetInstance('<?php echo $instanceName ?>').GetHTML();		
	} else {
		return Ext.getDom('mailBody').value;
	}
}
if (Ext.getDom('format_html') && !Ext.getDom('format_html').checked) { 
	og.oldMailBody = og.getMailBodyFromUI();
}

og.checkMailBodyChanges = function() {
	var new_body = og.getMailBodyFromUI();	
	og.thisDraftHasChanges = og.oldMailBody != new_body;
	og.oldMailBody = new_body;
}

og.autoSaveDraft = function() {
	var old_val = og.setHfValue('isDraft', true);
	og.setHfValue('autosave', true);

	if (og.oldMailBody == null) og.oldMailBody = og.getMailBodyFromUI();
	// if html -> always check for changes, if plain -> only check when key is pressed
	if (Ext.getDom('format_html').checked) og.checkMailBodyChanges();
		
	if (og.thisDraftHasChanges) {
		og.thisDraftHasChanges = false;
		var form = document.getElementById('<?php echo $instanceName ?>');
		if (form) form.onsubmit();
	}
	og.setHfValue('isDraft', old_val);
	og.setHfValue('autosave', false);
	og.stopAutosave();
	og.autoSaveTOut = setTimeout('og.autoSaveDraft()', og.draftAutosaveTimeout);
}

og.stopAutosave = function(){
	if (og.autoSaveTOut) clearTimeout(og.autoSaveTOut);
}

if (og.draftAutosaveTimeout > 0) {
	og.autoSaveTOut = setTimeout('og.autoSaveDraft()', og.draftAutosaveTimeout);
}

Ext.get('mailTo').focus();
</script>