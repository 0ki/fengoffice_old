<?php 
	$project = active_or_personal_project();
	$projects =  active_projects();
	$genid = gen_id();
	if($company->isNew()) { ?>
<form style="height:100%;background-color:white" class="internalForm" action="<?php echo get_url('company', 'add_client') ?>" method="post">
<?php } else { ?>
<form style="height:100%;background-color:white" class="internalForm" action="<?php echo $company->getEditUrl() ?>" method="post">
<?php } // if ?>


<div class="adminAddCompany">
  <div class="adminHeader">
  	<div class="adminHeaderUpperRow">
  		<div class="adminTitle"><table style="width:535px"><tr><td>
  			<?php echo $company->isNew() ? lang('new company') : lang('edit company') ?>
  		</td><td style="text-align:right">
  			<?php echo submit_button($company->isNew() ? lang('add company') : lang('save changes'), 's', array('style'=>'margin-top:0px;margin-left:10px')) ?>
  		</td></tr></table></div>
  	</div>
  	
  <div>
    <?php echo label_tag(lang('name'), 'clientFormName', true) ?>
    <?php echo text_field('company[name]', array_var($company_data, 'name'), 
    	array('class' => 'title', 'tabindex' => '1', 'id' => 'clientFormName')) ?>
  </div>
  
  	<div style="padding-top:5px">
		<?php if (isset ($projects) && count($projects) > 0) { ?>
			<a href="#" class="option" tabindex=0 onclick="og.toggleAndBolden('<?php echo $genid ?>add_company_select_workspace_div',this)"><?php echo lang('workspace') ?></a> - 
		<?php } ?>
		<a href="#" class="option" tabindex=0 onclick="og.toggleAndBolden('<?php echo $genid ?>add_company_add_tags_div', this)"><?php echo lang('tags') ?></a> - 
		<a href="#" class="option" tabindex=0 onclick="og.toggleAndBolden('add_company_timezone',this)"><?php echo lang('timezone') ?></a>
	</div>
  </div>
  <div class="adminSeparator"></div>
  <div class="adminMainBlock">
  
  <table style="margin-left:12px;margin-right:12px; margin-top:12px">
		<tr>
			<td style="padding-right:30px">
			<table style="width:100%">
			<tr>
				<td class="td-pr"><?php echo label_tag(lang('address'), $genid.'profileFormWAddress') ?></td>
				<td><?php echo text_field('company[address]', array_var($company_data, 'address'), array('id' => $genid.'clientFormAddress')) ?></td>
			</tr><tr>
				<td class="td-pr"><?php echo label_tag(lang('address2'), $genid.'clientFormAddress') ?></td>
				<td><?php echo text_field('company[address2]', array_var($company_data, 'address2'), array('id' => $genid.'clientFormAddress')) ?></td>
			</tr><tr>
				<td class="td-pr"><?php echo label_tag(lang('city'), $genid.'clientFormCity') ?></td>
				<td><?php echo text_field('company[city]', array_var($company_data, 'city'), array('id' => $genid.'clientFormCity')) ?></td>
			</tr><tr>
				<td class="td-pr"><?php echo label_tag(lang('state'), $genid.'clientFormState') ?></td>
				<td><?php echo text_field('company[state]', array_var($company_data, 'state'), array('id' => $genid.'clientFormState')) ?></td>
			</tr><tr>
				<td class="td-pr"><?php echo label_tag(lang('zipcode'), $genid.'clientFormZipcode') ?></td>
				<td><?php echo text_field('company[zipcode]', array_var($company_data, 'zipcode'), array('id' => $genid.'clientFormZipcode')) ?></td>
			</tr><tr>
				<td class="td-pr"><?php echo label_tag(lang('country'), $genid.'clientFormCountry') ?></td>
				<td><?php echo select_country_widget('company[country]', array_var($company_data, 'country'), array('id' => $genid.'clientFormCountry')) ?></td>
			</tr>
			</table>
			</td><td>
			<table style="width:100%">
			<tr>
				<td class="td-pr"><?php echo label_tag(lang('phone'), $genid.'clientFormPhoneNumber') ?> </td>
				<td><?php echo text_field('company[phone_number]', array_var($company_data, 'phone_number'), array('id' => $genid.'clientFormPhoneNumber')) ?></td>
			</tr><tr>
				<td class="td-pr"><?php echo label_tag(lang('fax'), $genid.'clientFormFaxNumber') ?> </td>
				<td><?php echo text_field('company[fax_number]', array_var($company_data, 'fax_number'), array('id' => $genid.'clientFormFaxNumber')) ?></td>
			</tr><tr height=20><td></td><td></td></tr><tr>
				<td class="td-pr"><?php echo label_tag(lang('email address'), $genid.'clientFormEmail') ?> </td>
				<td><?php echo text_field('company[email]', array_var($company_data, 'email'), array('id' => $genid.'clientFormAssistantNumber')) ?></td>
			</tr><tr height=20><td></td><td></td></tr><tr>
				<td class="td-pr"><?php echo label_tag(lang('homepage'), $genid.'clientFormHomepage') ?></td>
				<td><?php echo text_field('company[homepage]', array_var($company_data, 'homepage'), array('id' => $genid.'clientFormCallbackNumber')) ?></td>
			</tr>
			</table>
			</td>
		</tr>
	</table>
	

	<?php if (isset ($projects) && count($projects) > 0) { ?>
	<div id="<?php echo $genid ?>add_company_select_workspace_div" style="display:none">
	<fieldset><legend><?php echo lang('workspace')?></legend>
		<?php if ($company->isNew()) {
			echo select_workspaces('ws_ids', $projects, array($project), $genid.'ws_ids');
		} else {
			echo select_workspaces('ws_ids', $projects, $company->getWorkspaces(), $genid.'ws_ids');
		} ?>
	</fieldset>
	</div>
	<?php } ?>
		
	<div id="<?php echo $genid ?>add_company_add_tags_div" style="display:none">
	<fieldset><legend><?php echo lang('tags')?></legend>
		<?php echo autocomplete_textfield("company[tags]", array_var($company_data, 'tags'), Tags::getTagNames(), lang("enter tags desc"), array("class" => "long")); ?>
	</fieldset>
	</div>
	
  
  

  <div id="add_company_timezone" style="display:none">
  <fieldset>
    <legend><?php echo lang('timezone') ?></legend>
    <?php echo label_tag(lang('timezone'), 'clientFormTimezone', false)?>
    <?php echo select_timezone_widget('company[timezone]', array_var($company_data, 'timezone'), array('id' => 'clientFormTimezone', 'class' => 'long')) ?>
  </fieldset>
  </div>
  
  
<?php if(!$company->isNew() && $company->isOwner()) { ?>
  <?php echo submit_button(lang('save changes'), 's', array('tabindex' => '2')) ?>
<?php } else { ?>
  <?php echo submit_button($company->isNew() ? lang('add company') : lang('save changes'), 's', array('tabindex' => '2')) ?>
<?php } // if ?>
</div>
</div>
</form>

<script type="text/javascript">
	Ext.get('clientFormName').focus();
</script>