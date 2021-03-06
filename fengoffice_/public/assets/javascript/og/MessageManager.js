/**
 *  MessageManager
 *
 */
og.MessageManager = function() {
	var actions, moreActions;
	this.accountId = 0;
	this.doNotRemove = true;
	this.needRefresh = false;
	
	if (!og.MessageManager.store) {
		og.MessageManager.store = new Ext.data.Store({
			proxy: new og.GooProxy({
				url: og.getUrl('message', 'list_all')
			}),
			reader: new Ext.data.JsonReader({
				root: 'messages',
				totalProperty: 'totalCount',
				id: 'id',
				fields: [
					'object_id', 'type', 'title', 'text', 'date', 'is_today',
					'wsIds', 'userId', 'userName', 'tags', 'workspaceColors', 'ix'
				]
			}),
			remoteSort: true,
			listeners: {
				'load': function() {
					var d = this.reader.jsonData;
					var ws = og.clean(Ext.getCmp('workspace-panel').getActiveWorkspace().name);
					var tag = og.clean(Ext.getCmp('tag-panel').getSelectedTag().name);
					if (d.totalCount === 0) {
						if (tag) {
							this.fireEvent('messageToShow', lang("no objects with tag message", lang("messages"), ws, tag));
						} else {
							this.fireEvent('messageToShow', lang("no objects message", lang("messages"), ws));
						}
					} else {
						this.fireEvent('messageToShow', "");
					}
					og.showWsPaths();
				}
			}
		});
		og.MessageManager.store.setDefaultSort('date', 'desc');
	}
	this.store = og.MessageManager.store;
	this.store.addListener({messageToShow: {fn: this.showMessage, scope: this}});

	function renderDragHandle(value, p, r) {
		return '<div class="img-grid-drag" onmousedown="Ext.getCmp(\'message-manager\').getSelectionModel().selectRow('+r.data.ix+', true);"></div>';
	}
	
	function renderName(value, p, r) {
		var name = '';
		name = String.format(
				'<a style="font-size:120%" href="#" onclick="og.openLink(\'{1}\')" title="{2}">{0}</a>',
				og.clean(value), og.getUrl('message', 'view', {id: r.data.object_id}), og.clean(r.data.text));
	
		var wsString = String.format('<span class="project-replace">{0}</span>&nbsp;', r.data.wsIds);
		
		var text = '';
		if (r.data.text != ''){
			text = '&nbsp;-&nbsp;<span style="color:#888888;white-space:nowrap">';
			text += og.clean(r.data.text) + "</span></i>";
		}
		
		return wsString + name + text;
	}

		
	function renderFrom(value, p, r){
		name = String.format(
				'<a style="font-size:120%" href="#" onclick="og.openLink(\'{1}\')" title="{2}">{0}</a>',
				og.clean(value), og.getUrl('message', 'view', {id: r.data.object_id}), og.clean(r.data.text));
		return name;
	}
	
	
	function renderIcon(value, p, r) {
		return '<div class="db-ico ico-message"></div>';
	}

	function renderDate(value, p, r) {
		if (!value) {
			return "";
		}
		var userString = String.format('<a href="#" onclick="og.openLink(\'{1}\')">{0}</a>', og.clean(r.data.userName), og.getUrl('user', 'card', {id: r.data.userId}));
	
		if (!r.data.is_today) {
			return lang('last updated by on', userString, value);
		} else {
			return lang('last updated by at', userString, value);
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
	this.getSelectedIds = getSelectedIds;
	
	function getSelectedTypes() {
		var selections = sm.getSelections();
		if (selections.length <= 0) {
			return '';
		} else {
			var ret = '';
			for (var i=0; i < selections.length; i++) {
				ret += "," + selections[i].data.type;
			}	
			return ret.substring(1);
		}
	}
	this.getSelectedTypes = getSelectedTypes;
	
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
				actions.edit.setDisabled(true);
			} else {
				actions.tag.setDisabled(false);
				actions.del.setDisabled(false);
				actions.edit.setDisabled(false);
			}
		});
	
	var cm = new Ext.grid.ColumnModel([
		sm,{
			id: 'draghandle',
			header: '&nbsp;',
			width: 18,
        	renderer: renderDragHandle,
        	fixed:true,
        	resizable: false,
        	hideable:false,
        	menuDisabled: true
		},{
			id: 'icon',
			header: '&nbsp;',
			dataIndex: 'type',
			width: 28,
        	renderer: renderIcon,
        	fixed:true,
        	resizable: false,
        	hideable:false,
        	menuDisabled: true
		},{
			id: 'from',
			header: lang("from"),
			dataIndex: 'userName',
			width: 120,
			renderer: renderFrom
        },{
			id: 'title',
			header: lang("title"),
			dataIndex: 'title',
			width: 250,
			renderer: renderName,
			sortable:true
        },{
			id: 'tags',
			header: lang("tags"),
			dataIndex: 'tags',
			width: 60
        },{
			id: 'updatedOn',
			header: lang("last updated by"),
			dataIndex: 'date',
			width: 50,
			sortable: true,
			renderer: renderDate,
			sortable:true
        }]);
	cm.defaultSortable = false;

	moreActions = {};

	actions = {
		newCO: new Ext.Action({
			text: lang('new'),
            tooltip: lang('add new message'),
            iconCls: 'ico-new',
            handler: function() {
				var url = og.getUrl('message', 'add');
				og.openLink(url, null);
			}
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
							this.tagObjects(tag);
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
						ids: getSelectedIds(),
						types: getSelectedTypes()
					});
					this.getSelectionModel().clearSelections();
				}
			},
			scope: this
		}),
		edit: new Ext.Action({
			text: lang('edit'),
            tooltip: lang('edit selected object'),
            iconCls: 'ico-edit',
			disabled: true,
			handler: function() {
				var url = og.getUrl('message', 'edit', {id:getFirstSelectedId()});
				og.openLink(url, null);
			},
			scope: this
		})
    };
	this.actionRep = actions;
    
	og.MessageManager.superclass.constructor.call(this, {
		store: this.store,
		layout: 'fit',
		cm: cm,
		enableDrag: true,
		stateful: og.rememberGUIState,
		ddGroup: 'WorkspaceDD',
		id: 'message-manager',
		stripeRows: true,
		closable: true,
		loadMask: false,
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
			actions.edit
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
		this.resetVars();
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

Ext.extend(og.MessageManager, Ext.grid.GridPanel, {
	load: function(params) {
		if (!params) params = {};
		var start;
		if (typeof params.start == 'undefined') {
			start = (this.getBottomToolbar().getPageData().activePage - 1) * og.pageSize;
		} else {
			start = 0;
		}
		this.store.baseParams = {
					      tag: Ext.getCmp('tag-panel').getSelectedTag().name,
						  active_project: Ext.getCmp('workspace-panel').getActiveWorkspace().id,
						  account_id: this.accountId
					    };
		this.store.load({
			params: Ext.apply(params, {
				start: start,
				limit: og.pageSize				
			})
		});
	},
	resetVars: function(){
		this.viewUnclassified = false;
		this.accountId = 0;
	},
	
	activate: function() {
		if (this.needRefresh) {
			this.load({start:0});
		}
	},
	
	reset: function() {
		this.load({start:0});
	},
	
	showMessage: function(text) {
		this.innerMessage.innerHTML = text;
	},
	
	moveObjects: function(ws) {
		og.moveToWsOrMantainWs(this.id, ws);
	},
	
	moveObjectsToWsOrMantainWs: function(mantain, ws) {
		this.load({
			action: 'move',
			ids: this.getSelectedIds(),
			types: this.getSelectedTypes(),
			moveTo: ws,
			mantainWs: mantain
		});
	},
	
	trashObjects: function() {
		if (confirm(lang('confirm move to trash'))) {
			this.load({
				action: 'delete',
				ids: this.getSelectedIds(),
				types: this.getSelectedTypes()
			});
			this.getSelectionModel().clearSelections();
		}
	},
	
	tagObjects: function(tag) {
		this.load({
			action: 'tag',
			ids: this.getSelectedIds(),
			types: this.getSelectedTypes(),
			tagTag: tag
		});
	}
});


Ext.reg("messages", og.MessageManager);

/************************************************
Container for MessageManager,
*************************************************/
og.MessageManagerPanel = function() {
	this.doNotRemove = true;
	this.needRefresh = false;
	
	this.manager = new og.MessageManager();
	
	this.helpPanel = new og.HtmlPanel({
		html:'<div style="height:50px; line-height:50px; background-color:green;">HOLA</div>',
		style:'height: 50px;'
	});

	og.MessageManagerPanel.superclass.constructor.call(this, {
		layout: 'fit',
		border: false,
		bodyBorder: false,
		items: [
			this.helpPanel,
			this.manager
		],
		closable: true
	});
}

Ext.extend(og.MessageManagerPanel, Ext.Panel, {
	load: function(params) {
		this.manager.load(params);
	},
	activate: function() {
		this.manager.activate();
	},	
	reset: function() {
		this.manager.reset();
	},	
	showMessage: function(text) {
		this.manager.showMessage(text);
	}
});

Ext.reg("messages-containerpanel", og.MessageManagerPanel);