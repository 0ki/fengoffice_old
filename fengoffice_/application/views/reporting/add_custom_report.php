<?php
require_javascript("og/DateField.js");
$genid = gen_id();
?>
<form style='height: 100%; background-color: white' class="internalForm"
	action="<?php echo $url  ?>" method="post"
	onsubmit="return og.validateReport('<?php echo $genid ?>');"><input
	type="hidden" name="report[object_type]" id="report[object_type]"
	value="<?php echo isset($report_data['object_type']) ? $report_data['object_type'] : "" ?>" />
<div class="coInputHeader">
<div class="coInputHeaderUpperRow">
<div class="coInputTitle">
<table style="width: 535px">
	<tr>
		<td><?php echo (isset($id) ? lang('edit custom report') : lang('new custom report')) ?>
		</td>
		<td style="text-align: right"><?php echo submit_button((isset($id) ? lang('save changes') : lang('add report')),'s',array('style'=>'margin-top:0px;margin-left:10px', 'tabindex' => '100')) ?></td>
	</tr>
</table>
</div>
</div>
<div>
<?php echo label_tag(lang('name'), $genid . 'reportFormName', true) ?>
<?php echo text_field('report[name]', array_var($report_data, 'name'),
array('id' => $genid . 'reportFormName', 'tabindex' => '1', 'class' => 'title')) ?>
<?php echo label_tag(lang('description'), $genid . 'reportFormDescription', false) ?>
<?php echo text_field('report[description]', array_var($report_data, 'description'),
array('id' => $genid . 'reportFormDescription', 'tabindex' => '2', 'class' => 'title')) ?>
<?php echo label_tag(lang('object type'), $genid . 'reportFormObjectType', true) ?>
<?php
$options = array();
foreach ($object_types as $type) {
	if ($selected_type == $type[0]) {
		$selected = 'selected="selected"';
	} else {
		$selected = '';
	}
	$options[] = '<option value="'.$type[0].'" '.$selected.'>'.$type[1].'</option>';
} 
?>
<?php $strDisabled = count($options) > 1 ? '' : 'disabled'; 
echo select_box('objectTypeSel', $options,
array('id' => 'objectTypeSel' ,'onchange' => 'og.objectTypeChanged("'.$genid.'", "", "")', 'style' => 'width:200px;', $strDisabled => '')) ?>

</div>
</div>
<div id="<?php echo $genid ?>MainDiv" class="coInputMainBlock" style="display:none;">
<fieldset><legend><?php echo lang('conditions') ?></legend>
<div id="<?php echo $genid ?>"></div>
<br />
<a href="#" class="link-ico ico-add"
	onclick="og.addCondition('<?php echo $genid ?>', 0, 0, '', '', '', false)"><?php echo lang('add condition')?></a>
</fieldset>

<fieldset><legend><?php echo lang('columns and order') ?></legend>
<div><?php echo label_tag(lang('order by'), $genid . 'reportFormOrderBy', true, array('id' => 'orderByLbl', 'style' => 'display:none;')) ?>
<?php echo select_box('report[order_by]', array(),
array('id' => 'report[order_by]', 'style' => 'width:200px;display:none;')) ?>
<br /><br />
<a href="#" onclick="og.toggleColumnSelection()"><?php echo 'Select/Unselect all'?></a>
<div id="columnList">
	<table>
		<tr>
			<td id="tdFields" style="padding-right:10px;"></td>
			<td id="tdCPs"></td>
		</tr>
	</table>
</div>
</div>
</fieldset>

<?php echo submit_button((isset($id) ? lang('save changes') : lang('add report')))?>

</div>

</form>

<script>
	var modified = false;
	var selectedObjTypeIndex = -1;
	var fieldValues = {};

	og.enterCondition = function(id) {
  		var deleted = document.getElementById('conditions[' + id + '][deleted]');
  	  	if(deleted && deleted.value == "0"){
			Ext.get('delete' + id).setVisible(true);
  	 	}
	};

	og.leaveCondition = function(id) {
		Ext.get('delete' + id).setVisible(false);
	};
	
	og.objectTypeChanged = function(genid, order_by, cols){
		var objectTypeSel = document.getElementById('objectTypeSel');
		if(modified){
			if(!confirm(lang('confirm discard changes'))){
				objectTypeSel.selectedIndex = selectedObjTypeIndex;
				return;
			}
		}
		modified = false;
		selectedObjTypeIndex = objectTypeSel.selectedIndex;
		if(selectedObjTypeIndex != -1){
			var conditionsDiv = Ext.getDom(genid);
			while(conditionsDiv.firstChild){
				conditionsDiv.removeChild(conditionsDiv.firstChild);
			}
			var type = objectTypeSel[selectedObjTypeIndex].value;
			if(type == ''){
				document.getElementById(genid + 'MainDiv').style.display = 'none';
				return;
			}
			document.getElementById('report[object_type]').value = type;
			og.openLink(og.getUrl('reporting', 'get_object_fields', {object_type: type}), {
				callback: function(success, data) {
					if (success) {
						var columnFields = document.getElementById('tdFields');
						var columnCPs = document.getElementById('tdCPs');
						var colArray = cols.split(',');
						if(data.fields.length > 0){
							var options = {}; 
							var orderByOptions = document.getElementById('report[order_by]').options;
							var fields = '';							
							var CPs = '';
							for(var i=0; i < data.fields.length; i++){
								var field = data.fields[i];
								orderByOptions[i] = new Option(field.name, field.id, false, (field.id == order_by));
								var checked = '';
								if(cols == ""){
									checked = 'checked';
								}else{
									for(var j=0; j < colArray.length; j++){
										if(colArray[j] == field.id) checked = 'checked';
									}
								}
								if(isNumeric(field.id)){
									CPs += '<br/><input type="checkbox" name="columns[]" id="columns[]" value="' + field.id + '" ' + checked + ' />&nbsp;' + og.clean(field.name);
								}else{
									fields += '<br/><input type="checkbox" name="columns[]" id="columns[]" value="' + field.id + '" ' + checked + ' />&nbsp;' + og.clean(field.name);
								} 		
							}
							orderByOptions.length = i;
							document.getElementById('report[order_by]').style.display = '';
							document.getElementById('orderByLbl').style.display = '';
							columnFields.innerHTML = fields;
							columnCPs.innerHTML = CPs;
						}else{
							document.getElementById('report[order_by]').style.display = 'none';
							document.getElementById('orderByLbl').style.display = 'none';
							columnFields.innerHTML = '';
							columnCPs.innerHTML = '';
						}			
					}
				},
				scope: this
			});
			document.getElementById(genid + 'MainDiv').style.display = '';
		}
	};

	og.addCondition = function(genid, id, cpId, fieldName, condition, value, is_parametrizable){
  		var type = document.getElementById('report[object_type]').value;
  		if(type == ""){
  	  		alert(lang('object type not selected'));
  	  		return;
  		}
		var condDiv = Ext.getDom(genid);
  		var count = condDiv.getElementsByTagName('table').length;
  		var classname = "";
  		if (count % 2 != 0) {
  			classname = "odd";
  		}
  		var style = 'style="width:130px;padding-right:10px;"';
  		var table = '<table onmouseover="og.enterCondition(' + count + ')" onmouseout="og.leaveCondition(' + count + ')"><tr>' +
  		'<td><input id="conditions[' + count + '][id]" name="conditions[' + count + '][id]" type="hidden" value="{0}"/></td>' +
  		'<td><input id="conditions[' + count + '][deleted]" name="conditions[' + count + '][deleted]" type="hidden" value="0"/></td>' +
  		'<td ' + style + ' id="tdFields' + count + '"></td>' +
  		'<td ' + style + ' id="tdConditions' + count + '"></td>' +
  		'<td ' + style + ' id="tdValue' + count + '"><b>' + lang('value') + '</b>:<br/>' +
  		'<input type="text" style="width:100px;" id="conditions[' + count + '][value]" name="conditions[' + count + '][value]" name="conditions[' + count + '][value]" value="{1}" ></td>' +
  		'<td ' + style + '><b>' + lang('parametrizable') + '</b>:<br/>' + 
  		'<input type="checkbox" onclick="og.changeParametrizable(' + count + ')" id="conditions[' + count + '][is_parametrizable]" name="conditions[' + count + '][is_parametrizable]" {2}></td>' +
		'<td style="padding-left:20px;"><div style="display:none;" id="delete' + count + '" class="clico ico-delete" onclick="og.deleteCondition(' + count + ',\'' + genid + '\')"></div></td>' +
		'<td id="tdDelete' + count + '" style="display:none;"><b>' + lang('condition deleted') +
		'</b><a class="internalLink" href="javascript:og.undoDeleteCondition(' + count + ',\'' + genid + '\')">&nbsp;(' + lang('undo') + ')</a></td>' +
	  	'</tr></table>';

  		table = String.format(table, id, value, (is_parametrizable == 1 ? "checked" : ""));

  		var newCondition = document.createElement('div');
  		newCondition.id = "Condition" + count;
  		newCondition.style.padding = "5px";
  		newCondition.className = classname;
  		newCondition.innerHTML = table;
  		condDiv.appendChild(newCondition);
  		og.openLink(og.getUrl('reporting', 'get_object_fields', {object_type: type}), {
			callback: function(success, data) {
				if (success) {
					var disabled = ((cpId > 0 || fieldName != '') ? 'disabled' : '');
					var fields = '<b>' + lang('field') + 
					'</b>:<br/><select onchange="og.fieldChanged(' + count + ', \'\', \'\')" id="conditions[' + count + '][custom_property_id]" name="conditions[' + count + '][custom_property_id]" ' + disabled ' >';					
					for(var i=0; i < data.fields.length; i++){
						var field = data.fields[i];
						if(id > 0 && (field.id != cpId && fieldName != field.id)) continue;
						fields += '<option value="' + field.id + '" class="' + field.type + '">' + field.name + '</option>';
						if(field.values){
							if(!fieldValues[count]){
								fieldValues[count] = {};
							}
							if(id == 0){
								fieldValues[count][i] = field.values;
							}else{
								fieldValues[count][0] = field.values;
							}
						}						
					}
					fields += '</select>';	
					if(cpId > 0){
						fields += '<input type="hidden" name="conditions[' + count + '][custom_property_id]" value="' + cpId + '">';
					}
					document.getElementById('tdFields' + count).innerHTML = fields;
					og.fieldChanged(count, (condition != "" ? condition : ""), (value != "" ? value : ""));	
					og.changeParametrizable(count);				
				}
			},
			scope: this
		});
		if(id == 0){
			modified = true;
		}
	};

	og.deleteCondition = function(id, genid){
		if(confirm(lang('delete condition confirmation'))){
			var conditionDiv = document.getElementById('Condition' + id);
			conditionDiv.style.background = '#FFDEAD';
			document.getElementById('tdDelete' + id).style.display = '';
			document.getElementById('conditions[' + id + '][deleted]').value = 1;
			modified = true;
  	  	}
	};

	og.undoDeleteCondition = function(id, genid){
  		document.getElementById('tdDelete' + id).style.display = 'none';
  		document.getElementById('conditions[' + id + '][deleted]').value = 0;
  		var conditionDiv = Ext.getDom(genid);
		for(var i=0; i < conditionDiv.childNodes.length; i++){
			var nextCond = conditionDiv.childNodes.item(i);
			if(nextCond.id == ('Condition' + id)){
				nextCond.style.background = '';
				if (i % 2 == 0) {
					nextCond.className = "";
		  		} else {
		  			nextCond.className = "odd";
		  		}
		  		return;
			}
		}
  	};

	og.fieldChanged = function(id, condition, value){
		var fields = document.getElementById('conditions[' + id + '][custom_property_id]');
		var selField = fields.selectedIndex;
		if(selField != -1){
			var fieldType = fields[selField].className;
			var type_and_name = '<input type="hidden" name="conditions[' + id + '][field_name]" value="' + fields[selField].value + '"/>' +
			'<input type="hidden" name="conditions[' + id + '][field_type]" value="' + fieldType + '"/>'; 
			
			var conditions = '<b>' + lang('condition') + '</b>:<br/><select class="select" id="conditions[' + id + '][condition]" name="conditions[' + id + '][condition]">';
			var textValueField = '<b>' + lang('value') + '</b>:<br/><input type="text" style="width:100px;" id="conditions[' + id + '][value]" name="conditions[' + id + '][value]" value="' + value + '"/>' + type_and_name;
			var dateValueField = '<b>' + lang('value') + '</b>:<br/>' + '<span id="containerConditions[' + id + '][value]"></span>' + type_and_name; 
			
			if(fieldType == "text"){
				document.getElementById('tdValue' + id).innerHTML = textValueField;
				conditions += '<option value="like">' + lang('like') + '</option>';
				conditions += '<option value="not like">' + lang('not like') + '</option>';
				conditions += '<option value="=">' + lang('equals') + '</option>';
				conditions += '<option value="<>">' + lang('not equals') + '</option>';
				conditions += '</select>';
				document.getElementById('tdConditions' + id).innerHTML = conditions;
			}else if(fieldType == "numeric"){
				document.getElementById('tdValue' + id).innerHTML = textValueField;
				conditions += '<option value=">">&gt;</option>';
				conditions += '<option value=">=">&ge;</option>';
				conditions += '<option value="<">&lt;</option>';
				conditions += '<option value="<=">&le;</option>';
				conditions += '<option value="=">=</option>';
				conditions += '<option value="<>"><></option>';
				conditions += '<option value="%">%</option>';
				conditions += '</select>';
				document.getElementById('tdConditions' + id).innerHTML = conditions;
			}else if(fieldType == "boolean"){
				var values = '<b>' + lang('value') + '</b>:<br/><select id="conditions[' + id + '][value]" name="conditions[' + id + '][value]">';
				values += '<option value="1" ' + (value != "" && value == true ? "selected" : "") + '>' + lang('true') + '</option>';
				values += '<option value="0"' + (value == false ? "selected" : "") + '>' + lang('false') + '</option>';
				values += '</select>' + type_and_name;
				document.getElementById('tdValue' + id).innerHTML = values;
				conditions += '<option value="=">' + lang('equals') + '</option>';
				conditions += '</select>';
				document.getElementById('tdConditions' + id).innerHTML = conditions;
			} else if(fieldType == "date"){
				document.getElementById('tdValue' + id).innerHTML = dateValueField;
				conditions += '<option value=">">&gt;</option>';
				conditions += '<option value=">=">&ge;</option>';
				conditions += '<option value="<">&lt;</option>';
				conditions += '<option value="<=">&le;</option>';
				conditions += '<option value="=">=</option>';
				conditions += '<option value="<>"><></option>';
				conditions += '</select>';
				document.getElementById('tdConditions' + id).innerHTML = conditions;
				
				var dateCond = new og.DateField({
					renderTo:'containerConditions[' + id + '][value]',
					name: 'conditions[' + id + '][value]',
					id: 'conditions[' + id + '][value]',
					value: Ext.util.Format.date(value, og.date_format)
				});
			}else if(fieldType == "list"){
				var valuesList = fieldValues[id][selField].split(',');
				var listValueField = '<b>' + lang('value') + '</b>:<br/><select style="width:100px;" id="conditions[' + id + '][value]" name="conditions[' + id + '][value]">';
				for(var i=0; i < valuesList.length; i++){
					listValueField += '<option ' + (valuesList[i] == value ? "selected" : "") + '>' + valuesList[i] + '</option>';
				}
				listValueField += '</select>' + type_and_name; 
				document.getElementById('tdValue' + id).innerHTML = listValueField;
				conditions += '<option value="=">=</option>';
				conditions += '<option value="<>"><></option>';
				conditions += '</select>';
				document.getElementById('tdConditions' + id).innerHTML = conditions;
			}
			
			var conditionSel = document.getElementById('conditions[' + id + '][condition]');
			for(var j=0; j < conditionSel.options.length; j++){ 
				if(conditionSel.options[j].value == condition){
					conditionSel.selectedIndex = j;
				}
			}
			if(condition == "") {
				document.getElementById('conditions[' + id + '][is_parametrizable]').checked = false;
				modified = true;
			}
		}
	};

	og.changeParametrizable = function(id){
		var parametrizable = document.getElementById('conditions[' + id + '][is_parametrizable]').checked;
		var valueField = document.getElementById('conditions[' + id + '][value]');
		valueField.disabled = parametrizable;
		modified = true;
	};

	og.validateReport = function(genid){
		var cpConditions = Ext.getDom(genid);
		for(var i=0; i < cpConditions.childNodes.length; i++){
			var deleted = document.getElementById('conditions[' + i + '][deleted]').value;
			var parametrizable = document.getElementById('conditions[' + i + '][is_parametrizable]').checked;
			if(deleted == "0" && !parametrizable){
				var fields = document.getElementById('conditions[' + i + '][custom_property_id]');
				var value = document.getElementById('conditions[' + i + '][value]').value;
				var fieldName = fields[fields.selectedIndex].text;
				if(value == ""){
					alert(lang('condition value empty', fieldName));
					return;
				}
				var fieldType = fields[fields.selectedIndex].className;
				var condition = document.getElementById('conditions[' + i + '][condition]').value;
				if(fieldType == 'numeric' && condition != '%' && !isNumeric(value)){
					alert(lang('condition value not numeric', fieldName));
					return;
				}
			}
		}
		var columns = document.getElementsByName('columns[]');
		var colSelected = false;
		for(var j=0; j < columns.length; j++){
			var item = columns[j];
			if(item.checked == true){
				colSelected = true;
				break;
			}
		}
		if(!colSelected){
			alert(lang('report cols not selected'));
			return false;
		}
		return true;
	};

	og.toggleColumnSelection = function(){
		var columns = document.getElementsByName('columns[]');
		var checked = document.getElementById('columns[]').checked;
		var columnFields = document.getElementById('tdFields');
		var columnCPs = document.getElementById('tdCPs');
		for(var i=0; i < columns.length; i++){
			columns[i].checked = (checked ? '' : 'checked');
		}
	};

	function isNumeric(sText){
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
	og.objectTypeChanged("<?php echo $genid ?>", "", "");
	<?php if(isset($conditions)){ ?>
		og.objectTypeChanged('<?php echo $genid?>', '<?php echo array_var($report_data, 'order_by') ?>', '<?php echo implode(',', $columns) ?>');
		<?php foreach($conditions as $condition){ ?>		
			og.addCondition('<?php echo $genid?>',<?php echo $condition->getId() ?>, <?php echo $condition->getCustomPropertyId() ?> , '<?php echo $condition->getFieldName() ?>', '<?php echo $condition->getCondition() ?>', '<?php echo $condition->getValue() ?>', '<?php echo $condition->getIsParametrizable() ?>');		
		<?php }//foreach ?>
	<?php }//if ?>		
</script>
