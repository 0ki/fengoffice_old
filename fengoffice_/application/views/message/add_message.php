<?php
	require_javascript('og/modules/addMessageForm.js'); 
	$genid = gen_id();
	$object = $message;
	$visible_cps = CustomProperties::countVisibleCustomPropertiesByObjectType($message->getObjectTypeId());
?>
<form onsubmit="return og.handleMemberChooserSubmit('<?php echo $genid; ?>', <?php echo $message->manager()->getObjectTypeId() ?>);" class="add-message" id="<?php echo $genid ?>submit-edit-form" style='height:100%;background-color:white' action="<?php echo $message->isNew() ? get_url('message', 'add') : $message->getEditUrl() ?>" method="post" enctype="multipart/form-data" >
<div class="message">
<div class="coInputHeader">
<div class="coInputHeaderUpperRow">
	<div class="coInputTitle">
		<table style="width:535px"><tr><td>
			<?php echo $message->isNew() ? lang('new message') : lang('edit message') ?>
		</td><td style="text-align:right">
			<?php echo submit_button($message->isNew() ? lang('add message') : lang('save changes'),'s',array('style'=>'margin-top:0px;margin-left:10px', 'tabindex' => '5')) ?>
		</td></tr></table>
	</div>
	
	</div>
	<div>
	<?php 
            $is_required = true;
            if(config_option('untitled_notes'))
            {
                $is_required = false;
            }
            echo label_tag(lang('title'), $genid . 'messageFormTitle', $is_required) 
        ?>
	<?php echo text_field('message[name]', array_var($message_data, 'name'), 
		array('id' => $genid . 'messageFormTitle', 'class' => 'title', 'tabindex' => '1')) ?>
	</div>
	
	<?php $categories = array(); Hook::fire('object_edit_categories', $object, $categories); ?>
	
	<div style="padding-top:5px">
		<a href="#" class="option" onclick="og.toggleAndBolden('<?php echo $genid ?>add_message_select_context_div',this)"><?php echo lang('context') ?></a> - 
		<a href="#" class="option <?php echo $visible_cps>0 ? 'bold' : ''?>" onclick="og.toggleAndBolden('<?php echo $genid ?>add_custom_properties_div',this)"><?php echo lang('custom properties') ?></a> - 
		<a href="#" class="option" onclick="og.toggleAndBolden('<?php echo $genid ?>add_subscribers_div',this)"><?php echo lang('object subscribers') ?></a>
		<?php if($object->isNew() || $object->canLinkObject(logged_user())) { ?> - 
			<a href="#" class="option" onclick="og.toggleAndBolden('<?php echo $genid ?>add_linked_objects_div',this)"><?php echo lang('linked objects') ?></a>
		<?php } ?>
		<?php foreach ($categories as $category) { ?>
			- <a href="#" class="option" <?php if ($category['visible']) echo 'style="font-weight: bold"'; ?> onclick="og.toggleAndBolden('<?php echo $genid . $category['name'] ?>', this)"><?php echo lang($category['name'])?></a>
		<?php } ?>
	</div>
</div>
<div class="coInputSeparator"></div>
<div class="coInputMainBlock">
	
	<input id="<?php echo $genid?>merge-changes-hidden" type="hidden" name="merge-changes" value="" >
	<input id="<?php echo $genid?>genid"                type="hidden" name="genid"         value="<?php echo $genid ?>" >
	<input id="<?php echo $genid?>updated-on-hidden"    type="hidden" name="updatedon"     value="<?php echo !$message->isNew() ? $message->getUpdatedOn()->getTimestamp() : '' ?>">
	
	<div id="<?php echo $genid ?>add_message_select_context_div" style="display:none"> 
		<fieldset>
			<legend><?php echo lang('context')?></legend>
			<?php
			if ($message->isNew()) {
				render_dimension_trees($message->manager()->getObjectTypeId(), $genid, null, array('select_current_context' => true)); 
			} else {
				render_dimension_trees($message->manager()->getObjectTypeId(), $genid, $message->getMemberIds()); 
			} 
			?>
		
		</fieldset>
	</div>
	
	<div id="<?php echo $genid ?>add_custom_properties_div" style="<?php echo ($visible_cps > 0 ? "" : "display:none") ?>">
		<fieldset>	
			<legend><?php echo lang('custom properties') ?></legend>
			<?php  echo render_object_custom_properties($message, false) ?>
			<?php  //echo render_add_custom_properties($object); ?>
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
	
	<?php if($object->isNew() || $object->canLinkObject(logged_user())) { ?>
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
		array('id' => $genid . 'messageFormText', 'tabindex' => '50')) ?>
	</div>
	
	<?php foreach ($categories as $category) { ?>
	<div <?php if (!$category['visible']) echo 'style="display:none"' ?> id="<?php echo $genid . $category['name'] ?>">
	<fieldset>
		<legend><?php echo lang($category['name'])?><?php if ($category['required']) echo ' <span class="label_required">*</span>'; ?></legend>
		<?php echo $category['content'] ?>
	</fieldset>
	</div>
	<?php } ?>

	
	<?php echo submit_button($message->isNew() ? lang('add message') : lang('save changes'),'s',
		array('style'=>'margin-top:0px', 'tabindex' => '20000')) ?>
</div>
</div>
</form>

<script>
	var memberChoosers = Ext.getCmp('<?php echo "$genid-member-chooser-panel-".$message->manager()->getObjectTypeId()?>').items;
	var treeClicked = false;
	if (memberChoosers) {
		memberChoosers.each(function(item, index, length) {
			
			item.on('all trees updated', function() {
				// First User click
				$(".member-chooser input.x-tree-node-cb").click(function(){
					treeClicked = true;
 				});
				var dimensionMembers = {};
				memberChoosers.each(function(it, ix, l) {
					dim_id = this.dimensionId;
					dimensionMembers[dim_id] = [];
					var checked = it.getChecked("id");
					for (var j = 0 ; j < checked.length ; j++ ) {
						dimensionMembers[dim_id].push(checked[j]);
					}
				});
				var uids = App.modules.addMessageForm.getCheckedUsers('<?php echo $genid ?>');
				if(treeClicked) {
					Ext.get('<?php echo $genid ?>add_subscribers_content').load({
						url: og.getUrl('object', 'render_add_subscribers', {
							context: Ext.util.JSON.encode(dimensionMembers),
							users: uids,
							genid: '<?php echo $genid ?>',
							otype: '<?php echo $message->manager()->getObjectTypeId()?>'
						}),
						scripts: true
					});
				}
			});
		});
	}
	
	Ext.get('<?php echo $genid ?>messageFormTitle').focus();	
</script>
