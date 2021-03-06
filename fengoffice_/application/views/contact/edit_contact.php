<?php
if (!$contact->isNew())
{
	if($contact->canEdit(logged_user())) {
		add_page_action(lang('update picture'), $contact->getUpdatePictureUrl(), 'ico-picture');
		add_page_action(lang('assign to project'), $contact->getAssignToProjectUrl(), 'ico-workspace');
	} //if
} // if
?>

<form class="internalForm" action="<?php echo $contact->isNew() ? $contact->getAddUrl() : $contact->getEditUrl() ?>" method="post">
  <?php tpl_display(get_template_path('form_errors')) ?>

<div id="ContactTabMenu" style="width:100%;height:100%">
</div>

<div class="x-hide-display" id="ContactPersonalDiv">
<table class="blank" style="margin-left:20px;margin-right:20px">
	<tr>
		<td style="padding-right:60px">
		<div><?php echo label_tag(lang('first name'), 'profileFormFirstName') ?>
		<?php echo text_field('contact[firstname]', array_var($contact_data, 'firstname'), array('id' => 'profileFormFirstName')) ?>
		</div>
		</td>
		<td>
		<div><?php echo label_tag(lang('company'), 'profileFormCompany') ?> <?php echo select_company('contact[company_id]', array_var($contact_data, 'company_id'), array('id' => 'profileFormCompany')); 
		if(owner_company()->canAddClient(logged_user())) {
        ?><a class="internalLink" target="administration" href="<?php echo get_url('company', 'add_client')?>"><?php echo lang('add client')?></a> 
        <?php } // if?>
		</div>
		</td>
	</tr>
	<tr>
		<td>
		<div><?php echo label_tag(lang('last name'), 'profileFormLastName') ?>
		<?php echo text_field('contact[lastname]', array_var($contact_data, 'lastname'), array('id' => 'profileFormLastName')) ?>
		</div>
		</td>
		<td>
		<div><?php echo label_tag(lang('department'), 'profileFormDepartment') ?>
		<?php echo text_field('contact[department]', array_var($contact_data, 'department'), array('id' => 'profileFormDepartment')) ?>
		</div>
		</td>
	</tr>
	<tr>
		<td>
		<div><?php echo label_tag(lang('middle name'), 'profileFormMiddleName') ?>
		<?php echo text_field('contact[middlename]', array_var($contact_data, 'middlename'), array('id' => 'profileFormMiddleName')) ?>
		</div>
		</td>
		<td>
		<div><?php echo label_tag(lang('job title'), 'profileFormJobTitle') ?>
		<?php echo text_field('contact[job_title]', array_var($contact_data, 'job_title'), array('id' => 'profileFormJobTitle')) ?>
		</div>
		</td>
	</tr>
	<tr>
		<td colspan=2>
		<br/>
		<br/>
		<h2><?php echo label_tag(lang('email and instant messaging'), 'profileFormEmailIM') ?></h2>
		</td>
	</tr>
	<tr>
		<td style="text-align:top">

		<div><?php echo label_tag(lang('email address'), 'profileFormEmail') ?>
		<?php echo text_field('contact[email]', array_var($contact_data, 'email'), array('id' => 'profileFormEmail')) ?>
		</div>

		<div><?php echo label_tag(lang('email address 2'), 'profileFormEmail2') ?>
		<?php echo text_field('contact[email2]', array_var($contact_data, 'email2'), array('id' => 'profileFormEmail2')) ?>
		</div>

		<div><?php echo label_tag(lang('email address 3'), 'profileFormEmail3') ?>
		<?php echo text_field('contact[email3]', array_var($contact_data, 'email3'), array('id' => 'profileFormEmail3')) ?>
		</div>
		</td>
		<td style="text-align:top">
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
				<td style="vertical-align: middle"><?php echo text_field('contact[im_' . $im_type->getId() . ']', array_var($contact_data, 'im_' . $im_type->getId()), array('id' => 'profileFormIm' . $im_type->getId())) ?></td>
				<td style="vertical-align: middle"><?php echo radio_field('contact[default_im]', array_var($contact_data, 'default_im') == $im_type->getId(), array('value' => $im_type->getId())) ?></td>
			</tr>
			<?php } // foreach ?>
		</table>
		<p class="desc"><?php echo lang('primary im description') ?></p>
		</fieldset>
		<?php } // if ?>
		</td>
	</tr>
</table>


</div>

<div class="x-hide-display" id="ContactWorkDiv">
<table  style="margin-left:20px;margin-right:20px">
	<tr>
		<td  style="padding-right:60px">
		<div><?php echo label_tag(lang('address'), 'profileFormWAddress') ?> <?php echo text_field('contact[w_address]', array_var($contact_data, 'w_address'), array('id' => 'profileFormWAddress')) ?>
		</div>
		<div><?php echo label_tag(lang('city'), 'profileFormWCity') ?> <?php echo text_field('contact[w_city]', array_var($contact_data, 'w_city'), array('id' => 'profileFormWCity')) ?>
		</div>
		<div><?php echo label_tag(lang('state'), 'profileFormWState') ?> <?php echo text_field('contact[w_state]', array_var($contact_data, 'w_state'), array('id' => 'profileFormWState')) ?>
		</div>
		<div><?php echo label_tag(lang('zipcode'), 'profileFormWZipcode') ?> <?php echo text_field('contact[w_zipcode]', array_var($contact_data, 'w_zipcode'), array('id' => 'profileFormWZipcode')) ?>
		</div>
		<div><?php echo label_tag(lang('country'), 'profileFormWCountry') ?> <?php echo text_field('contact[w_country]', array_var($contact_data, 'w_country'), array('id' => 'profileFormWCountry')) ?>
		</div>
		<div><?php echo label_tag(lang('website'), 'profileFormWWebPage') ?> <?php echo text_field('contact[w_web_page]', array_var($contact_data, 'w_web_page'), array('id' => 'profileFormWWebPage')) ?>
		</div>
		</td>
		<td>
		<div><?php echo label_tag(lang('phone number'), 'profileFormWPhoneNumber') ?> <?php echo text_field('contact[w_phone_number]', array_var($contact_data, 'w_phone_number'), array('id' => 'profileFormWPhoneNumber')) ?>
		</div>
		<div><?php echo label_tag(lang('phone number 2'), 'profileFormWPhoneNumber2') ?> <?php echo text_field('contact[w_phone_number2]', array_var($contact_data, 'w_phone_number2'), array('id' => 'profileFormWPhoneNumber2')) ?>
		</div>
		<div><?php echo label_tag(lang('fax number'), 'profileFormWFaxNumber') ?> <?php echo text_field('contact[w_fax_number]', array_var($contact_data, 'w_fax_number'), array('id' => 'profileFormWFaxNumber')) ?>
		</div>
		<div><?php echo label_tag(lang('assistant number'), 'profileFormWAssistantNumber') ?> <?php echo text_field('contact[w_assistant_number]', array_var($contact_data, 'w_assistant_number'), array('id' => 'profileFormWAssistantNumber')) ?>
		</div>
		<div><?php echo label_tag(lang('callback number'), 'profileFormWCallbackNumber') ?> <?php echo text_field('contact[w_callback_number]', array_var($contact_data, 'w_callback_number'), array('id' => 'profileFormWCallbackNumber')) ?>
		</div>
		</td>
	</tr>
</table>
</div>

<div class="x-hide-display" id="ContactHomeDiv">
<table style="margin-left:20px;margin-right:20px">
	<tr>
		<td  style="padding-right:60px">
		<div><?php echo label_tag(lang('address'), 'profileFormHAddress') ?> <?php echo text_field('contact[h_address]', array_var($contact_data, 'h_address'), array('id' => 'profileFormHAddress')) ?>
		</div>
		<div><?php echo label_tag(lang('city'), 'profileFormHCity') ?> <?php echo text_field('contact[h_city]', array_var($contact_data, 'h_city'), array('id' => 'profileFormHCity')) ?>
		</div>
		<div><?php echo label_tag(lang('state'), 'profileFormHState') ?> <?php echo text_field('contact[h_state]', array_var($contact_data, 'h_state'), array('id' => 'profileFormHState')) ?>
		</div>
		<div><?php echo label_tag(lang('zipcode'), 'profileFormHZipcode') ?> <?php echo text_field('contact[h_zipcode]', array_var($contact_data, 'h_zipcode'), array('id' => 'profileFormHZipcode')) ?>
		</div>
		<div><?php echo label_tag(lang('country'), 'profileFormHCountry') ?> <?php echo text_field('contact[h_country]', array_var($contact_data, 'h_country'), array('id' => 'profileFormHCountry')) ?>
		</div>
		<div><?php echo label_tag(lang('website'), 'profileFormHWebPage') ?> <?php echo text_field('contact[h_web_page]', array_var($contact_data, 'h_web_page'), array('id' => 'profileFormHWebPage')) ?>
		</div>
		</td>
		<td>
		<div><?php echo label_tag(lang('phone number'), 'profileFormHPhoneNumber') ?> <?php echo text_field('contact[h_phone_number]', array_var($contact_data, 'h_phone_number'), array('id' => 'profileFormHPhoneNumber')) ?>
		</div>
		<div><?php echo label_tag(lang('phone number 2'), 'profileFormHPhoneNumber2') ?> <?php echo text_field('contact[h_phone_number2]', array_var($contact_data, 'h_phone_number2'), array('id' => 'profileFormHPhoneNumber2')) ?>
		</div>
		<div><?php echo label_tag(lang('fax number'), 'profileFormHFaxNumber') ?> <?php echo text_field('contact[h_fax_number]', array_var($contact_data, 'h_fax_number'), array('id' => 'profileFormHFaxNumber')) ?>
		</div>
		<div><?php echo label_tag(lang('mobile number'), 'profileFormHMobileNumber') ?> <?php echo text_field('contact[h_mobile_number]', array_var($contact_data, 'h_mobile_number'), array('id' => 'profileFormHMobileNumber')) ?>
		</div>
		<div><?php echo label_tag(lang('pager number'), 'profileFormHPagerNumber') ?> <?php echo text_field('contact[h_pager_number]', array_var($contact_data, 'h_pager_number'), array('id' => 'profileFormHPagerNumber')) ?>
		</div>
		</td>
	</tr>
</table>
</div>

<div class="x-hide-display" id="ContactOtherDiv">
<table style="margin-left:20px;margin-right:20px">
	<tr>
		<td >
		<div><?php echo label_tag(lang('address'), 'profileFormOAddress') ?>
		<?php echo text_field('contact[o_address]', array_var($contact_data, 'o_address'), array('id' => 'profileFormOAddress')) ?>
		</div>
		<div><?php echo label_tag(lang('city'), 'profileFormOCity') ?> <?php echo text_field('contact[o_city]', array_var($contact_data, 'o_city'), array('id' => 'profileFormOCity')) ?>
		</div>
		<div><?php echo label_tag(lang('state'), 'profileFormOState') ?> <?php echo text_field('contact[o_state]', array_var($contact_data, 'o_state'), array('id' => 'profileFormOState')) ?>
		</div>
		<div><?php echo label_tag(lang('zipcode'), 'profileFormOZipcode') ?>
		<?php echo text_field('contact[o_zipcode]', array_var($contact_data, 'o_zipcode'), array('id' => 'profileFormOZipcode')) ?>
		</div>
		<div><?php echo label_tag(lang('country'), 'profileFormOCountry') ?>
		<?php echo text_field('contact[o_country]', array_var($contact_data, 'o_country'), array('id' => 'profileFormOCountry')) ?>
		</div>
		<div><?php echo label_tag(lang('website'), 'profileFormOWebPage') ?>
		<?php echo text_field('contact[o_web_page]', array_var($contact_data, 'o_web_page'), array('id' => 'profileFormOWebPage')) ?>
		</div>
		</td>
		<td>
		<div><?php echo label_tag(lang('phone number'), 'profileFormOPhoneNumber') ?>
		<?php echo text_field('contact[o_phone_number]', array_var($contact_data, 'o_phone_number'), array('id' => 'profileFormOPhoneNumber')) ?>
		</div>
		<div><?php echo label_tag(lang('phone number 2'), 'profileFormOPhoneNumber2') ?>
		<?php echo text_field('contact[o_phone_number2]', array_var($contact_data, 'o_phone_number2'), array('id' => 'profileFormOPhoneNumber2')) ?>
		</div>
		<div><?php echo label_tag(lang('fax number'), 'profileFormOFaxNumber') ?>
		<?php echo text_field('contact[o_fax_number]', array_var($contact_data, 'o_fax_number'), array('id' => 'profileFormOFaxNumber')) ?>
		</div>
		</td>
	</tr>
	<tr>
		<td><br />
		<div><?php echo label_tag(lang('birthday'), 'profileFormBirthday')?> <?php echo pick_date_widget('contact[o_birthday]', array_var($contact_data, 'o_birthday'), 1902, date("Y")) ?>
		</div>
		<div><?php echo label_tag(lang('timezone'), 'profileFormTimezone')?> <?php echo select_timezone_widget('contact[timezone]', array_var($contact_data, 'timezone'), array('id' => 'profileFormTimezone', 'class' => 'long')) ?>
		</div>
		</td>
	</tr>
</table>
</div>

<div class="x-hide-display" id="ContactNotesDiv">
<table  style="margin-left:20px;margin-right:20px">
<tr><td>
    <div>
      <?php echo label_tag(lang('notes'), 'profileFormNotes') ?>
      <?php echo textarea_field('contact[notes]', array_var($contact_data, 'notes'), array('id' => 'profileFormNotes')) ?>
    </div>
    </td></tr></table>
</div>

<?php if (isset($isAddProject) && $isAddProject)
{
	?>
	<fieldset>
	 <legend> <?php echo label_tag(lang('role in project', active_project()->getName()), 'profileFormRole')?></legend>
	<div >
		<?php echo text_field('contact[role]', array_var($contact_data, 'role'), array('class' => 'long', 'id' => 'profileFormRole') ) ?>
	</div>
	</fieldset>
<?php }?>

<script type="text/javascript">

	// second tabs built from JS
	    var editContactTabPanelExt = new Ext.TabPanel({
	        renderTo: 'ContactTabMenu',
	        activeTab: 0,
	        plain:true,
	        defaults:{autoScroll: true},
	        items:[{
	                title: 'Personal',
	                contentEl: 'ContactPersonalDiv'
	            },{
	                title: 'Work',
	                contentEl: 'ContactWorkDiv'
	            },{
	                title: 'Home',
	                contentEl: 'ContactHomeDiv'
	            },{
	                title: 'Other',
	                contentEl: 'ContactOtherDiv'
	            },{
	                title: 'Notes',
	                contentEl: 'ContactNotesDiv'
	            }
	        ]
	    });
</script>

  <?php echo submit_button($contact->isNew() ? lang('add contact') : lang('update contact')) ?>
</form>


  