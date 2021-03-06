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

<input id="<?php echo $genid ?>hfIsNewCompany" type="hidden" name="contact[isNewCompany]" value=""/>

<div class="contact">
<div class="coInputHeader">
	<div class="coInputHeaderUpperRow">
	<div class="coInputTitle"><table style="width:535px">
	<tr><td><?php echo $contact->isNew() ? lang('new contact') : lang('edit contact') ?>
	</td><td style="text-align:right"><?php echo submit_button($contact->isNew() ? lang('add contact') : lang('save changes'),'s',array('style'=>'margin-top:0px;margin-left:10px', 'id' => $genid . 'submit1')) ?></td></tr></table>
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
		<a href="#" class="option" style="font-weight:bold" onclick="og.toggleAndBolden('<?php echo $genid ?>add_contact_work', this)"><?php echo lang('work') ?></a> - 
		<a href="#" class="option" onclick="og.toggleAndBolden('<?php echo $genid ?>add_contact_email_and_im', this)"><?php echo lang('email and instant messaging') ?></a> - 
		<a href="#" class="option" onclick="og.toggleAndBolden('<?php echo $genid ?>add_contact_home', this)"><?php echo lang('home') ?></a> - 
		<a href="#" class="option" onclick="og.toggleAndBolden('<?php echo $genid ?>add_contact_other', this)"><?php echo lang('other') ?></a> - 
		<a href="#" class="option" onclick="og.toggleAndBolden('<?php echo $genid ?>add_contact_notes', this)"><?php echo lang('notes') ?></a>
		<?php if($contact->isNew() || $contact->canLinkObject(logged_user())) { ?>
			- <a href="#" class="option" onclick="og.toggleAndBolden('<?php echo $genid ?>edit_contact_linked_objects_div', this)"><?php echo lang('linked objects') ?></a>
		<?php } //	if($contact->isNew() || $contact->canLinkObject(logged_user())) ?>
	</div>
</div>
<div class="coInputSeparator"></div>
<div class="coInputMainBlock">

	<div style="display:block" id="<?php echo $genid ?>add_contact_work">
	<fieldset><legend><?php echo lang('work') ?></legend>
		<div style="margin-left:12px;margin-right:12px;">
			<div>
				<?php echo label_tag(lang('company'), $genid.'profileFormCompany') ?> 
				<div id="<?php echo $genid ?>existing_company"><?php echo select_company('contact[company_id]', array_var($contact_data, 'company_id'), array('id' => $genid.'profileFormCompany', "class" => "og-edit-contact-select-company", 'onchange' => 'og.companySelectedIndexChanged(\''.$genid . '\')')); 
				?><a href="#" class="coViewAction ico-add" title="<?php echo lang('add a new company')?>" onclick="og.addNewCompany('<?php echo $genid ?>')"><?php echo lang('add company') . '...' ?></a></div>
				<div id="<?php echo $genid?>new_company" style="display:none; padding:6px; margin-top:6px;margin-bottom:6px; background-color:#EEE">
					<?php echo label_tag(lang('new company name'), $genid.'profileFormNewCompanyName') ?>
					<table width=100%><tr><td><?php echo text_field('company[name]', '', array('id' => $genid.'profileFormNewCompanyName', 'onchange' => 'og.checkNewCompanyName("'.$genid .'")')) ?></td>
					<td style="text-align:right;vertical-align:bottom"><a href="#" title="<?php echo lang('cancel')?>" onclick="og.addNewCompany('<?php echo $genid ?>')"><?php echo lang('cancel') ?></a></td></tr></table>
					<div id="<?php echo $genid ?>duplicateCompanyName" style="display:none"></div>
					<div id="<?php echo $genid ?>companyInfo" style="display:block">
						<table style="margin-top:12px">
						<tr>
						<td style="padding-right:30px">
							<table style="width:100%">
							<tr>
								<td class="td-pr"><?php echo label_tag(lang('address'), $genid.'profileFormWAddress') ?></td>
								<td><?php echo text_field('company[address]', '', array('id' => $genid.'clientFormAddress')) ?></td>
							</tr><tr>
								<td class="td-pr"><?php echo label_tag(lang('address2'), $genid.'clientFormAddress') ?></td>
								<td><?php echo text_field('company[address2]', '', array('id' => $genid.'clientFormAddress')) ?></td>
							</tr><tr>
								<td class="td-pr"><?php echo label_tag(lang('city'), $genid.'clientFormCity') ?></td>
								<td><?php echo text_field('company[city]', '', array('id' => $genid.'clientFormCity')) ?></td>
							</tr><tr>
								<td class="td-pr"><?php echo label_tag(lang('state'), $genid.'clientFormState') ?></td>
								<td><?php echo text_field('company[state]', '', array('id' => $genid.'clientFormState')) ?></td>
							</tr><tr>
								<td class="td-pr"><?php echo label_tag(lang('zipcode'), $genid.'clientFormZipcode') ?></td>
								<td><?php echo text_field('company[zipcode]', '', array('id' => $genid.'clientFormZipcode')) ?></td>
							</tr><tr>
								<td class="td-pr"><?php echo label_tag(lang('country'), $genid.'clientFormCountry') ?></td>
								<td><?php echo select_country_widget('company[country]', '', array('id' => $genid.'clientFormCountry')) ?></td>
							</tr><tr>
								<td class="td-pr"><?php echo label_tag(lang('website'), $genid.'clientFormWebPage') ?></td>
								<td><?php echo text_field('company[w_web_page]', '', array('id' => $genid.'clientFormWebPage')) ?></td>
							</tr>
							</table>
						</td><td>
							<table style="width:100%">
							<tr>
								<td class="td-pr"><?php echo label_tag(lang('phone'), $genid.'clientFormPhoneNumber') ?> </td>
								<td><?php echo text_field('company[phone_number]', '', array('id' => $genid.'clientFormPhoneNumber')) ?></td>
							</tr><tr>
								<td class="td-pr"><?php echo label_tag(lang('fax'), $genid.'clientFormFaxNumber') ?> </td>
								<td><?php echo text_field('company[fax_number]', '', array('id' => $genid.'clientFormFaxNumber')) ?></td>
							</tr><tr height=20><td></td><td></td></tr><tr>
								<td class="td-pr"><?php echo label_tag(lang('email address'), $genid.'clientFormEmail') ?> </td>
								<td><?php echo text_field('company[email]', '', array('id' => $genid.'clientFormAssistantNumber')) ?></td>
							</tr><tr height=20><td></td><td></td></tr><tr>
								<td class="td-pr"><?php echo label_tag(lang('homepage'), $genid.'clientFormHomepage') ?></td>
								<td><?php echo text_field('company[homepage]', '', array('id' => $genid.'clientFormCallbackNumber')) ?></td>
							</tr>
							</table>
							</td>
						</tr>
						</table>
					</div>
				</div>
			</div>
	
		<table style=" margin-top:12px">
			<tr>
				<td style="padding-right:30px">
				<table style="width:100%">
				<tr>
					<td class="td-pr"><?php echo label_tag(lang('department'), $genid.'profileFormDepartment') ?></td>
					<td><?php echo text_field('contact[department]', array_var($contact_data, 'department'), array('id' => $genid.'profileFormDepartment')) ?></td>
				</tr><tr height=20><td></td><td></td></tr>
				<tr>
					<td class="td-pr"><?php echo label_tag(lang('address'), $genid.'profileFormWAddress') ?></td>
					<td><?php echo text_field('contact[w_address]', array_var($contact_data, 'w_address'), array('id' => $genid.'profileFormWAddress')) ?></td>
				</tr><tr>
					<td class="td-pr"><?php echo label_tag(lang('city'), $genid.'profileFormWCity') ?></td>
					<td><?php echo text_field('contact[w_city]', array_var($contact_data, 'w_city'), array('id' => $genid.'profileFormWCity')) ?></td>
				</tr><tr>
					<td class="td-pr"><?php echo label_tag(lang('state'), $genid.'profileFormWState') ?></td>
					<td><?php echo text_field('contact[w_state]', array_var($contact_data, 'w_state'), array('id' => $genid.'profileFormWState')) ?></td>
				</tr><tr>
					<td class="td-pr"><?php echo label_tag(lang('zipcode'), $genid.'profileFormWZipcode') ?></td>
					<td><?php echo text_field('contact[w_zipcode]', array_var($contact_data, 'w_zipcode'), array('id' => $genid.'profileFormWZipcode')) ?></td>
				</tr><tr>
					<td class="td-pr"><?php echo label_tag(lang('country'), $genid.'profileFormWCountry') ?></td>
					<td><?php echo select_country_widget('contact[w_country]', array_var($contact_data, 'w_country'), array('id' => $genid.'profileFormWCountry')) ?></td>
				</tr><tr>
					<td class="td-pr"><?php echo label_tag(lang('website'), $genid.'profileFormWWebPage') ?></td>
					<td><?php echo text_field('contact[w_web_page]', array_var($contact_data, 'w_web_page'), array('id' => $genid.'profileFormWWebPage')) ?></td>
				</tr>
				</table>
				</td><td>
				<table style="width:100%">
				<tr>
					<td class="td-pr"><?php echo label_tag(lang('job title'), $genid.'profileFormJobTitle') ?></td>
					<td><?php echo text_field('contact[job_title]', array_var($contact_data, 'job_title'), array('id' => $genid.'profileFormJobTitle')) ?></td>
				</tr><tr height=20><td></td><td></td></tr>
				<tr>
					<td class="td-pr"><?php echo label_tag(lang('phone'), $genid.'profileFormWPhoneNumber') ?> </td>
					<td><?php echo text_field('contact[w_phone_number]', array_var($contact_data, 'w_phone_number'), array('id' => $genid.'profileFormWPhoneNumber')) ?></td>
				</tr><tr>
					<td class="td-pr"><?php echo label_tag(lang('phone 2'), $genid.'profileFormWPhoneNumber2') ?> </td>
					<td><?php echo text_field('contact[w_phone_number2]', array_var($contact_data, 'w_phone_number2'), array('id' => $genid.'profileFormWPhoneNumber2')) ?></td>
				</tr><tr>
					<td class="td-pr"><?php echo label_tag(lang('fax'), $genid.'profileFormWFaxNumber') ?> </td>
					<td><?php echo text_field('contact[w_fax_number]', array_var($contact_data, 'w_fax_number'), array('id' => $genid.'profileFormWFaxNumber')) ?></td>
				</tr><tr>
					<td class="td-pr"><?php echo label_tag(lang('assistant'), $genid.'profileFormWAssistantNumber') ?> </td>
					<td><?php echo text_field('contact[w_assistant_number]', array_var($contact_data, 'w_assistant_number'), array('id' => $genid.'profileFormWAssistantNumber')) ?></td>
				</tr><tr>
					<td class="td-pr"><?php echo label_tag(lang('callback'), $genid.'profileFormWCallbackNumber') ?></td>
					<td><?php echo text_field('contact[w_callback_number]', array_var($contact_data, 'w_callback_number'), array('id' => $genid.'profileFormWCallbackNumber')) ?></td>
				</tr>
				</table>
				</td>
			</tr>
		</table>
		</div>
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
			<td  style="padding-right:30px">
			<table><tr>
				<td class="td-pr"><?php echo label_tag(lang('address'), $genid.'profileFormHAddress') ?></td>
				<td><?php echo text_field('contact[h_address]', array_var($contact_data, 'h_address'), array('id' => $genid.'profileFormHAddress')) ?></td>
			</tr><tr>
				<td class="td-pr"><?php echo label_tag(lang('city'), $genid.'profileFormHCity') ?> </td>
				<td><?php echo text_field('contact[h_city]', array_var($contact_data, 'h_city'), array('id' => $genid.'profileFormHCity')) ?></td>
			</tr><tr>
				<td class="td-pr"><?php echo label_tag(lang('state'), $genid.'profileFormHState') ?></td>
				<td><?php echo text_field('contact[h_state]', array_var($contact_data, 'h_state'), array('id' => $genid.'profileFormHState')) ?></td>
			</tr><tr>
				<td class="td-pr"><?php echo label_tag(lang('zipcode'), $genid.'profileFormHZipcode') ?></td>
				<td><?php echo text_field('contact[h_zipcode]', array_var($contact_data, 'h_zipcode'), array('id' => $genid.'profileFormHZipcode')) ?></td>
			</tr><tr>
				<td class="td-pr"><?php echo label_tag(lang('country'), $genid.'profileFormHCountry') ?></td>
				<td><?php echo select_country_widget('contact[h_country]', array_var($contact_data, 'h_country'), array('id' => $genid.'profileFormHCountry')) ?></td>
			</tr><tr>
				<td class="td-pr"><?php echo label_tag(lang('website'), $genid.'profileFormHWebPage') ?></td>
				<td><?php echo text_field('contact[h_web_page]', array_var($contact_data, 'h_web_page'), array('id' => $genid.'profileFormHWebPage')) ?></td>
			</tr>
			</table>
			</td>
			<td>
			<table><tr>
				<td class="td-pr"><?php echo label_tag(lang('phone'), $genid.'profileFormHPhoneNumber') ?></td>
				<td><?php echo text_field('contact[h_phone_number]', array_var($contact_data, 'h_phone_number'), array('id' => $genid.'profileFormHPhoneNumber')) ?></td>
			</tr><tr>
				<td class="td-pr"><?php echo label_tag(lang('phone 2'), $genid.'profileFormHPhoneNumber2') ?></td>
				<td><?php echo text_field('contact[h_phone_number2]', array_var($contact_data, 'h_phone_number2'), array('id' => $genid.'profileFormHPhoneNumber2')) ?></td>
			</tr><tr>
				<td class="td-pr"><?php echo label_tag(lang('fax'), $genid.'profileFormHFaxNumber') ?></td>
				<td><?php echo text_field('contact[h_fax_number]', array_var($contact_data, 'h_fax_number'), array('id' => $genid.'profileFormHFaxNumber')) ?></td>
			</tr><tr>
				<td class="td-pr"><?php echo label_tag(lang('mobile'), $genid.'profileFormHMobileNumber') ?></td>
				<td><?php echo text_field('contact[h_mobile_number]', array_var($contact_data, 'h_mobile_number'), array('id' => $genid.'profileFormHMobileNumber')) ?></td>
			</tr><tr>
				<td class="td-pr"><?php echo label_tag(lang('pager'), $genid.'profileFormHPagerNumber') ?></td>
				<td><?php echo text_field('contact[h_pager_number]', array_var($contact_data, 'h_pager_number'), array('id' => $genid.'profileFormHPagerNumber')) ?></td>
			</tr>
			</table>
			</td>
		</tr>
	</table>
	</fieldset>
	</div>
	
	<div style="display:none" id="<?php echo $genid ?>add_contact_other">
	<fieldset><legend><?php echo lang('other') ?></legend>
	<table style="margin-left:20px;margin-right:20px">
		<tr>
			<td style="padding-right:30px">
			<table><tr>
				<td><?php echo label_tag(lang('middle name'), $genid.'profileFormMiddleName') ?></td>
				<td><?php echo text_field('contact[middlename]', array_var($contact_data, 'middlename'), array('id' => $genid.'profileFormMiddleName')) ?></td>
			</tr><tr>
				<td class="td-pr"><?php echo label_tag(lang('address'), $genid.'profileFormOAddress') ?></td>
				<td><?php echo text_field('contact[o_address]', array_var($contact_data, 'o_address'), array('id' => $genid.'profileFormOAddress')) ?></td>
			</tr><tr>
				<td class="td-pr"><?php echo label_tag(lang('city'), $genid.'profileFormOCity') ?> </td>
				<td><?php echo text_field('contact[o_city]', array_var($contact_data, 'o_city'), array('id' => $genid.'profileFormOCity')) ?></td>
			</tr><tr>
				<td class="td-pr"><?php echo label_tag(lang('state'), $genid.'profileFormOState') ?></td>
				<td><?php echo text_field('contact[o_state]', array_var($contact_data, 'o_state'), array('id' => $genid.'profileFormOState')) ?></td>
			</tr><tr>
				<td class="td-pr"><?php echo label_tag(lang('zipcode'), $genid.'profileFormOZipcode') ?></td>
				<td><?php echo text_field('contact[o_zipcode]', array_var($contact_data, 'o_zipcode'), array('id' => $genid.'profileFormOZipcode')) ?></td>
			</tr><tr>
				<td class="td-pr"><?php echo label_tag(lang('country'), $genid.'profileFormOCountry') ?></td>
				<td><?php echo select_country_widget('contact[o_country]', array_var($contact_data, 'o_country'), array('id' => $genid.'profileFormOCountry')) ?></td>
			</tr><tr>
				<td class="td-pr"><?php echo label_tag(lang('website'), $genid.'profileFormOWebPage') ?></td>
				<td><?php echo text_field('contact[o_web_page]', array_var($contact_data, 'o_web_page'), array('id' => $genid.'profileFormOWebPage')) ?></td>
			</tr>
			</table>
			</td>
			<td>
			<table><tr>
				<td><?php echo label_tag(lang('phone number'), $genid.'profileFormOPhoneNumber') ?></td>
				<td><?php echo text_field('contact[o_phone_number]', array_var($contact_data, 'o_phone_number'), array('id' => $genid.'profileFormOPhoneNumber')) ?></td>
			</tr><tr>
				<td class="td-pr"><?php echo label_tag(lang('phone number 2'), $genid.'profileFormOPhoneNumber2') ?></td>
				<td><?php echo text_field('contact[o_phone_number2]', array_var($contact_data, 'o_phone_number2'), array('id' => $genid.'profileFormOPhoneNumber2')) ?></td>
			</tr><tr>
				<td class="td-pr"><?php echo label_tag(lang('fax number'), $genid.'profileFormOFaxNumber') ?></td>
				<td><?php echo text_field('contact[o_fax_number]', array_var($contact_data, 'o_fax_number'), array('id' => $genid.'profileFormOFaxNumber')) ?></td>
			</tr>
			</table>
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
	
		<?php if($contact->isNew() || $contact->canLinkObject(logged_user())) { ?>
	<div style="display:none" id="<?php echo $genid ?>edit_contact_linked_objects_div">
	<fieldset>
		<legend><?php echo lang('linked objects') ?></legend>
	  	  <table style="width:100%;margin-left:2px;margin-right:3px" id="tbl_linked_objects">
	   	<tbody></tbody>
		</table>
		<?php echo render_object_links($contact, $contact->canEdit(logged_user())) ?>
	</fieldset>	
	</div>
	<?php } // if ?>
	
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

  	<?php echo submit_button($contact->isNew() ? lang('add contact') : lang('save changes'),'s',array('tabindex' => '4', 'id' => $genid . 'submit2')) ?>

<script type="text/javascript">
	Ext.get('<?php echo $genid ?>profileFormFirstName').focus();
</script>
</div>
</div>
</form>