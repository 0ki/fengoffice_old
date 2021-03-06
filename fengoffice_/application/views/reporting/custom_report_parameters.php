<?php
	$genid = gen_id();
	$tiCount = 0;
	$firstId = '';
?>

<form style='height:100%;background-color:white' class="internalForm" action="<?php echo get_url('reporting', 'view_custom_report', array('id' => $id)) ?>" method="get">

<div class="coInputHeader">
	<div class="coInputHeaderUpperRow">
		<div class="coInputTitle"><?php echo $title ?></div>
	</div>
</div>
<div class="coInputSeparator"></div>
<div class="coInputMainBlock">

	<div style="width:600px;padding-bottom:20px"><?php echo $description ?></div>

	<table>
		<?php foreach($conditions as $condition){
			$tiCount ++;
			?>
			<tr style='height:30px;'>
			<?php if($condition->getCustomPropertyId() > 0){
					$cp = CustomProperties::getCustomProperty($condition->getCustomPropertyId());
					$name = $cp->getName();
				  }else{
					$name = $condition->getFieldName();	
				  } 
				  $condId = $genid . 'rpcond' . $condition->getId();
				if ($firstId == '')
					$firstId = $condId;
			?>
				<td><b><?php echo $name ?>:&nbsp;</b></td>
			<?php if(isset($cp)){ ?>
				<td align='left'>
					<?php if($cp->getType() == 'text' || $cp->getType() == 'numeric'){ ?>
						<input type="text" id="<?php echo $condId; ?>" name="params[<?php echo $condition->getId() ?>]" tabindex=<?php echo $tiCount?>/>
					<?php }else if($cp->getType() == 'boolean'){  ?>
						<select id="<?php echo $condId; ?>" name="params[<?php echo $condition->getId() ?>]" tabindex=<?php echo $tiCount?>>
							<option value="1" > <?php echo lang('true') ?>  </option>
							<option value="0" > <?php echo lang('false') ?> </option>
						</select>
					<?php }else if($cp->getType() == 'list'){  ?>
						<select id="<?php echo $condId; ?>" name="params[<?php echo $condition->getId() ?>]" tabindex=<?php echo $tiCount?>>
						<?php foreach(explode(',', $cp->getValues()) as $value){ ?>
							<option value="<?php echo $value ?>"> <?php echo $value ?>  </option>
						<?php }//foreach ?>
						</select>
					<?php }else if($cp->getType() == 'date'){  ?>
						<?php echo pick_date_widget2("params[".$cp->getName()."]",$genid,$tiCount)?>
					<?php }?>
				</td>
			<?php }else{ ?>
				<td align='left'>
				<?php 
					$model_instance = new $model();
					$col_type = $model_instance->getColumnType($condition->getFieldName());
					if ($col_type == DATA_TYPE_DATE || $col_type == DATA_TYPE_DATETIME) {
						echo pick_date_widget2("params[".$condition->getId()."]");
					} else {
				?>
					<input type="text" id="<?php echo $condId; ?>" name="params[<?php echo $condition->getId() ?>]" />
				<?php } ?>
				</td>
			<?php } ?>
			</tr>
		<?php }//foreach ?>
	</table>
	
<?php echo submit_button(lang('generate report'),'s',array('tabindex' => $tiCount + 1))?>	
</div>

<script type="text/javascript">
var firstCond = Ext.getDom('<?php echo $firstId ?>');
if (firstCond)
	firstCond.focus();
</script>

</form>