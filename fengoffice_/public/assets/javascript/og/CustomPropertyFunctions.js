var cpModified = false;
var selectedObjTypeIndex = -1;
og.isMemberCustomProperties = 0;

og.validateCustomProperties = function(genid){
	var cpDiv = Ext.getDom(genid);
	var cpNames = new Array();
	for(var i=0; i < cpDiv.childNodes.length; i++){
		var deleted = document.getElementById('custom_properties[' + i + '][deleted]').value;
		if(deleted == "0"){
			var name = document.getElementById('custom_properties[' + i + '][name]').value;
			if(name == ''){
				alert(lang('custom property name empty'));
				return false;
			}
			var type = document.getElementById('custom_properties[' + i + '][type]').value;
			var defaultValue = document.getElementById('custom_properties[' + i + '][default_value]').value;
			if(type == 'list'){
				var values = document.getElementById('custom_properties[' + i + '][values]').value;
				if(values == ''){
					alert(lang('custom property values empty', name));
					return false;
				}
				var valuesArray = values.split(',');
				var defaultValueOK = false;
				for(var j=0; j < valuesArray.length; j++){
					valuesArray[j] = valuesArray[j].trim();
					if(valuesArray[j] == defaultValue){
						defaultValueOK = true;
					}
				}
				if(defaultValue != '' && !defaultValueOK){
					alert(lang('custom property wrong default value', name));
					return false;
				}
				
			}else if(type == 'numeric'){
				if(!og.isNumeric(defaultValue)){
					alert(lang('custom property invalid numeric value', name));
					return false;
				}
			}
			for(var k=0; k < cpNames.length; k++){
				if(cpNames[k] == name){
					alert(lang('custom property duplicate name', name));
					return false;
				}
			}
			cpNames.push(name);
		}
	}
	return true;
};

og.isNumeric = function(sText){
   var ValidChars = "0123456789.";
   var IsNumber=true;
   var Char;
 
   for (i = 0; i < sText.length && IsNumber == true; i++){ 
      Char = sText.charAt(i); 
      if (ValidChars.indexOf(Char) == -1){
         IsNumber = false;
      }
   }
   return IsNumber;  	   
 }






og.saveObjectTypeCustomProperties = function(genid, save_url) {
	var ot = $("#"+genid+"_ot_id").val();

	var containers = [];
	for (var i=0; i<og.custom_props_table_genids.length; i++) {
		var gid = og.custom_props_table_genids[i];
		var tmp_cont = $(".cp-container."+gid);
		if (tmp_cont && tmp_cont.length > 0) {
			for (var k=0; k<tmp_cont.length; k++) {
				containers.push(tmp_cont[k]);
			}
		}
	}
	
	var custom_props = [];
	
	for (var i=0; i<containers.length; i++) {
		var cont = containers[i];

		var pre_id = "#" + cont.id;
		
		var del = $(pre_id + " #deleted").attr('value')
		var name = $(pre_id + " #name").attr('value');
		
		if (!del && name == '') {
			og.err(lang('custom property name empty'));
			return;
		} 
		
		var prop = {
				id: $(pre_id + " #id").attr('value'),
				deleted: del,
				name: name,
				type: $(pre_id + " #type").val(),
				description: $(pre_id + " #description").attr('value'),
				default_value: $(pre_id + " #default_value").attr('value'),
				default_value_bool: $(pre_id + " #default_value_bool").attr('checked') == 'checked',
				values: $(pre_id + " #values").attr('value'),
				is_special: $(pre_id + " #is_special").attr('value'),
				is_disabled: $(pre_id + " #is_disabled").attr('value'),
				is_required: $(pre_id + " #is_required").attr('checked') == 'checked',
				is_multiple_values: $(pre_id + " #is_multiple_values").attr('checked') == 'checked',
				visible_by_default: $(pre_id + " #visible_by_default").attr('checked') == 'checked'
		}

		// set additional parameters foreach cp
		if (og.additional_on_cp_submit_fn && og.additional_on_cp_submit_fn.length > 0) {
			for (var k=0; k<og.additional_on_cp_submit_fn.length; k++) {
				var add_func = og.additional_on_cp_submit_fn[k];
				if (typeof(add_func) == 'function') {
					prop = add_func.call(null, prop, pre_id);
				}
			}
		}
		
		custom_props.push(prop);
	}
	
	if (!save_url) {
		save_url = og.getUrl('administration', 'save_custom_properties_for_type');
	}

	og.openLink(save_url, {
		post: {
			ot_id: ot,
			custom_properties: Ext.util.JSON.encode(custom_props)
		}
	});
}



og.customPropTypeChanged = function(combo) {
	var container = $(combo).closest(".cp-container");
	if ($(combo).val() == 'list' || $(combo).val() == 'table') {
		$("#"+$(container).attr('id')+" #values").show();
		$("#"+$(container).attr('id')+" #values_hint").hide();
	} else {
		$("#"+$(container).attr('id')+" #values").hide();
		$("#"+$(container).attr('id')+" #values_hint").show();
	}
	
	if ($(combo).val() == 'boolean') {
		$("#"+$(container).attr('id')+" #default_value_bool").show();
		$("#"+$(container).attr('id')+" #default_value").hide();
	} else {
		$("#"+$(container).attr('id')+" #default_value_bool").hide();
		$("#"+$(container).attr('id')+" #default_value").show();
	}
}



og.disableSpecialCustomProperty = function(link) {
	var container = $(link).closest(".cp-container");

	$("#"+$(container).attr('id')+" #is_disabled").val(1);
	
	$("#"+$(container).attr('id')+" #enable_action").show();
	$("#"+$(container).attr('id')+" #disable_action").hide();

	$("#"+$(container).attr('id')+" #disabled_message").show();
	$(container).addClass('disabled');
}

og.deleteCustomProperty = function(link){
  	if(confirm(lang('delete custom property confirmation'))){

  		var container = $(link).closest(".cp-container");

		$("#"+$(container).attr('id')+" #deleted").val(1);
		
		$("#"+$(container).attr('id')+" #undo_delete_action").show();
		$("#"+$(container).attr('id')+" #delete_action").hide();

		$("#"+$(container).attr('id')+" #deleted_message").show();
		$(container).addClass('disabled');
		
  	}
};

og.undoDisableSpecialCustomProperty = function(link) {

	var container = $(link).closest(".cp-container");

	$("#"+$(container).attr('id')+" #is_disabled").val(0);
	
	$("#"+$(container).attr('id')+" #enable_action").hide();
	$("#"+$(container).attr('id')+" #disable_action").show();

	$("#"+$(container).attr('id')+" #disabled_message").hide();
	$(container).removeClass('disabled');
}

og.undoDeleteCustomProperty = function(link){
	
	var container = $(link).closest(".cp-container");

	$("#"+$(container).attr('id')+" #deleted").val(0);
	
	$("#"+$(container).attr('id')+" #undo_delete_action").hide();
	$("#"+$(container).attr('id')+" #delete_action").show();

	$("#"+$(container).attr('id')+" #deleted_message").hide();
	$(container).removeClass('disabled');
};

og.refreshTableRowsOrder = function(genid) {
	var containers = $(".cp-container."+genid);
	for (var i=0; i<containers.length; i++) {
		var cont = containers[i];

		if (i % 2 != 0) {
			$(cont).addClass("alt");
		} else {
			$(cont).removeClass("alt");
		}

		$("#" + cont.id + " #order").html(i+1);
		
	}
}



