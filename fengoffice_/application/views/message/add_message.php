<?php 
	$project = active_or_personal_project();
	$projects =  active_projects();
	$genid = gen_id();
?>
<form style='height:100%;background-color:white' class="internalForm" action="<?php echo $message->isNew() ? get_url('message', 'add') : $message->getEditUrl() ?>" method="post" enctype="multipart/form-data">

<div class="message">
<div class="coInputHeader">
<div class="coInputHeaderUpperRow">
	<div class="coInputTitle"><table style="width:535px"><tr><td><?php echo $message->isNew() ? lang('new message') : lang('edit message') ?>
	</td><td style="text-align:right"><?php echo submit_button($message->isNew() ? lang('add message') : lang('save changes'),'s',array('style'=>'margin-top:0px;margin-left:10px')) ?></td></tr></table>
	</div>
	
	</div>
	<div>
	<?php echo label_tag(lang('title'), $genid . 'messageFormTitle', true) ?>
	<?php echo text_field('message[title]', array_var($message_data, 'title'), 
		array('id' => $genid . 'messageFormTitle', 'class' => 'title', 'tabindex' => '1')) ?>
	</div>
	
	<div style="padding-top:5px">
		<?php if (isset ($projects) && count($projects) > 0) { ?>
			<a href="#" class="option" onclick="og.toggleAndBolden('<?php echo $genid ?>add_message_select_workspace_div',this)"><?php echo lang('workspace') ?></a> - 
		<?php } ?>
		<a href="#" class="option" onclick="og.toggleAndBolden('<?php echo $genid ?>add_message_add_tags_div', this)"><?php echo lang('tags') ?></a> - 
		<a href="#" class="option" onclick="og.toggleAndBolden('<?php echo $genid ?>add_message_options_div',this)"><?php echo lang('options') ?></a>
		<?php if($message->isNew() && $project instanceof Project) { ?> - 
			<a href="#" class="option" onclick="og.toggleAndBolden('<?php echo $genid ?>add_message_mail_notif_div',this)"><?php echo lang('email notification') ?></a>
		<?php } ?> - 
		<a href="#" class="option" onclick="og.toggleAndBolden('<?php echo $genid ?>add_message_properties_div',this)"><?php echo lang('properties') ?></a>
		<?php if($message->isNew() || $message->canLinkObject(logged_user(), $project)) { ?> - 
			<a href="#" class="option" onclick="og.toggleAndBolden('<?php echo $genid ?>add_message_linked_objects_div',this)"><?php echo lang('linked objects') ?></a>
		<?php } ?>
	</div>
</div>
<div class="coInputSeparator"></div>
<div class="coInputMainBlock">
	<?php if (isset ($projects) && count($projects) > 0) { ?>
	<div id="<?php echo $genid ?>add_message_select_workspace_div" style="display:none">
	<fieldset><legend><?php echo lang('workspace')?></legend>
		<?php if ($message->isNew()) {
			echo select_workspaces('ws_ids', $projects, array($project), $genid.'ws_ids');
		} else {
			echo select_workspaces('ws_ids', $projects, $message->getWorkspaces(), $genid.'ws_ids');
		} ?>
	</fieldset>
	</div>
	<?php } ?>
	
	<div id="<?php echo $genid ?>add_message_add_tags_div" style="display:none">
	<fieldset><legend><?php echo lang('tags')?></legend>
		<?php echo autocomplete_textfield("message[tags]", array_var($message_data, 'tags'), Tags::getTagNames(), lang("enter tags desc"), array("class" => "long")); ?>
	</fieldset>
	</div>

	<?php if(logged_user()->isMemberOfOwnerCompany()) { ?>
	<div id="<?php echo $genid ?>add_message_options_div" style="display:none">
	<fieldset>
	<legend><?php echo lang('options') ?></legend>
	    <div class="objectOption">
			<div class="optionLabel"><label><?php echo lang('private message') ?>:</label></div>
			<div class="optionControl"><?php echo yes_no_widget('message[is_private]', $genid.'messageFormIsPrivate', array_var($message_data, 'is_private'), lang('yes'), lang('no')) ?></div>
			<div class="optionDesc"><?php echo lang('private message desc') ?></div>
		</div>
		
		<div class="objectOption">
			<div class="optionLabel"><label><?php echo lang('important message')?>:</label></div>
			<div class="optionControl"><?php echo yes_no_widget('message[is_important]', $genid.'messageFormIsImportant', array_var($message_data, 'is_important'), lang('yes'), lang('no')) ?></div>
			<div class="optionDesc"><?php echo lang('important message desc') ?></div>
		</div>

		<div class="objectOption">
			<div class="optionLabel"><label><?php echo lang('enable comments') ?>:</label></div>
			<div class="optionControl"><?php echo yes_no_widget('message[comments_enabled]', $genid.'fileFormEnableComments', array_var($message_data, 'comments_enabled', true), lang('yes'), lang('no')) ?></div>
			<div class="optionDesc"><?php echo lang('enable comments desc') ?></div>
		</div>

		<div class="objectOption">
			<div class="optionLabel"><label><?php echo lang('enable anonymous comments') ?>:</label></div>
			<div class="optionControl"><?php echo yes_no_widget('message[anonymous_comments_enabled]', $genid.'fileFormEnableAnonymousComments', array_var($message_data, 'anonymous_comments_enabled', false), lang('yes'), lang('no')) ?></div>
			<div class="optionDesc"><?php echo lang('enable anonymous comments desc') ?></div>
		</div>
	</fieldset>
	</div>
	<?php } // if ?>

	<?php if($message->isNew() && $project instanceof Project) { ?>
	<div id="<?php echo $genid ?>add_message_mail_notif_div" style="display:none">
	<fieldset id="emailNotification">
	<legend><?php echo lang('email notification') ?></legend>
	<p><?php echo lang('email notification desc') ?></p>
	<?php if (active_project() instanceof Project) {
		$companies = $project->getCompanies();
	} else {
		$companies = Companies::findAll();
	}?>
	<?php foreach($companies as $company) { ?>
		<script type="text/javascript">
			App.modules.addMessageForm.notify_companies.company_<?php echo $company->getId() ?> = {
				id          : <?php echo $company->getId() ?>,
				checkbox_id : 'notifyCompany<?php echo $company->getId() ?>',
				users       : []
			};
		</script>
		<?php if (active_project() instanceof Project) {
			$users = $company->getUsersOnProject($project);
		} else {
			$users = $company->getUsers();
		}?>
		<?php if(is_array($users) && count($users)) { ?>
		<div class="companyDetails">
			<div class="companyName">
				<?php echo checkbox_field('message[notify_company_' . $company->getId() . ']', 
					array_var($message_data, 'notify_company_' . $company->getId()), 
					array('id' => $genid.'notifyCompany' . $company->getId(), 
						'onclick' => 'App.modules.addMessageForm.emailNotifyClickCompany(' . $company->getId() . ',"' . $genid. '")')) ?> 
				<label for="<?php echo $genid ?>notifyCompany<?php echo $company->getId() ?>" class="checkbox"><?php echo clean($company->getName()) ?></label>
			</div>
			
			<div class="companyMembers">
			<ul>
			<?php foreach($users as $user) { ?>
				<li><?php echo checkbox_field('message[notify_user_' . $user->getId() . ']', 
					array_var($message_data, 'notify_user_' . $user->getId()), 
					array('id' => $genid.'notifyUser' . $user->getId(), 
						'onclick' => 'App.modules.addMessageForm.emailNotifyClickUser(' . $company->getId() . ', ' . $user->getId() . ',"' . $genid. '")')) ?> 
					<label for="<?php echo $genid ?>notifyUser<?php echo $user->getId() ?>" class="checkbox"><?php echo clean($user->getDisplayName()) ?></label>
				<script type="text/javascript">
					App.modules.addMessageForm.notify_companies.company_<?php echo $company->getId() ?>.users.push({
						id          : <?php echo $user->getId() ?>,
						checkbox_id : 'notifyUser<?php echo $user->getId() ?>'
					});
				</script></li>
			<?php } // foreach ?>
			</ul>
			</div>
			</div>
		<?php } // if ?>
	<?php } // foreach ?>
	</fieldset>
	</div>
	<?php } // if ?>

	<div id='<?php echo $genid ?>add_message_properties_div' style="display:none">
	<fieldset>
		<legend><?php echo lang('properties') ?></legend>
		<?php echo render_object_properties('message',$message); ?>
	</fieldset>
	</div>

	<?php if($message->isNew() || $message->canLinkObject(logged_user(), $project)) { ?>
	<div style="display:none" id="<?php echo $genid ?>add_message_linked_objects_div">
	<fieldset>
		<legend><?php echo lang('linked objects') ?></legend>
	  	  <table style="width:100%;margin-left:2px;margin-right:3px" id="tbl_linked_objects">
	   	<tbody></tbody>
		</table>
		<?php echo render_object_links($message, $message->canEdit(logged_user())) ?>
	</fieldset>	
	</div>
	<?php } // if ?>
	
	
	<div>
	<?php echo label_tag(lang('text'), 'messageFormText', false) ?>
	<?php echo editor_widget('message[text]', array_var($message_data, 'text'), 
		array('id' => $genid . 'messageFormText', 'tabindex' => '2')) ?>
	</div>

	<div>
	<?php if(!$message->isNew() && trim($message->getAdditionalText())) { ?>
		<label for="<?php echo $genid ?>messageFormAdditionalText"><?php echo lang('additional text') ?>:</label>
		<?php echo editor_widget('message[additional_text]', array_var($message_data, 'additional_text'), array('id' => $genid . 'messageFormAdditionalText')) ?>
	<?php } /* else { ?>
		<label for="<?php echo $genid ?>messageFormAdditionalText"><?php echo lang('additional text') ?> (<a href="#" onclick="return App.modules.addMessageForm.toggleAdditionalText(this, '<?php echo $genid ?>messageFormAdditionalText', 
				'<?php echo lang('expand additional text') ?>', '<?php echo lang('collapse additional text') ?>')"><?php echo lang('expand additional text') ?></a>):</label>
		<?php echo editor_widget('message[additional_text]', array_var($message_data, 'additional_text'), array('id' => $genid . 'messageFormAdditionalText')) ?>
		<script type="text/javascript">
		document.getElementById('<?php echo $genid ?>messageFormAdditionalText').style.display = 'none';</script>
	<?php } */ // if ?>
	</div>
	
	<?php echo submit_button($message->isNew() ? lang('add message') : lang('save changes'),'s',
		array('style'=>'margin-top:0px', 'tabindex' => '3')) ?>
</div>
</div>
</form>

<script type="text/javascript">
	Ext.get('<?php echo $genid ?>messageFormTitle').focus();
</script>
