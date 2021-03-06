/**
 *  
 * This module holds the rendering logic for the add new task div
 *
 * @author Carlos Palma <chonwil@gmail.com>
 */
 
 //************************************
//*		Draw add new task form
//************************************

ogTasks.drawAddNewTaskForm = function(group_id,parent_id, level){
	var topToolbar = Ext.getCmp('tasksPanelTopToolbarObject');
	var filters = topToolbar.getFilters();
	var bottomToolbar = Ext.getCmp('tasksPanelBottomToolbarObject');
	var displayCriteria = bottomToolbar.getDisplayCriteria();
	var drawOptions = bottomToolbar.getDrawOptions();
	
	if (parent_id > 0)
		var parentTask = ogTasks.getTask(parent_id);
	
	if (displayCriteria.group_by == 'milestone' && group_id != 'unclassified'){
		var milestone_id = group_id;
	} else if (parentTask && parentTask.milestoneId > 0){
		var milestone_id = parentTask.milestoneId;
	} else if (filters.filter == 'milestone') {
		var milestone_id = Ext.getCmp('ogTasksFilterMilestonesCombo').getValue();
	} else 
		var milestone_id = 0;
	
	var assignedToValue = null;
	if (displayCriteria.group_by == 'assigned_to' && group_id != 'unclassified'){
		assignedToValue = group_id;
	} else if(parentTask && parentTask.assignedToId){
		assignedToValue = parentTask.assignedToId;
	} else if (filters.filter == 'assigned_to') {
		assignedToValue = filters.fval;
	}
	
	var defaultWorkspace = null;
	if (displayCriteria.group_by == 'workspace')
		defaultWorkspace = group_id;
	else if (parentTask)
		defaultWorkspace = parentTask.workspaceIds;
	else if (displayCriteria.group_by == 'milestone'){
		var pm = this.getMilestone(group_id);
		if (pm)
			defaultWorkspace = pm.workspaceIds;
	} else if (filters.filter == 'milestone'){
		var pm = this.getMilestone(filters.fval);
		if (pm)
			defaultWorkspace = pm.workspaceIds;
	}
	
	var tags = '';
	var selectedTag = Ext.getCmp("tag-panel").getSelectedTag();
	if (selectedTag)
		tags += og.clean(selectedTag.name);
	if (displayCriteria.group_by == 'tag' && group_id != 'unclassified' && !(selectedTag && group_id == selectedTag.name)){
		if (tags != '')
			tags += ',';
		tags += group_id;
	}
	
	var priority = 200;
	if (displayCriteria.group_by == 'priority' && group_id != 'unclassified'){
		priority = group_id;
	}
	
	if (parent_id > 0)
		var containerName = 'ogTasksPanelTask' + parent_id + 'G' + group_id;
	else
		var containerName = 'ogTasksPanelGroup' + group_id;
	
	this.drawTaskForm(containerName, {
		parentId: parent_id,
		milestoneId: milestone_id,
		title: '',
		description: '',
		priority: priority,
		workspace: defaultWorkspace,
		startDate: '',
		dueDate: '',
		assignedTo: assignedToValue,
		taskId: 0,
		isEdit: false,
		tags: tags
	});
}

ogTasks.drawEditTaskForm = function(task_id, group_id){
	var task = this.getTask(task_id);
	var containerName = 'ogTasksPanelTask' + task.id + 'G' + group_id;
	if (task){
		this.drawTaskForm(containerName, {
			milestoneId: task.milestoneId?task.milestoneId:0,
			title: task.title,
			description: task.description,
			priority: task.priority,
			workspace: task.workspaceIds,
			startDate: task.startDate,
			dueDate: task.dueDate,
			assignedTo: task.assignedToId,
			taskId: task.id,
			isEdit: true,
			tags: task.tags
		});
	}
}




ogTasks.drawTaskForm = function(container_id, data){
	this.hideAddNewTaskForm();

	var bottomToolbar = Ext.getCmp('tasksPanelBottomToolbarObject');
	var topToolbar = Ext.getCmp('tasksPanelTopToolbarObject');
	var drawOptions = bottomToolbar.getDrawOptions();
	var padding = (15/* * level*/) - 1;
	
	var html = "<div style='margin-left:" + padding + "px' class='ogTasksAddTaskForm'>";
	
	if (data.parentId > 0){
		var parentTask = ogTasks.getTask(data.parentId);
		html += "<input type='hidden' id='ogTasksPanelATParentId' value='" + data.parentId + "'>";
	}
	html += "<b>" + lang('title') + ":</b><br/>";
	html += "<input id='ogTasksPanelATTitle' type='text' class='title' name='task[title]' tabIndex=1000 value=''/>";
	
	
	//First column
	html += "<table style='width:100%; margin-top:7px'><tr><td>";
	if (!data.isEdit){
		html += "<div id='ogTasksPanelATDesc' style='display:none'><b>" + lang('description') + ":</b><br/>";
		html += "<textarea id='ogTasksPanelATDescCtl' cols='40' rows='10' name='task[text]' class='short' tabIndex=1100 style='height:50px'></textarea></div>";
	}
	
	var chkIsVisible = data.assignedTo && data.assignedTo.split(':')[1] != '0';
	var chkIsChecked = chkIsVisible && ogTasks.userPreferences.defaultNotifyValue && data.assignedTo != (this.currentUser.companyId + ':' + this.currentUser.id);
	
	html += "<table><tr><td><div id='ogTasksPanelATAssigned' style='padding-top:5px;'><table><tr><td><b>" + lang('assigned to') + ":&nbsp;</b></td><td><span id='ogTasksPanelATAssignedCont'></span></td></tr></table></div></td>";
	html += '<td style="padding-top:7px;padding-left:15px"><div style="display:' + (chkIsVisible?'inline':'none') + '" id="ogTasksPanelATNotifyDiv"><label for="ogTasksPanelATNotify"><input style="width:14px;" type="checkbox" name="task[notify]" id="ogTasksPanelATNotify" ' + (chkIsChecked? 'checked':'') + '/>&nbsp;' + lang('send notification') + '</label></div></td>';
	html += '</tr></table>'; 
	
	html += "<div id='ogTasksPanelATWorkspace' style='padding-top:5px;" + (data.isEdit? '': 'display:none') + "'><table><tr><td><b>" + lang('workspace') + ":&nbsp;</b></td><td><div id='ogTasksPanelWsSelector'></div></td></tr></table></div>";
	html += "<div id='ogTasksPanelATMilestone' style='padding-top:5px;" + (data.isEdit? '': 'display:none') + "'><table><tr><td><b>" + lang('milestone') + ":&nbsp;</b></td><td><div id='ogTasksPanelMilestoneSelector'></div></td></tr></table></div>";
	html += "<div id='ogTasksPanelATTags' style='padding-top:5px;" + (data.isEdit? '': 'display:none') + "'><table><tr><td><b>" + lang('tags') + ":&nbsp;</b></td><td><input id='ogTasksPanelTagsSelector' style='min-width:120px;max-width:300px' type='text' value='" + (data.tags?data.tags + ',':'') + "' name='task[tags]'/></td></tr></table></div>";
	
	
	//Second column
	html += "</td><td style='padding-left:10px; margin-right:10px;width:300px;'>";
	
	if (drawOptions.show_time){
		html += "<div id='ogTasksPanelATTime' style='padding-top:5px;'><b>" + lang('time worked') + ":</b>&nbsp;";
		html += "<input type='text' id='ogTasksPanelATHours' style='width:25px' tabIndex=1250 />&nbsp;" + lang('hours') + "</div>";
	}
	
	html += "<table id='ogTasksPanelATDates' style='padding-top:5px;" + (data.isEdit? '': 'display:none') + "'><tr><td><b>" + lang('start date') + ":</b>&nbsp;</td>";
	html += "<td><span id='ogTasksPanelATStartDate'></span></td></tr>";
	html += "<tr><td><b>" + lang('due date') + ":</b>&nbsp;</td>";
	html += "<td><span id='ogTasksPanelATDueDate'></span></td></tr></table>";
	
	html += "<div id='ogTasksPanelATPriority' style='padding-top:5px;" + (data.isEdit? '': 'display:none') + "'><table><tr><td><b>" + lang('priority') + ":&nbsp;</b></td>";
	html += "<td><span id='ogTasksPanelATPriorityCont'></span></td></tr></table></div>";
	
	html += "</td></tr><tr><td style='padding-top:15px'>";
	if (!data.isEdit)
		html += "<a href='#' class='internalLink' onclick='ogTasks.addNewTaskShowMore()' id='ogTasksPanelATShowMore'><b>" + lang('more options') + "...</b></a>";
	html += "<a href='#' class='internalLink' style='" + (data.isEdit? '': 'display:none') + "' onclick='ogTasks.TaskFormShowAll(" + data.taskId + ")' id='ogTasksPanelATShowAll'><b>" + lang('all options') + "...</b></a>";
	html += "</td><td align=right>";
	
	
	//Buttons
	html += "<button onclick='ogTasks.SubmitNewTask(" + data.taskId + ");return false;' tabIndex=1600 type='submit' class='submit'>" + (data.isEdit? lang('save changes') : lang('add task')) + "</button>&nbsp;&nbsp;<button tabIndex=1700 onclick='ogTasks.hideAddNewTaskForm();return false;'>" + lang('cancel') + "</button>";
	html += "</td></table>";
	
	html += '</div>';
	
	var div = document.createElement('div');
	div.className = 'ogTasksTaskRow';
	div.id = 'ogTasksPanelAT';
	div.innerHTML = html;
	
	var container = document.getElementById(container_id);
	var next = container.nextSibling;
	if (next)
		container.parentNode.insertBefore(div, next);
	else
		container.appendChild(div);
	
	
	//Create Ext components
	var tags = Ext.getCmp("tag-panel").getTags();
	var arr = [];
	for (var i=0; i < tags.length; i++) {
		arr.push([tags[i].name, og.clean(tags[i].name)]);
	}
	new og.CSVCombo({
		store: new Ext.data.SimpleStore({
       		fields: ["value", "clean"],
       		data: arr
		}),
		valueField: "value",
       	displayField: "value",
       	mode: "local",
       	forceSelection: true,
       	triggerAction: "all",
       	tpl: "<tpl for=\".\"><div class=\"x-combo-list-item\">{clean}</div></tpl>",
       	emptyText: "",
       	applyTo: "ogTasksPanelTagsSelector"
   	});
	
	og.drawWorkspaceSelector('ogTasksPanelWsSelector', data.workspace, 'task[project_id]');
	var ws_sel = Ext.get('ogTasksPanelWsSelector');
	ogTasks.prevWsValue = -1;
	if(data.assignedTo) ogTasks.assignedTo = data.assignedTo;
	else ogTasks.assignedTo = '';
	ws_sel.addListener('click', this.wsSelectorClicked);
	this.wsSelectorClicked();
	
	document.getElementById('ogTasksPanelATTitle').value = data.title;
	document.getElementById('ogTasksPanelATTitle').focus();
	
	if (data.startDate){
		var date = new Date(data.startDate * 1000);
		var sd = date.dateFormat(lang('date format'));
	} else sd = '';
	var DtStart = new og.DateField({
		renderTo:'ogTasksPanelATStartDate',
		id:'ogTasksPanelATStartDateCmp',
		style:'width:100px',
		tabIndex:1300,
		value: sd,
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
	if (data.dueDate){
		var date = new Date(data.dueDate * 1000);
		var dd = date.dateFormat(lang('date format'));
	} else dd = '';
	var DtDue = new og.DateField({
		renderTo:'ogTasksPanelATDueDate',
		id:'ogTasksPanelATDueDateCmp',
		style:'width:100px',
		tabIndex:1400,
		value: dd,
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

	var milestoneCombo = topToolbar.filterMilestonesCombo.cloneConfig({
		name: 'task[milestone_id]',
		renderTo: 'ogTasksPanelMilestoneSelector',
		id: 'ogTasksPanelATMilestoneCombo',
		hidden: false,
		width: 200,
		value: data.milestoneId,
		tabIndex:1220
	});
		
	var priorityCombo = topToolbar.filterPriorityCombo.cloneConfig({
		name: 'task[priority]',
		renderTo: 'ogTasksPanelATPriorityCont',
		id: 'ogTasksPanelATPriorityCombo',
		hidden: false,
		width: 100,
		value: data.priority,
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
	document.getElementById('ogTasksPanelATMilestone').style.display = 'block';
	document.getElementById('ogTasksPanelATTags').style.display = 'block';
	
	document.getElementById('ogTasksPanelATDesc').focus();
}

ogTasks.TaskFormShowAll = function(task_id){
	var params = this.GetNewTaskParameters(false);
	if (task_id)
		og.openLink(og.getUrl('task', 'edit_task', {id:task_id}), {'post' : params});
	else
		og.openLink(og.getUrl('task', 'add_task'), {'post' : params});
}

ogTasks.hideAddNewTaskForm = function(){
	var oldForm = document.getElementById('ogTasksPanelAT');
	if (oldForm)
		oldForm.parentNode.removeChild(oldForm);
}

ogTasks.GetNewTaskParameters = function(wrapWithTask){
	var parameters = [];

	//Conditional fields
	var parentField = document.getElementById('ogTasksPanelATParentId');
	if (parentField)
		parameters["parent_id"] = parentField.value;
	
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
	if (notify && notify.style.display != 'none' && notify.checked)
		parameters["notify"] = true;
	else
		parameters["notify"] = false;
		
	var description = document.getElementById('ogTasksPanelATDescCtl');
	if (description)
		parameters["text"] = description.value;
	
	//Always visible
	parameters["assigned_to"] = Ext.getCmp('ogTasksPanelATUserCompanyCombo').getValue();
	parameters["milestone_id"] = Ext.getCmp('ogTasksPanelATMilestoneCombo').getValue();
	parameters["priority"] = Ext.getCmp('ogTasksPanelATPriorityCombo').getValue();
	parameters["title"] = document.getElementById('ogTasksPanelATTitle').value;
	parameters["project_id"] = document.getElementById('ogTasksPanelWsSelectorValue').value;
	parameters["tags"] = document.getElementById('ogTasksPanelTagsSelector').value;
	
	if (wrapWithTask){
		var params2 = [];
		for (var i in parameters)
			if (parameters[i] || parameters[i] === 0)
				params2["task[" + i + "]"] = parameters[i];
		return params2;
	}
	else
		return parameters;
}

ogTasks.SubmitNewTask = function(task_id){
	var parameters = this.GetNewTaskParameters(true);
	if (task_id > 0)
		var url = og.getUrl('task', 'quick_edit_task', {id:task_id});
	else
		var url = og.getUrl('task', 'quick_add_task');

	og.openLink(url, {
		method: 'POST',
		post: parameters,
		callback: function(success, data) {
			if (success && ! data.errorCode) {
				var task = this.getTask(data.task.id);
				if (!task){
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
				} else {
					task.setFromTdata(data.task);
				}
				this.redrawGroups = false;
				this.draw();
				this.redrawGroups = true;
			} else {
				if (!data.errorMessage || data.errorMessage == '')
					og.err(lang("error adding task"));
			}
		},
		scope: this
	});
}

ogTasks.wsSelectorClicked = function() {
	var wsVal = document.getElementById('ogTasksPanelWsSelectorValue').value;
	
	if (wsVal != ogTasks.prevWsValue) {
		og.openLink(og.getUrl('task', 'allowed_users_to_assign', {ws_id:wsVal}), {callback:ogTasks.drawAssignedToCombo});
		ogTasks.prevWsValue = wsVal;
	}
}

ogTasks.buildAssignedToComboStore = function(companies) {
	usersStore = [];
	comp_array = [];
	cantU = 0;
	cantC = 1;
	
	comp_array[cantC++] = ['0:0', lang('dont assign')];
	comp_array[cantC++] = ['0:0', '--'];
	usersStore[cantU++] = ['0:0', '--'];
	
	for (i=0; i<companies.length; i++) {
		comp = companies[i];
		comp_array[cantC++] = [comp.id + ':0', comp.name];
		for (j=0; j<comp.users.length; j++) {
			usr = comp.users[j];
			usersStore[cantU++] = [comp.id + ':' + usr.id, usr.name];
			if (usr.isCurrent) comp_array[0] = [comp.id + ':' + usr.id, lang('me')];
		}
	}
	usersStore = comp_array.concat(usersStore);
	return usersStore;
}

ogTasks.drawAssignedToCombo = function(success, data) {
	usersStore = ogTasks.buildAssignedToComboStore(data.companies);
	prev_combo = Ext.get('ogTasksPanelATUserCompanyCombo');
	if (prev_combo) prev_combo.remove();
	
	var namesCombo = new Ext.form.ComboBox({
		name: 'task[assigned_to]',
		renderTo: 'ogTasksPanelATAssignedCont',
		id: 'ogTasksPanelATUserCompanyCombo',
		store: usersStore,
		hidden: false,
		width: 200,
		displayField:'text',
        typeAhead: true,
        mode: 'local',
        triggerAction: 'all',
        selectOnFocus:true,
        value: ogTasks.assignedTo,
		emptyText: (lang('select user or group') + '...'),
	    valueNotFoundText: '',
		tabIndex:1200,
		listeners: {
			'select':function(combo, record){
				var checkbox = document.getElementById('ogTasksPanelATNotify');
				if (checkbox){
					var chkIsVisible = record.data.value != '-1:-1' && record.data.value.split(':')[1] != '0';
					var chkIsChecked = ogTasks.userPreferences.defaultNotifyValue && chkIsVisible && (record.data.value != (ogTasks.currentUser.companyId + ':' + ogTasks.currentUser.id));
					
					checkbox.checked = chkIsChecked;
					var checkboxDiv = document.getElementById('ogTasksPanelATNotifyDiv');
					if (chkIsVisible){
						ogTasks.assignedTo = combo.getValue();
						checkboxDiv.style.display = 'block';
					} else {
						checkboxDiv.style.display = 'none';
					}
				}
			}
		}
	});
}
