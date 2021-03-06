
<?php $genid = gen_id();

	$assign_type = 0; //All
	if ($assigned_to_user_filter > 0){
		$assigned_to = Users::findById($assigned_to_user_filter);
		$assigned_to_me = $assigned_to->getId() == logged_user()->getId();
		$assign_type = $assigned_to_me? 1 : 2;
	} else if ($assigned_to_company_filter > 0){
		$assigned_to = Companies::findById($assigned_to_company_filter);
		$assign_type = 3;
	}
?>

<script type="text/javascript">
	var cant_tips = 0;
	var tips_array = [];
	
	function addTip(div_id, title, bdy) {
		tips_array[cant_tips++] = new Ext.ToolTip({
			target: div_id,
	        html: bdy,
	        title: title,
	        hideDelay: 1500,
	        closable: true
		});
	}
</script>


<div id="<?php echo $genid ?>-db" style="padding:7px;">
<div class="dashboard" style="width:100%;">

<div class="dashWorkspace">
<span class="name">
<?php 
if(active_project() instanceof Project) 
	echo clean(active_project()->getName());
else 
	echo lang('all projects');
	
	$use_24_hours = user_config_option('time_format_use_24');
	if($use_24_hours) $timeformat = 'G:i';
	else $timeformat = 'g:i A';
									
	$tags = active_tag();
	
	$hasPendingTasks = isset($dashtasks) && is_array($dashtasks) && count($dashtasks) > 0;
	$hasLateMilestones = (isset($today_milestones) && is_array($today_milestones) && count($today_milestones)) || (isset($late_milestones) && is_array($late_milestones) && count($late_milestones));
	$hasMessages = isset($messages) && is_array($messages) && count($messages) > 0;
	$hasDocuments = isset($documents) && is_array($documents) && count($documents) > 0;
	$hasCharts = (isset($charts) && is_array($charts) && count($charts) > 0) || (isset($billing_chart_data) && is_array($billing_chart_data) && count($billing_chart_data) > 0);
	$hasEmails = (isset($unread_emails) && is_array($unread_emails) && count($unread_emails) > 0)
			|| (isset($ws_emails) && is_array($ws_emails) && count($ws_emails) > 0);
	
	$hasToday = (isset($today_milestones) && is_array($today_milestones) && count($today_milestones)) 
			|| (isset($today_tasks) && is_array($today_tasks) && count($today_tasks));
	$hasLate = (isset($late_tasks) && is_array($late_tasks) && count($late_tasks))
		|| (isset($late_milestones) && is_array($late_milestones) && count($late_milestones));
	$hasComments = isset($comments) && is_array($comments) && count($comments) > 0;
	
	$showWorkspaceInfo = active_project() instanceof Project && user_config_option('show dashboard info widget');
?>
</span><span class="description">
</span>
</div>

<div class="dashActions"">
	<a class="internalLink" href="#" onclick="og.switchToOverview(); return false;">
	<div class="viewAsList"><?php echo lang('view as list') ?></div></a>
</div>




<?php //--------------------------------------------- Remove FALSE
 if(!(active_project() instanceof Project) && false && logged_user()->isMemberOfOwnerCompany() && !owner_company()->getHideWelcomeInfo()) { ?>
<div class="hint">

  <div class="header"><?php echo lang('welcome to new account') ?></div>
  <div class="content"><?php echo lang('welcome to new account info', logged_user()->getDisplayName(), ROOT_URL) ?></div>
  
<?php if(owner_company()->isInfoUpdated()) { ?>
  <div class="header"><del><?php echo lang('new account step1') ?></del></div>
  <div class="content"><del><?php echo lang('new account step1 info', get_url('company', 'edit')) ?></del></div>
<?php } else { ?>
  <div class="header"><?php echo lang('new account step1') ?></div>
  <div class="content"><?php echo lang('new account step1 info', get_url('company', 'edit')) ?></div>
<?php } // if ?>
  
<?php if(owner_company()->countUsers() > 1) { ?>
  <div class="header"><del><?php echo lang('new account step2') ?></del></div>
  <div class="content"><del><?php echo lang('new account step2 info', owner_company()->getAddUserUrl()) ?></del></div>
<?php } else { ?>
  <div class="header"><?php echo lang('new account step2') ?></div>
  <div class="content"><?php echo lang('new account step2 info', owner_company()->getAddUserUrl()) ?></div>
<?php } // if?>
  
<?php if(owner_company()->countClientCompanies() > 0) { ?>
  <div class="header"><del><?php echo lang('new account step3') ?></del></div>
  <div class="content"><del><?php echo lang('new account step3 info', get_url('company', 'add_client')) ?></del></div>
<?php } else { ?>
  <div class="header"><?php echo lang('new account step3') ?></div>
  <div class="content"><?php echo lang('new account step3 info', get_url('company', 'add_client')) ?></div>
<?php } // if ?>
  
<?php if(owner_company()->countProjects() > 0) { ?>
  <div class="header"><del><?php echo lang('new account step4') ?></del></div>
  <div class="content"><del><?php echo lang('new account step4 info', get_url('project', 'add')) ?></del></div>
<?php } else { ?>
  <div class="header"><?php echo lang('new account step4') ?></div>
  <div class="content"><?php echo lang('new account step4 info', get_url('project', 'add')) ?></div>
<?php } // if?>
  
  <p><a class="internalLink" href="<?php echo get_url('company', 'hide_welcome_info') ?>"><?php echo lang('hide welcome info') ?></a></p>
  
</div>
<?php } // if ?>

<table style="width:100%">
<tr><td colspan=2>
<?php if (user_config_option('show calendar widget') && config_option('enable_calendar_module')) {
	
	tpl_assign("widgetClass", 'dashCalendar');
	tpl_assign("widgetTitle",lang('upcoming events milestones and tasks'));
	tpl_assign("widgetTemplate", 'calendar');
	$this->includeTemplate(get_template_path('widget', 'dashboard'));
} ?>
 </td></tr>
<tr><td>

<?php 


if (isset($tasks_in_progress) && $tasks_in_progress) {
	switch($assign_type){
		case 0: $title = lang('tasks in progress'); break;
		case 1: $title = lang('my tasks in progress'); break;
		case 2: $title = lang('tasks in progress for', $assigned_to->getDisplayName()); break;
		case 3: $title = lang('tasks in progress for', $assigned_to->getName()); break;
	}
	tpl_assign("widgetClass", 'dashTasksInProgress');
	tpl_assign("widgetTitle",$title);
	tpl_assign("widgetTemplate", 'active_tasks');
	$this->includeTemplate(get_template_path('widget', 'dashboard'));
}

if ($hasToday || $hasLate) {
	switch($assign_type){
		case 0: $title = lang('late milestones and tasks'); break;
		case 1: $title = lang('my late milestones and tasks'); break;
		case 2: $title = lang('late milestones and tasks for', $assigned_to->getDisplayName()); break;
		case 3: $title = lang('late milestones and tasks for', $assigned_to->getName()); break;
	}
	tpl_assign("hasToday", $hasToday);
	tpl_assign("hasLate", $hasLate);
	tpl_assign("widgetClass", 'dashLate');
	tpl_assign("widgetTitle",$title);
	tpl_assign("widgetTemplate", 'late_tasks');
	$this->includeTemplate(get_template_path('widget', 'dashboard'));
}

if ($hasPendingTasks) {
	switch($assign_type){
		case 0: $title = lang('pending tasks'); break;
		case 1: $title = lang('my pending tasks'); break;
		case 2: $title = lang('pending tasks for', $assigned_to->getDisplayName()); break;
		case 3: $title = lang('pending tasks for', $assigned_to->getName()); break;
	}
	tpl_assign("widgetClass", 'dashPendingTasks');
	tpl_assign("widgetTitle",$title);
	tpl_assign("widgetTemplate", 'pending_tasks');
	$this->includeTemplate(get_template_path('widget', 'dashboard'));
}

if ($hasDocuments) {
	tpl_assign("widgetClass", 'dashDocuments');
	tpl_assign("widgetTitle", lang('documents'));
	tpl_assign("widgetTemplate", 'documents');
	$this->includeTemplate(get_template_path('widget', 'dashboard'));
}
?>

</td>

<?php if ($hasMessages  || $hasCharts || $hasEmails || $hasComments || $showWorkspaceInfo){ ?>
<td style="width:<?php echo ($hasPendingTasks || $hasLate || $hasToday || $hasDocuments)? '330px' : '100%' ?>">
<?php 

if ($showWorkspaceInfo){
	tpl_assign("widgetClass", 'dashInfo');
	tpl_assign("widgetTitle", lang('description'));
	tpl_assign("widgetTemplate", 'dashboard_info');
	$this->includeTemplate(get_template_path('widget', 'dashboard'));
}

if ($hasEmails && (config_option('enable_email_module', defined('SHOW_MAILS_TAB') ? SHOW_MAILS_TAB : 0))) {
	tpl_assign("widgetClass", 'dashUnreadEmails');
	tpl_assign("widgetTitle", $unread_emails?lang('unread emails'):lang('workspace emails'));
	tpl_assign("widgetTemplate", 'emails');
	$this->includeTemplate(get_template_path('widget', 'dashboard'));
}

if ($hasMessages) {
	tpl_assign("widgetClass", 'dashMessages');
	tpl_assign("widgetTitle", lang('messages'));
	tpl_assign("widgetTemplate", 'messages');
	$this->includeTemplate(get_template_path('widget', 'dashboard'));
}

if ($hasComments) {
	tpl_assign("widgetClass", 'dashComments');
	tpl_assign("widgetTitle", lang('latest comments'));
	tpl_assign("widgetTemplate", 'comments');
	$this->includeTemplate(get_template_path('widget', 'dashboard'));
}

if ($hasCharts) {
	tpl_assign("widgetClass", 'dashChart');
	tpl_assign("widgetTitle", lang('charts'));
	tpl_assign("widgetTemplate", 'charts');
	$this->includeTemplate(get_template_path('widget', 'dashboard'));
}?>
</td>
<?php } ?>

</tr></table>
</div>
</div>
<script type="text/javascript">
og.showWsPaths('<?php echo $genid ?>-db');
Ext.QuickTips.init();
</script>