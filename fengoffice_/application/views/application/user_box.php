<div id="userbox">
  <?php echo lang('welcome back', $_userbox_user->getDisplayName()) ?> (<a href="<?php echo get_url('access', 'logout') ?>" onclick="return confirm('<?php echo lang('confirm logout') ?>')"><?php echo lang('logout') ?></a>) : 
  <a class="internalLink" href="<?php echo logged_user()->getAccountUrl() ?>"><?php echo lang('account') ?></a> |
  <a href="javascript:og.showHelp()"><?php echo lang('help') ?></a>
</div>