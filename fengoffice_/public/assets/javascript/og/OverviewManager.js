/**
 *  OverviewManager
 *
 */
og.OverviewManager = function() {

	var actions, moreActions;

	this.doNotRemove = true;
	this.needRefresh = false;

	if (!og.OverviewManager.store) {
		og.OverviewManager.store = new Ext.data.Store({
			proxy: new Ext.data.HttpProxy(new Ext.data.Connection({
				method: 'GET',
				url: og.getUrl('object', 'list_objects', {ajax: true})
			})),
			reader: new Ext.data.JsonReader({
				root: 'objects',
				totalProperty: 'totalCount',
				id: 'id',
				fields: [
					'name', 'object_id', 'type', 'tags', 'createdBy', 'createdById',
					{name: 'dateCreated', type: 'date', dateFormat: 'timestamp'},
					'updatedBy', 'updatedById',
					{name: 'dateUpdated', type: 'date', dateFormat: 'timestamp'},
					'icon', 'wsIds', 'manager', 'mimeType', 'url'
				]
			}),
			remoteSort: true,
			listeners: {
				'load': function() {
					var d = this.reader.jsonData;
					og.processResponse(d);
					var ws = og.clean(Ext.getCmp('workspace-panel').getActiveWorkspace().name);
					var tag = og.clean(Ext.getCmp('tag-panel').getSelectedTag().name);
					if (d.totalCount == 0) {
						if (tag) {
							this.fireEvent('messageToShow', lang("no objects with tag message", lang("objects"), ws, tag));
						} else {
							this.fireEvent('messageToShow', lang("no objects message", lang("objects"), ws));
						}
					} else {
						this.fireEvent('messageToShow', "");
					}
					og.hideLoading();
					og.showWsPaths();
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
		og.OverviewManager.store.setDefaultSort('dateUpdated', 'desc');
	}
	this.store = og.OverviewManager.store;
	this.store.addListener({messageToShow: {fn: this.showMessage, scope: this}});

	function renderName(value, p, r) {
		var ids = String(r.data.wsIds).split(',');
		var projectsString = "";
		for(var i = 0; i < ids.length; i++)
			projectsString += String.format('<span class="project-replace">{0}</span>&nbsp;', ids[i]);
	
		if (r.data.type == 'webpage') {
			return projectsString + String.format('<a href="#" onclick="window.open(\'{1}\'); return false">{0}</a>', og.clean(value), r.data.url);
		} else {
			return projectsString + String.format('<a href="#" onclick="og.openLink(\'{1}\')">{0}</a>', og.clean(value), r.data.url);
		}
	}

	function renderType(value, p, r){
		return String.format('<i>' + lang(value) + '</i>')
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
		return String.format('<div class="{0}" title="{1}"/>', classes, lang(r.data.type));
	}

	function renderUser(value, p, r) {
		return String.format('<a href="#" onclick="og.openLink(\'{1}\')">{0}</a>', og.clean(value), og.getUrl('user', 'card', {id: r.data.updatedById}));
	}

	function renderAuthor(value, p, r) {
		return String.format('<a href="#" onclick="og.openLink(\'{1}\')">{0}</a>', og.clean(value), og.getUrl('user', 'card', {id: r.data.createdById}));
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
				if (sm.getSelected().data.mimeType == 'prsn') {
					moreActions.slideshow.setDisabled(false);
				} else {
					moreActions.slideshow.setDisabled(true);
				}
				if (sm.getSelected().data.type == 'file') {
					moreActions.download.setDisabled(false);
				} else {
					moreActions.download.setDisabled(true);
				}
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
			id: 'type',
			header: lang('type'),
			dataIndex: 'type',
			width: 80,
        	renderer: renderType,
        	fixed:false,
        	resizable: true,
        	hideable:true,
        	menuDisabled: true
		},{
			id: 'name',
			header: lang("name"),
			dataIndex: 'name',
			width: 300,
			renderer: renderName
        },{
        	id: 'user',
        	header: lang('user'),
        	dataIndex: 'updatedBy',
        	width: 120,
        	renderer: renderUser
        },{
			id: 'tags',
			header: lang("tags"),
			dataIndex: 'tags',
			width: 120,
			hidden: true
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
		download: new Ext.Action({
			text: lang('download'),
			iconCls: 'ico-download',
			handler: function(e) {
				var url = og.getUrl('files', 'download_file', {id: getFirstSelectedId()});
				window.open(url);
			}
		}),
		properties: new Ext.Action({
			text: lang('properties'),
			iconCls: 'ico-properties',
			handler: function(e) {
				var o = sm.getSelected();
				var url = og.getUrl('object', 'view', {id: o.data.object_id, manager: o.data.manager});
				og.openLink(url);
			}
		}),
		slideshow: new Ext.Action({
			text: lang('slideshow'),
			iconCls: 'ico-slideshow',
			handler: function(e) {
				og.slideshow(getFirstSelectedId());
			},
			disabled: true
		})
	}
	
	actions = {
		newCO: new Ext.Action({
			text: lang('new'),
            tooltip: lang('create an object'),
            iconCls: 'ico-new',
			menu: {items: [
				{text: lang('contact'), iconCls: 'ico-contact', handler: function() {
					var url = og.getUrl('contact', 'add');
					og.openLink(url/*, {caller: 'contacts-panel'}*/);
				}},
				{text: lang('event'), iconCls: 'ico-event', handler: function() {
					var url = og.getUrl('event', 'add');
					og.openLink(url/*, {caller: 'calendar-panel'}*/);
				}},
				{text: lang('task'), iconCls: 'ico-task', handler: function() {
					var url = og.getUrl('task', 'add_task');
					og.openLink(url/*, {caller: 'tasks-panel'}*/);
				}},
				{text: lang('milestone'), iconCls: 'ico-milestone', handler: function() {
					var url = og.getUrl('milestone', 'add');
					og.openLink(url/*, {caller: 'tasks-panel'}*/);
				}},
				{text: lang('webpage'), iconCls: 'ico-webpages', handler: function() {
					var url = og.getUrl('webpage', 'add');
					og.openLink(url/*, {caller: 'webpages-panel'}*/);
				}},
				{text: lang('message'), iconCls: 'ico-message', handler: function() {
					var url = og.getUrl('message', 'add');
					og.openLink(url/*, {caller: 'messages-panel'}*/);
				}},
				{text: lang('document'), iconCls: 'ico-doc', handler: function() {
					var url = og.getUrl('files', 'add_document');
					og.openLink(url/*, {caller: 'documents-panel'}*/);
				}},
				/*{text: lang('spreadsheet'), iconCls: 'ico-sprd', handler: function() {
					var url = og.getUrl('files', 'add_spreadsheet');
					og.openLink(url, {caller: 'documents-panel'});
				}},*/
				{text: lang('presentation'), iconCls: 'ico-prsn', handler: function() {
					var url = og.getUrl('files', 'add_presentation');
					og.openLink(url/*, {caller: 'documents-panel'}*/);
				}},
				{text: lang('upload file'), iconCls: 'ico-upload', handler: function() {
					var url = og.getUrl('files', 'add_file');
					og.openLink(url/*, {caller: 'documents-panel'}*/);
				}},
				{text: lang('email'), iconCls: 'ico-email', handler: function() {
					var url = og.getUrl('mail', 'add_mail');
					og.openLink(url/*, {caller: 'documents-panel'}*/);
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
			text: lang('move to trash'),
            tooltip: lang('move selected objects to trash'),
            iconCls: 'ico-trash',
			disabled: true,
			handler: function() {
				if (confirm(lang('confirm move to trash'))) {
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
				moreActions.download,
				moreActions.properties,
				moreActions.slideshow
			]}
		}),
		refresh: new Ext.Action({
			text: lang('refresh'),
            tooltip: lang('refresh desc'),
            iconCls: 'ico-refresh',
			handler: function() {
				this.load();
			},
			scope: this
		}),
		showAsDashboard: new Ext.Action({
			text: lang('view as dashboard'),
            tooltip: lang('view as dashboard'),
            iconCls: 'ico-view-as-dashboard',
			handler: function() {
				og.switchToDashboard();
			},
			scope: this
		})
    };
    
	og.OverviewManager.superclass.constructor.call(this, {
		//enableDragDrop: true, //(breaks the checkbox selection)
		ddGroup : 'WorkspaceDD',
		store: this.store,
		layout: 'fit',
		autoExpandColumn: 'name',
		cm: cm,
		stripeRows: true,
		closable: true,
		/*style: "padding:7px;",*/
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
			/*actions.refresh,
			'-',*/
			'->',
			actions.showAsDashboard
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
	}, this);
};

Ext.extend(og.OverviewManager, Ext.grid.GridPanel, {
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
		if (this.innerMessage) {
			this.innerMessage.innerHTML = text;
		}
	}
});

Ext.reg("overview", og.OverviewManager);