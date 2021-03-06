<div id="userbox">
	<?php echo lang('welcome back', $_userbox_user->getDisplayName()) ?> (<a href="<?php echo get_url('access', 'logout') ?>"><?php echo lang('logout') ?></a>) : 
	<?php //if (logged_user()->isAdministrator()) { ?>
	<a class="internalLink" target="administration" href="<?php echo get_url('administration', 'index') ?>"><?php echo lang('administration') ?></a> |
	<?php //} ?>
	<a class="internalLink" target="account" href="<?php echo logged_user()->getAccountUrl() ?>"><?php echo lang('account') ?></a> |
	<a href="javascript:og.showHelp()"><?php echo lang('help') ?></a>
</div>