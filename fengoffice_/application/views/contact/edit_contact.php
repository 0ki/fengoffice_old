<?php
	$genid = gen_id();
if (!$contact->isNew())
{
	if($contact->canEdit(logged_user())) {
		add_page_action(lang('update picture'), $contact->getUpdatePictureUrl(), 'ico-picture');
		add_page_action(lang('assign to project'), $contact->getAssignToProjectUrl(), 'ico-workspace');
	} //if
} // if
?>

<form style='height:100%;background-color:white' class="internalForm" action="<?php echo $contact->isNew() ? $contact->getAddUrl() : $contact->getEditUrl() ?>" method="post">

<div class="contact">
<div class="coInputHeader">
	<div class="coInputHeaderUpperRow">
	<div class="coInputTitle"><table style="width:535px">
	<tr><td><?php echo $contact->isNew() ? lang('new contact') : lang('edit contact') ?>
	</td><td style="text-align:right"><?php echo submit_button($contact->isNew() ? lang('add contact') : lang('save changes'),'s',array('style'=>'margin-top:0px;margin-left:10px')) ?></td></tr></table>
	</div>
	
	</div>
	<table><tr><td>
		<div>
			<?php echo label_tag(lang('first name'), $genid . 'profileFormFirstName') ?>
			<?php echo text_field('contact[firstname]', array_var($contact_data, 'firstname'), 
				array('id' => $genid . 'profileFormFirstName', 'tabindex' => '1')) ?>
		</div>
	</td><td style="padding-left:20px">
		<div>
			<?php echo label_tag(lang('last name'), $genid . 'profileFormLastName') ?>
			<?php echo text_field('contact[lastname]', array_var($contact_data, 'lastname'), 
			array('id' => $genid . 'profileFormLastName', 'tabindex' => '2')) ?>
		</div>
	</td></tr></table>
	
	<div style="padding-top:5px">
		<?php if (isset($isAddProject) && $isAddProject) { ?>
			<a href="#" class="option" onclick="og.toggleAndBolden('<?php echo $genid ?>add_contact_role_div', this)"><?php echo lang('role') ?></a> - 
		<?php } ?>
		<a href="#" class="option" onclick="og.toggleAndBolden('<?php echo $genid ?>add_contact_work', this)"><?php echo lang('work') ?></a> - 
		<a href="#" class="option" onclick="og.toggleAndBolden('<?php echo $genid ?>add_contact_email_and_im', this)"><?php echo lang('email and instant messaging') ?></a> - 
		<a href="#" class="option" onclick="og.toggleAndBolden('<?php echo $genid ?>add_contact_home', this)"><?php echo lang('home') ?></a> - 
		<a href="#" class="option" onclick="og.toggleAndBolden('<?php echo $genid ?>add_contact_other', this)"><?php echo lang('other') ?></a> - 
		<a href="#" class="option" onclick="og.toggleAndBolden('<?php echo $genid ?>add_contact_notes', this)"><?php echo lang('notes') ?></a>
	</div>
</div>
<div class="coInputSeparator"></div>
<div class="coInputMainBlock">

	<div style="display:none" id="<?php echo $genid ?>add_contact_work">
	<fieldset><legend><?php echo lang('work') ?></legend>
		<div style="padding-left:20px">
			<div>
				<?php echo label_tag(lang('company'), $genid.'profileFormCompany') ?> 
				<?php echo select_company('contact[company_id]', array_var($contact_data, 'company_id'), array('id' => $genid.'profileFormCompany')); 
				if(owner_company()->canAddClient(logged_user())) {?>
					<a class="internalLink" target="administration" href="<?php echo get_url('company', 'add_client')?>"><?php echo lang('add client')?></a> 
	        	<?php } // if?>
			</div>
			
			<div>
				<?php echo label_tag(lang('department'), $genid.'profileFormDepartment') ?>
				<?php echo text_field('contact[department]', array_var($contact_data, 'department'), array('id' => $genid.'profileFormDepartment')) ?>
			</div>
	
			<div>
				<?php echo label_tag(lang('job title'), $genid.'profileFormJobTitle') ?>
				<?php echo text_field('contact[job_title]', array_var($contact_data, 'job_title'), array('id' => $genid.'profileFormJobTitle')) ?>
			</div>
		</div>
		<br/>
			<table  style="margin-left:20px;margin-right:20px">
		<tr>
			<td  style="padding-right:60px">
			<div><?php echo label_tag(lang('address'), $genid.'profileFormWAddress') ?> <?php echo text_field('contact[w_address]', array_var($contact_data, 'w_address'), array('id' => $genid.'profileFormWAddress')) ?>
			</div>
			<div><?php echo label_tag(lang('city'), $genid.'profileFormWCity') ?> <?php echo text_field('contact[w_city]', array_var($contact_data, 'w_city'), array('id' => $genid.'profileFormWCity')) ?>
			</div>
			<div><?php echo label_tag(lang('state'), $genid.'profileFormWState') ?> <?php echo text_field('contact[w_state]', array_var($contact_data, 'w_state'), array('id' => $genid.'profileFormWState')) ?>
			</div>
			<div><?php echo label_tag(lang('zipcode'), $genid.'profileFormWZipcode') ?> <?php echo text_field('contact[w_zipcode]', array_var($contact_data, 'w_zipcode'), array('id' => $genid.'profileFormWZipcode')) ?>
			</div>
			<div><?php echo label_tag(lang('country'), $genid.'profileFormWCountry') ?> <?php echo text_field('contact[w_country]', array_var($contact_data, 'w_country'), array('id' => $genid.'profileFormWCountry')) ?>
			</div>
			<div><?php echo label_tag(lang('website'), $genid.'profileFormWWebPage') ?> <?php echo text_field('contact[w_web_page]', array_var($contact_data, 'w_web_page'), array('id' => $genid.'profileFormWWebPage')) ?>
			</div>
			</td>
			<td>
			<div><?php echo label_tag(lang('phone number'), $genid.'profileFormWPhoneNumber') ?> <?php echo text_field('contact[w_phone_number]', array_var($contact_data, 'w_phone_number'), array('id' => $genid.'profileFormWPhoneNumber')) ?>
			</div>
			<div><?php echo label_tag(lang('phone number 2'), $genid.'profileFormWPhoneNumber2') ?> <?php echo text_field('contact[w_phone_number2]', array_var($contact_data, 'w_phone_number2'), array('id' => $genid.'profileFormWPhoneNumber2')) ?>
			</div>
			<div><?php echo label_tag(lang('fax number'), $genid.'profileFormWFaxNumber') ?> <?php echo text_field('contact[w_fax_number]', array_var($contact_data, 'w_fax_number'), array('id' => $genid.'profileFormWFaxNumber')) ?>
			</div>
			<div><?php echo label_tag(lang('assistant number'), $genid.'profileFormWAssistantNumber') ?> <?php echo text_field('contact[w_assistant_number]', array_var($contact_data, 'w_assistant_number'), array('id' => $genid.'profileFormWAssistantNumber')) ?>
			</div>
			<div><?php echo label_tag(lang('callback number'), $genid.'profileFormWCallbackNumber') ?> <?php echo text_field('contact[w_callback_number]', array_var($contact_data, 'w_callback_number'), array('id' => $genid.'profileFormWCallbackNumber')) ?>
			</div>
			</td>
		</tr>
	</table>
		</fieldset>
	</div>
	
	
	<div id="<?php echo $genid ?>add_contact_email_and_im" style="display:none">
	<fieldset>
		<legend><?php echo lang("email and instant messaging") ?></legend>
			<div>
				<?php echo label_tag(lang('email address 2'), $genid.'profileFormEmail2') ?>
				<?php echo text_field('contact[email2]', array_var($contact_data, 'email2'), array('id' => $genid.'profileFormEmail2')) ?>
			</div>
	
			<div>
				<?php echo label_tag(lang('email address 3'), $genid.'profileFormEmail3') ?>
				<?php echo text_field('contact[email3]', array_var($contact_data, 'email3'), array('id' => $genid.'profileFormEmail3')) ?>
			</div>
			
			<?php if(is_array($im_types) && count($im_types)) { ?>
			<fieldset><legend><?php echo lang('instant messengers') ?></legend>
			<table class="blank">
				<tr>
					<th colspan="2"><?php echo lang('im service') ?></th>
					<th><?php echo lang('value') ?></th>
					<th><?php echo lang('primary im service') ?></th>
				</tr>
				<?php foreach($im_types as $im_type) { ?>
				<tr>
					<td style="vertical-align: middle"><img
						src="<?php echo $im_type->getIconUrl() ?>"
						alt="<?php echo $im_type->getName() ?> icon" /></td>
					<td style="vertical-align: middle"><label class="checkbox"
						for="<?php echo 'profileFormIm' . $im_type->getId() ?>"><?php echo $im_type->getName() ?></label></td>
					<td style="vertical-align: middle"><?php echo text_field('contact[im_' . $im_type->getId() . ']', array_var($contact_data, 'im_' . $im_type->getId()), array('id' => $genid.'profileFormIm' . $im_type->getId())) ?></td>
					<td style="vertical-align: middle"><?php echo radio_field('contact[default_im]', array_var($contact_data, 'default_im') == $im_type->getId(), array('value' => $im_type->getId())) ?></td>
				</tr>
				<?php } // foreach ?>
			</table>
			<p class="desc"><?php echo lang('primary im description') ?></p>
			</fieldset>
			<?php } // if ?>
	</fieldset>
	</div>
	
	
	<div style="display:none" id="<?php echo $genid ?>add_contact_home">
	<fieldset><legend><?php echo lang('home') ?></legend>
	<table style="margin-left:20px;margin-right:20px">
		<tr>
			<td  style="padding-right:60px">
			<div><?php echo label_tag(lang('address'), $genid.'profileFormHAddress') ?> <?php echo text_field('contact[h_address]', array_var($contact_data, 'h_address'), array('id' => $genid.'profileFormHAddress')) ?>
			</div>
			<div><?php echo label_tag(lang('city'), $genid.'profileFormHCity') ?> <?php echo text_field('contact[h_city]', array_var($contact_data, 'h_city'), array('id' => $genid.'profileFormHCity')) ?>
			</div>
			<div><?php echo label_tag(lang('state'), $genid.'profileFormHState') ?> <?php echo text_field('contact[h_state]', array_var($contact_data, 'h_state'), array('id' => $genid.'profileFormHState')) ?>
			</div>
			<div><?php echo label_tag(lang('zipcode'), $genid.'profileFormHZipcode') ?> <?php echo text_field('contact[h_zipcode]', array_var($contact_data, 'h_zipcode'), array('id' => $genid.'profileFormHZipcode')) ?>
			</div>
			<div><?php echo label_tag(lang('country'), $genid.'profileFormHCountry') ?> <?php echo text_field('contact[h_country]', array_var($contact_data, 'h_country'), array('id' => $genid.'profileFormHCountry')) ?>
			</div>
			<div><?php echo label_tag(lang('website'), $genid.'profileFormHWebPage') ?> <?php echo text_field('contact[h_web_page]', array_var($contact_data, 'h_web_page'), array('id' => $genid.'profileFormHWebPage')) ?>
			</div>
			</td>
			<td>
			<div><?php echo label_tag(lang('phone number'), $genid.'profileFormHPhoneNumber') ?> <?php echo text_field('contact[h_phone_number]', array_var($contact_data, 'h_phone_number'), array('id' => $genid.'profileFormHPhoneNumber')) ?>
			</div>
			<div><?php echo label_tag(lang('phone number 2'), $genid.'profileFormHPhoneNumber2') ?> <?php echo text_field('contact[h_phone_number2]', array_var($contact_data, 'h_phone_number2'), array('id' => $genid.'profileFormHPhoneNumber2')) ?>
			</div>
			<div><?php echo label_tag(lang('fax number'), $genid.'profileFormHFaxNumber') ?> <?php echo text_field('contact[h_fax_number]', array_var($contact_data, 'h_fax_number'), array('id' => $genid.'profileFormHFaxNumber')) ?>
			</div>
			<div><?php echo label_tag(lang('mobile number'), $genid.'profileFormHMobileNumber') ?> <?php echo text_field('contact[h_mobile_number]', array_var($contact_data, 'h_mobile_number'), array('id' => $genid.'profileFormHMobileNumber')) ?>
			</div>
			<div><?php echo label_tag(lang('pager number'), $genid.'profileFormHPagerNumber') ?> <?php echo text_field('contact[h_pager_number]', array_var($contact_data, 'h_pager_number'), array('id' => $genid.'profileFormHPagerNumber')) ?>
			</div>
			</td>
		</tr>
	</table>
	</fieldset>
	</div>
	
	<div style="display:none" id="<?php echo $genid ?>add_contact_other">
	<fieldset><legend><?php echo lang('other') ?></legend>
	<table style="margin-left:20px;margin-right:20px">
		<tr>
			<td >
			<div><?php echo label_tag(lang('middle name'), $genid.'profileFormMiddleName') ?>
			<?php echo text_field('contact[middlename]', array_var($contact_data, 'middlename'), array('id' => $genid.'profileFormMiddleName')) ?>
			</div>
			<div><?php echo label_tag(lang('address'), $genid.'profileFormOAddress') ?>
			<?php echo text_field('contact[o_address]', array_var($contact_data, 'o_address'), array('id' => $genid.'profileFormOAddress')) ?>
			</div>
			<div><?php echo label_tag(lang('city'), $genid.'profileFormOCity') ?> <?php echo text_field('contact[o_city]', array_var($contact_data, 'o_city'), array('id' => $genid.'profileFormOCity')) ?>
			</div>
			<div><?php echo label_tag(lang('state'), $genid.'profileFormOState') ?> <?php echo text_field('contact[o_state]', array_var($contact_data, 'o_state'), array('id' => $genid.'profileFormOState')) ?>
			</div>
			<div><?php echo label_tag(lang('zipcode'), $genid.'profileFormOZipcode') ?>
			<?php echo text_field('contact[o_zipcode]', array_var($contact_data, 'o_zipcode'), array('id' => $genid.'profileFormOZipcode')) ?>
			</div>
			<div><?php echo label_tag(lang('country'), $genid.'profileFormOCountry') ?>
			<?php echo text_field('contact[o_country]', array_var($contact_data, 'o_country'), array('id' => $genid.'profileFormOCountry')) ?>
			</div>
			<div><?php echo label_tag(lang('website'), $genid.'profileFormOWebPage') ?>
			<?php echo text_field('contact[o_web_page]', array_var($contact_data, 'o_web_page'), array('id' => $genid.'profileFormOWebPage')) ?>
			</div>
			</td>
			<td>
			<div><?php echo label_tag(lang('phone number'), $genid.'profileFormOPhoneNumber') ?>
			<?php echo text_field('contact[o_phone_number]', array_var($contact_data, 'o_phone_number'), array('id' => $genid.'profileFormOPhoneNumber')) ?>
			</div>
			<div><?php echo label_tag(lang('phone number 2'), $genid.'profileFormOPhoneNumber2') ?>
			<?php echo text_field('contact[o_phone_number2]', array_var($contact_data, 'o_phone_number2'), array('id' => $genid.'profileFormOPhoneNumber2')) ?>
			</div>
			<div><?php echo label_tag(lang('fax number'), $genid.'profileFormOFaxNumber') ?>
			<?php echo text_field('contact[o_fax_number]', array_var($contact_data, 'o_fax_number'), array('id' => $genid.'profileFormOFaxNumber')) ?>
			</div>
			</td>
		</tr>
		<tr>
			<td><br />
			<div><?php echo label_tag(lang('birthday'), $genid.'profileFormBirthday')?> <?php echo pick_date_widget('contact[o_birthday]', array_var($contact_data, 'o_birthday'), 1902, date("Y")) ?>
			</div>
			<div><?php echo label_tag(lang('timezone'), $genid.'profileFormTimezone')?> <?php echo select_timezone_widget('contact[timezone]', array_var($contact_data, 'timezone'), array('id' => $genid.'profileFormTimezone', 'class' => 'long')) ?>
			</div>
			</td>
		</tr>
	</table>
	</fieldset>
	</div>
	
	<div style="display:none" id="<?php echo $genid ?>add_contact_notes">
	<fieldset><legend><?php echo lang('notes') ?></legend>
	    <div>
	      <?php echo label_tag(lang('notes'), $genid.'profileFormNotes') ?>
	      <?php echo textarea_field('contact[notes]', array_var($contact_data, 'notes'), array('id' => $genid.'profileFormNotes')) ?>
	    </div>
	</fieldset>
	</div>
	
	<?php if (isset($isAddProject) && $isAddProject)
	{
		?>
		<div id="<?php echo $genid ?>add_contact_role_div" style="display:none">
		<fieldset>
			<legend> <?php echo label_tag(lang('role in project', active_project()->getName()), $genid.'profileFormRole')?></legend>
			<?php echo text_field('contact[role]', array_var($contact_data, 'role'), array('class' => 'long', 'id' => $genid.'profileFormRole') ) ?>
		</fieldset>
		</div>
	<?php }?>


	<div>
		<?php echo label_tag(lang('email address'), $genid.'profileFormEmail') ?>
		<?php echo text_field('contact[email]', array_var($contact_data, 'email'), 
			array('id' => $genid.'profileFormEmail', 'tabindex' => '3')) ?>
	</div>

  	<?php echo submit_button($contact->isNew() ? lang('add contact') : lang('save changes'),'s',array('tabindex' => '4')) ?>

<script type="text/javascript">
	Ext.get('<?php echo $genid ?>profileFormFirstName').focus();
</script>
</div>
</div>
</form>