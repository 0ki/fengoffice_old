<?php
	function format_value_to_print($value, $type) {
		switch ($type) {
			case DATA_TYPE_STRING:
			case DATA_TYPE_INTEGER: $formatted = clean($value);
				break;
			case DATA_TYPE_BOOLEAN: $formatted = ($value == 1 ? lang('true') : lang('false'));
				break;
			case DATA_TYPE_DATE:
				if ($value != 0) { 
					$format = 'Y-m-d';
					if (str_ends_with($value, "00:00:00")) $format .= " H:i:s";
					$dtVal = DateTimeValueLib::dateFromFormatAndString($format, $value);
					$formatted = format_date($dtVal, null, 0);
				} else $formatted = '';
				break;
			case DATA_TYPE_DATETIME:
				if ($value != 0) {
					$dtVal = DateTimeValueLib::dateFromFormatAndString('Y-m-d H:i:s', $value);
					if (str_ends_with($value, "00:00:00")) $formatted = format_date($dtVal, null, 0);
					else $formatted = format_datetime($dtVal);
				} else $formatted = '';
				break;
			default: $formatted = clean($value);
		}
		
		return $formatted;
	}
?>
<br/>
<input type="hidden" name="id" value="<?php echo $id ?>" />
<table>
<tbody>
<tr>
<?php foreach($columns as $col) { ?>
	<td style="padding-right:10px;"><b><?php echo clean($col) ?></b></td>
<?php } //foreach?>
</tr>
<?php
	$isAlt = true; 
	foreach($rows as $row) {
		$isAlt = !$isAlt; 
?>
	<tr<?php echo ($isAlt ? ' style="background-color:#F4F8F9"' : "") ?>>
		<?php foreach($row as $k => $value) {?>
			<td style="padding-right:10px;"><?php echo format_value_to_print($value, $types[$k]) ?></td>
		<?php }//foreach ?>
	</tr>
<?php } //foreach ?>
</tbody>
</table>
