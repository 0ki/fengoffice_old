<?php
	require_javascript("og/DateField.js");
	require_javascript("og/modules/addMemberForm.js");
	set_page_title(lang('members'));
	$genid = gen_id();
	if (!isset($parent_sel)) $parent_sel = 0;
	if (!isset($obj_type_sel)) $obj_type_sel = 0;
	if (!isset($member)) $member = null;
	$member_color = 0;
	if ($member instanceof Member && !$member->isNew()) {
		$memberId = $member->getId();
		$member_color = $member->getColor();
	} else if ($parent_sel > 0) {
		$p = Members::getMemberById($parent_sel);
		if ($p instanceof Member) $member_color = $p->getColor();
	}
	
	$object_type_selected = $obj_type_sel > 0 ? ObjectTypes::findById($obj_type_sel) : null;
	if ($member instanceof Member && !$member->isNew()) {
		$object_type_name = lang(ObjectTypes::findById($member->getObjectTypeId())->getName());
	} else {
		$object_type_name = $object_type_selected instanceof ObjectType ? lang($object_type_selected->getName()) : null;
	}
	if ($member instanceof Member && $member->isNew()) {
		$member->setObjectTypeId($obj_type_sel);
	}
	if($member instanceof Member && !$member->isNew()) {
		$ot = ObjectTypes::findById($member->getObjectTypeId());
		$ot_name = lang($ot->getName());
		if ($member->getArchivedById() == 0) {
			add_page_action(lang('archive'), "javascript:if(confirm('".lang('confirm archive member',$ot_name)."')) og.openLink('".get_url('member', 'archive', array('id' => $member->getId()))."');", 'ico-archive-obj');
		} else {
			add_page_action(lang('unarchive'), "javascript:if(confirm('".lang('confirm unarchive member',$ot_name)."')) og.openLink('".get_url('member', 'unarchive', array('id' => $member->getId()))."');", 'ico-unarchive-obj');
		}
		add_page_action(lang('delete'), "javascript:if(confirm('".lang('confirm delete permanently', $ot_name)."')) og.openLink('".get_url('member', 'delete', array('id' => $member->getId(),'start' => true))."');", 'ico-delete');
	}
	$form_title = $object_type_name ? ($member->isNew() ? lang('new') : lang('edit')) . strtolower(" $object_type_name") : lang('new member');
	$new_member_text = $object_type_name ? ($member->isNew() ? lang('add') : lang('edit')) . strtolower(" $object_type_name") : lang('new member');

	$categories = array();
	Hook::fire('object_edit_categories', $member, $categories);
	
	$has_custom_properties = count(MemberCustomProperties::getCustomPropertyIdsByObjectType($obj_type_sel)) > 0;
?>

<form 
	id="<?php echo $genid ?>submit-edit-form" 
	class="edit-member" 
	method="post" enctype="multipart/form-data"  
	action="<?php echo $member == null || $member->isNew() ? get_url('member', 'add') : get_url('member', 'edit', array("id" => $member->getId())) ?>"
<?php if ( $current_dimension instanceof Dimension && $current_dimension->getDefinesPermissions()):?>
	onsubmit="if (og.userPermissions) og.userPermissions.ogPermPrepareSendData('<?php echo $genid ?>', <?php echo $member->isNew() ? 'true' : 'false';?>); return true"
<?php endif;?>
>
	<input type="hidden" name="member[dimension_id]" value="<?php echo $current_dimension->getId()?>"/>

	<div class="coInputHeader">
	  <div class="coInputHeaderUpperRow">
		<div class="coInputTitle"><?php echo $form_title ?></div>
	  </div>
	
	  <div>
		<div class="coInputName">
			<?php echo text_field('member[name]', array_var($member_data, 'name'), array('id' => $genid . 'memberFormTitle', 'class' => 'title', 'placeholder' => lang('type name here'))) ?>
		</div>
			
		<div class="coInputButtons">
			<?php echo submit_button($member == null || $member->isNew() ? $new_member_text : lang('save changes'),'s',array('style'=>'margin-top:0px;margin-left:10px')) ?>
		</div>
		<div class="clear"></div>
	  </div>
	</div>
	
	
	<div class="coInputMainBlock">
	
	  <div id="<?php echo $genid?>tabs" class="edit-form-tabs">
	
		<ul id="<?php echo $genid?>tab_titles">
		
			<li><a href="#<?php echo $genid?>member_data"><?php echo lang('details') ?></a></li>
			
			<?php if ($current_dimension->getDefinesPermissions() && can_manage_security(logged_user())) {?>
			<li><a href="#<?php echo $genid?>member_permissions_div" id="<?php echo $genid?>permissions_tab"><?php echo lang('permissions') ?></a></li>
			<?php } ?>
			
			<?php if ($has_custom_properties) { ?>
			<li><a href="#<?php echo $genid?>add_custom_properties_div"><?php echo lang('custom properties') ?></a></li>
			<?php } ?>
			
		</ul>
		
		<div id="<?php echo $genid?>member_data" class="form-tab">
	
		<div <?php echo ($member == null || $member->isNew() ? "" : 'style="display:none;"')?> class="dataBlock" id="<?php echo $genid?>_member_type_container">
			<?php echo label_tag(lang('type'), "", true) ?>
			<input type="hidden" id="<?php echo $genid ?>memberObjectType" name="member[object_type_id]"></input>
			<div id="<?php echo $genid ?>object_type_combo_container"></div>
			<div class="clear"></div>
		</div>
		<?php if($member instanceof Member && DimensionObjectTypeHierarchies::typeAllowChilds($current_dimension->getId(), $member->getObjectTypeId())){ ?>
		<div id="<?php echo $genid?>memberParentContainer" style="width:267px;">
			<?php  
				$selected_members = array();
				if ($parent_sel) {
					$selected_members[] = $parent_sel;
				}
				//echo label_tag(lang('located under'), "", false);
				//render_single_dimension_tree($current_dimension, $genid, $selected_members, array('checkBoxes'=>false,'all_members' => true));
				
				render_single_member_selector($current_dimension, $genid, $selected_members, array('is_multiple' => false, 'label' => lang('located under'), 
					'select_function' => 'og.onParentMemberSelect', 'listeners' => array('on_remove_relation' => "og.onParentMemberRemove('".$genid."');")), false);
				
				
			?>
				<input type="hidden" id="<?php echo $genid ?>memberParent" value="<?php echo $parent_sel; ?>" name="member[parent_member_id]"></input>
				<div class="clear"></div>
		</div>
		<?php } ?>
		
		<div id="<?php echo $genid?>member_color_input" class="dataBlock"></div>
		<div class="x-clear"></div>
		
		
		<div id="<?php echo $genid?>dimension_object_fields" style="display:none;"></div>
		
		<div style="margin-top:10px; display:none;" id="<?php echo $genid?>property_links">
			<span id="<?php echo $genid ?>addPropertiesLink"
				onclick="App.modules.addMemberForm.drawDimensionProperties('<?php echo $genid;?>', <?php echo $current_dimension->getId();?>);"
				class="db-ico ico-add bold" style="padding:3px 0 0 20px; cursor:pointer;"><?php echo lang('vinculations')?></span>
				
			<span id="<?php echo $genid ?>delPropertiesLink"
				onclick="App.modules.addMemberForm.deleteDimensionProperties('<?php echo $genid?>');"
				class="db-ico ico-delete bold" style="padding:3px 0 0 20px; cursor:pointer; display:none;"><?php echo lang('hide vinculations')?></span>
		</div>
		
		<div id="<?php echo $genid?>dimension_properties" style="width:750px;"></div>
		
		<div style="margin-top:10px; display:none;" id="<?php echo $genid?>restriction_links">
			<input type="hidden" id="<?php echo $genid?>ot_with_restrictions" value="" />
			<span id="<?php echo $genid ?>addRestrictionsLink"
				onclick="App.modules.addMemberForm.drawDimensionRestrictions('<?php echo $genid;?>', <?php echo $current_dimension->getId();?>);"
				class="db-ico ico-add bold" style="padding:3px 0 0 20px; cursor:pointer;"><?php echo lang('restrictions')?></span>
				
			<span id="<?php echo $genid ?>delRestrictionsLink"
				onclick="App.modules.addMemberForm.deleteDimensionRestrictions('<?php echo $genid?>');"
				class="db-ico ico-delete bold" style="padding:3px 0 0 20px; cursor:pointer; display:none;"><?php echo lang('hide restrictions')?></span>
		</div>
		
		<div id="<?php echo $genid?>dimension_restrictions" style="width:750px;"></div>
	<?php if (isset($rest_genid)) { ?>
		<input type="hidden" name="rest_genid" value="<?php echo $rest_genid?>" />
	<?php } ?>
	<?php if (isset($prop_genid)) { ?>
		<input type="hidden" name="prop_genid" value="<?php echo $prop_genid?>" />
	<?php } ?>
	
		
		</div>
		
		<div id="<?php echo $genid?>member_permissions_div" class="form-tab">
		<?php if ($current_dimension->getDefinesPermissions() && can_manage_security(logged_user())):?>
			<label><?php echo lang("users and groups with permissions here")?></label>
			<div class="clear"></div>
			<?php
				tpl_assign('genid', $genid); 
				$this->includeTemplate(get_template_path('member_permissions_control', 'member'));
			?>
		<?php endif ;?>
		</div>
		<div class="x-clear"></div>
		
		<?php if ($has_custom_properties) { ?>
		<div id="<?php echo $genid ?>add_custom_properties_div" class="form-tab"><?php 
			if($member->getObjectTypeId() > 0){
				echo render_member_custom_properties($member, false);
			}			
		?></div>
		<div class="x-clear"></div>
		<?php } ?>
		
	</div>
	<?php echo submit_button($member == null || $member->isNew() ? $new_member_text : lang('save changes'),'s',array('style'=>'margin-top:0px;')) ?>
</form>

<script>



	og.prev_parent = null;
	var genid = '<?php echo $genid?>';
	
	og.dimRestrictions.ot_with_restrictions = Ext.util.JSON.decode('<?php echo json_encode($ot_with_restrictions)?>');
	og.dimProperties.ot_with_properties = Ext.util.JSON.decode('<?php echo json_encode($ot_with_associations)?>');

	$(function() {
		$("#<?php echo $genid?>tabs").tabs();

		Ext.get('<?php echo $genid ?>memberFormTitle').focus();
		
		og.eventManager.fireEvent("after member add render",{
			genid: genid,
			dimensionCode: '<?php echo $current_dimension->getCode()?>'
		});

		App.modules.addMemberForm.drawObjectTypesSelectBox(genid, Ext.util.JSON.decode('<?php echo json_encode($dimension_obj_types)?>'), 'object_type_combo_container', 'memberObjectType', '<?php echo (isset($obj_type_sel) ? $obj_type_sel : 0) ?>', '<?php echo (isset($can_change_type) && $can_change_type ? '0' : '1')?>');
		App.modules.addMemberForm.objectTypeChanged('<?php echo $obj_type_sel ?>', genid, true);

		<?php if (count($selected_members) > 0) { ?>
		App.modules.addMemberForm.drawDimensionProperties('<?php echo $genid;?>', <?php echo $current_dimension->getId();?>);
		<?php } ?>
		
		document.getElementById(genid + 'member_color_input').innerHTML = og.getColorInputHtml(genid, 'member', <?php echo "$member_color"?>, 'color', '<?php echo lang('color')?>');
		
		<?php if (isset($obj_type_sel) && $obj_type_sel) {?>
			$("#<?php echo $genid?>_member_type_container").hide();
		<?php }	?>
	});
</script>
