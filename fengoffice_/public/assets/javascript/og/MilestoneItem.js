og.MilestoneItem = function(config) {
	Ext.apply(this, config, {
		id: 0,
		title: '',
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
		duedate: 0
	});

	this.doms = {};

	var div = document.createElement('div');
	this.doms.div = div;
	div.milestoneItem = this;
	div.className = 'og-milestone';
	if (this.isLate) {
		div.className += ' og-milestone-late';
	}
	if (this.completed) {
		div.className += ' og-milestone-completed';
	}
	div.onmouseover = this.showActions.createDelegate(this);
	div.onmouseout = this.hideActions.createDelegate(this);
	
	var table = document.createElement('table');
	var tbody = document.createElement('tbody');
	table.appendChild(tbody);
	var tr = document.createElement('tr');
	tbody.appendChild(tr);
	div.appendChild(table);
	
		var td = document.createElement('td');
		td.className = 'td-padding';
		tr.appendChild(td);

		var td = document.createElement('td');
		td.className = 'td-delete';
		var tddiv = document.createElement('div');
		this.doms.del = tddiv;
		tddiv.style.visibility = 'hidden';
		tddiv.className = 'og-milestone-delete';
		tddiv.onclick = this.deleteMilestone.createDelegate(this);
		tddiv.title = lang('milestone delete tip');
		td.appendChild(tddiv);
		tr.appendChild(td);
		
		var td = document.createElement('td');
		td.className = 'td-edit';
		var tda = document.createElement('a');
		this.doms.edit = tda;
		tda.style.visibility = 'hidden';
		tda.className = 'og-milestone-edit';
		tda.innerHTML = lang('edit');
		tda.onclick = this.editMilestone.createDelegate(this);
		tda.title = lang('milestone edit tip');
		tda.href = "#";
		td.appendChild(tda);
		tr.appendChild(td);
		
		var td = document.createElement('td');
		td.className = 'td-checkbox';
		var tddiv = document.createElement('div');
		this.doms.checkbox = tddiv;
		tddiv.className = 'og-milestone-checkbox';
		if (this.completed) {
			tddiv.className += ' og-milestone-checkbox-checked';
		}
		tddiv.onclick = this.checkMilestone.createDelegate(this);
		tddiv.title = lang('milestone check tip');
		tddiv.onmouseover = function() {
			Ext.fly(this).addClass('og-milestone-chekbox-hover');
		};
		tddiv.onmouseout = function() {
			Ext.fly(this).removeClass('og-milestone-chekbox-hover');
		};
		td.appendChild(tddiv);
		tr.appendChild(td);
		
		var td = document.createElement('td');
		td.className = 'td-toggle';
		var tddiv = document.createElement('div');
		this.doms.toggle = tddiv;
		tddiv.className = 'og-milestone-expander';
		if (this.expanded) {
			tddiv.className += ' toggle_expanded';
		} else {
			tddiv.className += ' toggle_collapsed';
		}
		tddiv.onclick = this.showSubTasks.createDelegate(this);
		tddiv.title = lang('milestone expand tip');
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
		tda.className = 'og-milestone-name';
		var linkText = this.title;
		if (this.assignedTo != '') {
			linkText = '<span style="font-weight:bold">' + this.assignedTo + ':</span>&nbsp;' + linkText;
		}
		tda.innerHTML = linkText;
		tda.onclick = this.viewMilestone.createDelegate(this);
		tda.title = lang('milestone view tip', this.title);
		td.appendChild(tda);
		tr.appendChild(td);
		
		/*var td = document.createElement('td');
		this.doms.workspace = td;
		td.className = 'td-workspace';
		td.innerHTML = String.format('<a href="#" onclick="Ext.getCmp(\'workspace-panel\').select({1})">{0}</a>', this.workspaces, this.workspaceids);
		td.title = this.workspaces;
		tr.appendChild(td);*/
		
		/*var td = document.createElement('td');
		this.doms.workspace = td;
		td.className = 'td-assigned-to';
		if (this.assignedTo != '') {
			td.innerHTML = lang('assigned to') + ": " + this.assignedTo;
			td.title  = lang('assigned to') + ": " + this.assignedTo;
		}
		tr.appendChild(td);*/
		
		var td = document.createElement('td');
		this.doms.workspace = td;
		td.className = 'td-duedate';
		var newDate = new Date(this.duedate*1000).add("d", 1);
		var currDate = new Date();
		if (newDate.getFullYear() != currDate.getFullYear())
			td.innerHTML = newDate.format("j M Y");
		else
			td.innerHTML = newDate.format("j M");
		tr.appendChild(td);
	
	var subtaskdiv = document.createElement('div');
	if (!this.expanded) {
		subtaskdiv.style.display = 'none';
	}
	subtaskdiv.className = 'og-milestone-subtasks';
	div.appendChild(subtaskdiv);
	this.doms.subtasks = subtaskdiv;

	var newTaskDiv = document.createElement('div');
	newTaskDiv.className = "og-add-milestone";
	subtaskdiv.appendChild(newTaskDiv);
	this.doms.newTaskDiv = newTaskDiv;
	
	var table = document.createElement('table');
	var tbody = document.createElement('tbody');
	table.appendChild(tbody);
	var tr = document.createElement('tr');
	tbody.appendChild(tr);
	newTaskDiv.appendChild(table);

		var newTaskForm = og.TaskItem.createAddTaskForm({
			toggleText: (this.showOnlySubtasks?lang('add new milestone'):lang('add task to', this.title))
		});
		this.doms.newTaskToggle = newTaskForm.doms.toggle;
		this.doms.newTaskBody = newTaskForm.doms.body;
		this.doms.newTaskToggle.onclick = this.showAddTask.createDelegate(this);
		this.doms.newTaskTitle = newTaskForm.doms.textarea;
		this.doms.newTaskAssignTo = newTaskForm.doms.dropdown;
		newTaskForm.doms.butOK.onclick = this.addTask.createDelegate(this);
		newTaskForm.doms.butCancel.onclick = this.hideAddTask.createDelegate(this);
		newTaskForm.doms.more.onclick = this.moreAddTask.createDelegate(this);
		newTaskDiv.appendChild(newTaskForm);
			
	if (this.container) {
		this.container.appendChild(div);
	}
	this.loadSubTasks(this.subtasks);
	og.MilestoneItem.loadedMilestones[this.id] = this;
};

og.MilestoneItem.loadedMilestones = [];

og.MilestoneItem.debugLoadedMilestones = function() {
	for (var k in og.MilestoneItem.loadedMilestones) {
		var t = og.MilestoneItem.loadedMilestones[k];
		t.debug();
	}
};

og.MilestoneItem.createAddMilestoneForm = function(config) {
	var div = document.createElement('div');
	div.className = 'og-milestone-new-form';
	var toggle = document.createElement('a');
	toggle.href = '#';
	toggle.className = 'og-milestone-new-toggle';
	toggle.innerHTML = config.toggleText;
	var body = document.createElement('div');
	body.className = 'og-milestone-new';
	body.style.display = 'none';
	body.appendChild(document.createTextNode(lang('title')+":"));
	body.appendChild(document.createElement('br'));
	var textarea = document.createElement('textarea');
	body.appendChild(textarea);
	body.appendChild(document.createElement('br'));
	body.appendChild(document.createTextNode(lang('due date')+":"));
	body.appendChild(document.createElement('br'));
	var dateDiv = document.createElement('div');
	var datePicker = new og.DatePicker();
	dateDiv.appendChild(datePicker.dom);
	body.appendChild(dateDiv);
	body.appendChild(document.createElement('br'));
	body.appendChild(document.createTextNode(lang('assign to')+":"));
	body.appendChild(document.createElement('br'));
	var dropdown = Ext.getDom('og-task-new-assigned-to');
	if (dropdown) {
		dropdown = dropdown.cloneNode(true);
	} else {
		dropdown = document.createElement('input');
		dropdown.type = 'hidden';
		dropdown.value = "0:0";
	}
	body.appendChild(dropdown);
	body.appendChild(document.createElement('br'));
	var amore = document.createElement('a');
	amore.innerHTML = lang('more');
	amore.href = "#";
	body.appendChild(amore);
	body.appendChild(document.createElement('br'));
	var butOK = document.createElement('button');
	butOK.innerHTML = lang('add milestone');
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
	div.doms.butOK = butOK;
	div.doms.butCancel = butCancel;
	div.doms.dateDiv = dateDiv;
	div.doms.datePicker = datePicker;
	
	toggle.onclick = function() {
		Ext.fly(body).slideIn("t", {duration:0.5, useDisplay:true,
			callback: function() {
				textarea.focus();
			},
			scope: this
		});
		Ext.fly(toggle).slideOut("t", {duration:0.5, useDisplay:true});
		textarea.value = "";
		textarea.focus();
	}
	butCancel.onclick = function() {
		Ext.fly(body).slideOut("t", {duration:0.5, useDisplay:true});
		Ext.fly(toggle).slideIn("t", {duration:0.5, useDisplay:true});
	}
	amore.onclick = function() {
		og.openLink(og.getUrl('milestone', 'add', {
			assigned_to: dropdown.value,
			name: textarea.value,
			due_day: datePicker.getValue().getDate(),
			due_month: datePicker.getValue().getMonth() + 1,
			due_year: datePicker.getValue().getFullYear()
		}));
	}
	butOK.onclick = function() {
		og.MilestoneItem.addMilestone({
			assigned_to: dropdown.value,
			name: textarea.value,
			due_day: datePicker.getValue().getDate(),
			due_month: datePicker.getValue().getMonth() + 1,
			due_year: datePicker.getValue().getFullYear(),
			container: config.container,
			node: div,
			callback: butCancel.onclick
		});
	}

	return div;
};

og.MilestoneItem.addMilestone = function(config) {
	og.openLink(og.getUrl('milestone', 'quick_add_milestone'), {
		method: "POST",
		post: {
			"milestone[assigned_to]": config.assigned_to,
			"milestone[name]": config.name,
			"milestone[due_date_day]": config.due_day,
			"milestone[due_date_month]": config.due_month,
			"milestone[due_date_year]": config.due_year
		},
		callback: function(success, data) {
			if (success && !data.errorCode) {
				var milestone = data.milestone;
				var item = new og.MilestoneItem(milestone);
				var dom = item.doms.div;
				dom.style.display = 'none';
				config.container.appendChild(dom, config.node);
				item.reposition();
				Ext.fly(dom).slideIn("t", {useDisplay: true, duration: 0.5});
			} else {
				og.err(lang("error adding milestone"));
			}
			if (typeof config.callback == 'function') {
				config.callback.call(success, data);
			}
		}
	});
};

og.MilestoneItem.prototype = {
	showActions: function() {
		this.doms.del.style.visibility = 'visible';
		this.doms.edit.style.visibility = 'visible';
	},

	hideActions: function() {
		this.doms.del.style.visibility = 'hidden';
		this.doms.edit.style.visibility = 'hidden';
	},
	
	deleteMilestone: function() {
		if (confirm(lang('confirm delete milestone'))) {
			// TODO:
			var milestoneDiv = this.doms.div;
			var parent = milestoneDiv.parentNode;
			var next = milestoneDiv.nextSibling;
			//parent.removeChild(taskDiv);
			Ext.fly(milestoneDiv).slideOut("t", {remove:true, duration:1});
			og.openLink(og.getUrl('milestone', 'delete', {id: this.id, quick: true}), {
				callback: function(success, data) {
					if (!success || data.errorCode) {
						// re insert milestone
						parent.insertBefore(milestoneDiv, next);
					} 
				}
			});
		}
	},
	
	editMilestone: function() {
		og.openLink(og.getUrl('milestone', 'edit', {id: this.id}));
	},
		
	orderSubtasks: function() {
		og.TaskItem.prototype.orderSubtasks.call(this);
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
			var status =  combo?combo.value:"all"; 
			og.openLink(og.getUrl('task', 'view_tasks', {milestone_id: this.id, assigned_to: assignedTo, status: status}), {
				callback: function(success, data) {
					if (success && !data.errorCode) {
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
		og.TaskItem.prototype.loadSubTasks.call(this, tasks);
		og.showWsPaths();
	},
	
	checkMilestone: function() {
		if (this.completed) {
			this.completed = false;
			Ext.fly(this.doms.div).removeClass('og-milestone-completed');
			og.openLink(og.getUrl('milestone', 'open', {id: this.id, quick: true}), {
				callback: function(success, data) {
					if (!success || data.errorCode) {
						Ext.fly(this.doms.div).addClass('og-milestone-completed');
					} else {
						// reposition according to duedate
						this.reposition();
					}
				},
				scope: this
			});
		} else {
			this.completed = true;
			Ext.fly(this.doms.div).addClass('og-milestone-completed');
			og.openLink(og.getUrl('milestone', 'complete', {id: this.id, quick: true}), {
				callback: function(success, data) {
					if (!success || data.errorCode) {
						Ext.fly(this.doms.div).removeClass('og-milestone-completed');
					} else {
						// reposition according to order
						this.reposition();
					}
				},
				scope: this
			});
		}
	},
	
	reposition: function() {
		// find my position between my siblings
		var me = this.doms.div;
		var dad = me.parentNode;
		dad.removeChild(me);
		dad.appendChild(me);
		var bro = me.previousSibling;
		while (bro && (!bro.milestoneItem || !me.milestoneItem.completed && bro.milestoneItem.completed ||
				me.milestoneItem.completed && bro.milestoneItem.completed && me.milestoneItem.duedate < bro.milestoneItem.duedate ||
				!me.milestoneItem.completed && !bro.milestoneItem.completed && me.milestoneItem.duedate < bro.milestoneItem.duedate)) {
			dad.removeChild(me);
			dad.insertBefore(me, bro);
			bro = me.previousSibling;
		}
	},

	viewMilestone: function() {
		og.openLink(og.getUrl('milestone', 'view', {id: this.id}));
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
			title: this.doms.newTaskTitle.value,
			parent_id: 0,
			milestone_id: this.id
		}));
	},
	
	addTask: function() {
		var assignedTo = this.doms.newTaskAssignTo.value;
		var title = this.doms.newTaskTitle.value;
		og.openLink(og.getUrl('task', 'quick_add_task'), {
			method: 'POST',
			post: {
				"task[title]": title,
				"task[assigned_to]": assignedTo,
				"task[parent_id]": 0,
				"task[milestone_id]": this.id
			},
			callback: function(success, data) {
				if (success && !data.errorCode) {
					var task = data.task;
					var item = new og.TaskItem(task);
					this.subtasks["id_" + task.id] = item;
					var dom = item.doms.div;
					dom.style.display = 'none';
					this.doms.subtasks.insertBefore(dom, this.doms.newTaskDiv);
					this.orderSubtasks();
					Ext.fly(dom).slideIn("t", {useDisplay: true, duration: 0.5});
				} else {
					og.err(lang("error adding task"));
				}
				this.hideAddTask();
			},
			scope: this
		});
	},
	
	debug: function() {
		alert("id: " + this.id + ",\n" +
			"title: " + this.title + ",\n"
		);
	}
};

