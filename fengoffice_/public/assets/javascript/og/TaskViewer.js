/**
 *  TaskViewer
 *
 */
og.TaskViewer = function() {
	var actions, moreActions;

	this.doNotDestroy = true;

	this.store = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy(new Ext.data.Connection({
			method: 'GET',
			url: og.getUrl('task', 'list_tasks')
		})),
		reader: new Ext.data.JsonReader({
			root: 'tasks',
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
				if (this.getTotalCount() <= og.pageSize) {
					this.remoteSort = false;
				}
			}
		}
	});
	this.store.setDefaultSort('dateUpdated', 'desc');

	function renderName(value, p, r) {
		return String.format(
			'<a href="#" onclick="og.openLink(\'{2}\')">{0}</a>',
			value, r.data.name, og.getUrl('task', 'view_list', {id: r.data.object_id}));
	}

	function renderIcon(value, p, r) {
		return String.format('<img src="{0}" class="db-ico" />', value);
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
				ret += "," + selections[i].data.object_id;
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
				actions.tag.setDisabled(false || this.grid.store.lastOptions.params.active_project == 0);
				actions.del.setDisabled(false);
				actions.more.setDisabled(false);
			}
		});
	var cm = new Ext.grid.ColumnModel([
		sm,{
			id: 'project',
			header: lang("project"),
			dataIndex: 'project',
			width: 120,
			renderer: renderProject,
			sortable: false
        },{
        	id: 'icon',
        	header: '&nbsp;',
        	dataIndex: 'icon',
        	width: 24,
        	renderer: renderIcon,
        	sortable: false
        },{
        	id: 'user',
        	header: lang('user'),
        	dataIndex: 'updatedBy',
        	width: 120,
        	renderer: renderUser,
        	sortable: false
        },{
			id: 'name',
			header: lang("name"),
			dataIndex: 'name',
			//width: 120,
			renderer: renderName
        },{
			id: 'type',
			header: lang('type'),
			dataIndex: 'type',
			width: 120,
			hidden: true,
			sortable: false
		},{
			id: 'tags',
			header: lang("tags"),
			dataIndex: 'tags',
			width: 120,
			hidden: true,
			sortable: false
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
	cm.defaultSortable = true;

	moreActions = {
		properties: new Ext.Action({
			text: lang('properties'),
			iconCls: 'db-ico-properties',
			handler: function(e) {
				var o = sm.getSelected();
				var url = og.getUrl('object', 'view_properties', {object_id: o.data.object_id, manager: o.data.manager});
				og.openLink(url);
			}
		})
	}
	
	actions = {
		newCO: new Ext.Action({
			text: lang('new'),
            tooltip: lang('create an object'),
            iconCls: 'db-ico-new',
			menu: {items: [
				{text: lang('contact'), iconCls: 'db-ico-contact', handler: function() {
					var url = og.getUrl('contact', 'add');
					og.openLink(url);
				}},
				{text: lang('event'), iconCls: 'db-ico-event', handler: function() {
					var url = og.getUrl('event', 'add');
					og.openLink(url);
				}},
				{text: lang('task'), iconCls: 'db-ico-task', handler: function() {
					var url = og.getUrl('task', 'add_list');
					og.openLink(url);
				}},
				{text: lang('document'), iconCls: 'db-ico-doc', handler: function() {
					var url = og.getUrl('files', 'add_document');
					og.openLink(url);
				}},
				{text: lang('spreadsheet'), iconCls: 'db-ico-sprd', handler: function() {
					var url = og.getUrl('files', 'add_spreadsheet');
					og.openLink(url);
				}},
				{text: lang('presentation'), iconCls: 'db-ico-prsn', handler: function() {
					var url = og.getUrl('files', 'add_presentation');
					og.openLink(url);
				}},
				{text: lang('upload file'), iconCls: 'db-ico-upload', handler: function() {
					var url = og.getUrl('files', 'add_file');
					og.openLink(url);
				}}
			]}
		}),
		tag: new Ext.Action({
			text: lang('tag'),
            tooltip: lang('tag selected objects'),
            iconCls: 'db-ico-tag',
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
            iconCls: 'db-ico-delete',
			disabled: true,
			handler: function() {
				if (confirm(lang('confirm delete object'))) {
					this.load({
						action: 'delete',
						objects: getSelectedIds()
					});
				}
			},
			scope: this
		}),
		more: new Ext.Action({
			text: lang('more'),
            tooltip: lang('more actions on first selected object'),
            iconCls: 'db-ico-more',
			disabled: true,
			menu: {items: [
				moreActions.properties
			]}
		}),
		refresh: new Ext.Action({
			text: lang('refresh'),
            tooltip: lang('refresh desc'),
            iconCls: 'db-ico-refresh',
			handler: function() {
				this.store.reload();
			},
			scope: this
		})
    };
    
	og.TaskViewer.superclass.constructor.call(this, {
		store: this.store,
		layout: 'fit',
		cm: cm,
		id: 'taskviewer-panel',
		stripeRows: true,
		closable: true,
		loadMask: true,
		bbar: new Ext.PagingToolbar({
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
		]
	});

	og.eventManager.addListener("tag changed", function(tag) {
    	this.load();
	}, this);
	og.eventManager.addListener("workspace changed", function(ws) {
		this.load();
		cm.setHidden(cm.getIndexById('project'), this.store.lastOptions.params.active_project != 0);
	}, this);
	this.load();
	cm.setHidden(cm.getIndexById('project'), this.store.lastOptions.params.active_project != 0);
};

Ext.extend(og.TaskViewer, Ext.grid.GridPanel, {
	load: function(params) {
		if (!params) params = {};
		var start = (this.getBottomToolbar().getPageData().activePage - 1) * og.pageSize;
		this.store.load({
			params: Ext.apply(params, {
				start: start,
				limit: og.pageSize,
				tag: Ext.getCmp('tag-panel').getSelectedTag().name,
				active_project: Ext.getCmp('workspace-panel').getActiveWorkspace().id
			}),
			callback: function() {
				var d = this.reader.jsonData;
				og.processResponse(d);
			}
		});
	}
});

og.TaskViewer.getInstance = function() {
	if (!og.TaskViewer.instance) {
		og.TaskViewer.instance = new og.TaskViewer();
	}
	return og.TaskViewer.instance;
}
