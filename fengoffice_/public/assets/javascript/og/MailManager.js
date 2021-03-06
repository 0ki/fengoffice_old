/**
 *  MailManager
 *
 */
og.MailManager = function() {
	var actions, moreActions, selectActions, accountActions, emailActions;
	this.accountId = 0;
	this.viewType = "all";
	this.readType = "all";
	this.classifType = "all";
	this.stateType = "received";
	this.doNotRemove = true;
	this.needRefresh = false;

	if (!og.MailManager.store) {
		og.MailManager.store = new Ext.data.Store({
			proxy: new og.GooProxy({
				url: og.getUrl('mail', 'list_all'),
				timeout: 0//Ext.Ajax.timeout
			}),
			reader: new Ext.data.JsonReader({
				root: 'messages',
				totalProperty: 'totalCount',
				id: 'id',
				fields: [
					'object_id', 'type', 'accountId', 'accountName', 'hasAttachment', 'subject', 'text', {name: 'date', type: 'date', dateFormat: 'timestamp'},
					'projectId', 'projectName', 'userId', 'userName', 'tags', 'workspaceColors','isRead','from','from_email','isDraft','isSent','folder','to'
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
							this.fireEvent('messageToShow', lang("no objects with tag message", lang("emails"), ws, tag));
						} else {
							this.fireEvent('messageToShow', lang("no objects message", lang("emails"), ws));
						}
					} else {
						this.fireEvent('messageToShow', "");
					}
					og.showWsPaths();
				}
			}
		});
		og.MailManager.store.setDefaultSort('date', 'desc');
	}
	this.store = og.MailManager.store;
	this.store.addListener({messageToShow: {fn: this.showMessage, scope: this}});
	
	function renderName(value, p, r) {
		var name = '';
		var bold = 'font-weight:normal;';
		if (!r.data.isRead) {bold = 'font-weight:bold;';}
		var strAction = 'view';
		
		if (r.data.isDraft) {
			strDraft = "<span style='font-size:80%;color:red'>"+lang('draft')+"&nbsp;</style>";			
			strAction = 'edit_mail';
		}
		else { strDraft = ''; }
		
		var subject = og.clean(value.trim()) || '<i>' + lang("no subject") + '</i>';
		
		name = String.format(
				'{4}<a style="font-size:120%;{3}" href="#" onclick="og.openLink(\'{1}\')" title="{2}">{0}</a>',
				subject, og.getUrl('mail', strAction, {id: r.data.object_id}), og.clean(r.data.text),bold,strDraft);
				
		if (r.data.isSent) {
			name = String.format('<span class="db-ico ico-sent" style="padding-left:18px" title="{1}">{0}</span>',name,lang("mail sent"));
		}
		
		var projectstring = String.format('<span class="project-replace">{0}</span>&nbsp;', r.data.projectId);
		
		var text = '';
		if (r.data.text != ''){
			text = '&nbsp;-&nbsp;<span style="color:#888888;white-space:nowrap">';
			text += og.clean(r.data.text) + "</span></i>";
		}
		
		return projectstring + name + text;
	}

		
	function renderFrom(value, p, r){
		var bold = 'font-weight:normal;';
		var strAction = 'view';
		
		if (r.data.isDraft) strAction = 'edit_mail';
		if (!r.data.isRead) bold = 'font-weight:bold;';
		
		var sender = og.clean(value.trim()) || '<i>' + lang("no sender") + '</i>';
		
		name = String.format(
				'<a style="font-size:120%;{3}" href="#" onclick="og.openLink(\'{1}\')" title="{2}">{0}</a>',
				sender, og.getUrl('mail', strAction, {id: r.data.object_id}), og.clean(r.data.from_email),bold);
		return name;
	}
	
	
	function renderIcon(value, p, r) {
		if (r.data.projectId.length > 0)
			return '<div class="db-ico ico-email"></div>';
		else
			return String.format('<a href="#" onclick="og.openLink(\'{0}\')" title={1}><div class="db-ico ico-classify"></div></a>', og.getUrl('mail', 'classify', {id: r.data.object_id}), lang('classify'));
	}

	function renderAttachment(value, p, r){
		if (value)
			return '<div class="db-ico ico-attachment"></div>';
		else
			return '';
	}

	function renderAccount(value, p, r) {
		return String.format('<a href="#" onclick="og.eventManager.fireEvent(\'mail account selected\',\'{1}\')">{0}</a>', og.clean(value), r.data.accountId);
	}
	
	function renderTo(value, p, r) {
		return String.format('<a href="#" onclick="og.openLink(\'{1}\')" title="{0}">{0}</a>', og.clean(value), og.getUrl('mail', 'add_mail', {}));
	}
	
	function renderFolder(value, p, r) {
		if (r.data.folder != 'undefined')
			return r.data.folder;
		else
			return '';
	}
	
	function renderDate(value, p, r) {
		if (!value) {
			return "";
		}

		var now = new Date();
		if (now.dateFormat('Y-m-d') > value.dateFormat('Y-m-d')) {
			return value.dateFormat(og.date_format + ' h:i a');
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
	this.getSelectedIds = getSelectedIds;
	
	function getSelectedReadTypes() {
		var selections = sm.getSelections();
		if (selections.length <= 0) {
			return '';
		} else {
			var read = false;
			var unread = false;
			for (var i=0; i < selections.length; i++) {
				if (selections[i].data.isRead) read = true;
				if (!selections[i].data.isRead) unread = true;
				if (read && unread) return 'all';
			}	
			if (read) return 'read';
			else return 'unread';
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
				emailActions.markAsRead.setDisabled(true);				
				emailActions.markAsUnRead.setDisabled(true);				
			} else {
				actions.tag.setDisabled(false);
				actions.del.setDisabled(false);
				
				var selTypes = getSelectedTypes();
				if (/message/.test(selTypes)){
					emailActions.markAsRead.setDisabled(true);
					emailActions.markAsUnRead.setDisabled(true);
				}else {								
					emailActions.markAsRead.setDisabled(false);
					emailActions.markAsUnRead.setDisabled(false);				
					var selReadTypes = getSelectedReadTypes();
					
					if (selReadTypes == 'read') emailActions.markAsRead.setDisabled(true);
					else if (selReadTypes == 'unread') emailActions.markAsUnRead.setDisabled(true);	
				}
				
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
			id: 'hasAttachment',
			header: '&nbsp;',
			dataIndex: 'hasAttachment',
			width: 24,
        	renderer: renderAttachment,
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
			id: 'subject',
			header: lang("subject"),
			dataIndex: 'subject',
			width: 250,
			renderer: renderName
        },{
			id: 'account',
			header: lang("account"),
			dataIndex: 'accountName',
			width: 60,
			renderer: renderAccount
        },{
			id: 'to',
			header: lang("to"),
			dataIndex: 'to',
			width: 100,
			hidden: true,
			renderer: renderTo
        },{
			id: 'tags',
			header: lang("tags"),
			dataIndex: 'tags',
			sortable: false,
			width: 60
        },{
			id: 'date',
			header: lang("date"),
			dataIndex: 'date',
			width: 60,
			renderer: renderDate
        },{
			id: 'folder',
			header: lang("folder"),
			dataIndex: 'folderName',
			width: 60,
			sortable: true,
			hidden: true,
			renderer: renderFolder
        }]);
	cm.defaultSortable = true;

	moreActions = {};
	
	filterReadUnread = {
		all: new Ext.Action({
			text: lang('view all'),
			handler: function() {
				this.reloadFiltering("all", null, null);
				Ext.getCmp('mails-manager').getTopToolbar().items.get('tb-item-read-unread').setText(lang('view by state'))
			},
			scope: this
		}),
		read: new Ext.Action({
			text: lang('read'),
			handler: function() {
				this.reloadFiltering("read", null, null);
				Ext.getCmp('mails-manager').getTopToolbar().items.get('tb-item-read-unread').setText(lang('read'))
			},
			scope: this
		}),
		unread: new Ext.Action({
			text: lang('unread'),
			handler: function() {
				this.reloadFiltering("unread", null, null);
				Ext.getCmp('mails-manager').getTopToolbar().items.get('tb-item-read-unread').setText(lang('unread'))
			},
			scope: this
		})
	};
	
	filterClassification = {
		all: new Ext.Action({
			text: lang('view all'),
			handler: function() {
				this.reloadFiltering(null, null, null, 'all');
				Ext.getCmp('mails-manager').getTopToolbar().items.get('tb-item-classification').setText(lang('view by classification'))
			},
			scope: this
		}),
		classified: new Ext.Action({
			text: lang('classified'),
			handler: function() {
				this.reloadFiltering(null, null, null, "classified");
				Ext.getCmp('mails-manager').getTopToolbar().items.get('tb-item-classification').setText(lang('classified'))
			},
			scope: this
		}),
		unclassified: new Ext.Action({
			text: lang('unclassified'),
			handler: function() {
				this.reloadFiltering(null, null, null, "unclassified");
				Ext.getCmp('mails-manager').getTopToolbar().items.get('tb-item-classification').setText(lang('unclassified'))
			},
			scope: this
		})
	};
	
	filterAccounts = {};
	
	emailActions = {
		markAsRead: new Ext.Action({
			text: lang('mark read'),
            tooltip: lang('mark read'),
            iconCls: 'ico-mail-mark-read',
			disabled: true,
			handler: function() {
				this.load({
					action: 'markAsRead',
					ids: getSelectedIds(),
					types: getSelectedTypes()
				});
			},
			scope: this
		}),
		markAsUnRead: new Ext.Action({
			text: lang('mark unread'),
            tooltip: lang('mark unread'),
            iconCls: 'ico-mail-mark-unread',
			disabled: true,
			handler: function() {
				this.load({
					action: 'markAsUnRead',
					ids: getSelectedIds(),
					types: getSelectedTypes()
				});
			},
			scope: this
		})
	};
	
	accountActions = {
		addAccount: new Ext.Action({
			text: lang('add mail account'),
			handler: function(e) {
				var url = og.getUrl('mail', 'add_account');
				og.openLink(url);
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
	};
	
	selectActions = {
		selectAll: new Ext.Action({
			text: lang('all'),
			handler: function(e) {
				sm.selectAll();
			}
		}),
		selectNone: new Ext.Action({
			text: lang('none'),
			handler: function(e) {
				sm.clearSelections();
			}
		}),
		selectRead: new Ext.Action({
			text: lang('read'),
			handler: function(e) {
				sm.selectAll();
				var selections = sm.getSelections();
				for (var i=0; i < selections.length; i++) {
					if (!selections[i].data.isRead) sm.deselectRow(i, false);
				}	
			}
		}),
		selectUnread: new Ext.Action({
			text: lang('unread'),
			handler: function(e) {
				sm.selectAll();
				var selections = sm.getSelections();
				for (var i=0; i < selections.length; i++) {
					if (selections[i].data.isRead) sm.deselectRow(i, false);
				}	
			}
		}),
		selectClassified: new Ext.Action({
			text: lang('classified'),
			handler: function(e) {
				sm.selectAll();
				var selections = sm.getSelections();
				for (var i=0; i < selections.length; i++) {
					if (!selections[i].data.projectId.length > 0) sm.deselectRow(i, false);
				}	
			}
		}),
		selectUnclassified: new Ext.Action({
			text: lang('unclassified'),
			handler: function(e) {
				sm.selectAll();
				var selections = sm.getSelections();
				for (var i=0; i < selections.length; i++) {
					if (selections[i].data.projectId.length > 0) sm.deselectRow(i, false);
				}	
			}
		})
	};
	
	actions = {
		newCO: new Ext.Action({
			text: lang('new'),
            tooltip: lang('create an email'),
            iconCls: 'ico-new',
            handler: function() {
            	var url = og.getUrl('mail', 'add_mail');
            	og.openLink(url, null);
            }
		}),
		accounts: new Ext.Action({
			text: lang('accounts'),
            tooltip: lang('account options'),
            iconCls: 'ico-administration',
			disabled: false,
			menu: {items: [
				accountActions.addAccount,
				accountActions.editAccount
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
		checkMails: new Ext.Action({
			text: lang('check mails'),
			iconCls: 'ico-check_mails',
			handler: function() {
				this.load({
					action: "checkmail"
				});
				this.action = "";
			},
			scope: this
		}),
		inbox_email: new Ext.Action({
	        text: lang('inbox'),
	        toggleGroup : 'filter_option',
	        enableToggle: true,
	        pressed: true,
	        id: 'inbox_btn',
	        toggleHandler: function(item, pressed) {
       			if(pressed){
					this.stateType = "received";	
					this.viewType = "all";
        			this.store.baseParams = {
					      read_type: this.readType,
					      view_type: this.viewType,
					      state_type : this.stateType,
					      classif_type: this.classifType,
					      tag: Ext.getCmp('tag-panel').getSelectedTag().name,
						  active_project: Ext.getCmp('workspace-panel').getActiveWorkspace().id,
						  account_id: this.accountId
					    };
					this.load();						
       			}
			},			
			scope: this
    	}),
		sent_email: new Ext.Action({
	        text: lang('sent'),
	        toggleGroup : 'filter_option',
	        enableToggle: true,
	        pressed: false,
	        id: 'sent_btn',
	        toggleHandler: function(item, pressed) {
        		if(pressed){
					this.stateType = "sent";
					this.viewType = "all";
        			this.store.baseParams = {
					      read_type: this.readType,
					      view_type: this.viewType,
					      state_type : this.stateType,
					      classif_type: this.classifType,
					      tag: Ext.getCmp('tag-panel').getSelectedTag().name,
						  active_project: Ext.getCmp('workspace-panel').getActiveWorkspace().id,
						  account_id: this.accountId
					    };
					this.load();
        		} 
			},
			scope: this
    	}),
    	
		draft_email: new Ext.Action({
	        text: lang('draft'),
	        toggleGroup : 'filter_option',
	        enableToggle: true,
	        pressed: false,
	        id: 'draft_btn',
			toggleHandler: function(item, pressed) {
				if(pressed){
					this.stateType = "draft";
					this.viewType = "all";
        			this.store.baseParams = {
					      read_type: this.readType,
					      view_type: this.viewType,
					      state_type : this.stateType,
					      classif_type: this.classifType,
					      tag: Ext.getCmp('tag-panel').getSelectedTag().name,
						  active_project: Ext.getCmp('workspace-panel').getActiveWorkspace().id,
						  account_id: this.accountId
					    };
					this.load();
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
		viewReadUnread: new Ext.Action({
			text: lang('view by state'),
            iconCls: 'ico-mail-mark-read',
			disabled: false,
			id: 'tb-item-read-unread',
			menu: {items: [
				filterReadUnread.all,
				'-',
				filterReadUnread.read,
				filterReadUnread.unread
			]}
		}),
		viewByAccount: new Ext.Action({
			text: lang('view by account'),
            iconCls: 'ico-account',
			disabled: false,
			id: 'tb-item-byaccount',
			menu: new og.EmailAccountMenu({
				listeners: {
					'accountselect': {
						fn: function(account, name) {
							this.accountId = account;
							this.load();
							if (account == 0) {
								name = lang('view by account');
							}
							Ext.getCmp('mails-manager').getTopToolbar().items.get('tb-item-byaccount').setText(name);
						},
						scope: this
					}
				}
			},[{name: lang('view all'), email:'', id: '', separator:true}],"view")
		}),
		viewByClassification: new Ext.Action({
			text: lang('view by classification'),
            iconCls: 'ico-classify',
			disabled: false,
			id: 'tb-item-classification',
			menu: {items: [
				filterClassification.all,
				'-',
				filterClassification.classified,
				filterClassification.unclassified
			]}
		}),
		select: new Ext.Action({
			text: lang('select'),
            tooltip: lang('select'),
            iconCls: 'ico-select',
			disabled: false,
			menu: {items: [
				selectActions.selectAll,
				selectActions.selectNone,
				'-',
				selectActions.selectRead,
				selectActions.selectUnread,
				'-',
				selectActions.selectClassified,
				selectActions.selectUnclassified
			]}
		})
    };
	this.actionRep = actions;

	this.topTbar1 = new Ext.Toolbar({
		style: 'border:0px none;',
		items: [
			actions.newCO,
			'-',
			actions.tag,
			actions.del,
			'-',
			emailActions.markAsRead,
			emailActions.markAsUnRead,
			'-',
			actions.checkMails,
			actions.accounts
		]
	});
	
	this.topTbar2 = new Ext.Toolbar({
		style: 'border:0px none',
		items: [
			actions.select,
			'-',
			actions.inbox_email,
			actions.sent_email,
			actions.draft_email,
			'-',
			lang('filter')+': ',
			actions.viewReadUnread,
			actions.viewByClassification,
			actions.viewByAccount
		]
	});
		    
	og.MailManager.superclass.constructor.call(this, {
		store: this.store,
		layout: 'fit',
		cm: cm,
		enableDrag: true,
		ddGroup: 'WorkspaceDD',
		border: false,
		bodyBorder: false,
		stripeRows: true,
		closable: true,
		loadMask: false,
		id: 'mails-manager',
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
		tbar: this.topTbar2,
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
	
	function toggleButtons(inb, sent, dra) {
		Ext.getCmp('inbox_btn').toggle(inb);
		Ext.getCmp('sent_btn').toggle(sent);
		Ext.getCmp('draft_btn').toggle(dra);
	}
	
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


Ext.extend(og.MailManager, Ext.grid.GridPanel, {
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
					      classif_type: this.classifType,
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
	},
	
	getFirstToolbar: function() {
		return this.topTbar1;
	},
	
	reloadFiltering: function(readType, viewType, stateType, classifType) {
		if (readType) this.readType = readType;
		if (viewType) this.viewType = viewType;
		if (stateType) this.stateType = stateType;
		if (classifType) this.classifType = classifType;
		
		this.store.baseParams = {
			read_type: this.readType,
			view_type: this.viewType,
			state_type : this.stateType,
			classif_type : this.classifType,
			tag: Ext.getCmp('tag-panel').getSelectedTag().name,
			active_project: Ext.getCmp('workspace-panel').getActiveWorkspace().id
		};
		this.load();
	}
});

Ext.reg("mails", og.MailManager);


/************************************************
Container for MailManager, adds a new toolbar
*************************************************/
og.MailManagerPanel = function() {
	this.doNotRemove = true;
	this.needRefresh = false;
	
	this.manager = new og.MailManager();

	og.MailManagerPanel.superclass.constructor.call(this, {
		layout: 'fit',
		border: false,
		bodyBorder: false,
		tbar: this.manager.getFirstToolbar(),
		items: [this.manager],
		closable: true
	});
}

Ext.extend(og.MailManagerPanel, Ext.Panel, {
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

Ext.reg("mails-containerpanel", og.MailManagerPanel);