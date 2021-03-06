<div style="padding:20px">

<?php
	set_page_title($message->isNew() ? lang('add message') : lang('edit message'));
	project_tabbed_navigation(PROJECT_TAB_MESSAGES);
	project_crumbs(array(
		array(lang('messages'), get_url('message')),
		array($message->isNew() ? lang('add message') : lang('edit message'))
	));
	//add_stylesheet_to_page('project/messages.css');
	//add_javascript_to_page('modules/addMessageForm.js');
?>

<?php $project = active_or_personal_project();
	if ($message->isNew()) { ?>
	<form class="internalForm" action="<?php echo get_url('message', 'add') ?>" method="post" enctype="multipart/form-data">
	<?php } else { ?>
	<form class="internalForm" action="<?php echo $message->getEditUrl() ?>" method="post">
	<?php } // if?>

	<?php tpl_display(get_template_path('form_errors')) ?>

	<div>
	<?php echo label_tag(lang('title'), 'messageFormTitle', true) ?>
	<?php echo text_field('message[title]', array_var($message_data, 'title'), array('id' => 'messageFormTitle', 'class' => 'title')) ?>
	</div>

	<div>
	<?php echo label_tag(lang('text'), 'messageFormText', true) ?>
	<?php echo editor_widget('message[text]', array_var($message_data, 'text'), array('id' => 'messageFormText')) ?>
	</div>

	<div>
	<?php if(!$message->isNew() && trim($message->getAdditionalText())) { ?>
		<label for="messageFormAdditionalText"><?php echo lang('additional text') ?>: <span class="desc">- (<?php echo lang('additional message text desc') ?>)</span></label>
		<?php echo editor_widget('message[additional_text]', array_var($message_data, 'additional_text'), array('id' => 'messageFormAdditionalText')) ?>
	<?php } else { ?>
		<label for="messageFormAdditionalText"><?php echo lang('additional text') ?> (<a href="#" onclick="return App.modules.addMessageForm.toggleAdditionalText(this, 'messageFormAdditionalText', '<?php echo lang('expand additional text') ?>', '<?php echo lang('collapse additional text') ?>')"><?php echo lang('expand additional text') ?></a>): <span class="desc">- <?php echo lang('additional message text desc') ?></span></label>
		<?php echo editor_widget('message[additional_text]', array_var($message_data, 'additional_text'), array('id' => 'messageFormAdditionalText')) ?>
		<script type="text/javascript">$('messageFormAdditionalText').style.display = 'none';</script>
	<?php } // if ?>
	</div>

	<?php $projects =  active_projects();
	if (isset ($projects) && count($projects) > 0) { ?>
	<fieldset>
	<legend class="toggle_collapsed" onclick="og.toggle('add_message_project_div',this)"><?php echo lang('workspace') ?></legend>
	<?php echo select_project('message[project_id]', $projects, ($project instanceof Project)? $project->getId():0, array('id'=>'add_message_project_div', 'style' => 'display:none')) ?>
	</fieldset>
	<?php } ?>
  
	<?php if(logged_user()->isMemberOfOwnerCompany()) { ?>
	<fieldset>
	<legend class="toggle_collapsed" onclick="og.toggle('add_message_options_div',this)"><?php echo lang('options') ?></legend>
	<div id="add_message_options_div" style="display:none">
		<div class="objectOption">
			<div class="optionLabel"><label><?php echo lang('private message') ?>:</label></div>
			<div class="optionControl"><?php echo yes_no_widget('message[is_private]', 'messageFormIsPrivate', array_var($message_data, 'is_private'), lang('yes'), lang('no')) ?></div>
			<div class="optionDesc"><?php echo lang('private message desc') ?></div>
		</div>

		<div class="objectOption">
			<div class="optionLabel"><label><?php echo lang('important message')?>:</label></div>
			<div class="optionControl"><?php echo yes_no_widget('message[is_important]', 'messageFormIsImportant', array_var($message_data, 'is_important'), lang('yes'), lang('no')) ?></div>
			<div class="optionDesc"><?php echo lang('important message desc') ?></div>
		</div>

		<div class="objectOption">
			<div class="optionLabel"><label><?php echo lang('enable comments') ?>:</label></div>
			<div class="optionControl"><?php echo yes_no_widget('message[comments_enabled]', 'fileFormEnableComments', array_var($message_data, 'comments_enabled', true), lang('yes'), lang('no')) ?></div>
			<div class="optionDesc"><?php echo lang('enable comments desc') ?></div>
		</div>

		<div class="objectOption">
			<div class="optionLabel"><label><?php echo lang('enable anonymous comments') ?>:</label></div>
			<div class="optionControl"><?php echo yes_no_widget('message[anonymous_comments_enabled]', 'fileFormEnableAnonymousComments', array_var($message_data, 'anonymous_comments_enabled', false), lang('yes'), lang('no')) ?></div>
			<div class="optionDesc"><?php echo lang('enable anonymous comments desc') ?></div>
		</div>
	</div>
	</fieldset>
	<?php } // if ?>

	<fieldset>
	<legend class="toggle_collapsed" onclick="og.toggle('add_message_tags_div',this)"><?php echo lang('tags') ?></legend>
	<script type="text/javascript">
		var allTags = [<?php
			$coma = false;
			$tags = Tags::getTagNames();
			foreach ($tags as $tag) {
				if ($coma) {
					echo ",";
				} else {
					$coma = true;
				}
				echo "'" . $tag . "'";
			}
		?>];
	</script>
	<?php echo autocomplete_textfield("message[tags]", array_var($message_data, 'tags'), 'allTags', array('id'=>'add_message_tags_div', 'style'=>'display:none', 'class' => 'long')); ?>
	</fieldset> 

  
	<?php if($message->isNew() && $project instanceof Project) { ?>
	<fieldset id="emailNotification">
	<legend class="toggle_collapsed" onclick="og.toggle('add_message_mail_notif_div',this)"><?php echo lang('email notification') ?></legend>
	<div id="add_message_mail_notif_div" style="display:none">
	<p><?php echo lang('email notification desc') ?></p>
	<?php foreach($project->getCompanies() as $company) { ?>
		<script type="text/javascript">
			App.modules.addMessageForm.notify_companies.company_<?php echo $company->getId() ?> = {
				id          : <?php echo $company->getId() ?>,
				checkbox_id : 'notifyCompany<?php echo $company->getId() ?>',
				users       : []
			};
		</script>
		<?php if(is_array($users = $company->getUsersOnProject($project)) && count($users)) { ?>
		<div class="companyDetails">
			<div class="companyName"><?php echo checkbox_field('message[notify_company_' . $company->getId() . ']', array_var($message_data, 'notify_company_' . $company->getId()), array('id' => 'notifyCompany' . $company->getId(), 'onclick' => 'App.modules.addMessageForm.emailNotifyClickCompany(' . $company->getId() . ')')) ?> <label for="notifyCompany<?php echo $company->getId() ?>" class="checkbox"><?php echo clean($company->getName()) ?></label></div>
			<div class="companyMembers">
			<ul>
			<?php foreach($users as $user) { ?>
				<li><?php echo checkbox_field('message[notify_user_' . $user->getId() . ']', array_var($message_data, 'notify_user_' . $user->getId()), array('id' => 'notifyUser' . $user->getId(), 'onclick' => 'App.modules.addMessageForm.emailNotifyClickUser(' . $company->getId() . ', ' . $user->getId() . ')')) ?> <label for="notifyUser<?php echo $user->getId() ?>" class="checkbox"><?php echo clean($user->getDisplayName()) ?></label></li>
				<script type="text/javascript">
					App.modules.addMessageForm.notify_companies.company_<?php echo $company->getId() ?>.users.push({
						id          : <?php echo $user->getId() ?>,
						checkbox_id : 'notifyUser<?php echo $user->getId() ?>'
					});
				</script>
			<?php } // foreach ?>
			</ul>
			</div>
			</div>
		<?php } // if ?>
	<?php } // foreach ?>
	</div>
	</fieldset>
	<?php } // if ?>

	<fieldset>
	<legend class="toggle_collapsed" onclick="og.toggle('add_message_properties_div',this)"><?php echo lang('properties') ?></legend>
	<div id='add_message_properties_div' style="display:none">
	<? echo render_object_properties('message',$message); ?>
	</div>
	</fieldset>

	<?php if($project instanceof Project && $message->canLinkObject(logged_user(), $project)) { ?>
	<fieldset>
	<legend class="toggle_collapsed" onclick="og.toggle('add_message_linked_objects_div',this)"><?php echo lang('linked objects') ?></legend>
	<div style="display:none" id="add_message_linked_objects_div">
	<?php echo render_object_links($message, $message->canEdit(logged_user())) ?>
	</div>
	</fieldset>	
	<?php } // if ?>

	<?php echo submit_button($message->isNew() ? lang('add message') : lang('edit message')) ?>
</form>

</div>