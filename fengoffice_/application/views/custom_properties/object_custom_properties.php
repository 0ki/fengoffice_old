<?php
$include_script = false;
$cps = CustomProperties::getAllCustomPropertiesByObjectType($type);
$ti = 0;
if (!isset($genid))
	$genid = gen_id();
if (!isset($startTi))
	$startTi = 20000;
if(count($cps) > 0){
	foreach($cps as $customProp){
		if(!isset($required) || ($required && $customProp->getIsRequired()) || (!$required && !$customProp->getIsRequired())){
			$ti++;
			$cpv = CustomPropertyValues::getCustomPropertyValue($_custom_properties_object->getId(), $customProp->getId());
			$default_value = $customProp->getDefaultValue();
			if($cpv instanceof CustomPropertyValue){
				$default_value = $cpv->getValue();
			}
			$name = 'object_custom_properties['.$customProp->getId().']';
			echo '<div style="margin-top:6px">';

			if ($customProp->getType() == 'boolean')
				echo checkbox_field($name, $default_value, array('tabindex' => $startTi + $ti, 'style' => 'margin-right:4px', 'id' => $genid . 'cp' . $customProp->getName()));
			
			echo label_tag(clean($customProp->getName()), $genid . 'cp' . $customProp->getName(), $customProp->getIsRequired(), array('style' => 'display:inline'), $customProp->getType() == 'boolean'?'':':');
			if ($customProp->getDescription() != ''){
				echo '<span class="desc" style="margin-left:10px">- ' . clean($customProp->getDescription()) . '</span>';
			}
			echo '</div>';
			
			switch ($customProp->getType()) {
				case 'text':
				case 'numeric':  
					if($customProp->getIsMultipleValues()){
						echo "<input type='hidden' id='$name' name='$name' value='" . clean($default_value) . "' />";
						$numeric = ($customProp->getType() == "numeric");
						echo "<table><tr><td>";
						echo text_field('field'.$customProp->getId(), '', array('tabindex' => $startTi + $ti, 'id' => 'field'.$customProp->getId()));
						echo "</td><td>";
						echo '&nbsp;<a href="#" class="link-ico ico-add" onclick="og.addCPValue('.$customProp->getId().',\''."list-".$name.'\','.($numeric?'true':'false').')">'.lang('add value').'</a><br/>';
						echo "</td></tr><tr><td>";
						$options = array();
						foreach(explode(',', $default_value) as $value){
							if($value != '') $options[] = '<option value="'. clean($value) .'">'. clean($value).'</option>';
						}				
						echo select_box("list-".$name, $options, array('size' => '3', 'style' => 'width:210px;', 'id' => "list-".$name, 'multiple' => 'multiple'));
						echo "</td><td>";
						echo '&nbsp;<a href="#" class="link-ico ico-delete" onclick="og.removeCPValue(\''."list-".$name.'\')">'.lang('remove value').'</a><br/>';
						echo "</td></tr></table>";
						$include_script = true;
					}else{
						echo text_field($name, $default_value, array('tabindex' => $startTi + $ti));
					}
					break;
				case 'boolean':
					break;
				case 'date':
					// dates from table are saved as a string in "Y-m-d H:i:s" format
					$value = DateTimeValueLib::dateFromFormatAndString("Y-m-d H:i:s", $default_value);
					echo pick_date_widget2($name, $value, null, $startTi + $ti);
					break;
				case 'list':
					$options = array();
					if(!$customProp->getIsRequired()){
						$options[] = '<option value=""></option>';
					}
					$totalOptions = 0;
					foreach(explode(',', $customProp->getValues()) as $value){
						$selected = ($value == $default_value) || ($customProp->getIsMultipleValues() && in_array($value, explode(',', $default_value)));
						if($selected){
							$options[] = '<option value="'. clean($value) .'" selected>'. clean($value) .'</option>';
						}else{
							$options[] = option_tag($value, $value);
						}
						$totalOptions++;
					}
					if($customProp->getIsMultipleValues()){
						$name .= '[]';
						echo select_box($name, $options, array('tabindex' => $startTi + $ti, 'style' => 'min-width:140px',  'size' => $totalOptions, 'multiple' => 'multiple'));
					}else{
						echo select_box($name, $options, array('tabindex' => $startTi + $ti, 'style' => 'min-width:140px'));
					}
					break;
				default: break;
			}
		}
	}
}
if ($include_script) require_javascript("og/CustomProperties.js");
?>

