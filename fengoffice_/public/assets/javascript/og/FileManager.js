/**
 *  FileManager
 *
 */
og.FileManager = function() {
	var actions, moreActions;

	this.doNotRemove = true;
	this.needRefresh = false;

	if (!og.FileManager.store) {
		og.FileManager.store = new Ext.data.Store({
			proxy: new Ext.data.HttpProxy(new Ext.data.Connection({
				method: 'GET',
				url: og.getUrl('files', 'list_files', {ajax: true})
			})),
			reader: new Ext.data.JsonReader({
				root: 'files',
				totalProperty: 'totalCount',
				id: 'id',
				fields: [
					'name', 'object_id', 'type', 'tags', 'createdBy', 'createdById',
					{name: 'dateCreated', type: 'date', dateFormat: 'timestamp'},
					'updatedBy', 'updatedById',
					{name: 'dateUpdated', type: 'date', dateFormat: 'timestamp'},
					'icon', 'wsIds', 'manager', 'checkedOutById',
					'checkedOutByName', 'mimeType', 'isModifiable',
					'modifyUrl'
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
							this.fireEvent('messageToShow', lang("no objects with tag message", lang("documents"), ws, tag));
						} else {
							this.fireEvent('messageToShow', lang("no objects message", lang("documents"), ws));
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
		og.FileManager.store.setDefaultSort('dateUpdated', 'desc');
	}
	this.store = og.FileManager.store;
	this.store.addListener({messageToShow: {fn: this.showMessage, scope: this}});
	
	function renderName(value, p, r) {
		var result = '';
		var name = String.format(
			'<a style="font-size:120%" href="#" onclick="og.openLink(\'{2}\')">{0}</a>',
			value, r.data.name, og.getUrl('files', 'file_details', {id: r.data.object_id}));
		
		var projectsString = '';
	    if (r.data.wsIds != ''){
			var ids = String(r.data.wsIds).split(',');
			for(var i = 0; i < ids.length; i++)
				projectsString += String.format('<span class="project-replace">{0}</span>&nbsp;', ids[i]);
		}
		
		var actions = '';
		var actionStyle= ' style="font-size:90%;color:#777777;padding-top:3px;padding-left:18px;background-repeat:no-repeat" '; 
		
		if (r.data.isModifiable) {
			actions += String.format(
			'<a class="ico-edit" href="#" onclick="og.openLink(\'{0}\')" title="{1}" ' + actionStyle + '>' + lang('edit') + '</a>',
			r.data.modifyUrl,lang('edit this document'));
		}
		
		if (actions != '')
			actions = '<span style="padding-left:15px">-&nbsp;' + actions + '</span>';
		
		return projectsString + name + actions;
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

	function renderDateUpdated(value, p, r) {
		if (!value) {
			return "";
		}
		var userString = String.format('<a href="#" onclick="og.openLink(\'{1}\')">{0}</a>', r.data.updatedBy, og.getUrl('user', 'card', {id: r.data.updatedById}));
	
		var now = new Date();
		var dateString = '';
		if (now.dateFormat('Y-m-d') > value.dateFormat('Y-m-d')) {
			return lang('last updated by on', userString, value.dateFormat('M j'));
		} else {
			return lang('last updated by at', userString, value.dateFormat('h:i a'));
		}
	}
	
	function renderDateCreated(value, p, r) {
		if (!value) {
			return "";
		}
		var userString = String.format('<a href="#" onclick="og.openLink(\'{1}\')">{0}</a>', r.data.createdBy, og.getUrl('user', 'card', {id: r.data.createdById}));
	
		var now = new Date();
		var dateString = '';
		if (now.dateFormat('Y-m-d') > value.dateFormat('Y-m-d')) {
			return lang('last updated by on', userString, value.dateFormat('M j'));
		} else {
			return lang('last updated by at', userString, value.dateFormat('h:i a'));
		}
	}

	function renderCheckout(value, p, r) {
		if (value =='')
			return String.format('<div class="ico-unlocked" style="display:block;height:16px;background-repeat:no-repeat;padding-left:18px">'
			+ '<a href="#" onclick="og.openLink(\'{1}\')" title="{2}">{0}</a>', lang('lock'), og.getUrl('files', 'checkout_file', {id: r.id}), lang('checkout description'));
		else if (value == 'self' && r.data.checkedOutById == "0"){
			return String.format('<div class="ico-locked" style="display:block;height:16px;background-repeat:no-repeat;padding-left:18px">' +
				'<a href="#" onclick="og.openLink(\'{1}\')">{0}</a>', 
				lang('unlock'), og.getUrl('files', 'undo_checkout', {id: r.id})) + ', ' +
				String.format('<a href="#" onclick="og.openLink(\'{1}\')" title="{2}">{0}</a>', 
				lang('checkin'), og.getUrl('files', 'checkin_file', {id: r.id}), lang('checkin description'))
				 + '</div>';
			}
		else
			return '<div class="ico-locked" style="display:block;height:16px;background-repeat:no-repeat;padding-left:18px">' +
				lang('checked out by', String.format('<a href="#" onclick="og.openLink(\'{1}\')">{0}</a>', 
				r.data.checkedOutByName, og.getUrl('user', 'card', {id: r.data.checkedOutById}))) + '</div>';
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
				actions.tag.setDisabled(false);
				actions.del.setDisabled(false);
				actions.more.setDisabled(sm.getCount() != 1);
				if (sm.getSelected().data.mimeType == 'prsn') {
					moreActions.slideshow.setDisabled(false);
				} else {
					moreActions.slideshow.setDisabled(true);
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
			id: 'name',
			header: lang("name"),
			dataIndex: 'name',
			width: 300,
			renderer: renderName,
			sortable: true
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
			width: 120,
			hidden: true
        },{
			id: 'updated',
			header: lang("last updated by"),
			dataIndex: 'dateUpdated',
			width: 120,
			renderer: renderDateUpdated,
			sortable: true
        },{
			id: 'created',
			header: lang("created by"),
			dataIndex: 'dateCreated',
			width: 120,
			hidden: true,
			renderer: renderDateCreated
		},{
			id: 'status',
			header: lang("status"),
			dataIndex: 'checkedOutByName',
			width: 120,
			renderer: renderCheckout
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
				{text: lang('upload file'), iconCls: 'ico-upload', handler: function() {
					var url = og.getUrl('files', 'add_file');
					og.openLink(url);
				}},'-',
				{text: lang('document'), iconCls: 'ico-doc', handler: function() {
					var url = og.getUrl('files', 'add_document');
					og.openLink(url);
				}},
				/*{text: lang('spreadsheet'), iconCls: 'ico-sprd', handler: function() {
					var url = og.getUrl('files', 'add_spreadsheet');
					og.openLink(url);
				}},*/
				{text: lang('presentation'), iconCls: 'ico-prsn', handler: function() {
					var url = og.getUrl('files', 'add_presentation');
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
            tooltip: lang('more actions'),
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
				this.store.reload();
			},
			scope: this
		})
    };
    
	og.FileManager.superclass.constructor.call(this, {
		store: this.store,
		layout: 'fit',
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
			actions.more/*,
			'-',
			actions.refresh*/
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

Ext.extend(og.FileManager, Ext.grid.GridPanel, {
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

Ext.reg("files", og.FileManager);


