<?php
  set_page_title(lang('assign to project'));
  
  if($contact->canEdit(logged_user())) {
	add_page_action(lang('update picture'), $contact->getUpdatePictureUrl(), 'ico-picture');
    add_page_action(lang('edit contact'), $contact->getEditUrl(), 'ico-edit');
  } // if

  $genid = gen_id();
?>
<form style='height:100%;background-color:white' class="internalForm" action="<?php echo $contact->getAssignToProjectUrl($contact->getCardUrl()) ?>" method="post" enctype="multipart/form-data">

<div style="display: none">
<?php
$selected = array();
foreach ($projects as $project) {
	if (array_var($contact_data, 'pid_' . $project->getId())) {
		$selected[] = $project;
		echo checkbox_field("contact[pid_".$project->getId()."]", true, array("id" => "$genid"."_".$project->getId()));
	} else {
		echo checkbox_field("contact[pid_".$project->getId()."]", false, array("id" => "$genid"."_".$project->getId()));
	}
}
?>
</div> 

<div class="assignToProject">
<div class="coInputSeparator"></div>
<div class="coInputMainBlock adminMainBlock">

<table style="min-width:400px;margin-top:10px;"><tr>
	<th></th>
	<th style="padding-left: 5px"><h2><?php echo lang('project') ?></h2></th>
	<th style="padding-left: 5px"><h2><?php echo lang('role') ?></h2></th>
	</tr>
	<tr>
	<td style="padding: 5px;"></td>
	<td style="padding: 5px;">
	<?php echo select_workspaces("ws_ids", $projects, $selected, $genid); ?>
	</td>
	<td style="padding: 5px;">  
<?php
echo "<p>".lang("assign contact to workspace desc")."</p><br />";
foreach ($projects as $project) {
	echo '<div id="role_' . $project->getId() . '_' . $genid . '" style="display:none">';
	echo label_tag(lang("role"), null, false, array("style" => "display:inline;padding-right:10px"));
	echo text_field("contact[role_pid_".$project->getId()."]", array_var($contact_data, 'role_pid_' . $project->getId()));
	echo '</div>';
} ?>	
	</td>
</table>
<?php echo submit_button(lang('update contact')) ?>
</div>
</div>
</div>

</form>

<script type="text/javascript">
var wsch = Ext.getCmp('<?php echo $genid ?>');
wsch.on("wsselected", function(ws) {
		if (this.visibleField) {
			this.visibleField.style.display = 'none';
		}
		if (ws.checked) {
			this.visibleField = Ext.getDom('role_' + ws.id + '_' + this.id);
			this.visibleField.style.display = 'block';
		}
	}, wsch);
wsch.on("wschecked", function(ws) {
		var checkbox = Ext.getDom(this.id + "_" + ws.id);
		if (ws.checked) {
			if (this.visibleField) {
				this.visibleField.style.display = 'none';
			}
			checkbox.checked = "checked";
			this.visibleField = Ext.getDom('role_' + ws.id + '_' + this.id);
			this.visibleField.style.display = 'block';
		} else {
			Ext.getDom('role_' + ws.id + '_' + this.id).style.display = 'none';
			this.visibleField = null;
			checkbox.checked = "";
		}
	}, wsch);
</script>