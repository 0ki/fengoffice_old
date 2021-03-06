<div style="display:none">
<!--  this select box will be cloned by the quick-add task forms  -->
<?php echo assign_to_select_box("task[assigned_to]", null, "0:0", array("id" => "og-task-new-assigned-to")) ?>
</div>

<script>
function filterTasks() {
	var to = Ext.getDom('og-task-filter-to').value;
	var status = Ext.getDom('og-task-filter-status').value;
	og.openLink(og.getUrl('task', 'index', {
		assigned_to: to,
		status: status 
	}));
}
</script>

<div style="padding:7px">



<table style="width:100%">
	<col width=12/><col width=226/><col width=12/>
	<tr><td class="coViewHeader" colspan=2 rowspan=2 style="background-color:#8181A1"><div class="coViewPropertiesHeader">
		<div class="og-tasks-actions">
	<table class="og-task-table-filter"><tr>
	<td class="td-buttons">
		<?php $butt_id = gen_id() ?>
		<div id="<?php echo $butt_id ?>" class="og-tasks-buttons">
		</div>
	</td>
	<td class="td-assigned-to">Show assigned to: <?php echo assign_to_select_box("assigned_to", null, $assignedTo, array("id" => "og-task-filter-to", "onchange" => "filterTasks()")); ?></td>
	<?php
		$option = array();
		$attrs1 = array();
		$attrs2 = array();
		if ($status == 'all' || $status == null) {
			$attrs1["selected"] = "selected"; 
		} else {
			$attrs2["selected"] = "selected";
		}
		$option[] = option_tag("All", "all", $attrs1);
		$option[] = option_tag("Pending", "pending", $attrs2);
		
	?>
	<td class="td-status">Show by status: <?php echo select_box("status", $option, array("id" => "og-task-filter-status", "onchange" => "filterTasks()")) ?></td>
	</tr></table>
	</div></td>
	<td class="coViewTopRight"></td></tr>
		
	<tr><td class="coViewRight" rowspan=2></td></tr>
	<tr><td class="coViewBody" colspan=2>
	
		<div style="og-tasks-container">
		
		</div>
		
		<script>
		var butt = new Ext.Button({
			renderTo: '<?php echo $butt_id ?>',
			iconCls: 'ico-new',
			text: lang('new'),
			menu: {items: [
				{text: lang('new milestone'), iconCls: 'ico-milestone', handler: function() {
					var url = og.getUrl('milestone', 'add');
					og.openLink(url);
				}},
				{text: lang('new task'), iconCls: 'ico-task', handler: function() {
					var url = og.getUrl('task', 'add_task');
					og.openLink(url);
				}}
			]}
		});
		</script>
		
		<div style="padding:7px;">
		<div class="tpMilestoneHeader"><?php echo lang('milestones') ?></div>
		
		<div id="og-milestones" class="og-milestones">
		<?php
		include "view_milestones.php";
		?>
		</div>
		
		<div class="tpTaskHeader"><?php echo lang('tasks') ?></div>
		
		<div id="og-sub-tasks-0" class="og-tasks">
		<?php
		include "view_tasks.php";
		?>
		</div>
		</div>
	</td></tr>
	
	<tr><td class="coViewBottomLeft"></td>
	<td class="coViewBottom"></td>
	<td class="coViewBottomRight"></td></tr>
	</table>
	
</div>
