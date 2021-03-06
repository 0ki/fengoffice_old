<?php 
	$project = active_or_personal_project();
	$projects =  active_projects();
	$genid = gen_id();
	$object = $message;
?>
<form style='height:100%;background-color:white' class="internalForm" action="<?php echo $message->isNew() ? get_url('message', 'add') : $message->getEditUrl() ?>" method="post" enctype="multipart/form-data">

<div class="message">
<div class="coInputHeader">
<div class="coInputHeaderUpperRow">
	<div class="coInputTitle"><table style="width:535px"><tr><td><?php echo $message->isNew() ? lang('new message') : lang('edit message') ?>
	</td><td style="text-align:right"><?php echo submit_button($message->isNew() ? lang('add message') : lang('save changes'),'s',array('style'=>'margin-top:0px;margin-left:10px', 'tabindex' => '100')) ?></td></tr></table>
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
		<a href="#" class="option" onclick="og.toggleAndBolden('<?php echo $genid ?>add_message_options_div',this)"><?php echo lang('options') ?></a> -
		<a href="#" class="option" onclick="og.toggleAndBolden('<?php echo $genid ?>add_custom_properties_div',this)"><?php echo lang('custom properties') ?></a> - 
		<a href="#" class="option" onclick="og.toggleAndBolden('<?php echo $genid ?>add_subscribers_div',this)"><?php echo lang('object subscribers') ?></a>
		<?php if($object->isNew() || $object->canLinkObject(logged_user(), $project)) { ?> - 
			<a href="#" class="option" onclick="og.toggleAndBolden('<?php echo $genid ?>add_linked_objects_div',this)"><?php echo lang('linked objects') ?></a>
		<?php } ?>
	</div>
</div>
<div class="coInputSeparator"></div>
<div class="coInputMainBlock">
	<?php if (isset ($projects) && count($projects) > 0) { ?>
	<div id="<?php echo $genid ?>add_message_select_workspace_div" style="display:none">
	<fieldset><legend><?php echo lang('workspace')?></legend>
		<?php if ($message->isNew()) {
			echo select_workspaces('ws_ids', null, array($project), $genid.'ws_ids');
		} else {
			echo select_workspaces('ws_ids', null, $message->getWorkspaces(), $genid.'ws_ids');
		} ?>
	</fieldset>
	</div>
	<?php } ?>
	
	<div id="<?php echo $genid ?>add_message_add_tags_div" style="display:none">
	<fieldset><legend><?php echo lang('tags')?></legend>
		<?php echo autocomplete_tags_field("message[tags]", array_var($message_data, 'tags'), null, 40); ?>
	</fieldset>
	</div>

	<?php if(logged_user()->isMemberOfOwnerCompany()) { ?>
	<div id="<?php echo $genid ?>add_message_options_div" style="display:none">
	<fieldset>
	<legend><?php echo lang('options') ?></legend>
	    <?php /* <div class="objectOption">
			<div class="optionLabel"><label><?php echo lang('private message') ?>:</label></div>
			<div class="optionControl"><?php echo yes_no_widget('message[is_private]', $genid.'messageFormIsPrivate', array_var($message_data, 'is_private'), lang('yes'), lang('no')) ?></div>
			<div class="optionDesc"><?php echo lang('private message desc') ?></div>
		</div>
		
		<div class="objectOption">
			<div class="optionLabel"><label><?php echo lang('important message')?>:</label></div>
			<div class="optionControl"><?php echo yes_no_widget('message[is_important]', $genid.'messageFormIsImportant', array_var($message_data, 'is_important'), lang('yes'), lang('no')) ?></div>
			<div class="optionDesc"><?php echo lang('important message desc') ?></div>
		</div> */ ?>

		<div class="objectOption">
			<div class="optionLabel"><label><?php echo lang('enable comments') ?>:</label></div>
			<div class="optionControl"><?php echo yes_no_widget('message[comments_enabled]', $genid.'fileFormEnableComments', array_var($message_data, 'comments_enabled', true), lang('yes'), lang('no'), 45) ?></div>
			<div class="optionDesc"><?php echo lang('enable comments desc') ?></div>
		</div>

		<div class="objectOption">
			<div class="optionLabel"><label><?php echo lang('enable anonymous comments') ?>:</label></div>
			<div class="optionControl"><?php echo yes_no_widget('message[anonymous_comments_enabled]', $genid.'fileFormEnableAnonymousComments', array_var($message_data, 'anonymous_comments_enabled', false), lang('yes'), lang('no'), 50) ?></div>
			<div class="optionDesc"><?php echo lang('enable anonymous comments desc') ?></div>
		</div>
	</fieldset>
	</div>
	<?php } // if ?>

	<div id='<?php echo $genid ?>add_custom_properties_div' style="display:none">
	<fieldset>
		<legend><?php echo lang('custom properties') ?></legend>
		<?php echo render_add_custom_properties($object); ?>
	</fieldset>
	</div>

	<div id="<?php echo $genid ?>add_subscribers_div" style="display:none">
		<fieldset>
		<legend><?php echo lang('object subscribers') ?></legend>
		<div id="<?php echo $genid ?>add_subscribers_content">
			<?php echo render_add_subscribers($object, $genid); ?>
		</div>
		</fieldset>
	</div>
	
	<script>
	var wsch = Ext.getCmp('<?php echo $genid ?>ws_ids');
	wsch.on("wschecked", function(arguments) {
		var uids = App.modules.addMessageForm.getCheckedUsers('<?php echo $genid ?>');
		Ext.get('<?php echo $genid ?>add_subscribers_content').load({
			url: og.getUrl('object', 'render_add_subscribers', {
				workspaces: this.getValue(),
				users: uids,
				genid: '<?php echo $genid ?>',
				object_type: '<?php echo get_class($object->manager()) ?>'
			}),
			scripts: true
		});
	}, wsch);
	</script>

	<?php if($object->isNew() || $object->canLinkObject(logged_user(), $project)) { ?>
	<div style="display:none" id="<?php echo $genid ?>add_linked_objects_div">
	<fieldset>
		<legend><?php echo lang('linked objects') ?></legend>
		<?php echo render_object_link_form($object) ?>
	</fieldset>	
	</div>
	<?php } // if ?>
	
	
	<div>
	<?php echo label_tag(lang('text'), 'messageFormText', false) ?>
	<?php echo editor_widget('message[text]', array_var($message_data, 'text'), 
		array('id' => $genid . 'messageFormText', 'tabindex' => '20')) ?>
	</div>

	<div>
	<?php if(!$message->isNew() && trim($message->getAdditionalText())) { ?>
		<label for="<?php echo $genid ?>messageFormAdditionalText"><?php echo lang('additional text') ?>:</label>
		<?php echo editor_widget('message[additional_text]', array_var($message_data, 'additional_text'), array('id' => $genid . 'messageFormAdditionalText', 'tabindex' => '25')) ?>
	<?php } /* else { ?>
		<label for="<?php echo $genid ?>messageFormAdditionalText"><?php echo lang('additional text') ?> (<a href="#" onclick="return App.modules.addMessageForm.toggleAdditionalText(this, '<?php echo $genid ?>messageFormAdditionalText', 
				'<?php echo escape_single_quotes(lang('expand additional text')) ?>', '<?php echo escape_single_quotes(lang('collapse additional text')) ?>')"><?php echo lang('expand additional text') ?></a>):</label>
		<?php echo editor_widget('message[additional_text]', array_var($message_data, 'additional_text'), array('id' => $genid . 'messageFormAdditionalText')) ?>
		<script type="text/javascript">
		document.getElementById('<?php echo $genid ?>messageFormAdditionalText').style.display = 'none';</script>
	<?php } */ // if ?>
	</div>
	
	<?php echo submit_button($message->isNew() ? lang('add message') : lang('save changes'),'s',
		array('style'=>'margin-top:0px', 'tabindex' => '30')) ?>
</div>
</div>
</form>

<script type="text/javascript">
	Ext.get('<?php echo $genid ?>messageFormTitle').focus();
</script>
