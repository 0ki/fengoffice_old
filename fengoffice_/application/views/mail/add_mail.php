<?php
include("public/assets/javascript/fckeditor/fckeditor.php");
 
  set_page_title( lang('write mail'));
  add_page_action(lang('send mail'), $mail->getSendMailUrl(), 'ico-send');
 
  $instanceName = "fck" . gen_id();
  $type = array_var($mail_data, 'type');
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
</script>
<form style='height:100%;background-color:white'  id="<?php echo $instanceName ?>"  class="internalForm" action="<?php echo $mail->getSendMailUrl()?>" method="post"  onsubmit="return setBody('<?php echo $instanceName ?>')">
<input type="hidden" name="instanceName" value="<?php echo $instanceName ?>" />
<input type="hidden" name="mail[body]" value="" />
<?php tpl_display(get_template_path('form_errors')) ?>




<div class="mail">
<div class="coInputHeader">
	<div class="coInputHeaderUpperRow">
  		<div class="coInputTitle"><table style="width:535px"><tr><td>
  			<?php echo lang('send mail') ?>
  		</td><td style="text-align:right">
  			<?php echo submit_button(lang('send mail'), '', 
  			array('style'=>'margin-top:0px;margin-left:10px')) ?>
  		</td></tr></table>
  		</div>
  	</div>
  
  <div>
    <label for='mailTo'><?php echo lang('mail to')?> <span class="label_required">*</span>  
    </label>
    <?php echo text_field('mail[to]', array_var($mail_data, 'to'), 
    	array('class' => 'title', 'tabindex'=>'1', 'id' => 'mailTo')) ?>
  </div>
  <div>
    <label for='mailSubject'><?php echo lang('mail subject')?> 
    </label>
    <?php echo text_field('mail[subject]', array_var($mail_data, 'subject'), 
    	array('class' => 'title', 'tabindex'=>'1', 'id' => 'mailSubject')) ?>
  </div>
  <div style="padding-top:5px">
	<?php if (isset ($projects) && count($projects) > 0) { ?>
		<a href="#" class="option" onclick="og.toggleAndBolden('add_mail_body', this)"><?php echo lang('Body') ?></a> - 
	<?php } ?>
	<a href="#" class="option" onclick="og.toggleAndBolden('add_mail_account', this)"><?php echo lang('mail account') ?></a> - 
	<a href="#" class="option" onclick="og.toggleAndBolden('add_mail_CC', this)"><?php echo lang('mail CC') ?></a> - 
	<a href="#" class="option" onclick="og.toggleAndBolden('add_mail_BCC', this)"><?php echo lang('mail BCC') ?></a>	- 
	<a href="#" class="option" onclick="og.toggleAndBolden('add_mail_options', this)"><?php echo lang('mail options') ?></a>	
  </div>
  </div>
<div class="coInputSeparator"></div>
<div class="coInputMainBlock">
  <div id="add_mail_account" style="display:none;">
    <label for="mailAccount"><?php echo lang('mail account')?> 
    <span class="desc"><?php echo lang('mail account desc') ?></span></label>
    <?php echo render_select_mail_account('mail[account_id]',  $mail_accounts, '1',
    array('id' => 'mailAccount', 'tabindex'=>'3')) ?>
  </div>
  <div id="add_mail_CC" <?php  array_var($mail_data, 'cc')==''? print('style="display:none;'):print('')?> >
    <label for="mailCC"><?php echo lang('mail CC')?> <span class="label_required"></span>
    <span class="desc"><?php echo lang('mail CC desc') ?></span></label>
    <?php echo text_field('mail[CC]', array_var($mail_data, 'cc'), 
    array('class' => 'title', 'id' => 'mailCC', 'tabindex'=>'3')) ?>
  </div>

  <div id="add_mail_BCC" style="display:none;">
    <label for="mailBCC"><?php echo lang('mail BCC')?> <span class="label_required"></span>
    <span class="desc"><?php echo lang('mail BCC desc') ?></span></label>
    <?php echo text_field('mail[BCC]', array_var($mail_data, 'BCC'), 
    array('id' => 'mailBCC', 'tabindex'=>'3')) ?>
  </div>
  
  <div id="add_mail_options" style="display:none;">
    <label><?php echo lang('mail options')?></label>
    <label><?php echo radio_field('mail[format]',$type=='html', array('id' => 'format_html','value' => 'html', 'tabindex'=>'4','onchange'=>"alertFormat('$instanceName','html')")) ." ".lang('format html') ?></label>
    <label><?php echo radio_field('mail[format]',$type=='plain', array('id' => 'format_plain','value' => 'plain', 'tabindex'=>'5', 'onchange'=>"alertFormat('$instanceName','plain')"))." ".lang('format plain')  ?></label>
  </div>
  
  <div id="add_mail_body">
    <label for="mailBody"><?php echo lang('mail body')?> <span class="label_required"></span>
    <?php 
    $display=($type=='html')?'none':'block';
    $display_fck=($type=='html')?'block':'none';
    echo textarea_field('plain_body', array_var($mail_data, 'body'), 
    array('id' => 'mailBody', 'tabindex'=>'2','style'=>"display:".$display.";")) ?>
    </label>
    <div id="fck_editor" style="display:<?php echo $display_fck ?>; width:90%">
		<?php
			$oFCKeditor = new FCKeditor($instanceName);
			$oFCKeditor->BasePath = 'public/assets/javascript/fckeditor/';
			$oFCKeditor->Width = '100%';
			$oFCKeditor->Height = '100%';
			$oFCKeditor->Config['SkinPath'] = get_theme_url('fckeditor/');
			$oFCKeditor->Value = nl2br(array_var($mail_data, 'body'));
			$oFCKeditor->Create();
		?>
	</div>
  </div>
  <?php echo submit_button( lang('send mail') , 's', array('tabindex'=>'5')) ?>

</div>
</div>
</form>