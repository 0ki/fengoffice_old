<?php
  set_page_title(lang('assign to project'));
  
  if($contact->canEdit(logged_user())) {
	add_page_action(lang('update picture'), $contact->getUpdatePictureUrl(), 'ico-picture');
    add_page_action(lang('edit contact'), $contact->getEditUrl(), 'ico-edit');
  } // if

?>
<form class="internalForm" action="<?php echo $contact->getAssignToProjectUrl($contact->getCardUrl()) ?>" method="post" enctype="multipart/form-data">

<?php tpl_display(get_template_path('form_errors')) ?>

<table><tr>
	<th></th>
	<th style="padding-left: 5px"><h2><?php echo lang('project') ?></h2></th>
	<th style="padding-left: 5px"><h2><?php echo lang('role') ?></h2></th>
	</tr>
  
<?php foreach ($projects as $project) {?>
  <tr style="padding-top:3px;vertical-align:middle"><td style="padding-top:3px"><?php echo checkbox_field('contact[pid_'.$project->getId().']', array_var($contact_data, 'pid_' . $project->getId()), array('id' => 'assignFormProjectChk'.$project->getId()) ); ?></td>		
  <td style="padding-left: 5px; padding-top:3px"><h2><?php echo $project->getName() ?></h2></td>
  <td style="padding-left: 5px; padding-top:1px"><?php echo text_field('contact[role_pid_'.$project->getId().']', array_var($contact_data, 'role_pid_' . $project->getId()), array('id' => 'assignFormProjectRole'.$project->getId())) ?></td>
  </tr>
<?php } ?>	
  </table>
  <?php echo submit_button(lang('update contact')) ?>
  
</form>