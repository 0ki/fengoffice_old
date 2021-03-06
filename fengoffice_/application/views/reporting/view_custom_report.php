<?php
	
	if ($description != '') echo clean($description) . '<br/>';
	$conditionHtml = '';
	
	if (count($conditions) > 0) {
		foreach ($conditions as $condition) {
			if($condition->getCustomPropertyId() > 0){
				$cp = CustomProperties::getCustomProperty($condition->getCustomPropertyId());
				$name = clean($cp->getName());
				$paramName = $condition->getId()."_".$cp->getName();
				$coltype = $cp->getOgType();
			}else{
				$name = lang('field ' . $model . ' ' . $condition->getFieldName());
					
				$coltype = array_key_exists($condition->getFieldName(), $types)? $types[$condition->getFieldName()]:'';
				$paramName = $condition->getFieldName();
			}
			$paramValue = isset($parameters[$paramName]) ? $parameters[$paramName] : '';
			$value = $condition->getIsParametrizable()? clean($paramValue) : clean($condition->getValue());
			
			eval('$managerInstance = ' . $model . "::instance();");
			$externalCols = $managerInstance->getExternalColumns();
			if(in_array($condition->getFieldName(), $externalCols)){
				$value = clean(Reports::instance()->getExternalColumnValue($condition->getFieldName(), $value, $managerInstance));
			}
			
			if ($value != '')
				$conditionHtml .= '- ' . $name . ' ' . ($condition->getCondition() != '%' ? $condition->getCondition() : lang('ends with') ) . ' ' . format_value_to_print($condition->getFieldName(), $value, $coltype, '', '"', user_config_option('date_format')) . '<br/>';
		}
	}
	
	?>
	
<div id="pdfOptions" style="display:none;">
	<b><?php echo lang('report pdf options') ?></b><hr/>
	<?php echo lang('report pdf page layout') ?>:
	<select name="pdfPageLayout">
		<option value="P" selected><?php echo lang('report pdf vertical') ?></option>
		<option value="L"><?php echo lang('report pdf landscape') ?></option>
	</select>&nbsp;&nbsp;
	<?php echo lang('report font size') ?>:
	<select name="pdfFontSize">
		<option value="8">8</option>
		<option value="9">9</option>
		<option value="10">10</option>
		<option value="11">11</option>
		<option value="12" selected>12</option>
		<option value="13">13</option>
		<option value="14">14</option>
		<option value="15">15</option>
		<option value="16">16</option>
	</select><br/>
	<input type="submit" name="exportPDF" value="<?php echo lang('export') ?>" onclick="document.getElementById('form<?php echo $genid ?>').target = '_download';" style="width:120px; margin-top:10px;"/>
</div>
<br/>

<?php
	if ($conditionHtml != '') {?>
<br/>
<b><?php echo lang('conditions')?>:</b><br/>
<p style="padding-left:10px">
	<?php echo $conditionHtml; ?>
</p>
<?php } // if ?>
<br/>
<?php if (!isset($id)) $id= ''; ?>
<input type="hidden" name="id" value="<?php echo $id ?>" />
<input type="hidden" name="order_by" value="<?php echo $order_by ?>" />
<input type="hidden" name="order_by_asc" value="<?php echo $order_by_asc ?>" />
<table>
<tr>
<?php foreach($columns as $col) {
	$sorted = false;
	$asc = false;
	if($col != '' && array_var($db_columns, $col) == $order_by) {
		$sorted = true;
		$asc = $order_by_asc;
	}	?>
	<td style="padding-right:10px;border-bottom:1px solid #666"><b>
	<?php if($to_print){ 	
			echo clean($col);
		  }else if($col != ''){ ?>
		<a href="<?php echo get_url('reporting', 'view_custom_report', array('id' => $id, 'replace' => true, 'order_by' => array_var($db_columns,$col), 'order_by_asc' => $asc ? 0 : 1)).$parameterURL; ?>"><?php echo clean($col) ?></a>
	<?php } ?>
	</b>
	<?php if(!$to_print && $sorted){ ?>
		<span class="db-ico ico-<?php echo $asc ? 'asc' : 'desc' ?>" style="padding:2px 0 0 18px;">&nbsp;</span>
	<?php } ?>
	</td>
<?php }?>
</tr>
<?php
	$isAlt = true; 
	foreach($rows as $row) {
		$isAlt = !$isAlt;
		$i = 0; 
?>
	<tr<?php echo ($isAlt ? ' style="background-color:#F4F8F9"' : "") ?>>
		<?php foreach($row as $k => $value) {
				$db_col = isset($db_columns[$columns[$i]]) ? $db_columns[$columns[$i]] : '';
			?>
			<td style="padding-right:10px;"><?php echo format_value_to_print($db_col, $value, ($k == 'link'?'':array_var($types, $k)), $model, '', user_config_option('date_format')) ?></td>
		<?php
			$i++; 
			} ?>
	</tr>
<?php } ?>
</table>

<br/><?php if (isset($pagination)) echo $pagination ?>
