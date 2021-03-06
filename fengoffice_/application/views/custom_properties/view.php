<?php
	$properties = $__properties_object->getCustomProperties();	
	$cpvCount = CustomPropertyValues::getCustomPropertyValueCount($__properties_object->getId(), get_class($__properties_object->manager()));
	if ((!is_array($properties) || count($properties) == 0) && $cpvCount == 0) 
		return "";
?>
<div class="commentsTitle"><?php echo lang('custom properties')?></div>
<?php if($cpvCount > 0){?>
<table class="og-custom-properties">
<?php 
	$cps = CustomProperties::getAllCustomPropertiesByObjectType(get_class($__properties_object->manager()));
	foreach($cps as $customProp){ 
		$cpv = CustomPropertyValues::getCustomPropertyValue($__properties_object->getId(), $customProp->getId());
		if($cpv instanceof CustomPropertyValue && ($customProp->getIsRequired() || $cpv->getValue() != '')){?>
			<tr>
				<td class="name" title="<?php echo clean($customProp->getName()) ?>">- <?php echo clean(truncate($customProp->getName(), 20)) ?>:&nbsp;</td>
				<?php
					// dates are in standard format "Y-m-d H:i:s", must be formatted
					if ($customProp->getType() == 'date') {
						$dtv = DateTimeValueLib::dateFromFormatAndString("Y-m-d H:i:s", $cpv->getValue());
						$value = $dtv->format(user_config_option('date_format', 'd/m/Y'));
					} else {
						$value = $cpv->getValue();
					}
				?>
				<td title="<?php echo clean($value) ?>"><?php echo clean(truncate($value,30)) ?></td>
			</tr>
		<?php } // if
	} // foreach ?>
</table>
<?php } // if
	
// Draw flexible custom properties
if (is_array($properties) && count($properties) > 0){ ?>
	<table class="og-custom-properties">
	<?php foreach ($properties as $prop) {?>
		<tr>
			<td class="name" title="<?php echo $prop->getPropertyName() ?>">- <?php echo truncate($prop->getPropertyName(), 12) ?>:&nbsp;</td>
			<td title="' . $prop->getPropertyValue() . '"><?php echo truncate($prop->getPropertyValue(), 12) ?></td>
		</tr>
	<?php } // foreach ?>
	</table>
<?php } // if ?>
</div>