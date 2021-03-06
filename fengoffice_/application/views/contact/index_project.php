<?php

  set_page_title(lang('contacts'));
  if(Contact::canAdd(logged_user())) {
    add_page_action(lang('add contact'), get_url('contact', 'add_project'));
  } // if

?>
<?php if(isset($roles) && is_array($roles) && count($roles)) { ?>
<div id="contacts">
<table>
<tr><th style="width:120px"><?php echo lang('name') ?></th><th style="width:100px"><?php echo lang('role') ?></th>
<th style="width:100px"><?php echo lang('company') ?></th><th style="width:200px"><?php echo lang('email address') ?></th></tr>
<?php foreach($roles as $role) { 
    $contact = $role->getContact();
	if ($contact->canView(logged_user())) {?>
	<tr><td><a class="internalLink" href="<?php echo $contact->getCardURL() ?>"><?php echo $contact->getReverseDisplayName() ?></a></td>
	<td><?php echo $role->getRole(); ?></td>
	<td><?php if ($contact->hasCompany()) { ?>
	<a class="internalLink" href="<?php echo $contact->getCompany()->getViewURL() ?>"><?php echo $contact->getCompany()->getName() ?></a><?php } ?></td>
	<td><a class="internalLink" href="mailto:<?php echo $contact->getEmail() ?>"><?php echo $contact->getEmail() ?></a></td></tr>
<?php } else { ?> 
	<tr><td><span><?php echo $contact->getReverseDisplayName()?></span></td>
	<td><?php echo $role->getRole(); ?></td>
	<td><?php if ($contact->hasCompany()) { ?>
	<span><?php echo $contact->getCompany()->getName() ?></span><?php } ?></td>
	<td>--</td></tr>
<?php  } //if ?>
<?php } // foreach ?>
</table>
  <div id="projectContactsPaginationBottom"><?php echo advanced_pagination($roles_pagination, get_url('contact', 'index_project', array('page' => '#PAGE#'))) ?></div>
</div>
<?php } else { ?>
<p><?php echo lang('no contacts in project') ?></p>
<?php } // if ?>