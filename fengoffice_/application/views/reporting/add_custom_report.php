<?php
require_javascript("og/DateField.js");
require_javascript("og/ReportingFunctions.js");
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
$selected_option=null;
$options = array();
foreach ($object_types as $type) {
	if ($selected_type == $type[0]) {
		$selected = 'selected="selected"';
		$selected_option = $type[1];
	} else {
		$selected = '';
	}
	$options[] = '<option value="'.$type[0].'" '.$selected.'>'.$type[1].'</option>';
} 
?>
<?php $strDisabled = count($options) > 1 ? '' : 'disabled'; 
echo select_box('objectTypeSel', $options,
array('id' => 'objectTypeSel' ,'onchange' => 'og.reportObjectTypeChanged("'.$genid.'", "", 1, "")', 'style' => 'width:200px;', $strDisabled => '')) ?>

</div>
<div id="showhideOptions" style="padding-top:5px">
	<a href="#" class="option" onclick="og.toggleAndBolden('<?php echo $genid ?>add_creport_select_workspace_div',this)"><?php echo lang('workspace') ?></a> - 
	<a href="#" class="option" onclick="og.toggleAndBolden('<?php echo $genid ?>add_creport_add_tags_div', this)"><?php echo lang('tags') ?></a>
</div>
</div>
<div id="<?php echo $genid ?>MainDiv" class="coInputMainBlock" style="display:none;">

<div id="wsandTags">
<fieldset id="<?php echo $genid?>add_creport_select_workspace_div" style="display:none">
	<legend>
		<?php echo lang('workspace') ?>
	</legend>
	<div id="custom-report-ws<?php echo $genid ?>">
		
		<?php foreach($conditions as $condition){ 
			if ($condition->getFieldName()  == 'workspace'){
				$selected_ws = $condition->getValue();
				$parameter_ws = $condition->getIsParametrizable();
				$hidWs = '<input type="hidden" name="report[workspceid]" value="'. $condition->getId() . '" >';
				
			}//if
			if ( $condition->getFieldName()  == 'tag'){
				$selected_tag = $condition->getValue();
				$parameter_tag = $condition->getIsParametrizable();
				$hidTg = '<input type="hidden" name="report[tagid]" value="'. $condition->getId() . '" >';
			}//if
		}//foreach 
		echo $hidWs;
		echo '<div style="margin-top:5px; margin-right:5px; float:left;">' . select_project2('report[workspace]',(isset($selected_ws) ? $selected_ws:0 ), $genid , true).'</div>'; 
		echo '<div style="margin-top:5px;padding-top:3px; margin-right:5px; float:left;">' . checkbox_field('parametizable_ws',$parameter_ws) . lang('parametrizable') .'</div>';		
		 ?>
	</div>
</fieldset>

<fieldset id="<?php echo $genid?>add_creport_add_tags_div" style="display:none"><legend><?php echo lang('tags') ?></legend>
	<div id="custom-report-tags<?php echo $genid ?>">
			<?php
			echo $hidTg; 
			echo '<div style="margin-top:5px; margin-right:5px; float:left;">' . autocomplete_tags_field("report[tags]", (isset($selected_tag) ?$selected_tag:null ), null, 40) . '</div>';
			echo '<div  style="float: left; margin-top: 8px; margin-left: 5px;">' . checkbox_field('parametizable_tags',$parameter_tag) . lang('parametrizable') .'</div>';
		 ?>
	</div>
</fieldset>
</div>

<fieldset><legend><?php echo lang('conditions') ?></legend>
<div id="<?php echo $genid ?>"></div>
<br />
<a href="#" class="link-ico ico-add"
	onclick="og.addCondition('<?php echo $genid ?>', 0, 0, '', '', '', false)"><?php echo lang('add condition')?></a>
</fieldset>

<fieldset><legend><?php echo lang('columns and order') ?></legend>
<div><?php echo label_tag(lang('order by'), $genid . 'reportFormOrderBy', true, array('id' => 'orderByLbl', 'style' => 'display:none;')) ?>
<?php echo select_box('report[order_by]', array(),
array('id' => 'report[order_by]', 'style' => 'width:200px;display:none;'));
$asc = option_tag(lang('ascending'), 'asc');
$desc = option_tag(lang('descending'), 'desc');
echo select_box('report[order_by_asc]', array($asc, $desc),
array('id' => 'report[order_by_asc]', 'style' => 'width:200px;display:none;')) ?>
<br /><br />
<a href="#" onclick="og.toggleColumnSelection()"><?php echo lang('select unselect all')?></a>
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
	og.loadReportingFlags();
	og.reportObjectTypeChanged("<?php echo $genid ?>", "", 1, "");
	<?php if(isset($conditions)){ ?>
		og.reportObjectTypeChanged('<?php echo $genid?>', '<?php echo array_var($report_data, 'order_by') ?>', '<?php echo array_var($report_data, 'order_by_asc') ?>', '<?php echo (isset($columns) ? implode(',', $columns) : '') ?>');
		<?php foreach($conditions as $condition){ ?>
		<?php if ( $condition->getFieldName()  != 'workspace' && $condition->getFieldName()  != 'tag'){ ?>		
		    og.addCondition('<?php echo $genid?>',<?php echo $condition->getId() ?>, <?php echo $condition->getCustomPropertyId() ?> , '<?php echo $condition->getFieldName() ?>', '<?php echo $condition->getCondition() ?>', '<?php echo $condition->getValue() ?>', '<?php echo $condition->getIsParametrizable() ?>');		
		<?php 
			}//if
		}//foreach ?>
	<?php }//if ?>
</script>
