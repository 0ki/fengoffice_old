<?php 
  set_page_title($mailAccount->isNew() ? lang('add mail account') : lang('edit mail account'));
  if (!$mailAccount->isNew() && $mailAccount->canDelete(logged_user()))
  	add_page_action(lang('delete mail account'), $mailAccount->getDeleteUrl(), 'ico-delete');
  tpl_display(get_template_path('form_errors')) 
?>

<form class="internalForm" action="<?php echo $mailAccount->isNew() ? get_url('mail', 'add_account') : $mailAccount->getEditUrl()?>" method="post">
  <div>
    <label for='mailAccountFormName'><?php echo lang('mail account name')?> <span class="label_required">*</span>  
    <span class="desc"><?php echo lang('mail account name description') ?></span></label>
    <?php echo text_field('mailAccount[name]', array_var($mailAccount_data, 'name'), array('id' => 'mailAccountFormName')) ?>
  </div>

  <div>
    <label for="mailAccountFormEmail"><?php echo lang('mail account id')?> <span class="label_required">*</span>
    <span class="desc"><?php echo lang('mail account id description') ?></span></label>
    <?php echo text_field('mailAccount[email]', array_var($mailAccount_data, 'email'), array('id' => 'mailAccountFormEmail')) ?>
  </div>

  <div>
    <label for="mailAccountFormPassword"><?php echo lang('password')?> <span class="label_required">*</span>
    <span class="desc"><?php echo lang('mail account password description') ?></span></label>
    <?php echo password_field('mailAccount[password]', array_var($mailAccount_data, 'password'), array('id' => 'mailAccountFormPassword')) ?>
  </div>

  <div>
    <label for="mailAccountFormServer"><?php echo lang('server address')?> <span class="label_required">*</span>
    <span class="desc"><?php echo lang('mail account server description') ?></span></label>
    <?php echo text_field('mailAccount[server]', array_var($mailAccount_data, 'server'), array('id' => 'mailAccountFormServer')) ?>
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
  <?php echo submit_button($mailAccount->isNew() ? lang('add mail account') : lang('edit mail account')) ?>
</form>