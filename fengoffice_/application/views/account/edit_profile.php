<?php
    set_page_title(lang('update profile'));
  
  if($user->canUpdateProfile(logged_user())) {
	add_page_action(lang('update avatar'), $user->getUpdateAvatarUrl(), 'ico-picture');
	add_page_action(lang('change password'),$user->getEditPasswordUrl(), 'ico-password');
  } // if
  
  if($user->canUpdatePermissions(logged_user())) {
  	add_page_action(lang('permissions'), $user->getUpdatePermissionsUrl(), 'ico-permissions');
  } // if

  $genid = gen_id();
?>
<form style="height:100%;background-color:white" class="internalForm" action="<?php echo $user->getEditProfileUrl($redirect_to) ?>" method="post">


<div class="adminEditProfile">
  <div class="adminHeader">
  	<div class="adminHeaderUpperRow">
  		<div class="adminTitle"><table style="width:535px"><tr><td>
  			<?php echo lang('update profile') ?>
  		</td><td style="text-align:right">
  			<?php echo submit_button(lang('save changes'), 's', array('style'=>'margin-top:0px;margin-left:10px')) ?>
  		</td></tr></table></div>
  	</div>
  
  <div>
    <?php echo label_tag(lang('display name'), 'profileFormDisplayName') ?>
    <?php echo text_field('user[display_name]', array_var($user_data, 'display_name'), 
    	array('id' => 'profileFormDisplayName', 'tabindex' => '1', 'class' => 'title')) ?>
  </div>
  
  	<div style="padding-top:5px">
		<?php if(logged_user()->isAdministrator()) { ?>
			<a href="#" class="option" tabindex=0 onclick="og.toggleAndBolden('<?php echo $genid ?>update_profile_administrator_options',this)"><?php echo lang('administrator options') ?></a> - 
		<?php } // if ?>
		<a href="#" class="option" tabindex=0 onclick="og.toggleAndBolden('<?php echo $genid ?>update_profile_phone_numbers',this)"><?php echo lang('phone numbers') ?></a> - 
		<?php if(is_array($im_types) && count($im_types)) { ?>
			<a href="#" class="option" tabindex=0 onclick="og.toggleAndBolden('<?php echo $genid ?>update_profile_im',this)"><?php echo lang('instant messengers') ?></a> - 
		<?php } ?>
		<a href="#" class="option" tabindex=0 onclick="og.toggleAndBolden('<?php echo $genid ?>update_profile_timezone',this)"><?php echo lang('timezone') ?></a>
	</div>
  
  </div>
  <div class="adminSeparator"></div>
  <div class="adminMainBlock">

<?php if(logged_user()->isAdministrator()) { ?>

  <div id="<?php echo $genid ?>update_profile_administrator_options" style="display:none">
  <fieldset>
    <legend><?php echo lang('administrator update profile notice') ?></legend>
    <div class="content">
      <div>
        <?php echo label_tag(lang('username'), 'profileFormUsername', true) ?>
        <?php echo text_field('user[username]', array_var($user_data, 'username'), 
        array('id' => 'profileFormUsername', 'tabindex' => '2')) ?>
      </div>
      
      <div>
        <?php echo label_tag(lang('company'), 'userFormCompany', true) ?>
        <?php echo select_company('user[company_id]', array_var($user_data, 'company_id'), 
        array('id' => 'userFormCompany', 'tabindex' => '3')) ?>
      </div>
      
<?php if($company->isOwner()) { ?>
      <fieldset>
        <legend><?php echo lang('options') ?></legend>
        
        <?php if($user->getId() != 1) /* System admin cannot change admin status */ {?>
	        <div>
	          <?php echo label_tag(lang('is administrator'), null, true) ?>
	          <?php echo yes_no_widget('user[is_admin]', 'userFormIsAdmin', array_var($user_data, 'is_admin'), lang('yes'), lang('no')) ?>
	        </div>
        <?php } ?>
        
        <!-- div>
          <?php echo label_tag(lang('is auto assign'), null, true) ?>
          <?php echo yes_no_widget('user[auto_assign]', 'userFormAutoAssign', array_var($user_data, 'auto_assign'), lang('yes'), lang('no')) ?>
        </div -->
      </fieldset>
<?php } else { ?>
      <input type="hidden" name="user[is_admin]" value="0" />
      <input type="hidden" name="user[auto_assign]" value="0" />
<?php } // if ?>
    </div>
    </fieldset>
  </div>
<?php } else { ?>
  <div>
    <?php echo label_tag(lang('username')) ?>
    <?php echo clean(array_var($user_data, 'username')) ?>
    <input type="hidden" name="user[username]" value="<?php echo clean(array_var($user_data, 'username')) ?>" />
  </div>
<?php } // if ?>


  
  <div id="<?php echo $genid ?>update_profile_phone_numbers" style="display:none">
  <fieldset>
    <legend><?php echo lang('phone numbers') ?></legend>
    
    <div>
      <?php echo label_tag(lang('office phone number'), 'profileFormOfficeNumber') ?>
      <?php echo text_field('user[office_number]', array_var($user_data, 'office_number'), array('id' => 'profileFormOfficeNumber')) ?>
    </div>
    
    <div>
      <?php echo label_tag(lang('fax number'), 'profileFormFaxNumber') ?>
      <?php echo text_field('user[fax_number]', array_var($user_data, 'fax_number'), array('id' => 'profileFormFaxNumber')) ?>
    </div>
    
    <div>
      <?php echo label_tag(lang('mobile phone number'), 'profileFormMobileNumber') ?>
      <?php echo text_field('user[mobile_number]', array_var($user_data, 'mobile_number'), array('id' => 'profileFormMobileNumber')) ?>
    </div>
    
    <div>
      <?php echo label_tag(lang('home phone number'), 'profileFormHomeNumber') ?>
      <?php echo text_field('user[home_number]', array_var($user_data, 'home_number'), array('id' => 'profileFormHomeNumber')) ?>
    </div>
    
  </fieldset>
  </div>
    
<?php if(is_array($im_types) && count($im_types)) { ?>
<div id="<?php echo $genid ?>update_profile_im" style="display:none">
  <fieldset>
    <legend><?php echo lang('instant messengers') ?></legend>
    <table class="blank">
      <tr>
        <th colspan="2"><?php echo lang('im service') ?></th>
        <th><?php echo lang('value') ?></th>
        <th><?php echo lang('primary im service') ?></th>
      </tr>
<?php foreach($im_types as $im_type) { ?>
      <tr>
        <td style="vertical-align: middle"><img src="<?php echo $im_type->getIconUrl() ?>" alt="<?php echo $im_type->getName() ?> icon" /></td>
        <td style="vertical-align: middle"><label class="checkbox" for="<?php echo 'profileFormIm' . $im_type->getId() ?>"><?php echo $im_type->getName() ?></label></td>
        <td style="vertical-align: middle"><?php echo text_field('user[im_' . $im_type->getId() . ']', array_var($user_data, 'im_' . $im_type->getId()), array('id' => 'profileFormIm' . $im_type->getId())) ?></td>
        <td style="vertical-align: middle"><?php echo radio_field('user[default_im]', array_var($user_data, 'default_im') == $im_type->getId(), array('value' => $im_type->getId())) ?></td>
      </tr>
<?php } // foreach ?>
    </table>
    <p class="desc"><?php echo lang('primary im description') ?></p>
  </fieldset>
</div>
<?php } // if ?>

  <div id="<?php echo $genid ?>update_profile_timezone" style="display:none">
  <fieldset>
  	<legend><?php echo lang('timezone')?></legend>
   	<?php echo select_timezone_widget('user[timezone]', array_var($user_data, 'timezone'), array('id' => 'profileFormTimezone', 'class' => 'title')) ?>
  </fieldset>
  </div>

  <div>
    <?php echo label_tag(lang('email address'), 'profileFormEmail', true) ?>
    <?php echo text_field('user[email]', array_var($user_data, 'email'), 
    	array('id' => 'profileFormEmail', 'tabindex' => '10', 'class' => 'long')) ?>
  </div>
  
  
  <div>
    <?php echo label_tag(lang('user title'), 'profileFormTitle') ?>
    <?php echo text_field('user[title]', array_var($user_data, 'title'), 
    	array('id' => 'profileFormTitle', 'tabindex' => '11')) ?>
  </div>
  
  <?php echo submit_button(lang('save changes'),'s',array('tabindex' => '20')) ?>

</div>
</div>
</form>

<script type="text/javascript">
	Ext.get('profileFormDisplayName').focus();
</script>