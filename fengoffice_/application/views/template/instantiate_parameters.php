<?php $genid = gen_id() ?>
<form style='height:100%;background-color:white' class="internalForm" action="<?php echo get_url('template', 'instantiate_parameters', array('id' => $id)) ?>" method="post">

<div class="template">
<div class="coInputHeader">
	<div class="coInputHeaderUpperRow">
		<div class="coInputTitle">Template Parameters</div>
	</div>
	<div style="padding-top:5px">
		<a href="#" class="option" onclick="og.toggleAndBolden('<?php echo $genid ?>parameters_select_workspace_div', this)"><?php echo lang('workspace') ?></a> -
		<a href="#" class="option" onclick="og.toggleAndBolden('<?php echo $genid ?>parameters_tags_div', this)"><?php echo lang('tags') ?></a>
	</div>
</div>
<div class="coInputMainBlock">
	<div id="<?php echo $genid ?>parameters_select_workspace_div" style="display:none">
	<fieldset>
	<legend><?php echo lang('workspace') ?></legend>
		<?php echo select_project2('project_id', $id, $genid) ?>
	</fieldset>
	</div>

	<div id="<?php echo $genid ?>parameters_tags_div" style="display:none">
	<fieldset>
	<legend><?php echo lang('tags') ?></legend>
		<?php echo autocomplete_tags_field('tags', '', 'tags') ?>
	</fieldset>
	</div>
	<div>
		<table><tbody>
		<?php foreach($parameters as $parameter) {?>
			<tr style='height:30px;'>
				<td style="padding:3px 10px 0 10px;"><b><?php echo $parameter['name']; ?></b></td>
				<td align="left">
					<?php if($parameter['type'] == 'string'){ ?>
						<input id="parameterValues[<?php echo $parameter['name'] ?>]" name="parameterValues[<?php echo $parameter['name'] ?>]" />
					<?php }else{ ?>
						<?php echo pick_date_widget2('parameterValues['.$parameter['name'].']')?>
					<?php }?>
				</td>
			</tr>
		<?php }//foreach ?>
		</tbody></table>
	</div>
	<br/>
	<div>
	<?php echo submit_button('Instantiate','s',	array('style'=>'margin-top:0px', 'tabindex' => '3')) ?>
	</div>	
</div>
</div>
</form>