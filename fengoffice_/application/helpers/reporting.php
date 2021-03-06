<?php

function report_table_csv($results, $report) {
	
	$columns = array_var($results, 'columns');
	$rows = array_var($results, 'rows');
	$pagination = array_var($results, 'pagination');
	
	$ot = ObjectTypes::findById($report->getObjectTypeId());
	
	$headers = array();
	foreach ($columns['order'] as $col) {
		if ($col == 'object_type_id' || $col == 'link') continue;
		$headers[] = $columns['names'][$col];
	}
	
	$all_csv_rows = array();
	foreach($rows as $row) {
		$values_array = array();
		
		foreach ($columns['order'] as $col) {
			if ($col == 'object_type_id' || $col == 'link') continue;
		
			$value = array_var($row, $col);
			
			$val_type = array_var($types, $col);
			$date_format = is_numeric($col) ? "Y-m-d" : user_config_option('date_format');
			
			if ($val_type == 'DATETIME') {
				$formatted_val = $value;
			} else {
				$formatted_val = format_value_to_print($col, $value, $val_type, array_var($row, 'object_type_id'), '', $date_format);
			}
			if ($formatted_val == '--') $formatted_val = "";
			
			$formatted_val = '"'. strip_tags($formatted_val) .'"';
			
			$values_array[] = $formatted_val;
		}
		$csv_row = implode(',', $values_array);
		$all_csv_rows[] = $csv_row;
	}
	$add_csv_rows = array();
	Hook::fire('get_additional_report_rows_csv', array('results' => $results, 'report_id' => $report->getId()), $add_csv_rows);
	if (count($add_csv_rows) > 0) {
		$all_csv_rows = array_merge($all_csv_rows, $add_csv_rows);
	}
	
	$csv = implode(',', $headers)."\n";
	$csv .= implode("\n", $all_csv_rows);
	
	return $csv;
}



function report_table_html($results, $report, $parametersUrl="", $to_print=false) {
	ob_start();
	
	$columns = array_var($results, 'columns');
	$rows = array_var($results, 'rows');
	$pagination = array_var($results, 'pagination');
	
	$ot = ObjectTypes::findById($report->getObjectTypeId());
	?>
	<table>
		<tr>
	<?php
		foreach ($columns['order'] as $col) {
			$sorted = false;
			$asc = false;
			
			if($col != 'link' && $col != 'located_under' && $col == $report->getOrderBy()) {
				$sorted = true;
				$asc = $report->getIsOrderByAsc();
			}
		?>
			<td style="padding-right:10px;border-bottom:1px solid #666" class="bold">
		<?php 
			if ($to_print) {
				
				echo clean(array_var($columns['names'], $col));
				
			} else if($col != 'link') {
				
			  	$allow_link = true;
			  	if ($ot instanceof Timeslot && in_array($col, ProjectTasks::instance()->getColumns())) {
			  		$allow_link = false;
			  	}
			  	$echo_link = $allow_link && !(is_numeric($col) || str_starts_with($col, "dim_") || $col == 'time' || $col == 'billing'); 
			  	?>
				<a href="<?php echo $echo_link ? get_url('reporting', 'view_custom_report', array('id' => $report->getId(), 'replace' => true, 'order_by' => $col, 'order_by_asc' => $asc ? 0 : 1)).$parametersUrl : "#" ?>" <?php echo ($echo_link ? "" : 'style="cursor:default;"') ?>>
					<?php echo clean(array_var($columns['names'], $col)) ?>
				</a>
		<?php }
			  if(!$to_print && $sorted){ ?>
				<span class="db-ico ico-<?php echo $asc ? 'asc' : 'desc' ?>" style="padding:2px 0 0 18px;">&nbsp;</span>
		<?php } ?>
			</td>
		<?php 
		}
		?>
		</tr>
	<?php
		$isAlt = true; 
		foreach($rows as $row) {
			$isAlt = !$isAlt;
			$i = 0; 
	?>
		<tr<?php echo ($isAlt ? ' style="background-color:#F4F8F9"' : "");?>>
		<?php
			foreach ($columns['order'] as $col) {
				if ($col == 'object_type_id') continue;
				
				$value = array_var($row, $col);
		?>
			<td style="padding-right:10px;">
		<?php 
				$val_type = ($col == 'link' ? '' : array_var($types, $col));
				$date_format = is_numeric($col) ? "Y-m-d" : user_config_option('date_format');
				if ($val_type == 'DATETIME') {
					echo $value;
				} else {
					echo format_value_to_print($col, $value, $val_type, array_var($row, 'object_type_id'), '', $date_format);
				}
		?>
			</td>
		<?php
				$i++;
			}
		?>
		</tr>
	<?php 
		} // end foreach rows
		
		$null=null; 
		Hook::fire('render_additional_report_rows', array('results' => $results, 'report_id' => $report->getId()), $null);
	?>
	</table>
	<?php
	
	return ob_get_clean();
}

