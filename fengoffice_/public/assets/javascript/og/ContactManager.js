/**
 *  ContactManager
 */
og.ContactManager = function() {
	var actions;
	this.doNotDestroy = true;
	
	this.store = new Ext.data.Store({
        proxy: new Ext.data.HttpProxy(new Ext.data.Connection({
			method: 'GET',
            url: og.getUrl('contact', 'list_all')
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
				}
			}
		}
    });
    this.store.setDefaultSort('name', 'asc');
    this.store.contactManager = this;
    
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
				actions.tag.setDisabled(false || this.grid.store.lastOptions.params.active_project == 0);
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
			renderer: renderContactName
        },
		{
			id: 'role',
			header: lang("role"),
			dataIndex: 'role',
			width: 120
        },{
			id: 'company',
			header: lang("company"),
			dataIndex: 'companyName',
			width: 120,
			renderer: renderCompany
        },{
			id: 'email',
			header: lang("email"),
			dataIndex: 'email',
			width: 120,
			renderer: renderEmail
		},{
			id: 'tags',
			header: lang("tags"),
			dataIndex: 'tags',
			width: 120,
			hidden: true,
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
            iconCls: 'db-ico-contact',
            handler: function() {
				var url = og.getUrl('contact', 'add');
				og.openLink(url, null);
			}
		}),
		delContact: new Ext.Action({
			text: lang('delete'),
            tooltip: lang('delete selected contacts'),
            iconCls: 'db-ico-delete',
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
            iconCls: 'db-ico-new',
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
            iconCls: 'db-ico-refresh',
			handler: function() {
				this.store.reload();
			},
			scope: this
		}),
		tag: new Ext.Action({
			text: lang('tag'),
	        tooltip: lang('tag selected contacts'),
	        iconCls: 'db-ico-tag',
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
        ]
    });

	og.eventManager.addListener("tag changed", function(tag) {
    	this.load();
	}, this);
	og.eventManager.addListener("workspace changed", function(ws) {
		this.load();
		cm.setHidden(cm.getIndexById('role'), this.store.lastOptions.params.active_project == 0);
		cm.setHidden(cm.getIndexById('tags'), this.store.lastOptions.params.active_project == 0);
	}, this);
	
	this.load();
	cm.setHidden(cm.getIndexById('role'), this.store.lastOptions.params.active_project == 0);
	cm.setHidden(cm.getIndexById('tags'), this.store.lastOptions.params.active_project == 0);
};

Ext.extend(og.ContactManager, Ext.grid.GridPanel, {
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

og.ContactManager.getInstance = function() {
	if (!og.ContactManager.instance) {
		og.ContactManager.instance = new og.ContactManager();
	}
	return og.ContactManager.instance;
}