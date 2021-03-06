/**
 *  
 * This module holds the rendering logic for the add new task div
 *
 * @author Carlos Palma <chonwil@gmail.com>
 */
 
 //************************************
//*		Draw add new task form
//************************************

ogTasks.drawAddNewTaskForm = function(group_id, task_id, level){
	this.hideAddNewTaskForm();
	
	
	var bottomToolbar = Ext.getCmp('tasksPanelBottomToolbarObject');
	var topToolbar = Ext.getCmp('tasksPanelTopToolbarObject');
	var displayCriteria = bottomToolbar.getDisplayCriteria();
	var drawOptions = bottomToolbar.getDrawOptions();
	var filters = topToolbar.getFilters();
	var padding = (15 * level) - 1;
	var parent;
	if (task_id > 0)
		parent = document.getElementById('ogTasksPanelTask' + task_id + 'G' + group_id);
	else
		parent = document.getElementById('ogTasksPanelGroup' + group_id);
	if (task_id && task_id > 0)
		var parentTask = ogTasks.getTask(task_id);
	
	var div = document.createElement('div');
	div.className = 'ogTasksTaskRow';
	div.id = 'ogTasksPanelAT';
	var html = "<div style='margin-left:" + padding + "px' class='ogTasksAddTaskForm'>";
	if (task_id)
		html += "<input type='hidden' id='ogTasksPanelATParentId' value='" + task_id + "'>";
	if (displayCriteria.group_by == 'milestone' && group_id != 'unclassified'){
		html += "<input type='hidden' id='ogTasksPanelATMilestoneId' value='" + group_id + "'>";
	} else if (parentTask && parentTask.milestoneId > 0){
		html += "<input type='hidden' id='ogTasksPanelATMilestoneId' value='" + parentTask.milestoneId + "'>";
	} else if (filters.filter == 'milestone') {
		html += "<input type='hidden' id='ogTasksPanelATMilestoneId' value='" + Ext.getCmp('ogTasksFilterMilestonesCombo').getValue() + "'>";
	}
	html += "<b>" + lang('title') + ":</b><br/>";
	html += "<input id='ogTasksPanelATTitle' type='text' class='title' name='task[title]' tabIndex=1000/>";
	
	
	//First column
	html += "<table style='width:100%; margin-top:7px'><tr><td>";
	html += "<div id='ogTasksPanelATDesc' style='display:none'><b>" + lang('description') + ":</b><br/>";
	html += "<textarea id='ogTasksPanelATDescCtl' cols='40' rows='10' name='task[text]' class='short' tabIndex=1100 style='height:50px'></textarea></div>";
	
	var assignedToValue = null;
	if (displayCriteria.group_by == 'assigned_to' && group_id != 'unclassified'){
		assignedToValue = group_id;
	} else if (filters.filter == 'assigned_to') {
		assignedToValue = filters.fval;
	}
	var chkIsChecked = (assignedToValue != (ogTasks.currentUser.id + ':' + ogTasks.currentUser.companyId)) && (assignedToValue && assignedToValue.split(':')[1] != '0');
	var chkIsVisible = (assignedToValue && assignedToValue.split(':')[1] != '0');
	html += "<table><tr><td><div id='ogTasksPanelATAssigned' style='padding-top:5px;'><table><tr><td><b>" + lang('assigned to') + ":&nbsp;</b></td><td><span id='ogTasksPanelATAssignedCont'></span></td></tr></table></div></td>";
	html += '<td style="padding-top:7px;padding-left:15px"><div style="display:' + (chkIsVisible?'inline':'none') + '" id="ogTasksPanelATNotifyDiv"><label for="ogTasksPanelATNotify"><input style="width:14px;" type="checkbox" name="task[notify]" id="ogTasksPanelATNotify" ' + (chkIsChecked? 'checked':'') + '/>&nbsp;' + lang('send notification') + '</label></div></td></tr></table>'; 
	
	html += "<div id='ogTasksPanelATWorkspace' style='padding-top:5px;display:none'><table><tr><td><b>" + lang('workspace') + ":&nbsp;</b></td><td><div id='ogTasksPanelWsSelector'></div></td></tr></table></div>";
	
	
	//Second column
	html += "</td><td style='padding-left:10px; margin-right:10px;width:300px;'>";
	
	if (drawOptions.show_time){
		html += "<div id='ogTasksPanelATTime' style='padding-top:5px;'><b>" + lang('time worked') + ":</b>&nbsp;";
		html += "<input type='text' id='ogTasksPanelATHours' style='width:25px' tabIndex=1250 />&nbsp;" + lang('hours') + "</div>";
	}
	
	if (drawOptions.show_dates || displayCriteria.group_by == "due_date" || displayCriteria.group_by == "start_date"){
		displayDefault = displayCriteria.group_by == "due_date" || displayCriteria.group_by == "start_date";
		
		html += "<table id='ogTasksPanelATDates' style='padding-top:5px;display:" + (displayDefault? 'inline':'none') + "'><tr><td><b>" + lang('start date') + ":</b>&nbsp;</td>";
		html += "<td><span id='ogTasksPanelATStartDate'></span></td></tr>";
		html += "<tr><td><b>" + lang('due date') + ":</b>&nbsp;</td>";
		html += "<td><span id='ogTasksPanelATDueDate'></span></td></tr></table>";
	}
	
	html += "<div id='ogTasksPanelATPriority' style='padding-top:5px;display:none'><table><tr><td><b>" + lang('priority') + ":&nbsp;</b></td>";
	html += "<td><span id='ogTasksPanelATPriorityCont'></span></td></tr></table></div>";
	
	html += "</td></tr><tr><td style='padding-top:15px'>";
	html += "<a href='#' class='internalLink' onclick='ogTasks.addNewTaskShowMore()' id='ogTasksPanelATShowMore'><b>" + lang('more options') + "...</b></a>";
	html += "<a href='#' class='internalLink' style='display:none' onclick='ogTasks.addNewTaskShowAll()' id='ogTasksPanelATShowAll'><b>" + lang('all options') + "...</b></a>";
	html += "</td><td align=right>";
	
	
	//Buttons
	html += "<button onclick='ogTasks.SubmitNewTask();return false;' tabIndex=1600 type='submit' class='submit'>" + lang('add task') + "</button>&nbsp;&nbsp;<button tabIndex=1700 onclick='ogTasks.hideAddNewTaskForm();return false;'>" + lang('cancel') + "</button>";
	html += "</td></table>";
	
	html += '</div>';
	div.innerHTML = html;
	var next = parent.nextSibling;
	if (next)
		parent.parentNode.insertBefore(div, next);
	else
		parent.appendChild(div);
	
	
	//Create Ext components
	
	var defaultWorkspace = null;
	if (displayCriteria.group_by == 'workspace')
		defaultWorkspace = group_id;
	else if (parentTask)
		defaultWorkspace = parentTask.workspaceId;
	else if (displayCriteria.group_by == 'milestone'){
		var pm = this.getMilestone(group_id);
		if (pm)
			defaultWorkspace = pm.workspaceIds;
	}
	
	og.drawWorkspaceSelector('ogTasksPanelWsSelector',defaultWorkspace, 'task[project_id]');
	
	document.getElementById('ogTasksPanelATTitle').focus();
	if (drawOptions.show_dates){
		var DtStart = new og.DateField({
			renderTo:'ogTasksPanelATStartDate',
			id:'ogTasksPanelATStartDateCmp',
			style:'width:100px',
			tabIndex:1300,
			listeners: {
				'change': {
					fn: function(start, val, old) {
						if (this.getValue() && this.getValue() < start.getValue()) {
							alert(lang("warning start date greater than due date"));
						}
					},
					scope: DtDue
				}
			}
		});
		var DtDue = new og.DateField({
			renderTo:'ogTasksPanelATDueDate',
			id:'ogTasksPanelATDueDateCmp',
			style:'width:100px',
			tabIndex:1400,
			listeners: {
				'change': {
					fn: function(due, val, old) {
						if (this.getValue() && this.getValue() > due.getValue()) {
							alert(lang("warning start date greater than due date"));
						}
					},
					scope: DtStart
				}
			}
		});
	}
	var namesCombo = topToolbar.filterNamesCompaniesCombo.cloneConfig({
			name: 'task[assigned_to]',
			renderTo: 'ogTasksPanelATAssignedCont',
			id: 'ogTasksPanelATUserCompanyCombo',
			hidden: false,
			width: 200,
			value: assignedToValue,
			tabIndex:1200,
			listeners: {
				'select':function(combo, record){
					var checkbox = document.getElementById('ogTasksPanelATNotify');
					var checkboxDiv = document.getElementById('ogTasksPanelATNotifyDiv');
					if (record.data.value != '-1:-1' && record.data.value.split(':')[1] != '0'){
						checkboxDiv.style.display = 'block';
						var currentUser = ogTasks.currentUser;
						checkbox.checked = (record.data.value != (currentUser.id + ':' + currentUser.companyId));
					} else {
						checkboxDiv.style.display = 'none';
						checkbox.checked = false;
					}
				}
			}
		});
		
	var priority = 200;
	if (displayCriteria.group_by == 'priority' && group_id != 'unclassified'){
		priority = group_id;
	}
	var priorityCombo = topToolbar.filterPriorityCombo.cloneConfig({
			name: 'task[priority]',
			renderTo: 'ogTasksPanelATPriorityCont',
			id: 'ogTasksPanelATPriorityCombo',
			hidden: false,
			width: 100,
			value: priority,
			tabIndex:1500
		});
}

ogTasks.addNewTaskShowMore = function(){
	document.getElementById('ogTasksPanelATShowMore').style.display = 'none';
	document.getElementById('ogTasksPanelATShowAll').style.display = 'inline';
	
	document.getElementById('ogTasksPanelATDesc').style.display = 'block';
	
	if (document.getElementById('ogTasksPanelATDates'))
		document.getElementById('ogTasksPanelATDates').style.display = 'block';
	
	if (document.getElementById('ogTasksPanelATPriority'))
		document.getElementById('ogTasksPanelATPriority').style.display = 'block';
		
	document.getElementById('ogTasksPanelATAssigned').style.visibility = 'visible';
	document.getElementById('ogTasksPanelATWorkspace').style.display = 'block';
	
	document.getElementById('ogTasksPanelATDesc').focus();
}

ogTasks.addNewTaskShowAll = function(){
	var params = this.GetNewTaskParameters(false);
	og.openLink(og.getUrl('task', 'add_task'), {'post' : params});
}

ogTasks.hideAddNewTaskForm = function(){
	var oldForm = document.getElementById('ogTasksPanelAT');
	if (oldForm)
		oldForm.parentNode.removeChild(oldForm);
}

ogTasks.ShowWorkspaceSelector = function(workspaceId){
	if (document.getElementById('ogTasksPanelWsSelPanel').innerHTML == ''){
		var tree = Ext.getCmp('workspace-panel');
		var wsList = tree.getWsList();
		var newTree = tree.cloneConfig({
			id: 'ogTasksPanelWsSelPanelTree',
			renderTo: 'ogTasksPanelWsSelPanel',
			tbar: [],
			root:[],
			workspaces: wsList,
			isInternalSelector: true,
			width:180,
			height:250,
			selectedWorkspaceId: workspaceId
		});	
	}
	document.getElementById('ogTasksPanelWsSelPanel').style.display = 'block';
	document.getElementById('ogTasksPanelWsSelHeader').style.display = 'none';
}

ogTasks.WorkspaceSelected = function(workspace){
	document.getElementById('ogTasksPanelWsSelHeader').innerHTML = "<a class='coViewAction ico-color" + workspace.color + "' href='#' onclick='ogTasks.ShowWorkspaceSelector(" + workspace.id + ")' title='" + lang('change workspace') + "'>" + og.getFullWorkspacePath(workspace.id,true) + "</a>";
	document.getElementById('ogTasksPanelWsSelPanel').style.display = 'none';
	document.getElementById('ogTasksPanelWsSelHeader').style.display = 'block';
	document.getElementById('ogTasksPanelWsSelValue').value = workspace.id;
}


ogTasks.GetNewTaskParameters = function(wrapWithTask){
	var parameters = [];

	//Conditional fields
	var parentField = document.getElementById('ogTasksPanelATParentId');
	if (parentField)
		parameters["parent_id"] = parentField.value;
	
	var milestoneField = document.getElementById('ogTasksPanelATMilestoneId');
	if (milestoneField)
		parameters["milestone_id"] = milestoneField.value;
	
	var hoursPanel = document.getElementById('ogTasksPanelATHours');
	if (hoursPanel)
		parameters["hours"] = hoursPanel.value;
	
	var startPanel = Ext.getCmp('ogTasksPanelATStartDateCmp');
	if (startPanel && startPanel.getValue() != '')
		parameters["task_start_date"] = startPanel.getValue().format(lang('date format'));
	
	var duePanel = Ext.getCmp('ogTasksPanelATDueDateCmp');
	if (duePanel && duePanel.getValue() != '')
		parameters["task_due_date"] = duePanel.getValue().format(lang('date format'));
		
	var notify = document.getElementById('ogTasksPanelATNotify');
	if (notify.style.display != 'none' && notify.checked)
		parameters["notify"] = true;
	
	//Always visible
	parameters["assigned_to"] = Ext.getCmp('ogTasksPanelATUserCompanyCombo').getValue();
	parameters["priority"] = Ext.getCmp('ogTasksPanelATPriorityCombo').getValue();
	parameters["title"] = document.getElementById('ogTasksPanelATTitle').value;
	parameters["text"] = document.getElementById('ogTasksPanelATDescCtl').value;
	parameters["project_id"] = document.getElementById('ogTasksPanelWsSelectorValue').value;
	
	if (wrapWithTask){
		var params2 = [];
		for (var i in parameters)
			if (parameters[i])
				params2["task[" + i + "]"] = parameters[i];
		return params2;
	}
	else
		return parameters;
}

ogTasks.SubmitNewTask = function(){
	var parameters = this.GetNewTaskParameters(true);

	og.openLink(og.getUrl('task', 'quick_add_task'), {
		method: 'POST',
		post: parameters,
		callback: function(success, data) {
			if (success && ! data.errorCode) {
				var task = new ogTasksTask();
				task.setFromTdata(data.task);
				if (data.task.s)
					task.statusOnCreate = data.task.s;
				task.isCreatedClientSide = true;
				this.Tasks[this.Tasks.length] = task;
				var parent = this.getTask(task.parentId);
				if (parent){
					task.parent = parent;
					parent.subtasks[parent.subtasks.length] = task;
				}
				this.draw();
			} else {
				og.err(lang("error adding task"));
			}
		},
		scope: this
	});
}

