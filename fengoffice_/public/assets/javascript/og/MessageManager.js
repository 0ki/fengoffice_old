/**
 *  MessageManager
 *
 */
og.MessageManager = function() {
	var actions, moreActions;
	this.accountId = 0;
	this.viewType = "all";
	this.active = true;
	this.doNotDestroy = true;
	this.needRefresh = false;

	this.store = new Ext.data.Store({
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
				'projectId', 'projectName', 'userId', 'userName', 'tags'
			]
		}),
		remoteSort: true,
		listeners: {
			'load': function() {
				if (this.getTotalCount() <= og.pageSize) {
					this.remoteSort = false;
				} else {
					this.remoteSort = true;
				}
				var d = this.reader.jsonData;
				og.processResponse(d);
				var ws = Ext.getCmp('workspace-panel').getActiveWorkspace().name;
				var tag = Ext.getCmp('tag-panel').getSelectedTag().name;
				if (d.totalCount == 0) {
					if (tag) {
						this.manager.showMessage(lang("no objects with tag message", lang("messages"), ws, tag));
					} else {
						this.manager.showMessage(lang("no objects message", lang("messages"), ws));
					}
				} else {
					this.manager.showMessage("");
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
	this.store.setDefaultSort('date', 'desc');
	this.store.manager = this;

	function renderName(value, p, r) {
		if (r.data.type == 'message')
			return String.format(
					'<a href="#" onclick="og.openLink(\'{1}\')" title="{2}">{0}</a>',
					value, og.getUrl('message', 'view', {id: r.data.object_id}), String.format(r.data.text));
		else
			return String.format(
					'<a href="#" onclick="og.openLink(\'{1}\')" title="{2}">{0}</a>',
					value, og.getUrl('mail', 'view', {id: r.data.object_id}), String.format(r.data.text));
	}

	function renderIcon(value, p, r) {
		if (value == "email")
			if (r.data.projectId > 0)
				return String.format('<div class="db-ico ico-email"></div>');
			else
				return String.format('<a href="#" onclick="og.openLink(\'{0}\')" title={1}><div class="db-ico ico-classify"></div></a>'
						, og.getUrl('mail', 'classify', {id: r.data.object_id}), lang('classify'));
		else
			return String.format('<div class="db-ico ico-message"></div>');
	}
	
	function renderType(value, p, r){
		return String.format('<i>' + lang(value) + '</i>')
	}

	function renderAttachment(value, p, r){
		if (value)
			return String.format('<div class="db-ico ico-attachment"></div>');
		else
			return '';
	}
	
	function renderUser(value, p, r) {
		return String.format('<a href="#" onclick="og.openLink(\'{1}\')">{0}</a>', value, og.getUrl('user', 'card', {id: r.data.userId}));
	}

	function renderProject(value, p, r) {
		return String.format('<a href="#" onclick="Ext.getCmp(\'workspace-panel\').select({1})">{0}</a>', value, r.data.projectId);
	}
	
	function renderText(value, p, r) {
		return String.format('<div id="message-text-{1}" style="cursor:pointer" onclick="javascript:document.getElementById(\'message-text-{1}\').style.whiteSpace = document.getElementById(\'message-text-{1}\').style.whiteSpace == \'nowrap\' ? \'pre\':\'nowrap\'; return false;">{0}</div>', value, r.id);
	}

	function renderAccount(value, p, r) {
		return String.format('<a href="#" onclick="og.eventManager.fireEvent(\'mail account selected\',\'{1}\')">{0}</a>', value, r.data.accountId);
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
        	sortable: false,
        	fixed:true,
        	resizable: false,
        	hideable:false,
        	menuDisabled: true
		},{
			id: 'hasAttachment',
			header: '&nbsp;',
			dataIndex: 'hasAttachment',
			width: 24,
        	renderer: renderAttachment,
        	sortable: false,
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
        	sortable: false,
        	fixed:false,
        	resizable: true,
        	hideable:true,
        	menuDisabled: true
		},{
			id: 'title',
			header: lang("title"),
			dataIndex: 'title',
			width: 250,
			sortable: false,
			renderer: renderName
        },{
			id: 'text',
			header: lang("text"),
			dataIndex: 'text',
			renderer: renderText,
			sortable: false,
			hidden: true,
			width: 250
        },{
			id: 'account',
			header: lang("account"),
			dataIndex: 'accountName',
			width: 60,
			renderer: renderAccount,
			sortable: false
        },{
			id: 'project',
			header: lang("project"),
			dataIndex: 'projectName',
			width: 60,
			renderer: renderProject,
			sortable: false
        },{
        	id: 'user',
        	header: lang('user'),
        	dataIndex: 'userName',
        	width: 60,
        	renderer: renderUser,
        	sortable: false
        },{
			id: 'tags',
			header: lang("tags"),
			dataIndex: 'tags',
			width: 120,
			sortable: false
        },{
			id: 'date',
			header: lang("date"),
			dataIndex: 'date',
			width: 50,
			sortable: false,
			renderer: renderDate
        }]);
	cm.defaultSortable = true;

	moreActions = {}
	
	viewActions = {
			all: new Ext.Action({
				text: lang('view all'),
				handler: function() {
					og.MessageManager.instance.viewType = "all";
					og.MessageManager.instance.accountId = 0;
					og.MessageManager.instance.load();
				}
			}),
			messages: new Ext.Action({
				text: lang('messages'),
				iconCls: "ico-message",
				handler: function() {
					og.MessageManager.instance.viewType = "messages";
					og.MessageManager.instance.load();
				}
			}),
			emails: new Ext.Action({
				text: lang('all emails'),
				iconCls: "ico-email",
				handler: function() {
					og.MessageManager.instance.viewType = "emails";
					og.MessageManager.instance.accountId = 0;
					og.MessageManager.instance.load();
				},
				menu: new og.EmailAccountMenu({
					listeners: {
						'accountselect': {
							fn: function(account) {
								this.viewType = "emails";
								this.accountId = account;
								this.load();
							},
							scope: this
						}
					}
				},{},"view")
			}),
			unclassified: new Ext.Action({
				text: lang('unclassified emails'),
				iconCls: "ico-classify",
				handler: function() {
					og.MessageManager.instance.viewType = "unclassified";
					og.MessageManager.instance.accountId = 0;
					og.MessageManager.instance.load();
				},
				menu: new og.EmailAccountMenu({
					listeners: {
						'accountselect': {
							fn: function(account) {
								this.viewType = "unclassified";
								this.accountId = account;
								this.load();
							},
							scope: this
						}
					}
				},{},"view")
			})
		}
	
	emailActions = {
			addAccount: new Ext.Action({
				text: lang('add mail account'),
				handler: function(e) {
					var url = og.getUrl('mail', 'add_account');
					og.openLink(url);
				}
			}),
			checkMails: new Ext.Action({
				text: lang('check mails'),
				handler: function() {
					og.MessageManager.instance.load({
						action: "checkmail"
					});
					og.MessageManager.instance.action = "";
				}
			}),
			editAccount: new Ext.Action({
				text: lang('edit account'),
	            tooltip: lang('edit email account'),
				disabled: false,
				menu: new og.EmailAccountMenu({
					listeners: {
						'accountselect': {
							fn: function(account) {
								var url = og.getUrl('mail', 'edit_account', {id: account});
								og.openLink(url);
							},
							scope: this
						}
					}
				},{},"edit")
			})
		}
	
	actions = {
			newMessage: new Ext.Action({
				text: lang('new'),
	            tooltip: lang('add new message'),
	            iconCls: 'ico-message',
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
				}
			},
			scope: this
		}),
		refresh: new Ext.Action({
			text: lang('refresh'),
            tooltip: lang('refresh desc'),
            iconCls: 'ico-refresh',
			handler: function() {
				this.store.reload();
			},
			scope: this
		}),
		view: new Ext.Action({
			text: lang('view'),
            iconCls: 'ico-view_options',
			disabled: false,
			menu: {items: [
				viewActions.all,
				'-',
				viewActions.messages,
				viewActions.emails,
				viewActions.unclassified
			]}
		}),
		email: new Ext.Action({
			text: lang('email actions'),
            tooltip: lang('more email actions'),
            iconCls: 'ico-email_menu',
			disabled: false,
			menu: {items: [
				emailActions.checkMails,
				'-',
				emailActions.addAccount,
				emailActions.editAccount
			]}
		})
    };
	this.actionRep = actions;
    
	og.MessageManager.superclass.constructor.call(this, {
		store: this.store,
		layout: 'fit',
		cm: cm,
		id: 'message-manager',
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
			actions.newMessage,
			'-',
			actions.tag,
			actions.del,
			'-',
			actions.refresh,
			'-',
			actions.view,
			actions.email
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
	
	og.eventManager.addListener("tag changed", function(tag) {
		this.resetVars();
		if (this.active) {
			this.load({start: 0});
		} else {
    		this.needRefresh = true;
    	}
	}, this);
	og.eventManager.addListener("workspace changed", function(ws) {
		if (this.store.lastOptions) {
			cm.setHidden(cm.getIndexById('project'), this.store.lastOptions.params.active_project != 0);
		}
	}, this);
};

Ext.extend(og.MessageManager, Ext.grid.GridPanel, {
	load: function(params) {
		if (!params) params = {};
		var start = (this.getBottomToolbar().getPageData().activePage - 1) * og.pageSize;
		this.store.load({
			params: Ext.apply(params, {
				start: start,
				limit: og.pageSize,
				tag: Ext.getCmp('tag-panel').getSelectedTag().name,
				active_project: Ext.getCmp('workspace-panel').getActiveWorkspace().id,
				account_id: this.accountId,
				view_type: this.viewType
			})
		});
	},
	resetVars: function(){
		this.viewUnclassified = false;
		this.accountId = 0;
	},
	
	activate: function() {
		this.active = true;
		if (this.needRefresh) {
			this.load({start: 0});
		}
	},
	
	deactivate: function() {
		this.active = false;
	},
	
	showMessage: function(text) {
		this.innerMessage.innerHTML = text;
	}
});

og.MessageManager.getInstance = function() {
	if (!og.MessageManager.instance) {
		og.MessageManager.instance = new og.MessageManager();
	}
	return og.MessageManager.instance;
}
