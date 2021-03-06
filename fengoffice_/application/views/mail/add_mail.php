<?php 
  set_page_title( lang('write mail'));
  add_page_action(lang('send mail'), $mail->getSendMailUrl(), 'ico-send');
?>

<form style='height:100%;background-color:white'  class="internalForm" action="<?php echo $mail->getSendMailUrl()?>" method="post">

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
	<a href="#" class="option" onclick="og.toggleAndBolden('add_mail_body', this)"><?php echo lang('mail body') ?></a>	
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
  <div id="add_mail_CC" style="display:none;">
    <label for="mailCC"><?php echo lang('mail CC')?> <span class="label_required"></span>
    <span class="desc"><?php echo lang('mail CC desc') ?></span></label>
    <?php echo text_field('mail[CC]', array_var($mail_data, 'CC'), 
    array('id' => 'mailCC', 'tabindex'=>'3')) ?>
  </div>

  <div id="add_mail_BCC" style="display:none;">
    <label for="mailBCC"><?php echo lang('mail BCC')?> <span class="label_required"></span>
    <span class="desc"><?php echo lang('mail BCC desc') ?></span></label>
    <?php echo text_field('mail[BCC]', array_var($mail_data, 'BCC'), 
    array('id' => 'mailBCC', 'tabindex'=>'3')) ?>
  </div>
  
  <div id="add_mail_body">
    <label for="mailBody"><?php echo lang('mail body')?> <span class="label_required"></span>
    </label>
    <?php echo textarea_field('mail[body]', array_var($mail_data, 'body'), 
    array('id' => 'mailBody', 'tabindex'=>'2')) ?>
  </div>
  <?php echo submit_button( lang('send mail') , 's', array('tabindex'=>'5')) ?>

</div>
</div>
</form>