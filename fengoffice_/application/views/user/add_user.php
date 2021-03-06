<?php
	$genid=gen_id();
  set_page_title($user->isNew() ? lang('add user') : lang('edit user'));
?>
<script type="text/javascript" src="<?php echo get_javascript_url('modules/addUserForm.js') ?>"></script>
<form style="height:100%;background-color:white" class="internalForm" action="<?php echo $company->getAddUserUrl() ?>" onsubmit="javascript:ogPermPrepareSendData('<?php echo $genid ?>');return true;" method="post">

<div class="adminAddUser">
  <div class="adminHeader">
  	<div class="adminHeaderUpperRow">
  		<div class="adminTitle"><table style="width:535px"><tr><td>
  			<?php echo $user->isNew() ? lang('new user') : lang('edit user') ?>
  		</td><td style="text-align:right">
  			<?php echo submit_button($user->isNew() ? lang('add user') : lang('save changes'), 's', array('style'=>'margin-top:0px;margin-left:10px', 'tabindex' => '400')) ?>
  		</td></tr></table></div>
  	</div>
  	
  <div>
    <?php echo label_tag(lang('username'), 'userFormName', true) ?>
    <?php echo text_field('user[username]', array_var($user_data, 'username'), 
    	array('class' => 'medium', 'id' => 'userFormName', 'tabindex' => '100')) ?>
  </div>
  	
  <div>
    <?php echo label_tag(lang('email address'), 'userFormEmail', true) ?>
    <?php echo text_field('user[email]', array_var($user_data, 'email'), 
    	array('class' => 'title', 'id' => 'userFormEmail', 'tabindex' => '200')) ?>
  </div>
  
  	<?php if(!$user->isNew() && logged_user()->isAdministrator()) { ?>
  <div>
    <?php echo label_tag(lang('company'), 'userFormCompany', true) ?>
    <?php echo select_company('user[company_id]', array_var($user_data, 'company_id'), 
    	array('id' => 'userFormCompany', 'tabindex' => '300')) ?>
  </div>
<?php } else { ?>
  <input type="hidden" name="user[company_id]" value="<?php echo $company->getId()?>" />
<?php } // if ?>
  	
  </div>
  <div class="adminSeparator"></div>
  <div class="adminMainBlock">
  
  <div>
    <?php echo label_tag(lang('display name'), 'userFormDisplayName') ?>
    <?php echo text_field('user[display_name]', array_var($user_data, 'display_name'), 
    	array('class' => 'medium', 'id' => 'userFormDisplayName', 'tabindex' => '500')) ?>
  </div>
  
  
  <div>
    <?php echo label_tag(lang('timezone'), 'userFormTimezone', false)?>
    <?php echo select_timezone_widget('user[timezone]', array_var($user_data, 'timezone'), 
    	array('id' => 'userFormTimezone', 'class' => 'long', 'tabindex' => '600')) ?>
  </div>
  
<?php if($user->isNew() || logged_user()->isAdministrator()) { ?>
  <fieldset>
    <legend><?php echo lang('password') ?></legend>
    <div>
      <?php echo radio_field('user[password_generator]', array_var($user_data, 'password_generator') == 'random', array('value' => 'random', 'class' => 'checkbox', 'id' => 'userFormRandomPassword', 'onclick' => 'App.modules.addUserForm.generateRandomPasswordClick()', 'tabindex' => '700')) ?> <?php echo label_tag(lang('user password generate'), 'userFormRandomPassword', false, array('class' => 'checkbox'), '') ?>
    </div>
    <div>
      <?php echo radio_field('user[password_generator]', array_var($user_data, 'password_generator') == 'specify', array('value' => 'specify', 'class' => 'checkbox', 'id' => 'userFormSpecifyPassword', 'onclick' => 'App.modules.addUserForm.generateSpecifyPasswordClick()', 'tabindex' => '800')) ?> <?php echo label_tag(lang('user password specify'), 'userFormSpecifyPassword', false, array('class' => 'checkbox'), '') ?>
    </div>
    <div id="userFormPasswordInputs">
      <div>
        <?php echo label_tag(lang('password'), 'userFormPassword', true) ?>
        <?php echo password_field('user[password]', null, array('id' => 'userFormPassword', 'tabindex' => '900')) ?>
      </div>
      
      <div>
        <?php echo label_tag(lang('password again'), 'userFormPasswordA', true) ?>
        <?php echo password_field('user[password_a]', null, array('id' => 'userFormPasswordA', 'tabindex' => '1000')) ?>
      </div>
    </div>
  </fieldset>
  <script type="text/javascript">
    App.modules.addUserForm.generateRandomPasswordClick();
  </script>
<?php } // if ?>


<?php if($company->isOwner()) { ?>
  <div class="formBlock">
    <div>
      <?php echo label_tag(lang('is administrator'), null, true) ?>
      <?php echo yes_no_widget('is_admin', 'userFormIsAdmin', $user->isAdministrator(), lang('yes'), lang('no'), '1100') ?>
    </div>
    
    <!-- div>
      <?php echo label_tag(lang('is auto assign'), null, true) ?>
      <?php echo yes_no_widget('user[auto_assign]', 'userFormAutoAssign', array_var($user_data, 'auto_assign'), lang('yes'), lang('no'), '1200') ?>
    </div -->
  </div>
<?php } else { ?>
  <input type="hidden" name="user[auto_assign]" value="0" />
<?php } // if ?>
  
<?php if($user->isNew()) { ?>
  <div class="formBlock">
    <?php echo label_tag(lang('send new account notification'), null, true) ?>
    <?php echo yes_no_widget('user[send_email_notification]', 'userFormEmailNotification', array($user_data, 'send_email_notification'), lang('yes'), lang('no'), '1300') ?>
    <br /><span class="desc"><?php echo lang('send new account notification desc') ?></span>
  </div>
  <div class="formBlock">
    <?php echo label_tag(lang('create contact from user'), null, true) ?>
    <?php echo yes_no_widget('user[create_contact]', 'createContact', array($user_data, 'create_contact'), lang('yes'), lang('no'), '1400') ?>
    <br /><span class="desc"><?php echo lang('create contact from user desc') ?></span>
  </div>
  <br/>
  
<fieldset>
	<legend><?php echo lang('permissions') ?></legend>
<?php 
	tpl_assign('genid', $genid);
	$this->includeTemplate(get_template_path('user_permissions_control', 'account'));
?>
</fieldset>

<?php } // if ?>


  <?php 
  echo input_field('user[contact_id]',array_var($user_data, 'contact_id',''), array('type' => 'hidden'));
  echo submit_button($user->isNew() ? lang('add user') : lang('save changes'), 's', array('tabindex' => '1500')); ?>
  </div>
  </div>
</form>

<script type="text/javascript">
	Ext.get('userFormName').focus();
</script>