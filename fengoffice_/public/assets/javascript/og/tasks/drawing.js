/**
 * drawing.js
 *
 * This module holds the rendering logic for groups and tasks
 *
 * @author Carlos Palma <chonwil@gmail.com>
 */

//************************************
//*		<RX : dragging
//************************************

var rx__dd = 1000;
rx__TasksD = Ext.extend(Ext.dd.DDProxy, {
startDrag: function(x, y) {
	var dragEl = Ext.get(this.getDragEl());
	var el = Ext.get(this.getEl());
	
	if (!Ext.isIE) dragEl.applyStyles({'border':'1px solid gray;','border-width':'1px 1px 1px 6px','width':'auto','height':'auto','cursor':'move'});
	else dragEl.setWidth('auto');
	var task = ogTasks.getTask(this.config.dragData.i_t);
	var str = '';
	for (var i=0; i < rx__TasksDrag.tasks_to_edit.length; i++) {
		var t = ogTasks.getTask(rx__TasksDrag.tasks_to_edit[i]);
		str += (str == '' ? '' : '<hr />') + t.title;
	}
	dragEl.update(str);
	dragEl.addClass(el.dom.className + ' RX__tasks_dd-proxy'); 
},
onDragOver: function(e, targetId) {
    var target = Ext.get(targetId);
	if(targetId.indexOf(rx__TasksDrag.idGroup)>=0) /* group */ {
        this.lastTargetId = targetId;		
		this.lastGroupTargetId = targetId;
        target.addClass('RX__tasks_dd-over');
	}else if(targetId.indexOf(rx__TasksDrag.idTask)>=0) /* task */ {
        this.lastTargetId = targetId;				
        target.addClass('RX__tasks_dd-over');
	}else{
		//XXX: mark wrong target, check other options
	}
},
onDragOut: function(e, targetId) {
	var target = Ext.get(targetId);
	if(targetId.indexOf(rx__TasksDrag.idGroup)>=0) /* group */ {
        this.lastTargetId = ''; //targetId;		
        target.removeClass('RX__tasks_dd-over');
	}else if(targetId.indexOf(rx__TasksDrag.idTask)>=0) /* task */ {
        this.lastTargetId = this.lastGroupTargetId;				
        target.removeClass('RX__tasks_dd-over');
	}else{
		//XXX: mark wrong target, check other options
	}
},
endDrag: function() {
    var dragEl = Ext.get(this.getDragEl());
    var el = Ext.get(this.getEl());
    if(this.lastGroupTargetId) 
		Ext.get(this.lastGroupTargetId).removeClass('RX__tasks_dd-over');
	if(this.lastTargetId) 
		Ext.get(this.lastTargetId).removeClass('RX__tasks_dd-over');
	
	var targetId = this.lastTargetId;
	rx__TasksDrag.d = rx__TasksDrag.haveExtDD[this.lastGroupTargetId];
	rx__TasksDrag.p = rx__TasksDrag.haveExtDD[this.lastTargetId];
	rx__TasksDrag.t = this.config.dragData.i_t;
	rx__TasksDrag.g = this.config.dragData.i_g;
	this.lastTargetId = null;
	this.lastGroupTargetId = null;
	
	var doProcess = false;
	if (targetId) {
		if(targetId.indexOf(rx__TasksDrag.idGroup)>=0) /* group */ {
			doProcess = true;
			rx__TasksDrag.p = false;
		}else if(targetId.indexOf(rx__TasksDrag.idTask)>=0) /* task */ {
			doProcess = true;
		}else{
			//XXX: mark wrong target
		}
	}
	
	if(doProcess) {
		rx__TasksDrag.process();
		/*/ alert('From '+rx__TasksDrag.g+'.'+rx__TasksDrag.t+' to '+rx__TasksDrag.d+'.'+rx__TasksDrag.p+' ('+rx__TasksDrag.displayCriteria.group_by+')'); /* */
		//alert(dump(ogTasks.Groups));
	}else{
		//alert(targetId);
	}
}
});

var rx__TasksDrag = {
	t: false,
	g: false,
	d: false,
	p: false,
	tasks_to_edit: [],
	// (g::t)-->(d::p)
	displayCriteria: '',
	allowDrag: false,
	state: 'no',
	haveExtDD: {},
	full_redraw: false,

	classGroup: 'ogTasksGroup', //'ogTasksGroupHeader',
	idGroup: 'ogTasksPanelGroupCont', // 'ogTasksPanelGroup',
	classTask: 'ogTasksTaskTable',
	idTask: 'ogTasksPanelTaskTable',
	ddGroup: 'WorkspaceDD', // group
	dzClass: 'rx__hasDZ',
	
	initialize: function() {
		this.haveExtDD = {};
	},
	addTaskToMove: function(task_id) {
		task_id = task_id.toString();
		var index = this.tasks_to_edit.indexOf(task_id);
		if (index < 0) this.tasks_to_edit.push(task_id);
	},
	removeTaskToMove: function(task_id) {
		task_id = task_id.toString();
		var index = this.tasks_to_edit.indexOf(task_id);
		if (index > -1) this.tasks_to_edit.splice(index, 1);
	},
	prepareExt: function(t,g,id) {
		if(this.haveExtDD[id]) return;
		Ext.get(id).dd = new rx__TasksD(id, rx__TasksDrag.ddGroup, { scope: this, dragData: {i_t:t, i_g: g} });
		new Ext.dd.DropZone(id, {ddGroup: rx__TasksDrag.ddGroup});
		this.haveExtDD[id] = t; // true
		this.prepareDrops();
	},
	prepareDrops: function() {
		Ext.select('.'+rx__TasksDrag.classGroup).each( function(el) {
			if(el.hasClass(rx__TasksDrag.dzClass)) return;
			el.addClass(rx__TasksDrag.dzClass);
			id = el.dom.id;
			new Ext.dd.DropZone(id, {ddGroup: rx__TasksDrag.ddGroup});
			d = id.substr(rx__TasksDrag.idGroup.length, 66);
			rx__TasksDrag.haveExtDD[id] = d;
		} );
		Ext.select('.'+rx__TasksDrag.classTask).each( function(el) {
			if(el.hasClass(rx__TasksDrag.dzClass)) return;
			el.addClass(rx__TasksDrag.dzClass);
			id = el.dom.id;
			new Ext.dd.DropZone(id, {ddGroup: rx__TasksDrag.ddGroup});
			d = new String( id.substr(rx__TasksDrag.idTask.length, 66) );
			d = d.substr(1,d.indexOf('G')-1); // format: T{task_id}G{group_id}
			rx__TasksDrag.haveExtDD[id] = d;
		} );
	},
	prepareDrop: function(d,id) {
		if(this.haveExtDD[id]) return;
		/*Ext.get(id).dd =*/ new Ext.dd.DropZone(id, {ddGroup: rx__TasksDrag.ddGroup});
		this.haveExtDD[id] = d;
	},
	parametersFromTask: function(task, wrapper) {
		var parameters = [];
		
		// mandatory
		parameters["id"] = task.id;
		parameters["assigned_to_contact_id"] = task.assignedToId;
		parameters["milestone_id"] = task.milestoneId;
		parameters["priority"] = task.priority;
		parameters["title"] = task.title;
		parameters["text"] = task.description;
		
		var ehours = Math.floor(task.TimeEstimate / 60);
		var emins = task.TimeEstimate - ehours*60;
		parameters["hours"] = ehours;
		parameters["minutes"] = emins;
		
		// add dates to parameters
		if (task.dueDate) {
			var d1 = new Date();
			var seconds = task.dueDate + (task.useDueTime ? -og.loggedUser.tz * 3600 : 0);
			d1.setTime(seconds * 1000);
			parameters["task_due_date"] = d1.format(og.preferences['date_format']);
			if (task.useDueTime) {
				parameters["use_due_time"] = true;
				parameters["task_due_time"] = d1.format(og.config.time_format_use_24_duetime);
			}
		}
		if (task.startDate) {
			var d2 = new Date();
			var seconds = task.startDate + (task.useStartTime ? -og.loggedUser.tz * 3600 : 0);
			d2.setTime(seconds * 1000);
			parameters["task_start_date"] = d2.format(og.preferences['date_format']);
			if (task.useStartTime) {
				parameters["use_start_time"] = true;
				parameters["task_start_time"] = d2.format(og.config.time_format_use_24_duetime);
			}
		}
		
		if (wrapper) {
			var params2 = [];
			for (var i in parameters) {
				if (typeof(parameters[i]) == 'function') continue;
				if (parameters[i] || parameters[i] === 0) {
					params2[wrapper + "[" + i + "]"] = parameters[i];
				}
			}
			parameters = params2;
		}
		
		return parameters;
	},
	quickEdit: function(parameters) {
		
		var url = og.getUrl('task', 'quick_edit_multiple_task', {dont_mark_as_read:1});
	
		og.openLink(url, {
			method: 'POST',
			post: parameters,
			callback: function(success, data) {
				if (success && ! data.errorCode) {
					
					for (var k=0; k<data.tasks.length; k++) {
						var task = ogTasks.getTask(data.tasks[k].task.id);
						if (!task){
							var task = new ogTasksTask();
							task.setFromTdata(data.tasks[k].task);
							if (data.tasks[k].task.s) {
								task.statusOnCreate = data.tasks[k].task.s;
							}
							task.isCreatedClientSide = true;
							ogTasks.Tasks[ogTasks.Tasks.length] = task;
							var parent = ogTasks.getTask(task.parentId);
							if (parent){
								task.parent = parent;
								parent.subtasks[parent.subtasks.length] = task;
							}
						} else {
							task.setFromTdata(data.tasks[k].task);
							var parent = ogTasks.getTask(task.parentId);
							if (parent){
								task.parent = parent;
								parent.subtasks[parent.subtasks.length] = task;
							}
						}
						task.isChecked = false;
						if (data.tasks[k].subtasks && data.tasks[k].subtasks.length > 0) {
							ogTasks.setSubtasksFromData(task, data.tasks[k].subtasks);
						}
					}
					if(!rx__TasksDrag.full_redraw) ogTasks.redrawGroups = false;
					else rx__TasksDrag.full_redraw = true;
					ogTasks.draw();
					ogTasks.redrawGroups = true;
					rx__TasksDrag.haveExtDD = {};
				} else {
					if (!data.errorMessage || data.errorMessage == '') {
						og.err(lang("error adding task"));
					}
				}
			},
			scope: ogTasks
		});
		
	},
	process: function() {

		var all_parameters = [];
		this.addTaskToMove(this.t);
		
		for (var k = 0; k < this.tasks_to_edit.length; k++) {

			var task = ogTasks.getTask(this.tasks_to_edit[k]);
			
			this.p = parseInt(this.p);
			
			// non-edits
			if (this.g == this.d && !this.p) {
				// task is being dragged from group #G to group #G
				if (task.parentId != 0) {
					// however, the intention might be to un-attach the task from its parent (!)
					this.p = 0;
				} else return;
			}
			if (task.parentId == this.d && task.parentId) {// is the task being dragged as a subtask o its own parent?
				return;
			}
			
			// check for unwanted cycles - #t cannot be a predecessor of #p 
			var ti = this.p;
			var tiQ = {};
			while(ti!=0 && !tiQ[ti]) {
				if(ti == task.id) return;
				var tt = ogTasks.getTask(ti);
				if(!tt) break;
				tiQ[ti] = 1; // loop protection - mark visited vertices
				ti = tt.parentId;
			}
			
			// unattach from current parent
			if(task.parentId) {
				// delete task #t from the list of its parent subtasks 
				var parent = ogTasks.getTask(task.parentId);
				for(var i=parent.subtasks.length; i-->0;) { 
					if(parent.subtasks[i].id == task.id)
					{
						parent.subtasks.splice(i,1);
						break;
					}
				}
				// change task #t parent to #0
				for (var i = 0; i < ogTasks.Tasks.length; i++) {
					if (ogTasks.Tasks[i].id == task.id) {
						ogTasks.Tasks[i].parentId = 0;
						ogTasks.Tasks[i].parent = null;
						break;
					}
				}
			}
			
			// special edits
			switch(this.displayCriteria.group_by) {
				case 'status': ogTasks.ToggleCompleteStatus(task.id, 1-this.d); return; break;
				default:
			}
	
			var parameters = this.parametersFromTask(task);
			
			parameters['parent_id'] = this.p ? this.p : 0;
			parameters['apply_ws_subtasks'] = "checked";
			parameters['apply_milestone_subtasks'] = "checked";
		
			var group = ogTasks.getGroup(this.d);
			var group_not_empty = group && group.group_tasks && group.group_tasks.length > 0;
			
			// change
			switch (this.displayCriteria.group_by){
				case 'milestone':	parameters["milestone_id"] = this.d != 'unclassified' ? ogTasks.getMilestone(this.d).id : 0; parameters["keep_members"]=1;break;
				case 'priority':	parameters["priority"] = this.d != 'unclassified' ? parseInt(this.d) : 200; /*100,200,300*/ break;
				case 'assigned_to':	parameters["assigned_to_contact_id"] = this.d; parameters["keep_members"]=1; break;
				case 'due_date' : 	if(group_not_empty) parameters["task_due_date"] = group.group_tasks[0].dueDate; break;
				case 'start_date' : if(group_not_empty) parameters["task_start_date"] = group.group_tasks[0].startDate; break;
				case 'created_on' : if(group_not_empty) parameters["created_on"] = group.group_tasks[0].createdOn; break;
				case 'completed_on':if(group_not_empty) parameters["completed_on"] = group.group_tasks[0].completedOn.toString().format(lang('date format')); break;
				case 'created_by' :	parameters["created_by"] = this.d; /* ? */ break;
				case 'status' : 	parameters["status"] = this.d; /* done previously, special request */ break;
				case 'completed_by':parameters["completed_by"] = this.d; /* ? */ break;
				case 'subtype':parameters["object_subtype"] = this.d; /* ? */ break;
				default:
					if (this.displayCriteria.group_by.indexOf('dimension_') == 0) {
						// Group by dimension
						var dim_id = this.displayCriteria.group_by.replace('dimension_', '');
						parameters['member_id'] = this.d == 'unclassified' ? '0' : this.d;
						parameters['remove_from_dimension'] = dim_id;
					}
					break;
			}
			for (var n in parameters) {
				if (typeof(parameters[n]) == 'function') continue;
				all_parameters['tasks['+k+']['+n+']'] = parameters[n];
			}
		}
		
		rx__TasksDrag.full_redraw = true;
		this.tasks_to_edit = [];
		this.quickEdit(all_parameters);
		
	},
	onDragStart: function(t,g,id) {
		return false;
		/*if(this.state!='no') return false;
		this.t=t;
		this.g=g;
		this.state = 'md';
		return false;*/
	},
	last_oDO_e: null,
	markCursor: function(e,d) {
		if(this.last_oDO_e)
			this.last_oDO_e.style.cursor = 'auto';
		if(e)
			e.style.cursor = (d==this.g?'not-allowed':'crosshair')+' !important';
		this.last_oDO_e = e;
	},
	onDragOver: function(e,d) {
		if(this.state!='md') return false;
		if(this.last_oDO_e==e) return false;
			else this.markCursor(e,d);
		return false;
	},
	onDrop: function(d) {
		if(this.state!='md') return false;
		this.markCursor(null,d);
		this.d=d;
		this.state = 'no';
		return false;
	},
	showHandle: function(id,v) {
		if(!rx__TasksDrag.allowDrag || og.loggedUser.isGuest) return;
		var o = document.getElementById('RX__ogTasksPanelDrag'+id);
		var ine = Ext.get('ogTasksPanelAT');
		if(ine) if(ine.isVisible()) v = false;
		if(o) o.style.visibility = v?'visible':'hidden';
	}
};


//************************************
//*		Main function
//************************************

ogTasks.draw = function(){
	//first load the groups from server
	if(!ogTasks.Groups.loaded){
		ogTasks.getGroups();
		return;
	}
	ogTasks.Groups.loaded = false;
	
	if (typeof ogTasks.userPreferences.showTasksListAsGantt != 'undefined' && ogTasks.userPreferences.showTasksListAsGantt) {
		return;
	}
	
	ogTasks.currentUser.isWorking = false;
	var start = new Date(); 
	
	for (var i = 0; i < this.Tasks.length; i++)
		this.Tasks[i].divInfo = [];

	var bottomToolbar = Ext.getCmp('tasksPanelBottomToolbarObject');
	var topToolbar = Ext.getCmp('tasksPanelTopToolbarObject');
	
	if (!bottomToolbar || !topToolbar) return;
	
	var displayCriteria = bottomToolbar.getDisplayCriteria();
	var drawOptions = topToolbar.getDrawOptions();
		
	// *** <RX ***
	rx__TasksDrag.displayCriteria = displayCriteria;
	rx__TasksDrag.allowDrag = false;
	if( displayCriteria.group_by=='milestone' || displayCriteria.group_by=='priority' || displayCriteria.group_by=='assigned_to' 
		|| displayCriteria.group_by=='status' || displayCriteria.group_by=='subtype' || displayCriteria.group_by.indexOf('dimension_') == 0) {
		
		rx__TasksDrag.allowDrag = true;
	}
	// *** /RX ***
	
	//Drawing
	var sb = new StringBuffer();
	sb.append(ogTasks.newTaskFormTopList());	
	
	//Draw all groups
	for (var i = 0; i < this.Groups.length; i++){
		sb.append(this.drawGroup(displayCriteria, drawOptions, this.Groups[i]));				
	}
	
	// *** <RX ***
	if(this.Groups.length==0) {
		var context_names = og.contextManager.getActiveContextNames();
		if (context_names.length == 0) context_names.push(lang('all'));
		
		sb.append('<div id="rx__no_tasks_info">' +	
			'<div class="inner-message">'+lang('no tasks to display', '"'+context_names.join('", "')+'"')+ '</div>'+
		'</div>');	
	}
	// *** /RX ***
	
	var container = document.getElementById('tasksPanelContainer');
	container.innerHTML = '';
	
	container.innerHTML = sb.toString();
	
	ogTasks.resizeRows();
	if(this.Groups.length != 0) {
		ogTasks.drawAllGroupsTasks();
	}
}

og.eventManager.addListener('menu-panel expand', function() {
	ogTasks.resizeRowsDelay();
});

og.eventManager.addListener('menu-panel collapse', function() {
	ogTasks.resizeRowsDelay();
});

ogTasks.resizeRowsDelay = function(){
	var currentPanel = Ext.getCmp('tabs-panel').getActiveTab();
	if (currentPanel.id == 'tasks-panel') {
		setTimeout(function(){
			ogTasks.resizeRows();
		}, 200);
	}	
}

ogTasks.resizeRows = function(){
	$(".task-name-container").width('200px');
	var container_width = 0;
	$(".task-list-row-template").first().children().each(function() {
		container_width += $(this).outerWidth( true );
	});

	//set the width of the task panel container
	if(ogTasks.currentUser.isWorking){
		container_width = container_width + 60;
	}
	$("#tasksPanelContainer").width(container_width+40);
	
	//fill all the free space width the name of the task
	var name = $(".task-name-container").width() + $(".task-list-row-template").first().width() - container_width ;
	$(".task-name-container").width(name);	
		
	//name width of subtasks
	$('.subtasks-container .task-name-container').each(function(){
		var rest = $(".task-list-row-template").first().width() - $(this).closest(".task-list-row").width() - 15;		
	    $(this).width(name - rest);
	});
}

ogTasks.toggleSubtasks = function(taskId, groupId){
	var subtasksDiv = document.getElementById('ogTasksPanelSubtasksT' + taskId + 'G' + groupId);
	var expander = document.getElementById('ogTasksPanelFixedExpanderT' + taskId + 'G' + groupId);
	var task = this.getTask(taskId);
	
	if (subtasksDiv){
		task.isExpanded = !task.isExpanded;
		subtasksDiv.style.display = (task.isExpanded)? 'block':'none';		
	}else{
		if (task.subtasksIds.length > 0){
			task.isExpanded = !task.isExpanded;			
			og.getSubTasksAndDraw(task, groupId);
		}
				
	}
	expander.className = "og-task-expander " + ((task.isExpanded)?'toggle_expanded':'toggle_collapsed');
}

ogTasks.loadAllDescriptions = function(task_ids) {
	ogTasks.all_descriptions_loaded = false;
	og.openLink(og.getUrl('task', 'get_task_descriptions'), {
		hideLoading: true,
		scope: this,
		method: 'POST',
		post: {ids: task_ids.join(',')},
		callback: function(success, data) {
			for (i=0; i<ogTasks.Tasks.length; i++) {
				var task = ogTasks.Tasks[i];
				if (data.descriptions['t'+task.id]) {
					task.description = data.descriptions['t'+task.id];
				}
			}
			ogTasks.all_descriptions_loaded = true;
		}
	});
}

//************************************
//*		Draw group
//************************************

ogTasks.drawMilestoneCompleteBar = function(group){
	var html = '';
	var milestone = this.getMilestone(group.group_id);
	if (!milestone) return html;
	var complete = 0;
	var completedTasks = parseInt(milestone.completedTasks);
	var totalTasks =  parseInt(milestone.totalTasks);
	var tasks = this.flattenTasks(group.group_tasks);
	for (var i = 0; i < tasks.length; i++){
		var t = tasks[i];
		if (t.milestoneId == group.group_id){
			completedTasks += (t.status == 1 && (t.statusOnCreate == 0))? parseInt(1) : parseInt(0);
			completedTasks -= (t.status == 0 && (t.statusOnCreate == 1))? parseInt(1) : parseInt(0);
			totalTasks = (t.isCreatedClientSide)? totalTasks + parseInt(1) : totalTasks + parseInt(0);
		}
	}
	if (totalTasks > 0)
		complete = ((100 * completedTasks) / totalTasks);
	html += "<table><tr><td style='padding-left:15px;padding-top:5px'>" +
	"<table style='height:7px;width:50px'><tr><td style='height:7px;width:" + (complete) + "%;background-color:#6C2'></td><td style='width:" + (100 - complete) + "%;background-color:#DDD'></td></tr></table>" +
	"</td><td style='padding-left:3px;line-height:12px'><span style='font-size:8px;color:#AAA'>(" + completedTasks + '/' +  totalTasks + ")</span></td></tr></table>";

	return html;			
}

ogTasks.drawGroup = function(displayCriteria, drawOptions, group){
	var sb = new StringBuffer();
	
	sb.append("<div id='ogTasksPanelGroupCont" + group.group_id + "' class='ogTasksGroup' style='display:block;'><div id='ogTasksPanelGroup" + group.group_id + "' class='ogTasksGroupHeader' onmouseover='ogTasks.mouseMovement(null,\"" + group.group_id + "\",true)' onmouseout='ogTasks.mouseMovement(null,\"" + group.group_id + "\", false)'>");
	sb.append("<table width='100%'><tr>");
	sb.append('<td style="width:13px"><div style="width: 13px;" onclick="ogTasks.expandCollapseAllTasksGroup(\'' + group.group_id + '\')" class="og-task-expander toggle_expanded" id="ogTasksPanelGroupExpanderG' + group.group_id + '"></div></td>');
	sb.append('<td style="width:20px" title="'+lang('select all tasks')+'"><input style="width:14px;height:14px" type="checkbox" id="ogTasksPanelGroupChk' + group.group_id + '" ' + (group.isChecked?'checked':'') + ' onclick="ogTasks.GroupSelected(this,\'' + group.group_id + '\')"/></td>');
	
	sb.append("<td width='20px'><div class='db-ico " + group.group_icon + "'></div></td>");
	
	sb.append('<td>');
	switch (displayCriteria.group_by){
		case 'milestone':
			var milestone = this.getMilestone(group.group_id);
			if (milestone){
				if (milestone.isUrgent){
					sb.append("</td><td><div class='db-ico ico-urgent-milestone'></div></td><td>");
				}
				sb.append("<table><tr><td><div class='ogTasksGroupHeaderName'>");
				if (milestone.completedById){
					var user = this.getUser(milestone.completedById, true);
					var tooltip = '';
					if (user){
						var time = new Date(milestone.completedOn * 1000);
						var now = new Date();
						var timeFormatted = time.getYear() != now.getYear() ? time.dateFormat('M j, Y'): time.dateFormat('M j');
						tooltip = lang('completed by name on', og.clean(user.name), timeFormatted).replace(/'\''/g, '\\\'');
					}
					sb.append("<a href='#' style='text-decoration:line-through' class='internalLink' onclick='og.openLink(\"" + og.getUrl('milestone', 'view', {id: group.group_id}) + "\")' title='" + tooltip + "'>" + og.clean(group.group_name) + '</a></div></td>');
				}
				else
					sb.append("<a href='#' class='internalLink' onclick='og.openLink(\"" + og.getUrl('milestone', 'view', {id: group.group_id}) + "\")'>" + og.clean(group.group_name) + '</a></div></td>');
				
			} else {
				sb.append("<table><tr><td><div class='ogTasksGroupHeaderName'>" + og.clean(group.group_name) + '</div></td>');
			}
			sb.append("</tr></table>");
			break;
		default:
			sb.append("<div class='ogTasksGroupHeaderName'>" + og.clean(group.group_name) + '</div>');
	}
	sb.append("</td><td align='right'>");
	
	if(!drawOptions.show_subtasks_structure){
	//	sb.append("<div class='ogTasksGroupHeaderName' style='font-size: 14px;margin-right: 10px;'>" + lang('total') + ": " + + og.clean(group.real_total) + '</div>');
	}

	var transparent_style = "opacity:0.35;filter:alpha(opacity=35);";
	if (displayCriteria.group_by == 'milestone' && this.getMilestone(group.group_id)){
		var milestone = this.getMilestone(group.group_id);
		sb.append("<table><tr>");
		if (drawOptions.show_dates){
			sb.append('<td><span style="padding-left:12px;color:#888;">');
			var date = new Date();
			date.setTime((milestone.dueDate + date.getTimezoneOffset()*60)* 1000);
			var now = new Date();
			var dateFormatted = date.getYear() != now.getYear() ? date.dateFormat('M j, Y'): date.dateFormat('M j');
			if (milestone.completedById > 0){
				sb.append('<span style="text-decoration:line-through">' +  lang('due') + ':&nbsp;' + dateFormatted + '</span>');
			} else {
				if ((date < now))
					sb.append('<span style="font-weight:bold;color:#F00">' + lang('due') + ':&nbsp;' + dateFormatted + '</span>');
				else
					sb.append(lang('due') + ':&nbsp;' + dateFormatted);
			}
			sb.append('</span></td>');
		}
		sb.append("<td><div id='ogTasksPanelCompleteBar" + group.group_id + "'>" + this.drawMilestoneCompleteBar(group) + "</div></td>");
		sb.append("<td></td></tr></table>");
	} else {
		//sb.append("<div class='ogTasksGroupHeaderActions' style='"+transparent_style+"' id='ogTasksPanelGroupActions" + group.group_id + "'>" + this.drawGroupActions(group) + '</div>');
	}
	sb.append('</td></tr></table></div>');
	//35
	sb.append("<div id='ogTasksPanelTaskRowsContainer" + group.group_id + "'>");
	
	//draw the group's tasks
	group.isExpanded = ogTasks.expandedGroups.indexOf(group.group_id) > -1;
	
	/*for (var i = 0; i < group.group_tasks.length; i++){
		if (i == og.noOfTasks){//Draw expander if group has more than og.noOfTasks tasks
			sb.append("<div class='ogTasksTaskRow' style='display:" + (group.isExpanded? "none" : "inline") + "' id='ogTasksGroupExpandTasksTitle" + group.group_id + "'>");
			sb.append("<a href='#' class='internalLink' onclick='ogTasks.expandGroup(\"" + group.group_id + "\")'>" + lang('show more tasks number', (group.group_tasks.length - i)) + "</a>");
			sb.append("</div>");
			sb.append("<div id='ogTasksGroupExpandTasks" + group.group_id + "'>");
			if (group.isExpanded){
				for (var j = og.noOfTasks; j < group.group_tasks.length; j++){
					sb.append(this.drawTask(group.group_tasks[j], drawOptions, displayCriteria, group.group_id, 1));
				}
			}
			sb.append("</div>");
			break;
		}
		sb.append(this.drawTask(group.group_tasks[i], drawOptions, displayCriteria, group.group_id, 1));
	}*/

	var time_estimated = 0;	
	
	//if (drawOptions.show_time_estimates) {
		//format_group_totals.total_tasks = group.total;
		/*for (var key in group_totals) {
			format_group_totals[key] = ogTasks.minutesToHoursAndMinutes(group_totals[key]);
		}*/
		
		sb.append("</div><div>");
		sb.append(ogTasks.newTaskGroupTotals(group));
	//}
	sb.append("</div></div>");
	return sb.toString();
}

ogTasks.minutesToHoursAndMinutes = function(minutes){
	var total_estimate_split = Math.round(minutes * 100 / 60) / 100;
	var total_estimate = (total_estimate_split + '').split(".");
	var hours_estimate = total_estimate[0] + " " + lang('hours');
	var minutes_estimate = "";
	if (total_estimate[1]) {
		if (total_estimate[1].length == 1) {
			minutes_estimate = ", " + Math.round(((total_estimate[1] * 60) / 10)) + " " + lang('minutes');
		} else {
			minutes_estimate = ", " + Math.round(((total_estimate[1] * 60) / 100)) + " " + lang('minutes');
		}
		var format_total_estimate = hours_estimate + minutes_estimate;
	} else {
		var format_total_estimate = hours_estimate;
	}
	return format_total_estimate;
}

ogTasks.drawGroupActions = function(group){
	var html = '<a id="ogTasksPanelGroupSoloOn' + group.group_id + '" style="margin-right:15px;display:' + (group.solo? "none" : "inline") + '" href="#" class="internalLink" onClick="ogTasks.hideShowGroups(\'' + group.group_id + '\')" title="' + lang('hide other groups') + '">' + (lang('hide others')) + '</a>' +
	'<a id="ogTasksPanelGroupSoloOff' + group.group_id + '" style="display:' + (group.solo? "inline" : "none") + ';margin-right:15px;" href="#" class="internalLink" onClick="ogTasks.hideShowGroups(\'' + group.group_id + '\')" title="' + lang('show all groups') + '">' + (lang('show all')) + '</a>' +
	'<a href="#" class="internalLink ogTasksGroupAction ico-print" style="margin-right:15px;" onClick="ogTasks.printGroup(\'' + group.group_id + '\')" title="' + lang('print this group') + '">' + (lang('print')) + '</a>';
	if (ogTasks.userPermissions.can_add) {
		html += '<a href="#" class="internalLink ogTasksGroupAction ico-add" onClick="ogTasks.drawAddNewTaskForm(\'' + group.group_id + '\')" title="' + lang('add a new task to this group') + '">' + (lang('add task')) + '</a>';
	}
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
		var group = this.getGroup(group_id);
		group.isExpanded = true;
		var html = '';
		var bottomToolbar = Ext.getCmp('tasksPanelBottomToolbarObject');
		var topToolbar = Ext.getCmp('tasksPanelTopToolbarObject');
		var displayCriteria = bottomToolbar.getDisplayCriteria();
		var drawOptions = topToolbar.getDrawOptions();
		for (var i = og.noOfTasks; i < group.group_tasks.length; i++)
			html += this.drawTask(group.group_tasks[i], drawOptions, displayCriteria, group.group_id, 1);
		div.innerHTML = html;
		divLink.style.display = 'none';
		ogTasks.expandedGroups.push(group.group_id);
		
		//init action btns
		var btns = $("#ogTasksGroupExpandTasks"+ group_id +" .tasksActionsBtn").toArray();
		og.initPopoverBtns(btns);
		
		//resize rows
		ogTasks.resizeRows();
		
		//init breadcrumbs
		og.eventManager.fireEvent('replace all empty breadcrumb', null);
		
/*		if (drawOptions.show_workspaces)
			og.showWsPaths('ogTasksGroupExpandTasks' + group_id);*/
	}
}



ogTasks.collapseGroup = function(group_id){
	var div = document.getElementById('ogTasksGroupExpandTasks' + group_id);
	var divLink = document.getElementById('ogTasksGroupExpandTasksTitle' + group_id);
	if (div){
		var group = this.getGroup(group_id);
		group.isExpanded = false;
		div.innerHTML = '';
		divLink.style.display = 'block';
	}
}

ogTasks.expandCollapseAllTasksGroup = function(group_id) {
	var group = this.getGroup(group_id);
	if (group){
		var expander = document.getElementById('ogTasksPanelGroupExpanderG' + group_id);
		if (group.alltasks_collapsed) {
			group.alltasks_collapsed = false;
			if (expander) expander.className = 'og-task-expander toggle_expanded';
		} else {
			group.alltasks_collapsed = true;
			if (expander) expander.className = 'og-task-expander toggle_collapsed';
		}
		
		$("#ogTasksPanelTaskRowsContainer" +  group.group_id).slideToggle();
	}
}


ogTasks.drawAddTask = function(id_subtask, group_id, level){
	//Draw indentation
	// FIXME: quick add task
	var padding = (15 * (level + 1)) + 10;
	return '<div class="ogTasksTaskRow" style="padding-left:' + padding + 'px">' + 
	'</div>';
		
}



//************************************
//*		Draw task
//************************************

ogTasks.drawGroupTasks = function(group){
	var bottomToolbar = Ext.getCmp('tasksPanelBottomToolbarObject');
	var topToolbar = Ext.getCmp('tasksPanelTopToolbarObject');
	
	var displayCriteria = bottomToolbar.getDisplayCriteria();
	var drawOptions = topToolbar.getDrawOptions();
	group.isExpanded = ogTasks.expandedGroups.indexOf(group.group_id) > -1;
	
	for (var i = 0; i < group.group_tasks_order.length; i++){
		var task_id = group.group_tasks_order[i];	
		ogTasks.drawTask(group.group_tasks[task_id], drawOptions, displayCriteria, group.group_id, 1);				
	}	
};

ogTasks.drawAllGroupsTasks = function(){
	og.loading();
	for (var i = 0; i < ogTasks.Groups.length; i++){
		setTimeout(function(){ 
			var last = false;
			for (var j = 0; j < ogTasks.Groups.length; j++){
				if(j == ogTasks.Groups.length - 1){
					last = true;
				}
				var group = ogTasks.Groups[j];	
				if(!group.rendering){
					group.rendering = true;
					ogTasks.drawGroupTasks(group);
					break;
				}
			};
			//last iteration
			ogTasks.resizeRows();
			if(last){
				//start all clocks on the list
				var clocks = $(".og-timeslot-work-started span");
				
				for (i = 0; i < clocks.length; i++) { 
					var clockId = clocks[i].id;
					clockId = clockId.replace("timespan", "");
					var user_start_time = parseInt($("#"+clockId+"user_start_time").val());
					
					og.startClock(clockId,user_start_time);
				}
				
				
				$("#tasksPanel").parent().css('overflow', 'hidden');
								
				var btns = $(".tasksActionsBtn").toArray();			
				og.initPopoverBtns(btns);
								
				og.eventManager.fireEvent('replace all empty breadcrumb', null);
				og.hideLoading();
			}
		}, (100*i));
	};
};

ogTasks.drawTask = function(task, drawOptions, displayCriteria, group_id, level, target, returnHtml){
	//Draw indentation
	var padding = 15 * level;
	var containerName = 'ogTasksPanelTask' + task.id + 'G' + group_id;
	task.divInfo[task.divInfo.length] = {group_id: group_id, drawOptions: drawOptions, displayCriteria: displayCriteria, group_id: group_id, level:level};

	// **** <RX : dragging **** //
	var rx__drag_h = '';
	var tgId = "T" + task.id + 'G' + group_id;
	
	var html = '<div style="padding-left:' + padding + 'px" id="' + containerName + '" class="RX__tasks_row level-'+level+'">' + rx__drag_h 
		 + this.drawTaskRow(task, drawOptions, displayCriteria, group_id, level) + '</div>';
		
	if (typeof returnHtml != 'undefined') {
		return html;
	}else if (typeof target != 'undefined') {
		$(target).append(html);	
	}else{
		$("#ogTasksPanelTaskRowsContainer"+group_id).append(html);	
	}
}

ogTasks.removeTaskFromView = function(task) {
	$("[id^='ogTasksPanelTask" + task.id + "']").each(function( index ) {
		$(this).remove();
	});
	
	//parent
	if(task.parentId > 0){
		var parent = ogTasksCache.getTask(task.parentId);
		if(parent.subtasksIds.length == 0){
			ogTasks.reDrawTask(parent);
		}
	}
}

ogTasks.reDrawTask = function(task) {
	var bottomToolbar = Ext.getCmp('tasksPanelBottomToolbarObject');
	var topToolbar = Ext.getCmp('tasksPanelTopToolbarObject');	
	var displayCriteria = bottomToolbar.getDisplayCriteria();
	var drawOptions = topToolbar.getDrawOptions();
	
	//parent
	if(drawOptions.show_subtasks_structure){
		if(task.parentId > 0){
			var parent = ogTasksCache.getTask(task.parentId);
			
			//if is not rendered and is subtask?
			if($("[id^='ogTasksPanelTask" + task.id + "']").length == 0){
				$("[id^='ogTasksPanelSubtasksT" + parent.id + "']").each(function( index ) {
					var group_id = $(this).attr('id');
					var remove = "ogTasksPanelSubtasksT" + task.id + "G";
					group_id = group_id.replace(remove, "");
					
					var html = ogTasks.drawTask(task, drawOptions, displayCriteria, group_id, 1, null,true);
					$(this).append(html);
					//init action btns
					var btns = $("#ogTasksPanelTask" + task.id + "G"+group_id +" .tasksActionsBtn").toArray();
					og.initPopoverBtns(btns);
					
				});	
				ogTasks.reDrawTask(parent);
			}			
		}else{
			//if is not rendered redraw all groups from server
			if($("[id^='ogTasksPanelTask" + task.id + "']").length == 0){
				ogTasks.Groups.loaded = false;
				ogTasks.draw();
				return;
			}
		}
	}else{
		//if is not rendered redraw all groups from server
		if($("[id^='ogTasksPanelTask" + task.id + "']").length == 0){
			ogTasks.Groups.loaded = false;
			ogTasks.draw();
			return;
		}
	}
	
	$("[id^='ogTasksPanelTask" + task.id + "']").each(function( index ) {
		var group_id = $(this).attr('id');
		var remove = "ogTasksPanelTask" + task.id + "G";
		group_id = group_id.replace(remove, "");
		
		for (var j = 0; j < ogTasks.Groups.length; j++){
			var group = ogTasks.Groups[j];	
			if(group.group_id == group_id){
				var html = ogTasks.drawTask(task, drawOptions, displayCriteria, group_id, 1, null,true);
				$("#ogTasksPanelTask" + task.id + "G"+group_id).replaceWith(html);
				//init action btns
				var btns = $("#ogTasksPanelTask" + task.id + "G"+group_id +" .tasksActionsBtn").toArray();
				og.initPopoverBtns(btns);		
							
				break;
			}
		};
		
	});	
	
	//start all clocks on the list
	var clocks = $(".og-timeslot-work-started span");
	
	for (i = 0; i < clocks.length; i++) { 
		var clockId = clocks[i].id;
		clockId = clockId.replace("timespan", "");
		var user_start_time = parseInt($("#"+clockId+"user_start_time").val());
		
		og.startClock(clockId,user_start_time);
	}	
	
	ogTasks.resizeRows();	
	
	og.eventManager.fireEvent('replace all empty breadcrumb', null);	
}

ogTasks.drawTaskRow = function(task, drawOptions, displayCriteria, group_id, level){
	var sb = new StringBuffer();
	var tgId = "T" + task.id + 'G' + group_id;

	//checkbox container class by priority
	var priorityColor = "priority-default";
	if (typeof task.priority != 'undefined') {
		priorityColor = "priority-"+task.priority;
	}
	
	//subtask expander
	var subtasksExpander = "";
	
	if(drawOptions.show_subtasks_structure){
		if (task.subtasksIds.length > 0){
			if (task.isExpanded){
				subtasksExpander = "toggle_expanded";
			}else{
				subtasksExpander = "toggle_collapsed";
			}	 
		}
	}
	
	
	//Draw the Assigned user
	var assignedTo = false;
	if (task.assignedToId){
		assignedTo = og.allUsers[task.assignedToId];		
	}
	
	//Draw the Assigned user
	var assignedBy = false;
	if (task.assignedById){
		assignedBy = og.allUsers[task.assignedById];		
	}
	
	//Draw the task name
	taskName = task.title;
	var tooltip = '';
	//if is completed
	if (task.status > 0){
		var user = this.getUser(task.completedById, true);
		if (user){
			var time = new Date(task.completedOn * 1000);
			var now = new Date();
			var timeFormatted = time.getYear() != now.getYear() ? time.dateFormat('M j, Y'): time.dateFormat('M j');
			tooltip = lang('completed by name on', og.clean(user.name), timeFormatted).replace(/'\''/g, '\\\'');
		}		
	}
	
	//Member Path
	mem_path = "";
	var mpath = Ext.util.JSON.decode(task.memPath);
	if (mpath) mem_path = og.getEmptyCrumbHtml(mpath,".task-breadcrumb-container");
	
	//Dates
	var start_date = '';
	if (task.startDate){
        var date = new Date(task.startDate * 1000);
        date = new Date(Date.parse(date.toUTCString().slice(0, -4)));
        var hm_format = task.useStartTime ? (og.preferences['time_format_use_24'] == 1 ? ' <br> G:i' : ' <br> g:i A') : '';
        var now = new Date();
        var dateFormatted = date.getYear() != now.getYear() ? date.dateFormat('M j, Y' + hm_format): date.dateFormat('M j' + hm_format);
        start_date = dateFormatted;
	}
	var due_date = '';
	var due_date_late = false;
	if (task.dueDate){
	        var date = new Date((task.dueDate) * 1000);
	        date = new Date(Date.parse(date.toUTCString().slice(0, -4)));
	        var hm_format = task.useDueTime ? (og.preferences['time_format_use_24'] == 1 ? ' <br> G:i' : ' <br> g:i A') : '';
	        var now = new Date();
	        var dateFormatted = date.getYear() != now.getYear() ? date.dateFormat('M j, Y' + hm_format): date.dateFormat('M j' + hm_format);
	        due_date = dateFormatted;	
	        
	        if (task.status == 0 && date < now) {
	        	due_date_late = true;
	        }
	}
	
	//Draw time tracking
	var userIsWorking = false;
	var userPaused = false;
	var userStartTime = 0;
	var userState = 'started';
	var userPausedTime = '';
	var workingOnUsers = new Array();
	var showWorkingOnUsers = false;
	if (drawOptions.show_time){
		//is working
		if (task.workingOnIds){
			var ids = (task.workingOnIds + ' ').split(',');
			for (var i = 0; i < ids.length; i++) {
				if (this.currentUser && ids[i] == this.currentUser.id){
					userIsWorking = true;
					ogTasks.currentUser.isWorking = true;
					userStartTime = task.workingOnTimes[i];
					var pauses = (task.workingOnPauses + ' ').split(',');
					userPaused = pauses[i] == 1;
					if(userPaused){
						userState = 'paused';
						userPausedTime = og.calculateTimeForClock(new Date(),userStartTime);
					}
				}else{
					var usrId = parseInt(ids[i]);
					workingOnUsers.push(og.allUsers[usrId]);
					showWorkingOnUsers = true;
				}
			}		
		}		
	}
	
	//task actions
	var taskActions = new Array();
	taskActions.push({
		act_collapsed: true,
		act_onclick: "ogTasks.AddWorkTime", 
		act_onclick_param: [{param_val: task.id}],
		act_text: lang('add work'), 
		act_class: "ico-time-s coViewAction"
	});	
	taskActions.push({
		act_collapsed: !drawOptions.show_quick_add_sub_tasks,
		act_onclick: "ogTasks.drawAddNewTaskForm", 
		act_onclick_param: [{param_val: "'"+group_id+"',"},{param_val: task.id+","},{param_val: level}],
		act_text: lang('add subtask'), 
		act_id: "ogTasksPanelExpander"+tgId,
		act_class: "add-subtask-link ico-add coViewAction"
	});
	taskActions.push({
		act_collapsed: !drawOptions.show_quick_edit,
		act_onclick: "ogTasks.drawEditTaskForm",
		act_onclick_param: [{param_val: task.id+","},{param_val: "'"+group_id+"'"}],
		act_text: lang('edit'), 
		act_class: "ico-edit coViewAction"
	});
	if(task.status){
		taskActions.push({
			act_collapsed: !drawOptions.show_quick_complete,
			act_onclick: "ogTasks.ToggleCompleteStatus",
			act_onclick_param: [{param_val: task.id+","},{param_val: task.status}],
			act_text: lang('reopen this task'), 
			act_class: "ico-reopen coViewAction"
		});
	}else{
		taskActions.push({
			act_collapsed: !drawOptions.show_quick_complete,
			act_onclick: "ogTasks.ToggleCompleteStatus",
			act_onclick_param: [{param_val: task.id+","},{param_val: task.status}],
			act_text: lang('complete this task'), 
			act_class: "ico-complete coViewAction"
		});
	}
	//mark the last collapsed action with a bool
	for(var i = taskActions.length; i > 0; i--){
		if(taskActions[i-1].act_collapsed){
			taskActions[i-1].act_last = true;	    	
	    	break;
	    }
	}
	
	var show_quick_actions_container = false;
	for(var i = taskActions.length; i > 0; i--){
		if(!taskActions[i-1].act_collapsed){
			show_quick_actions_container = true;
	    }
	}
		
	var row_total_cols = [];
	for (var key in ogTasks.TotalCols){
		var row_field = ogTasks.TotalCols[key].row_field;
		var color = '#888';
		if(row_field == 'worked_time_string' && task.pending_time < task.worked_time){
			color = '#f00';
		}
		row_total_cols.push({text : task[row_field], color: color});
	}
	
	//get template for the row
	if(typeof ogTasks.task_list_row_template == "undefined"){
		var source = $("#task-list-row-template").html(); 
		//compile the template
		var template = Handlebars.compile(source);
		ogTasks.task_list_row_template = template;		
	}
	
	
	//template data
	var data = {
			task: task,
			task_actions: taskActions,
			show_quick_actions_container: show_quick_actions_container,
			genid: og.genid,
			start_date : start_date,
			due_date : due_date,
			due_date_late : due_date_late,
			draw_options : drawOptions,
			subtasksExpander: subtasksExpander,
			priorityColor: priorityColor,
			tgId: tgId,
			group_id: "'"+group_id+"'",
			assigned_to : assignedTo,
			assigned_by : assignedBy,
			rx__dd : ++rx__dd,
			rx__TasksDrag : rx__TasksDrag,
			view_url :  og.getUrl('task', 'view', {id: task.id}),
			task_name : taskName,
			tool_tip : tooltip,
			mem_path: mem_path,
			percent_completed_bar : ogTasks.buildTaskPercentCompletedBar(task),
			level : level,
			user_is_working : userIsWorking,
			user_paused : userPaused,
			user_paused_time : userPausedTime,
			user_state : userState,
			user_start_time : userStartTime,
			working_on_users : workingOnUsers,
			show_working_on_users : showWorkingOnUsers,
			row_total_cols : row_total_cols
	}
	
	//instantiate the template
	var html = ogTasks.task_list_row_template(data);
	
	sb.append(html);
	return sb.toString();
}

ogTasks.closeTimeslot = function(tId){
	if(og.config.tasks_show_description_on_time_forms){
		//get template
		var source = $("#small-task-timespan-template").html(); 
		//compile the template
		var template = Handlebars.compile(source);
		
		//template data
		var data = {
				taskId: tId,			
				genid: og.genid
		}
		
		//instantiate the template
		var html = template(data);
			
		var modal_params = {
				'escClose': true,
				'overlayClose': true,
				'minWidth' : 400,
				'minHeight' : 200,
				'closeHTML': '<a id="ogTasksPanelAT_close_link" class="modal-close modal-close-img"></a>'
			};
		
			
		$.modal(html,modal_params);
				
		$( "#small-task-timespan-modal-form"+og.genid ).submit(function( event ) {
			var parameters = [];
			var form_params = $( this ).serializeArray();
			
			for (i = 0; i < form_params.length; i++) { 
				    parameters[form_params[i].name] = form_params[i].value;
			}
					
			ogTasks.executeAction("close_work",tId,parameters['timeslot[description]']);
			
			ogTasks.closeModal();
			
			event.preventDefault();
		});	
	}else{
		ogTasks.executeAction("close_work",tId);
	}
}

ogTasks.drawSubtasks = function(params){	
	var task = ogTasksCache.getTask(params.task_id);
	var group_id = params.group_id;
		
	var $task_view = $('#ogTasksPanelTask' + task.id + 'G' + group_id);
	var subtasks_container_id = 'ogTasksPanelSubtasksT' + task.id + 'G' + group_id;
	
	var html = '<div class="subtasks-container" style="margin-left: '+ $task_view.css( "padding-left" )+'; display:' + ((task.isExpanded)?'block':'none') + '" id="' + subtasks_container_id +'"></div>';
	
	$task_view.after(html);	
	
	var bottomToolbar = Ext.getCmp('tasksPanelBottomToolbarObject');
	var topToolbar = Ext.getCmp('tasksPanelTopToolbarObject');	
	var displayCriteria = bottomToolbar.getDisplayCriteria();
	var drawOptions = topToolbar.getDrawOptions();
		
	var target = "#"+subtasks_container_id;
	for (var i = 0; i < task.subtasksIds.length; i++){
		var subtask = ogTasks.getTask(task.subtasksIds[i]);
		ogTasks.drawTask(subtask, drawOptions, displayCriteria, group_id, 1, target);
	}	
	
	ogTasks.resizeRows();
	
	og.eventManager.fireEvent('replace all empty breadcrumb', null);
}
                    
ogTasks.ToggleCompleteStatus = function(task_id, status) {
	var related = false;
	if (status == 0) {
		var task = ogTasks.getTask(task_id);
		for ( var j = 0; j < task.subtasks.length; j++) {
			if (task.subtasks[j].status == 0) {
				related = true;
			}
			if (related) {
				break;
			}
		}
	}

	if (related) {
		this.dialog = new og.TaskCompletePopUp(task_id);
		this.dialog.setTitle(lang('do complete'));
		this.dialog.show();
	} else {
		ogTasks.ToggleCompleteStatusOk(task_id, status, '');
	}
}

ogTasks.ToggleCompleteStatusOk = function(task_id, status, opt){
	var action = (status == 0)? 'complete_task' : 'open_task';
	og.openLink(og.getUrl('task', action, {id: task_id, quick: true, options: opt}), {
		callback: function(success, data) {
			if (!success || data.errorCode) {
				
			} else {
				//Set task data
				var task = ogTasksCache.addTasks(data.task);
				ogTasks.UpdateTask(task.id,false);
				
				ogTasks.refreshGroupsTotals();
			}
		},
		scope: this
	});
}

ogTasks.AddWorkTime = function(task_id) {
	//get template
	var source = $("#task-timespan-template").html(); 
	//compile the template
	var template = Handlebars.compile(source);
	
	var minutes = new Array();
	for (i = 0; i < 61; i=i+5) { 
		minutes.push({minute:i});
	}
	
	//template data
	var data = {
			taskId: task_id,
			minutes: minutes,
			showDesc: og.config.tasks_show_description_on_time_forms,
			genid: og.genid
	}
	
	//instantiate the template
	var html = template(data);
	
		
	var modal_params = {
			'escClose': true,
			'minWidth' : 390,
			'minHeight' : 300,
			'overlayClose': true,
			'closeHTML': '<a id="ogTasksPanelAT_close_link" class="modal-close modal-close-img"></a>'
		};
		
	$.modal(html,modal_params);
	
	// DatePicker Menu  
	var dateCond = new og.DateField({
		renderTo:'datepicker'+og.genid,
		name: 'timeslot[date]',
		id: 'timeslot[date]',
		value: Ext.util.Format.date(new Date(), og.preferences['date_format']),
		tabIndex: 70
	});
	 	
	$( "#task-timespan-modal-form"+og.genid ).submit(function( event ) {
		var parameters = [];
		var form_params = $( this ).serializeArray();
		
		for (i = 0; i < form_params.length; i++) { 
			    parameters[form_params[i].name] = form_params[i].value;
		}
		parameters.use_current_time = true;
		og.openLink(
				og.getUrl('time','add_timeslot'),
				{ method:'POST' , 
					post:parameters,
					callback:function(success, data){
						if (!success || data.errorCode) {
						} else {
							ogTasks.closeModal();							
							ogTasks.UpdateTask(data.real_obj_id, true);
						}						
					}
				}
			);		 
		
		event.preventDefault();
	});
}


ogTasks.readTask = function(task_id,isUnRead){
	var task = ogTasks.getTask(task_id);
	if (!isUnRead){
		og.openLink(
			og.getUrl('task','multi_task_action'),
			{ method:'POST' ,	post:{ids:task_id, action:'markasread'},callback:function(success, data){
					if (!success || data.errorCode) {
					} else {
						var td = document.getElementById('ogTasksPanelMarkasTd' + task_id);
						td.innerHTML = "<div title=\"" + lang('mark as unread') + "\" id=\"readunreadtask" + task_id + "\" class=\"db-ico ico-read\" onclick=\"ogTasks.readTask(" + task_id + ",true)\" />";
						task.isRead = true;
					}
				}
			}
		);
	}else{
		og.openLink(
			og.getUrl('task','multi_task_action'),
			{ method:'POST' ,	post:{ids:task_id, action:'markasunread'},callback:function(success, data){
					if (!success || data.errorCode) {
					} else {								
						var td = document.getElementById('ogTasksPanelMarkasTd' + task_id);
						td.innerHTML = "<div title=\"" + lang('mark as read') + "\" id=\"readunreadtask" + task_id + "\" class=\"db-ico ico-unread\" onclick=\"ogTasks.readTask(" + task_id + ",false)\" />";
						task.isRead = false;
					}
				}
			}
		);
	}
}

ogTasks.UpdateTask = function(task_id, from_server){
	if (typeof from_server != 'undefined' && from_server) {
		og.openLink(og.getUrl('task', 'get_task_data', {id: task_id, task_info: true}), {
			callback: function(success, data) {
				if (!success || data.errorCode) {
					
				} else {
					//Set task data
					ogTasks.drawTaskRowAfterEdit(data);							
				}
			},
			scope: this
		});
	}else{
		var task = ogTasksCache.getTask(task_id);
		ogTasks.reDrawTask(task);	
	}	
}

ogTasks.buildTaskPercentCompletedBar = function(task) {
	var color_cls = 'task-percent-completed-';
	
	if (task.percentCompleted < 25) color_cls += '0';
	else if (task.percentCompleted < 50) color_cls += '25';
	else if (task.percentCompleted < 75) color_cls += '50';
	else if (task.percentCompleted < 100) color_cls += '75';
        else if (task.percentCompleted == 100) color_cls += '100';
	else color_cls += 'more-estimate';
        
        var percent_complete = 100;
        if(task.percentCompleted <= 100){
            percent_complete = task.percentCompleted;
        }
	
	var html = "<span><span class='nobr'><table style='display:inline;'><tr><td style='padding-left:15px;padding-top:6px'>" +
			"<table style='height:7px;width:50px'><tr><td style='height:7px;width:" + percent_complete + "%;' class='"+color_cls+"'></td><td style='width:" + (100 - percent_complete) + "%;background-color:#DDD'></td></tr></table>" +
			"</td><td style='padding-left:3px;line-height:12px'><span class='percent_num' style='font-size:8px;color:#777'>" + percent_complete + "%</span></td></tr></table></span></span>";
	
	return html;
}


ogTasks.UpdateDependants = function(task, complete, prev_status) {
	var deps = this.getDependencyCount(task.id);
	if (deps) {
		var dependants = deps.dependants.split(',');
		for (var i = 0; i < dependants.length; i++){
			var dependant_id = dependants[i];
			var dc = this.getDependencyCount(dependant_id);
			if (dc) {
				if (complete) {
					dc.count -= 1;
					this.UpdateTask(dependant_id);
				} else {
					// Reopen: add 1 and reopen parents
					if (prev_status == 1) {
						dc.count += 1;
						var dep = this.getTask(dependant_id);
						dep.status = 0;
						this.UpdateTask(dependant_id);
						this.UpdateDependants(dep, false);
					}
				}
			}
		}
	}
}

ogTasks.newTaskFormTopList = function() {
	var topToolbar = Ext.getCmp('tasksPanelTopToolbarObject');
	
	var drawOptions = topToolbar.getDrawOptions();
	var draw_quick_actions = false;
	if(drawOptions.show_quick_complete){
		draw_quick_actions = true;
	}
	if(drawOptions.show_quick_add_sub_tasks){
		draw_quick_actions = true;
	}
	if(drawOptions.show_quick_edit){
		draw_quick_actions = true;
	}
	
	var title_total_cols = [];
	for (var key in ogTasks.TotalCols){
		var title_field = ogTasks.TotalCols[key].title;
		title_total_cols.push(lang(title_field));
	}
	
	//get template for the row
	var source = $("#task-list-col-names-template").html(); 
	//compile the template
	var template = Handlebars.compile(source);
	
	//template data
	var data = {
			draw_options : drawOptions,
			title_total_cols: title_total_cols,
			draw_quick_actions : draw_quick_actions
	}
	
	//instantiate the template
	var html = template(data);
	
	return '<div id="ogTasksPanelColNames">'+html+'</div>';
		
}

ogTasks.newTaskGroupTotals = function(group) {
	var topToolbar = Ext.getCmp('tasksPanelTopToolbarObject');
	
	var drawOptions = topToolbar.getDrawOptions();
	drawOptions.groupId = group.group_id;
	
	if(group.total_tasks_loaded < group.total){
		drawOptions.showMore = true;				
	}
	
	//get template for the row
	var source = $("#task-list-group-totals-template").html(); 
	//compile the template
	var template = Handlebars.compile(source);
	
	var format_group_totals = [];
	for (var key in ogTasks.TotalCols){
		var row_field = ogTasks.TotalCols[key].row_field;
		format_group_totals.push({text : group[row_field]});
	}
	
	//template data
	var data = {
			draw_options : drawOptions,
			format_group_totals : format_group_totals
	}
	
	//instantiate the template
	var html = template(data);
	
	return html;
		
}

