<div style="padding:10px">

<?php $step = 1; ?>

<b><?php echo lang('welcome to new account') ?></b><br/><hr/>
<?php echo lang('welcome to new account info', logged_user()->getDisplayName(), ROOT_URL) ?><br/><br/>

<?php if(logged_user()->isAccountOwner()){
		$step++;
		if(owner_company()->isInfoUpdated()) { ?>
  <p><b><del><?php echo lang('new account step1 owner') ?></del></b></p><br/>
<?php 	} else { ?>
  <b><?php echo lang('new account step1 owner') ?></b><br/><hr/>
  <?php echo lang('new account step1 owner info', get_url('company', 'edit_client', array('id' => owner_company()->getId())))?><br/><br/>
<?php } // if 
}?>

<?php if(User::canAdd(logged_user(), owner_company())){ 
	if(owner_company()->countUsers() > 1) { ?>
  <p><b><del><?php echo lang('new account step add members', $step) ?></del></b></p><br/>
<?php } else { ?>
  <b><?php echo lang('new account step add members', $step) ?></b><br/><hr/>
  <?php echo lang('new account step add members info', owner_company()->getAddUserUrl()) ?><br/><br/>
<?php } // if
	$step++;
} ?>

<?php if(count(logged_user()->getOwnProjects()) > 1) { ?>
  <p><b><del><?php echo lang('new account step start workspace', $step) ?></del></b></p><br/>
<?php } else { ?>
  <b><?php echo lang('new account step start workspace', $step) ?></b><br/><hr/>
  <?php echo lang('new account step start workspace info', get_url('project', 'add')) ?><br/><br/>
<?php } ?>
<?php $step++ ?>  

<?php if(logged_user()->isAccountOwner()) { ?>
  <b><?php echo lang('new account step configuration',$step) ?></b><br/><hr/>
  <?php echo lang('new account step configuration info', get_url('administration', 'configuration')) ?><br/><br/>
<?php  $step++;
} ?> 

<?php if(!logged_user()->isAccountOwner()) { 
	if(logged_user()->isInfoUpdated()) {?>
  <p><b><del><?php echo lang('new account step profile',$step) ?></del></b></p><br/>
<?php } else {?>
  <b><?php echo lang('new account step profile',$step) ?></b><br/><hr/>
  <?php echo lang('new account step profile info', get_url('account', 'edit_profile', array('id' => logged_user()->getId()))) ?><br/><br/>
<?php } ?>
<?php  $step++;
} ?> 

<?php if(!logged_user()->isAccountOwner()) {
	if(logged_user()->hasPreferencesUpdated()) {?>
  <p><b><del><?php echo lang('new account step preferences',$step) ?></del></b></p><br/>
<?php } else {?>
  <b><?php echo lang('new account step preferences',$step) ?></b><br/><hr/>
  <?php echo lang('new account step preferences info', get_url('user', 'list_user_categories')) ?><br/><br/>
<?php } ?>
<?php  $step++;
} ?> 

<b><?php echo lang('new account step actions',$step) ?></b><br/><hr/>

<?php echo lang('add a new')?>:

<image src='<?php echo image_url('/16x16/message.png')?> ' />&nbsp;
<a class='internalLink' href='<?php echo get_url('message', 'add')?> ' ><?php echo lang('message')?></a>&nbsp;|&nbsp;

<image src='<?php echo image_url('/16x16/types/contact.png')?> ' />&nbsp;
<a class='internalLink' href='<?php echo get_url('contact', 'add')?> ' ><?php echo lang('contact')?></a>&nbsp;|&nbsp;

<image src='<?php echo image_url('/16x16/companies.png')?> ' />&nbsp;
<a class='internalLink' href='<?php echo get_url('company', 'add_client')?> ' ><?php echo lang('company')?></a>&nbsp;|&nbsp;

<image src='<?php echo image_url('/16x16/types/event.png')?> ' />&nbsp;
<a class='internalLink' href='<?php echo get_url('event', 'add')?> ' ><?php echo lang('event')?></a>&nbsp;|&nbsp;

<image src='<?php echo image_url('/16x16/upload.png')?> ' />&nbsp;
<a class='internalLink' href='<?php echo get_url('files', 'add_file')?> ' ><?php echo lang('file')?></a>&nbsp;|&nbsp;

<image src='<?php echo image_url('/16x16/documents.png')?> ' />&nbsp;
<a class='internalLink' href='<?php echo get_url('files', 'add_document')?> ' ><?php echo lang('document')?></a>&nbsp;|&nbsp;

<image src='<?php echo image_url('/16x16/prsn.png')?> ' />&nbsp;
<a class='internalLink' href='<?php echo get_url('files', 'add_presentation')?> ' ><?php echo lang('presentation')?></a>&nbsp;|&nbsp;

<image src='<?php echo image_url('/16x16/milestone.png')?> ' />&nbsp;
<a class='internalLink' href='<?php echo get_url('milestone', 'add')?> ' ><?php echo lang('milestone')?></a>&nbsp;|&nbsp;

<image src='<?php echo image_url('/16x16/types/task.png')?> ' />&nbsp;
<a class='internalLink' href='<?php echo get_url('task', 'add_task')?> ' ><?php echo lang('task')?></a>&nbsp;|&nbsp;

<image src='<?php echo image_url('/16x16/types/webpage.png')?> ' />&nbsp;
<a class='internalLink' href='<?php echo get_url('webpage', 'add')?> ' ><?php echo lang('weblink')?></a>&nbsp;&nbsp;

<br/><br/><p><a class='internalLink' href='<?php echo get_url('config', 'remove_getting_started_widget')?> ' ><?php echo lang('remove this widget')?></a></p>
	
</div>