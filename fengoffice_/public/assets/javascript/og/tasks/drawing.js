/**
 * drawing.js
 *
 * This module holds the rendering logic for groups and tasks
 *
 * @author Carlos Palma <chonwil@gmail.com>
 */



//************************************
//*		Main function
//************************************

ogTasks.draw = function(){
	this.Groups = [];
	for (var i = 0; i < this.Tasks.length; i++)
		this.Tasks[i].divInfo = [];
	
	var container = document.getElementById('tasksPanelContainer');
	container.innerHTML = '';
	var bottomToolbar = Ext.getCmp('tasksPanelBottomToolbarObject');
	var displayCriteria = bottomToolbar.getDisplayCriteria();
	var drawOptions = bottomToolbar.getDrawOptions();
	this.Groups = this.groupTasks(displayCriteria, this.Tasks);
	for (var i = 0; i < this.Groups.length; i++){
		this.Groups[i].group_tasks = this.orderTasks(displayCriteria, this.Groups[i].group_tasks);
		if (i != (this.Groups.length-1) || this.Groups[i].group_tasks.length > 0) //If there are no unclassified or unassigned tasks, do not show unassigned group
			this.drawGroup(displayCriteria, drawOptions, this.Groups[i]);
	}
	container.innerHTML += "<div style='height:20px'></div>";
	og.showWsPaths('tasksPanelContainer');
	
}

ogTasks.toggleSubtasks = function(taskId, groupId){
	var subtasksDiv = document.getElementById('ogTasksPanelSubtasksT' + taskId + 'G' + groupId);
	var expander = document.getElementById('ogTasksPanelFixedExpanderT' + taskId + 'G' + groupId);
	var task = this.getTask(taskId);
	if (subtasksDiv){
		task.isExpanded = !task.isExpanded;
		subtasksDiv.style.display = (task.isExpanded)? 'block':'none';
		expander.className = "og-task-expander " + ((task.isExpanded)?'toggle_expanded':'toggle_collapsed');
	}
}



//************************************
//*		Draw group
//************************************

ogTasks.drawMilestoneCompleteBar = function(group){
	var html = '';
	var milestone = this.getMilestone(group.group_id);
	var complete = 0;
	var completedTasks = milestone.completedTasks;
	var totalTasks =  milestone.totalTasks;
	for (var i = 0; i < group.group_tasks.length; i++){
		var t = group.group_tasks[i];
		completedTasks += (t.status == 1 && (t.statusOnCreate == 0))? 1:0;
		totalTasks += (t.isCreatedClientSide)? 1:0;
	}
	if (totalTasks > 0)
		complete = ((100 * completedTasks) / totalTasks);
	html += "<table><tr><td style='padding-left:15px;padding-top:5px'>";
	html += "<table style='height:7px;width:50px'><tr><td style='width:" + (complete) + "%;background-color:#6C2'></td><td style='width:" + (100 - complete) + "%;background-color:#DDD'></td></tr></table>";
	html += "</td><td style='padding-left:3px;line-height:12px'><span style='font-size:8px;color:#AAA'>(" + completedTasks + '/' +  totalTasks + ")</span></td></tr></table>";

	return html;			
}

ogTasks.drawGroup = function(displayCriteria, drawOptions, group){
	var container = document.getElementById('tasksPanelContainer');
	var html = "<div id='ogTasksPanelGroupCont" + group.group_id + "'><div id='ogTasksPanelGroup" + group.group_id + "' class='ogTasksGroupHeader' onmouseover='ogTasks.mouseMovement(null,\"" + group.group_id + "\",true)' onmouseout='ogTasks.mouseMovement(null,\"" + group.group_id + "\", false)'>";
	html +="<table width='100%'><tr><td width='20px'><div class='db-ico " + group.group_icon + "'></div></td>"
	
	switch (displayCriteria.group_by){
		case 'milestone':
			var milestone = this.getMilestone(group.group_id);
			if (milestone){
				var headerTitle = "<table><tr><td><div class='ogTasksGroupHeaderName'>";
				if (milestone.completedById){
					var user = this.getUser(milestone.completedById);
					var tooltip = '';
					if (user){
						var time = new Date(milestone.completedOn * 1000);
						tooltip = lang('completed by name on', user.name, time.dateFormat('M j')).replace(/'\''/g, '\\\'');
					}
					headerTitle += "<a href='#' style='text-decoration:line-through' class='internalLink' onclick='og.openLink(\"" + og.getUrl('milestone', 'view', {id: group.group_id}) + "\")' title='" + tooltip + "'>" + group.group_name + '</a></div></td>';
				}
				else
					headerTitle += "<a href='#' class='internalLink' onclick='og.openLink(\"" + og.getUrl('milestone', 'view', {id: group.group_id}) + "\")'>" + group.group_name + '</a></div></td>';
				
				headerTitle += "<td><div id='ogTasksPanelCompleteBar" + group.group_id + "'>";
				headerTitle += this.drawMilestoneCompleteBar(group);
				headerTitle += "</div></td>";
				
				if (drawOptions.show_dates){
					headerTitle += '<td><span style="padding-left:12px;color:#888;">';
					var date = new Date(milestone.dueDate * 1000);
					if (milestone.completedById > 0){
						headerTitle += '<span style="text-decoration:line-through">';
						headerTitle += lang('due') + ':&nbsp;' + date.dateFormat('M j');
						headerTitle += '</span>';
					} else {
						var now = new Date();
						if ((date < now)){
							headerTitle += '<span style="font-weight:bold;color:#F00">';
							headerTitle += lang('due') + ':&nbsp;' + date.dateFormat('M j');
							headerTitle += '</span>';
						}
						else
							headerTitle += lang('due') + ':&nbsp;' + date.dateFormat('M j');
					}
					headerTitle += '</span></td>';
				}
			} else {
				var headerTitle = "<table><tr><td><div class='ogTasksGroupHeaderName'>" + group.group_name + '</div></td>';
			}
			headerTitle += "</tr></table>";
			break;
		default:
			var headerTitle = "<div class='ogTasksGroupHeaderName'>" + group.group_name + '</div>';
	}
	html += '<td>' + headerTitle + '</td>';
	
	html += "<td align='right'><div class='ogTasksGroupHeaderActions' style='display:none' id='ogTasksPanelGroupActions" + group.group_id + "'>" + this.drawGroupActions(group.group_id) + '</div></td></tr></table>';
	html += "</div>";
	
	//draw the group's tasks
	for (var i = 0; i < group.group_tasks.length; i++){
		if (i == 8){			//Draw expander if group has more than 8 tasks
			html += "<div class='ogTasksTaskRow' id='ogTasksGroupExpandTasksTitle" + group.group_id + "'>";
			html += "<a href='#' class='internalLink' onclick='ogTasks.expandGroup(\"" + group.group_id + "\")'>" + lang('show more tasks number', (group.group_tasks.length - i)) + "</a>";
			html += "</div>";
			html += "<div id='ogTasksGroupExpandTasks" + group.group_id + "' style='display:none'>";
		}
		html += this.drawTask(group.group_tasks[i], drawOptions, displayCriteria, group.group_id, 1);
	}
	if (group.group_tasks.length > 8){
		html += "</div>";
	}
	html += "</div>";
	container.innerHTML += html;
}

ogTasks.drawGroupActions = function(group_id){
	var html = '<a id="ogTasksPanelGroupSoloOn' + group_id + '" style="padding-right:15px;" href="#" class="internalLink" onClick="ogTasks.hideShowGroups(\'' + group_id + '\')" title="' + lang('hide other groups') + '">' + (lang('hide others')) + '</a>';
	html += '<a id="ogTasksPanelGroupSoloOff' + group_id + '" style="display:none;padding-right:15px;" href="#" class="internalLink" onClick="ogTasks.hideShowGroups(\'' + group_id + '\')" title="' + lang('show all groups') + '">' + (lang('show all')) + '</a>';
	html += '<div class="ogTasksGroupAction ico-add">';
	html += '<a href="#" class="internalLink" onClick="ogTasks.drawAddNewTaskForm(\'' + group_id + '\')" title="' + lang('add a new task to this group') + '">' + (lang('add task')) + '</a>';
	html += '</div>';
	return html;
}



ogTasks.hideShowGroups = function(group_id){
	var group = this.getGroup(group_id);
	if (group){
		var soloOn = document.getElementById('ogTasksPanelGroupSoloOn' + group_id);
		var soloOff = document.getElementById('ogTasksPanelGroupSoloOff' + group_id);
		group.solo = !group.solo;
		
		soloOn.style.display = group.solo ? 'none':'inline';
		soloOff.style.display= group.solo ? 'inline':'none';
		
		for (var i = 0; i < this.Groups.length; i++){
			if (this.Groups[i].group_id != group_id){
				var groupEl = document.getElementById('ogTasksPanelGroupCont' + this.Groups[i].group_id);
				if (groupEl)
					groupEl.style.display = group.solo ? 'none':'block';
			}
		}
		
		if (group.solo)
			this.expandGroup(group_id);
		else
			this.collapseGroup(group_id);
	}
}



ogTasks.expandGroup = function(group_id){
	var div = document.getElementById('ogTasksGroupExpandTasks' + group_id);
	var divLink = document.getElementById('ogTasksGroupExpandTasksTitle' + group_id);
	if (div){
		div.style.display = 'block';
		divLink.style.display = 'none';
	}
}



ogTasks.collapseGroup = function(group_id){
	var div = document.getElementById('ogTasksGroupExpandTasks' + group_id);
	var divLink = document.getElementById('ogTasksGroupExpandTasksTitle' + group_id);
	if (div){
		div.style.display = 'none';
		divLink.style.display = 'block';
	}
}



ogTasks.drawAddTask = function(id_subtask, group_id, level){
	//Draw indentation
	var padding = (15 * (level + 1)) + 10;
	var html = '<div class="ogTasksTaskRow" style="padding-left:' + padding + 'px">';
	html += '<div class="ogTasksAddTask ico-add">';
	html += '<a href="#" class="internalLink"  onClick="ogTasks.drawAddNewTaskForm(\'' + group_id + '\', ' + id_subtask + ', ' + level + ')">' + ((id_subtask > 0)?lang('add subtask') : lang('add task')) + '</a>';
	html += '</div></div>';
	return html;
}



//************************************
//*		Draw task
//************************************

ogTasks.drawTask = function(task, drawOptions, displayCriteria, group_id, level){
	//Draw indentation
	var padding = 15 * level;
	var containerName = 'ogTasksPanelTask' + task.id + 'G' + group_id;
	task.divInfo[task.divInfo.length] = {group_id: group_id, drawOptions: drawOptions, displayCriteria: displayCriteria, group_id: group_id, level:level};
	
	var html = '<div class="ogTasksTaskRow"><div style="padding-left:' + padding + 'px" id="' + containerName + '">';
	
	html += this.drawTaskRow(task, drawOptions, displayCriteria, group_id, level);
	
	html += '</div></div>';
	if (task.subtasks.length > 0)
		html += this.drawSubtasks(task, drawOptions, displayCriteria, group_id, level);
	return html;
}

ogTasks.drawTaskRow = function(task, drawOptions, displayCriteria, group_id, level){
	var containerName = 'ogTasksPanelTask' + task.id + 'G' + group_id;
	var html = '<table id="ogTasksPanelTaskTableT' + task.id + 'G' + group_id + '" class="ogTasksTaskTable' + (task.isChecked?'Selected':'') + '" onmouseover="ogTasks.mouseMovement(' + task.id + ',\'' + group_id + '\',true)" onmouseout="ogTasks.mouseMovement(' + task.id + ',\'' + group_id + '\',false)"><tr>';
	
	//Draw checkbox
	var priorityColor = "white";
	switch(task.priority){
		case 300: priorityColor = "#D20"; break;
		case 200: priorityColor = "#D0E0F4"; break;
		default:
	}
	var checkboxName = 'ogTasksPanelChkT' + task.id + 'G' + group_id;
	html += '<td width=19 class="ogTasksCheckbox" style="background-color:' + priorityColor + '">';
	html += '<input style="width:14px;height:14px" type="checkbox" id="' + checkboxName + '" ' + (task.isChecked?'checked':'') + ' onchange="ogTasks.TaskSelected(this,' + task.id + ', \'' + group_id + '\')"/></td>'; 
	
	//Draw subtasks expander
	if (task.subtasks.length > 0){
		html += "<td width='16px' style='padding-top:3px'><div id='ogTasksPanelFixedExpanderT" + task.id + "G" + group_id + "' class='og-task-expander " + ((task.isExpanded)?'toggle_expanded':'toggle_collapsed') + "' onclick='ogTasks.toggleSubtasks(" + task.id +", \"" + group_id + "\")'></div></td>";
	}else{
		html += "<td width='16px'><div id='ogTasksPanelExpanderT" + task.id + "G" + group_id + "' style='visibility:hidden' class='og-task-expander ico-add ogTasksIcon' onClick='ogTasks.drawAddNewTaskForm(\"" + group_id + "\", " + task.id + "," + level +")' title='" + lang('add subtask') + "'></div></td>";
	}
	
	//Center td
	html += '<td align=left>';
	
	//Draw Workspaces
	if (drawOptions.show_workspaces){
		var ids = String(task.workspaceIds).split(',');
		var projectsString = "";
		for(var i = 0; i < ids.length; i++)
			if (!(displayCriteria.group_by == 'workspace' && group_id == ids[i]))
				projectsString += '<span class="project-replace">' + ids[i] + '</span>&nbsp;';
		html += projectsString;
	}
	
	var taskName = '';
	//Draw the Assigned user
	if (task.assignedToId && (displayCriteria.group_by != 'assigned_to' || task.assignedToId != group_id)){
		taskName += '<b>' + this.getUserCompanyName(task.assignedToId) + '</b>:&nbsp;';
	}
	
	//Draw the task name
	taskName += task.title;
	if (task.status > 0){
		var user = this.getUser(task.completedById);
		var tooltip = '';
		if (user){
			var time = new Date(task.completedOn * 1000);
			tooltip = lang('completed by name on', user.name, time.dateFormat('M j')).replace(/'\''/g, '\\\'');
		}
		taskName = "<span style='text-decoration:line-through' title='" + tooltip + "'>" + taskName + "</span>";
	}
	html += '<a class="internalLink" href="#" onclick="og.openLink(\'' + og.getUrl('task', 'view_task', {id: task.id}) + '\')">' + taskName + '</a>';
	
	//Draw dates
	if (drawOptions.show_dates){
		if (task.startDate || task.dueDate){
			html += '<span style="padding-left:12px;color:#888;font-size:10px">';
			if (task.startDate){
				var date = new Date(task.startDate * 1000);
				html += lang('start') + ':&nbsp;' + date.dateFormat('M j');
			}
			if (task.startDate && task.dueDate)
				html += '&nbsp;-&nbsp;';
			if (task.dueDate){
				var date = new Date(((task.dueDate) * 1000));
				if (task.status == 1){
					html += '<span style="text-decoration:line-through">';
					html += lang('due') + ':&nbsp;' + date.dateFormat('M j');
					html += '</span>';
				} else {
					var now = new Date();
					if ((date < now)){
						html += '<span style="font-weight:bold;color:#F00">';
						html += lang('due') + ':&nbsp;' + date.dateFormat('M j');
						html += '</span>';
					}
					else
						html += lang('due') + ':&nbsp;' + date.dateFormat('M j');
				}
			}
			html += '</span>';
		}
	}
	
	//Draw tags
	if (drawOptions.show_tags){
		if (task.tags){
			html += '<span style="padding-left:18px;padding-top:4px;padding-bottom:2px;color:#888;font-size:10px;margin-left:10px" class="ico-tags ogTasksIcon"><i>';
			html += task.tags;
			html += '</i></span>';
		}
	}
	
	html +='</td>';
	
	
	
	//Draw task actions
	html +="<td align=right><div id='ogTasksPanelTaskActionsT" + task.id + "G" + group_id + "' class='ogTaskActions'>";
	var renderTo = "ogTasksPanelTaskActionsT" + task.id + "G" + group_id + "Assign";
	var assignTo = this.drawUserCompanySelector(renderTo, task.assignedToId, task.id);
	html +="<table class='ogTasksPanelActionTable'><tr><td><div id='" + renderTo + "'>" + assignTo + "</div></td>";
	html += "<td style='padding-left:8px'><a href='#' onclick='ogTasks.ToggleCompleteStatus(" + task.id + ", " + task.status + ")'>";
	if (task.status > 0){
		html += "<div class='ico-reopen coViewAction' title='" + lang('reopen this task') + "' style='cursor:pointer;height:16px;padding-top:0px'>" + lang('reopen') + "</div></a>";
	} else {
		html +="<div class='ico-complete coViewAction' title='" + lang('complete this task') + "' style='cursor:pointer;height:16px;padding-top:0px'>" + lang('complete') + "</div></a>";
	}
	html +="</td></tr></table></div></td>";
	
	//Draw time tracking
	if (drawOptions.show_time){
		if (task.workingOnIds){
			var ids = (task.workingOnIds + ' ').split(',');
			var action = "start_work"; 
			for (var i = 0; i < ids.length; i++)
				if (ids[i] == this.currentUser.id)
					action = "close_work";
			html +="<td class='ogTasksActiveTimeTd'><table><tr><td>" ;
			html+="<a href='#' onclick='ogTasks.executeAction(\"" + action + "\",[" + task.id + "])'><div class='ogTasksTimeClock ico-time' title='" + lang(action) + "'></div></a></td><td style='white-space:nowrap'><b>";
			
			for (var i = 0; i < ids.length; i++){
				var user = this.getUser(ids[i]);
				if (user){
					html += "" + user.name;
					if (i < ids.length - 1)
						html += ",";
					html += "&nbsp;";
				}
			}
			html +="</b></td></tr></table>";
		}else{
			html +="<td class='ogTasksTimeTd'>" ;
			html+="<a href='#' onclick='ogTasks.executeAction(\"start_work\",[" + task.id + "])'><div class='ogTasksTimeClock ico-time' title='" + lang('start_work') + "'></div></a>";
		}
		html +="</td>";
	}
	
	html += '</tr></table>';
	return html;
}

ogTasks.drawSubtasks = function(task, drawOptions, displayCriteria, group_id, level){
	var html = '<div style="display:' + ((task.isExpanded)?'block':'none') + '" id="ogTasksPanelSubtasksT' + task.id + 'G' + group_id + '">';
	var orderedTasks = this.orderTasks(displayCriteria, task.subtasks);
	for (var i = 0; i < orderedTasks.length; i++){
		html += this.drawTask(orderedTasks[i], drawOptions, displayCriteria, group_id, level + 1);
	}
	html += this.drawAddTask(task.id, group_id, level);
	html += '</div>';
	return html;
}


ogTasks.ToggleCompleteStatus = function(task_id, status){
	var action = (status == 0)? 'complete_task' : 'open_task';
	
	og.openLink(og.getUrl('task', action, {id: task_id, quick: true}), {
		callback: function(success, data) {
			if (!success || data.errorCode) {
			} else {
				//Set task data
				var task = ogTasks.getTask(task_id);
				task.status = (status == 0)? 1 : 0;
				task.completedById = ogTasks.currentUser.id;
				var today = new Date();
				today = today.clearTime();
				task.completedOn = (today.format('U'));
				
				//Redraw task, or redraw whole panel
				var bottomToolbar = Ext.getCmp('tasksPanelBottomToolbarObject');
				var displayCriteria = bottomToolbar.getDisplayCriteria();
				if (displayCriteria.group_by != 'status')
					this.UpdateTask(task.id);
				else
					this.draw();
			}
		},
		scope: this
	});
}

ogTasks.UpdateTask = function(task_id){
	var task = ogTasks.getTask(task_id);
	for (var i = 0; i < task.divInfo.length; i++){
		var containerName = 'ogTasksPanelTask' + task.id + 'G' + task.divInfo[i].group_id;
		var div = document.getElementById(containerName);
		if (div){
			div.innerHTML = this.drawTaskRow(task, task.divInfo[i].drawOptions, task.divInfo[i].displayCriteria, task.divInfo[i].group_id, task.divInfo[i].level);
			if (task.divInfo[i].displayCriteria.group_by == 'milestone') { //Update milestone complete bar
				var div2 = document.getElementById('ogTasksPanelCompleteBar' + task.divInfo[i].group_id);
				div2.innerHTML = this.drawMilestoneCompleteBar(this.getGroup(task.divInfo[i].group_id));
			}
			og.showWsPaths(containerName);
		}
	}
}

ogTasks.drawUserCompanySelector = function(renderTo, assigned_to, task_id){
	var html = "";
	var name = lang('assign');

	html ="<div id='" + renderTo + "Header'>";
	/*if (assigned_to)
		html += lang('assigned to') + ':&nbsp';*/
	html += "<a href='#' onclick='ogTasks.ShowUserCompanySelector(\"" + renderTo + "\",\"" + assigned_to + "\"," + task_id + ")' title='" + lang('change user') + "'>" + name + "</a>";
		
	html +="</div><div id='" + renderTo + "Panel'></div>";
	return html;
}

ogTasks.ShowUserCompanySelector = function(controlName, assigned_to, task_id){
	document.getElementById(controlName + 'Header').style.display = 'none';
	document.getElementById(controlName + 'Panel').style.display = 'block';
	
	if (document.getElementById(controlName + 'Panel').innerHTML == ''){
		var combo = Ext.getCmp('ogTasksFilterNamesCompaniesCombo');
		var newCombo = combo.cloneConfig({
			id: (controlName + 'Combo'),
			renderTo: controlName + 'Panel',
			controlName: controlName,
			isInternalSelector: true,
			taskId : task_id,
			assignedTo : assigned_to,
			value: assigned_to
		});	
		newCombo.expand();
	}
}

ogTasks.UserCompanySelected = function(controlName, assigned_to, task_id){
	var name;
	if (assigned_to)
		name = '<span style="font-size:80%;color:#888"><i>' + lang('assigning to') + '&nbsp;' + this.getUserCompanyName(assigned_to) + '&hellip;&nbsp;&nbsp;</i></span>';
	this.changeAssignedToUser(task_id, assigned_to);
	
	document.getElementById(controlName + 'Panel').style.display = 'none';
	document.getElementById(controlName + 'Header').innerHTML = "<a href='#' onclick='og.ShowUserCompanySelector(\"" + controlName + "\",\"" + assigned_to + "\")' title='" + lang('change user') + "'>" + name + "</a>";
	document.getElementById(controlName + 'Header').style.display = 'block';
	
}