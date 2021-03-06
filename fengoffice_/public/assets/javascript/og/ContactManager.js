/**
 *  ContactManager
 */
og.ContactManager = function() {
	var actions;
	this.doNotDestroy = true;
	this.active = true;
	
	this.store = new Ext.data.Store({
        proxy: new Ext.data.HttpProxy(new Ext.data.Connection({
			method: 'GET',
            url: og.getUrl('contact', 'list_all', {ajax:true})
        })),
        reader: new Ext.data.JsonReader({
            root: 'contacts',
            totalProperty: 'totalCount',
            id: 'id',
            fields: [
                'name', 'companyId', 'companyName', 'email', 'website', 'jobTitle', 'createdBy', 'createdById', 'role', 'tags',
                'department', 'email2', 'email3', 'workWebsite', 'workAddress', 'workPhone1', 'workPhone2', 
                'homeWebsite', 'homeAddress', 'homePhone1', 'homePhone2', 'mobilePhone'
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
						this.manager.showMessage(lang("no objects with tag message", lang("contacts"), ws, tag));
					} else {
						this.manager.showMessage(lang("no objects message", lang("contacts"), ws));
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
			}
		}
    });
    this.store.setDefaultSort('name', 'asc');
    this.store.manager = this;
    
    //--------------------------------------------
    // Renderers
    //--------------------------------------------

    function renderContactName(value, p, r) {
    	return String.format('<a href="#" onclick="og.openLink(\'{1}\', null)">{0}</a>', value, og.getUrl('contact', 'card', {id: r.id}));
    }
    function renderCompany(value, p, r) {
    	return String.format('<a href="#" onclick="og.openLink(\'{1}\', null)">{0}</a>', value, og.getUrl('company', 'card', {id: r.data.companyId}));
    }
    function renderEmail(value, p, r) {
    	return String.format('<a mailto="{0}">{0}</a>', value);
    }
    function renderWebsite(value, p, r) {
    	return String.format('<a href="" onclick="window.open(\'{0}\'); return false">{0}</a>', value);
    }
    
	function getSelectedIds() {
		var selections = sm.getSelections();
		if (selections.length <= 0) {
			return '';
		} else {
			var ret = '';
			for (var i=0; i < selections.length; i++) {
				ret += "," + selections[i].id;
			}	
			return ret.substring(1);
		}
	}
	
	function getFirstSelectedId() {
		if (sm.hasSelection()) {
			return sm.getSelected().id;
		}
		return '';
	}

	var sm = new Ext.grid.CheckboxSelectionModel();
	sm.on('selectionchange',
		function() {
			if (sm.getCount() <= 0) {
				actions.tag.setDisabled(true);
				actions.delContact.setDisabled(true);
				actions.editContact.setDisabled(true);
				actions.assignContact.setDisabled(true);
			} else {
				actions.editContact.setDisabled(sm.getCount() != 1);
				actions.assignContact.setDisabled(sm.getCount() != 1);
				actions.tag.setDisabled(false);
				actions.delContact.setDisabled(false);
			}
		});
    var cm = new Ext.grid.ColumnModel([
		sm,
		{
			id: 'name',
			header: lang("name"),
			dataIndex: 'name',
			width: 120,
			sortable: false,
			renderer: renderContactName
        },
		{
			id: 'role',
			header: lang("role"),
			dataIndex: 'role',
			sortable: false,
			width: 120
        },{
			id: 'company',
			header: lang("company"),
			dataIndex: 'companyName',
			width: 120,
			sortable: false,
			renderer: renderCompany
        },{
			id: 'email',
			header: lang("email"),
			dataIndex: 'email',
			width: 120,
			sortable: false,
			renderer: renderEmail
		},{
			id: 'tags',
			header: lang("tags"),
			dataIndex: 'tags',
			width: 120,
			sortable: false
        },{
			id: 'department',
			header: lang("department"),
			dataIndex: 'department',
			width: 120,
			hidden: true,
			sortable: false
        },{
			id: 'email2',
			header: lang("email2"),
			dataIndex: 'email2',
			width: 120,
			hidden: true,
			sortable: false,
			renderer: renderEmail
        },{
			id: 'email3',
			header: lang("email3"),
			dataIndex: 'email3',
			width: 120,
			hidden: true,
			sortable: false,
			renderer: renderEmail
        },{
			id: 'workWebsite',
			header: lang("workWebsite"),
			dataIndex: 'workWebsite',
			width: 120,
			hidden: true,
			sortable: false,
			renderer: renderWebsite
        },{
			id: 'workPhone1',
			header: lang("workPhone1"),
			dataIndex: 'workPhone1',
			width: 120,
			hidden: true,
			sortable: false
        },{
			id: 'workPhone2',
			header: lang("workPhone2"),
			dataIndex: 'workPhone2',
			width: 120,
			hidden: true,
			sortable: false
        },{
			id: 'workAddress',
			header: lang("workAddress"),
			dataIndex: 'workAddress',
			width: 120,
			hidden: true,
			sortable: false
        },{
			id: 'homeWebsite',
			header: lang("homeWebsite"),
			dataIndex: 'homeWebsite',
			width: 120,
			hidden: true,
			sortable: false,
			renderer: renderWebsite
        },{
			id: 'homePhone1',
			header: lang("homePhone1"),
			dataIndex: 'homePhone1',
			width: 120,
			hidden: true,
			sortable: false
        },{
			id: 'homePhone2',
			header: lang("homePhone2"),
			dataIndex: 'homePhone2',
			width: 120,
			hidden: true,
			sortable: false
        },{
			id: 'homeAddress',
			header: lang("homeAddress"),
			dataIndex: 'homeAddress',
			width: 120,
			hidden: true,
			sortable: false
        },{
			id: 'mobilePhone',
			header: lang("mobilePhone"),
			dataIndex: 'mobilePhone',
			width: 120,
			hidden: true,
			sortable: false
        }]);
    cm.defaultSortable = true;
	
	actions = {
		newContact: new Ext.Action({
			text: lang('new'),
            tooltip: lang('add new contact'),
            iconCls: 'ico-contact',
            handler: function() {
				var url = og.getUrl('contact', 'add');
				og.openLink(url, null);
			}
		}),
		delContact: new Ext.Action({
			text: lang('delete'),
            tooltip: lang('delete selected contacts'),
            iconCls: 'ico-delete',
			disabled: true,
			handler: function() {
				if (confirm(lang('confirm delete contacts'))) {
					this.load({
						action: 'delete',
						contacts: getSelectedIds()
					});
				}
			},
			scope: this
		}),
		editContact: new Ext.Action({
			text: lang('edit'),
            tooltip: lang('edit selected contact'),
            iconCls: 'ico-new',
			disabled: true,
			handler: function() {
				var url = og.getUrl('contact', 'edit', {id:getFirstSelectedId()});
				og.openLink(url, null);
			},
			scope: this
		}),
		assignContact: new Ext.Action({
			text: lang('assign to project'),
            tooltip: lang('assign contact to project'),
            iconCls: 'ico-workspaces',
			disabled: true,
			handler: function() {
				var url = og.getUrl('contact', 'assign_to_project', {id:getFirstSelectedId()});
				og.openLink(url, null);
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
		tag: new Ext.Action({
			text: lang('tag'),
	        tooltip: lang('tag selected contacts'),
	        iconCls: 'ico-tag',
			disabled: true,
			menu: new og.TagMenu({
				listeners: {
					'tagselect': {
						fn: function(tag) {
							this.load({
								action: 'tag',
								contacts: getSelectedIds(),
								tagTag: tag
							});
						},
						scope: this
					}
				}
			})
		})
    };
    
	og.ContactManager.superclass.constructor.call(this, {
        store: this.store,
		layout: 'fit',
        cm: cm,
        closable: true,
		stripeRows: true,
        loadMask: true,
        bbar: new Ext.PagingToolbar({
            pageSize: og.pageSize,
            store: this.store,
            displayInfo: true,
            displayMsg: lang('displaying contacts of'),
            emptyMsg: lang("no contacts to display")
        }),
		viewConfig: {
            forceFit: true
        },
		sm: sm,
		tbar:[
			actions.newContact,
			'-',
			actions.tag,
			actions.delContact,
			actions.editContact,
			actions.assignContact,
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

	og.eventManager.addListener("tag changed", function(tag) {
		if (this.active) {
			this.load({start: 0});
		} else {
    		this.needRefresh = true;
    	}
	}, this);
	og.eventManager.addListener("workspace changed", function(ws) {
		if (this.store.lastOptions) {
			cm.setHidden(cm.getIndexById('role'), this.store.lastOptions.params.active_project == 0);
		}
	}, this);
};

Ext.extend(og.ContactManager, Ext.grid.GridPanel, {
	load: function(params) {
		var start = (this.getBottomToolbar().getPageData().activePage - 1) * og.pageSize;
		if (!params) params = {};
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

og.ContactManager.getInstance = function() {
	if (!og.ContactManager.instance) {
		og.ContactManager.instance = new og.ContactManager();
	}
	return og.ContactManager.instance;
}