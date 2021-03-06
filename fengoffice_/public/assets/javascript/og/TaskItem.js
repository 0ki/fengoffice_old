og.TaskItem = function(config) {
	Ext.apply(this, config, {
		id: 0,
		title: '',
		parent: 0,
		milestone: 0,
		subtasks: {},
		assignedTo: '',
		workspaces: '',
		workspaceids: '',
		workspacecolors: '',
		expanded: false,
		completed: false,
		completedBy: '',
		isLate: false,
		daysLate: 0,
		showOnlySubtasks: false,
		duedate: 0,
		order: 0
	});

	this.doms = {};

	var div = document.createElement('div');
	this.doms.div = div;
	div.taskItem = this;
	div.className = 'og-task';
	if (this.isLate) {
		div.className += ' og-task-late';
	}
	if (this.completed) {
		div.className += ' og-task-completed';
	}
	if (this.priority >= 300) {
		div.className += ' og-task-high-priority';
	} else if (this.priority <= 100) {
		div.className += ' og-task-low-priority';
	}
	
	div.onmouseover = this.showActions.createDelegate(this);
	div.onmouseout = this.hideActions.createDelegate(this);
	
	var table = document.createElement('table');
	if (this.showOnlySubtasks) {
		table.style.display = 'none';
	}
	var tbody = document.createElement('tbody');
	table.appendChild(tbody);
	var tr = document.createElement('tr');
	tbody.appendChild(tr);
	div.appendChild(table);

		var td = document.createElement('td');
		td.className = 'td-delete';
		var tddiv = document.createElement('div');
		this.doms.del = tddiv;
		tddiv.style.visibility = 'hidden';
		tddiv.className = 'og-task-delete';
		tddiv.onclick = this.deleteTask.createDelegate(this);
		tddiv.title = lang('task delete tip');
		td.appendChild(tddiv);
		tr.appendChild(td);
		
		var td = document.createElement('td');
		td.className = 'td-edit';
		var tda = document.createElement('a');
		this.doms.edit = tda;
		tda.style.visibility = 'hidden';
		tda.className = 'og-task-edit';
		tda.innerHTML = lang('edit');
		tda.onclick = this.editTask.createDelegate(this);
		tda.title = lang('task edit tip');
		tda.href = "#";
		td.appendChild(tda);
		tr.appendChild(td);
		
		var td = document.createElement('td');
		td.className = 'td-move-down';
		var tddiv = document.createElement('div');
		this.doms.moveDown = tddiv;
		tddiv.style.visibility = 'hidden';
		tddiv.className = 'og-task-move-down';
		tddiv.onclick = this.moveTaskDown.createDelegate(this);
		tddiv.title = lang('task move down tip');
		td.appendChild(tddiv);
		tr.appendChild(td);
		
		var td = document.createElement('td');
		td.className = 'td-checkbox';
		var tddiv = document.createElement('div');
		this.doms.checkbox = tddiv;
		tddiv.className = 'og-task-checkbox';
		if (this.completed) {
			tddiv.className += ' og-task-checkbox-checked';
		}
		tddiv.onclick = this.checkTask.createDelegate(this);
		tddiv.title = lang('task check tip');
		tddiv.onmouseover = function() {
			Ext.fly(this).addClass('og-task-chekbox-hover');
		};
		tddiv.onmouseout = function() {
			Ext.fly(this).removeClass('og-task-chekbox-hover');
		};
		td.appendChild(tddiv);
		tr.appendChild(td);
		
		var td = document.createElement('td');
		td.className = 'td-toggle';
		var tddiv = document.createElement('div');
		this.doms.toggle = tddiv;
		tddiv.className = 'og-task-expander';
		if (this.expanded) {
			tddiv.className += ' toggle_expanded';
		} else {
				tddiv.className += ' toggle_collapsed';
		}
		tddiv.onclick = this.showSubTasks.createDelegate(this);
		tddiv.title = lang('task expand tip');
		td.appendChild(tddiv);
		tr.appendChild(td);
		
		var td = document.createElement('td');
		td.className = 'td-name';
		
		if (this.workspaceids != ''){
			var ids = String(this.workspaceids).split(',');
			for (var idi = 0; idi < ids.length; idi++){
				var tdspan = document.createElement('span');
				tdspan.className='project-replace';
				tdspan.innerHTML = ids[idi];
				td.appendChild(tdspan);
				td.appendChild(document.createTextNode(' '));
			}
		}
		
		var tda = document.createElement('a');
		this.doms.title = tda;
		tda.href = '#';
		tda.className = 'og-task-name';
		var linkText = this.title;
		if (this.assignedTo != '') {
			if (linkText.length > 66 - this.assignedTo.length)
				linkText = linkText.substr(0,66 - this.assignedTo.length) + "...";
			linkText = '<span style="font-weight:bold">' + this.assignedTo + ':</span>&nbsp;' + linkText;
		} else 
			if (linkText.length > 70)
				linkText = linkText.substr(0,70) + "...";
		tda.innerHTML = linkText;
		tda.onclick = this.viewTask.createDelegate(this);
		tda.title = lang('task view tip', this.title);
		td.appendChild(tda);
		
		tr.appendChild(td);
		
		var td = document.createElement('td');
		this.doms.workspace = td;
		td.className = 'td-duedate';
		if (this.duedate > 0){
			var newDate = new Date(this.duedate*1000).add("d", 1);
			var currDate = new Date();
			if (newDate.getFullYear() != currDate.getFullYear())
				td.innerHTML = newDate.format("j M Y");
			else
				td.innerHTML = newDate.format("j M");
		}
		tr.appendChild(td);
		
	
	var subtaskdiv = document.createElement('div');
	if (!this.expanded) {
		subtaskdiv.style.display = 'none';
	}
	if (this.showOnlySubtasks) {
		subtaskdiv.style.paddingLeft = '0px';
	}
	subtaskdiv.className = 'og-task-subtasks';
	div.appendChild(subtaskdiv);
	this.doms.subtasks = subtaskdiv;

	var newTaskDiv = document.createElement('div');
	newTaskDiv.className = "og-add-task";
	subtaskdiv.appendChild(newTaskDiv);
	this.doms.newTaskDiv = newTaskDiv;
	
		var newTaskForm = og.TaskItem.createAddTaskForm({
			toggleText: (this.showOnlySubtasks?lang('add new task'):lang('add subtask to', this.title))
		});
		this.doms.newTaskToggle = newTaskForm.doms.toggle;
		this.doms.newTaskBody = newTaskForm.doms.body;
		this.doms.newTaskToggle.onclick = this.showAddTask.createDelegate(this);
		this.doms.newTaskTitle = newTaskForm.doms.textarea;
		this.doms.newTaskAssignTo = newTaskForm.doms.dropdown;
		this.doms.newTaskCheckbox = newTaskForm.doms.checkbox;
		if(showNotificationCheck)
			this.doms.newTaskCheckboxNotify = newTaskForm.doms.checkboxNotify;
		this.doms.newTaskHours = newTaskForm.doms.hours;
		newTaskForm.doms.butOK.onclick = this.addTask.createDelegate(this);
		newTaskForm.doms.butCancel.onclick = this.hideAddTask.createDelegate(this);
		newTaskForm.doms.more.onclick = this.moreAddTask.createDelegate(this);
		newTaskDiv.appendChild(newTaskForm);
			
	if (this.container) {
		this.container.appendChild(div);
	}
	this.loadSubTasks(this.subtasks);
	og.TaskItem.loadedTasks[this.id] = this;
};

og.TaskItem.loadedTasks = [];

og.TaskItem.debugLoadedTasks = function() {
	for (var k in og.TaskItem.loadedTasks) {
		var t = og.TaskItem.loadedTasks[k];
		t.debug();
	}
};

og.TaskItem.createAddTaskForm = function(config) {
	var div = document.createElement('div');
	div.className = 'og-task-new-form';
	var toggle = document.createElement('a');
	toggle.href = '#';
	toggle.className = 'og-task-new-toggle';
	toggle.innerHTML = config.toggleText;
	var body = document.createElement('div');
	body.className = 'og-task-new';
	body.style.display = 'none';
	body.appendChild(document.createTextNode(lang('title')+": "));
	//body.appendChild(document.createElement('br'));
	var textarea = document.createElement('input');
	textarea.style.width='400px';
	body.appendChild(textarea);
	body.appendChild(document.createElement('br'));
	
	var table = document.createElement('table');
	table.style.marginTop="4px";
	var tbody = document.createElement('tbody');
	table.appendChild(tbody);
	var tr = document.createElement('tr');
	tbody.appendChild(tr);
	var td = document.createElement('td');
	td.width="18px";
	var checkbox = document.createElement('input');
	checkbox.type = 'checkbox';
	checkbox.style.width="16px"
	checkbox.style.height="16px"
	checkbox.style.height="16px"
	td.appendChild(checkbox);
	tr.appendChild(td);
	var td = document.createElement('td');
	td.style.paddingRight="15px";
	td.innerHTML = lang('completed');
	tr.appendChild(td);
	if(showNotificationCheck){
		var td = document.createElement('td');
		td.width="18px";
		var checkboxNotify = document.createElement('input');
		checkboxNotify.type = 'checkbox';
		checkboxNotify.style.width="16px"
		checkboxNotify.style.height="16px"
		checkboxNotify.style.height="16px"
		td.appendChild(checkboxNotify);
		tr.appendChild(td);
		var td = document.createElement('td');
		td.style.paddingRight="15px";
		td.innerHTML = lang('notify');
		tr.appendChild(td);
	}
	var td = document.createElement('td');
	td.innerHTML = lang('hours worked') + ':&nbsp;';
	tr.appendChild(td);
	var td = document.createElement('td');
	var hours = document.createElement('input');
	hours.style.width="25px";
	td.appendChild(hours);
	tr.appendChild(td);
	body.appendChild(table);
	
	var table = document.createElement('table');
	table.style.marginTop="4px";
	table.style.marginBottom="4px";
	var tbody = document.createElement('tbody');
	table.appendChild(tbody);
	var tr = document.createElement('tr');
	tbody.appendChild(tr);
	var td = document.createElement('td');
	td.appendChild(document.createTextNode(lang('assign to')+":"));
	tr.appendChild(td);
	var td = document.createElement('td');
	var dropdown = Ext.getDom('og-task-new-assigned-to');
	if (dropdown) {
		dropdown = dropdown.cloneNode(true);
	} else {
		dropdown = document.createElement('input');
		dropdown.type = 'hidden';
		dropdown.value = "0:0";
	}
	td.appendChild(dropdown);
	tr.appendChild(td);
	var td = document.createElement('td');
	var amore = document.createElement('a');
	amore.style.paddingLeft='15px';
	amore.innerHTML = lang('more options');
	amore.href = "#";
	td.appendChild(amore);
	tr.appendChild(td);
	body.appendChild(table);
	
	var butOK = document.createElement('button');
	butOK.innerHTML = lang('add task');
	body.appendChild(butOK);
	var butCancel = document.createElement('button');
	butCancel.innerHTML = lang('cancel');
	body.appendChild(butCancel);
	div.appendChild(toggle);
	div.appendChild(body);
	
	div.doms = {};
	div.doms.toggle = toggle;
	div.doms.body = body;
	div.doms.textarea = textarea;
	div.doms.dropdown = dropdown;
	div.doms.more = amore;
	div.doms.checkbox = checkbox;
	if(showNotificationCheck)
		div.doms.checkboxNotify = checkboxNotify;
	div.doms.hours = hours;
	div.doms.butOK = butOK;
	div.doms.butCancel = butCancel;
	return div;
};

og.TaskItem.prototype = {
	showActions: function() {
		this.doms.moveDown.style.visibility = 'visible';
		this.doms.del.style.visibility = 'visible';
		this.doms.edit.style.visibility = 'visible';
	},

	hideActions: function() {
		this.doms.moveDown.style.visibility = 'hidden';
		this.doms.del.style.visibility = 'hidden';
		this.doms.edit.style.visibility = 'hidden';
	},
	
	deleteTask: function() {
		if (confirm(lang('confirm delete task'))) {
			// TODO:
			var taskDiv = this.doms.div;
			var parent = this.getParentTaskOrMilestone();
			var next = taskDiv.nextSibling;
			//parent.removeChild(taskDiv);
			Ext.fly(taskDiv).slideOut("t", {remove:true, duration:0.5});
			og.openLink(og.getUrl('task', 'delete_task', {id: this.id, quick: true}), {
				callback: function(success, data, options) {
					if (!success || data.errorCode) {
						// re insert task
						options.parent.doms.subtasks.insertBefore(taskDiv, next);
					} else {
						delete options.parent.subtasks["id_" + this.id];
					}
				},
				scope: this,
				parent: parent
			});
		}
	},
	
	editTask: function() {
		og.openLink(og.getUrl('task', 'edit_task', {id: this.id}));
	},
	
	moveTaskDown: function() {
		var taskDiv = this.doms.div;
		var next = taskDiv.nextSibling;
		if (next && next.className != 'og-add-task' && next.className != 'og-add-milestone') {
			var parent = next.parentNode;
			parent.removeChild(next);
			parent.insertBefore(next, taskDiv);
			og.openLink(og.getUrl('task', 'move_down', {'id': this.id}), {
				callback: function(success, data) {
					if (!success || data.errorCode) {
						parent.removeChild(taskDiv);
						parent.insertBefore(taskDiv, next);
					}
				}
			});
		}
	},
	
	orderSubtasks: function() {
		// bubble sort
		var inorder = [];
		for (var i in this.subtasks) {
			inorder.push(this.subtasks[i]);
		}
		for (var i=0; i < inorder.length - 1; i++) {
			for (var j=i+1; j < inorder.length; j++) {
				if (inorder[i].completed && !inorder[j].completed ||
						(inorder[i].completed && inorder[j].completed ||
						 !inorder[i].completed && !inorder[j].completed) &&
						inorder[i].order > inorder[j].order) {
					// swap
					var aux = inorder[i];
					inorder[i] = inorder[j];
					inorder[j] = aux;
				}
			}
		}
		// reorder dom structure
		for (var i=0; i < inorder.length; i++) {
			try {
				this.doms.subtasks.removeChild(inorder[i].doms.div);
			} catch (e) {
				//alert(inorder[i].id);
			}
			this.doms.subtasks.insertBefore(inorder[i].doms.div, this.doms.newTaskDiv);
		}
	},
	
	showSubTasks: function() {
		if (this.expanded) {
			Ext.fly(this.doms.toggle).replaceClass('toggle_expanded', 'toggle_collapsed');
			Ext.fly(this.doms.subtasks).slideOut("t", {useDisplay: true, duration: 0.5});
			this.expanded = false;
		} else {
			Ext.fly(this.doms.toggle).replaceClass('toggle_collapsed', 'toggle_expanded');
			Ext.fly(this.doms.subtasks).slideIn("t", {useDisplay: true, duration: 0.5});
			this.expanded = true;
			var combo = Ext.getDom('og-task-filter-to');
			var assignedTo = combo?combo.value:"0:0";
			var combo = Ext.getDom('og-task-filter-status');
			var status = combo?combo.value:"all";
			var combo = Ext.getDom('og-task-filter-priority');
			var prio = combo?combo.value:"all";
			og.openLink(og.getUrl('task', 'view_tasks', {parent_id: this.id, assigned_to: assignedTo, status: status, priority: prio}), {
				callback: function(success, data) {
					if (success && ! data.errorCode) {
						// delete previous subtasks
						this.loadSubTasks(data.tasks);
					} else {
						og.err(lang("error fetching tasks"));
					}
				}, scope: this
			});
		}
	},
	
	loadSubTasks: function(tasks) {
		this.subtasks = {};
		var el = this.doms.subtasks.firstChild;
		while (el) {
			this.doms.subtasks.removeChild(el);
			el = this.doms.subtasks.firstChild;
		}
		
		for (var i in tasks) {
			if (typeof tasks[i] != 'object') continue;
			tasks[i].container = this.doms.subtasks;
			var task = new og.TaskItem(tasks[i]);
			this.subtasks["id_" + tasks[i].id] = task;
		}
		this.doms.subtasks.appendChild(this.doms.newTaskDiv);
		if (tasks.length > 0)
			og.showWsPaths();
	},
	
	checkTask: function() {
		if (this.completed) {
			this.completed = false;
			Ext.fly(this.doms.div).removeClass('og-task-completed');
			og.openLink(og.getUrl('task', 'open_task', {id: this.id, quick: true}), {
				callback: function(success, data) {
					if (!success || data.errorCode) {
						Ext.fly(this.doms.title).addClass('og-task-completed');
					} else {
						// reposition according to order
						var parent = this.getParentTaskOrMilestone();
						parent.orderSubtasks();

						// check auto completed tasks and milestones 
						if (data.openedMilestone) {
							var milestone = og.MilestoneItem.loadedMilestones[data.openedMilestone];
							Ext.fly(milestone.doms.div).removeClass('og-milestone-completed');
							milestone.reposition();
						}
						for (var i=0; i < data.openedTasks; i++) {
							var oTask = og.TaskItem.loadedTasks[data.openedTasks[i]];
							if (oTask) {
								oTask.completed = false;
								Ext.fly(oTask.doms.div).removeClass('og-task-completed');
								var parent = this.getParentTaskOrMilestone();
								if (parent) parent.orderSubtasks();
							}
						}
					}
				},
				scope: this
			});
		} else {
			this.completed = true;
			Ext.fly(this.doms.div).addClass('og-task-completed');
			og.openLink(og.getUrl('task', 'complete_task', {id: this.id, quick: true}), {
				callback: function(success, data) {
					if (!success || data.errorCode) {
						Ext.fly(this.doms.div).removeClass('og-task-completed');
					} else {
						// reposition according to order
						var parent = this.getParentTaskOrMilestone();
						parent.orderSubtasks();

						// check auto completed tasks and milestones
						if (data.completedMilestone) {
							var milestone = og.MilestoneItem.loadedMilestones[data.completedMilestone];
							Ext.fly(milestone.doms.div).addClass('og-milestone-completed');
							milestone.reposition();
						}
						for (var i=0; i < data.completedTasks; i++) {
							var cTask = og.TaskItem.loadedTasks[data.completedTasks[i]];
							if (cTask) {
								cTask.completed = true;
								Ext.fly(cTask.doms.div).addClass('og-task-completed');
								var parent = this.getParentTaskOrMilestone();
								if (parent) parent.orderSubtasks();
							}
						}
					}
				},
				scope: this
			});
		}
	},

	viewTask: function() {
		og.openLink(og.getUrl('task', 'view_task', {id: this.id}));
	},
	
	showAddTask: function() {
		Ext.fly(this.doms.newTaskBody).slideIn("t", {duration:0.5, useDisplay:true,
			callback: function() {
				this.doms.newTaskTitle.focus();
			},
			scope: this
		});
		Ext.fly(this.doms.newTaskToggle).slideOut("t", {duration:0.5, useDisplay:true});
		this.doms.newTaskTitle.value = "";
		this.doms.newTaskTitle.focus();
	},

	hideAddTask: function() {
		Ext.fly(this.doms.newTaskBody).slideOut("t", {duration:0.5, useDisplay:true});
		Ext.fly(this.doms.newTaskToggle).slideIn("t", {duration:0.5, useDisplay:true});
	},
	
	moreAddTask: function() {
		og.openLink(og.getUrl('task', 'add_task', {
			assigned_to: this.doms.newTaskAssignTo.value,
			title: encodeURIComponent(this.doms.newTaskTitle.value),
			parent_id: this.id,
			milestone_id: 0
		}));
	},
	
	addTask: function() {
		var assignedTo = this.doms.newTaskAssignTo.value;
		var title = this.doms.newTaskTitle.value;
		var hours = this.doms.newTaskHours.value;
		var checkedNotify = showNotificationCheck && this.doms.newTaskCheckboxNotify.checked;
		var checked = this.doms.newTaskCheckbox.checked;
		og.openLink(og.getUrl('task', 'quick_add_task'), {
			method: 'POST',
			post: {
				"task[title]": title,
				"task[assigned_to]": assignedTo,
				"task[parent_id]": this.id,
				"task[milestone_id]": 0,
				"task[hours]": hours,
				"task[is_completed]": checked,
				"task[send_notification]": checkedNotify
			},
			callback: function(success, data) {
				if (success && ! data.errorCode) {
					var task = data.task;
					var item = new og.TaskItem(task);
					this.subtasks["id_" + task.id] = item;
					var dom = item.doms.div;
					dom.style.display = 'none';
					this.doms.subtasks.insertBefore(dom, this.doms.newTaskDiv);
					this.orderSubtasks();
					Ext.fly(dom).slideIn("t", {useDisplay: true, duration: 0.5});
					og.showWsPaths();
				} else {
					og.err(lang("error adding task"));
				}
				this.hideAddTask();
			},
			scope: this
		});
	},
	
	getParentTaskOrMilestone: function() {
		if (this.milestone) {
			return og.MilestoneItem.loadedMilestones[this.milestone];
		} else {
			return og.TaskItem.loadedTasks[this.parent];
		}
	},
	
	debug: function() {
		alert("id: " + this.id + ",\n" +
			"title: " + this.title + ",\n" +
			"parent: " + this.parent + ",\n" +
			"milestone: " + this.milestone + ",\n" +
			"order: " + this.order + ",\n"
		);
	}
};

