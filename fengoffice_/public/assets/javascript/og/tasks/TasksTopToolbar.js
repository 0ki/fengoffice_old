/**
 *  TaskManager
 *
 */
 
og.TasksTopToolbar = function(config) {
	Ext.applyIf(config,
		{
			id: "tasksPanelTopToolbarObject",
			renderTo: "tasksPanelTopToolbar",
			height: 28,
			style:"border:0px none"
		});
		
	og.TasksTopToolbar.superclass.constructor.call(this, config);
	var userPreferences = Ext.util.JSON.decode(document.getElementById(config.userPreferencesHfId).value);
		
	var templates = [];
	var templatesArray = Ext.util.JSON.decode(document.getElementById(config.templatesHfId).value);
	for (var i = 0; i < templatesArray.length; i++){
		templates[templates.length] = {text: templatesArray[i].t,
			iconCls: 'ico-template-task',
			handler: function() {
				var url = og.getUrl('task', 'copy_task', {id: templatesArray[i].id});
				og.openLink(url);
			}
		};
	}
	
	var butt = new Ext.Button({
		iconCls: 'ico-new',
		text: lang('new'),
		menu: {
			cls:'scrollable-menu',
			items: [
			{text: lang('new milestone'), iconCls: 'ico-milestone', handler: function() {
				var url = og.getUrl('milestone', 'add');
				og.openLink(url);
			}},
			{text: lang('new task'), iconCls: 'ico-task', handler: function() {
				var additionalParams = {};
				var toolbar = Ext.getCmp('tasksPanelTopToolbarObject');
				if (toolbar.filterNamesCompaniesCombo.isVisible()){
					var value = toolbar.filterNamesCompaniesCombo.getValue();
					var split = value.split(':');
					if (split[0] > 0 || split[1] > 0){
						additionalParams.assigned_to = value;
					}
				}
				var url = og.getUrl('task', 'add_task');
				og.openLink(url, {post:additionalParams});
			}},
			'-', 
			{text: lang('all'),
				iconCls: 'ico-template-task',
				cls: 'scrollable-menu',
				menu: {
					items: templates
			}}
		]}
	});
	
	var actions = {
		tag: new Ext.Action({
			text: lang('tag'),
            tooltip: lang('tag selected objects'),
            iconCls: 'ico-tag',
			disabled: true,
			menu: new og.TagMenu({
				listeners: {
					'tagselect': {
						fn: function(tag) {
							ogTasks.executeAction('tag', null, tag);
						},
						scope: this
					}
				}
			})
		}),
		del: new Ext.Action({
			text: lang('delete'),
            tooltip: lang('delete selected objects'),
            iconCls: 'ico-delete',
			disabled: true,
			handler: function() {
				if (confirm(lang('confirm delete object'))) {
					ogTasks.executeAction('delete');
				}
			},
			scope: this
		}),
		complete: new Ext.Action({
			text: lang('complete'),
            tooltip: lang('complete selected tasks'),
            iconCls: 'ico-complete',
			disabled: true,
			handler: function() {
				ogTasks.executeAction('complete');
			},
			scope: this
		})
	};
	this.actions = actions;
	
    

    this.filtercombo = new Ext.form.ComboBox({
        store: new Ext.data.SimpleStore({
	        fields: ['value', 'text'],
	        data : [['created_by',lang('created by')]
	        	,['completed_by', lang('completed by')]
	        	,['assigned_to', lang('assigned to')]
	        	,['assigned_by', lang('assigned by')]
	        	,['milestone', lang('milestone')]
	        	,['priority', lang('priority')]]
	    }),
        displayField:'text',
        typeAhead: true,
        mode: 'local',
        triggerAction: 'all',
        selectOnFocus:true,
        width:100,
        valueField: 'value',
        listeners: {
        	'select' : function(combo, record) {
        		switch(record.data.value){
        			case 'milestone':
        				Ext.getCmp('ogTasksFilterNamesCombo').hide();
        				Ext.getCmp('ogTasksFilterNamesCompaniesCombo').hide();
        				Ext.getCmp('ogTasksFilterMilestonesCombo').show();
        				Ext.getCmp('ogTasksFilterMilestonesCombo').setValue('');
        				Ext.getCmp('ogTasksFilterPriorityCombo').hide();
        				break;
        			case 'priority':
        				Ext.getCmp('ogTasksFilterNamesCombo').hide();
        				Ext.getCmp('ogTasksFilterNamesCompaniesCombo').hide();
        				Ext.getCmp('ogTasksFilterMilestonesCombo').hide();
        				Ext.getCmp('ogTasksFilterPriorityCombo').show();
        				Ext.getCmp('ogTasksFilterPriorityCombo').setValue('');
        				break;
        			case 'assigned_to':
        				Ext.getCmp('ogTasksFilterNamesCombo').hide();
        				Ext.getCmp('ogTasksFilterNamesCompaniesCombo').show();
        				Ext.getCmp('ogTasksFilterNamesCompaniesCombo').setValue('');
        				Ext.getCmp('ogTasksFilterMilestonesCombo').hide();
        				Ext.getCmp('ogTasksFilterPriorityCombo').hide();
        				break;
        			default:
        				Ext.getCmp('ogTasksFilterNamesCombo').show();
        				Ext.getCmp('ogTasksFilterNamesCombo').setValue('');
        				Ext.getCmp('ogTasksFilterNamesCompaniesCombo').hide();
        				Ext.getCmp('ogTasksFilterMilestonesCombo').hide();
        				Ext.getCmp('ogTasksFilterPriorityCombo').hide();
        				break;
        		}
        	}
        }
    });
    this.filtercombo.setValue(userPreferences.filter);
    
    
    var currentUser = '';
    var usersArray = Ext.util.JSON.decode(document.getElementById(config.usersHfId).value);
    var companiesArray = Ext.util.JSON.decode(document.getElementById(config.companiesHfId).value);
    for (i in usersArray){
		if (usersArray[i].isCurrent)
			currentUser = usersArray[i].cid + ':' + usersArray[i].id;
	}
	var ucsData = [[currentUser, lang('me')],['0:0',lang('anyone')],['-1:-1', lang('unclassified')],['0:0','--']];
	for (i in companiesArray)
		if (companiesArray[i].id) ucsData[ucsData.length] = [(companiesArray[i].id + ':0'), companiesArray[i].name];
	ucsData[ucsData.length] = ['0:0','--'];
	for (i in usersArray){
		var companyName = '';
		var j;
		for(j in companiesArray)
			if (companiesArray[j].id == usersArray[i].cid)
				companyName = companiesArray[j].name;
		if (!usersArray[i].isCurrent && usersArray[i].cid) ucsData[ucsData.length] = [(usersArray[i].cid + ':' + usersArray[i].id), usersArray[i].name + ' : ' + companyName];
		if (usersArray[i].isCurrent)
			currentUser = usersArray[i].cid + ':' + usersArray[i].id;
	}
	
	
    
    this.filterNamesCompaniesCombo = new Ext.form.ComboBox({
    	id: 'ogTasksFilterNamesCompaniesCombo',
        store: new Ext.data.SimpleStore({
	        fields: ['value', 'text'],
	        data : ucsData
	    }),
	    hidden: userPreferences.filter != 'assigned_to',
        displayField:'text',
        typeAhead: true,
        mode: 'local',
        triggerAction: 'all',
        selectOnFocus:true,
        width:160,
        valueField: 'value',
        emptyText: (lang('select user or group') + '...'),
        valueNotFoundText: '',
        listeners: {
        	'select' : function(combo, record) {
				var toolbar = Ext.getCmp('tasksPanelTopToolbarObject');
        		if (toolbar.filterNamesCompaniesCombo == this)
        			toolbar.load();
        		else{
        			if (this.initialConfig.isInternalSelector)
        				ogTasks.UserCompanySelected(this.initialConfig.controlName, record.data.value, this.initialConfig.taskId);
        		}
        	}
        }
    });
    this.filterNamesCompaniesCombo.setValue(userPreferences.filterValue);
    
    for (i in usersArray){
		if (usersArray[i].isCurrent)
			currentUser = usersArray[i].id;
	}
	var uData = [[currentUser, lang('me')],['0',lang('anyone')],['0','--']];
	for (i in usersArray){
		if (!usersArray[i].isCurrent)
			uData[uData.length] = [usersArray[i].id, usersArray[i].name];
	}
    this.filterNamesCombo = new Ext.form.ComboBox({
    	id: 'ogTasksFilterNamesCombo',
        store: new Ext.data.SimpleStore({
	        fields: ['value', 'text'],
	        data : uData
	    }),
	    hidden: (userPreferences.filter == 'milestone' || userPreferences.filter == 'priority' || userPreferences.filter == 'assigned_to'),
        displayField:'text',
        typeAhead: true,
        mode: 'local',
        triggerAction: 'all',
        selectOnFocus:true,
        width:160,
        valueField: 'value',
        emptyText: (lang('select user or group') + '...'),
        valueNotFoundText: '',
        listeners: {
        	'select' : function(combo, record) {
				var toolbar = Ext.getCmp('tasksPanelTopToolbarObject');
        		toolbar.load();
        	}
		}
	});
    this.filterNamesCombo.setValue(userPreferences.filterValue);
    
    this.filterPriorityCombo = new Ext.form.ComboBox({
    	id: 'ogTasksFilterPriorityCombo',
        store: new Ext.data.SimpleStore({
			fields: ['value', 'text'],
			data : [[100, lang('low')],[200, lang('normal')],[300, lang('high')]]
	    }),
	    hidden: userPreferences.filter != 'priority',
        displayField:'text',
        typeAhead: true,
        mode: 'local',
        triggerAction: 'all',
        selectOnFocus:true,
        width:160,
        valueField: 'value',
        emptyText: (lang('select priority') + '...'),
        valueNotFoundText: '',
        listeners: {
        	'select' : function(combo, record) {
				var toolbar = Ext.getCmp('tasksPanelTopToolbarObject');
        		if (toolbar.filterPriorityCombo == this)
        			toolbar.load();
        	}
        }
    });
    this.filterPriorityCombo.setValue(userPreferences.filterValue);
    
    
    var milestones = Ext.util.JSON.decode(document.getElementById(config.internalMilestonesHfId).value);
    milestones = milestones.concat(Ext.util.JSON.decode(document.getElementById(config.externalMilestonesHfId).value));
    milestonesData = [];
    for (i in milestones){
    	if (milestones[i].id)
    		milestonesData[milestonesData.length] = [milestones[i].id, milestones[i].t];
    }
    this.filterMilestonesCombo = new Ext.form.ComboBox({
    	id: 'ogTasksFilterMilestonesCombo',
        store: new Ext.data.SimpleStore({
	        fields: ['value', 'text'],
	        data : milestonesData,
	        sortInfo: {field:'text',direction:'ASC'}
	    }),
	    hidden: (userPreferences.filter != 'milestone'),
        displayField:'text',
        typeAhead: true,
        mode: 'local',
        triggerAction: 'all',
        selectOnFocus:true,
        width:160,
        valueField: 'value',
        emptyText: (lang('select milestone') + '...'),
        valueNotFoundText: '',
        listeners: {
        	'select' : function(combo, record) {
				var toolbar = Ext.getCmp('tasksPanelTopToolbarObject');
        		toolbar.load();
        	}
        }
    });
    this.filterMilestonesCombo.setValue(userPreferences.filterValue);
	
	
    this.statusCombo = new Ext.form.ComboBox({
    	id: 'ogTasksStatusCombo',
        store: new Ext.data.SimpleStore({
	        fields: ['value', 'text'],
	        data : [[2, lang('all')],[0, lang('pending')],[1, lang('complete')]]
	    }),
        displayField:'text',
        typeAhead: true,
        mode: 'local',
        triggerAction: 'all',
        selectOnFocus:true,
        width:80,
        valueField: 'value',
        listeners: {
        	'select' : function(combo, record) {
				var toolbar = Ext.getCmp('tasksPanelTopToolbarObject');
        		toolbar.load();
        	}
        }
    });
    this.statusCombo.setValue(userPreferences.status);
    
    //Add stuff to the toolbar
	this.add(butt);
	this.addSeparator();
	this.add(actions.tag);
	this.add(actions.del);
	this.add(actions.complete);
	this.addSeparator();
    this.add(lang('filter') + ':');
    this.add(this.filtercombo);
    this.add(this.filterNamesCombo);
    this.add(this.filterNamesCompaniesCombo);
    this.add(this.filterPriorityCombo);
    this.add(this.filterMilestonesCombo);
    this.add('&nbsp;&nbsp;&nbsp;' + lang('status') + ':');
    this.add(this.statusCombo);
};

function ogTasksLoadFilterValuesCombo(newValue){
	var combo = Ext.getCmp('ogTasksFilterValuesCombo');
}

Ext.extend(og.TasksTopToolbar, Ext.Toolbar, {
	load: function(params) {
		if (!params) params = {};
		Ext.apply(params,this.getFilters());
		og.openLink(og.getUrl('task','new_list_tasks',params));
	},
	getFilters : function(){
		var filterValue;
		switch(this.filtercombo.getValue()){
			case 'milestone':
				filterValue = this.filterMilestonesCombo.getValue();
				break;
			case 'priority':
				filterValue = this.filterPriorityCombo.getValue();
				break;
			case 'assigned_to':
				filterValue = this.filterNamesCompaniesCombo.getValue();
				break;
			default:
				filterValue = this.filterNamesCombo.getValue();
				break;
		}
		
		return {
			status: this.statusCombo.getValue(),
			filter:this.filtercombo.getValue(),
			fval:filterValue
		}
	},
	cloneUserCompanyCombo : function(newId){
		var clone = this.filterNamesCompaniesCombo.cloneConfig({id:newId});
		
		return clone;
	},
	updateCheckedStatus : function(){
		var checked = false;
		var allIncomplete = true;
		for (var i = 0; i < ogTasks.Tasks.length; i++)
			if (ogTasks.Tasks[i].isChecked){
				checked = true;
				if (ogTasks.Tasks[i].status == 1)
					allIncomplete = false;
			}
		
		if (!checked){
			this.actions.del.disable();
			this.actions.complete.disable();
			this.actions.tag.disable();
		} else {
			this.actions.del.enable();
			this.actions.tag.enable();
			if (allIncomplete)
				this.actions.complete.enable();
			else
				this.actions.complete.disable();
				
		}
		
	}
});

Ext.reg("tasksTopToolbar", og.TasksTopToolbar);