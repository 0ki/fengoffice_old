/**
 *  MessageManager
 *
 */
og.MessageManager = function() {
	var actions, moreActions;
	this.accountId = 0;
	this.viewType = "emails";
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
					'projectId', 'projectName', 'userId', 'userName', 'tags', 'workspaceColors','isRead','from','isDraft','isSent'
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
		if (r.data.type == 'message'){			
			name = String.format(
					'<a style="font-size:120%" href="#" onclick="og.openLink(\'{1}\')" title="{2}">{0}</a>',
					value, og.getUrl('message', 'view', {id: r.data.object_id}), String.format(r.data.text));
		}else{
			var bold = 'font-weight:normal;';
			if (!r.data.isRead) {bold = 'font-weight:600;';}
			var strAction = 'view';
			
			if (r.data.isDraft) {
				strDraft = "<span style='font-size:80%;color:red'>"+lang('draft')+"&nbsp;</style>";			
				strAction = 'edit_mail';
			}
			else { strDraft = ''; }
			
			
			name = String.format(
					'{4}<a style="font-size:120%;{3}" href="#" onclick="og.openLink(\'{1}\')" title="{2}">{0}</a>',
					value, og.getUrl('mail', strAction, {id: r.data.object_id}), String.format(r.data.text),bold,strDraft);
					
			 if (r.data.isSent) {
			 	name = String.format('<div class="db-ico ico-sent" style="padding-left:18px" title="{1}">{0}</div>',name,lang("mail sent"));
			 }


		}	
		var projectstring = '';		
	    if (r.data.projectId !== ''){
			var ids = String(r.data.projectId).split(',');
			var names = r.data.projectName.split(',');
			var colors = String(r.data.workspaceColors).split(',');
			projectstring = '<span class="og-wsname">';
			for(var i = 0; i < ids.length; i++){
				projectstring += String.format('<a href="#" class="og-wsname og-wsname-color-' + colors[i].trim() +  '" onclick="Ext.getCmp(\'workspace-panel\').select({1})">{0}</a>', names[i].trim(), ids[i].trim()) + "&nbsp";
			}
			projectstring += '</span>';

		}
		
		var text = '';
		if (r.data.text != ''){
			text = '&nbsp;-&nbsp;<span style="color:#888888;white-space:nowrap">';
			text += r.data.text + "</span></i>";
		}
		
		return projectstring + name + text;
	}

		
	function renderFrom(value, p, r){
		if (r.data.type == 'message'){
			name = String.format(
					'<a style="font-size:120%" href="#" onclick="og.openLink(\'{1}\')" title="{2}">{0}</a>',
					value, og.getUrl('message', 'view', {id: r.data.object_id}), String.format(r.data.text));
		} else{
			var bold = 'font-weight:normal;';
			if (!r.data.isRead) bold = 'font-weight:600;';
			name = String.format(
					'<a style="font-size:120%;{3}" href="#" onclick="og.openLink(\'{1}\')" title="{2}">{0}</a>',
					value, og.getUrl('mail', 'view', {id: r.data.object_id}), String.format(r.data.from),bold);
		}	
		return name;
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

	function renderAttachment(value, p, r){
		if (value)
			return String.format('<div class="db-ico ico-attachment"></div>');
		else
			return '';
	}

	function renderAccount(value, p, r) {
		return String.format('<a href="#" onclick="og.eventManager.fireEvent(\'mail account selected\',\'{1}\')">{0}</a>', value, r.data.accountId);
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
				if (/message/.test(selTypes)){//read/unread functionality not yet implemented in messages
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
			id: 'title',
			header: lang("title"),
			dataIndex: 'title',
			width: 250,
			renderer: renderName
        },{
			id: 'account',
			header: lang("account"),
			dataIndex: 'accountName',
			width: 60,
			renderer: renderAccount
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
	
	viewActions = {
			all: new Ext.Action({
				text: lang('view all'),
				handler: function() {
					Ext.getCmp('inbox_btn').toggle(false);
					this.viewType = "all";
					this.readType = "all";
					this.stateType = "all";
					
        			this.store.baseParams = {
					      read_type: this.readType,
					      view_type: this.viewType,
					      state_type : this.stateType,
					      tag: Ext.getCmp('tag-panel').getSelectedTag().name,
						  active_project: Ext.getCmp('workspace-panel').getActiveWorkspace().id
					    };
					this.load();
				},
				scope: this
			}),
			messages: new Ext.Action({
				text: lang('messages'),
				iconCls: "ico-message",
				handler: function() {
					this.viewType = "messages";
					this.load();
				},
				scope: this
			}),
			emails: new Ext.Action({
				text: lang('all emails'),
				iconCls: "ico-email",
				handler: function() {
					this.viewType = "emails";
					this.readType = "all";
					this.stateType = "all";
					this.accountId = 0;
					
        			this.store.baseParams = {
					      read_type: this.readType,
					      view_type: this.viewType,
					      state_type : this.stateType,
					      tag: Ext.getCmp('tag-panel').getSelectedTag().name,
						  active_project: Ext.getCmp('workspace-panel').getActiveWorkspace().id,
						  account_id: this.accountId
					    };
					this.load();
				},
				scope: this,
				menu: new og.EmailAccountMenu({
					listeners: {
						'accountselect': {
							fn: function(account) {
								this.viewType = "emails";
								this.readType = "all";
								this.stateType = "all";
								this.accountId = account;
								
			        			this.store.baseParams = {
								      read_type: this.readType,
								      view_type: this.viewType,
								      state_type : this.stateType,
								      tag: Ext.getCmp('tag-panel').getSelectedTag().name,
									  active_project: Ext.getCmp('workspace-panel').getActiveWorkspace().id,
									  account_id: this.accountId
								    };
								this.load();
							},
							scope: this
						}
					}
				},{},"view")
			}),
			unreademails: new Ext.Action({
				text: lang('unread emails'),
				iconCls: "ico-email",
				handler: function() {
					this.readType = "unreaded";
					this.viewType = "emails";
					this.stateType = "all";
					this.accountId = 0;
					
        			this.store.baseParams = {
					      read_type: this.readType,
					      view_type: this.viewType,
					      state_type : this.stateType,
					      tag: Ext.getCmp('tag-panel').getSelectedTag().name,
						  active_project: Ext.getCmp('workspace-panel').getActiveWorkspace().id,
						  account_id: this.accountId
					    };
					this.load();
				},
				scope: this,
				menu: new og.EmailAccountMenu({
					listeners: {
						'accountselect': {
							fn: function(account) {
								this.viewType = "emails";
								this.readType = "unreaded";
								this.stateType = "all";
								this.accountId = account;
								
			        			this.store.baseParams = {
								      read_type: this.readType,
								      view_type: this.viewType,
								      state_type : this.stateType,
								      tag: Ext.getCmp('tag-panel').getSelectedTag().name,
									  active_project: Ext.getCmp('workspace-panel').getActiveWorkspace().id,
									  account_id: this.accountId
								    };
								this.load();
							},
							scope: this
						}
					}
				},{},"view")
			}),
			drafts: new Ext.Action({
				text: lang('draft'),
				iconCls: "ico-email",
				handler: function() {
					this.readType = "all";
					this.stateType = "draft";
					this.viewType = "emails";
					this.accountId = 0;
					
        			this.store.baseParams = {
					      read_type: this.readType,
					      view_type: this.viewType,
					      state_type : this.stateType,
					      tag: Ext.getCmp('tag-panel').getSelectedTag().name,
						  active_project: Ext.getCmp('workspace-panel').getActiveWorkspace().id,
						  account_id: this.accountId
					    };
					this.load();
				},
				scope: this,
				menu: new og.EmailAccountMenu({
					listeners: {
						'accountselect': {
							fn: function(account) {
								this.viewType = "emails";
								this.stateType = "draft";
								this.readType = "all";
								this.accountId = account;
								
			        			this.store.baseParams = {
								      read_type: this.readType,
								      view_type: this.viewType,
								      state_type : this.stateType,
								      tag: Ext.getCmp('tag-panel').getSelectedTag().name,
									  active_project: Ext.getCmp('workspace-panel').getActiveWorkspace().id,
									  account_id: this.accountId
								    };
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
					this.viewType = "unclassified";
					this.accountId = 0;
					
        			this.store.baseParams = {
					      read_type: this.readType,
					      view_type: this.viewType,
					      state_type : this.stateType,
					      tag: Ext.getCmp('tag-panel').getSelectedTag().name,
						  active_project: Ext.getCmp('workspace-panel').getActiveWorkspace().id,
						  account_id: this.accountId
					    };
					this.load();
				},
				scope: this,
				menu: new og.EmailAccountMenu({
					listeners: {
						'accountselect': {
							fn: function(account) {
								this.viewType = "unclassified";
								this.accountId = account;
								
			        			this.store.baseParams = {
								      read_type: this.readType,
								      view_type: this.viewType,
								      state_type : this.stateType,
								      tag: Ext.getCmp('tag-panel').getSelectedTag().name,
									  active_project: Ext.getCmp('workspace-panel').getActiveWorkspace().id,
									  account_id: this.accountId
								    };
								this.load();
							},
							scope: this
						}
					}
				},{},"view")
			})
		};
	
	emailActions = {
			addAccount: new Ext.Action({
				text: lang('add mail account'),
				handler: function(e) {
					var url = og.getUrl('mail', 'add_account');
					og.openLink(url);
				}
			}),			
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
	
	actions = {
		newCO: new Ext.Action({
			text: lang('new'),
            tooltip: lang('create an object'),
            iconCls: 'ico-new',
            menu: {items: [
            	{
					text: lang('email'),
		            tooltip: lang('write new mail'),
		            iconCls: 'ico-messages',
		            handler: function() {
						var url = og.getUrl('mail', 'add_mail');
						og.openLink(url, null);
					}
				},
            	{ 	
            		text: lang('message'),
		            tooltip: lang('add new message'),
		            iconCls: 'ico-message',
		            handler: function() {
						var url = og.getUrl('message', 'add');
						og.openLink(url, null);
					}
				}
			]}
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
							this.viewType = "emails";
		        			this.accountId = 0;
		        			this.store.baseParams = {
							      read_type: this.readType,
							      view_type: this.viewType,
							      state_type : this.stateType,
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
	        toggleHandler: function(item, pressed) {
        		if(pressed){
					this.stateType = "sent";
					this.viewType = "emails";
        			this.accountId = 0;
        			this.store.baseParams = {
					      read_type: this.readType,
					      view_type: this.viewType,
					      state_type : this.stateType,
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
			toggleHandler: function(item, pressed) {
				if(pressed){
					this.stateType = "draft";
					this.viewType = "emails";
        			this.accountId = 0;
        			this.store.baseParams = {
					      read_type: this.readType,
					      view_type: this.viewType,
					      state_type : this.stateType,
					      tag: Ext.getCmp('tag-panel').getSelectedTag().name,
						  active_project: Ext.getCmp('workspace-panel').getActiveWorkspace().id,
						  account_id: this.accountId
					    };
					this.load();
        		} 
			},
			scope: this
    	}),
    	btn_messages: new Ext.Action({
				text: lang('messages'),
				toggleGroup : 'filter_option',
		        enableToggle: true,
		        pressed: false,
				toggleHandler: function(item, pressed) {
					if(pressed){
						this.viewType = "messages";
	        			this.accountId = 0;
	        			this.store.baseParams = {
					      read_type: this.readType,
					      view_type: this.viewType,
					      state_type : this.stateType,
					      tag: Ext.getCmp('tag-panel').getSelectedTag().name,
						  active_project: Ext.getCmp('workspace-panel').getActiveWorkspace().id,
						  account_id: this.accountId
					    };
						this.load();
	        		}
				},
				scope: this
		}),
		
		unread_email: new Ext.Action({
	        text: 'Unread',
	        enableToggle: true,
	        pressed: true,
	        toggleHandler: function(item, pressed) {
	        			if(pressed){							
							this.readType = "unreaded";						
	        			} else {
	        				this.readType = "all";
	        			}
	        			this.viewType = "emails";
	        			this.accountId = 0;
	        			
	        			this.store.baseParams = {
					      read_type: this.readType,
					      view_type: this.viewType,
					      state_type : this.stateType,
					      tag: Ext.getCmp('tag-panel').getSelectedTag().name,
						  active_project: Ext.getCmp('workspace-panel').getActiveWorkspace().id,
						  account_id: this.accountId
					    };
						
	        			this.load();
					},
	        pressed: true,
			scope: this
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
				//viewActions.messages,
				viewActions.unreademails,
				//viewActions.drafts,
				viewActions.emails,
				viewActions.unclassified
			]}
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
		email: new Ext.Action({
			text: lang('email actions'),
            tooltip: lang('more email actions'),
            iconCls: 'ico-email_menu',
			disabled: false,
			menu: {items: [
				emailActions.markAsRead,
				emailActions.markAsUnRead,
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
			actions.inbox_email,
			actions.sent_email,
			actions.draft_email,
			actions.btn_messages,
			actions.unread_email,
			
			'-',
			/*actions.refresh,
			'-',*/
			actions.view,
			actions.email,
			'-',
			actions.tag,
			actions.del,
			'-',
			actions.checkMails

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
		this.viewType = "emails";
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