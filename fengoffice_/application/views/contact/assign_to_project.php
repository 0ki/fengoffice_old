<?php
  set_page_title(lang('assign to project'));
  
  if($contact->canEdit(logged_user())) {
	add_page_action(lang('update picture'), $contact->getUpdatePictureUrl(), 'ico-picture');
    add_page_action(lang('edit contact'), $contact->getEditUrl(), 'ico-edit');
  } // if

  $genid = gen_id();
?>
<form style='height:100%;background-color:white' class="internalForm" action="<?php echo $contact->getAssignToProjectUrl($contact->getCardUrl()) ?>" method="post" enctype="multipart/form-data">

<?php
$selected = array();
foreach ($projects as $project) {
	if (array_var($contact_data, 'pid_' . $project->getId())) {
		$selected[] = $project;
	}
}
?>
<?php /*echo select_workspaces("ws_ids", $projects, $selected, $genid); ?>
<input type="hidden" name="ws_roles" values="" />
<script type="text/javascript">
var wsch = Ext.getCmp('<?php echo $genid ?>');
wsch.on({
	"wsselect": {
	},
	"wscheck"
}); 
</script>*/ ?>

  
<div class="assignToProject">
<div class="coInputSeparator"></div>
<div class="coInputMainBlock adminMainBlock">

<table style="min-width:400px;margin-top:10px;"><tr>
	<th></th>
	<th style="padding-left: 5px"><h2><?php echo lang('project') ?></h2></th>
	<th style="padding-left: 5px"><h2><?php echo lang('role') ?></h2></th>
	</tr>
  
<?php $isAlt = true;
foreach ($projects as $project) {
	$isAlt = !$isAlt;?>
  <tr class="<?php echo $isAlt? 'altRow' : ''?>" style="padding-top:3px;vertical-align:middle"><td style="padding-top:3px"><?php echo checkbox_field('contact[pid_'.$project->getId().']', array_var($contact_data, 'pid_' . $project->getId()), array('id' => 'assignFormProjectChk'.$project->getId()) ); ?></td>		
  <td style="padding-left: 5px; padding-top:3px"><?php echo clean($project->getName()) ?></td>
  <td style="padding-left: 5px; padding-top:1px"><?php echo text_field('contact[role_pid_'.$project->getId().']', array_var($contact_data, 'role_pid_' . $project->getId()), array('id' => 'assignFormProjectRole'.$project->getId())) ?></td>
  </tr>
<?php } ?>	
  </table>
  <?php echo submit_button(lang('update contact')) ?>
</div>
</div>
</form>