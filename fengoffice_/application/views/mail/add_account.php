<?php 
  set_page_title($mailAccount->isNew() ? lang('add mail account') : lang('edit mail account'));
  if (!$mailAccount->isNew() && $mailAccount->canDelete(logged_user()))
  	add_page_action(lang('delete mail account'), $mailAccount->getDeleteUrl(), 'ico-delete');
?>

<form class="internalForm" action="<?php echo $mailAccount->isNew() ? get_url('mail', 'add_account') : $mailAccount->getEditUrl()?>" method="post">

<div class="adminAddMailAccount">
  <div class="adminHeader">
  	<div class="adminHeaderUpperRow">
  		<div class="adminTitle"><table style="width:535px"><tr><td>
  			<?php echo $mailAccount->isNew() ? lang('new mail account') : lang('edit mail account') ?>
  		</td><td style="text-align:right">
  			<?php echo submit_button($mailAccount->isNew() ? lang('add mail account') : lang('save changes'), '', 
  			array('style'=>'margin-top:0px;margin-left:10px')) ?>
  		</td></tr></table>
  		</div>
  	</div>
  
  <div>
    <label for='mailAccountFormName'><?php echo lang('mail account name')?> <span class="label_required">*</span>  
    <span class="desc"><?php echo lang('mail account name description') ?></span></label>
    <?php echo text_field('mailAccount[name]', array_var($mailAccount_data, 'name'), 
    	array('class' => 'title', 'tabindex'=>'1', 'id' => 'mailAccountFormName')) ?>
  </div>
  
  </div>
  <div class="adminSeparator"></div>
  <div class="adminMainBlock">

  <div>
    <label for="mailAccountFormEmail"><?php echo lang('mail account id')?> <span class="label_required">*</span>
    <span class="desc"><?php echo lang('mail account id description') ?></span></label>
    <?php echo text_field('mailAccount[email]', array_var($mailAccount_data, 'email'), 
    array('id' => 'mailAccountFormEmail', 'tabindex'=>'2')) ?>
  </div>

  <div>
    <label for="mailAccountFormPassword"><?php echo lang('password')?> <span class="label_required">*</span>
    <span class="desc"><?php echo lang('mail account password description') ?></span></label>
    <?php echo password_field('mailAccount[password]', array_var($mailAccount_data, 'password'), 
    array('id' => 'mailAccountFormPassword', 'tabindex'=>'3')) ?>
  </div>

  <div>
    <label for="mailAccountFormServer"><?php echo lang('server address')?> <span class="label_required">*</span>
    <span class="desc"><?php echo lang('mail account server description') ?></span></label>
    <?php echo text_field('mailAccount[server]', array_var($mailAccount_data, 'server'), 
    array('id' => 'mailAccountFormServer', 'tabindex'=>'4')) ?>
  </div>

<fieldset style="display:none">
	<legend><?php echo lang('email connection method')?></legend>
  <div>
    <?php echo yes_no_widget('mailAccount[is_imap]', 'mailAccountFormIsImap', array_var($mailAccount_data, 'is_imap', false), lang('imap'), lang('pop3')) ?>
  </div>
  <div>
    <?php echo checkbox_field('mailAccount[incoming_ssl]', array_var($mailAccount_data, 'incoming_ssl'), array('id' => 'mailAccountFormIncomingSsl')) ?>
    <label for="mailAccountFormIncomingSsl" class="yes_no"><?php echo lang('incoming ssl') ?></label>
  </div>
  <div>
    <?php echo label_tag(lang('incoming ssl port'), 'mailAccountFormIncomingSslPort') ?>
    <?php echo text_field('mailAccount[incoming_ssl_port]', array_var($mailAccount_data, 'incoming_ssl_port'), array('id' => 'mailAccountFormIncomingSslPort')) ?>
  </div>
</fieldset>
  <?php echo submit_button($mailAccount->isNew() ? lang('add mail account') : lang('save changes'), 's', array('tabindex'=>'5')) ?>

</div>
</div>
</form>

<script type="text/javascript">
	Ext.get('mailAccountFormName').focus();
</script>