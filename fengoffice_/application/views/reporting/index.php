<?php 
	$genid = gen_id();
?>



<div style="padding:7px">
<table width=100% id="reportingMenu">
<tr>
<td height=12 width=140></td>
<td rowspan=6 colspan=2 style="background-color:white">

<div class="inner_report_menu_div" id="<?php echo $genid ?>activity" style="display:none">

</div>

<div class="inner_report_menu_div" id="<?php echo $genid ?>tasks" style="display:block">
<div class="report_header"><?php echo lang('time') ?></div>
<ul  style="padding-top:4px">
	<li><div><a style="font-weight:bold" class="internalLink" href="<?php echo get_url('reporting','total_task_times_p')?>"><?php echo lang('task time report') ?></a>
	<div style="padding-left:15px"><?php echo lang('task time report description') ?></div>
	</div>
	</li>
	<?php if (false) { ?><li><a class="internalLink" href="<?php echo get_url('reporting','total_task_times_vs_estimate_comparison_p')?>"><?php echo lang('estimate vs total task times report') ?></a></li><?php } ?>
</ul>
<br/>
<?php if (false) { ?><div class="report_header"><?php echo lang('activity') ?></div>
<ul>
	<li><a class="internalLink" href="<?php echo get_url('reporting','new_tasks')?>"><?php echo lang('new tasks by user') ?></a></li>
</ul>
</div><?php } ?>

<div class="inner_report_menu_div" id="<?php echo $genid ?>statistics" style="display:none">
</div>

<div class="inner_report_menu_div" id="<?php echo $genid ?>administration" style="display:none">
</div>

</td><td class="coViewTopRight"></td></tr>

<tr><td class="report_unselected_menu">
<a href="#" onclick="javascript:og.selectReportingMenuItem(this, '<?php echo $genid ?>activity')"><div style="width:120px"><?php echo lang('activity') ?></div></a>
</td><td class="coViewRight" rowspan=5></td></tr>


<tr><td class="report_selected_menu">
<a href="#" onclick="javascript:og.selectReportingMenuItem(this, '<?php echo $genid ?>tasks')"><div style="width:120px"><?php echo lang('tasks') ?></div></a>
</td></tr>


<tr><td class="report_unselected_menu">
<a href="#" onclick="javascript:og.selectReportingMenuItem(this, '<?php echo $genid ?>statistics')"><div style="width:120px"><?php echo lang('statistics') ?></div></a>
</td></tr>


<tr><td class="report_unselected_menu">
<a href="#" onclick="javascript:og.selectReportingMenuItem(this, '<?php echo $genid ?>administration')"><div style="width:120px"><?php echo lang('administration') ?></div></a>
</td></tr>



<tr><td rowspan=2 style="min-height:20px"></td></tr>
<tr><td class="coViewBottomLeft"></td>
	<td class="coViewBottom"></td>
	<td class="coViewBottomRight"></td>
</tr>
</table>

</div>