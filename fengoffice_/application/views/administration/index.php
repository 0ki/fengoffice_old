<?php 
  set_page_title(lang('administration'));
?>
<div class="adminIndex" style="height:100%;background-color:white">
  <div class="adminHeader">
  	<div class="adminTitle"><?php echo lang('administration') ?></div>
  </div>
  <div class="adminSeparator"></div>
  <div class="adminMainBlock">
    <?php echo lang('welcome to administration info') ?>
    <br/>
    <br/>
    
<div style="width:100%;max-width:700px; text-align:center">
    <table><tr>
<?php if(can_edit_company_data(logged_user())){ ?>
<td align="center">
    <div style="width:150px;display:block; margin-right:10px;margin-bottom:40px">
    <table width="100%" align="center"><tr><td align="center">
    	<a class="internalLink" href="<?php echo get_url('administration', 'company') ?>"><div class="coViewIconImage ico-large-company"></div></a>
    </td></tr><tr><td align="center"><b><a class="internalLink" href="<?php echo get_url('administration', 'company') ?>"><?php echo lang('owner company') ?></a></b>
    </td></tr></table>
    </div>
</td>
<?php } ?>

<?php if(can_manage_security(logged_user())){ ?>
<td align="center">
    <div style="width:150px;display:block; margin-right:10px;margin-bottom:40px">
    <table width="100%" align="center"><tr><td align="center">
    	<a class="internalLink" href="<?php echo get_url('administration', 'clients') ?>"><div class="coViewIconImage ico-large-company"></div></a>
    </td></tr><tr><td align="center"><b><a class="internalLink" href="<?php echo get_url('administration', 'clients') ?>"><?php echo lang('client companies') ?></a></b>
    	<br/><a class="internalLink coViewAction ico-add" href="<?php echo get_url('company', 'add_client') ?>"><?php echo lang('add client') ?></a>
    	</td></tr></table>
    </div>
</td>
<?php } ?>

<?php if(can_edit_company_data(logged_user())){ ?>
<td align="center">
    <div style="width:150px;display:block; margin-right:10px;margin-bottom:40px">
    <table width="100%" align="center"><tr><td align="center">
    	<a class="internalLink" href="<?php echo get_url('administration', 'members') ?>"><div class="coViewIconImage ico-large-user"></div></a>
    </td></tr><tr><td align="center"><b><a class="internalLink" href="<?php echo get_url('administration', 'members') ?>"><?php echo lang('users') ?></a></b>
    	<br/><a class="internalLink coViewAction ico-add" href="<?php echo owner_company()->getAddUserUrl() ?>"><?php echo lang('add user') ?></a>
    </td></tr></table>
    </div>
</td>
<?php } ?>

<?php if(can_manage_security(logged_user())){ ?>
<td align="center">
    <div style="width:150px;display:block; margin-right:10px;margin-bottom:40px">
    <table width="100%" align="center"><tr><td align="center">
    	<a class="internalLink" href="<?php echo get_url('administration', 'groups') ?>"><div class="coViewIconImage ico-large-group"></div></a>
    </td></tr><tr><td align="center"><b><a class="internalLink" href="<?php echo get_url('administration', 'groups') ?>"><?php echo lang('groups') ?></a></b>
    	<br/><a class="internalLink coViewAction ico-add" href="<?php echo owner_company()->getAddGroupUrl() ?>"><?php echo lang('add group') ?></a>
    </td></tr></table>
    </div>
</td>
<?php } ?>

</tr></table>


<table>
<tr>
<?php if(can_manage_workspaces(logged_user())){ ?>
<td align="center">
    <div style="width:150px;display:block; margin-right:10px;margin-bottom:40px">
    <table width="100%" align="center"><tr><td align="center">
    	<a class="internalLink" href="<?php echo get_url('administration', 'projects') ?>"><div class="coViewIconImage ico-large-workspace"></div></a>
    </td></tr><tr><td align="center"><b><a class="internalLink" href="<?php echo get_url('administration', 'projects') ?>"><?php echo lang('projects') ?></a></b>
    	<br/><a class="internalLink coViewAction ico-add" href="<?php echo get_url('project', 'add') ?>"><?php echo lang('add project') ?></a>
    </td></tr></table>
    </div>
</td>
<td align="center">
    <div style="width:150px;display:block; margin-right:10px;margin-bottom:40px">
    <table width="100%" align="center"><tr><td align="center">
    	<a class="internalLink" href="<?php echo get_url('administration', 'task_templates') ?>"><div class="coViewIconImage ico-large-tasks"></div></a>
    </td></tr><tr><td align="center"><b><a class="internalLink" href="<?php echo get_url('administration', 'task_templates') ?>"><?php echo lang('task templates') ?></a></b>
    	<br/><a class="internalLink coViewAction ico-add" href="<?php echo get_url('task','add_task',array('is_template'=>'true')) ?>"><?php echo lang('add task template') ?></a>
    </td></tr></table>
    </div>
</td>
<?php } ?>
</tr></table>

<table>
<tr>
<?php if(can_manage_configuration(logged_user())){ ?>
<td align="center">
    <div style="width:150px;display:block; margin-right:10px;margin-bottom:40px">
    <table width="100%" align="center"><tr><td align="center">
    	<a class="internalLink" href="<?php echo get_url('administration', 'configuration') ?>"><div class="coViewIconImage ico-large-configuration"></div></a>
    </td></tr><tr><td align="center"><b><a class="internalLink" href="<?php echo get_url('administration', 'configuration') ?>"><?php echo lang('configuration') ?></a></b>
    </td></tr></table>
    </div>
</td>
<td align="center">
    <div style="width:150px;display:block; margin-right:10px;margin-bottom:40px">
    <table width="100%" align="center"><tr><td align="center">
    	<a class="internalLink" href="<?php echo get_url('administration', 'tools') ?>"><div class="coViewIconImage ico-large-tools"></div></a>
    </td></tr><tr><td align="center"><b><a class="internalLink" href="<?php echo get_url('administration', 'tools') ?>"><?php echo lang('administration tools') ?></a></b>
    </td></tr></table>
    </div>
</td>
<td align="center">
    <div style="width:150px;display:block; margin-right:10px;margin-bottom:40px">
    <table width="100%" align="center"><tr><td align="center">
    	<a class="internalLink" href="<?php echo get_url('administration', 'upgrade') ?>"><div class="coViewIconImage ico-large-upgrade"></div></a>
    </td></tr><tr><td align="center"><b><a class="internalLink" href="<?php echo get_url('administration', 'upgrade') ?>"><?php echo lang('upgrade') ?></a></b>
    </td></tr></table>
    </div>
</td>

<?php if(logged_user()->isAccountOwner()){ ?>
<td align="center">
    <div style="width:150px;display:block; margin-right:10px;margin-bottom:40px">
    <table width="100%" align="center"><tr><td align="center">
    	<a class="internalLink" href="<?php echo get_url('backup') ?>"><div class="coViewIconImage ico-large-backup"></div></a>
    </td></tr><tr><td align="center"><b><a class="internalLink" href="<?php echo get_url('backup') ?>"><?php echo lang('backup') ?></a></b>
    </td></tr></table>
    </div>
</td>
<?php } } ?>
</tr></table>
</div>
    
  </div>
</div>