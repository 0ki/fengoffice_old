<?php
include("public/assets/javascript/fckeditor/fckeditor.php");
 
  set_page_title( lang('write mail'));
 
  $instanceName = "fck" . gen_id();
  $type = array_var($mail_data, 'type','plain');
?>
<script type="text/javascript">
function setBody(iname) {
	var form = Ext.getDom(iname);
	if (Ext.getDom('format_html').checked){
		form['mail[body]'].value = FCKeditorAPI.GetInstance(iname).GetHTML();
	}
	else {
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

function alertFormat(iname, opt) {
	var oEditor = FCKeditorAPI.GetInstance(iname);
	if(opt == 'plain'){
		Ext.MessageBox.confirm('Warning', '<?php echo lang('switch format warn')?>', function(btn){
			if (btn == 'yes') {
				var mailBody = Ext.getDom('mailBody')
				mailBody.style.display = 'block';				
				Ext.getDom('fck_editor').style.display= 'none';
				var oDOM = oEditor.EditorDocument ;
			    var iText ;
			
			    // The are two diffent ways to get the text (without HTML markups).
			    // It is browser specific.
			
			    if ( document.all ) {     // If Internet Explorer.			    
			      iText = oDOM.body.innerText ;
			    }
			    else{               // If Gecko.			    
			      var r = oDOM.createRange() ;
			      r.selectNodeContents( oDOM.body ) ;
			      iText = r.toString() ;
			    }	
				mailBody.value = iText;	
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
		oEditor.SetHTML(mailBody.value);	
	}
}


function setDraft(val){
	var isDraft = Ext.getDom('isDraft');
	isDraft.value = val;
}

function setDiscard(val){
	var the_id = Ext.getDom('id').value;
	document.frmMail.action = og.getUrl('mail', 'delete', {id:the_id, ajax:'true'});
}

</script>

<form style="height:100%;background-color:white;" id="<?php echo $instanceName ?>" name="frmMail"  class="internalForm" action="<?php echo $mail->getSendMailUrl()?>" method="post"  onsubmit="return setBody('<?php echo $instanceName ?>')">
<input type="hidden" name="instanceName" value="<?php echo $instanceName ?>" />
<input type="hidden" name="mail[body]" value="" />
<input type="hidden" name="mail[isDraft]" id="isDraft" value="false" />
<input type="hidden" name="mail[id]" id="id" value="<?php echo  array_var($mail_data, 'id') ?>" />
<?php tpl_display(get_template_path('form_errors')) ?>




<div class="mail" style="height:80%;">
<div class="coInputHeader">
	<div class="coInputHeaderUpperRow">
  		<div class="coInputTitle"><table style="width:535px"><tr><td>
  			<?php echo lang('send mail') ?>
  		</td><td style="text-align:right">
  			<?php echo submit_button(lang('send mail'), '', 
  			array('style'=>'margin-top:0px;margin-left:10px','onclick'=>"setDraft(false)"))?>
  		</td>
  		<td style="text-align:right">
  			<?php echo submit_button(lang('save')." ".lang('draft'), '', 
  			array('style'=>'margin-top:0px;margin-left:10px','onclick'=>"setDraft(true)")) ?>
  		</td>
  		<td style="text-align:right">
  			<?php
  			$strDisabled = array_var($mail_data, 'id') == ''?'disabled':'';
  			echo submit_button(lang('discard'), '', 
  			array('style'=>'margin-top:0px;margin-left:10px','onclick'=>"setDiscard(true)",$strDisabled=>'')) ?>
  		</td>
  		</tr></table>
  		</div>
  	</div>
  
  <div>
    <label for='mailTo'><?php echo lang('mail to')?> <span class="label_required">*</span>  
    </label>
    <?php echo text_field('mail[to]', array_var($mail_data, 'to'), 
    	array('class' => 'title', 'tabindex'=>'10', 'id' => 'mailTo')) ?>
  </div>
  
 	<div id="add_mail_CC" style="<?php  array_var($mail_data, 'cc')==''? print('display:none;'):print('')?>">
    	<label for="mailCC"><?php echo lang('mail CC')?> </label>
    	<?php echo text_field('mail[CC]', array_var($mail_data, 'cc'), 
    	array('class' => 'title', 'id' => 'mailCC', 'tabindex'=>'20')) ?>
 	</div>
 	
 	
 	<div id="add_mail_BCC" style="display:none;">
	    <label for="mailBCC"><?php echo lang('mail BCC')?></label>
	    <?php echo text_field('mail[BCC]', array_var($mail_data, 'BCC'), 
	    array('class' => 'title','id' => 'mailBCC', 'tabindex'=>'30')) ?>
	</div>
 	
 	
   
   
  <div>
    <label for='mailSubject'><?php echo lang('mail subject')?> 
    </label>
    <?php echo text_field('mail[subject]', array_var($mail_data, 'subject'), 
    	array('class' => 'title', 'tabindex'=>'40', 'id' => 'mailSubject')) ?>
  </div>
  <div style="padding-top:5px">
	
	<a href="#" class="option" onclick="og.toggleAndBolden('add_mail_account', this)"><?php echo lang('mail account') ?></a> - 
	<a href="#" class="option" onclick="og.toggleAndBolden('add_mail_CC', this)"><?php echo lang('mail CC') ?></a> - 
	<a href="#" class="option" onclick="og.toggleAndBolden('add_mail_BCC', this)"><?php echo lang('mail BCC') ?></a> - 
	<a href="#" class="option" onclick="og.toggleAndBolden('add_mail_options', this)"><?php echo lang('mail options') ?></a>	
  </div>
</div>
<div class="coInputSeparator"></div>

<!--
<div class="coInputMainBlock">
-->
  <div id="add_mail_account" style="display:none;">
    <label for="mailAccount"><?php echo lang('mail account')?> 
    <span class="desc"><?php echo lang('mail account desc') ?></span></label>
    <?php echo render_select_mail_account('mail[account_id]',  $mail_accounts, '1',
    array('id' => 'mailAccount', 'tabindex'=>'44')) ?>
  </div>
 

  
  
  <div id="add_mail_options" style="display:none;">
    <label><?php echo lang('mail options')?></label>
    <label><?php echo radio_field('mail[format]',$type=='html', array('id' => 'format_html','value' => 'html', 'tabindex'=>'45','onchange'=>"alertFormat('$instanceName','html')")) ." ".lang('format html') ?></label>
    <label><?php echo radio_field('mail[format]',$type=='plain', array('id' => 'format_plain','value' => 'plain', 'tabindex'=>'46', 'onchange'=>"alertFormat('$instanceName','plain')"))." ".lang('format plain')  ?></label>
  </div>
  
     
    <?php 
    $display=($type=='html')?'none':'block';
    $display_fck=($type=='html')?'block':'none';
    echo textarea_field('plain_body', array_var($mail_data, 'body'), 
    array('id' => 'mailBody', 'tabindex'=>'50','style'=>"display:".$display.";width:97%;height:75%;margin-left:1%;margin-right:1%;margin-top:1%;margin-bottom:1%;")) ?>
    <div id="fck_editor" style="display:<?php echo $display_fck ?>; width:100%; height:100%; padding:0px; margin:0px;">
		<?php
			$oFCKeditor = new FCKeditor($instanceName);
			$oFCKeditor->BasePath = 'public/assets/javascript/fckeditor/';
			$oFCKeditor->Width = '100%';
			$oFCKeditor->Height = '100%';
			$oFCKeditor->Config['SkinPath'] = get_theme_url('fckeditor/');
			$oFCKeditor->Value = nl2br(array_var($mail_data, 'body'));
			$oFCKeditor->ToolbarSet  = 'Basic' ;
			$oFCKeditor->Create();
		?>
	</div>
<!-- 
	</div>
-->	
</div>

</form>

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
</script>