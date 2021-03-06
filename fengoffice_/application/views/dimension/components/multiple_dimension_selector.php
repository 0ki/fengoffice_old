
<script>
if (!member_selector) var member_selector = {};
</script>

<div id='<?php echo $component_id ?>-container' class="member-selectors-container" >
	<input id='<?php echo $genid; ?>members' name='members' type='hidden' value="<?php echo str_replace('"', "'", $selected_members_json); ?>"></input>

<?php

	$initial_selected_members = $selected_members;

	if (count($initial_selected_members) == 0) {
		$selected_context_member_ids = active_context_members(false);
		if (count($selected_context_member_ids) > 0) {
			$initial_selected_members = Members::findAll(array('conditions' => 'id IN ('.implode(',', $selected_context_member_ids).')'));
		}
	}
	
	$members_dimension = array();
	$sel_mem_ids = array();
	foreach ($dimensions as $dimension) :
	
		$dimension_id = $dimension['dimension_id'];
		if (is_array($skipped_dimensions) && in_array($dimension_id, $skipped_dimensions)) continue;
		
		if ( is_array(array_var($options, 'allowedDimensions')) && array_search($dimension_id, $options['allowedDimensions']) === false ){
			continue;	 
		}

		if (!$dimension['is_manageable']) continue;
		
		$is_required = $dimension['is_required'];				
		$dimension_name = $dimension['dimension_name'];				
		if ($is_required) $dimension_name .= " *";
		
		if (is_array($simulate_required) && in_array($dimension_id, $simulate_required)) $is_required = true;

		$dimension_selected_members = array();
		foreach ($selected_members as $selected_member) {
			if ($selected_member->getDimensionId() == $dimension_id) $dimension_selected_members[] = $selected_member;
		}
		
		$autocomplete_options = array();
		if (!isset($dim_controller)) $dim_controller = new DimensionController();
		$members = $dim_controller->initial_list_dimension_members($dimension_id, $content_object_type_id, $allowed_member_type_ids, false, "", null, false, null, true, $initial_selected_members);
		
		foreach ($members as $m) {
			$autocomplete_options[] = array($m['id'], $m['name'], $m['path'], $m['to_show'], $m['ico'], $m['dim']);
			$members_dimension[$m['id']] = $m['dim'];
		}
		
		$expgenid = gen_id();
?>
	
	<div id="<?php echo $genid; ?>member-seleector-dim<?php echo $dimension_id?>" class="single-dimension-selector">
		<div class="header x-accordion-hd" onclick="og.dashExpand('<?php echo $expgenid?>', 'selector-body-dim<?php echo $dimension_id ?>');">
			<?php echo $dimension_name?>
			<div id="<?php echo $expgenid; ?>expander" class="dash-expander ico-dash-expanded"></div>
		</div>
		<div class="selector-body" id="<?php echo $expgenid?>selector-body-dim<?php echo $dimension_id ?>">
			<div id="<?php echo $genid; ?>selected-members-dim<?php echo $dimension_id?>" class="selected-members">
	
	<?php if (count($dimension_selected_members) > 0) : 
			$alt_cls = "";
			$dimension_has_selection = false;
			foreach ($dimension_selected_members as $selected_member) :
				$allowed_members = array_keys($members_dimension);
				if (!in_array($selected_member->getId(), $allowed_members)) continue;
				$dimension_has_selection = true;
				?>
				<div class="selected-member-div <?php echo $alt_cls?>" id="<?php echo $genid?>selected-member<?php echo $selected_member->getId()?>">
					<span class="coViewAction <?php echo $selected_member->getIconClass()?>"></span><?php
						$complete_path = $selected_member->getPath();
						$complete_path = ($complete_path == "" ? "" : '<span class="path">'.$complete_path.'/</span>') . '<span class="bold">' . $selected_member->getName() . '</span>';
						echo $complete_path;
					?><div class="selected-member-actions">
						<a href="#" class="coViewAction ico-delete" title="<?php echo lang('remove relation')?>" onclick="member_selector.remove_relation(<?php echo $dimension_id?>,'<?php echo $genid?>', <?php echo $selected_member->getId()?>)"><?php echo lang('remove')?></a>
					</div>
				</div>
	<?php 		$alt_cls = $alt_cls == "" ? "alt-row" : "";
				$sel_mem_ids[] = $selected_member->getId();
		 	endforeach; ?>
	
				<div class="separator"></div>
	<?php endif;?>
			</div>
			<?php $form_visible = $dimension['is_multiple'] || (!$dimension['is_multiple'] && !$dimension_has_selection); ?>
			<div id="<?php echo $genid; ?>add-member-form-dim<?php echo $dimension_id?>" class="add-member-form" style="display:<?php echo ($form_visible?'block':'none')?>;">
				<?php
				$combo_listeners = array(
					"select" => "function (combo, record, index) { member_selector.autocomplete_select($dimension_id, '$genid', combo, record); }",
				);
				echo autocomplete_member_combo("member_autocomplete-dim".$dimension_id, $dimension_id, $autocomplete_options, 
					lang('add new relation ' . $dimension['dimension_code']), array('class' => 'member-name-input'), false, $genid .'add-member-input-dim'. $dimension_id, $combo_listeners);
				?>
				<div class="clear"></div>
			</div>
		</div>
	</div>

	<script>
	if (!member_selector['<?php echo $genid; ?>']) member_selector['<?php echo $genid; ?>'] = {};
	if (!member_selector['<?php echo $genid; ?>'].properties) member_selector['<?php echo $genid; ?>'].properties = {};

	<?php
	$listeners_str = "{";
	foreach ($listeners as $event => $function) {
		$listeners_str .= $event .' : \''. escape_single_quotes($function) .'\',';
	}
	if (str_ends_with($listeners_str, ",")) $listeners_str = substr($listeners_str, 0, -1);
	$listeners_str .= "}";
	?>

	member_selector['<?php echo $genid; ?>'].properties['<?php echo $dimension_id ?>'] = {
		title: '<?php echo $dimension_name ?>',
		dimensionId: <?php echo $dimension_id ?>,
		objectTypeId: <?php echo $content_object_type_id ?>,
		required: <?php echo $is_required ?>,
		reloadDimensions: <?php echo json_encode( DimensionMemberAssociations::instance()->getDimensionsToReload($dimension_id) ); ?>,
		isMultiple: <?php echo $dimension['is_multiple'] ?>,
		listeners: <?php echo $listeners_str ?>
	};

	if (member_selector['<?php echo $genid; ?>'].properties['<?php echo $dimension_id ?>'].listeners.after_render) {
		eval(member_selector['<?php echo $genid; ?>'].properties['<?php echo $dimension_id ?>'].listeners.after_render);
	}

	</script>
<?php endforeach; ?>
	
<?php 
	foreach ($listeners as $event => $function) {
		if ($event == 'after_render_all') {
			echo '<script>'.escape_single_quotes($function).';</script>';
		}
	}
?>
	<div class="clear"></div>
</div>
<script>

member_selector['<?php echo $genid; ?>'].members_dimension = Ext.util.JSON.decode('<?php echo json_encode($members_dimension)?>');
member_selector['<?php echo $genid; ?>'].context = og.contextManager.plainContext();

member_selector.init = function(genid) {

	member_selector[genid].sel_context = {};
	var selected_member_ids = Ext.util.JSON.decode(Ext.fly(Ext.get(genid + 'members')).getValue());
	for (i=0; i<selected_member_ids.length; i++) {
		var mid = selected_member_ids[i];
		var dim = member_selector[genid].members_dimension[mid];
		if (!member_selector[genid].sel_context[dim]) {
			member_selector[genid].sel_context[dim] = [];
		}
		member_selector[genid].sel_context[dim].push(mid);
	}
}

member_selector.autocomplete_select = function(dimension_id, genid, combo, record) {
	combo.setValue(record.data.name);
	combo.selected_member = record.data;

	member_selector.add_relation(dimension_id, genid);
}

member_selector.add_relation = function(dimension_id, genid) {
	var combo = Ext.getCmp(genid + 'add-member-input-dim' + dimension_id);
	var member = combo.selected_member;

	if (member == null) return;

	var selected_member_ids = Ext.util.JSON.decode(Ext.fly(Ext.get(genid + 'members')).getValue());
	var i = 0;
	while (selected_member_ids[i] != member.id && i < selected_member_ids.length) i++;
	if (i < selected_member_ids.length) {
		combo.clearValue();
		combo.selected_member = null;
		return;
	}

	if (!member_selector[genid].sel_context[dimension_id]) member_selector[genid].sel_context[dimension_id] = [];
	member_selector[genid].sel_context[dimension_id].push(member.id);
	
	var sel_members_div = Ext.get(genid + 'selected-members-dim' + dimension_id);
	var already_selected = sel_members_div.select('div.selected-member-div').elements;
	var last = already_selected.length > 0 ? Ext.fly(already_selected[already_selected.length - 1]) : null;
	var alt_cls = last==null || last.hasClass('alt-row') ? "" : " alt-row";
	
	var html = '<div class="selected-member-div'+alt_cls+'" id="'+genid+'selected-member'+member.id+'">';
	html += '<span class="coViewAction '+member.ico+'"></span>';
	if (member.path != '') {
		html += '<span class="path">'+member.path+'/ </span>';
	}
	html += '<span class="bold">'+member.name+'</span>';
	html += '<div class="selected-member-actions"><a class="coViewAction ico-delete" onclick="member_selector.remove_relation('+dimension_id+',\''+genid+'\', '+member.id+')" href="#">'+lang('remove')+'</a></div>';
	html += '</div><div class="separator"></div>';

	var sep = sel_members_div.select('div.separator').elements;
	for (x in sep) Ext.fly(sep[x]).remove();
	sel_members_div.insertHtml('beforeEnd', html);

	combo.clearValue();
	combo.selected_member = null;

	if (!member_selector[genid].properties[dimension_id].isMultiple) {
		var form = Ext.get(genid + 'add-member-form-dim' + dimension_id);
		if (form) {
			f = Ext.fly(form);
			f.enableDisplayMode();
			f.hide();
		}
	}

	// refresh member_ids input
	var member_ids_input = Ext.fly(Ext.get(genid + 'members'));
	var member_ids = Ext.util.JSON.decode(member_ids_input.getValue());
	member_ids.push(member.id);
	member_ids_input.dom.value = Ext.util.JSON.encode(member_ids);

	// reload dependant selectors
	member_selector.reload_dependant_selectors(dimension_id, genid);

	// on selection change listener
	if (member_selector[genid].properties[dimension_id].listeners.on_selection_change) {
		eval(member_selector[genid].properties[dimension_id].listeners.on_selection_change);
	}
}

member_selector.remove_relation = function(dimension_id, genid, member_id, dont_reload) {
	
	var div = Ext.get(genid+'selected-member'+member_id);
	if (div) {
		div = Ext.fly(div);
		var next = div;
		while (next = next.next('div.selected-member-div')) {
			if (next.hasClass('alt-row')) next.removeClass('alt-row');
			else next.addClass('alt-row');
		}
		div.remove();
	}

	var sel_members_div = Ext.get(genid + 'selected-members-dim' + dimension_id);
	var already_selected = sel_members_div.select('div.selected-member-div').elements;
	if (already_selected.length == 0) {
		var sep = sel_members_div.select('div.separator').elements;
		for (x in sep) Ext.fly(sep[x]).remove();
	}

	if (!member_selector[genid].properties[dimension_id].isMultiple) {
		var form = Ext.get(genid + 'add-member-form-dim' + dimension_id);
		if (form) {
			f = Ext.fly(form);
			f.enableDisplayMode();
			f.show();
		}
	}

	// refresh member_ids input
	var member_ids_input = Ext.fly(Ext.get(genid + 'members'));
	var member_ids = Ext.util.JSON.decode(member_ids_input.getValue());
	for (index in member_ids) {
		if (member_ids[index] == member_id) member_ids.splice(index, 1);
	}
	member_ids_input.dom.value = Ext.util.JSON.encode(member_ids);

	for (index in member_selector[genid].sel_context[dimension_id]) {
		if (member_selector[genid].sel_context[dimension_id][index] == member_id) {
			member_selector[genid].sel_context[dimension_id].splice(index, 1);
		}
	}

	if (!dont_reload) {
		// reload dependant selectors
		member_selector.reload_dependant_selectors(dimension_id, genid);
	
		// on selection change listener
		if (member_selector[genid].properties[dimension_id].listeners.on_selection_change) {
			eval(member_selector[genid].properties[dimension_id].listeners.on_selection_change);
		}
	}
}

member_selector.reload_dependant_selectors = function(dimension_id, genid) {
	dimensions_to_reload = member_selector[genid].properties[dimension_id].reloadDimensions;

	for (i=0; i<dimensions_to_reload.length; i++) {
		var dim_id = dimensions_to_reload[i];
		if (member_selector[genid].properties[dim_id]) {
		
			var member_ids_input = Ext.fly(Ext.get(genid + 'members'));
			var selected_members = member_ids_input.getValue();
			
			$.ajax({
				data: {
					dimension_id: dim_id,
					object_type_id: member_selector[genid].properties[dim_id].objectTypeId,
					onlyname: 1,
					selected_ids: selected_members
				},	
				url: og.makeAjaxUrl(og.getUrl('dimension', 'initial_list_dimension_members_tree')),
				dataType: "json",
				type: "POST",
				success: function(data){
					var combo = Ext.getCmp(genid + 'add-member-input-dim' + data.dimension_id);
					if (combo) {
						combo.disable();
						var store = [];
						for (x=0; x<data.dimension_members.length; x++) {
							dm = data.dimension_members[x];
							
							store[store.length] = [dm.id, dm.name, dm.path, dm.to_show, dm.ico, dm.dim];

							if(!member_selector[genid].members_dimension[dm.id]) {
								member_selector[genid].members_dimension[dm.id] = dm.dim;
							}
						}
						combo.reset();
						combo.store.removeAll();
						combo.store.loadData(store);
						combo.enable();
					}
            	}
            });
			
		}
	}
}


member_selector.remove_all_selections = function(genid) {
	for (dim_id in member_selector[genid].properties) {
		member_selector[genid].properties[dim_id];

		for (index in member_selector[genid].sel_context[dim_id]) {
			member_id = member_selector[genid].sel_context[dim_id][index];
			member_selector.remove_relation(dim_id, genid, member_id, true);
		}
		member_selector.reload_dependant_selectors(dim_id, genid);
	}
}

member_selector.set_selected = function(genid, member_ids) {
	for (dim_id in member_selector[genid].properties) {
		var combo = Ext.getCmp(genid + 'add-member-input-dim' + dim_id);
		for (x=0; x<member_ids.length; x++) {
			var store = combo.store;
			for (i=0; i<store.data.items.length; i++) {
				if (store.data.items[i].data.id == member_ids[x]) {
					member_selector.autocomplete_select(dim_id, genid, combo, store.data.items[i]);
				}
			}
		}
	}
	var member_ids_input = Ext.fly(Ext.get(genid + 'members'));
	member_ids_input.dom.value = Ext.util.JSON.encode(member_ids);
	member_selector.init(genid);
}



member_selector.init('<?php echo $genid; ?>');

</script>