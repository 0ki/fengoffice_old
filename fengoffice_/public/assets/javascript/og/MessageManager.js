/**
 *  MessageManager
 *
 */
og.MessageManager = function() {
	var actions, moreActions;
	this.accountId = 0;
	this.viewType = "messages";
	this.readType = "unreaded";
	this.stateType = "received";
	this.doNotRemove = true;
	this.needRefresh = false;
	
	if (!og.MessageManager.store) {
		og.MessageManager.store = new Ext.data.Store({
			proxy: new Ext.data.HttpProxy(new Ext.data.Connection({
				method: 'GET',
				url: og.getUrl('message', 'list_all', {ajax:true})
			})),
			reader: new Ext.data.JsonReader({
				root: 'messages',
				totalProperty: 'totalCount',
				id: 'id',
				fields: [
					'object_id', 'type', 'accountId', 'accountName', 'hasAttachment', 'title', 'text', {name: 'date', type: 'date', dateFormat: 'timestamp'},
					'wsIds', 'projectName', 'userId', 'userName', 'tags', 'workspaceColors','isRead','from','isDraft','isSent'
				]
			}),
			remoteSort: true,
			listeners: {
				'load': function() {
					var d = this.reader.jsonData;
					og.processResponse(d);
					var ws = Ext.getCmp('workspace-panel').getActiveWorkspace().name;
					var tag = Ext.getCmp('tag-panel').getSelectedTag().name;
					if (d.totalCount === 0) {
						if (tag) {
							this.fireEvent('messageToShow', lang("no objects with tag message", lang("messages"), ws, tag));
						} else {
							this.fireEvent('messageToShow', lang("no objects message", lang("messages"), ws));
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
		og.MessageManager.store.setDefaultSort('date', 'desc');
	}
	this.store = og.MessageManager.store;
	this.store.addListener({messageToShow: {fn: this.showMessage, scope: this}});

	function renderName(value, p, r) {
		var name = '';
		name = String.format(
				'<a style="font-size:120%" href="#" onclick="og.openLink(\'{1}\')" title="{2}">{0}</a>',
				htmlentities(value), og.getUrl('message', 'view', {id: r.data.object_id}), String.format(r.data.text));
	
		var ids = String(r.data.wsIds).split(',');
		var wsString = "";
		for(var i = 0; i < ids.length; i++)
			wsString += String.format('<span class="project-replace">{0}</span>&nbsp;', ids[i]);
		
		var text = '';
		if (r.data.text != ''){
			text = '&nbsp;-&nbsp;<span style="color:#888888;white-space:nowrap">';
			text += r.data.text + "</span></i>";
		}
		
		return wsString + name + text;
	}

		
	function renderFrom(value, p, r){
		name = String.format(
				'<a style="font-size:120%" href="#" onclick="og.openLink(\'{1}\')" title="{2}">{0}</a>',
				htmlentities(value), og.getUrl('message', 'view', {id: r.data.object_id}), String.format(r.data.text));
		return name;
	}
	
	
	function renderIcon(value, p, r) {
		return String.format('<div class="db-ico ico-message"></div>');
	}

	function renderDate(value, p, r) {
		if (!value) {
			return "";
		}
		var userString = String.format('<a href="#" onclick="og.openLink(\'{1}\')">{0}</a>', r.data.userName, og.getUrl('user', 'card', {id: r.data.userId}));
	
		var now = new Date();
		if (now.dateFormat('Y-m-d') > value.dateFormat('Y-m-d')) {
			return lang('last updated by on', userString, value.dateFormat('M j'));
		} else {
			return lang('last updated by at', userString, value.dateFormat('h:i a'));
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
			} else {
				actions.tag.setDisabled(false);
				actions.del.setDisabled(false);
			}
		});
	
	var cm = new Ext.grid.ColumnModel([
		sm,{
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
			dataIndex: 'from',
			width: 120,
			renderer: renderFrom
        },{
			id: 'title',
			header: lang("title"),
			dataIndex: 'title',
			width: 250,
			renderer: renderName
        },{
			id: 'tags',
			header: lang("tags"),
			dataIndex: 'tags',
			width: 60
        },{
			id: 'date',
			header: lang("last updated by"),
			dataIndex: 'date',
			width: 50,
			sortable: true,
			renderer: renderDate
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
							this.load({
								action: 'tag',
								ids: getSelectedIds(),
								types: getSelectedTypes(),
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
						ids: getSelectedIds(),
						types: getSelectedTypes()
					});
					this.getSelectionModel().clearSelections();
				}
			},
			scope: this
		})
    };
	this.actionRep = actions;
    
	og.MessageManager.superclass.constructor.call(this, {
		store: this.store,
		layout: 'fit',
		cm: cm,
		//id: 'message-manager',
		stripeRows: true,
		closable: true,
		loadMask: false,
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
			actions.del
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
					      read_type: this.readType,
					      view_type: this.viewType,
					      state_type : this.stateType,
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
		this.viewType = "messages";
		this.readType = "unreaded";
		this.stateType = "received";
	},
	
	activate: function() {
		if (this.needRefresh) {
			this.load({start:0});
		}
	},
	
	showMessage: function(text) {
		this.innerMessage.innerHTML = text;
	}
});


Ext.reg("messages", og.MessageManager);