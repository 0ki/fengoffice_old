<?php
	require_javascript('og/modules/doubleListSelCtrl.js');
		
	// build columm list
	$list = array();
	if (is_array($columns)) {
		foreach ($columns as $colid) {
			if ($colid != '') {
				$list[] = array(
					'id' => $colid,
					'text' => '',
					'selected' => true,
				);
			}
		}
	}
	$options = array();
	foreach ($allowed_columns as $acol) {
		$add = true;		
		foreach ($list as $k => $item) {
			if ($acol['id'] == $item['id'] ){
				$list[$k]['text'] = $acol['name'];
				$add = false;
				break;
			}
		}
		if ($add) {
			$list[] = array(
				'id' => $acol['id'],
				'text' => $acol['name'],
				'selected' => false,
			);
		}
		$options[] = option_tag($acol['name'], $acol['id'], $acol['id'] == $order_by ? array('selected' => 'selected') : null);
	}
	
	// Render Order By combos
	echo label_tag(lang('order by'), $genid . 'reportFormOrderBy', true, array('id' => 'orderByLbl'));
	echo select_box('report[order_by]', $options, array('id' => 'report[order_by]', 'style' => 'width:200px;'));
	$asc = option_tag(lang('ascending'), 'asc', $order_by_asc ? array('selected' => 'selected') : null);
	$desc = option_tag(lang('descending'), 'desc', !$order_by_asc ? array('selected' => 'selected') : null);
	echo select_box('report[order_by_asc]', array($asc, $desc), array('id' => 'report[order_by_asc]', 'style' => 'width:120px;')); 
	echo "<br /><br />";
	// Render Column lists
	echo label_tag(lang('columns to print'), 'columns');
	echo doubleListSelect("columns", $list, array('id' => $genid."columns", 'size' => 20));
	
	echo '<span class="desc">' . lang('columns to print desc') . '</span>'; 
?>