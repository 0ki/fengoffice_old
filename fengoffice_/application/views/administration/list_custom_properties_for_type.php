<?php   
  if (!isset($genid)) {
  	$genid = gen_id();
  }
  
  if (!isset($save_js_function)) {
  	$save_js_function = "og.saveObjectTypeCustomProperties('$genid');";
  }
  
  $type_name = strtolower(lang($object_type->getName().'s'));
  
?>

<script>
	var genid = '<?php echo $genid?>';
	og.admin_cp_count = {};
	og.admin_cp_count['<?php echo $genid?>'] = 0;

	og.custom_props_table_genids = [];
	og.custom_props_table_genids = ['<?php echo $genid?>'];
	
</script>

<div class="custom-properties-admin object-type <?php echo $object_type->getName() ?>">

<div class="coInputHeader">
<table><tr><td>
  <div class="coInputHeaderUpperRow">
	<div class="coInputTitle">
		<?php if (array_var($extra_params, 'form_title')) {
			echo array_var($extra_params, 'form_title');
		} else {
			echo lang('custom properties for', $type_name);
		} ?>
	</div>
	<div class="desc">
		<?php echo lang('custom properties reorder help') ?>
	</div>
  </div>
</td><td style="min-width:160px;">
  <div class="coInputHeaderUpperRow">
  	<div class="coInputButtons">
  		<?php echo submit_button(lang('save changes'), null, array('onclick' => $save_js_function, 'style' => 'margin-top:0; margin-left:20px;')) ?>
  	</div>
  </div>
</td></tr></table>
</div>

<div class="coInputMainBlock adminMainBlock">
	<input type="hidden" id="<?php echo $genid?>_ot_id" value="<?php echo $object_type->getId() ?>"/>
	
	<?php 
		tpl_assign('genid', $genid);
		tpl_assign('type_name', $type_name);
		tpl_assign('extra_params', $extra_params);
		tpl_display(get_template_path('cp_table_template', 'administration'));
	?>
	
	<?php 
	$fire_sections_hook = !isset($dont_fire_hook) || !$dont_fire_hook;
	if ($fire_sections_hook) {
		$null = null;
		Hook::fire('custom_property_form_sections', array('ot' => $object_type, 'genid' => $genid), $null);
	}
	?>
	
	<?php echo submit_button(lang('save changes'), null, array('onclick' => $save_js_function)) ?>
</div>

</div>

<script>
og.addCustomPropertyRow = function(genid, property, id_suffix) {

	var template = $('<tbody></tbody>');
	
	var cp_count = og.admin_cp_count[genid] || 0;
	id_suffix = id_suffix || '';

	var container_id = "cp-container-" + cp_count + id_suffix;

	// get html and replace {number} with new cp index
	var template_html = $("#"+genid+"-cp-container-template").html();
	template_html = template_html.replace(/{number}/g, cp_count);
	template.html(template_html);
	
	$(template).attr('id', container_id);
	$(template).addClass("cp-container").addClass(genid);
	if (cp_count % 2 != 0) {
		$(template).addClass("alt");
	}

	$("#"+genid+"custom-properties-table").append(template);
	
	var pre_id = "#" + container_id;
	
	$(pre_id + " #order").html(cp_count + 1);
	$(pre_id + " #deleted_message").html(lang('custom property deleted'));
	
	if (property) {

		$(pre_id + " #id").attr('value', property.id);
		$(pre_id + " #name").attr('value', property.name);
		$(pre_id + " #description").attr('value', property.description);
		$(pre_id + " #values").attr('value', property.values);
		$(pre_id + " #default_value").attr('value', property.default_value);
		$(pre_id + " #is_special").attr('value', property.is_special);
		$(pre_id + " #is_disabled").attr('value', property.is_disabled);
		if (property.default_value) {
			$(pre_id + " #default_value_bool").attr('checked', 'checked');
		}
		if (property.is_required) {
			$(pre_id + " #is_required").attr('checked', 'checked');
		}
		if (property.is_multiple_values) {
			$(pre_id + " #is_multiple_values").attr('checked', 'checked');
		}
		if (property.visible_by_default) {
			$(pre_id + " #visible_by_default").attr('checked', 'checked');
		}

		$(pre_id + ' #type option[value="' + property.type + '"]').prop('selected', true);
		
		if (property.type == 'list' || property.type == 'table') {
			$(pre_id + " #values").show();
			$(pre_id + " #values_hint").hide();
		} else if (property.type == 'boolean') {
			$(pre_id + " #default_value_bool").show();
			$(pre_id + " #default_value").hide();
		}

		if (property.is_special) {
			
			$(pre_id + " #delete_action").hide();
			$(pre_id + " #undo_delete_action").hide();

			$(pre_id + " #type").hide();
			$(pre_id + " #values").hide();
			$(pre_id + " #values_hint").hide();
			$(pre_id + " #default_value").hide();
			$(pre_id + " #is_required").hide();
			$(pre_id + " #is_multiple_values").hide();
			$(pre_id + " #visible_by_default").hide();
			
			$(pre_id + " #is_special_hint").show();

			if (property.is_disabled) {
				$(pre_id + " #disabled_message").show();
				$(pre_id + " #enable_action").show();
				$(pre_id + " #disable_action").hide();
				$(template).addClass("disabled");
			} else {
				$(pre_id + " #enable_action").hide();
				$(pre_id + " #disable_action").show();
			}
			
		}
	}
	
	og.admin_cp_count[genid] = cp_count + 1;
}
	
$(function() {

<?php 
	if (count($custom_properties) == 0) { // add one empty row

		?>og.addCustomPropertyRow('<?php echo $genid?>');<?php
		
	} else {
		foreach ($custom_properties as $cp) { /* @var $cp CustomProperty */ ?>
		var prop = {
				id: '<?php echo $cp->getId()?>',
				name: '<?php echo escape_character($cp->getName())?>',
				type: '<?php echo $cp->getType()?>',
				description: '<?php echo escape_character($cp->getDescription())?>',
				values: '<?php echo escape_character($cp->getValues())?>',
				default_value: '<?php echo escape_character($cp->getDefaultValue())?>',
				is_special: <?php echo $cp->getColumnValue('is_special') ? '1' : '0'?>,
				is_disabled: <?php echo $cp->getColumnValue('is_disabled') ? '1' : '0'?>,
				visible_by_default: <?php echo $cp->getVisibleByDefault() ? '1' : '0' ?>,
				is_required: <?php echo $cp->getIsRequired() ? '1' : '0' ?>,
				is_multiple_values: <?php echo $cp->getIsMultipleValues() ? '1' : '0' ?>
		};
		og.addCustomPropertyRow('<?php echo $genid?>', prop);
	
	<?php }
	} ?>
	
	$( "#<?php echo $genid?>custom-properties-table" ).sortable({
		stop: function(event, object) {
			og.refreshTableRowsOrder(genid);
		},
		handle: ".handle",
		cursor: "move",
		cancel: "tr.header"
	});
});
</script>



