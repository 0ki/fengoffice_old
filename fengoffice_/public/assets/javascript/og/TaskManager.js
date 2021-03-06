/**
 *  TaskManager
 *
 */
og.TaskManager = function() {
	var actions, moreActions;

	this.doNotRemove = true;
	this.needRefresh = false;

	if (!og.TaskManager.store) {
		og.TaskManager.store = new Ext.data.Store({
			proxy: new Ext.data.HttpProxy(new Ext.data.Connection({
				method: 'GET',
				url: og.getUrl('task', 'list_tasks', {ajax:true})
			})),
			reader: new Ext.data.JsonReader({
				root: 'objects',
				totalProperty: 'totalCount',
				id: 'id',
				fields: [
					'name','object_id', 'type', 'tags', 'createdBy', 'createdById',
					{name: 'dateCreated', type: 'date', dateFormat: 'timestamp'},
					'updatedBy', 'updatedById',
					{name: 'dateUpdated', type: 'date', dateFormat: 'timestamp'},
					'icon', 'project', 'projectId', 'manager'
				]
			}),
			remoteSort: true,
			listeners: {
				'load': function() {
					var d = this.reader.jsonData;
					og.processResponse(d);
					var ws = Ext.getCmp('workspace-panel').getActiveWorkspace().name;
					var tag = Ext.getCmp('tag-panel').getSelectedTag().name;
					if (d.totalCount == 0) {
						if (tag) {
							this.fireEvent('messageToShow', lang("no objects with tag message", lang("tasks"), ws, tag));
						} else {
							this.fireEvent('messageToShow', lang("no objects message", lang("tasks"), ws));
						}
					} else {
						this.fireEvent('messageToShow', "");
					}
					og.hideLoading();
				},
				'beforeload': function() {
					og.loading();
					return true;
				},
				'loadexception': function() {
					og.hideLoading();
					var d = this.reader.jsonData;
					og.processResponse(d);
				}
			}
		});
		og.TaskManager.store.setDefaultSort('dateUpdated', 'desc');
	}
	this.store = og.TaskManager.store;
	this.store.addListener({messageToShow: {fn: this.showMessage, scope: this}});

	function renderName(value, p, r) {
		if (r.data.type == 'task') {
			var url = og.getUrl('task', 'view_task', {id: r.data.object_id});
		} else if (r.data.type == 'milestone') {
			var url = og.getUrl('milestone', 'view', {id: r.data.object_id});
		}
		return String.format(
			'<a href="#" onclick="og.openLink(\'{2}\')">{0}</a>',
			value, r.data.name, url);
	}
	
	function renderIcon(value, p, r) {
		var classes = "db-ico ico-unknown ico-" + r.data.type;
		if (r.data.mimeType) {
			var path = r.data.mimeType.replace(/\//ig, "-").split("-");
			var acc = "";
			for (var i=0; i < path.length; i++) {
				acc += path[i];
				classes += " ico-" + acc;
				acc += "-";
			}
		}
		return String.format('<div class="{0}" />', classes);
	}

	function renderUser(value, p, r) {
		return String.format('<a href="#" onclick="og.openLink(\'{1}\')">{0}</a>', value, og.getUrl('user', 'card', {id: r.data.updatedById}));
	}

	function renderAuthor(value, p, r) {
		return String.format('<a href="#" onclick="og.openLink(\'{1}\')">{0}</a>', value, og.getUrl('user', 'card', {id: r.data.createdById}));
	}

	function renderProject(value, p, r) {
		return String.format('<a href="#" onclick="Ext.getCmp(\'workspace-panel\').select({1})">{0}</a>', value, r.data.projectId);
	}

	function renderDate(value, p, r) {
		if (!value) {
			return "";
		}
		var now = new Date();
		if (now.dateFormat('Y-m-d') > value.dateFormat('Y-m-d')) {
			return value.dateFormat('M j');
		} else {
			return value.dateFormat('h:i a');
		}
	}

	function getSelectedIds() {
		var selections = sm.getSelections();
		if (selections.length <= 0) {
			return '';
		} else {
			var ret = '';
			for (var i=0; i < selections.length; i++) {
				ret += "," + selections[i].data.manager + ":" + selections[i].data.object_id;
			}	
			return ret.substring(1);
		}
	}
	
	function getFirstSelectedId() {
		if (sm.hasSelection()) {
			return sm.getSelected().data.object_id;
		}
		return '';
	}

	var sm = new Ext.grid.CheckboxSelectionModel();
	sm.on('selectionchange',
		function() {
			if (sm.getCount() <= 0) {
				actions.tag.setDisabled(true);
				actions.del.setDisabled(true);
				actions.more.setDisabled(true);
			} else {
				actions.tag.setDisabled(false);
				actions.del.setDisabled(false);
				actions.more.setDisabled(false);
			}
		});
	var cm = new Ext.grid.ColumnModel([
		sm,{
        	id: 'icon',
        	header: '&nbsp;',
        	dataIndex: 'icon',
        	width: 28,
        	renderer: renderIcon,
        	fixed:true,
        	resizable: false,
        	hideable:false,
        	menuDisabled: true
        },{
			id: 'name',
			header: lang("name"),
			dataIndex: 'name',
			width: 300,
			renderer: renderName
        },{
			id: 'project',
			header: lang("project"),
			dataIndex: 'project',
			width: 120,
			renderer: renderProject
        },{
        	id: 'user',
        	header: lang('user'),
        	dataIndex: 'updatedBy',
        	width: 120,
        	renderer: renderUser
        },{
			id: 'type',
			header: lang('type'),
			dataIndex: 'type',
			width: 120,
			hidden: true
		},{
			id: 'tags',
			header: lang("tags"),
			dataIndex: 'tags',
			width: 120
        },{
			id: 'last',
			header: lang("last update"),
			dataIndex: 'dateUpdated',
			width: 80,
			renderer: renderDate
        },{
			id: 'created',
			header: lang("created on"),
			dataIndex: 'dateCreated',
			width: 80,
			hidden: true,
			renderer: renderDate
		},{
			id: 'author',
			header: lang("author"),
			dataIndex: 'createdBy',
			width: 120,
			renderer: renderAuthor,
			hidden: true
		}]);
	cm.defaultSortable = false;

	moreActions = {
		properties: new Ext.Action({
			text: lang('properties'),
			iconCls: 'ico-properties',
			handler: function(e) {
				var o = sm.getSelected();
				var url = og.getUrl('object', 'view', {id: o.data.object_id, manager: o.data.manager});
				og.openLink(url);
			}
		})
	}
	
	actions = {
		newCO: new Ext.Action({
			text: lang('new'),
            tooltip: lang('create an object'),
            iconCls: 'ico-new',
            menu: {items: [
            	{text: lang('task'), iconCls: 'ico-task', handler: function() {
					var url = og.getUrl('task', 'add_task');
					og.openLink(url);
				}},
				{text: lang('milestone'), iconCls: 'ico-milestone', handler: function() {
					var url = og.getUrl('milestone', 'add');
					og.openLink(url);
				}}
			]}
		}),
		tag: new Ext.Action({
			text: lang('tag'),
            tooltip: lang('tag selected objects'),
            iconCls: 'ico-tag',
			disabled: true,
			menu: new og.TagMenu({
				listeners: {
					'tagselect': {
						fn: function(tag) {
							this.load({
								action: 'tag',
								objects: getSelectedIds(),
								tagTag: tag
							});
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
					this.load({
						action: 'delete',
						objects: getSelectedIds()
					});
					this.getSelectionModel().clearSelections();
				}
			},
			scope: this
		}),
		more: new Ext.Action({
			text: lang('more'),
            tooltip: lang('more actions on first selected object'),
            iconCls: 'ico-more',
			disabled: true,
			menu: {items: [
				moreActions.properties
			]}
		}),
		refresh: new Ext.Action({
			text: lang('refresh'),
            tooltip: lang('refresh desc'),
            iconCls: 'ico-refresh',
			handler: function() {
				this.store.reload();
			},
			scope: this
		})
    };
    
	og.TaskManager.superclass.constructor.call(this, {
		store: this.store,
		layout: 'fit',
		cm: cm,
		stripeRows: true,
		closable: true,
		style: "padding:7px;",
		bbar: new og.PagingToolbar({
			pageSize: og.pageSize,
			store: this.store,
			displayInfo: true,
			displayMsg: lang('displaying objects of'),
			emptyMsg: lang("no objects to display")
		}),
		viewConfig: {
			forceFit: true
		},
		sm: sm,
		tbar:[
			actions.newCO,
			'-',
			actions.tag,
			actions.del,
			actions.more,
			'-',
			actions.refresh
		],
		listeners: {
			'render': {
				fn: function() {
					this.innerMessage = document.createElement('div');
					this.innerMessage.className = 'inner-message';
					var msg = this.innerMessage;
					var elem = Ext.get(this.getEl());
					var scroller = elem.select('.x-grid3-scroller');
					scroller.each(function() {
						this.dom.appendChild(msg);
					});
				},
				scope: this
			}
		}
	});

	var tagevid = og.eventManager.addListener("tag changed", function(tag) {
		if (!this.ownerCt) {
			og.eventManager.removeListener(tagevid);
			return;
		}
		if (this.ownerCt.active) {
			this.load({start:0});
		} else {
    		this.needRefresh = true;
    	}
	});
};

Ext.extend(og.TaskManager, Ext.grid.GridPanel, {
	load: function(params) {
		if (!params) params = {};
		if (typeof params.start == 'undefined') {
			var start = (this.getBottomToolbar().getPageData().activePage - 1) * og.pageSize;
		} else {
			var start = 0;
		}
		Ext.apply(this.store.baseParams, {
			tag: Ext.getCmp('tag-panel').getSelectedTag().name,
			active_project: Ext.getCmp('workspace-panel').getActiveWorkspace().id
		});
		this.store.load({
			params: Ext.applyIf(params, {
				start: start,
				limit: og.pageSize
			})
		});
		this.needRefresh = false;
	},
	
	activate: function() {
		if (this.needRefresh) {
			this.load({start: 0});
		}
	},
	
	showMessage: function(text) {
		this.innerMessage.innerHTML = text;
	}
});

Ext.reg("tasks", og.TaskManager);