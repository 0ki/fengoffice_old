<?php
	if (!isset($genid)) $genid = gen_id();
	
	if ($description != '') echo clean($description) . '<br/>';
	$conditionHtml = '';
	
	if (count($conditions) > 0) {
		foreach ($conditions as $condition) {
			if($condition->getCustomPropertyId() > 0){
				if (!$object_type instanceof ObjectType) continue;
				
				if (in_array($object_type->getType(), array('dimension_object','dimension_group'))) {
					if (Plugins::instance()->isActivePlugin('member_custom_properties')) {
						$mcp = MemberCustomProperties::getCustomProperty($condition->getCustomPropertyId());
						$name = clean($mcp->getName());
						$paramName = $condition->getId()."_".$mcp->getName();
						$coltype = $mcp->getOgType();
					}
				} else {
					$cp = CustomProperties::getCustomProperty($condition->getCustomPropertyId());
					$name = clean($cp->getName());
					$paramName = $condition->getId()."_".$cp->getName();
					$coltype = $cp->getOgType();
				}
			}else{
				$name = lang('field ' . $model . ' ' . $condition->getFieldName());
					
				$coltype = array_key_exists($condition->getFieldName(), $types)? $types[$condition->getFieldName()]:'';
				$paramName = $condition->getFieldName();
				if (str_starts_with($coltype, 'DATE') && !$condition->getIsParametrizable()) {
					$cond_value = DateTimeValueLib::dateFromFormatAndString('m/d/Y', $condition->getValue())->format(user_config_option('date_format'));
					$condition->setValue($cond_value);
				}
			}
			$paramValue = isset($parameters[$paramName]) ? $parameters[$paramName] : '';
			$value = $condition->getIsParametrizable() ? clean($paramValue) : clean($condition->getValue());
			
			eval('$managerInstance = ' . $model . "::instance();");
			$externalCols = $managerInstance->getExternalColumns();
			if(in_array($condition->getFieldName(), $externalCols)){
				$value = clean(Reports::instance()->getExternalColumnValue($condition->getFieldName(), $value, $managerInstance));
			}
			if ($value != '') {
				$conditionHtml .= '- ' . $name . ' ' . ($condition->getCondition() != '%' ? $condition->getCondition() : lang('ends with') ) . ' ' . format_value_to_print($condition->getFieldName(), $value, $coltype, '', '"', user_config_option('date_format')) . '<br/>';
			}
		}
	}
	?>
	

<?php if ($conditionHtml != '') : ?>
<div style="float:left;">
	<div class="bold"><?php echo lang('conditions')?>:</div>
	<p style="padding-left:10px"><?php echo $conditionHtml; ?></p>
</div>
<?php endif; ?>

<?php if (count(active_context_members(false)) > 0) : ?>
<div style="margin-bottom: 10px; padding-bottom: 5px; float:left;<?php echo ($conditionHtml != '' ? "margin-left:35px;padding-left:35px;border-left:1px dotted #aaa;" : "")?>">
	<h5><?php echo lang('showing information for')?>:</h5>
	<ul>
	<?php
		$context = active_context();
		foreach ($context as $selection) :
			if ($selection instanceof Member) : ?>
				<li><span class="coViewAction <?php echo $selection->getIconClass()?>"><?php echo $selection->getName()?></span></li>	
	<?php 	endif;
		endforeach;
	?>
	</ul>
</div>
<?php endif; ?>

<div class="clear"></div>


<?php if (!isset($id)) $id= ''; ?>
<input type="hidden" name="id" value="<?php echo $id ?>" />
<input type="hidden" name="order_by" value="<?php echo $order_by ?>" />
<input type="hidden" name="order_by_asc" value="<?php echo $order_by_asc ?>" />

<?php 
	$params_url = isset($parametersURL) ? $parametersURL : "";
	$report = Reports::getReport($id);
	
	Env::useHelper('reporting');
	echo report_table_html($results, $report, $params_url);
	
	$pagination = array_var($results, 'pagination');
?>

<div style="margin-top: 10px;">
</div>
<?php
	if ($pagination) echo $pagination;

	if (isset($save_html_in_file) && $save_html_in_file) {
		$html = ob_get_clean();
		file_put_contents($html_filename, $html);
	}

